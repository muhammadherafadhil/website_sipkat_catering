<div class="bg-white rounded-lg shadow p-4 border-l-4 {{ $getBorderClass() }}">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs text-gray-500 uppercase tracking-wide">{{ $label }}</p>
            <p class="text-2xl font-bold {{ $getTextClass() }} mt-1">{{ $value }}</p>
            @if($hint)
                <p class="text-xs text-gray-400 mt-1">{{ $hint }}</p>
            @endif
        </div>
        <span class="text-3xl opacity-70">{{ $icon }}</span>
    </div>
</div>