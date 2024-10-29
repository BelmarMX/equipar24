<input id="{{$prefix}}[{{$record->id}}]"
       class="peer size-4 appearance-none rounded-sm border border-slate-300 accent-pink-500 dark:accent-pink-600 checked:appearance-auto focus:ring-0"
       type="checkbox"
       name="{{$prefix}}[{{$record->id}}]"
       value="1"
       @if($record->with_freight == 1 ) checked @endif
       data-original-id="{{ $record->id }}"
       data-original-value="{{ $record->with_freight }}"
       data-freight-type="{{$prefix}}"
       @if($readonly) readonly @endif
       @if($readonly) disabled @endif
>
