<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Banners', 'fa_icon'=>'images', 'subtitle'=>$subtitle])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <div class="flex flex-wrap items-center justify-center p-6 border-2 border-dotted mb-5 leading-4" id="orderable">
            @foreach($records AS $record)
                <div class="block draggable is_draggable w-1/5 border-2 p-2 m-2 text-center hover:bg-gray-200 cursor-pointer rounded" data-id="{{$record->id}}" data-position="{{ $record->order }}">
                    @if( !is_null($record->image) && file_exists($record->asset_folder.$record->image) )
                        <img class="mx-auto" src="{{$record->asset_url.$record->image}}" alt="{{ $record->title }}"><br>
                        <small class="uppercase" style="font-size:.7rem;">{{ $record->title }}</small>
                    @else
                        {{ $record->title }}
                    @endif
                </div>
            @endforeach
        </div>

        @can('editar banners')
            <div class="text-right">
                <x-form.button class="ms-1" type="success" icon="fa-save" text="Actualizar" form="button" data-action-post/>
            </div>
        @endcan
    </div>

    @push('ESmodules')
        <script>
            const url_route         = '{{ route('dashboard.banners.sort') }}';
            const url_route_back    = '{{ route('banners.index') }}';
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/dragger.js'])
    @endpush
</x-app-layout>
