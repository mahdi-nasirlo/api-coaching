<?php

namespace App\Enums;

enum PublishStatusEnum: string
{
    case Draft = 'draft';
    case Reviewing = 'reviewing';
    case Published = 'published';
    case Rejected = 'rejected';

    public function getLabel(): string|array|null
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Reviewing => 'Reviewing',
            self::Published => 'Published',
            self::Rejected => 'Rejected',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Reviewing => 'warning',
            self::Published => 'success',
            self::Rejected => 'danger',
        };
    }

    public function getIcon(): string|array|null
    {
        return match ($this) {
            self::Draft => 'heroicon-s-paper-clip',
            self::Reviewing => 'heroicon-o-clock',
            self::Published => 'heroicon-m-check',
            self::Rejected => 'heroicon-o-hand-thumb-down',
        };
    }

    public function isDraft(): bool
    {
        return $this === self::Draft;
    }

    public function isReviewing(): bool
    {
        return $this === self::Reviewing;
    }

    public function isPublished(): bool
    {
        return $this === self::Published;
    }

    public function isRejected(): bool
    {
        return $this === self::Rejected;
    }
}
