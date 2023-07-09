<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
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
     * @todo To prevent mutiple players for the same user,  add unique:players,user_id, it makes a prblem with udpate function
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|max:255',
            'user_id' => 'required|exists:users,id',
            'games_count' => 'nullable|integer',
            'last_game_at' => 'nullable|date_format:Y-m-d H:i:s',
            'score' => 'nullable|numeric'
        ];
    }
}
