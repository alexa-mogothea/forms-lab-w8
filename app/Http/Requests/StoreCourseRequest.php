<?php

namespace App\Http\Requests;

use App\Rules\ValidCourseCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // authorization rules can go here later
    }

    public function rules(): array
    {
        return [
            'code'          => ['required', 'string', 'max:20', new ValidCourseCode,
                                'unique:courses,code'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:1000'],
            'units'         => ['required', 'integer', 'between:1,6'],
            'instructor_id' => ['nullable', Rule::exists('instructors', 'id')],
            'is_active'     => ['boolean'],
            'image'         => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique'   => 'That course code is already taken.',
            'units.between' => 'Units must be between :min and :max.',
        ];
    }

    public function attributes(): array
    {
        return ['instructor_id' => 'instructor'];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'code'      => strtoupper(trim($this->code ?? '')),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
