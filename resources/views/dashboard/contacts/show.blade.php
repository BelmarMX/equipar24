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
                <div class="md:w-2/12">
                    @include('dashboard.contacts.status', ['record' => $contact])
                </div>
                <div class="md:w-6/12 md:ms-[33.33%] text-right">
                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">Fecha de solicitud {{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y H:i') }}</span>
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
                <div class="flex flex-wrap" x-data="{ edit_field: false}">
                    <div class="w-full mb-4">
                        <h2>Datos de contacto</h2>
                    </div>
                    <x-form.input-text name="form_contact_uuid" placeholder="UUID del contacto" value="{{ strtoupper($contact->form_contact->uuid) }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact_created_at" placeholder="Alta del contacto" value="{{ \Carbon\Carbon::parse($contact->form_contact->created_at)->format('d/m/Y H:i') }}" readonly class="mb-6 md:w-4/12 md:ms-[33.3333%]"/>

                    <x-form.input-text name="form_contact_name" placeholder="Nombre del contacto" value="{{ $contact->form_contact->name }}" bind_readonly data-field="contact_name" class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact_email" placeholder="Email del contacto" value="{{ $contact->form_contact->email }}" bind_readonly data-field="contact_email" class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact_phone" placeholder="Teléfono del contacto" value="{{ $contact->form_contact->phone }}" bind_readonly data-field="contact_phone" class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact_company" placeholder="Empresa del contacto" value="{{ $contact->form_contact->company }}" bind_readonly data-field="contact_company" class="mb-6 md:w-8/12"/>

                    @if( $contact->status == 'pending' )
                    <div class="flex justify-end border-t-4 border-slate-50 pb-8">
                        <x-form.button class="ms-1" type="warning" icon="fa-pencil" text="Editar contacto" form="button" x-on:click="edit_field = !edit_field"/>
                    </div>
                    @endif
                </div>
                <div class="flex flex-wrap">
                    <x-form.textarea name="form_contact_comment" placeholder="Comentario del cliente" value="{{$contact->comment}}" readonly class="mb-6 md:w-full"/>
                </div>
                <div class="flex flex-wrap">
                    @if($contact->type=='quotation')
                    <div class="w-full mb-4">
                        <h2>Cotización</h2>
                    </div>
                    <div class="w-full mb-10">
                        <small>NOTA: La información de la cotización es histórica y muestra los nombres y precios aplicables en el momento de la solicitud.</small>
                        <div class="table-responsive bg-white rounded p-1">
                            @if( $contact->status == 'pending' )
                            <div class="text-right p-3" x-data="{show_modal: false}">
                                <x-form.button class="ms-1 add-new-product" type="warning" icon="fa-add" text="Agregar producto" form="button" x-on:click="show_modal = true"/>

                                <div id="crud-modal" tabindex="-1" x-show="show_modal" class="bg-gray-800/35 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full flex" aria-modal="true" role="dialog">
                                    <div class="relative p-4 w-full max-w-md max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700 p-4">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Agregar producto al cotizador
                                                </h3>
                                                <button x-on:click="show_modal = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                                                    <i class="fa-solid fa-times"></i>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-4 md:p-5">
                                                <div class="grid gap-4 mb-4 grid-cols-2">
                                                    <div class="col-span-2">
                                                        <label for="search_title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar por título</label>
                                                        <input x-ref='search_box' type="text" name="search_title" id="search_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Escribe el nombre del producto">
                                                    </div>
                                                    <div class="col-span-2 text-center">
                                                        <button data-search-product type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <span class="working hidden"><i class="fa-solid fa-circle-notch fa-spin"></i></span>
                                                            <span class="static"><i class="fa-solid fa-search"></i></span>
                                                            Buscar
                                                        </button>
                                                    </div>
                                                    <div class="col-span-2">
                                                        <hr>
                                                    </div>
                                                    <div class="col-span-2 hidden" data-show="results_not_found">
                                                        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                                                            No se encontraron productos que coincidan con la búsqueda.
                                                        </div>
                                                    </div>
                                                    <div class="col-span-2 hidden" data-show="results_found">
                                                        <label for="results" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resultados</label>
                                                        <select id="results" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                            <option selected="" disabled>Selecciona uno de la lista</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-span-1 hidden" data-show="results_found">
                                                        <label for="new_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cantidad</label>
                                                        <input type="number" name="new_quantity" min="1" id="new_quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="1" value="1" required="">
                                                    </div>
                                                    <div class="col-span-1 content-end hidden" data-show="results_found">
                                                        <button id="add_new_product_to_quota" type="button" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                            <i class="fa-solid fa-plus"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <table class="min-w-full text-left text-sm font-light text-surface">
                                <thead class="border-b border-neutral-200 font-medium">
                                    <tr>
                                        <th class="px-3 py-2">ID</th>
                                        <th class="px-3 py-2">Título del producto</th>
                                        <th class="px-3 py-2">Promoción<br>aplicada</th>
                                        <th class="px-3 py-2 text-center">Cant.</th>
                                        <th class="px-3 py-2 text-center">P. original</th>
                                        <th class="px-3 py-2 text-center">Descuento</th>
                                        <th class="px-3 py-2 text-center">P. unitario</th>
                                        <th class="px-3 py-2 text-center">Total</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody class="quotation">
                                    @foreach($contact->form_quotation_details()->get() AS $detail)
                                        <tr class="border-b border-neutral-200" data-product_id="{{ $detail->product_id }}">
                                            <td class="px-3 py-2 text-right">
                                                @if( $contact->status == 'pending' )
                                                <button type="button" data-tooltip="Marcar sin existencia" data-no-stock="{{ $detail->product_id }}">🔴</button>
                                                @endif
                                                <small>{{ $detail->product_id }}</small>
                                                <input type="hidden" name="quotation.product_id[]" value="{{ $detail->product_id }}">
                                                <input type="hidden" name="quotation.original[{{ $detail->product_id }}]" value="{{ $detail->original_price }}">
                                                <input type="hidden" name="quotation.discount[{{ $detail->product_id }}]" value="{{ $detail->discount }}">
                                                <input type="hidden" name="quotation.total[{{ $detail->product_id }}]" value="{{ $detail->total }}">
                                                <input type="hidden" name="quotation.in_stock[{{ $detail->product_id }}]" value="1">
                                                <input type="hidden" name="quotation.is_deleted[{{ $detail->product_id }}]" value="0">
                                                <input type="hidden" name="quotation.add_after[{{ $detail->product_id }}]" value="0">
                                            </td>
                                            <td class="px-3 py-2" style="max-width: 430px">
                                                <small data-table="title">{{ $detail->product_name }}</small>
                                                @if(isset($detail->product) && $detail->product_name != $detail->product->title)
                                                <br><small data-tooltip="Nombre actual"><i class="fa-solid fa-rotate-right"></i> {{ $detail->product->title }}</small>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2" data-if-not-stock="{{ $detail->product_id }}">
                                                @if( !is_null($detail->promotion_id) )
                                                    <small>{{ $detail->promotion->title ?? 'Promoción eliminada' }}</small><br>
                                                    <small>ID {{ $detail->promotion_id }}: {{ $detail->promotion->title ? ($detail->promotion->type=='fixed' ? "-$".$detail->promotion->amount : "-".$detail->promotion->amount."%" ) : NULL }}</small>
                                                @else
                                                    <small>Sin promoción</small>
                                                @endif
                                            </td>
                                            <td class="px-3 py-2 text-right" data-if-not-stock="{{ $detail->product_id }}">
                                                <input data-table="quantity"
                                                       type="number"
                                                       name="quotation.quantity[{{ $detail->product_id }}]"
                                                       min="1"
                                                       value="{{ $detail->quantity }}"
                                                       class="block pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right"
                                                       style="max-width: 80px;"
                                                       @if($contact->status != 'pending') readonly @endif
                                                >
                                            </td>
                                            <td class="px-3 py-2 text-right" data-if-not-stock="{{ $detail->product_id }}">${{ number_format($detail->original_price) }}</td>
                                            <td class="px-3 py-2 text-right" data-if-not-stock="{{ $detail->product_id }}">${{ number_format($detail->discount) }}</td>
                                            <td class="px-3 py-2 text-right" data-if-not-stock="{{ $detail->product_id }}">${{ number_format($detail->total) }}</td>
                                            <td class="px-3 py-2 text-right" data-if-not-stock="{{ $detail->product_id }}" data-update-amount="{{ $detail->product_id }}">${{ number_format($detail->quantity * $detail->total) }}</td>
                                            <td class="text-center">
                                                @if( $contact->status == 'pending' )
                                                <button class="text-red-500" data-tooltip="Eliminar de la cotización" data-delete="{{ $detail->product_id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <button class="text-sky-500 hidden" data-tooltip="Restaurar en la cotización" data-restore="{{ $detail->product_id }}">
                                                    <i class="fa-solid fa-trash-restore"></i>
                                                </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="ignore totales border-b border-neutral-200">
                                        <td class="px-3 py-2 text-right" colspan="4"><strong>TOTAL</strong></td>
                                        <td class="px-3 py-2 text-right" data-original-price>${{ number_format($totals->original) }}</td>
                                        <td class="px-3 py-2 text-right">${{ number_format($totals->discount) }}</td>
                                        <td class="px-3 py-2 text-right"></td>
                                        <td class="px-3 py-2 text-right" data-gran-total>${{ number_format($totals->total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if( $contact->status == 'pending' && $contact->type=='quotation' )
                        <div class="text-right mt-3">
                            <x-form.button id="send_whatsapp" class="ms-2" type="success" icon="fa-brands fa-whatsapp" text="Enviar whatsapp al cliente" form="button"/>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="flex flex-wrap">
                    <div class="w-full mb-4">
                        <h2>Atención</h2>
                    </div>
                    <x-form.input-text name="user.name" placeholder="Nombre del usuario de atención" value="{{ $attended->name }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="user.email" placeholder="Email del usuario de atención" value="{{ $attended->email }}" readonly class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="form_contact_date" placeholder="Fecha de atención" value="{{ \Carbon\Carbon::parse(now())->format('d/m/Y H:i') }}" readonly class="mb-6 md:w-4/12"/>

                    <x-form.textarea name="notes" placeholder="Notas del agente" value="{{$contact->notes}}" class="mb-6 md:w-8/12" required :readonly="$contact->status!='pending'"/>
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
                <x-form.button class="ms-1" type="success" icon="fa-pencil" text="Responder" form="submit"/>
                @endif
            </div>
        </form>
    </div>

    @push('style')
    @endpush
    @push('ESmodules')
        @if( $contact->type == 'quotation' )
            @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/form_contacts.js'])
        @endif
    @endpush
</x-app-layout>
