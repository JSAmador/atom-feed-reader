<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 11:21 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'entryid',
        'title',
        'updated',
        'icon',
        'logo',
        'rights',
        'subtitle',
        'generator_id'
    ];

    public function entries() {
        return $this->belongsToMany('App\Entry');
    }

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    public function links() {
        return $this->belongsToMany('App\Link');
    }

    public function generator() {
        return $this->belongsTo('App\Generator');
    }
}