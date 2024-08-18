<?php

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Enums\StatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'category' => [new Enum(CategoryEnum::class)],
            'user_id' => 'required',
            'status' => [new Enum(StatusEnum::class)],
            'image',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A title is required',
            'description.required' => 'A description is required'
        ];
    }
}
