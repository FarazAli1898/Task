<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Country;
use App\Models\City;
use App\Models\AreaLandmark;
class StoreController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        $stores = Store::all();
        return view('stores', compact('countries', 'stores'));
    }

    public function getCitiesByCountry($countryId) {
        $cities = City::where('country_id', $countryId)->get();
        return response()->json($cities);
    }

    public function getLandmarksByCity($cityId) {
        $landmarks = AreaLandmark::where('city_id', $cityId)->get();
        return response()->json($landmarks);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'landmark_id' => 'nullable|integer|exists:area_landmarks,id',
        ]);

        $store = Store::create($validatedData);
        return response()->json(['message' => 'Store created successfully', 'store' => $store]);
    }

    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
            'landmark_id' => 'nullable|integer|exists:area_landmarks,id',
        ]);

        $store->update($validatedData);
        return response()->json(['message' => 'Store updated successfully', 'store' => $store]);
    }

    public function show($id)
    {
        $store = Store::with(['city.country', 'landmark'])->findOrFail($id);
        return response()->json($store);
    }

    public function createCountry(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country = Country::create($validatedData);
        return response()->json(['message' => 'Country created successfully', 'country' => $country]);
    }

    public function createCity(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer|exists:countries,id',
        ]);

        $city = City::create($validatedData);
        return response()->json(['message' => 'City created successfully', 'city' => $city]);
    }

    public function createLandmark(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'coordinates' => 'required|string|max:255',
            'city_id' => 'required|integer|exists:cities,id',
        ]);

        $landmark = AreaLandmark::create($validatedData);
        return response()->json(['message' => 'Landmark created successfully', 'landmark' => $landmark]);
    }
}
