<!-- Typography Tab -->
<div x-show="activeTab === 'typography'" class="space-y-6">
    <form id="theme-form" class="space-y-4">
        {{-- <x-editor.details
            id="fontFamily"
            :open="true"
        > --}}
            <x-slot:title>Font Family</x-slot>
                {{-- <el-select name="typography.status" value="active" @change="updateFont(font);">
                    <button type="button">
                        <el-selectedcontent>
                            Select font
                        </el-selectedcontent>
                    </button>

                    <el-options popover>
                        <template x-for="font in fonts.filter(f => f.toLowerCase().includes(search.toLowerCase()))"
                            :key="font">
                            <el-option
                                class="w-full px-3 py-2 text-left text-sm text-gray-300 hover:bg-gray-700 transition-colors"
                                :style="`font-family: '${font}', sans-serif`">
                                <span x-text="font"></span>
                            </el-option>
                        </template>
                    </el-options>
                </el-select>

                <label class="block text-sm font-medium text-gray-300">Font Family</label>
                <div class="relative" x-data="{ isOpen: false, search: '' }">
                    <button @click="isOpen = !isOpen" type="button"
                        class="w-full flex items-center justify-between px-3 py-2 bg-gray-800 border border-gray-700 rounded-md text-sm text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <span x-text="form.fontFamily || 'Select font'"></span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': isOpen }" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="m7 10 5 5 5-5z" />
                        </svg>
                    </button>
                    <div x-show="isOpen" @click.away="isOpen = false" x-transition
                        class="absolute top-full left-0 right-0 mt-1 bg-gray-800 border border-gray-700 rounded-md shadow-lg z-50 max-h-48 overflow-hidden">
                        <input x-model="search" placeholder="Search fonts..."
                            class="w-full px-3 py-2 bg-gray-800 border-b border-gray-700 text-sm text-gray-300 placeholder-gray-500 focus:outline-none"
                            @keydown.escape="isOpen = false">
                        <div class="max-h-32 overflow-y-auto">

                        </div>
                    </div>
                </div>

                <input type="hidden" name="typography.fontFamily" :value="form.fontFamily"> --}}
        {{-- </x-editor.details> --}}

        <x-editor.details id="base" :open="true">
            <x-slot:title>Base Text</x-slot>

            <x-field name="typography.base.fontFamily">
                <x-label>Font Family</x-label>

                <x-select>
                    <option value="Inter">Inter</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lato">Lato</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Source Sans Pro">Source Sans Pro</option>
                    <option value="Raleway">Raleway</option>
                    <option value="PT Sans">PT Sans</option>
                    <option value="Lora">Lora</option>
                    <option value="Merriweather">Merriweather</option>
                    <option value="Playfair Display">Playfair Display</option>
                    <option value="Oswald">Oswald</option>
                    <option value="Nunito">Nunito</option>
                    <option value="Ubuntu">Ubuntu</option>
                    <option value="Poppins">Poppins</option>
                    <option value="Mukti">Mukti</option>
                    <option value="Fira Sans">Fira Sans</option>
                    <option value="Work Sans">Work Sans</option>
                    <option value="Rubik">Rubik</option>
                    <option value="DM Sans">DM Sans</option>
                    <option value="Manrope">Manrope</option>
                    <option value="Space Grotesk">Space Grotesk</option>
                </x-select>
            </x-field>

            <x-field name="typography.base.letterSpacing">
                <x-label>Letter Spacing</x-label>

                <x-slider
                    min="-0.25"
                    max="0.25"
                    step="0.005"
                    unit="em"
                />
            </x-field>

            <x-field name="typography.base.lineHeight">
                <x-label>Line Height</x-label>

                <x-slider
                    min="0.5"
                    max="2.5"
                    step="0.05"
                />
            </x-field>
        </x-editor.details>

        <x-editor.details id="headline" :open="true">
            <x-slot:title>Headline</x-slot>

            <x-field name="typography.headline.fontFamily">
                <x-label>Font Family</x-label>

                <x-select>
                    <option value="Inter">Inter</option>
                    <option value="Roboto">Roboto</option>
                    <option value="Open Sans">Open Sans</option>
                    <option value="Lato">Lato</option>
                    <option value="Montserrat">Montserrat</option>
                    <option value="Source Sans Pro">Source Sans Pro</option>
                    <option value="Raleway">Raleway</option>
                    <option value="PT Sans">PT Sans</option>
                    <option value="Lora">Lora</option>
                    <option value="Merriweather">Merriweather</option>
                    <option value="Playfair Display">Playfair Display</option>
                    <option value="Oswald">Oswald</option>
                    <option value="Nunito">Nunito</option>
                    <option value="Ubuntu">Ubuntu</option>
                    <option value="Poppins">Poppins</option>
                    <option value="Mukti">Mukti</option>
                    <option value="Fira Sans">Fira Sans</option>
                    <option value="Work Sans">Work Sans</option>
                    <option value="Rubik">Rubik</option>
                    <option value="DM Sans">DM Sans</option>
                    <option value="Manrope">Manrope</option>
                    <option value="Space Grotesk">Space Grotesk</option>
                </x-select>
            </x-field>

            <x-field name="typography.headline.letterSpacing">
                <x-label>Letter Spacing</x-label>

                <x-slider
                    min="-0.25"
                    max="0.25"
                    step="0.005"
                    unit="em"
                />
            </x-field>

            <x-field name="typography.headline.lineHeight">
                <x-label>Line Height</x-label>

                <x-slider
                    min="0.5"
                    max="2.5"
                    step="0.05"
                />
            </x-field>
        </x-editor.details>
    </form>
</div>
