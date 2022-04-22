<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\User;

class CategoryRequest extends BaseRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            Category::TITLE => ['required', 'string', 'min:1', 'max:255'],
        ];
    }
}
