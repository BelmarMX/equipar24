<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\BlogArticle;
use App\Models\BlogCategory;
use App\Models\City;
use App\Models\FormContact;
use App\Models\ProductBrand;
use App\Models\State;
use Durlecode\EJSParser\HtmlParser;
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

    /* ----------------------------------------------------------------------
     *  MIGRATION ZONE
    ---------------------------------------------------------------------- */
    /**
     * @return void
     */
    private function migrate_banners()
    {
        return;
        $this->info("Step: Migration of banners");

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
        $this->info("Step: Migration of blog_categories");

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
        $this->info("Step: Migration of blog_categories");

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
        $this->info("Step: Migration of contacts");

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

    private function migrate_projects()
    {}

    private function migrate_project_images()
    {}

    private function migrate_product_categories()
    {}

    private function migrate_product_subcategories()
    {}

    private function migrate_products()
    {}

    private function migrate_product_images()
    {}

    private function generate_array_file($contents, $name='logger')
    {
        Storage::put('db_migration/'.$name.'.json', json_encode($contents));
    }
}
