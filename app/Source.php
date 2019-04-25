<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:28 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Source extends Model
{

    public $timestamps = false;
    protected $fillable = ['title', 'updated'];

}