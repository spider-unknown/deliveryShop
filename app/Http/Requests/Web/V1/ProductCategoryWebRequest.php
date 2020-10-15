<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
       return [
         'id' => ['exists:products,id', $this->isEditOrUpdate() ? 'required' : ''],
         'category_id' => ['exists:categories,id', 'required']
       ];
    }

}
