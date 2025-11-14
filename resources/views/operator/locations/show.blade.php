<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Location') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto mb-4 max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ $location->title }}</h2>
                    <hr class="mt-2 mb-4">
                    @if($location->zones && $location->zones != null && count($location->zones) > 0)
                    @foreach ($location->zones as $zone)
                    <a href="{{ route('operator.zones.show', $zone->id) }}" class="btn btn-primary"> {{ $zone->title }} </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">Units</h2>
                    <hr class="mt-2 mb-4">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Alarm</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Zone</th>
                                    <th scope="col">Limit (KLD)</th>
                                    <th scope="col">TF (KLD)</th>
                                    <th scope="col">YF (KLD)</th>
                                    <th scope="col">Last Ping</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($units) && count($units) > 0)
                                @foreach ($units as $unit)
                                <tr class="@if(date("Y-m-d", strtotime($unit->liveData->updated_at)) == date("Y-m-d")) text-success @else text-danger @endif">
                                    <td>
                                        {{ $loop->index +1 }}
                                        @if($unit->alarm != null && $unit->alarm->ping_error)
                                        <span class="text-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                                <path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
                                                <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
                                            </svg>

                                        </span>
                                        @endif
                                    </td>
                                    <td>{{ $unit->id }}</td>
                                    <td>
                                        @if ($unit->alarm != null)
                                        <x-tooltip id="{{ $unit->id }}" :alarms="$unit->alarm" />
                                        @endif
                                    </td>
                                    <td>{{ $unit->user->name }}</td>
                                    <td>{{ $unit->title }}</td>
                                    <td>{{ $unit->address }}</td>
                                    <td>{{ $unit->zone->title }}</td>
                                    <td>{{ $unit->total_limit }}</td>
                                    <td>{{ $unit->liveData->today_flow }}</td>
                                    <td>{{ $unit->yesterdayFlow == null ? '-' : $unit->yesterdayFlow->net_flow }}</td>
                                    <td>{{ $unit->liveData->updated_at }}</td>
                                    {{-- <td class="text-right">
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                                            <div class="ml-1">
                                                                <img src="{{ asset('assets/img/three-dots.svg')}}" />
                    </div>
                    </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.units.edit', $unit->id )">
                            {{ __('Edit') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.units.show', $unit->id )">
                            {{ __('View') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" id="delete-form" action="{{ route('admin.units.destroy', $unit->id ) }}">
                            @csrf
                            @method('DELETE')
                            <x-dropdown-link :href="route('admin.units.destroy', $unit->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                    </x-dropdown>
                    </td> --}}
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">
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
