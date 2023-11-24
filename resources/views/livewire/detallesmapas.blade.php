<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $info->name }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
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
                    <h3 class="font-semibold text-lg dark:text-gray-100">Agregar Gremio</h3>
                </div>
                <div class="relative w-full max-w-full flex-grow flex-1 text-right">
                    <x-button class="ms-4" wire:click="modalgremio()" wire:loading.attr="disabled">
                        {{ __('Buscar Gremio') }}
                    </x-button>
                </div>
            </div>
            <!-- / Seccion que contiene el titulo las busquedas y el boton para registro nuevo -->

            <!-- Seccion que contiene el modal para agregar el mapa -->
            <x-dialog-modal wire:model="modalAgregar">
                <x-slot name="title">
                    Agregar Gremio
                </x-slot>

                <x-slot name="content">
                    <div>
                        <x-input id="buscar" class="block mt-1 w-full" type="search" name="buscar"
                            wire:model.live="buscar" placeholder="Buscar" />
                    </div>
                    <div class="mt-4">
                        <!-- Tabla -->
                        <div class="overflow-x-auto">
                            <div class="dark:bg-gray-800 shadow-md rounded my-6">
                                <table class="min-w-max w-full table-auto">
                                    <thead>
                                        <tr
                                            class="dark:bg-gray-800 dark:text-gray-100 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Nombre</th>
                                        </tr>
                                    </thead>
                                    @if ($gremios == false)
                                    @else
                                        <tbody class="text-gray-600 text-sm font-light">
                                            @foreach ($gremios as $gremio)
                                                <tr class="border-b border-gray-200 hover:bg-gray-600 dark:text-gray-100"
                                                    type="button" wire:click="detallesdegremio('{{ $gremio->Id }}')">
                                                    <td class="py-3 px-6 text-left whitespace-nowrap">
                                                        {{ $gremio->Name }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif

                                </table>
                            </div>
                        </div>
                        <!-- / Tabla -->

                    </div>

                </x-slot>

                <x-slot name="footer">
                    <div class="px-4 py-2 m-2">
                        <x-danger-button class="ml-2" wire:click="$toggle('modalAgregar')"
                            wire:loading.attr="disabled">
                            Cancelar
                        </x-danger-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
            <!-- / Seccion que contiene el modal para agregar el mapa -->

            <!-- Seccion que contiene el modal para agregar el mapa -->
            <x-dialog-modal wire:model="modalGremio">
                <x-slot name="title">
                    @if ($alianza_gremio == null)
                        {{ $nombre_gremio }}
                    @else
                        {{ $alianza_gremio }} {{ $nombre_gremio }}
                    @endif                    
                </x-slot>

                <x-slot name="content">
                    <div class="mt-4">
                        <x-label for="name" value="{{ __('Nombre del Gremio') }}" />  
                        {{ $nombre_gremio }}  
                    </div>

                    @if ($alianza_gremio)
                        <div class="mt-4">
                            <x-label for="name" value="{{ __('Alianza') }}" />  
                            {{ $alianza_gremio }}      
                        </div>                          
                    @endif

                    <div class="mt-4">
                        <x-label for="name" value="{{ __('Identificador') }}" />  
                        {{ $id_gremio }}  
                    </div>   
                    
                    <div class="mt-4">
                        <x-label for="name" value="{{ __('Integrantes') }}" />  
                        {{ $miembros_gremio }}  
                    </div> 

                    <div class="mt-4">
                        <x-label for="name" value="{{ __('Tipo de Escondite HO/HQ') }}" />
                        <select wire:model.defer="escondite"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="" selected>Seleccionar</option>
                            <option value="HO">HO</option>
                            <option value="HQ">HQ</option>
                        </select>
                    </div>
                    
                </x-slot>

                <x-slot name="footer">
                    <div class="px-4 py-2 m-2">
                        <x-secondary-button wire:click="guardarescondite()" wire:loading.attr="disabled">
                            Agregar
                        </x-secondary-button>
                    </div>                    
                    <div class="px-4 py-2 m-2">
                        <x-danger-button class="ml-2" wire:click="$toggle('modalGremio')"
                            wire:loading.attr="disabled">
                            Cancelar
                        </x-danger-button>
                    </div>
                </x-slot>
            </x-dialog-modal>
            <!-- / Seccion que contiene el modal para agregar el mapa -->

        </div>
        <div class="mt-4  bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <img class="max-w-full h-auto" src="{{ $info->foto_mapa }}" />
        </div>        
    </div>

</div>
