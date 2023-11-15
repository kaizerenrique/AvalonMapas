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
            <x-input id="buscar" class="block mt-1 w-full" type="search" name="buscar" wire:model.live="buscar"
                placeholder="Buscar" />
        </div>
        <div class="relative w-full max-w-full flex-grow flex-1 text-right">
            <x-button class="ms-4" wire:click="agregarmapa()" wire:loading.attr="disabled">
                {{ __('Nuevo Mapa') }}
            </x-button>
        </div>
    </div>
    <!-- / Seccion que contiene el titulo las busquedas y el boton para registro nuevo -->

    <!-- Tabla -->
    <div class="overflow-x-auto">
        <div class="dark:bg-gray-800 shadow-md rounded my-6">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="dark:bg-gray-800 dark:text-gray-100 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Nombre</th>
                        <th class="py-3 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($mapas as $mapa)
                        <tr class="border-b border-gray-200 hover:bg-gray-600 dark:text-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                
                                  <div class="flex items-center">
                                    <div class="mr-2">
                                      <img class="w-12 h-12 rounded-full" src="{{ $mapa->foto_mapa }}" />
                                    </div>
                                    <span>{{ $mapa->name }}</span>
                                  </div>                 
                                                          
                              </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                               {{$mapa->name}}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        wire:click="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        wire:click="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </div>
                                    <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        wire:click="consultarborrarmapa({{$mapa->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $mapas->links() }}
        </div>
    </div>
    <!-- / Tabla -->

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

    <x-confirmation-modal wire:model="confirmarEliminarMapa">
        <x-slot name="title">
            Borrar Mapa
        </x-slot>
    
        <x-slot name="content">
            ¿Estás seguro de que quieres eliminar el mapa {{ $mensajemapa }}? Una vez que se elimine el mapa, todos los datos se eliminarán permanentemente.
        </x-slot>
    
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmarEliminarMapa')" wire:loading.attr="disabled">
                Cancelar
            </x-secondary-button>
    
            <x-danger-button class="ml-2" wire:click="borrarmapa({{ $idmapa }})" wire:loading.attr="disabled">
                Borrar Mapa
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

</div>
