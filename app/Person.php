<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:24 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'uri'];


}