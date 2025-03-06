<?php

namespace App\Http\Controllers;

use App\Classes\Navigation;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogCategoryController extends Controller
{
	private $can_view;
	private $can_create;
	private $can_edit;
	private $can_delete;

	public function __construct()
	{
		$this->can_view     = FALSE;
		$this->can_create   = FALSE;
		$this->can_edit     = FALSE;
		$this->can_delete   = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view     = $user->can('ver blog');
			$this->can_create   = $user->can('crear blog');
			$this->can_edit     = $user->can('editar blog');
			$this->can_delete   = $user->can('eliminar blog');
		}
	}

    public function view()
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    if( !$this->can_view )
	    { abort(403); }

        return view('dashboard.blogCategories.index', [
            'subtitle' => 'Registros activos'
        ]);
    }

    public function archived()
    {
	    if( !$this->can_delete )
	    { abort(403); }

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
            $restore    = $this->can_delete;
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
                $actions    = parent::set_actions('blogCategories', 'title', FALSE, $restore, $this->can_edit, $this->can_delete);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    if( !$this->can_create )
	    { abort(403); }

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
	    if( !$this->can_create )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

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
	    if( !$this->can_edit )
	    { abort(403); }

        $blogCategory->update($request->validated());
        return redirect() -> route('blogCategories.index', ['updated' => $blogCategory->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $blogCategory->delete();
        return redirect()->route('blogCategories.archived', ['deleted' => $blogCategory->id]);
    }

    public function restore($blog_category_id)
    {
	    if( !$this->can_delete )
	    { abort(403); }

        $blogCategory = BlogCategory::onlyTrashed()->find($blog_category_id);
        $blogCategory->restore();
        return redirect()->route('blogCategories.index', ['restored' => $blogCategory->id]);
    }
}
