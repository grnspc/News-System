<?php

namespace GrnSpc\News\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    const EXCERPT_LENGTH = 150;
    const WPM = 150;

    protected $table = 'articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['slug', 'title', 'content', 'image', 'status', 'category_id', 'featured', 'date'];
    // protected $hidden = [];
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function newFactory()
    {
        return \GrnSpc\News\Database\Factories\ArticleFactory::new();
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function author()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
            ->where('date', '<=', date('Y-m-d'))
            ->orderBy('date', 'DESC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute(): string
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit($this->content, SELF::EXCERPT_LENGTH);
    }

    public function getDateForHumansAttribute(): string
    {
        return $this->created_st->format('F d, Y');
    }

    public function getImageUrlAttribute(): string
    {
        $defImage = [
            'news/news-default.png',
            'news/news-default-1.jpg',
            'news/news-default-2.jpg',
            'news/news-default-3.jpg',
            'news/news-default-4.jpg',
            'news/news-default-5.jpg',        ];

        return asset('storage/images/'.($this->image ?? Arr::random($defImage)));
    }

    public function getEstimatedReadTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->attributes['content']));

        $minutes = (int) floor($wordCount / SELF::WPM);
        $seconds = (int) floor($wordCount % SELF::WPM / (SELF::WPM / 60));

        $str_minutes = ($minutes === 1) ? 'minute' : 'minute';
        $str_seconds = ($seconds === 1) ? 'second' : 'second';

        if ($minutes === 0) {
            return "{$seconds} {$str_seconds}";
        } else {
            return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */


}
