<?php

namespace App\Http\Controllers\Web\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\WebBaseController;
use App\Http\Forms\Web\V1\CountryWebForm;
use App\Http\Requests\Web\V1\CountryWebRequest;
use App\Models\Entities\Country;
use Illuminate\Http\Request;

class CountryController extends WebBaseController
{
    public function index() {
        $countries = Country::all();
        $country_web_form = CountryWebForm::inputGroups(null);
        return $this->adminPagesView('city.country', compact('countries', 'country_web_form'));
    }

    public function store(CountryWebRequest $request) {
        Country::create(['name' => $request->name]);
        $this->added();
        return redirect()->route('country.index');
    }

    public function update(CountryWebRequest $request) {
        $country = Country::find($request->id);
        $country->name = $request->name;
        $country->save();
        $this->edited();
        return redirect()->route('country.index');
    }
}
