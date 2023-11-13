<?php

namespace Modules\RefProvisionalDiagnosis\Http\Requests;

use App\Http\Requests\FormRequest;

class RefProvisionalDiagnosisFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['ProvisionalDiagnosisCode'] = ['required'];
        $rules['ProvisionalDiagnosisName'] = ['required'];
        $rules['RefProvisionalDiagnosisGroupId'] = ['required'];
      
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
