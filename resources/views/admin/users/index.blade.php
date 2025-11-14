<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            {{ __('Users') }}
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create New User
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="table-responsive">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    {{-- <th scope="col"></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($users) && count($users) > 0)
                                @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $loop->index +1 }}
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles[0]->name }}</td>
                                    <td class="text-right">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    <div class="ml-1">
                                                        <img src="{{ asset('assets/img/three-dots.svg')}}" />
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('admin.users.edit', $user->id )">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>

                                                <x-dropdown-link :href="route('admin.users.show', $user->id )">
                                                    {{ __('View') }}
                                                </x-dropdown-link>

                                                <!-- Authentication -->
                                                <form method="POST" id="delete-form" action="{{ route('admin.users.destroy', $user->id ) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-dropdown-link :href="route('admin.users.destroy', $user->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">
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

    <script>
        document.querySelectorAll('form#delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure ! you want to delete this.')) form.submit();
            });
        });

    </script>

</x-admin-layout>
