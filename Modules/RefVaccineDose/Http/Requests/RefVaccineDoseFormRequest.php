<?php

namespace Modules\RefVaccineDose\Http\Requests;

use App\Http\Requests\FormRequest;

class RefVaccineDoseFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['VaccineDoseTitle'] = ['required','unique:RefVaccineDose,VaccineDoseTitle'];
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
