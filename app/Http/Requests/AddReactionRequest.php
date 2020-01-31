<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddReactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'movie_id' => ['required', 'exists:movies,id'],
            'type' => ['required']
        ];
    }
}
