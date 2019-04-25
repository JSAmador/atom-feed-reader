<?php
/**
 * Created by PhpStorm.
 * User: Juan Sanchez
 * Date: 2/4/19
 * Time: 5:10 PM
 */


class DatabaseTest extends TestCase
{


    public function testAddUser() {
        factory(App\User::class)->create(
            [
                'username' => 'Juan',
                'email' => 'juan@test.com',
            ]
        );

        $this->seeInDatabase('users', ['username' => 'Juan', 'email' => 'juan@test.com']);
    }


    public function testAddPerson() {
        factory(App\Person::class)->create(
            [
                'name' => 'Pedro',
                'email' => 'pedro@test.com',
                'uri' => 'pedro.com'
            ]
        );
        $this->seeInDatabase('people', ['name' => 'Pedro', 'email' => 'pedro@test.com', 'uri' => 'pedro.com']);
    }

    public function testAddSource() {
        factory(App\Source::class)->create(
            [
                'title' => 'Yo mismo',
                'updated' => '2019/02/01 20:30:25'
            ]
        );
        $this->seeInDatabase('sources', ['title' => 'Yo mismo', 'updated' => '2019/02/01 20:30:25']);


    }

    public function testAddGenerator() {
        factory(App\Generator::class)->create(
            [
                'uri' => 'google.com',
                'version' => '3.0'
            ]
        );
        $this->seeInDatabase('generators', ['uri' => 'google.com', 'version' => '3.0']);


    }

    public function testAddLink() {
        factory(App\Link::class)->create(
            [
                'href' => 'http://test.com',
                'rel' => "self",
                'type' => "text/aplication",
                'hreflang' => "es",
                'title' => "My link",
                'length' => "200"
            ]
        );
        $this->seeInDatabase('links',
            [
                'href' => 'http://test.com',
                'rel' => "self",
                'type' => "text/aplication",
                'hreflang' => "es",
                'title' => "My link",
                'length' => "200"
            ]
        );

    }

    public function testAddFeed() {
        factory(App\Feed::class)->create (
            [
                'entryid' => 'feed.com/atom',
                'title' => 'Nuevo Feed',
                'updated' => '2019/02/01 20:30:25',
                'icon' => 'feed.com/atom.jpg',
                'logo' => 'feed.com/atom.jpg',
                'rights' => '2019 feeds',
                'subtitle' => 'Esto es un nuevo feed lleno de texto',
                'generator_id' => 1,
                'added_by' => 1
            ]
        );

        $this->seeInDatabase('feeds',
            [
                'entryid' => 'feed.com/atom',
                'title' => 'Nuevo Feed',
                'updated' => '2019/02/01 20:30:25',
                'icon' => 'feed.com/atom.jpg',
                'logo' => 'feed.com/atom.jpg',
                'rights' => '2019 feeds',
                'subtitle' => 'Esto es un nuevo feed lleno de texto',
                'generator_id' => 1,
                'added_by' => 1
            ]
        );
    }

    public function testAddEntry() {
        factory(App\Entry::class)->create (
            [
                'entryid' => 'entry.com',
                'title' => 'This is an Entry',
                'updated' => '2019/02/01 20:30:25',
                'rights' => 'my rights',
                'content' => 'here can go a lot of texts',
                'summary' => 'this should be short',
                'published' => '2019/02/01 20:30:25',
                'feed_id' => 1,
                'source_id' => 1
            ]
        );

        $this->seeInDatabase('entries',
            [
                'entryid' => 'entry.com',
                'title' => 'This is an Entry',
                'updated' => '2019/02/01 20:30:25',
                'rights' => 'my rights',
                'content' => 'here can go a lot of texts',
                'summary' => 'this should be short',
                'published' => '2019/02/01 20:30:25',
                'feed_id' => 1,
                'source_id' => 1
            ]
        );
    }



}