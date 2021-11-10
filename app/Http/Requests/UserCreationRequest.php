<?php

namespace App\Http\Requests;

use App\Rules\ForbiddenSlug;
use Illuminate\Foundation\Http\FormRequest;

class UserCreationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required','alpha_dash', 'unique:users', 'min:3', 'max:255', new ForbiddenSlug],
            'email' => ['required', 'email', 'max:255']
        ];
    }
}
