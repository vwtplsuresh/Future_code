<x-operator-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="px-4 py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if($locations && $locations != null && count($locations) > 0)
            <div class="mb-4 row">
                @foreach ($locations as $location)
                <div class="mb-2 col-xl-3 col-lg-6">
                    <div class="card l-bg-info">
                        <div class="p-4 card-statistic-3">
                            <div class="card-icon card-icon-large d-flex">
                                <<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                            </div>
                            <div class="mb-4">
                                <a href="{{ route('admin.locations.show', $location->id) }}">
                                    <h5 class="mb-0 text-xl card-title text-bold">{{ $location->title }}</h5>
                                </a>
                            </div>
                            <div class="mb-2 row align-items-center d-flex">
                                <div class="col-8">
                                    <h2 class="mb-0 d-flex align-items-center ">
                                        {{ count($location->units) }} Units
                                    </h2>
                                </div>
                                <div class="text-right col-4">
                                    <span>{{ count($location->zones) }} Zone</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="mb-4 row">
                <div class="mb-6 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div id="bar-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="mb-6 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="">
                                <table class="table table-sm table-bordered" id="">
                                    <thead class="text-primary">
                                        <tr>
                                            <th scope="col">Location</th>
                                            <th scope="col">Zone</th>
                                            <th scope="col">Total Units</th>
                                            <th scope="col">Online</th>
                                            <th scope="col">Offline</th>
                                            <th scope="col">Zone Flow Limit</th>
                                            <th scope="col">Zone Total Flow</th>
                                            <th scope="col">Location Flow Limit</th>
                                            <th scope="col">Location Total Flow</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($allData) && count($allData) > 0)
                                        @foreach ($allData as $locationData)
                                        @php
                                        $i = 0;
                                        $zones = $locationData['zones'] ?? [];
                                        @endphp
                                        @foreach ($zones as $zoneData)
                                        <tr>
                                            @if($i == 0)
                                            <td rowspan="{{ count($zones) }}">{{ $locationData['location_title'] }}</td>
                                            @endif
                                            <td>{{ $zoneData['zone_title'] }}</td>
                                            <td>{{ $zoneData['total_units'] }}</td>
                                            <td>{{ $zoneData['total_online_units'] }}</td>
                                            <td>{{ $zoneData['total_offline_units'] }}</td>
                                            <td>{{ $zoneData['total_flow_limit'] }}</td>
                                            <td>{{ $zoneData['total_today_flow'] }}</td>
                                            @if($i == 0)
                                            <td rowspan="{{ count($zones) }}">{{ $locationData['total_flow_limit'] }}</td>
                                            @endif
                                            @if($i == 0)
                                            <td rowspan="{{ count($zones) }}">{{ $locationData['total_today_flow'] }}</td>
                                            @endif
                                        </tr>
                                        @php
                                        $i++;
                                        @endphp
                                        @endforeach
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="9">
                                                No data found !
                                            </td>
                                        </tr>
                                        @endif

                                    </tbody>
                                    <tfoot class="text-info">
                                        <tr>
                                            <th scope="col">{{ $totals['total_locations'] }}</th>
                                            <th scope="col">{{ $totals['total_zones'] }}</th>
                                            <th scope="col">{{ $totals['total_units'] }}</th>
                                            <th scope="col">{{ $totals['total_online_units'] }}</th>
                                            <th scope="col">{{ $totals['total_offline_units'] }}</th>
                                            <th scope="col">{{ $totals['total_flow_limit'] }}</th>
                                            <th scope="col">{{ $totals['total_today_flow'] }}</th>
                                            <th scope="col">{{ $totals['total_flow_limit'] }}</th>
                                            <th scope="col">{{ $totals['total_today_flow'] }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            barChart();

            $(window).resize(function() {
                window.barChart.redraw();
            });
        });


        function barChart() {
            let data = @php echo $chartData @endphp;
            console.log({
                data
            });
            window.barChart = Morris.Bar({
                element: 'bar-chart'
                , data: data
                , xkey: 'y'
                , ykeys: ['a', 'b']
                , labels: ['Online', 'Offline']
                , barColors: ['#6ec57d', '#f98c8c']
                , lineWidth: '3px'
                , resize: true
                , redraw: true
                , barSizeRatio: 0.20
            });
        }

    </script>
</x-operator-layout>
