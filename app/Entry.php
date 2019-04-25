<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:23 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{

    public $timestamps = false;

    protected $fillable = ['entryid', 'title', 'updated', 'content', 'summary', 'published', 'rights', 'feed_id', 'source_id'];

    public function person() {
        return $this->belongsToMany('App\Person');
    }

    public function links() {
        return $this->belongsToMany('App\Link');
    }

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    public function source() {
        return $this->belongsTo('App\Source');
    }



}