<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:33 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public $timestamps = false;

    protected $fillable = ['href', 'rel', 'type', 'hreflang', 'title', 'length'];


}