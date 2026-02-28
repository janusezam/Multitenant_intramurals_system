@if($color === 'green')
    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-green-600 font-medium">{{ $label }}</p>
                <p class="text-2xl font-bold text-green-700">{{ $value }}</p>
            </div>
            <span class="text-3xl">{{ $icon }}</span>
        </div>
    </div>
@elseif($color === 'blue')
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-blue-600 font-medium">{{ $label }}</p>
                <p class="text-2xl font-bold text-blue-700">{{ $value }}</p>
            </div>
            <span class="text-3xl">{{ $icon }}</span>
        </div>
    </div>
@elseif($color === 'red')
    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-red-600 font-medium">{{ $label }}</p>
                <p class="text-2xl font-bold text-red-700">{{ $value }}</p>
            </div>
            <span class="text-3xl">{{ $icon }}</span>
        </div>
    </div>
@elseif($color === 'indigo')
    <div class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-4 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-indigo-600 font-medium">{{ $label }}</p>
                <p class="text-2xl font-bold text-indigo-700">{{ $value }}</p>
            </div>
            <span class="text-3xl">{{ $icon }}</span>
        </div>
    </div>
@endif
