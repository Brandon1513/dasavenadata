<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Sección izquierda: logo y navegación -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
                    </a>
                </div>

                <!-- Navigation Links -->
                @if (Auth::check())
                    
                
                <div class="hidden space-x-8 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="hover:text-gray-300">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->hasAnyRole(['administrador', 'lider', 'validador']))
                        <!-- Dropdown Administración -->
                        <div class="relative">
                            @if (Auth::user()->hasRole('administrador'))
                            <x-dropdown align="left">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out bg-transparent border border-transparent rounded-md hover:text-gray-300 focus:outline-none">
                                        <div>{{ __('Administración') }}</div>
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    
                                        <x-dropdown-link :href="route('empleados.index')" class="text-gray-700 hover:bg-gray-200">
                                            {{ __('Gestionar Usuarios') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('departamento.tablas.index')" class="text-gray-700 hover:bg-gray-200">
                                            {{ __('Departamento Tablas') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('departamentos.index')" class="text-gray-700 hover:bg-gray-200">
                                            {{ __('Departamentos') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('validador-tablas.index')" class="text-gray-700 hover:bg-gray-200">
                                            {{ __('Validador') }}
                                        </x-dropdown-link>
                                     
                                </x-slot>
                            </x-dropdown>
                            @endif
                        </div>

                        <!-- Dropdown Archivos -->
                        <div class="relative">
                            <x-dropdown align="left">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out bg-transparent border border-transparent rounded-md hover:text-gray-300 focus:outline-none">
                                        <div>{{ __('Archivos') }}</div>
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    @role('lider')
                                    <x-dropdown-link :href="route('upload.form')" class="text-gray-700 hover:bg-gray-200">
                                        {{ __('Subir datos') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('importaciones.historial')" class="text-gray-700 hover:bg-gray-200">
                                        {{ __('Historial Importaciones') }}
                                    </x-dropdown-link>
                                    @endrole
                                    @role('validador')
                                        <x-dropdown-link :href="route('importaciones.validar')" class="text-gray-700 hover:bg-gray-200">
                                            {{ __('Validar Importaciones') }}
                                        </x-dropdown-link>
                                    @endrole
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sección derecha: Usuario -->
            @if (Auth::check())
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <!-- Mostrar link de iniciar sesión si no está logueado -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <a href="{{ route('login') }}" class="text-sm underline">Iniciar Sesión</a>
                </div>
            @endif

            <!-- Hamburger Menu -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>
        @if(Auth::check())
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    
                    @if(Auth::user()->hasRole('administrador'))
                            <x-responsive-nav-link :href="route('empleados.index')" :active="request()->routeIs('empleados.index')" class="">
                            {{ __('Gestionar Usuarios') }}
                            </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->hasRole('lider'))
                            <x-responsive-nav-link :href="route('upload.form')" :active="request()->routeIs('upload.form')" class="">
                            {{ __('subir Datos') }}
                            </x-responsive-nav-link>
                    @endif
                    @if (Auth::user()->hasAnyRole(['administrador', 'lider']))
                            <x-responsive-nav-link :href="route('importaciones.historial')" :active="request()->routeIs('importaciones.historial')" class="">
                            {{ __('Importaciones') }}
                            </x-responsive-nav-link>
                    @endif
                    

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <!-- Mostrar link de iniciar sesión si no está logueado en menú responsive -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <x-responsive-nav-link :href="route('login')" class="">
                    {{ __('Iniciar Sesión') }}
                </x-responsive-nav-link>
            </div>
        @endif
    </div>
</nav>
