<?php


namespace App\Http\Forms\Web\V1;


use App\Core\Interfaces\WithForm;
use App\Http\Forms\Web\FormUtil;

class ProductWebForm implements WithForm
{
    public static function inputGroups($value = null): array
    {
        $array = [];
        if($value) {
            $array = FormUtil::input('id', 1, null,
                'numeric', true,
                $value->id, null, null, true);
        }
        return array_merge(
            $array,
            FormUtil::input('name', 'Пицца', 'Название',
                'text', true, $value ? $value->name : ''),
            FormUtil::textArea('description', 'Вкусная итальянская пицца', 'Описание',
                true, $value ? $value->description : ''),
            FormUtil::input('price', 100, 'Цена',
                'number', true, $value ? $value->price : ''),
            FormUtil::input('image', 'Выберите фото', 'Фото',
                'file', $value ? false : true)
        );

    }
}
