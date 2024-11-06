<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Requests\ImageRequest;
use App\Models\City;
use App\Models\FormContact;
use App\Models\FormSubmit;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Promotion;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $last_price                                 = ProductPrice::orderBy('id', 'desc')->first();
        $stats                                      = new \stdClass();
        $stats -> products                          = Product::all() -> count();
        $stats -> active_promotions                 = Promotion::get_active_promotions()->count();
        $stats -> prices_last_update                = $last_price ? Carbon::parse($last_price -> created_at) -> format('d/m/Y H:i:s') : NULL;
        $stats -> prices_changed_by                 = $last_price -> user -> name ?? NULL;

        $submits                                    = FormSubmit::get_statistics();
        $stats -> quotations                        = new \stdClass();
        $stats -> quotations -> month               = $submits->quotations_month;
        $stats -> quotations -> month_attended      = $submits->quotations_month-$submits->quotations_month_pending;
        $stats -> quotations -> total               = $submits->quotations_total;
        $stats -> quotations -> healt               = $submits->healt_quotations_month;
        $stats -> quotations -> tooltip             = FormSubmit::set_healt_message($submits->healt_quotations_month);

        $stats -> contact_forms                     = new \stdClass();
        $stats -> contact_forms -> month            = $submits->contacts_month;
        $stats -> contact_forms -> month_attended   = $submits->contacts_month-$submits->contacts_month_pending;
        $stats -> contact_forms -> total            = $submits->contacts_total;
        $stats -> contact_forms -> healt            = $submits->healt_contacts_month;
        $stats -> contact_forms -> tooltip          = FormSubmit::set_healt_message($submits->healt_contacts_month);

        $contacts                                   = FormContact::get_statistics();
        $stats -> contacts                          = new \stdClass();
        $stats -> contacts -> month                 = $contacts->month;
        $stats -> contacts -> total                 = $contacts->total;

        return view('dashboard.dashboard', compact('stats'));
    }

    public function states(){
        return view('dashboard.dashboard-items.states');
    }

    public function get_states(Request $request)
    {
        return DataTables::of(State::query())
            ->addColumn('action', function ($record) {
                $related_opts   = ['route' => 'dashboard.state-cities', 'tooltip' => 'Ver ciudades relacionadas'];
                $actions        = parent::set_actions('branches', 'title', TRUE, FALSE, FALSE, FALSE, $related_opts);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->addColumn('ciudades_count', function($state){
                return $state -> cities -> count();
            })
            ->toJson();
    }

    public function state_cities(State $state)
    {
        return view('dashboard.dashboard-items.cities', compact('state'));
    }

    public function get_state_cities(State $state, Request $request)
    {
        return DataTables::of(City::query())
            ->filter(function ($query) use ($state, $request) {
                $query -> where('state_id', $state->id);
                if( !empty($request -> search['value']) )
                {
                    $query -> where('name', 'like', '%'.$request -> search['value'].'%');
                }
            })
            ->addColumn('state_name', $state -> name)
            ->addColumn('action', function ($record) {
                $actions    = parent::set_actions('branches', 'title', FALSE, FALSE, FALSE, FALSE);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    public function cities()
    {
        return view('dashboard.dashboard-items.cities');
    }

    public function get_cities(Request $request)
    {
        return DataTables::of(City::query())
            ->addColumn('state_name', function($record){
                return $record -> state -> name;
            })
            ->addColumn('action', function ($record) {
                $actions    = parent::set_actions('branches', 'title', FALSE, FALSE, FALSE, FALSE);
                return view('dashboard.partials.actions', compact(['actions', 'record'])) -> render();
            })
            ->toJson();
    }

    public function upload_image(ImageRequest $request)
    {}

    public function upload_file(FileRequest $request)
    {}
}
