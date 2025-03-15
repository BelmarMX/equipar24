<?php

namespace App\Console\Commands;

use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\Project;
use App\Models\Promotion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera el archivo xml sitemap';

    /**
     * Execute the console command.
     */
    public function handle()
    {
	    $this->info("Recolectandon rutas.");

		// ? Recolección de rutas web (GET) y filtrado por coincidencia de palabras
	    $routes             = collect(Route::getRoutes())->map(function($route) {
			return in_array('GET', $route->methods()) ? $route->uri() : 'forgot-route';
	    });

		$public_routes      = $routes->filter(function($route) {
			return !preg_match('/^(up|login|logout|register|verify|password|forgot|reset|confirm|email|auth|admin|dashboard|api|profile|storage|gracias|resultados)/', $route);
		});

		$sitemap                            = Sitemap::create();

		foreach($public_routes as $uri)
		{
			if( Str::contains($uri, 'portafolio/{slug_project}') )
			{
				$projects                   = Project::all();
				foreach($projects as $project)
				{
					$sitemap->add(Url::create('portafolio/'.$project->slug)
						->setLastModificationDate($project->updated_at ?? $project->created_at));
				}
			}
			elseif( Str::contains($uri, 'productos/{slug_category}') )
			{
				$products_categories        = ProductCategory::all();
				foreach($products_categories as $product_category)
				{
					$sitemap->add(Url::create('productos/'.$product_category->slug)
						->setLastModificationDate($product_category->updated_at ?? $product_category->created_at));
					$product_subcategories  = ProductSubcategory::where('product_category_id', $product_category->id)->get();
					foreach($product_subcategories as $product_subcategory)
					{
						$sitemap->add(Url::create('productos/'.$product_category->slug.'/'.$product_subcategory->slug)
							->setLastModificationDate($product_subcategory->updated_at ?? $product_subcategory->created_at));
						$products           = Product::where('product_category_id', $product_category->id)->where('product_subcategory_id', $product_subcategory->id)->get();
						foreach($products as $product)
						{
							$sitemap->add(Url::create('productos/'.$product_category->slug.'/'.$product_subcategory->slug.'/'.$product->slug)
								->setLastModificationDate($product->updated_at ?? $product->created_at));
						}
					}
				}
			}
			elseif( Str::contains($uri, 'marcas/{slug_brand}') )
			{
				$brands                     = ProductBrand::all();
				foreach($brands as $brand)
				{
					$sitemap->add(Url::create('marcas/'.$brand->slug)
						->setLastModificationDate($brand->updated_at ?? $brand->created_at));
					$categories             = ProductBrand::get_product_categories_of_brand($brand->id);
					foreach($categories as $category)
					{
						$sitemap->add(Url::create('marcas/'.$brand->slug.'/'.$category->slug)
							->setLastModificationDate($category->updated_at ?? $category->created_at));
						$subcategories         = ProductBrand::get_product_subcategories_of_brand($brand->id, $category->id);
						foreach($subcategories as $subcategory)
						{
							$sitemap->add(Url::create('marcas/'.$brand->slug.'/'.$category->slug.'/'.$subcategory->slug)
								->setLastModificationDate($subcategory->updated_at ?? $subcategory->created_at));
						}
					}
				}
			}
			elseif( Str::contains($uri, 'promociones/{slug_promotion}') )
			{
				$promotions                   = Promotion::all();
				foreach($promotions as $promotion)
				{
					$sitemap->add(Url::create('promociones/'.$promotion->slug)
						->setLastModificationDate($promotion->updated_at ?? $promotion->created_at));
				}
			}
			elseif( Str::contains($uri, 'blog/{slug_blog_category}') )
			{
				$blog_categories = BlogCategory::all();
				foreach($blog_categories as $blog_category)
				{
					$sitemap->add(Url::create('blog/'.$blog_category->slug)
						->setLastModificationDate($blog_category->updated_at ?? $blog_category->created_at));
					$blog_articles = BlogArticle::where('blog_category_id', $blog_category->id)->get();
					foreach($blog_articles as $blog_article)
					{
						$sitemap->add(Url::create('blog/'.$blog_category->slug.'/'.$blog_article->slug)
							->setLastModificationDate($blog_article->updated_at ?? $blog_article->created_at));
					}
				}
			}
			else
			{
				$sitemap->add(Url::create($uri));
			}
		}

		$sitemap->writeToFile(public_path('sitemap.xml'));
	    $this->info("Sitemap generado correctamente.");
    }
}
