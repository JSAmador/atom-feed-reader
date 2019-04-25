<?php

namespace App\Http\Controllers;



use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Requests\FeedRequest;
use App\Feed;
use App\Entry;
use Feed as FeedReader;


class FeedsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $feed
     */

    public function index() {
        // get from db
        $feeds = Feed::all();
        $entries = Entry::all();
        //$feeds = DB::table('feeds')->select()->get();
        //$entries = DB::table('entries')->select()->get();
        return view('FeedReader', ['feeds' => $feeds, 'entries' => $entries]);
    }

    public function storeRate(Request $request) {
        $this->validate($request,
            [
                'rate' => 'required',
                'name' => 'required',
                'email' => 'required'
            ]
        );

        $rate = $request->input('rate');
        $name = $request->input('name');
        $email = $request->input('email');
        $entry_id = $request->input('entry_id');

        $user_id = DB::table('users')->insertGetId(
            [
                'username' => $name,
                'email' => $email
            ]
        );

        DB::table('rates')->insert(
          [
              'rate' => $rate,
              'user_id' => $user_id,
              'entry_id' => $entry_id
          ]
        );


        $url = '/feedReader/'.$entry_id;
        return redirect($url);

    }

    public function store(Request $request) {

        $this->validate($request,
            [
                'feed-link' => 'required',
                'email' => 'required',
                'name' => 'required'
            ]
        );

        $feed = $request->input('feed-link');
        $user_email = $request->input('email');
        $user_name = $request->input('name');


        $atom = FeedReader::loadAtom($feed);
        $ok = 0;
        $error = "";

        // save to db

        // Feed elements
        $feed_entryid = $atom->id;
        $feed_title = $atom->title;
        $feed_updated = date('Y-m-d H:i:s', strtotime($atom->updated));
        $feed_icon = $atom->icon;
        $feed_logo = $atom->logo;
        $feed_rights = $atom->rights;
        $feed_subtitle = $atom->subtitle;
        $feed_generator = $atom->generator;
        $feed = DB::table('feeds')
            ->where('entryid', '=', $feed_entryid)
            ->first();

        if (is_null($feed)) {
            // It does not exist - add to favorites button will show

            $generator_id = DB::table('generators')->insertGetId(
                [
                    'uri' => $feed_generator->uri,
                    'version' => $feed_generator->version,
                    'content' => $feed_generator

                ]
            );
            $user_id = DB::table('users')->insertGetId(
                [
                    'username' => $user_name,
                    'email' => $user_email
                ]
            );

            $feed_id = DB::table('feeds')->insertGetId(
                [
                    'entryid' => $feed_entryid,
                    'title' => $feed_title,
                    'updated' => $feed_updated,
                    'icon' => $feed_icon,
                    'logo' => $feed_logo,
                    'rights' => $feed_rights,
                    'subtitle' => $feed_subtitle,
                    'generator_id' => $generator_id,
                    'added_by' => $user_id
                ]
            );



            $this->addPeople($atom->author, $feed_id, 'feed', 'author');
            $this->addPeople($atom->contributor, $feed_id, 'feed', 'contributor');
            $this->addCategories($atom->category, $feed_id, 'feed');
            $this->addLinks($atom->link, $feed_id, 'feed');

            foreach ($atom->entry as $entry):
                $entryid = $entry->id;
                $title = $entry->title;
                $updated = date('Y-m-d H:i:s', strtotime($entry->updated));

                $summary = $entry->summary;
                $content = $entry->content;
                $published = date('Y-m-d H:i:s');
                $rights = $entry->rights;
                $entry_source = $entry->source;
                $source_id = DB::table('sources')->insertGetId(
                    [
                        'entryid' => $entry_source->id,
                        'title' => $entry_source->title,
                        'updated' => $updated

                    ]
                );


                $entry_id = DB::table('entries')->insertGetId(
                    [
                        'entryid' => $entryid,
                        'title' => $title,
                        'updated' => $updated,
                        'summary' => $summary,
                        'content' => $content,
                        'published' => $published,
                        'rights' => $rights,
                        'feed_id' => $feed_id,
                        'source_id' => $source_id
                    ]
                );


                $this->addPeople($entry->author, $entry_id, 'entry', 'author');
                $this->addPeople($entry->contributor, $entry_id, 'entry', 'contributor');
                $this->addCategories($entry->category, $entry_id, 'entry');
                $this->addLinks($entry->link, $entry_id, 'entry');

            endforeach;



            $ok = 1;
            $msg = "Feed Added Successfully";
        } else {
            $msg = "Feed Already Exist";
        }
        return view('AddFeed', ['msg' => $msg, 'ok' => $ok]);

    }


    public function addPeople($list, $id, $type, $type2) {
        foreach ($list as $item):
            $item_name = $item->name;
            $item_email = $item->email;
            $item_uri = $item->uri;

            $item_id = DB::table('people')->insertGetId(
                ['name' => $item_name, 'email' => $item_email, 'uri' => $item_uri]
            );

            if ($type == 'entry') {
                $table = 'entries_'.$type2.'s';
            } else {
                $table = $type.'s_'.$type2.'s';
            }

            $table_id = $type.'_id';


            DB::table($table)->insert(
                [$table_id => $id, 'person_id' => $item_id]
            );
        endforeach;
    }

    public function addCategories($list, $id, $type) {
        foreach ($list as $category):
            $category = $category->attributes();
            $term = $category->term;
            $scheme = $category->scheme;
            $label = $category->label;


            $category_id = DB::table('categories')->insertGetId(
                [
                    'term' => $term,
                    'scheme' =>$scheme,
                    'label' => $label,

                ]
            );
            if ($type == 'entry') {
                $table = 'entries_categories';
            } else {
                $table = 'feeds_categories';
            }

            $table_id = $type.'_id';

            DB::table($table)->insert(
                [
                    $table_id => $id,
                    'category_id' => $category_id
                ]
            );

        endforeach;
    }

    public function addLinks($list, $id, $table_type) {
        foreach ($list as $link):
            $link = $link->attributes();

            $href = $link->href;
            $rel = $link->rel;
            $type = $link->type;
            $hreflang = $link->hreflang;
            $title = $link->title;
            $length = $link->length;

            $link_id = DB::table('links')->insertGetId(
                [
                    'href' => $href,
                    'rel' =>$rel,
                    'type' => $type,
                    'hreflang' => $hreflang,
                    'title' => $title,
                    'length' => $length
                ]
            );

            if ($table_type == 'entry') {
                $table = 'entries_links';
            } else {
                $table = 'feeds_links';
            }

            $table_id = $table_type.'_id';

            DB::table($table)->insert(
                [
                    $table_id => $id,
                    'link_id' => $link_id
                ]
            );

        endforeach;

    }



    public function showEntry($id) {

        $entry = DB::table('entries')->where('id', $id)->first();
        $entry_authors = DB::table('people')
            ->join('entries_authors', 'people.id', 'entries_authors.person_id')
            ->where('entries_authors.entry_id', $entry->id)->get();
        $entry_contributors = DB::table('people')
            ->join('entries_contributors', 'people.id', 'entries_contributors.person_id')
            ->where('entries_contributors.entry_id', $entry->id)->get();
        $entry_links = DB::table('links')
            ->join('entries_links', 'links.id', 'entries_links.link_id')
            ->where('entries_links.entry_id', $entry->id)->get();
        $entry_categories = DB::table('categories')
            ->join('entries_categories', 'categories.id', 'entries_categories.category_id')
            ->where('entries_categories.entry_id', $entry->id)->get();
        $entry_source = DB::table('sources')->where('id', $entry->source_id)->first();
        $entry_rating = DB::table('rates')->where('entry_id', $entry->id)->avg('rate');
        $feed = DB::table('feeds')->where('id', $entry->feed_id)->first();
        $feed_authors = DB::table('people')
            ->join('feeds_authors', 'people.id', 'feeds_authors.person_id')
            ->where('feeds_authors.feed_id', $feed->id)->get();
        $feed_contributors = DB::table('people')
            ->join('feeds_contributors', 'people.id', 'feeds_contributors.person_id')
            ->where('feeds_contributors.feed_id', $feed->id)->get();
        $feed_links = DB::table('links')
            ->join('feeds_links', 'links.id', 'feeds_links.link_id')
            ->where('feeds_links.feed_id', $feed->id)->get();
        $feed_categories = DB::table('categories')
            ->join('feeds_categories', 'categories.id', 'feeds_categories.category_id')
            ->where('feeds_categories.feed_id', $feed->id)->get();
        $feed_generator = DB::table('generators')->where('id', $feed->generator_id)->first();
        $feed_added = DB::table('users')->where('id', $feed->added_by)->first();

        

        return view('EntryReader',
            [
                'entry' => $entry,
                'entry_authors' => $entry_authors,
                'entry_contributors' => $entry_contributors,
                'entry_links' => $entry_links,
                'entry_categories' => $entry_categories,
                'entry_source' => $entry_source,
                'entry_rating' => $entry_rating,
                'feed' => $feed,
                'feed_authors' => $feed_authors,
                'feed_contributors' => $feed_contributors,
                'feed_links' => $feed_links,
                'feed_categories' => $feed_categories,
                'feed_generator' => $feed_generator,
                'feed_added' => $feed_added

            ]
        );
    }
}
