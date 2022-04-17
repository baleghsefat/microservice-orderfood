<?php


namespace App\Http\Requests;


use Anik\Form\FormRequest;

class BaseRequest extends FormRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [];
    }
}
