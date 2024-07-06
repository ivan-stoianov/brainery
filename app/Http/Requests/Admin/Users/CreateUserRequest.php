<?php

namespace App\Http\Requests\Admin\Users;

use App\Rules\FirstName;
use App\Rules\LastName;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:100'
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
            ],
        ];
    }
}
