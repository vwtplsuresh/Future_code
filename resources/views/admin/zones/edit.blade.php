<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Zone') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.zones.update', $zone->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="location" :value="__('Location')" />
                                <select class="form-control mt-1" id="location" name="location">
                                    <option value="">Location</option>
                                    @if (!empty($locations) && count($locations) > 0)
                                        @foreach ($locations as $location)
                                        <option value="{{$location->id}}" @if($location->id == $zone->location->id) selected @endif>{{$location->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $zone->title)" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

