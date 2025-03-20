<div x-data="buscar_productos()" class="relative">
    <input type="text"
           x-model="query"
           @input.debounce.300ms="buscar_productos"
           placeholder="Buscar productos..."
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
    >
    @error('product_list')
    <x-form.error-field :id="'product_list'" :error="$message" />
    @enderror

    <!-- Lista de sugerencias -->
    <div class="absolute bg-white border w-full max-h-80 overflow-y-auto mt-1" x-show="resultados.length">
        <template x-for="producto in resultados" :key="producto.id">
            <div @click="agregar_producto(producto)" class="p-2 cursor-pointer hover:bg-gray-200">
                <img :src="producto.image" class="w-10 h-10 inline-block">
                <span x-text="producto.name"></span>
            </div>
        </template>
    </div>

    <!-- Lista de productos seleccionados -->
    <div class="mt-4">
        <template x-for="(producto, index) in seleccionados" :key="producto.id">
            <div class="flex items-center justify-start p-2 border-b mb-3">
                <button @click="eliminar_producto(index)" class="text-red-500 hover:text-red-700 me-5 border w-9 h-9 rounded-full">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
                <img :src="producto.image" class="w-10 h-10 me-5">
                <small x-text="producto.name"></small>
            </div>
        </template>
    </div>

    <!-- Campo oculto para enviar los IDs -->
    <input type="hidden" name="product_list" :value="JSON.stringify(seleccionados.map(p => p.id))">
</div>