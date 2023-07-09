<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'name' => 'nullable|max:255',
            'creation_type' => 'required|in:random,selected',
            'duration_in_seconds' => 'nullable|integer',
            'start_time' => 'nullable|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after:start_time',
            'result' => 'nullable|numeric',
            'vocabularies' => 'required_if:creation_type,selected|array|min:1|max:10',
            'vocabularies.*' => 'required_if:creation_type,selected|distinct|exists:vocabularies,id'
        ];
    }
}
