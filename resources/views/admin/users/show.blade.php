<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $user->name }}</h2>
                    <hr class="mt-2 mb-4">

                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-lg text-gray-800 dark:text-gray-200 leading-tight">Units</h2>
                    <hr class="mt-2 mb-4">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Alarms</th>
                                    <th scope="col">Panel No.</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Location/Zone</th>
                                    <th scope="col">Addrss</th>
                                    {{-- <th scope="col">PH</th>
                                    <th scope="col">TDS</th> --}}
                                    <th scope="col">CF (KLD)</th>
                                    <th scope="col">YF (KLD)</th>
                                    <th scope="col">TF (KLD)</th>
                                    <th scope="col">Totalizer (KLD)</th>
                                    <th scope="col">Last Ping</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($user->units) && count($user->units) > 0)
                                @foreach ($user->units as $unit)
                                <tr>
                                    <td>
                                        {{ $loop->index +1 }}
                                    </td>
                                    <td>{{ $unit->id }}</td>
                                    <td>
                                        @if ($unit->alarm != null)
                                        <x-tooltip id="{{ $unit->id }}" :alarms="$unit->alarm" />
                                        @endif
                                    </td>
                                    <td>{{ $unit->panel_no }}</td>
                                    <td>{{ $unit->user->name }}</td>
                                    <td>{{ $unit->title }}</td>
                                    <td>{{ $unit->location->title }} / {{ $unit->zone->title }}</td>
                                    <td>{{ $unit->address }}</td>
                                    {{-- <td>{{ $unit->liveData->ph }}</td>
                                    <td>{{ $unit->liveData->tds }}</td> --}}
                                    <td>{{ $unit->liveData->current_flow }}</td>
                                    <td>0</td>
                                    <td>{{ $unit->liveData->today_flow }}</td>
                                    <td>{{ $unit->liveData->totalizer }}</td>
                                    <td>{{ $unit->liveData->updated_at }}</td>
                                    <td class="text-right">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
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
                                    </td>
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
