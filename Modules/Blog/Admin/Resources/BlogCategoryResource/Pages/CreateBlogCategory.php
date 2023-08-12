<?php

namespace Modules\Blog\Admin\Resources\BlogCategoryResource\Pages;

use Modules\Blog\Admin\Resources\BlogCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogCategory extends CreateRecord
{
    protected static string $resource = BlogCategoryResource::class;
}
