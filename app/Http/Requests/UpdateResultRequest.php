<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResultRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        // TODO: Verificare i dati

        // request =
        // "home_score" => "0"
        // "visitor_score" => "3"
        // "home_set_1" => "14"
        // "visitor_set_1" => "25"
        // "home_set_2" => "13"
        // "visitor_set_2" => "25"
        // "home_set_3" => "17"
        // "visitor_set_3" => "25"
        // "home_set_4" => null
        // "visitor_set_4" => null
        // "home_set_5" => null
        // "visitor_set_5" => null

        return [
            //
        ];
    }
}
