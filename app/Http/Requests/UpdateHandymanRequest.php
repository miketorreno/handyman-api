<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHandymanRequest extends FormRequest
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
            'about' => ['string'],
            'tools' => ['json'],
            'membership_level' => ['string'],
            'reputation_score' => ['integer'],
            'avg_rating' => ['numeric'],
            'experience' => ['string'],
            'hire_count' => ['integer'],
            'group_type' => ['integer'],
            'group_members' => ['json'],
            'certifications' => ['json'],
            'languages' => ['json'],
            'approval_status' => ['integer'],

            'categories' => ['array'],
            'categories.*' => ['integer', Rule::exists('categories', 'id')],

            'services' => ['array'],
            'services.*' => ['integer', Rule::exists('services', 'id')],
        ];
    }
}
