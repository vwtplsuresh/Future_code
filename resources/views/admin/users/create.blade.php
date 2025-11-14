<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <!-- Lmail Address -->
                        <div class="row mt-3">
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-6 col-xs-6 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" placeholder="Name" name="name" :value="old('name')" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="py-2 col-sm-6 col-xs-6 col-md-6 col-lg-6 col-xl-6">
                                <x-input-label for="role" :value="__('Role')" />
                                <select class="form-control  mt-1" id="role" name="role">
                                    <option value="" >Select Role</option>
                                    <option value="user" >User</option>
                                    <option value="inspector" >Inspector</option>
                                    <option value="operator" >Operator</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-6 col-xs-6 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="examlpe@email.com" name="email" :value="old('email')" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-6 col-xs-6 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" placeholder="********" name="password" :value="old('password')" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Lmail Address -->
                            <div class="py-2 col-sm-6 col-xs-6 col-md-4 col-lg-4 col-xl-4">
                                <x-input-label for="cpassword" :value="__('Confirm Password')" />
                                <x-text-input id="cpassword" class="block mt-1 w-full" type="password" placeholder="********" name="cpassword" :value="old('cpassword')" />
                                <x-input-error :messages="$errors->get('cpassword')" class="mt-2" />
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
</x-admin-layout>
