<?php

namespace Modules\Meeting\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $user_name
 */
class CreateCoachRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'user_name' => ['nullable', 'alpha_dash', Rule::unique('coaches', 'user_name'), 'string', 'max:255'],
            'hourly_price' => ['required', 'numeric', 'min:0'],
            'categories' => ['required', 'array', 'min:1', 'max:4'],
            'categories.*' => ['required', 'numeric', 'exists:categories,id'],
            'about_me' => ['required', 'string', 'max:1024'],
            'resume' => ['required', 'string', 'max:1024'],
            'job_experience' => ['nullable', 'string', 'max:1024'],
            'education_record' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
