<x-admin-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Locations') }}
            <x-a-button :href="route('admin.locations.create')" >Create New Location</x-a-button>
            {{-- <a href="{{ route('admin.locations.create') }}" class="inline-block px-4 py-2 text-black bg-blue-600 rounded hover:bg-blue-700">
                Create New Location
            </a> --}}
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
                                    <th scope="col">Location</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($locations) && count($locations) > 0)
                                @foreach ($locations as $location)
                                <tr>
                                    <td>
                                        {{ $loop->index +1 }}
                                    </td>
                                    <td>{{ $location->title }}</td>
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
                                                <x-dropdown-link :href="route('admin.locations.edit', $location->id )">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>

                                                <x-dropdown-link :href="route('admin.locations.show', $location->id )">
                                                    {{ __('View') }}
                                                </x-dropdown-link>

                                                <!-- Authentication -->
                                                <form method="POST" id="delete-form" action="{{ route('admin.locations.destroy', $location->id ) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-dropdown-link :href="route('admin.locations.destroy', $location->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="3">
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
        document.querySelectorAll('form#delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure ! you want to delete this.')) form.submit();
            });
        });

    </script>
</x-admin-layout>
