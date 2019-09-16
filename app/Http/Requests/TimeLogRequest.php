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
            'ticket_id' => ['required', 'exists:Tickets,id'],
            'project_id' => ['required', 'exists:Projects,id'],
            'user_id' => ['required', 'exists:Users,id'],
        ];
    }
}
