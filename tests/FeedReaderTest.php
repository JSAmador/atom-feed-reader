<?php
/**
 * Created by PhpStorm.
 * User: Juan Sanchez
 * Date: 2/4/19
 * Time: 5:10 PM
 */

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Laravel\Lumen\Testing\WithoutMiddleware;
use Illuminate\Http\Response;

class FeedReaderTest extends TestCase
{
    use WithoutMiddleware;

    public function testCanViewFeedReader() {
        $this->get('/feedReader');

        $this->assertEquals(
            200, $this->response->status()
        );

    }

    public function testCanViewAddFeed() {
        $this->get('/addFeed');

        $this->assertEquals(
            200, $this->response->status()
        );
    }

    public function testCanAddNewFeed() {
        $this->post('/addFeed')
            ->seeJsonEquals([
                'feed-link' => ["The feed-link field is required."],
                'email' => ["The email field is required."],
                'name' => ["The name field is required."]
            ]);

    }



}