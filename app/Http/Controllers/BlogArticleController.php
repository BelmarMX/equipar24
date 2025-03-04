<?php

namespace App\Http\Controllers;

use App\Classes\ImagesSettings;
use App\Classes\Navigation;
use App\Http\Requests\BlogArticleRequest;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogArticleController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.blogArticles.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.blogArticles.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = BlogArticle::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of      = BlogArticle::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('category', function($record) {
                return $record->blog_category->title ?? '🚫 Eliminada';
            })
            ->addColumn('preview', function($record) {
                return view('dashboard.partials.preview', compact('record')) -> render();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions            = parent::set_actions('blogArticles', 'title', FALSE, $restore);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->rawColumns(['preview', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.blogArticles.create-edit', [
                'resource'      => 'blogArticles'
            ,   'record'        => new BlogArticle()
            ,   'categories'    => BlogCategory::get_categories()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogArticleRequest $request)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::ARTICLE_FOLDER
            ,   TRUE
            ,   ImagesSettings::ARTICLE_RX_WIDTH
            ,   ImagesSettings::ARTICLE_RX_HEIGHT
        );

        $validated['image']     = $stored -> full -> original;
        $validated['image_rx']  = $stored -> full -> thumbnail  ?? NULL;

        $created                = BlogArticle::create($validated);
        return redirect() -> route('blogArticles.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogArticle $blogArticle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogArticle $blogArticle)
    {
        return view('dashboard.blogArticles.create-edit', [
                'resource'      => 'blogArticles'
            ,   'record'        => $blogArticle
            ,   'categories'    => BlogCategory::get_categories()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogArticleRequest $request, BlogArticle $blogArticle)
    {
        $validated              = $request -> validated();
        $stored                 = parent::store_all_images_from_request(
                $request -> file('image')
            ,   NULL
            ,   $validated['title']
            ,   ImagesSettings::ARTICLE_FOLDER
            ,   TRUE
            ,   ImagesSettings::ARTICLE_RX_WIDTH
            ,   ImagesSettings::ARTICLE_RX_HEIGHT
            ,   $blogArticle -> image
            ,   NULL
            ,   $blogArticle -> image_rx
        );

        $validated['image']     = $stored->full->original   ?? $blogArticle->image;
        $validated['image_rx']  = $stored->full->thumbnail  ?? $blogArticle->image_rx;

        $blogArticle -> update($validated);
        return redirect() -> route('blogArticles.index', ['updated' => $blogArticle->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogArticle $blogArticle)
    {
        $blogArticle->delete();
        return redirect() -> route('blogArticles.archived', ['deleted' => $blogArticle->id]);
    }

    public function restore($blog_article_id)
    {
        $blogArticle = BlogArticle::onlyTrashed() -> find($blog_article_id);
        $blogArticle->restore();
        return redirect() -> route('blogArticles.index', ['restored' => $blogArticle->id]);
    }

    public function show_categories()
    {
        return view('web.blog.blog', array_merge(
                    Navigation::get_static_data(['reels', 'related', 'articles'])
                ,   [
                        'categories'    => BlogCategory::get_categories()
                    ,   'articles'      => BlogArticle::where('published_at', '<=', now())->orderBy('published_at', 'DESC')->paginate(12)
                ]
            )
        );
    }

    public function show_category($slug_blog_category)
    {
        $blog_category  = BlogCategory::where('slug', $slug_blog_category)->firstOrFail();
        return view('web.blog.blog', array_merge(
                    Navigation::get_static_data(['reels', 'related'])
                ,   [
                        'blog_category' => $blog_category
                    ,   'categories'    => BlogCategory::get_categories()
                    ,   'articles'      => BlogArticle::where('blog_category_id', $blog_category->id)->where('published_at', '<=', now())->orderBy('published_at', 'DESC')->paginate(12)
                ]
            )
        );
    }

    public function show_article($slug_blog_category, $slug_blog_article)
    {
        $blog_category  = BlogCategory::where('slug', $slug_blog_category)->firstOrFail();
        $article        = BlogArticle::where('slug', $slug_blog_article)->where('blog_category_id', $blog_category->id)->firstOrFail();

        return view('web.blog.blog-article', array_merge(
                    Navigation::get_static_data(['banners', 'reels', 'related', 'articles'])
                ,   [
                        'article'       => $article
                    ,   'categories'    => BlogCategory::get_categories()
                    ,   'latest'        => BlogArticle::get_latest(4)
                ]
            )
        );
    }
}
