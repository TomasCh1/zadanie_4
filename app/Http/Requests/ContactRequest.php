<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;    // ← zmeň z false na true
    }


    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            // tu použijeme správne ignore ID
            'email'      => [
                'required',
                'email',
                Rule::unique('contacts', 'email')
                    ->ignore($this->route('contact')->id ?? null),
            ],
            'formality'  => 'required|in:tykanie,vykanie',
            'salutation' => 'nullable|string|max:255',
        ];
    }
}
