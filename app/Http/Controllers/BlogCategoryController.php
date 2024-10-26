<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogCategoryController extends Controller
{
    public function view()
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.blogCategories.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
        return view('dashboard.blogCategories.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request)
    {
        $restore        = FALSE;
        if( $request -> has('with_trashed') && $request -> with_trashed == 'true' )
        {
            $dt_of      = BlogCategory::onlyTrashed();
            $restore    = TRUE;
        }
        else
        {
            $dt_of = BlogCategory::query();
        }

        return DataTables::of($dt_of)
            ->addColumn('count_articles', function($record) {
                return $record->blog_articles->count();
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions    = parent::set_actions('blogCategories', 'title', FALSE, $restore);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.blogCategories.create-edit', [
                'resource'  => 'blogCategories'
            ,   'record'    => new BlogCategory()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCategoryRequest $request)
    {
        $created = BlogCategory::create($request -> validated());
        return redirect() -> route('blogCategories.index', compact('created'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug_blog_category)
    {
        return view('web.blog.blog', array_merge(
                Navigation::get_static_data(['banners', 'reels', 'related', 'articles', 'states'])
                ,   [
                        'record'        => BlogCategory::where('slug', $slug_blog_category) -> first()
                    ,   'articles'      => BlogCategory::get_articles_by_slug($slug_blog_category, 12)
                    ,   'categories'    => BlogCategory::get_categories()
                ]
            )
        );
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        return view('dashboard.blogCategories.create-edit', [
                'resource'  => 'blogCategories'
            ,   'record'    => $blogCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $blogCategory->update($request->validated());
        return redirect() -> route('blogCategories.index', ['updated' => $blogCategory->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return redirect()->route('blogCategories.archived', ['deleted' => $blogCategory->id]);
    }

    public function restore($blog_category_id)
    {
        $blogCategory = BlogCategory::onlyTrashed()->find($blog_category_id);
        $blogCategory->restore();
        return redirect()->route('blogCategories.index', ['restored' => $blogCategory->id]);
    }
}
