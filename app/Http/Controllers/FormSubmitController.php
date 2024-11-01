<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormContactRequest;
use App\Http\Requests\FormQuotationDetailRequest;
use App\Http\Requests\FormSubmitRequest;
use App\Models\City;
use App\Models\FormContact;
use App\Models\FormQuotationDetail;
use App\Models\FormSubmit;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormSubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function archived()
    {
    }

    public function datatable(Request $request)
    {
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
    public function show(FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FormSubmitRequest $request, FormSubmit $formSubmit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FormSubmit $formSubmit)
    {
        //
    }

    public function restore($form_submit_id)
    {
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
            $contact->email     = $validated['email'];
            $contact->phone     = $validated['phone'];
            $contact->save();
        }

        FormSubmit::create([
                'form_contact_id'   => $form_contact_id
            ,   'type'              => 'contact'
            ,   'comment'           => $validated['comments']
        ]);

        // Enviar email

        return redirect() -> route('gracias');
    }

    public function send_quotation(FormQuotationDetailRequest $request)
    {
        $validated              = $request->validated();
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
            $contact->email     = $validated['email'];
            $contact->phone     = $validated['phone'];
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
                // Aquí hay algo raro: revisar
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

        return redirect() -> route('gracias');
    }
}
