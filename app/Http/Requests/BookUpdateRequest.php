<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['max:30'],
            'description' => ['max:300'],
            'owner' => ['integer', 'exists:users,id'],
            'status' => ['integer'],
            'assignee' => ['integer', 'exists:users,id'],
        ];
    }
    
    /**
     * Errors
     *
     * @return void
     */
    public function messages()
    {
        return [
            'title.max' => 'Title max 30',
            'description.max' => 'Description max 300',
            'owner.exists' => 'Owner not exists',
            'assignee.exists' => 'Assignee not exists',
        ];
    }
}
