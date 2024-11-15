<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-envelope-open me-1"></i> Formulario de {{ $contact->type == 'quotation' ? 'Cotización' : 'Solicitud de información' }}
            </h2>
            <x-secondary-link class="mx-1" :href="route('contacts.index')">
                <i class="fa-solid fa-clipboard-list md:me-1 text-base"></i><span class="hidden md:inline">Registros</span>
            </x-secondary-link>
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-200 dark:bg-white p-4">
        <form data-floating-labels
              id="form_create_edit"
              class="w-11/12 mx-auto px-1 py-7"
              method="POST"
              action="{{ route('contacts.update', $contact->id) }}"
              enctype="multipart/form-data"
              autocomplete="off"
        >
            @method('PUT')
            @csrf

            <h1 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">
                Detalles del formulario
            </h1>
            <div class="flex flex-wrap">
                <div class="md:w-4/12">
                    @include('dashboard.contacts.status', ['record' => $contact])
                </div>
                <div class="md:w-4/12 md:ms-[33.33%] text-right">
                    Fecha de solicitud {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            @if($errors -> any() )
                <x-form.alert type="danger" title="Hay errores en el formulario que impidieron su registro." />
            @endif
            <hr class="mb-2 border-2 border-slate-50"/>

            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
            <div class="bg-neutral-50 px-3 py-10">
                <div class="flex flex-wrap">
                    <div class="w-full mb-4">
                        <h2>Datos de contacto</h2>
                    </div>
                    <x-form.input-text name="form_contact.uuid" placeholder="UUID del contacto" value="{{ strtoupper($contact->form_contact->uuid) }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact.created_at" placeholder="Alta del contacto" value="{{ \Carbon\Carbon::parse($contact->form_contact->created_at)->format('d/m/Y H:i') }}" readonly class="mb-6 md:w-4/12 md:ms-[33.3333%]"/>
                    <x-form.input-text name="form_contact.name" placeholder="Nombre del contacto" value="{{ $contact->form_contact->name }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact.email" placeholder="Email del contacto" value="{{ $contact->form_contact->email }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact.phone" placeholder="Teléfono del contacto" value="{{ $contact->form_contact->phone }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact.company" placeholder="Empresa del contacto" value="{{ $contact->form_contact->company }}" readonly class="mb-6 md:w-8/12"/>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full mb-4">
                        <h2>Atención</h2>
                    </div>
                    <x-form.input-text name="user.name" placeholder="Nombre del usuario de atención" value="{{ Auth::user()->name }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="user.email" placeholder="Email del usuario de atención" value="{{ Auth::user()->email }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact.date" placeholder="Fecha de atención" value="{{ \Carbon\Carbon::parse(now())->format('d/m/Y H:i') }}" readonly class="mb-6 md:w-4/12"/>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full mb-4">
                        <h2>Respuesta</h2>
                    </div>
                    @if($contact->type=='quotation')
                    <div class="w-full mb-10">
                        <small>NOTA: La información de la cotización es histórica y muestra los nombres y precios aplicables en el momento de la solicitud.</small>
                        <div class="table-responsive bg-white rounded p-1">
                            <table class="min-w-full text-left text-sm font-light text-surface">
                                <thead class="border-b border-neutral-200 font-medium">
                                    <tr>
                                        <th class="px-3 py-2">ID</th>
                                        <th class="px-3 py-2">Título del producto</th>
                                        <th class="px-3 py-2">Promoción aplicada</th>
                                        <th class="px-3 py-2 text-center">Cant.</th>
                                        <th class="px-3 py-2 text-center">P. original</th>
                                        <th class="px-3 py-2 text-center">Descuento</th>
                                        <th class="px-3 py-2 text-center">P. unitario</th>
                                        <th class="px-3 py-2 text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contact->form_quotation_details()->get() AS $detail)
                                        <tr class="border-b border-neutral-200">
                                            <td class="px-3 py-2 text-right">{{ $detail->product_id }}</td>
                                            <td class="px-3 py-2" style="max-width: 430px">
                                                <small>{{ $detail->product_name }}</small>
                                                @if(isset($detail->product) && $detail->product_name != $detail->product->title)
                                                <br><small data-tooltip="Nombre actual"><i class="fa-solid fa-rotate-right"></i> {{ $detail->product->title }}</small>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2">
                                                @if( !is_null($detail->promotion_id) )
                                                    {{ $detail->promotion->title ?? 'Promoción eliminada' }}<br>
                                                    <small>ID {{ $detail->promotion_id }}: {{ $detail->promotion->title ? ($detail->promotion->type=='fixed' ? "-$".$detail->promotion->amount : "-".$detail->promotion->amount."%" ) : NULL }}</small>
                                                @else
                                                    Sin promoción
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-right">{{ $detail->quantity }}</td>
                                            <td class="px-3 py-2 text-right">${{ number_format($detail->original_price) }}</td>
                                            <td class="px-3 py-2 text-right">${{ number_format($detail->discount) }}</td>
                                            <td class="px-3 py-2 text-right">${{ number_format($detail->total) }}</td>
                                            <td class="px-3 py-2 text-right">${{ number_format($detail->quantity * $detail->total) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="border-b border-neutral-200">
                                        <td class="px-3 py-2 text-right" colspan="4"><strong>TOTAL</strong></td>
                                        <td class="px-3 py-2 text-right">${{ number_format($totals->original) }}</td>
                                        <td class="px-3 py-2 text-right">${{ number_format($totals->discount) }}</td>
                                        <td class="px-3 py-2 text-right"></td>
                                        <td class="px-3 py-2 text-right">${{ number_format($totals->total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    <x-form.textarea name="form_contact.comment" placeholder="Comentario del cliente" value="{{$contact->comment}}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.textarea name="notes" placeholder="Notas del agente" value="{{$contact->notes}}" class="mb-6 md:w-4/12" required :readonly="$contact->status!='pending'"/>
                    @if( $contact->status == 'pending' )
                    <x-form.select select2 name="status" placeholder="Cambiar estatus del formulario" class="mb-6 md:w-4/12">
                        <option value="approved" selected>Aprobado</option>
                        <option value="rejected">Rechazado</option>
                    </x-form.select>
                    @endif
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->

            <div class="flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
                <x-form.button class="me-2" type="danger-outline" icon="fa-cancel" text="Cancelar" href="{{ route('contacts.index') }}" data-confirm-redirect=""/>
                @if( $contact->status == 'pending' )
                <x-form.button class="ms-1" type="success" icon="'fa-pencil'" text="Actualizar" form="submit"/>
                @endif
            </div>
        </form>
    </div>

    @push('style')
    @endpush
    @push('ESmodules')
    @endpush
</x-app-layout>
