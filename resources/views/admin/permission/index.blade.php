<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            {{ __('Roles') }}
            <x-a-button :href="route('admin.permissions.create')" >Create New Permissin</x-a-button>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('layouts.alerts.success')
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Permission</th>
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($permissions) && count($permissions) > 0)
                                    @foreach ($permissions as $permission)
                                       
                                            <tr>
                                                <td>
                                                    {{ $loop->index }}
                                                </td>
                                                <td>{{ ucwords($permission->name) }}</td>
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
                                                            
                                                            <form method="POST" id="delete-form" action="{{ route('admin.permissions.destroy', $permission->id ) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-dropdown-link :href="route('admin.permissions.destroy', $permission->id)" onclick="event.preventDefault(); this.closest('form').submit();">
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
                                        <td colspan="2">
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
