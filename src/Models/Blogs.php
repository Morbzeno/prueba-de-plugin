<?php

namespace Morbzeno\PruebaDePlugin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blogs extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'author', 
        'slug',
        'category_id',
    ];
    
    public function tags ()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag', 'blog_id', 'tag_id');
    }

    public function users ()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot(){
        parent::boot();


    static::created(function ($blog) {
        // Solo si no tenía slug asignado
        if (!$blog->slug) {
            $blog->slug = Str::slug($blog->title . "-" . $blog->id);
            $blog->image = asset('storage/' . ltrim($blog->image, '/'));
            $blog->saveQuietly();
        }
    });

    static::updated(function ($blog) {
        if (!str_ends_with($blog->slug, '-' . $blog->id)) {
            $blog->slug = Str::slug($blog->slug) . '-' . $blog->id;
            $blog->image = asset('storage/' . ltrim($blog->image, '/'));
            $blog->saveQuietly();
        }
    });

    }

}
