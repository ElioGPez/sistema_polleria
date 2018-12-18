<?php

namespace polleria\Http\Requests;

use polleria\Http\Requests\Request;

class CuentaFormRequest extends Request
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
          'monto'=>'numeric|required|min:1',
        ];
    }
}
