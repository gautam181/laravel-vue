<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ticket_id' => ['required', 'exists:tickets,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'user_id' => ['required', 'exists:users,id'],
            'minutes' => [function ($attribute, $value, $fail) {
                $hours = self::get('hours');
                if($value < 1 && $hours < 1)
                    $fail('Log time must be al least one minute ');
            }],
            'description' => ['required'],
        ];
    }
}
