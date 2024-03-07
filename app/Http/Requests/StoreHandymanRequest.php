<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHandymanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'about' => ['string'],
            'tools' => ['json'],
            'membership_level' => ['string', 'max:255'],
            'reputation_score' => ['integer'],
            'avg_rating' => ['integer'],
            'experience' => ['string', 'max:255'],
            'hire_count' => ['integer'],
            'group_type' => ['integer'],
            'group_members' => ['json'],
            'certifications' => ['json'],
            'languages' => ['json'],
            'contact' => ['json'],
            'approval_status' => ['integer'],

            'categories' => ['array'],
            'categories.*' => ['integer', Rule::exists('categories', 'id')],

            'services' => ['array'],
            'services.*' => ['integer', Rule::exists('services', 'id')],
        ];
    }
}
