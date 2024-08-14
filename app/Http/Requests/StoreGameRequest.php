<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'rawgApiId' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'thumbnail' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'game_site_url' => ['required', 'string', 'max:255'],
            'game_img_url' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'string', 'max:255'],
        ];

    }
}
