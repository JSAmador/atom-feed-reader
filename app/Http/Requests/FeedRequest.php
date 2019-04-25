<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 2/4/19
 * Time: 10:53 AM
 */

namespace App\Http\Requests;

use Illuminate\Http\Request;

class FeedRequest extends Request {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'feed-link'    => 'required',
            'email'   => 'required|email',
            'name'     => 'required'
        ];
    }
}