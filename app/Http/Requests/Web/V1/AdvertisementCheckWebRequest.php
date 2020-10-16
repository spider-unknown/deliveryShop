<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementCheckWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'id' => ['exists:advertisements,id', $this->isEditOrUpdate() ? 'required' : ''],
        ];
    }
}
