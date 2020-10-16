<?php


namespace App\Http\Forms\Web\V1;


use App\Core\Interfaces\WithForm;
use App\Http\Forms\Web\FormUtil;
use App\Models\Entities\Advertisement;
use App\Models\Entities\Product;

class AdvertisementWebForm implements WithForm
{
    public static function inputGroups($value = null): array
    {
        $array = [];
        $products_array = [];
        $selected_top = $value ? $value->position == Advertisement::TOP ? 'selected' : '' : '';
        $selected_middle = $value ? $value->position == Advertisement::MIDDLE ? 'selected' : '' : '';
        $positions = [
            array('title' => 'Top', 'value' => Advertisement::TOP, 'selected' => $selected_top),
            array('title' => 'Middle', 'value' => Advertisement::MIDDLE, 'selected' => $selected_middle),
            ];
        $products = Product::all();
        $products_array[] = array('title' => null, 'value' => null, 'selected' => '');
        foreach ($products as $product) {
            $selected = $value ? $value->product_id == $product->id ? 'selected' : '' : '';
            $products_array[] = array('title' => $product->name, 'value' => $product->id, 'selected' => $selected);
        }
        if($value) {
            $array = FormUtil::input('id', 1, null,
                'numeric', true,
                $value->id, null, null, true);
        }
        return array_merge(
            $array,
            FormUtil::input('link', 'https://sups.kz', 'Ссылка',
                'text', false, $value ? $value->link : ''),
            FormUtil::input('image', '', 'Выберите фото',
                'file', $value ? false : true),
            FormUtil::select('position', '', 'Позиция',
                true, $positions),
            FormUtil::select('product_id', '', 'Продукт',
                false, $products_array)

        );
    }
}
