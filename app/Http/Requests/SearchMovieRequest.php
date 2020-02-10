<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchMovieRequest extends FormRequest
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
    public function all($keys = null)
    {
        $data = parent::all($keys);
        $data['queryParam'] = request()->queryParam;
        return $data;
    }
    public function rules()
    {
        return [
            'queryParam' => 'required|string|max:255|min:1'
        ];
    }
}
