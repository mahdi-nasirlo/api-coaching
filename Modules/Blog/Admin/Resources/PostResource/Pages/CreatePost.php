<?php

namespace Modules\Blog\Admin\Resources\PostResource\Pages;

use Modules\Blog\Admin\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
