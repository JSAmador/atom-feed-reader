<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:37 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public $timestamps = false;

    protected $fillable = ['term', 'scheme', 'label'];

}