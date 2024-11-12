<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\FormContact;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductGallery;
use App\Models\ProductSubcategory;
use App\Models\Project;
use App\Models\ProjectGallery;
use App\Models\State;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DbMigrateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-migrate-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from older database to new structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bar    = $this->output->createProgressBar(10);
        $bar->start();
        $this->info("\n");

        $states = $this->get_states_as_assoc();
        $cities = $this->get_cities_as_assoc();
        $brands = $this->get_brands_as_assoc();

        // ? Migrate Banners
        $this->migrate_banners();
        $bar->advance();

        // ? Migrate Blog Categories
        $this->migrate_blog_categories();
        $bar->advance();

        // ? Migrate Blog Articles
        $this->migrate_blog_articles();
        $bar->advance();

        // ? Migrate Contacts
        $this->migrate_contacts($states, $cities);
        $bar->advance();

        // ? Migrate Projects
        $this->migrate_projects();
        $bar->advance();

        // ? Migrate Project Images
        $this->migrate_project_images();
        $bar->advance();

        // ? Migrate Product Categories
        $this->migrate_product_categories();
        $bar->advance();

        // ? Migrate Product Subcategories
        $this->migrate_product_subcategories();
        $bar->advance();

        // ? Migrate Products
        $this->migrate_products();
        $bar->advance();

        // ? Migrate Product Images
        $this->migrate_product_images();
        $bar->advance();

        $bar->finish();
    }

    /* ----------------------------------------------------------------------
     *  HELPERS ZONE
    ---------------------------------------------------------------------- */
    /**
     * @return array
     */
    private function get_states_as_assoc()
    {
        $states     = State::all();
        $assoc      = [];
        foreach($states AS $state)
        {
            $assoc[Str::slug($state->alias)] = $state->id;
        }
        return $assoc;
    }

    /**
     * @return array
     */
    private function get_cities_as_assoc()
    {
        $cities     = City::orderBy('state_id', 'ASC')->orderBy('name', 'ASC')->get();
        $assoc      = [];
        foreach($cities AS $city)
        {
            $assoc[$city->state_id][Str::slug($city->name)] = $city->id;
        }
        return $assoc;
    }

    /**
     * @return array
     */
    private function get_brands_as_assoc()
    {
        $brands     = ProductBrand::all();
        $assoc      = [];
        foreach($brands AS $brand)
        {
            $assoc[$brand->slug] = $brand->id;
        }
        return $assoc;
    }

    private function get_older_newer_blog_categories()
    {
        $older  = DB::connection('DB_Prod')->table('blog_categories')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('blog_categories')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($newer AS $new)
        {
            $assoc[$new->slug] = $new->id;
        }
        foreach($older AS $old)
        {
            $return[$old->id] = $assoc[$old->slug];
        }
        return $return;
    }

    private function get_older_newer_porfolio()
    {
        $older  = DB::connection('DB_Prod')->table('portfolio')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('projects')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($newer AS $new)
        {
            $assoc[$new->slug] = $new->id;
        }
        foreach($older AS $old)
        {
            $return[$old->id] = $assoc[$old->slug];
        }
        return $return;
    }

    private function get_newer_older_porfolio()
    {
        $older  = DB::connection('DB_Prod')->table('portfolio')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('projects')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($older AS $old)
        {
            $assoc[$old->slug] = $old->id;
        }
        foreach($newer AS $new)
        {
            $return[$new->id] = $assoc[$new->slug];
        }
        return $return;
    }

    private function get_newer_older_products()
    {
        $older  = DB::connection('DB_Prod')->table('products')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('products')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($older AS $old)
        {
            $assoc[$old->slug] = $old->id;
        }
        foreach($newer AS $new)
        {
            $return[$new->id] = $assoc[$new->slug];
        }
        return $return;
    }

    private function get_older_newer_product_categories()
    {
        $older  = DB::connection('DB_Prod')->table('products_categories')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('product_categories')->whereNull('deleted_at')
            ->select(['id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($newer AS $new)
        {
            $assoc[$new->slug] = $new->id;
        }
        foreach($older AS $old)
        {
            $return[$old->id] = $assoc[$old->slug];
        }
        return $return;
    }

    private function get_older_newer_product_subcategories()
    {
        $older  = DB::connection('DB_Prod')->table('products_subcategories')
            ->join('products_categories', 'products_categories.id', '=', 'products_subcategories.category_id')
            ->whereNull('products_categories.deleted_at')
            ->whereNull('products_subcategories.deleted_at')
            ->select(['products_subcategories.id', 'products_subcategories.slug'])
            ->get();
        $newer  = DB::connection('mysql')->table('product_subcategories')->whereNull('deleted_at')
            ->select(['id', 'product_category_id', 'slug'])
            ->get();

        $return     = [];
        $assoc      = [];
        foreach($newer AS $new)
        {
            $assoc[$new->slug] = [
                    'new_id'            => $new->id
                ,   'new_category_id'   => $new->product_category_id
            ];
        }
        foreach($older AS $old)
        {
            $return[$old->id] = $assoc[$old->slug];
        }
        return $return;
    }

    private function new_features_style($string)
    {
        $string = str_replace(';', '|', $string);
        $string = str_replace(['<br>', '<br/>', '<br />'], '', $string);
        $string = str_replace('  ', ' ', $string);
        $string = str_replace('  ', ' ', $string);
        $string = str_replace(['| ', ' |', ' | '], '|', $string);
        return $string;
    }

    /* ----------------------------------------------------------------------
     *  MIGRATION ZONE
    ---------------------------------------------------------------------- */
    /**
     * @return void
     */
    private function migrate_banners()
    {
        return;
        $this->info(" Step: Migration of banners");

        $records   = DB::connection('DB_Prod')->table('banner')->whereNull('deleted_at')
            ->select(['title', 'link', 'image', 'image_rx', 'image_mv', 'created_at'])

            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $insert[] = [
                    'promotion_id'      => NULL
                ,   'title'             => $record->title
                ,   'link'              => $record->link
                ,   'image'             => $record->image
                ,   'image_rx'          => $record->image_rx
                ,   'image_mv'          => $record->image_mv
                ,   'order'             => 0
                ,   'created_at'        => $record->created_at
                ,   'updated_at'        => now()
            ];
        }
        $this->generate_array_file($insert, 'banners');
        Banner::insertOrIgnore($insert);
    }

    /**
     * @return void
     */
    private function migrate_blog_categories()
    {
        return;
        $this->info(" Step: Migration of blog_categories");

        $records   = DB::connection('DB_Prod')->table('blog_categories')->whereNull('deleted_at')
            ->select(['title', 'slug', 'created_at'])
            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $insert[] = [
                    'title'             => $record->title
                ,   'slug'              => $record->slug
                ,   'image'             => NULL
                ,   'image_rx'          => NULL
                ,   'created_at'        => $record->created_at
                ,   'updated_at'        => now()
            ];
        }
        $this->generate_array_file($insert, 'blog_categories');
        BlogCategory::insertOrIgnore($insert);
    }

    private function migrate_blog_articles()
    {
        return;
        $this->info(" Step: Migration of blog_articles");

        $old_new_cat    = $this->get_older_newer_blog_categories();
        $records        = DB::connection('DB_Prod')->table('blog_articles')->whereNull('deleted_at')
            ->select(['category_id', 'title', 'slug', 'publish', 'image', 'image_rx', 'shortdesc', 'content', 'created_at'])
            ->get();
        $not_inserted   = [];
        $insert         = [];

        foreach($records AS $record)
        {
            if( !isset($old_new_cat[$record->category_id]) )
            {
                $not_inserted[] = ['blog_articles_id'  => $record->id];
            }
            else
            {
                $insert[] = [
                        'blog_category_id'  => $old_new_cat[$record->category_id]
                    ,   'title'             => $record->title
                    ,   'slug'              => $record->slug
                    ,   'summary'           => $record->shortdesc
                    ,   'content'           => $record->content
                    ,   'image'             => $record->image
                    ,   'image_rx'          => $record->image_rx
                    ,   'raw_editor'        => NULL
                    ,   'published_at'      => $record->publish
                    ,   'created_at'        => $record->created_at
                    ,   'updated_at'        => now()
                ];
            }
        }
        $this->generate_array_file($insert, 'blog_articles');
        if( $not_inserted )
        {
            $this->generate_array_file($insert, 'blog_articles_not_inserted');
        }
        BlogArticle::insertOrIgnore($insert);
    }

    /**
     * @param $states
     * @param $cities
     * @return void
     */
    private function migrate_contacts($states, $cities)
    {
        return;
        $this->info(" Step: Migration of contacts");

        $records   = DB::connection('DB_Prod')->table('clientes')->whereNull('deleted_at')
            ->select(['nombre', 'email', 'phone', 'company', 'city', 'state', 'created_at'])
            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $state_alias    = Str::slug($record->state);
            $state_id       = $states[$state_alias] ?? 1;
            $city_fk        = array_key_first($cities[$state_id]);
            $city_id        = $cities[$state_id][Str::slug($record->city)] ?? $cities[$state_id][$city_fk];

            $insert[] = [
                    'uuid'          => Str::uuid()
                ,   'state_id'      => $state_id
                ,   'city_id'       => $city_id
                ,   'name'          => $record->nombre ?? NULL
                ,   'email'         => $record->email ?? NULL
                ,   'phone'         => !is_null($record->phone) && $record->phone != '[not required]' ? trim(str_replace(['-', '+52'], '', $record->phone)) : NULL
                ,   'company'       => !is_null($record->company) && $record->company != '[not required]' ? $record->company : NULL
                ,   'created_at'    => $record->created_at
                ,   'updated_at'    => now()
            ];
        }
        $this->generate_array_file($insert, 'contacts');
        FormContact::insertOrIgnore($insert);
    }

    /**
     * @return null
     */
    private function migrate_projects()
    {
        return;
        $this->info(" Step: Migration of projects");

        $records   = DB::connection('DB_Prod')->table('portfolio')->whereNull('deleted_at')
            ->select(['title', 'slug', 'image', 'image_rx', 'content', 'created_at'])
            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $insert[] = [
                    'title'             => $record->title
                ,   'slug'              => $record->slug
                ,   'image'             => $record->image
                ,   'image_rx'          => $record->image_rx
                ,   'description'       => strip_tags($record->content)
                ,   'created_at'        => $record->created_at
                ,   'updated_at'        => now()
            ];
        }

        $this->generate_array_file($insert, 'projects');
        Project::insertOrIgnore($insert);
    }

    /**
     * @return void
     */
    private function migrate_project_images()
    {
        return;
        $this->info(" Step: Migration of projects images");

        $new_old_porfolio   = $this->get_newer_older_porfolio();
        $projects           = Project::all();
        $insert             = [];

        foreach($projects AS $project)
        {
            $records   = DB::connection('DB_Prod')->table('portfolio_images')->whereNull('deleted_at')
                ->where('portfolio_id', $new_old_porfolio[$project->id])
                ->select(['portfolio_id', 'title', 'slug', 'image', 'created_at'])
                ->get();


            foreach($records AS $record)
            {
                $insert[] = [
                        'project_id'        => $project->id
                    ,   'title'             => $record->title
                    ,   'image'             => $record->image
                    ,   'created_at'        => $record->created_at
                    ,   'updated_at'        => now()
                ];
            }
        }

        $this->generate_array_file($insert, 'project_galleries');
        ProjectGallery::insertOrIgnore($insert);
    }

    /**
     * @return void
     */
    private function migrate_product_categories()
    {
        return;
        $this->info(" Step: Migration of product categories");

        $records   = DB::connection('DB_Prod')->table('products_categories')->whereNull('deleted_at')
            ->select(['title', 'slug', 'image', 'image_rx', 'created_at'])
            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $insert[] = [
                    'title'             => ucfirst(mb_strtolower($record->title))
                ,   'slug'              => $record->slug
                ,   'image'             => $record->image
                ,   'image_rx'          => $record->image_rx
                ,   'created_at'        => $record->created_at
                ,   'updated_at'        => now()
            ];
        }

        $this->generate_array_file($insert, 'product_categories');
        ProductCategory::insertOrIgnore($insert);
    }

    /**
     * @return void
     */
    private function migrate_product_subcategories()
    {
        return;
        $this->info(" Step: Migration of product subcategories");
        $new_old_categories = $this -> get_older_newer_product_categories();

        $records   = DB::connection('DB_Prod')->table('products_subcategories')
            ->join('products_categories', 'products_subcategories.category_id', '=', 'products_categories.id')
            ->whereNull('products_categories.deleted_at')
            ->whereNull('products_subcategories.deleted_at')
            ->select(['products_subcategories.category_id', 'products_subcategories.title', 'products_subcategories.slug', 'products_subcategories.created_at'])
            ->orderBy('products_subcategories.category_id')
            ->orderBy('products_subcategories.title')
            ->get();
        $insert     = [];

        foreach($records AS $record)
        {
            $insert[] = [
                    'product_category_id'   => $new_old_categories[$record->category_id]
                ,   'title'                 => ucfirst(mb_strtolower($record->title))
                ,   'slug'                  => $record->slug
                ,   'created_at'            => $record->created_at
                ,   'updated_at'            => now()
            ];
        }

        $this->generate_array_file($insert, 'product_subcategories');
        ProductSubcategory::insertOrIgnore($insert);
    }

    /**
     * @return void
     */
    private function migrate_products()
    {
        //return;
        $this->info(" Step: Migration of products");

        $new_old_subcategories  = $this->get_older_newer_product_subcategories();
        $new_brands             = $this->get_brands_as_assoc();

        $records    = DB::connection('DB_Prod')->table('products')
            ->join('products_subcategories', 'products_subcategories.id', '=', 'products.subcategory_id')
            ->whereNull('products_subcategories.deleted_at')
            ->whereNull('products.deleted_at')
            ->orderBy('products.category_id')
            ->orderBy('products.subcategory_id')
            ->select(['products.category_id', 'products.subcategory_id', 'products.title', 'products.slug', 'products.modelo', 'products.marca', 'products.resumen', 'products.caracteristicas', 'products.tecnica',
                'products.precio', 'products.image', 'products.image_rx', 'products.ficha', 'products.con_flete', 'products.created_at'])
            ->get();
        $not_inserted   = [];
        $insert         = [];

        foreach($records AS $record)
        {
            if( !$subcat = $new_old_subcategories[$record->subcategory_id] )
            {
                $not_inserted['by_subcategory'][]   = $record->id;
            }
            if( !$brand = $new_brands[Str::slug($record->marca == 'OFFMAN' ? 'HOFFMAN' : $record->marca)] )
            {
                $not_inserted['by_brand'][]         = $record->id;
            }

            $insert[]   = [
                    'product_category_id'       => $subcat['new_category_id']
                ,   'product_subcategory_id'    => $subcat['new_id']
                ,   'product_brand_id'          => $brand
                ,   'title'                     => mb_strtoupper($record->title)
                ,   'slug'                      => $record->slug
                ,   'model'                     => mb_strtoupper($record->modelo)
                ,   'summary'                   => $record->resumen
                ,   'features'                  => $this->new_features_style($record->caracteristicas)
                ,   'description'               => $record->tecnica
                ,   'price'                     => $record->precio
                ,   'is_featured'               => FALSE
                ,   'with_freight'              => $record->con_flete
                ,   'image'                     => $record->image
                ,   'image_rx'                  => $record->image_rx
                ,   'data_sheet'                => $record->ficha
                ,   'raw_editor'                => NULL
                ,   'created_at'                => $record->created_at
                ,   'updated_at'                => now()
            ];
        }

        $this->generate_array_file($insert, 'products');
        if( $not_inserted )
        {
            $this->generate_array_file($not_inserted, 'products_not_inserted');
        }

        $chunked = array_chunk($insert, 500);
        foreach($chunked AS $chunk)
        {
            Product::insertOrIgnore($chunk);
        }
    }

    private function migrate_product_images()
    {
        $this->info(" Step: Migration of product images");

        $new_old_product    = $this->get_newer_older_products();
        $products           = Product::all();
        $insert             = [];

        foreach($products AS $product)
        {
            $records   = DB::connection('DB_Prod')->table('product_images')
                ->where('producto_id', $new_old_product[$product->id])
                ->select(['producto_id', 'image', 'image_rx', 'created_at'])
                ->get();

            foreach($records AS $record)
            {
                $insert[] = [
                        'product_id'        => $product->id
                    ,   'title'             => $product->title
                    ,   'image'             => $record->image
                    ,   'image_rx'          => $record->image_rx
                    ,   'created_at'        => $record->created_at
                    ,   'updated_at'        => now()
                ];
            }
        }

        $this->generate_array_file($insert, 'product_galleries');
        $chunked = array_chunk($insert, 500);
        foreach($chunked AS $chunk)
        {
            ProductGallery::insertOrIgnore($chunk);
        }
    }

    private function generate_array_file($contents, $name='logger')
    {
        Storage::put('db_migration/'.$name.'.json', json_encode($contents));
    }
}
