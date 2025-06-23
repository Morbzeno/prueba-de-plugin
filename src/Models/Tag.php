<?php

namespace Morbzeno\PruebaDePlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blogs::class, 'blog_tag', 'tag_id', 'blog_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($tag) {
            if (! Str::endsWith($tag->slug, '-' . $tag->id)) {
                $tag->slug = Str::slug($tag->name) . '-' . $tag->id;
                $tag->saveQuietly();
            }
        });

        static::created(function ($tag) {
            if (! Str::endsWith($tag->slug, '-' . $tag->id)) {
                $tag->slug = Str::slug($tag->name) . '-' . $tag->id;
                $tag->saveQuietly();
            }
        });

        static::creating(function ($tag) {
            if (! $tag->slug) {
                $baseSlug = $tag->name;
                $slug = Str::slug($baseSlug);
                $original = $slug;
                $i = 1;

                while (self::where('slug', $slug)->exists()) {
                    $slug = $original . '-' . $i++;
                }

                $tag->slug = $slug;
            }
        });
    }
}
