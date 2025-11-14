<x-admin-layout>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Single Unit Monthly Flow') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form class="form" action="{{ route('admin.reports.get.singleUnitMonthlyFlow') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-md-3 col-lg-3 col-sm-12 form-group">
                                <x-input-label for="location" :value="__('Location')" />
                                <select class="mt-1 form-control" id="locations" name="location">
                                    <option value="">Location</option>
                                    @if (!empty($locations) && count($locations) > 0)
                                        @foreach ($locations as $location)
                                        <option value="{{$location->id}}">{{$location->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <div class="mb-2 col-md-3 col-lg-3 col-sm-12 form-group">
                                <x-input-label for="zone" :value="__('Zone')" />
                                <select class="mt-1 form-control" id="zones" name="zone">
                                    <option value="">Zone</option>
                                    @if (!empty($zones) && count($zones) > 0)
                                        @foreach ($zones as $zone)
                                        <option value="{{$zone->id}}" style="display: none;" data-location={{ $zone->location_id }}>{{$zone->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('zone')" class="mt-2" />
                            </div>
                            <div class="mb-2 col-md-3 col-lg-3 col-sm-12 form-group">
                                <x-input-label for="unit" :value="__('Unit')" />
                                <select class="mt-1 form-control" id="units" name="unit">
                                    <option value="">Unit</option>
                                    @if (!empty($units) && count($units) > 0)
                                        @foreach ($units as $unit)
                                        <option value="{{$unit->id}}" style="display: none;" data-zone={{ $unit->zone_id }}>{{$unit->title}} ({{ $unit->address }})</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            </div>
                            <div class="mb-2 col-md-3 col-lg-3 col-sm-12 form-group">
                                <x-input-label for="month" :value="__('Month')" />
                                <x-text-input id="month" class="block w-full mt-1" type="month" name="month" min="{{ (date('Y')-1) }}-{{ date('m') }}" max="{{ date('Y-m') }}" :value="old('month')" />
                                <x-input-error :messages="$errors->get('month')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Search') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @if (!empty($report))
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <x-primary-button class="ml-3" onclick="htmlTableToExcel('xlsx')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Download Report
                    </x-primary-button>
                    <hr class="my-2">
                    <div class="wrapper1">
                        <div class="div1"></div>
                    </div>
                    <div class="wrapper2">
                        <div class="table-responsive div2">
                            <table class="table table-sm " id="report-table">
                                <thead class=" text-primary" style="font-size: 12px;">
                                    <tr>
                                        <th scope="col">Unit</th><td scope="col" colspan="2">{{ $report->title }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Loction</th><td scope="col" colspan="2">{{ $report->location->title }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Zone</th><td scope="col" colspan="2">{{ $report->zone->title }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Address</th><td scope="col" colspan="2">{{ $report->address }}</td>
                                    </tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Flow</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($report->report_data as $flow)
                                        <tr>
                                            <td>
                                                {{ $loop->index +1 }}
                                            </td>
                                            <td>{{ $flow->created_at }}</td>
                                            <td>{{ $flow->net_flow }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        const zones = document.querySelector("#zones");
        const locations = document.querySelector("#locations");
        const units = document.querySelector("#units");

        locations.addEventListener('change', function(){
            let location_id = locations.value;
            let options = zones.querySelectorAll('option');
            options.forEach(option => {
                if(option.dataset.location == location_id){
                    option.style.display = "block";
                }else{
                    option.style.display = "none"
                }
            });
            options[0].style.display = "block";
            zones.selectedIndex = 0;
            units.selectedIndex = 0;
        });

        zones.addEventListener('change', function(){
            let zone_id = zones.value;
            let options=units.querySelectorAll('option');
            options.forEach(option => {
                if(option.dataset.zone == zone_id){
                    option.style.display = "block";
                }else{
                    option.style.display = "none"
                }
            });
            options[0].style.display = "block";
            units.selectedIndex = 0;
        });

        function htmlTableToExcel(type){
            var data = document.getElementById('report-table');
            var excelFile = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(excelFile, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(excelFile, 'ExportedFile:HTMLTableToExcel.' + type);
        }

        document.addEventListener('DOMContentLoaded', function () {
            const wrapper1 = document.querySelector('.wrapper1');
            const wrapper2 = document.querySelector('.wrapper2');
            const div1 = document.querySelector('.div1');
            const div2 = document.querySelector('.div2');
            const table = document.querySelector('table');

            // Scroll synchronization
            wrapper1?.addEventListener('scroll', function (e) {
                wrapper2.scrollLeft = wrapper1.scrollLeft;
            });

            wrapper2?.addEventListener('scroll', function (e) {
                wrapper1.scrollLeft = wrapper2.scrollLeft;
            });

            // Width synchronization on window load
            window.addEventListener('load', function (e) {
                if(div1) div1.style.width = table.offsetWidth + 'px';
                if(div2) div2.style.width = table.offsetWidth + 'px';
            });
        });

        const table = document.querySelector(`#report-table`);

        function tableSum(){
            const rows = table.querySelectorAll('tbody tr');
            const columns = table.querySelectorAll('tbody tr td');
            const tableFooter = table.querySelector('tfoot');
            const totalTr = createTr();
            const totalTrth = createTh('Total', 'text-right', 'colspan', 2);

            totalTr.appendChild(totalTrth);

            for(let c=1;c<2;c++){
                let sum = 0;
                for(r=0;r<rows.length;r++){
                    let thv = rows[r].querySelector(`td:nth-child(3)`).textContent;
                    if(!isNaN(thv))sum = sum + Number(thv);
                }
                let th = createTh(sum.toFixed(2));
                totalTr.appendChild(th);
            }

                tableFooter.appendChild(totalTr);

        }

        function createTr(){
            return document.createElement('tr');
        }

        function createTh(content, cls=null, atr=null, atrv=null){
            let th = document.createElement('th');
            th.textContent = content;
            if(cls !== null) th.classList.add(cls);
            if(atr !== null && atrv !== null) th.setAttribute(atr, atrv);
            return th;
        }



        if(table){
            tableSum();
        }

    </script>
</x-admin-layout>
