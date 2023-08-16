<?php

namespace App\Filament\Resources\Blog\PostResource\Pages;

use App\Enums\PublishStatusEnum;
use App\Filament\Resources\Blog\PostResource;
use App\Models\Blog\Post;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),

            Actions\ActionGroup::make([
                Action::make('draft')
                    ->action(fn(?Post $post) => $post->update(['status' => PublishStatusEnum::Draft]))
                    ->visible(fn(?Post $post) => !$post->status->isDraft()),

                Action::make('reviewing')
                    ->action(fn(?Post $post) => $post->update(['status' => PublishStatusEnum::Reviewing]))
                    ->visible(fn(?Post $post) => !$post->status->isReviewing()),

                Action::make('published')
                    ->action(fn(?Post $post) => $post->update(['status' => PublishStatusEnum::Published]))
                    ->visible(fn(?Post $post) => !$post->status->isPublished()),

                Action::make('rejected')
                    ->action(fn(?Post $post) => $post->update(['status' => PublishStatusEnum::Rejected]))
                    ->visible(fn(?Post $post) => !$post->status->isRejected())
            ])
                ->button()
                ->label('Switching')
                ->color('warning')
                ->icon('heroicon-o-document-check')
        ];
    }
}
