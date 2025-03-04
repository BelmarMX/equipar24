@section('title',           $article->title)
@section('description',     $article->summary)
@section('image',           $article->asset_url.$article->image_rx)
@extends('web._layout.master.app')

@section('content')
    <main class="container mt-5">
        @include('web.blog.partials.scroll-categories', [
                'tag_title'     => 'Categorías'
            ,   'todas_link'    => route('blog')
            ,   'categories'    => array_map(function($category){
                return [$category['title'], route('blog-categories', $category['slug'])];
            }, $categories -> toArray() )
        ])

        <div class="row gx-5">
            <section class="blog__article col-md-8">
                <img width="{{ $ImagesSettings::ARTICLE_WIDTH }}"
                     height="{{ $ImagesSettings::ARTICLE_HEIGHT }}"
                     class="img-fluid"
                     src="{{ $article->asset_url.$article->image }}"
                     alt="{{ $article->title }}"
                >
                <div class="blog__article__tags p-2 mb-4">
                    <div class="d-inline">
                        <i class="bi bi-clock"></i> {{ $Navigation::split_date($article->published_at)->large }}
                    </div>
                    <div class="d-inline ms-1">
                        <i class="bi bi-tag"></i> <a href="{{ route('blog-categories', $article->blog_category->slug) }}">{{ $article->blog_category->title }}</a>
                    </div>
                </div>

                <h1 class="blog__article__title">{{ $article->title }}</h1>

                <div class="blog__article__content">
                    {!! $article -> content !!}
                </div>
            </section>

            <aside class="col-md-4">
                @foreach($latest AS $blog)
                    <div class="mb-5">
                        @include('web.blog.partials.blog-view', [
                                'title'             => $blog -> title
                            ,   'link'              => route('blog-open', [
                                    $blog->blog_category->slug, $blog->slug
                                ])
                            ,   'image'             => $blog->asset_url.$blog->image_rx
                            ,   'day'               => $Navigation::split_date($blog->published_at) -> day
                            ,   'month'             => $Navigation::split_date($blog->published_at) -> short_month
                            ,   'category_title'    => $blog -> blog_category->title
                            ,   'category_link'     => route('blog-categories', $blog->blog_category -> slug)
                            ,   'summary'           => $blog->summary
                        ])
                    </div>
                @endforeach
            </aside>
        </div>
    </main>
@endsection
