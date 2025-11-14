<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="post" action="{{ route('admin.units.update', $unit->id) }}">
                        @csrf
                        @method("PUT")
                        <div class="row">
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="user_id" :value="__('User')" />
                                <select class="form-control  mt-1" id="user_id" name="user_id">
                                    <option value="">User</option>
                                    @if (!empty($users) && count($users) > 0)
                                    @foreach ($users as $user)
                                    <option @if ($unit->user_id == $user->id) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="location_id" :value="__('Location')" />
                                <select class="form-control  mt-1" id="location_id" name="location_id">
                                    <option value="">Location</option>
                                    @if (!empty($locations) && count($locations) > 0)
                                    @foreach ($locations as $location)
                                    <option @if ($unit->location_id == $location->id) selected @endif value="{{$location->id}}">{{$location->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="zone_id" :value="__('Zone')" />
                                <select class="form-control  mt-1" id="zone_id" name="zone_id">
                                    <option value="" data-location="">Zone</option>
                                    @if (!empty($zones) && count($zones) > 0)
                                    @foreach ($zones as $zone)
                                    <option @if ($unit->zone_id == $zone->id) selected @endif value="{{$zone->id}}" style="display:none;" data-location={{ $zone->location_id }}>{{$zone->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('zone_id')" class="mt-2" />
                            </div>
                        </div>
                        <div class="row">
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="panel_no" :value="__('Panel No.')" />
                                <x-text-input id="panel_no" class="block mt-1 w-full" type="text" name="panel_no" :value="old('panel_no', $unit->panel_no)" placeholder="Unit Panel No." />
                                <x-input-error :messages="$errors->get('panel_no')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $unit->title)" placeholder="Unit Name" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="address" :value="__('Address')" />
                                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address', $unit->address)" placeholder="Unit Address" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="operator_name" :value="__('Operator Name')" />
                                <x-text-input id="operator_name" class="block mt-1 w-full" type="text" name="operator_name" placeholder="Full Name" :value="old('operator_name', $unit->operator_name)" />
                                <x-input-error :messages="$errors->get('operator_name')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="operator_mobile" :value="__('Operator Mobile')" />
                                <x-text-input id="operator_mobile" class="block mt-1 w-full" type="text" placeholder="example:12345789" name="operator_mobile" :value="old('operator_mobile', $unit->operator_mobile)" />
                                <x-input-error :messages="$errors->get('operator_mobile')" class="mt-2" />
                            </div>
                        </div>

                        <hr>

                        <div class="row mt-3">
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="total_limit" :value="__('Total Limit (KLD)')" />
                                <x-text-input id="total_limit" class="block mt-1 w-full" type="text" placeholder="0.00" name="total_limit" :value="old('total_limit', $unit->total_limit)" />
                                <x-input-error :messages="$errors->get('total_limit')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="today_limit" :value="__('Today Limit (%)')" />
                                <x-text-input id="today_limit" class="block mt-1 w-full" type="text" placeholder="100" help="Today limit will be in %" name="today_limit" :value="old('today_limit', $unit->today_limit)" />
                                <x-input-error :messages="$errors->get('today_limit')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="plc_reset" :value="__('PLC Reset')" />
                                <select class="form-control  mt-1" id="plc_reset" name="plc_reset">
                                    <option @if($unit->plc_reset == 0) selected @endif value="0" >Off</option>
                                    <option @if($unit->plc_reset == 1) selected @endif value="1" >On</option>
                                </select>
                                <x-input-error :messages="$errors->get('plc_reset')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="panel_lock" :value="__('Panel Lock')" />
                                <select class="form-control  mt-1" id="panel_lock" name="panel_lock">
                                    <option @if($unit->panel_lock == 0) selected @endif value="0" >Unlock</option>
                                    <option @if($unit->panel_lock == 1) selected @endif value="1" >Lock</option>
                                </select>
                                <x-input-error :messages="$errors->get('panel_lock')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="reset_totalizer" :value="__('Reset Totalizer')" />
                                <select class="form-control  mt-1" id="reset_totalizer" name="reset_totalizer">
                                    <option value="0" @if($unit->reset_totalizer == 0) selected @endif>Off</option>
                                    <option value="1" @if($unit->reset_totalizer == 1) selected @endif>On</option>
                                </select>
                                <x-input-error :messages="$errors->get('reset_totalizer')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="reset_memory" :value="__('Reset Memory')" />
                                <select class="form-control  mt-1" id="reset_memory" name="reset_memory">
                                    <option value="0" @if($unit->reset_memory == 0) selected @endif>Off</option>
                                    <option value="1" @if($unit->reset_memory == 1) selected @endif>On</option>
                                </select>
                                <x-input-error :messages="$errors->get('reset_memory')" class="mt-2" />
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="panel_unlock_timing" :value="__('Panel Un-lock Timings')" />
                                <x-text-input id="panel_unlock_timing" class="block mt-1 w-full" type="text" name="panel_unlock_timing" placeholder="06-09,14-16,22-00" :value="old('panel_unlock_timing', optional($unit->time)->fixed_time)" />
                                <x-input-error :messages="$errors->get('panel_unlock_timing')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="panel_unlock_dates" :value="__('Panel Un-lock Dates')" />
                                <x-text-input id="panel_unlock_dates" class="block mt-1 w-full" type="text" name="panel_unlock_dates" placeholder="02,08,12,20,25" :value="old('panel_unlock_dates', $unit->panel_unlock_dates)" />
                                <x-input-error :messages="$errors->get('panel_unlock_dates')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="mode" :value="__('TDS Reset')" />
                                <select class="form-control  mt-1" id="mode" name="mode">
                                    {{-- <option value="0" @if($unit->mode == 0) selected @endif>Auto</option>
                                    <option value="1" @if($unit->mode == 1) selected @endif>Manual</option> --}}
                                    <option value="0" @if($unit->mode == 0) selected @endif>TDS Off</option>
                                    <option value="1" @if($unit->mode == 1) selected @endif>TDS On</option>
                                </select>
                                <x-input-error :messages="$errors->get('mode')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="pipe_size" :value="__('Pipe Size')" />
                                <x-text-input id="pipe_size" class="block mt-1 w-full" type="text" placeholder="0.00" name="pipe_size" :value="old('pipe_size', $unit->pipe_size)" />
                                <x-input-error :messages="$errors->get('pipe_size')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-2 col-lg-2 col-xl-2">
                                <x-input-label for="tds_bit" :value="__('TDS Bit')" />
                                <select class="form-control  mt-1" id="tds_bit" name="tds_bit">
                                    <option value="0" @if($unit->tds_bit == 0) selected @endif>OFF</option>
                                    <option value="1" @if($unit->tds_bit == 1) selected @endif>ON</option>
                                </select>
                                <x-input-error :messages="$errors->get('tds_bit')" class="mt-2" />
                            </div>
                        </div>

                        <div class="row mt-3">

                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="min_tds" :value="__('Minimum TDS limit')" />
                                <x-text-input id="min_tds" class="block mt-1 w-full" type="number" name="min_tds" placeholder="0" :value="old('min_tds', number_format((float)$unit->min_tds, 2, '.', ''))" />
                                <x-input-error :messages="$errors->get('min_tds')" class="mt-2" />
                            </div>

                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="max_tds" :value="__('Maximum TDS limit')" />
                                <x-text-input id="max_tds" class="block mt-1 w-full" type="number" name="max_tds" placeholder="0" :value="old('max_tds', number_format((float)$unit->max_tds, 2, '.', ''))" />
                                <x-input-error :messages="$errors->get('max_tds')" class="mt-2" />
                            </div>

                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="cto" :value="__('CTO')" />
                                <x-text-input id="cto" class="block mt-1 w-full" type="text" name="cto" placeholder="CTO" :value="old('cto', $unit->cto)" />
                                <x-input-error :messages="$errors->get('cto')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-12 col-xs-12 col-md-3 col-lg-3 col-xl-3">
                                <x-input-label for="cto_remark" :value="__('CTO Remark')" />
                                <x-textarea id="cto_remark" class="block mt-1 w-full" type="text" name="cto_remark" placeholder="CTO Remark" :value="old('cto_remark', $unit->cto_remark)"></x-textarea>
                                <x-input-error :messages="$errors->get('cto_remark')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('UPDATE') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        const zones = document.querySelector("#zone_id");
        const locations = document.querySelector("#location_id");

        locations.addEventListener('change', function() {
            let location_id = locations.value;
            let options = zones.querySelectorAll('option');
            options.forEach(option => {
                if (option.dataset.location == location_id) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none"
                }
            });
            options[0].style.display = "block";
            zones.selectedIndex = 0;
        });

        document.addEventListener('DOMContentLoaded', function() {
            let location_id = locations.value;
            let options = zones.querySelectorAll('option');
            let selected = 0;
            options.forEach((option, index) => {
                if (option.dataset.location == location_id) {
                    option.style.display = "block";
                } else {
                    option.style.display = "none"
                }

                if (option.getAttribute('selected') != null) {
                    selected = index;
                }
            });
            options[0].style.display = "block";
            zones.selectedIndex = selected;
        });

    </script>
</x-admin-layout>
