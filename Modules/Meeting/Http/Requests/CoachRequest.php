<?php

namespace Modules\Meeting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoachRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'user_name' => ['nullable', 'string', 'max:255'],
            'hourly_price' => ['required', 'numeric', 'min:0'],
            'about_me' => ['required', 'string', 'max:1024'],
            'resume' => ['required', 'string' , 'max:1024'],
            'job_experience' => ['nullable', 'string', 'max:1024'],
            'education_record' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
