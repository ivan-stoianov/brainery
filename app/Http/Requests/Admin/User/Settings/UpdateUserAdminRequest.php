<?php

namespace App\Http\Requests\Admin\User\Settings;

use App\Rules\FirstName;
use App\Rules\LastName;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAdminRequest extends FormRequest
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
            'first_name' => [
                'required',
                'min:2',
                'max:40',
                new FirstName(),
            ],
            'last_name' => [
                'required',
                'min:2',
                'max:40',
                new LastName(),
            ],
        ];
    }
}
