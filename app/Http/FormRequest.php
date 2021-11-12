<?php


namespace App\Http;

use App\Interfaces\ResponseCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Validation\ValidationException;

class FormRequest extends BaseFormRequest implements ResponseCode
{
    protected $stopOnFirstFailure = true;

    /*public function fails()
    {
        return $this->validator->fails();
    }

    public function failed()
    {
        return $this->validator->failed();
    }

    public function errors()
    {
        return $this->validator->errors();
    }*/

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->status(200)
            ->errorBag($validator->errors()->first());
    }
}
