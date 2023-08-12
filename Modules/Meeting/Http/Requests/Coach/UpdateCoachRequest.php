<?php

namespace Modules\Meeting\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $user_name
 * @property mixed $avatar
 */
class UpdateCoachRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'user_name' => ['required', 'alpha_dash', Rule::unique('coaches')->ignore($this->user_name, 'user_name'), 'string', 'max:255'],
            'categories' => ['required', 'array', 'min:1', 'max:4'],
            'categories.*' => ['required', 'numeric', 'exists:coach_categories,id'],
            'hourly_price' => ['required', 'numeric', 'min:0'],
            'about_me' => ['required', 'string', 'max:1024'],
            'resume' => ['required', 'string', 'max:1024'],
            'job_experience' => ['nullable', 'string', 'max:1024'],
            'education_record' => ['nullable', 'string', 'max:1024'],
        ];
    }

    public function validated($key = null, $default = null): array
    {
        $validatedData = parent::validated();

        $coachData = [
            'name' => $validatedData['name'],
            'avatar' => $validatedData['avatar'],
            'user_name' => $validatedData['user_name'] ?? null,
            'hourly_price' => $validatedData['hourly_price'],
        ];

        $coachInfo = [
            'about_me' => $validatedData['about_me'],
            'resume' => $validatedData['resume'],
            'job_experience' => $validatedData['job_experience'] ?? null,
            'education_record' => $validatedData['education_record'] ?? null,
        ];

        return [
            'coach' => $coachData,
            'coach_info' => $coachInfo,
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
