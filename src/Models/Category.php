<?php

namespace Morbzeno\PruebaDePlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function blog()
    {
        return $this->hasMany(Blogs::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($category) {
            if (! Str::endsWith($category->slug, '-' . $category->id)) {
                $category->slug = Str::slug($category->name) . '-' . $category->id;
                $category->saveQuietly();
            }
        });

        static::created(function ($category) {
            if (! Str::endsWith($category->slug, '-' . $category->id)) {
                $category->slug = Str::slug($category->name) . '-' . $category->id;
                $category->saveQuietly();
            }
        });

    }
}
