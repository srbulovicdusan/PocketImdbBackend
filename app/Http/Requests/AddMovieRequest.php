<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMovieRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:1'],
            'description' => ['required', 'string', 'max:255', 'min:1'],
            'image' => ['file', 'image', 'mimes:jpeg,jpg,png', 'max:5000'],
            'image_url' => ['string', 'min:1'],
            'genre' => ['required', 'string', 'max:255', 'min:1']

        ];
    }
}
