<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_home(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText("Hello in Home Page");
    }

    public function test_contact()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSeeText("This is Contact Page");
    }
    public function test_store_post_success()
    {
        $post = new BlogPost();
        $post->title = "post title";
        $post->content = "post content";
        $this->actingAs($this->userMoc())
            ->post("/posts", $post->toArray())
            ->assertStatus(302)
            ->assertSessionHas("status", "The Blog Post is Created!")
            ->assertSessionHasNoErrors();
        $this->assertDatabaseHas("blog_posts", $post->toArray());
    }

    public function test_store_post_fail()
    {
        $post = new BlogPost();
        $post->title = "x";
        $post->content = "x";
        $this->actingAs($this->userMoc())
            ->post("/posts", $post->toArray())
            ->assertStatus(302)
            ->assertSessionMissing("status")
            ->assertSessionHasErrors();
        $errors = session("errors")->getMessages();
        $this->assertEquals($errors["title"][0], "The title field must be at least 5 characters.");
        $this->assertEquals($errors["content"][0], "The content field must be at least 5 characters.");
        $this->assertDatabaseMissing("blog_posts", $post->toArray());
    }

    public function test_update_post_success()
    {
        $post = new BlogPost();
        $post->title = "post title from update";
        $post->content = "post content from update";
        $post->save();
        $this->assertDatabaseHas("blog_posts", $post->toArray());
        $params = [
            "title" => "new post update",
            "content" => "new post update",
        ];
        $this->actingAs($this->userMoc())
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas("status", 'The Blog Post is Updated!')
            ->assertSessionHasNoErrors();
        $this->assertDatabaseMissing("blog_posts", $post->toArray());
    }

    function test_delete_post_success()
    {
        $post = new BlogPost();
        $post->title = "this is new title";
        $post->content = "this is new content";
        $post->save();
        $this->assertDatabaseHas("blog_posts", $post->toArray());
        $this->actingAs($this->userMoc())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302);
        $this->assertDatabaseMissing("blog_posts", $post->toArray());
    }
}
