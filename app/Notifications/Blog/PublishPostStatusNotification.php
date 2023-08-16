<?php

namespace App\Notifications\Blog;

use App\Enums\PublishStatusEnum;
use App\Models\Blog\Post;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublishPostStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Post $post)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase(User $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title("post " . $this->post->title . " is published by  is waiting for accept")
            ->actions([

                Action::make('mark as review')
                    ->link()
                    ->action(fn() => $this->post->update(['status' => PublishStatusEnum::Reviewing->value])),

                Action::make('view post')
                    ->button()
//                    ->url(PostResource::getUrl('view', ['recorde' => $this->post]))
            ])
            ->getDatabaseMessage($notifiable);
    }
}
