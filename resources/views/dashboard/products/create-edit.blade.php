<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-registered me-1"></i> Productos <i class="fa-solid fa-right-long fa-xs"></i> {{ $record->id ? 'Editar' : 'Nuevo' }}
            </h2>
            @include('dashboard.partials.submenu', ['resource' => $resource, 'push_buttons' => [
                    ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ]])
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
                        <x-form.input-text name="title" placeholder="Título del producto" value="{{ old('title', $record->title) }}" with_slug="true" required class="mb-6"/>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.input-text name="model" placeholder="Modelo" value="{{ old('model', $record->model) }}" required class="mb-6"/>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.select select2 name="product_brand_id" placeholder="Marca" class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @foreach($brands AS $brand)
                                        <option value="{{ $brand->id }}" @if( old('product_brand_id', $record->product_brand_id) == $brand->id) selected @endif>{{ $brand->title }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.select select2 data-category-fill="#product_subcategory_id" name="product_category_id" placeholder="Categoría"  class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @foreach($categories AS $category)
                                        <option value="{{ $category->id }}" @if( old('product_category_id', $record->product_category_id) == $category->id) selected @endif>{{ $category->title }}</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.select select2 name="product_subcategory_id" placeholder="Subcategoría" class="mb-6">
                                    <option value="" selected>Ninguna</option>
                                    @if( $record->product_subcategory_id )
                                        @foreach($record -> product_category -> subcategories AS $subcategory)
                                            <option value="{{ $subcategory->id }}" @if( old('product_subcategory_id', $record->product_subcategory_id) == $subcategory->id) selected @endif>{{ $subcategory->title }}</option>
                                        @endforeach
                                    @endif
                                </x-form.select>
                            </div>
                        </div>
                        <x-form.input-text name="summary" placeholder="Resumen" value="{{ old('summary', $record->summary) }}" class="mb-6"/>
                        <x-form.input-number name="price" placeholder="Precio" value="{{ old('price', $record->price) }}" decimal="true" required class="w-6/12 ml-auto mb-6"/>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.checkbox name="is_featured" label="Producto destacado" fa_icon="fa-star" value="1" checked="{{ old('is_featured', $record->is_featured) }}" :width="100" class="mb-6"/>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.checkbox name="with_freight" label="¿Incluye flete?" fa_icon="fa-truck-fast" value="1" checked="{{ old('with_freight', $record->with_freight) }}" :width="100" class="mb-6"/>
                            </div>
                        </div>
                        <x-form.features-box name="features" placeholder="Características" value="{{ old('features', $record->features) }}" class="mb-6"/>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Portada"
                                           required
                                           :width="$ImagesSettings::PRODUCT_WIDTH"
                                           :height="$ImagesSettings::PRODUCT_HEIGHT"
                                           :value="$record->id ? $record->asset_url.$record->image : NULL"
                        />
                        <x-form.file name="data_sheet"
                                     class="mb-6"
                                     placeholder="Ficha técnica"
                                     accept="application/pdf,application/x-pdf"
                                     :value="$record->id ? $record->asset_url.'fichas/'.$record->data_sheet : NULL"
                        />
                    </div>
                    <div class="w-full">
                        <x-form.textarea-editor name="raw_editor" class="mb-6" placeholder="Información técnica" value="{{ old('raw_editor', $record->raw_editor ?? $raw_description) }}" required/>
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
    @endpush
</x-app-layout>
