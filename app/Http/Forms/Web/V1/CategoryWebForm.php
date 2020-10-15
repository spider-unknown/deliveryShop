<?php


namespace App\Http\Forms\Web\V1;


use App\Core\Interfaces\WithForm;
use App\Http\Forms\Web\FormUtil;

class CategoryWebForm implements WithForm
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
                'text', true, $value ? $value->name : ''));
    }
}
