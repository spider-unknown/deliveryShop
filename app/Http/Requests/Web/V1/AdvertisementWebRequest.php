<?php

namespace App\Http\Requests\Web\V1;

use App\Http\Requests\Web\WebBaseRequest;
use App\Models\Entities\Advertisement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvertisementWebRequest extends WebBaseRequest
{
    public function injectedRules()
    {
        return [
            'id' => ['numeric', 'exists:products,id', !$this->isStore() ? 'required' : ''],
            'link' => ['string', 'nullable', !request()->get('product_id') ? 'required' : ''],
            'product_id' => ['numeric', 'exists:products,id', 'nullable', !request()->get('link') ? 'required' : ''],
            'image' => [$this->isStore() ? 'required' : '', 'image', ],
            'position' => ['required', 'numeric', Rule::in([
                Advertisement::TOP, Advertisement::MIDDLE
            ])]
        ];
    }

}
