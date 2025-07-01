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

        static::creating(function ($category) {
            if (!$category->slug) {
                $baseSlug = $category->name;
                $slug = Str::slug($baseSlug);
                $original = $slug;
                $i = 1;
    
                while (self::where('slug', $slug)->exists()) {
                    $slug = $original . '-' . $i++;
                }
    
                $category->slug = $slug;
            }
        });

    }
    public static function newFactory()
{
    return \Database\Factories\CategoryFactory::new();
}

}
