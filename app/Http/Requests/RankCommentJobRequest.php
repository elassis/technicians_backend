<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RankCommentJobRequest extends FormRequest
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
            'id' => 'required',
            'comment' => 'required|string|min:5|max:200',
            'ranking' => 'required|integer|min:1|max:5'
        ];
    }
}
