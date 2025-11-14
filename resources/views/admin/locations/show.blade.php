<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Location') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto mb-4 max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">{{ $location->title }}</h2>
                    <hr class="mt-2 mb-4">
                    @if($location->zones && $location->zones != null && count($location->zones) > 0)
                    @foreach ($location->zones as $zone)
                    <a href="{{ route('admin.zones.show', $zone->id) }}" class="btn btn-primary"> {{ $zone->title }} </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">Units</h2>
                    <hr class="mt-2 mb-4">
                    <div class="">
                        <table class="table table-sm " id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Panel Lock Unlock</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Zone</th>
                                    <th scope="col">Limit (KLD)</th>
                                    <th scope="col">TF (KLD)</th>
                                    <th scope="col">YF (KLD)</th>
                                    <th scope="col">Last Ping</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($units) && count($units) > 0)
                                @foreach ($units as $unit)
                                <tr class="@if(date("Y-m-d", strtotime($unit->liveData->updated_at)) == date("Y-m-d")) text-success @else text-danger @endif">
                                    <td>
                                        {{ $loop->index +1 }}
                                     
                                    </td>
                                    <td>{{ $unit->id }}</td>
                                    {{-- <td>
                                        @if ($unit->alarm != null)
                                        <x-tooltip id="{{ $unit->id }}" :alarms="$unit->alarm" />
                                        @endif
                                    </td> --}}
                                    <td>
                                        {{-- <a href="#" 
                                        class="toggle-lock" 
                                        data-id="{{ $unit->id }}"> --}}
                                            @if ($unit->liveData->panel_lock_status == 1)
                                            <i class="fa fa-lock text-danger" title="Locked"></i>
                                            @else
                                                {{-- <i class="fa fa-unlock text-success" title="Unlocked"></i> --}}
                                            @endif
                                        {{-- </a> --}}
                                    </td>
                                    <td>{{ $unit->user->name }}</td>
                                    <td>{{ $unit->title }}</td>
                                    <td>{{ $unit->address }}</td>
                                    <td>{{ $unit->zone->title }}</td>
                                    <td>{{ $unit->total_limit }}</td>
                                    <td>{{ $unit->liveData->today_flow }}</td>
                                    <td>{{ $unit->yesterdayFlow == null ? '-' : $unit->yesterdayFlow->net_flow }}</td>
                                    <td>{{ $unit->liveData->updated_at }}</td>
                                    {{-- <td class="text-right">
                                                <x-dropdown align="right" width="48">
                                                    <x-slot name="trigger">
                                                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                                            <div class="ml-1">
                                                                <img src="{{ asset('assets/img/three-dots.svg')}}" />
                    </div>
                    </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.units.edit', $unit->id )">
                            {{ __('Edit') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('admin.units.show', $unit->id )">
                            {{ __('View') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" id="delete-form" action="{{ route('admin.units.destroy', $unit->id ) }}">
                            @csrf
                            @method('DELETE')
                            <x-dropdown-link :href="route('admin.units.destroy', $unit->id)" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                    </x-dropdown>
                    </td> --}}
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">
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

//    status upadate js

//         $(document).on('click', '.toggle-lock', function(e){
//             e.preventDefault();
//             var link = $(this);
//             var id = link.data('id');
//             $.ajax({
//                 url: "{{ url('/admin/unit/toggle-lock') }}/" + id,
//                 type: "GET",
//                 success: function(res){
//                     if(res.success){
//                         if(res.status == 1){
//                             link.html('<i class="fa fa-unlock text-success" title="Unlocked"></i>');
//                              Swal.fire({
//                                 icon: 'success',
//                                 title: res.message,
//                                 showConfirmButton: false,
//                                 timer: 3000, // 5 seconds
//                                 timerProgressBar: true,
//                                 position: 'top-end',
//                                 toast: true,
//                             });
//                         }else{
//                             link.html('<i class="fa fa-lock text-danger" title="Locked"></i>');
//                                 Swal.fire({
//                                     icon: 'error',
//                                     title: res.message,
//                                     showConfirmButton: false,
//                                     timer: 3000, // 5 seconds
//                                     timerProgressBar: true,
//                                     position: 'top-end',
//                                     toast: true,
//                                 });
//                         }

                        
//                     }
//                 }
//             });
//         });


//       
</script>


</x-admin-layout>
