{{-- @if ($alarms->emergency_stop_alarm_status || $alarms->door_limit_switch_alarm_status || $alarms->current_flow_alarm_status || $alarms->emergency_stop_alarm_status || $alarms->today_flow_alarm_status || $alarms->overload_alarm_status || $alarms->pump_alarm_status || $alarms->tank_level_alarm_status || $alarms->tank_level_alarm_status || $alarms->output_value_alarm_status || $alarms->pipe_size_alarm_status || $alarms->totalizer_alarm_status || $alarms->panel_lock_alarm_status || $alarms->auto_manual_alarm_status || $alarms->kld_limit_send_alarm_status)
    <div x-data="{ tooltip_{{ $id }}: false }" class="relative z-30 inline-flex">
        <div x-on:mouseover="tooltip_{{ $id }} = true" x-on:mouseleave="tooltip_{{ $id }} = false" class="rounded-md text-red-500 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
        </div>
        <div style="min-width:500px" class="shadow-md absolute top-0 z-50 max-w-3xl w-6xl p-2 mt-3 text-sm leading-tight transform -translate-x-1/2 -translate-y-full bg-white" x-cloak x-show.transition.origin.top="tooltip_{{ $id }}">
            <ul class="list-none text-rose-500 p-2 text-red-500 w-full">
                @if($alarms->emergency_stop_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->emergency_stop_alarm_message }}</li>
                @endif
                @if($alarms->door_limit_switch_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->door_limit_switch_alarm_message }}</li>
                @endif
                @if($alarms->current_flow_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->current_flow_alarm_message }}</li>
                @endif
                @if($alarms->emergency_stop_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->emergency_stop_alarm_message }}</li>
                @endif
                @if($alarms->today_flow_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->today_flow_alarm_message }}</li>
                @endif
                @if($alarms->overload_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->overload_alarm_message }}</li>
                @endif
                @if($alarms->pump_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->pump_alarm_message }}</li>
                @endif
                @if($alarms->tank_level_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->tank_level_alarm_message }}</li>
                @endif
                @if($alarms->tank_level_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->tank_level_alarm_message }}</li>
                @endif
                @if($alarms->output_value_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->output_value_alarm_message }}</li>
                @endif
                @if($alarms->pipe_size_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->pipe_size_alarm_message }}</li>
                @endif
                @if($alarms->totalizer_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->totalizer_alarm_message }}</li>
                @endif
                @if($alarms->panel_lock_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->panel_lock_alarm_message }}</li>
                @endif
                @if($alarms->auto_manual_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->auto_manual_alarm_message }}</li>
                @endif
                @if($alarms->kld_limit_send_alarm_status)
                    <li style="color:rgb(240, 58, 58);">- {{ $alarms->kld_limit_send_alarm_message }}</li>
                @endif
            </ul>
        </div>
    </div>
@endif --}}
