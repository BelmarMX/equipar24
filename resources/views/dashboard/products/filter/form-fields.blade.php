
    <div class="flex flex-wrap">
        <div class="w-full md:w-4/12">
            <x-form.select select2 name="product_brand_id" placeholder="Marca" class="mb-6">
                <option value="" selected>Todas</option>
                @foreach($brands AS $brand)
                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="w-full md:w-4/12">
            <x-form.select select2 data-category-fill="#product_subcategory_id" name="product_category_id" placeholder="Categoría"  class="mb-6">
                <option value="" selected>Todas</option>
                @foreach($categories AS $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </x-form.select>
        </div>
        <div class="w-full md:w-4/12">
            <x-form.select select2 name="product_subcategory_id" placeholder="Subcategoría" class="mb-6">
                <option value="" selected>Todas</option>
            </x-form.select>
        </div>
        <div class="w-full md:w-4/12">
            <x-form.checkbox name="is_featured" label="Producto destacado" fa_icon="fa-star" value="1" :width="100" class="mb-6"/>
        </div>
        <div class="w-full md:w-4/12">
            <x-form.checkbox name="with_freight" label="¿Incluye flete?" fa_icon="fa-truck-fast" value="1" :width="100" class="mb-6"/>
        </div>
        <div class="w-full md:w-4/12 text-center">
            <x-form.button id="btn-filter" class="ms-1" type="info-outline" icon="fa-filter-circle-dollar fa-lg" text="Filtrar" form="button" data-tooltip="Filtra los productos para modificar los precios del resultado."/>
            @if( !isset($btn_download) || $btn_download )
            <x-form.button id="btn-download" class="mb-1" type="info-outline" icon="fa-file-arrow-down fa-lg" text="Descargar" form="button" data-tooltip="Descarga la plantilla filtrada para cambiar precios."/>
            @endif
        </div>
    </div>
