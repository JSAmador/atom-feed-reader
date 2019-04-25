<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 12:32 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Generator extends Model
{
    public $timestamps = false;
    protected $fillable = ['uri', 'version'];

}