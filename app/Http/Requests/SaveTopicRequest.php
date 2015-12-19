<?php

namespace Imojie\Http\Requests;

use Imojie\Http\Requests\Request;

class SaveTopicRequest extends Request
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
            'title' => 'required|between:1,80',
            'content' => 'required',
        ];
    }
}
