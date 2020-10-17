<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Forms\Web\V1\CityWebForm;
use App\Http\Requests\Web\V1\CityCountryWebRequest;
use App\Http\Requests\Web\V1\CityWebRequest;
use App\Models\Entities\City;
use Illuminate\Http\Request;

class CityController extends WebBaseController
{
    public function index(CityCountryWebRequest $cityCountryWebRequest) {
        $country_id = $cityCountryWebRequest->country_id;
        $cities = City::where('country_id', $country_id)->get();
        $city_web_form = CityWebForm::inputGroups(null);
        return $this->adminPagesView('city.city', compact('cities', 'city_web_form', 'country_id'));
    }

    public function store(CityCountryWebRequest $cityCountryWebRequest, CityWebRequest $request) {
        $country_id = $cityCountryWebRequest->country_id;
        City::create([
            'name' => $request->name,
            'country_id' => $country_id
        ]);
        $this->added();
        return redirect()->route('city.index', ['country_id' => $country_id]);
    }

    public function update(CityCountryWebRequest $cityCountryWebRequest, CityWebRequest $request) {
        $country_id = $cityCountryWebRequest->country_id;
        $city = City::find($request->id);
        $city->name = $request->name;
        $city->save();
        $this->added();
        return redirect()->route('city.index', ['country_id' => $country_id]);
    }

}
