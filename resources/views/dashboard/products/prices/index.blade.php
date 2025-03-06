<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-dollar-sign me-1"></i> Cambio masivo de precios
            </h2>
            @include('dashboard.partials.submenu', ['push_buttons' => [
                    ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
                ,   ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ], 'permission' => 'precios'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-200 dark:bg-white p-4">
        <form data-floating-labels
              id="filter_products"
              class="w-11/12 mx-auto px-1 py-7"
              method="POST"
              enctype="multipart/form-data"
              autocomplete="off"
        >
            @csrf
            <h1 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">
                Filtrar y mostrar productos
            </h1>
            <hr class="mb-2 border-2 border-slate-50"/>

            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
            <div class="bg-neutral-50 px-3 py-10">
                <div class="flex flex-wrap">
                    <div class="md:w-9/12">
                        @include('dashboard.products.filter.form-fields')
                    </div>
                    @can('editar precios')
                    <div class="w-full md:w-3/12">
                        <x-form.file name="new_prices"
                                     class="mb-6"
                                     placeholder="Subir XLSX"
                                     accept=".xlsx"
                                     :value="NULL"
                        />
                        <div id="upload-button-wrapper" class="hidden text-center">
                            <x-form.button id="btn-upload" class="mb-1" type="success" icon="fa-file-arrow-up fa-lg"
                                           text="Actualizar con XLSX" form="button"
                                           data-tooltip="Carga la plantilla para actualizar los precios"/>
                        </div>
                    </div>
                    @endcan
                </div>
                <div id="price_change_controller" class="hidden text-center w-full mt-5">
                    <hr class="mt-5 mb-5">
                    Aplicar
                    <input id="change_value"
                           class="mb-3 p-1 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right"
                           type="number" step=".01" value="" placeholder="0.00">
                    <select id="change_type"
                            class="mb-3 p-1 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700">
                        <option value="fixed_more" selected>[ +$ ] Pesos más</option>
                        <option value="fixed_less">[ -$ ] Pesos menos</option>
                        <option value="percentage_more">[ +% ] Porciento más</option>
                        <option value="percentage_less">[ -% ] Porciento menos</option>
                    </select>
                    <div class="inline">
                        <x-form.button id="btn-change-prices" class="ms-1" type="info-outline" icon="fa-rotate fa-md"
                                       text="Generar precios" form="button" data-tooltip="Genera nuevos precios"/>
                    </div>
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
        </form>
    </div>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="productPrices-table" class="hidden" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 260px">Título</th>
                <th style="min-width: 180px">Categoría</th>
                <th style="min-width: 220px">Subcategoría</th>
                <th style="min-width: 120px">Marca</th>
                <th>Precio Actual</th>
                <th>Precio Nuevo</th>
            </tr>
            </thead>
        </table>

        @can('editar precios')
        <div id="btn-update-wrapper" class="hidden flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
            <x-form.button id="btn-update" class="ms-1" type="success" icon="fa-save" text="Actualizar Precios"
                           form="button"/>
        </div>
        @endcan
    </div>

    @push('ESmodules')
        <script>
            const url_route = '{{ route('dashboard.productPrices.datatable') }}';
            const update_massive_route = '{{ route('productPrices.update_massive') }}'
            const generate_massive_file_route = '{{ route('productPrices.generate_massive_file') }}'
            const update_massive_file_route = '{{ route('productPrices.update_massive_file') }}'
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/behavior.js', 'resources/assets/js/dashboard/datatables/productPrices.js'])
    @endpush
</x-app-layout>
