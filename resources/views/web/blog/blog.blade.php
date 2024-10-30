@section('title',           isset($blog_category) ? 'Artículos del blog en la categoría '.$blog_category->title : 'Blog de noticias')
@section('description',     'Descubra aquí nuevas noticias y tips para llevar una excelente alimentación en su espacio de trabajo.')
@section('image',           asset('images/samples/banner_productos.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner-mv.jpg')
            ,   'slide_alt'     => 'Blog Banner'
            ,   'summary'       => FALSE
            ,   'title'         => '<strong>BLOG</strong>'
            ,   'description'   => 'Artículos de interés general sobre <strong>equipamientos de cocinas industriales</strong>'
            ,   'h1'            => TRUE
        ])
    </div>

    <main class="container">
        <h1>{{ $blog_category->title ?? 'Blog de noticias' }}</h1>
        @include('web.blog.partials.scroll-categories', [
                'tag_title'     => 'Categorías'
            ,   'todas_link'    => route('blog')
            ,   'categories'    => array_map(function($category){
                return [$category['title'], route('blog-categories', $category['slug'])];
            }, $categories->toArray() )
        ])

        <section>
            <div class="row">
                @foreach($articles AS $article)
                    <div class="col-md-4 mb-4">
                        @include('web.blog.partials.blog-view', [
                                'title'             => $article -> title
                            ,   'link'              => route('blog-open', [
                                    $article->blog_category->slug, $article->slug
                                ])
                            ,   'image'             => $article->asset_url.$article->image_rx
                            ,   'day'               => $Navigation::split_date($article->published_at) -> day
                            ,   'month'             => $Navigation::split_date($article->published_at) -> short_month
                            ,   'category_title'    => $article -> blog_category->title
                            ,   'category_link'     => route('blog-categories', $article->blog_category -> slug)
                            ,   'summary'           => $article->summary
                        ])
                    </div>
                @endforeach

                <div class="col-12">
                    <div class="table-responsive">
                        {{ $articles -> render() }}
                    </div>
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection
