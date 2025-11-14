<x-operator-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Zone') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('operator.zones.store') }}">
                        @csrf
                        <div class="row">
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="location" :value="__('Location')" />
                                <select class="mt-1 form-control" id="location" name="location">
                                    <option value="">Location</option>
                                    @if (!empty($locations) && count($locations) > 0)
                                    @foreach ($locations as $location)
                                    <option value="{{$location->id}}">{{$location->title}}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('location')" class="mt-2" />
                            </div>
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-12 col-xs-12 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="title" :value="__('Title')" />
                                <x-text-input id="title" class="block w-full mt-1" type="text" name="title" :value="old('title')" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
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
</x-operator-layout>
