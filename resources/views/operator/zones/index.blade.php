<x-operator-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Zones') }}
            @can('create zone')
            <x-a-button :href="route('operator.zones.create')" >Create New Zone</x-a-button>
            @endcan
        </h2>
    </x-slot>



    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Zone</th>
                                    <th scope="col">Location</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($zones) && count($zones) > 0)
                                @foreach ($zones as $zone)
                                        <tr>
                                            <td>
                                                {{ $loop->index +1 }}
                                            </td>
                                            <td>{{ $zone->title }}</td>
                                            <td>{{ $zone->location->title }}</td>
                                            <td class="text-right">
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                                            <div class="ml-1">
                                                                <img src="{{ asset('assets/img/three-dots.svg')}}" />
                                                            </div>
                                                        </button>
                                                    </x-slot>

                                                    <x-slot name="content">
                                                        @can('edit zone')
                                                        <x-dropdown-link :href="route('operator.zones.edit', $zone->id )">
                                                            {{ __('Edit') }}
                                                        </x-dropdown-link>
                                                        @endcan
                                                        @can('view zone')
                                                        <x-dropdown-link :href="route('operator.zones.show', $zone->id )">
                                                            {{ __('View') }}
                                                        </x-dropdown-link>
                                                        @endcan
                                                        @can('delete zone')
                                                        <!-- Authentication -->
                                                        <form method="POST" id="delete-form" action="{{ route('operator.zones.destroy', $zone->id ) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <x-dropdown-link :href="route('operator.zones.destroy', $zone->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                                {{ __('Delete') }}
                                                            </x-dropdown-link>
                                                        </form>
                                                        @endcan
                                                    </x-slot>
                                                </x-dropdown>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            No data found !
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('form#delete-form').forEach( form => {
            form.addEventListener('submit', function(e){
                e.preventDefault();
                if(confirm('Are you sure ! you want to delete this.'))form.submit();
            });
        });
    </script>
</x-operator-layout>

