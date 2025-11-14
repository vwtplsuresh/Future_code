<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
            @include('layouts.alerts.success')
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                                {{ $unit->title }}

                                <div>
                                    <a href="{{ route('admin.locations.show', $unit->location->id) }}" class="btn btn-primary"> {{ $unit->location->title }} </a>
                                    <a href="{{ route('admin.zones.show', $unit->zone->id) }}" class="btn btn-primary"> {{ $unit->zone->title }} </a>
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
                                        <th class="mw-50">Today Flow  (KLD):</th>
                                        <td class="text-left">{{ $unit->liveData->today_flow }}</td>
                                    </tr>
                                    <tr>
                                        <th class="mw-50">Totalizer  (KLD):</th>
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

                                    <tr>
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
                                    </tr>
				    {{-- @if($unit->alarm->ping_error)  
				    <tr>
					<th>Ping Error :</th>
					<td>
					  <span class="text-danger">
					    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
  						<path d="M5.85 3.5a.75.75 0 0 0-1.117-1 9.719 9.719 0 0 0-2.348 4.876.75.75 0 0 0 1.479.248A8.219 8.219 0 0 1 5.85 3.5ZM19.267 2.5a.75.75 0 1 0-1.118 1 8.22 8.22 0 0 1 1.987 4.124.75.75 0 0 0 1.48-.248A9.72 9.72 0 0 0 19.266 2.5Z" />
  						<path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 0 0 5.25 9v.75a8.217 8.217 0 0 1-2.119 5.52.75.75 0 0 0 .298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 1 0 7.48 0 24.583 24.583 0 0 0 4.83-1.244.75.75 0 0 0 .298-1.205 8.217 8.217 0 0 1-2.118-5.52V9A6.75 6.75 0 0 0 12 2.25ZM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 0 0 4.496 0l.002.1a2.25 2.25 0 1 1-4.5 0Z" clip-rule="evenodd" />
					    </svg>

					   </span> 
					</td>
				    </tr>
				    @endif --}}
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                                Unit Status
                            </h2>
                            <hr class="mt-2 mb-4">
                            <div class="d-inline-flex flex-wrap w-100">

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="emergency_stop_status" value="{{ !$unit->liveData->emergency_stop_status }}" />
                                    <button class="btn @if($unit->liveData->emergency_stop_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Emergency Stop</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="door_limit_switch_status" value="{{ !$unit->liveData->door_limit_switch_status }}" />
                                    <button class="btn @if($unit->liveData->door_limit_switch_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Door Limit Switch</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="overload_status" value="{{ !$unit->liveData->overload_status }}" />
                                    <button class="btn @if($unit->liveData->overload_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Overload</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="pump_status" value="{{ !$unit->liveData->pump_status }}" />
                                    <button class="btn @if($unit->liveData->pump_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Pump</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="auto_manual" value="{{ !$unit->liveData->auto_manual }}" />
                                    <button class="btn @if($unit->liveData->auto_manual == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Auto/Manual</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="panel_lock_status" value="{{ !$unit->liveData->panel_lock_status }}" />
                                    <button class="btn @if($unit->panel_lock_status == 0) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Panel Lock</button>
                                </form>

                                {{-- <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="fc_50" value="{{ !$unit->liveData->fc_50 }}" />
                                    <button class="btn @if($unit->liveData->fc_50 == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">FC-50</button>
                                </form>

                                <form class="m-2 max-w-2xl" method="POST" id="update-form" action="">
                                    @csrf
                                    <input type="hidden" name="fc_50" value="{{ !$unit->liveData->emergency_stop_status }}" />
                                    <button class="btn @if($unit->liveData->auto_manual == 1) btn-danger @else btn-success @endif" onclick="event.preventDefault(); this.closest('form').submit();">Level</button>
                                </form> --}}

                            </div>
                            @if ($unit->alarm != null)
                                <h2 class="mt-4 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
                                    Alarms
                                </h2>
                                <hr class="my-2">
                                <ul class="list-none text-rose-500 p-2 text-red-500 w-full">
                                    @if($unit->alarm->emergency_stop_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->emergency_stop_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->door_limit_switch_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->door_limit_switch_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->current_flow_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->current_flow_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->emergency_stop_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->emergency_stop_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->today_flow_stop_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->today_flow_stop_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->overload_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->overload_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->pump_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->pump_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->tank_level_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->tank_level_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->tank_level_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->tank_level_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->output_value_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->output_value_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->pipe_size_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->pipe_size_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->totalizer_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->totalizer_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->panel_lock_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->panel_lock_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->auto_manual_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->auto_manual_alarm_message }}</li>
                                    @endif
                                    @if($unit->alarm->kld_limit_send_alarm_status)
                                        <li style="color:rgb(240, 58, 58);">- {{ $unit->alarm->kld_limit_send_alarm_message }}</li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">User</h2>
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

                    <div class="mb-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
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
        document.querySelectorAll('form#update-form').forEach( form => {
            form.addEventListener('submit', function(e){
                e.preventDefault();
                if(confirm('Are you sure ! you want to update this.'))form.submit();
            });
        });
    </script>
</x-admin-layout>
