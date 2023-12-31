<?php

namespace Modules\RefIllness\Http\Requests;

use App\Http\Requests\FormRequest;

class RefillnessFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['IllnessCode'] = ['required'];
        $rules['HOIllness'] = ['required'];
        $rules['FamilyHO'] = ['required'];
        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
