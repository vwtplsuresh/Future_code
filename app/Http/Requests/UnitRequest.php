<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'panel_no' => 'required|numeric',
            'title' => 'required',
            'location_id' => 'required',
            'zone_id' => 'required',
            'user_id' => 'required',
            'address' => 'required',
            'total_limit' => 'required|numeric',
            'today_limit' => 'required|numeric',
            'pipe_size' => 'required',
            'min_tds' => 'required|numeric',
            'max_tds' => 'required|numeric',
            'tds_bit' => 'required|numeric',
            'panel_unlock_timing' => 'nullable|string',

        ];
    }
}
