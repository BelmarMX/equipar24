<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-truck-fast me-1"></i> Cambio de fletes
            </h2>
            @include('dashboard.partials.submenu', ['push_buttons' => [
                    ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
                ,   ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ]])
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
                        @include('dashboard.products.filter.form-fields', ['btn_download' => FALSE])
                    </div>
                </div>
                <div id="freight_change_controller" class="hidden text-center w-full mt-5">
                    <hr class="mt-5 mb-5">
                    <select id="change_type"
                            class="mb-3 p-1 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
                            style="min-width: 200px">
                        <option value="with_freight" selected>Agregar flete</option>
                        <option value="without_freight">Quitar flete</option>
                    </select>
                    <div class="inline">
                        <x-form.button id="btn-change-freights" class="ms-1" type="info-outline" icon="fa-rotate fa-md"
                                       text="Aplicar selección" form="button"
                                       data-tooltip="Agrega o quita el flete a los productos seleccionados"/>
                    </div>
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
        </form>
    </div>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="productFreights-table" class="hidden" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 260px">Título</th>
                <th style="min-width: 180px">Categoría</th>
                <th style="min-width: 220px">Subcategoría</th>
                <th style="min-width: 120px">Marca</th>
                <th>Flete Actual</th>
                <th>Flete Nuevo</th>
            </tr>
            </thead>
        </table>

        <div id="btn-update-wrapper" class="hidden flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
            <x-form.button id="btn-update" class="ms-1" type="success" icon="fa-save" text="Actualizar fletes"
                           form="button"/>
        </div>
    </div>

    @push('ESmodules')
        <script>
            const url_route = '{{ route('dashboard.productFreights.datatable') }}';
            const update_massive_route = '{{ route('productFreights.update_massive') }}'
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/behavior.js', 'resources/assets/js/dashboard/datatables/productFreights.js'])
    @endpush
</x-app-layout>