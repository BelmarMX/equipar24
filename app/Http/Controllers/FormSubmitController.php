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
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FormSubmitController extends Controller
{
	private $can_view_contact;
	private $can_create_contact;
	private $can_edit_contact;
	private $can_delete_contact;
	private $can_view_quotation;
	private $can_create_quotation;
	private $can_edit_quotation;
	private $can_delete_quotation;

	public function __construct()
	{
		$this->can_view_contact         = FALSE;
		$this->can_create_contact       = FALSE;
		$this->can_edit_contact         = FALSE;
		$this->can_delete_contact       = FALSE;
		$this->can_view_quotation       = FALSE;
		$this->can_create_quotation     = FALSE;
		$this->can_edit_quotation       = FALSE;
		$this->can_delete_quotation     = FALSE;

		if( $user = Auth()->user() )
		{
			$this->can_view_contact         = $user->can('ver contactos');
			$this->can_create_contact       = $user->can('crear contactos');
			$this->can_edit_contact         = $user->can('editar contactos');
			$this->can_delete_contact       = $user->can('eliminar contactos');
			$this->can_view_quotation       = $user->can('ver cotizaciones');
			$this->can_create_quotation     = $user->can('crear cotizaciones');
			$this->can_edit_quotation       = $user->can('editar cotizaciones');
			$this->can_delete_quotation     = $user->can('eliminar cotizaciones');
		}
	}

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
	    if( !$this->can_delete_contact && !$this->can_delete_quotation )
	    { abort(403); }

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
        if( (!empty($filter) && $filter=='quotations') || ($this->can_view_quotation && !$this->can_view_contact) )
        {
            $dt_of->where('type', 'quotation');
        }
        if( (!empty($filter) && $filter=='contacts') || (!$this->can_view_quotation && $this->can_view_contact) )
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
                            'enabled'   => !$restore && (($record->type == 'quotation' && $this->can_delete_quotation) || ($record->type == 'contact' && $this->can_delete_contact))
                        ,   'route'     => 'contacts.delete'
                    ]
                    ,   'restore'       => [
                            'enabled'   => $restore && (($record->type == 'quotation' && $this->can_delete_quotation) || ($record->type == 'contact' && $this->can_delete_contact))
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
	    if( ($contact->type=='quotation' && !$this->can_edit_quotation) || ($contact->type=='contact' && !$this->can_edit_contact) )
	    { abort(403); }

        $validated              = $request->validate([
                'notes'                     => 'required|string'
            ,   'status'                    => 'required|in:approved,rejected'
            ,   "form_contact_name"         => "required|string"
            ,   "form_contact_email"        => "required|string|unique:form_contacts,email,{$contact->form_contact->id}"
            ,   "form_contact_phone"        => "required|digits:10"
            ,   "form_contact_company"      => "nullable|string"
        ], [
                'notes'                     => 'Debes agregar una nota para actualizar el estado de esta solicitud.'
            ,   'status'                    => 'Debes seleccionar un estatus para la solicitud.'
            ,   'form_contact_name'         => 'El nombre del contacto es requerido.'
            ,   'form_contact_email'        => 'El formato de correo electrónico del contacto es incorrecto o ya existe en la base de datos para otro usuario.'
            ,   'form_contact_phone'        => 'El teléfono del contacto debe ser un número de 10 dígitos.'
            ,   'form_contact_company'      => 'La empresa del contacto debe ser una cadena de texto válida.'
        ]);

        // ? Si el contacto ha sido modificado, actualizamos el registro.
        if( $request->form_contact_name != $contact->form_contact->name ||
            $request->form_contact_email != $contact->form_contact->email ||
            $request->form_contact_phone != $contact->form_contact->phone ||
            $request->form_contact_company != $contact->form_contact->company
        ){
            $update_contact = FormContact::find($contact->form_contact->id);
            $update_contact->name       = $request->form_contact_name;
            $update_contact->email      = $request->form_contact_email;
            $update_contact->phone      = $request->form_contact_phone;
            $update_contact->company    = $request->form_contact_company;
            $update_contact->save();
        }

        if( $contact->type=='quotation' )
        {
            $no_to_update           = [];
            // ? Marcamos productos como fuera de stock y se eliminan de la cotización
            foreach($request->quotation_in_stock AS $product_id => $in_stock)
            {
                if( $in_stock != 1)
                {
                    FormQuotationDetail::where('form_submit_id', $contact->id)
                        ->where('product_id', $product_id)
                        ->delete();
                    $product = Product::find($product_id);
                    $product->in_stock = false;
                    $product->save();
                    $no_to_update[] = $product_id;
                }
            }

            // ? Eliminamos productos de la cotización
            foreach($request->quotation_is_deleted AS $product_id => $is_deleted)
            {
                if( $is_deleted == 1)
                {
                    FormQuotationDetail::where('form_submit_id', $contact->id)
                        ->where('product_id', $product_id)
                        ->delete();
                    $no_to_update[] = $product_id;
                }
            }

            // ? Agregamos nuevos productos a la cotización
            if( empty($request->quotation_model) ){ $request->quotation_model = []; }
            foreach($request->quotation_model AS $product_id => $model)
            {
                $in_stock           = $request->quotation_in_stock[$product_id] == 1;
                $is_deleted         = $request->quotation_is_deleted[$product_id] == 1;

                if( !$in_stock || $is_deleted )
                { continue; }

                FormQuotationDetail::create([
                        'form_submit_id'        => $contact->id
                    ,   'product_id'            => $product_id
                    ,   'promotion_id'          => null
                    ,   'uuid'                  => Str::uuid()
                    ,   'quantity'              => $request->quotation_quantity[$product_id]
                    ,   'product_name'          => $request->quotation_title[$product_id]
                    ,   'product_model'         => $request->quotation_model[$product_id]
                    ,   'product_brand'         => $request->quotation_brand[$product_id]
                    ,   'product_image'         => $request->quotation_image[$product_id]
                    ,   'original_price'        => $request->quotation_original[$product_id]
                    ,   'discount'              => $request->quotation_discount[$product_id]
                    ,   'total'                 => $request->quotation_total[$product_id]
                    ,   'notes'                 => 'Este producto fue agregado por el agente.'
                ]);

                $no_to_update[] = $product_id;
            }

            // ? Actualizamos los registros que tengan modificaciones
            $no_to_update = array_unique($no_to_update);
            foreach($request->quotation_product_id AS $product_id)
            {
                if( in_array($product_id, $no_to_update) )
                { continue; }

                $detail = FormQuotationDetail::where('form_submit_id', $contact->id)
                    ->where('product_id', $product_id)
                    ->first();
                if( $request->quotation_quantity[$product_id] != $detail->quantity )
                {
                    $detail->quantity   = $request->quotation_quantity[$product_id];
                    $detail->total      = $request->quotation_quantity[$product_id] * $detail->original_price;
                    $detail->notes      = 'Producto actualizado por el agente.';
                    $detail->save();
                }
            }
        }

        // ? Respuesta y envío del email
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

        Mail::to($request->form_contact_email, $request->form_contact_name)
            ->send( $contact->type=='quotation' ? new Quotation($contact->id) : new Contact($contact->id) );

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
        $verify                 = parent::verify_turnstile($validated['cf-turnstile-response']);
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
	    $verify                 = parent::verify_turnstile($validated['cf-turnstile-response']);
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
            $has_promo          = $product->get_higer_active_promo();

	        $original_price     = $product->price;
	        $discount           = 0;
	        $total              = $product->price;
	        if( $product->promotion_price > 0 )
	        {
		        $discount           = $product->price - $product->promotion_price;
		        $total              = $product->promotion_price;
	        }
			elseif( $has_promo )
			{
				$original_price     = $has_promo->original_price;
				$discount           = $has_promo->discount;
				$total              = $has_promo->total;
			}

            FormQuotationDetail::create([
                    'form_submit_id'    => $submitted->id
                ,   'product_id'        => $product->id
                ,   'promotion_id'      => !empty($has_promo) ? $has_promo->promotion_id : NULL
                ,   'uuid'              => Str::uuid()
                ,   'quantity'          => $validated['qty'][$product_id][0]
                ,   'product_name'      => $product->title
                ,   'product_model'     => $product->model
                ,   'product_brand'     => $product->product_brand->title
                ,   'product_image'     => $product->image_rx
                ,   'original_price'    => $original_price
                ,   'discount'          => $discount
                ,   'total'             => $total
            ]);
        }

        // Enviar email
        Mail::to(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->send(new Quotation($submitted->id));

        return redirect() -> route('gracias');
    }
}
