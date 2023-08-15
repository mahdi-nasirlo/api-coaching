<?php

namespace App\Observers;


use App\Models\Blog\Post;

class PostObserver
{

    public function created(Post $post): void
    {
        $post->user_id = auth()->id();
    }


    public function updated(Post $post): void
    {
        //
    }

    public function deleted(Post $post): void
    {
        //
    }


    public function restored(Post $post): void
    {
        //
    }

    public function forceDeleted(Post $post): void
    {
        //
    }
}
