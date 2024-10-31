<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-clapperboard me-1"></i> Reels <i class="fa-solid fa-right-long fa-xs"></i> {{ $record->id ? 'Editar' : 'Nuevo' }}
            </h2>
            @include('dashboard.partials.submenu', ['resource' => $resource])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-200 dark:bg-white p-4">
        <form data-floating-labels
              id="form_create_edit"
              class="w-11/12 mx-auto px-1 py-7"
              method="POST"
              action="{{ $record->id ? route($resource.'.update', $record->id) : route($resource.'.store') }}"
              enctype="multipart/form-data"
              autocomplete="off"
        >
        @empty(!$record->id)
            @method('PUT')
        @endempty
        @csrf
            <h1 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">
                {!! $record->id ? '<i class="fa-solid fa-file-pen"></i>' : '<i class="fa-solid fa-file-circle-plus"></i>' !!} {{ $record->id ? 'Editar' : 'Nuevo' }} Registro
            </h1>
            @if($errors -> any() )
                <x-form.alert type="danger" title="Hay errores en el formulario que impidieron su registro." />
            @endif
            <hr class="mb-2 border-2 border-slate-50"/>

            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
            <div class="bg-neutral-50 px-3 py-10">
                <div class="flex flex-wrap">
                    <div class="md:w-6/12 w-full">
                        <x-form.input-text name="title" placeholder="Título del reel" value="{{ old('title', $record->title) }}" required class="mb-6"/>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.select select2 name="promotion_id" placeholder="Promoción" value="{{ $record->promotion_id }}" class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @foreach($promotions AS $promotion)
                                        <option value="{{ $promotion->id }}" @if( old('promotion_id', $record->promotion_id) == $promotion->id) selected @endif
                                                data-link-href="{{route('promociones-productos', $promotion->slug)}}"
                                                data-link-title="¡Ver promoción!"
                                                data-link-description="{{ $promotion->title }}"
                                        >{{ $promotion->title }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.date-range id="date_time_vigency"
                                                   start_name="starts_at"
                                                   end_name="ends_at"
                                                   placeholder="Vigencia"
                                                   start_value="{{ old('starts_at', $record->starts_at ?? date('Y-m-d')) }}"
                                                   end_value="{{ old('ends_at', $record->ends_at ?? date('Y-m-d')) }}"
                                                   required
                                                   class="mb-6"
                                />
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.select select2 data-category-fill="#product_subcategory_id" name="product_category_id" placeholder="Categoría"  class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @foreach($categories AS $category)
                                        <option value="{{ $category->id }}" @if( old('product_category_id', $record->product->product_category_id ?? NULL) == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.select select2 data-subcategory-fill="#product_id" name="product_subcategory_id" placeholder="Subcategoría" class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @if( $record->product->product_subcategory_id ?? NULL )
                                        @foreach($record->product->product_category->subcategories AS $subcategory)
                                            <option value="{{ $subcategory->id }}" @if( old('product_subcategory_id', $record->product->product_subcategory_id) == $subcategory->id) selected @endif>{{ $subcategory->title }}</option>
                                        @endforeach
                                    @endif
                                </x-form.select>
                            </div>
                        </div>
                        <x-form.select select2 name="product_id" placeholder="Producto" value="{{ $record->product_id }}" class="mb-6">
                            <option value="" selected>Ninguno</option>
                            @if( $record->product->id ?? NULL )
                                @foreach($rcrd_products AS $product)
                                    <option value="{{ $product->id }}" @if( old('product_subcategory_id', $record->product->id) == $product->id) selected @endif
                                            data-link-href="{{route('producto-open', [$product->product_category->slug,$product->product_subcategory->slug, $product->slug])}}"
                                            data-link-title="¡Ver producto!"
                                            data-link-description="{{ $product->title }}"
                                    >{{ $product->title }}</option>
                                @endforeach
                            @endif
                        </x-form.select>
                        <div class="flex flex-wrap mb-3">
                            <div class="leading-relaxed text-end pr-1 w-full">
                                Autocompletar con:
                                <x-form.button form="button" class="me-2" type="info-outline" icon="fa-money-check-dollar" text="Promoción" onclick="update_with_promotion()"/>
                                <x-form.button form="button" class="me-2" type="info-outline" icon="fa-barcode" text="Producto" onclick="update_with_product()"/>
                            </div>
                        </div>
                        <x-form.input-text name="link" placeholder="Enlace (opcional)" value="{{ old('link', $record->link) }}" class="mb-6"/>
                        <x-form.input-text name="link_title" placeholder="Título del enlace (opcional)" value="{{ old('link_title', $record->link_title) }}" class="mb-6"/>
                        <x-form.input-text name="link_summary" placeholder="Descripción del enlace (opcional)" value="{{ old('link_summary', $record->link_summary) }}" class="mb-6"/>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file name="video"
                                     class="mb-6"
                                     placeholder="Archivo de video"
                                     accept="video/mp4,video/webm"
                                     size_tag="max: 16,380 kb"
                                     :value="$record->id ? $record->asset_url.$record->video : NULL"
                        />
                    </div>
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->

            <div class="flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
                <x-form.button class="me-2" type="danger-outline" icon="fa-cancel" text="Cancelar" href="{{ route($resource.'.index') }}" data-confirm-redirect=""/>
                <x-form.button class="ms-1" type="success" icon="{{ $record->id ? 'fa-pencil' : 'fa-save' }}" text="{{$record->id ? 'Editar' : 'Guardar'}}" form="submit"/>
            </div>
        </form>
    </div>

    @push('style')
    @endpush
    @push('ESmodules')
        <script >

            const update_link = option => {
                $('#link').val(option.attr('data-link-href'))
                $('#link_title').val(option.attr('data-link-title'))
                $('#link_summary').val(option.attr('data-link-description'))
            }

            const update_with_promotion = O => {
                update_link( $('#promotion_id').find('option:selected') )
            }
            const update_with_product = O => {
                update_link( $('#product_id').find('option:selected') )
            }
        </script>
    @endpush
</x-app-layout>
