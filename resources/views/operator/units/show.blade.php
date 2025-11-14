<x-operator-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto mb-4 max-w-7xl sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                {{ $unit->title }}
                                <div>
                                    @can('view location')<a href="{{ route('operator.locations.show', $unit->location->id) }}" class="btn btn-primary"> {{ $unit->location->title }} </a>@endcan
                                    @can('view zone')<a href="{{ route('operator.zones.show', $unit->zone->id) }}" class="btn btn-primary"> {{ $unit->zone->title }} </a>@endcan
                                </div>
                            </h2>
                            <hr class="mt-2 mb-4">
                            <div class="">
                                <table class="table table-borderless">
                                    <tr>
                                        <th class="mw-50">Panel No. :</th>
                                        <td class="text-left">{{ $unit->panel_no }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Address :</th>
                                        <td class="text-left">{{ $unit->address }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Limit (KLD) :</th>
                                        <td class="text-left">{{ $unit->total_limit }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Current Flow (KLD):</th>
                                        <td class="text-left">{{ $unit->liveData->current_flow }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Today Flow (KLD):</th>
                                        <td class="text-left">{{ $unit->liveData->today_flow }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Totalizer (KLD):</th>
                                        <td class="text-left">{{ $unit->liveData->totalizer }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">RVC Limit:</th>
                                        <td class="text-left">{{ $unit->liveData->kld_limit_send }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">RTC Limit:</th>
                                        <td class="text-left">{{ $unit->liveData->rtc_hh }}-{{ $unit->liveData->rtc_mm }}</td>
                                    </tr>

                                    <tr>
                                        <th class="mw-50">Last Ping :</th>
                                        <td class="text-left">{{ date('Y-m-d h:i:s', strtotime($unit->liveData->updated_at)) }}</td>
                                    </tr>

                                    {{-- <tr>
                                        <th class="mw-50">TDS Bit</th>
                                        <td class="text-left">{{ $unit->tds_bit == 1 ? "ON" : "OFF" }}</td>
                                    </tr>

                                    <tr>
                                        <th class="mw-50">Minimum TDS Limit :</th>
                                        <td class="text-left">{{ number_format((float)$unit->min_tds, 2, '.', '') }}</td>
                                    </tr>

                                    <tr>
                                        <th class="mw-50">Maximun TDS Limit :</th>
                                        <td class="text-left">{{ number_format((float)$unit->max_tds, 2, '.', '') }}</td>
                                    </tr> --}}

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                Unit Status
                            </h2>
                            <hr class="mt-2 mb-4">
                            <div class="flex-wrap d-inline-flex w-100">

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="emergency_stop_status" value="{{ !$unit->liveData->emergency_stop_status }}" />
                                    <button class="btn @if($unit->liveData->emergency_stop_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Emergency Stop</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="door_limit_switch_status" value="{{ !$unit->liveData->door_limit_switch_status }}" />
                                    <button class="btn @if($unit->liveData->door_limit_switch_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Door Limit Switch</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="overload_status" value="{{ !$unit->liveData->overload_status }}" />
                                    <button class="btn @if($unit->liveData->overload_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Overload</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="pump_status" value="{{ !$unit->liveData->pump_status }}" />
                                    <button class="btn @if($unit->liveData->pump_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Pump</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="auto_manual" value="{{ !$unit->liveData->auto_manual }}" />
                                    <button class="btn @if($unit->liveData->auto_manual == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Auto/Manual</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="panel_lock_status" value="{{ !$unit->liveData->panel_lock_status }}" />
                                    <button class="btn @if($unit->panel_lock_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Panel Lock</button>
                                </form>

                                {{-- <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="fc_50" value="{{ !$unit->liveData->fc_50 }}" />
                                <button class="btn @if($unit->liveData->fc_50 == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">FC-50</button>
                                </form>

                                <form class="max-w-2xl m-2" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="fc_50" value="{{ !$unit->liveData->emergency_stop_status }}" />
                                    <button class="btn @if($unit->liveData->auto_manual == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Level</button>
                                </form> --}}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">User</h2>
                            <hr class="mt-2 mb-4">
                            <div class="">
                                <table class="table table-borderless">
                                    <tr>
                                        <th class="mw-50 w-25">Name :</th>
                                        <td class="text-left">{{ $unit->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50 w-25">Email :</th>
                                        <td class="text-left">{{ $unit->user->email }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                Flow History
                            </h2>
                            <hr class="mt-2 mb-4">
                            <div class="">
                                <table class="table table-sm " id="">
                                    <thead class=" text-primary">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Flow(KLD)</th>
                                            <th scope="col">Date</th>
                                            {{-- <th scope="col"></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($unit->monthlyFlow) && count($unit->monthlyFlow) > 0)
                                        @foreach ($unit->monthlyFlow as $monthlyFlow)
                                        <tr>
                                            <td>
                                                {{ $loop->index +1 }}
                                            </td>
                                            <td>{{ $monthlyFlow->net_flow }}</td>
                                            <td>{{ date('M d Y', strtotime($monthlyFlow->created_at)) }}</td>
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
                                <x-dropdown-link :href="route('operator.units.edit', $unit->id )">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('operator.units.show', $unit->id )">
                                    {{ __('View') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" id="delete-form" action="{{ route('operator.units.destroy', $unit->id ) }}">
                                    @csrf
                                    @method('DELETE')
                                    <x-dropdown-link :href="route('operator.units.destroy', $unit->id)" onclick="event.preventDefault(); this.closest('form').submit();">
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

    </div>
    </div>
    <script>
        document.querySelectorAll('form#update-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure ! you want to update this.')) form.submit();
            });
        });

    </script>
</x-operator-layout>
