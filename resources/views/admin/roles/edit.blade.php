<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex justify-between">
            {{ __('Create Role') }}
        </h2>
    </x-slot>

<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white shadow rounded p-6">
        <h2 class="text-2xl font-semibold mb-4">Edit Role: {{ $role->name }}</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-800 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Role name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium mb-1">Role Name</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $role->name) }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Select / Deselect All -->
            <div class="flex items-center justify-between mb-3">
                <div>
                    <label class="inline-flex items-center">
                        <input id="select_all" type="checkbox" class="form-checkbox mr-2">
                        <span class="text-sm">Select / Deselect All Permissions</span>
                    </label>
                </div>
                <div class="text-sm text-gray-500">Total permissions: {{ $permissions->count() }}</div>
            </div>

            <!-- Permissions list (grouped if provided) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                @if(isset($permissionGroups) && count($permissionGroups))
                    @foreach($permissionGroups as $groupName => $groupPermissions)
                        <div class="border rounded p-4">
                            <h3 class="font-medium mb-2">{{ $groupName }}</h3>
                            <div class="space-y-2">
                                @foreach($groupPermissions as $perm)
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $perm->name }}"
                                               class="permission-checkbox mr-2"
                                               {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                        <span class="text-sm">{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="border rounded p-4 col-span-1 md:col-span-2">
                        <div class="space-y-2">
                            @foreach($permissions as $perm)
                                <label class="flex items-center">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $perm->name }}"
                                           class="permission-checkbox mr-2"
                                           {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                                    <span class="text-sm">{{ $perm->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Update Role
                </button>

                <a href="{{ route('admin.roles.index') }}" class="px-4 py-2 border rounded text-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- JS: Select/Deselect all -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('select_all');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        // toggle all based on selectAll checkbox
        selectAll?.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });

        // if any checkbox unchecked -> uncheck selectAll; if all checked -> check selectAll
        function refreshSelectAll() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', refreshSelectAll));

        // initialize state
        refreshSelectAll();
    });
</script>



    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.roles.store') }}">
                        @csrf
                        <!-- Lmail Address -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="{{ $role->name }}" autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
    </div> --}}
</x-admin-layout>
