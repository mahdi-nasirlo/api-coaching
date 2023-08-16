<?php

namespace App\Observers;


use App\Enums\PublishStatusEnum;
use App\Models\Blog\Post;
use App\Notifications\Blog\PublishPostStatusNotification;

class PostObserver
{

    public function created(Post $post): void
    {
        $post->user_id = auth()->id();
//        auth()->user()->notify(new PublishPostStatusNotification());
    }

    public function updating(Post $post): void
    {
        $post->status = PublishStatusEnum::Draft;
    }

    public function updated(Post $post): void
    {
        auth()->user()->notify(new PublishPostStatusNotification($post));
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
