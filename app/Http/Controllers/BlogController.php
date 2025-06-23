<?php

namespace App\Http\Controllers\Vendor\PruebaDePlugin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Morbzeno\PruebaDePlugin\Models\Blogs;
use Morbzeno\PruebaDePlugin\Models\Tag;
use Morbzeno\PruebaDePlugin\Models\Category;


class BlogController extends Controller
{
    function index(){
        $blogs = Blogs::with('users')->with('tags')->with('category')->paginate(2);
        
        if($blogs->isEmpty()){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }

        return response()->json([
            'message' => 'datos encontrados',
            'data' => $blogs
        ]);
    }

    function show($slug){
        $blogs = Blogs::where('slug', $slug)->with('users')->with('tags')->with('category')->get();
        

        if($blogs->isEmpty()){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }

        return response()->json([
            'message' => 'datos encontrados',
            'data' => $blogs
        ]);
    }

    public function showblogs()
    {
        $categories = Category::withCount('blog')->inRandomOrder()->paginate(10);
        $tags = Tag::withCount('blogs')->inRandomOrder()->paginate(10);
        $randomBlogs = Blogs::latest()->paginate(3);
        $blogs = Blogs::with('users')->with('tags')->with('category')->paginate(2);
        
        if($blogs->isEmpty()){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }

        return view('blog.see', compact('blogs', 'tags', 'categories', 'randomBlogs'));
    }

    
    public function detailBlog($slug)
    {
        $categories = Category::withCount('blog')->inRandomOrder()->paginate(10);
        $tags = Tag::withCount('blogs')->inRandomOrder()->paginate(10);
        $randomBlogs = Blogs::inRandomOrder()->paginate(3);
        $blog = Blogs::where('slug', $slug)->with('users')->with('tags')->with('category')->first();

        if(!$blog){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }

        return view('blog.detail', compact('blog', 'tags', 'categories', 'randomBlogs'));
    }

    public function showtag($slug)
    {
        $categories = Category::withCount('blog')->inRandomOrder()->paginate(10);
        $tags = Tag::withCount('blogs')->inRandomOrder()->paginate(10);
        $randomBlogs = Blogs::inRandomOrder()->paginate(3);
        $tag = Tag::where('slug', $slug)->first();
        if(!$tag){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }
        $blogs = $tag->blogs()->paginate(2);

        if (!$blogs){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }


        return view('tag.see', compact('tag', 'categories', 'tags', 'blogs', 'randomBlogs'));
    }

    public function showcategory($slug)
    {
        $categories = Category::withCount('blog')->inRandomOrder()->paginate(10);
        $category = Category::where('slug', $slug)->first();
        $randomBlogs = Blogs::inRandomOrder()->paginate(3);
        $tags = Tag::withCount('blogs')->inRandomOrder()->paginate(10);
        if(!$category){
            return response()->json([
                'message' => 'datos no encontrados',
            ]);
        }
        $blogs = $category->blog()->paginate(2);

        return view('category.see', compact('tags', 'categories', 'category', 'randomBlogs', 'blogs'));
    }
}
