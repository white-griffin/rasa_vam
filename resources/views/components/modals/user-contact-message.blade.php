<div class="space-y-4" dir="rtl">

    {{-- هدر --}}
    <div class="flex items-start justify-between pb-3 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $record->name }}</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" dir="ltr">{{ $record->mobile }}</p>
        </div>
        <span class="text-xs text-gray-400 dark:text-gray-500" dir="ltr">
            {{ \Hekmatinasser\Verta\Facades\Verta::instance($record->created_at)->format('Y/m/d H:i') }}
        </span>
    </div>

    {{-- موضوع --}}
    <div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">موضوع</p>
        <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $record->subject }}</p>
    </div>

    {{-- پیام --}}
    <div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">پیام</p>
        <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                    text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap leading-relaxed">
            {{ $record->message }}
        </div>
    </div>

</div>
