<?php

namespace App\Models\Blog;

use App\Enums\PublishStatusEnum;
use App\Models\Comment;
use App\Models\User;
use App\Observers\PostObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Tags\HasTags;

/**
 * @property string title
 * @property string slug
 * @property string content
 * @property Carbon published_at
 * @property string image
 * @property PublishStatusEnum status
 * @property int user_id
 * @property User author
 * @property Category category
 */
class Post extends Model
{
    use HasFactory;
    use HasTags;

    /**
     * @var string
     */
    protected $table = 'blog_posts';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
        'status' => PublishStatusEnum::class,
    ];

    public static function booted(): void
    {
        self::observe(PostObserver::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blog_category_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
