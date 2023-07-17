<?php

namespace Modules\Meeting\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

/**
 * @property mixed $user_name
 */
class UpdateCoachRequest extends FormRequest
{
    public function rules(): array
    {
        Log::info($this->user_name);
        return [
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'user_name' => ['required', Rule::unique('coaches')->ignore($this->user_name, 'user_name'), 'string', 'max:255'],
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
