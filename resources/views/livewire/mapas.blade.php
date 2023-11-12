<div class="p-6">
    <div>
        @if (session()->has('message'))
            <div class="max-w-lg mx-auto">
                <div class="flex bg-emerald-100 rounded-lg p-4 mb-4 text-sm text-emerald-700" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-5 w-5 mr-3"
                        fill="none" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                            clip-rule="evenodd" />
                    </svg>
                    <div>
                        <span class="font-medium">{{ session('message') }}</span>.
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Seccion que contiene el titulo las busquedas y el boton para registro nuevo -->
    <div class="flex flex-wrap items-center px-4 py-2">
        <div class="relative w-full max-w-full flex-grow flex-1">
            <h3 class="font-semibold text-lg dark:text-gray-100">Listado de Mapas</h3>
        </div>
        <div class="flex flex-col items-center w-full max-w-xl">
            <x-input id="buscar" class="block mt-1 w-full" type="search" name="buscar" wire:model="buscar"
                placeholder="Buscar" />
        </div>
        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
            <x-button class="ms-4" wire:click="agregarmapa()" wire:loading.attr="disabled">
                {{ __('Nuevo Mapa') }}
            </x-button>
        </div>
    </div>
    <!-- / Seccion que contiene el titulo las busquedas y el boton para registro nuevo -->

    <!-- Seccion que contiene el modal para agregar el mapa -->
    <x-dialog-modal wire:model="modalAgregar">
        <x-slot name="title">
            Registrar un Nuevo Mapa
        </x-slot>

        <x-slot name="content">
            <!-- Seccion de imagen principal del mapa -->
            <div>
                <h3 class="font-semibold text-lg dark:text-gray-100">Detalles del Mapa</h3>
                @if ($imagen)
                    <div class="col-span-2 sm:col-span-4 md:col-span-4">
                        <img class="mb-4 w-full" src="{{ $imagen->temporaryUrl() }}" alt="">
                    </div>
                @endif
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    para
                                    Subir
                                    archivo</span></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" wire:model.defer="imagen" />
                        <x-input-error for="imagen" class="mt-2" />
                    </label>
                </div>
            </div>
            <!-- / Seccion de imagen principal del mapa -->

            <div class="mt-4">
                <x-label for="name" value="{{ __('Nombre del Mapa') }}" />
                <x-input class="block mt-1 w-full" type="text" wire:model.defer="name" required />

            </div>

            <div class="mt-4">
                <x-label for="name" value="{{ __('Nivel del Mapa') }}" />
                <select wire:model.defer="nivel"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="" selected>Seleccionar</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="name" value="{{ __('Tipo del Mapa') }}" />
                <select wire:model.defer="tipo"
                    class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    <option value="" selected>Seleccionar</option>
                    <option value="Cruce">Cruce</option>
                    <option value="Corredor">Corredor</option>
                    <option value="Santuario">Santuario</option>
                    <option value="Descanso">Descanso</option>
                </select>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="px-4 py-2 m-2">
                <x-secondary-button wire:click="guardarmapa()" wire:loading.attr="disabled">
                    Agregar
                </x-secondary-button>
            </div>
            <div class="px-4 py-2 m-2">
                <x-danger-button class="ml-2" wire:click="$toggle('modalAgregar')" wire:loading.attr="disabled">
                    Cancelar
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>
    <!-- / Seccion que contiene el modal para agregar el mapa -->

</div>
