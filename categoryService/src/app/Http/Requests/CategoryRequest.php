<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Validation\Rule;

class CategoryRequest extends BaseRequest
{
    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            Category::TITLE => [
                'required',
                'string',
                'min:1',
                'max:255',
                Rule::unique(Category::TABLE, Category::TITLE)
                    ->whereNull(Category::DELETED_AT)
                    ->ignore($this->categoryId, Category::ID),
            ],
        ];
    }
}
