<input id="{{$prefix}}[{{$record->id}}]"
       class="block w-full p-px mt-0 border-1 border-gray-200 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right bg-white read-only:bg-gray-100 read-only:text-gray-600"
       style="font-size: .75rem"
       type="number"
       name="{{$prefix}}[{{$record->id}}]"
       step=".01"
       placeholder="0.00"
       value="{{ $record->price }}"
       data-original-id="{{ $record->id }}"
       data-original-price="{{ $record->price }}"
       data-price-type="{{$prefix}}"
       @if($readonly) readonly @endif
       @if($readonly) disabled @endif
>
