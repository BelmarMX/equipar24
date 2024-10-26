<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Requests\ImageRequest;
use App\Models\City;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $stats                                      = new \stdClass();
        $stats -> products                          = Product::all() -> count();
        $stats -> active_promotions                 = Promotion::get_promotions()->count();
        $stats -> prices_last_update                = Carbon::parse(now()) -> format('d/m/Y H:i:s');
        $stats -> prices_changed_by                 = 'John Doe';

        $stats -> quotations                        = new \stdClass();
        $stats -> quotations -> month               = 1234;
        $stats -> quotations -> month_attended      = 678;
        $stats -> quotations -> total               = 9125821;
        $stats -> quotations -> healt               = 'danger';
        $stats -> quotations -> tooltip             = 'Es urgente prestar atención';

        $stats -> contact_forms                     = new \stdClass();
        $stats -> contact_forms -> month            = 4891;
        $stats -> contact_forms -> month_attended   = 4800;
        $stats -> contact_forms -> total            = 458912;
        $stats -> contact_forms -> healt            = 'warning';
        $stats -> contact_forms -> tooltip          = 'Es necesario prestar atención';

        $stats -> contacts                          = new \stdClass();
        $stats -> contacts -> month                 = 678;
        $stats -> contacts -> total                 = 2987;

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
