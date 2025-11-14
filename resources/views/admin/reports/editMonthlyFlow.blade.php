<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Monthly Flow') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="row">
                <!-- Unit Details -->
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <p><strong>Unit : </strong>{{ $unit->title }}</p>
                            <p><strong>Location : </strong>{{ $unit->location->title }}</p>
                            <p><strong>Zone : </strong>{{ $unit->zone->title }}</p>
                            <p><strong>Address : </strong>{{ $unit->address }}</p>
                            <p><strong>Limit : </strong>{{ $unit->total_limit }}</p>
                        </div>
                    </div>
                </div>

                <!-- Monthly Flow Edit Forms -->
                <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="mb-4 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <!-- Start of the single form for all entries -->
                            <form class="form" action="{{ url('/admin/reports/updateMonthlyFlow/'.$month.'/'.$unit->id.'/'.$unit->location_id.'/'.$unit->zone_id) }}" method="post">
                                @csrf
                                @if (!empty($monthlyFlow) && count($monthlyFlow) > 0)
                                    @foreach ($monthlyFlow as $flow)
                                        <div class="mb-4 row">
                                            <div class="col-md-3 col-lg-3 col-sm-12">
                                                <x-input-label for="net_flow_{{ $flow->id }}" :value="date('M d Y', strtotime($flow->created_at))" />
                                            </div>
                                            <div class="col-md-3 col-lg-3 col-sm-12">
                                                <input type="hidden" name="flow_id[]" value="{{ $flow->id }}">
                                                <x-text-input id="net_flow_{{ $flow->id }}" class="block w-full mt-1" type="text" name="net_flow[]" :value="old('net_flow', $flow->net_flow)" />
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <hr class="my-2">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-sm-12">
                                        <x-primary-button class="ml-3">
                                            {{ __('Update') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>

                            <!-- End of the single form -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>