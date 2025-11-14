<x-operator-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Users') }}
            @can('create user')
            <x-a-button :href="route('operator.users.create')">Create New User</x-a-button>
            @endcan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col"></th>
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

                                    <td class="text-right">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                                    <div class="ml-1">
                                                        <img src="{{ asset('assets/img/three-dots.svg')}}" />
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                @can('edit user')
                                                <x-dropdown-link :href="route('operator.users.edit', $user->id )">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                @endcan
                                                @can('view user')
                                                <x-dropdown-link :href="route('operator.users.show', $user->id )">
                                                    {{ __('View') }}
                                                </x-dropdown-link>
                                                @endcan
                                                @can('delete user')
                                                <!-- Authentication -->
                                                <form method="POST" id="delete-form" action="{{ route('operator.users.destroy', $user->id ) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-dropdown-link :href="route('operator.users.destroy', $user->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                                @endcan
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

</x-operator-layout>
