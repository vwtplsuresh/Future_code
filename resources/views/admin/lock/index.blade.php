<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.lock.update') }}">
                        @csrf
                        <div class="row">
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="location_id" :value="__('Location')" />
                                <select class="form-control  mt-1" id="location_id" name="location_id">
                                    <option selected disabled>Select Location</option>
                                    @if (!empty($locations) && count($locations) > 0)
                                    @foreach ($locations as $location)
                                    <option value="{{$location->id}}">{{$location->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location_id')" class="mt-2" />
                            </div>

                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="zone_id" :value="__('Zone')" />
                                <select class="form-control  mt-1" id="zone_id" name="zone_id">
                                    <option selected disabled>Select Zone</option>
                                    @if (!empty($zones) && count($zones) > 0)
                                    @foreach ($zones as $zone)
                                    <option value="{{$zone->id}}" style="display: none;" data-location={{ $zone->location_id }}>{{$zone->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('zone_id')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-12 col-xs-12 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="action" :value="__('Action')" />
                                <select class="form-control  mt-1" id="action" name="action">
                                    <option selected disabled >Select Lock Unlock</option>
                                    <option value="lock">Lock </option>
                                    <option value="unlock">Unlock</option>
                                   
                                </select>
                                <x-input-error :messages="$errors->get('action')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Add') }}
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

    </script>
</x-admin-layout>
