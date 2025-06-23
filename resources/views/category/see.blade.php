@extends('layouts.blog')  
    <h1>Lista de Blogs</h1>
    <div id="blog-list"></div>
    <body>
        <div class="sidebar-left"></div>
        <div class="sidebar-right"></div>
        <ul>
            <li><a class="active" href="http://localhost:8000/blog">Blogs</a></li>
          </ul>
        <div class="sidebar-top">
            <p class="center"></p>
        </div>
        <div class="sidebar-bottom"></div>
        <div class="contenido">
            <p class="fs-1">Categoria: {{$category->name}}</p>  
            @if ($blogs->count())
            @foreach ($blogs as $blog)
            <hr>
              <a href="/blog/{{$blog->slug}}">
                <p class="fs-3">{{$blog->title}}</p>
                <img src="{{$blog->image}}"  alt="imagen no encontrada">
                <br>
                <p class="mt-2 descripcion">{{$blog->description}}</p>
              </a>

              <table>
                @foreach ($blog['tags']->chunk(4) as $chunk)
                  <tr>
                    @foreach ($chunk as $tag)
                      <td>
                        <a href="http://localhost:8000/tag/{{ $tag->slug }}">
                          {{ $tag->name }}
                        </a>
                      </td>
                    @endforeach
                  </tr>
                @endforeach
              </table>
            @endforeach
            <hr>
            <div class="pagination">
                  {{ $blogs->links('pagination::bootstrap-5') }}
            </div>
            
        </div>
            @else
                <p>Lo sentimos, no hay ninguna entrada con un la categoria "{{$category->name}}" de momento.</p>
            @endif

        <div class="tags">

          <p class="fs-1 p-2">Nuevos</p>
            @foreach ($randomBlogs as $blog)
              <table>
                <tr>
                  <th>
                    <a href="http://localhost:8000/blog/{{$blog->slug}}">{{$blog->title}}
                      <img src="http://localhost:8000/storage/{{$blog->image}}"  alt="imagen no encontrada">
                    </a>
                  </th>
                </tr>
              </table>
            @endforeach
            
            <p class="fs-1 p-2">Etiquetas</p>

            @foreach ($tags as $tag)
            <table>
              <tr>
                <th>
                  <a href="http://localhost:8000/tag/{{$tag->slug}}">{{$tag->name}} {{$tag->blogs_count }}</a>
                </th>
              </tr>
            </table>
            @endforeach

            <p class="fs-1 p-2">Categorias</p>

            @foreach ($categories as $category)
            <table>
              <tr>
                <th>
                  <a href="http://localhost:8000/category/{{$category->slug}}">{{$category->name}} {{$category->blog_count }}</a>
                </th>
              </tr>
            </table>
            @endforeach
        </div>
      </body>
</body>
</html>
