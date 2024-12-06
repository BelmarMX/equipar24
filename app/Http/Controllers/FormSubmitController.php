<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormContactRequest;
use App\Http\Requests\FormQuotationDetailRequest;
use App\Http\Requests\FormSubmitRequest;
use App\Mail\Contact;
use App\Mail\Quotation;
use App\Models\City;
use App\Models\FormContact;
use App\Models\FormQuotationDetail;
use App\Models\FormSubmit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FormSubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($filter = NULL)
    {
        return view('dashboard.contacts.index', [
                'subtitle'  => 'Registros activos'
            ,   'filter'    => $filter
        ]);
    }

    public function archived()
    {
        return view('dashboard.contacts.index', [
                'subtitle'      => 'Registros eliminados'
            ,   'with_trashed'  => TRUE
        ]);
    }

    public function datatable(Request $request, $filter = NULL)
    {
        $restore = FALSE;
        if ($request->has('with_trashed') && $request->with_trashed == 'true')
        {
            $dt_of = FormSubmit::onlyTrashed();
            $restore = TRUE;
        }
        else
        {
            $dt_of = FormSubmit::query();
        }
        $dt_of->with(['form_contact', 'approved_by', 'rejected_by']);

        if (isset($_GET['filter']))
        {
            if($_GET['filter'] == 'pending')
            {
                $dt_of->where('status', 'pending');
            }
            elseif($_GET['filter'] == 'approved')
            {
                $dt_of->where('status', 'approved');
            }
            elseif($_GET['filter'] == 'rejected')
            {
                $dt_of->where('status', 'rejected');
            }
            elseif($_GET['filter'] == 'only_quotation')
            {
                $dt_of->where('type', 'quotation');
            }
            elseif($_GET['filter'] == 'only_contact')
            {
                $dt_of->where('type', 'contact');
            }
        }
        if( !empty($filter) && $filter=='quotations' )
        {
            $dt_of->where('type', 'quotation');
        }
        if( !empty($filter) && $filter=='contacts' )
        {
            $dt_of->where('type', 'contact');
        }

        return DataTables::of($dt_of)
            ->addColumn('status', function ($record) {
                return view('dashboard.contacts.status', compact('record'))->render();
            })
            ->addColumn('estimated_value', function($record){
                return $record->calculate_value_quotation();
            })
            ->addColumn('assigned', function($record){
                if( $record -> approved_at )
                {
                    return json_decode($record->approved_by);
                }
                else
                {
                    return json_decode($record->rejected_by);
                }
            })
            ->addColumn('state', function($record){
                return $record->form_contact->state->name;
            })
            ->addColumn('city', function($record){
                return $record->form_contact->city->name;
            })
            ->addColumn('action', function ($record) use ($restore) {
                $actions = [
                        'delete'        => [
                            'enabled'   => !$restore
                        ,   'route'     => 'contacts.delete'
                    ]
                    ,   'restore'       => [
                            'enabled'   => $restore
                        ,   'route'     => 'contacts.restore'
                    ]
                    ,   'watch'         => ['route' => 'contacts.show']
                ];
                return view('dashboard.contacts.actions', compact('actions','record'))->render();
            })
            ->rawColumns(['status', 'action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FormSubmitRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FormSubmit $contact)
    {
        $totals             = $contact->calculate_value_quotation(FALSE);
        $attended           = new \stdClass();
        $attended->email    = Auth::user()->email;
        $attended->name     = Auth::user()->name;

        if( !is_null($contact->approved_by_user_id) )
        {
            $attended->email    = $contact->approved_by->email;
            $attended->name     = $contact->approved_by->name;
        }
        elseif( !is_null($contact->rejected_by_user_id) )
        {
            $attended->email    = $contact->rejected_by->email;
            $attended->name     = $contact->rejected_by->name;
        }
        return view('dashboard.contacts.show', compact('contact', 'totals', 'attended'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormSubmit $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormSubmit $contact)
    {
        $validated              = $request->validate([
                'notes'     => 'required|string'
            ,   'status'    => 'required|in:approved,rejected'
        ], [
                'notes'     => 'Debes agregar una nota para actualizar el estado de esta solicitud.'
        ]);

        $contact->notes         = $validated['notes'];
        $contact->status        = $validated['status'];
        if( $validated['status'] == 'approved' )
        {
            $contact->approved_by_user_id   = Auth::user()->id;
            $contact->approved_at           = now();
        }
        else
        {
            $contact->rejected_by_user_id   = Auth::user()->id;
            $contact->rejected_at           = now();
        }
        $contact->save();

        if( $contact->type=='quotation' )
        {
            Mail::to($contact->form_contact->email, $contact->form_contact->name)
                ->send(new Quotation($contact->id));
        }
        else
        {
            Mail::to($contact->form_contact->email, $contact->form_contact->name)
                ->send(new Contact($contact->id));
        }

        return redirect()->route('contacts.index', ['updated' => $contact->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormSubmit $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.archived', ['deleted' => $contact->id]);
    }

    public function restore($form_submit_id)
    {
        $contact = FormSubmit::onlyTrashed()->find($form_submit_id);
        $contact->restore();
        return redirect()->route('contacts.index', ['restored' => $contact->id]);
    }

    public function get_cities(Request $request)
    {
        return City::get_cities($request->state_id);
    }

    public function find_contact(Request $request)
    {
        $contact = FormContact::where('email', $request->email)->first();
        if( !$contact )
        { return NULL; }

        return response() -> json($contact);
    }

    public function send_contact(FormContactRequest $request)
    {
        $validated              = $request->validated();
        $verify                 = parent::verify_recaptcha($validated['g-recaptcha-response']);
        if( !$verify->success )
        {
            abort(500, 'Todo indica que eres un robot.');
        }

        if( is_null($validated['uuid']) )
        {
            $validated['uuid']  = Str::uuid();
            $created            = FormContact::create($validated);
            $form_contact_id    = $created->id;
        }
        else
        {
            $contact            = FormContact::where('uuid', $validated['uuid'])->first();
            $form_contact_id    = $contact->id;
            // Lógica para cuando encontremos a un mono
            $contact->state_id  = $validated['state_id'];
            $contact->city_id   = $validated['city_id'];
            $contact->name      = $validated['name'];
            $contact->phone     = $validated['phone'];
            $contact->company   = $validated['company'];
            $contact->save();
        }

        $form_submit = FormSubmit::create([
                'form_contact_id'   => $form_contact_id
            ,   'type'              => 'contact'
            ,   'comment'           => $validated['comments']
        ]);

        // Enviar email
        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->send(new Contact($form_submit->id));

        return redirect() -> route('gracias');
    }

    public function send_quotation(FormQuotationDetailRequest $request)
    {
        $validated              = $request->validated();
        $verify                 = parent::verify_recaptcha($validated['g-recaptcha-response']);
        if( !$verify->success )
        {
            abort(500, 'Todo indica que eres un robot.');
        }

        if( is_null($validated['uuid']) )
        {
            $validated['uuid']  = Str::uuid();
            $created            = FormContact::create($validated);
            $form_contact_id    = $created->id;
        }
        else
        {
            $contact            = FormContact::where('uuid', $validated['uuid'])->first();
            $form_contact_id    = $contact->id;
            // Lógica para cuando encontremos a un mono
            $contact->state_id  = $validated['state_id'];
            $contact->city_id   = $validated['city_id'];
            $contact->name      = $validated['name'];
            $contact->phone     = $validated['phone'];
            $contact->company   = $validated['company'];
            $contact->save();
        }

        $submitted = FormSubmit::create([
                'form_contact_id'   => $form_contact_id
            ,   'type'              => 'quotation'
            ,   'comment'           => $validated['comments']
        ]);

        foreach($validated['id'] AS $k => $product_id)
        {
            $product = Product::find($product_id);
            if( !$product )
            { continue; }
            $has_promo  = $product->get_higer_active_promo();

            FormQuotationDetail::create([
                    'form_submit_id'    => $submitted->id
                ,   'product_id'        => $product->id
                ,   'promotion_id'      => !empty($has_promo) ? $has_promo->promotion_id : NULL
                ,   'uuid'              => Str::uuid()
                ,   'quantity'          => $validated['qty'][$product_id][0]
                ,   'product_name'      => $product->title
                ,   'original_price'    => !empty($has_promo) ? $has_promo->original_price  : $product->price
                ,   'discount'          => !empty($has_promo) ? $has_promo->discount        : 0
                ,   'total'             => !empty($has_promo) ? $has_promo->total           : $product->price
            ]);
        }

        // Enviar email
        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->send(new Quotation($submitted->id));

        return redirect() -> route('gracias');
    }
}
