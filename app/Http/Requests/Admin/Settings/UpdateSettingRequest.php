<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' => ['required', 'min:2', 'max:20'],
            'registration_enabled' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'app_name.required' => __('Application name is required.'),
            'app_name.min' => __('Application name field must be at least 2 characters.'),
            'app_name.max' => __('Application name field must not be greater than 20 characters.'),
            'registration_enabled.required' => __('Member registration setting is required.'),
        ];
    }
}
