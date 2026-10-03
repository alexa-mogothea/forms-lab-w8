<?php

namespace App\Http\Requests;

use App\Rules\ValidCourseCode;
use Illuminate\Validation\Rule;

// Reuse everything from StoreCourseRequest; only the "code" rule changes.
class UpdateCourseRequest extends StoreCourseRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['code'] = [
            'required', 'string', 'max:20', new ValidCourseCode,
            Rule::unique('courses', 'code')->ignore($this->route('course')),
        ];

        return $rules;
    }
}
