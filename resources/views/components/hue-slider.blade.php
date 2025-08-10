@aware([
    'name'
])


<div class="relative">
    <!-- Hue slider track with gradient background -->
    <div class="relative h-8 rounded-md overflow-hidden border border-gray-700">
        <div
            class="w-full h-full"
            style="background: linear-gradient(to right,
                oklch(0.65 0.25 0),
                oklch(0.65 0.25 60),
                oklch(0.65 0.25 120),
                oklch(0.65 0.25 180),
                oklch(0.65 0.25 240),
                oklch(0.65 0.25 300),
                oklch(0.65 0.25 360)
            );"
        ></div>

        <!-- Slider input -->
        <input
            x-model="form.{{ $name }}.hue"
            type="range"
            min="0"
            max="360"
            step="1"
            name="{{ $name }}_hue"
            id="{{ $name }}_hue"
            class="absolute inset-0 w-full h-full appearance-none bg-transparent cursor-pointer slider-thumb"
        >
    </div>

    <input
        x-model="form.{{ $name }}.chroma"
        type="range"
        min="0"
        max="4"
        step="0.1"
        name="{{ $name }}_chroma"
        id="{{ $name }}_chroma"
        class="w-full"
    >
</div>

<style>
.slider-thumb::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    border: 2px solid #374151;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.slider-thumb::-moz-range-thumb {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    border: 2px solid #374151;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}
</style>
