<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\City;
use App\Models\AreaLandmark;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'country' => 'CountryName1',
                'cities' => [
                    [
                        'name' => 'CityName1',
                        'landmarks' => ['Landmark1', 'Landmark2']
                    ],
                    [
                        'name' => 'CityName2',
                        'landmarks' => ['Landmark3', 'Landmark4']
                    ],
                ],
            ],
            [
                'country' => 'CountryName2',
                'cities' => [
                    [
                        'name' => 'CityName3',
                        'landmarks' => ['Landmark5', 'Landmark6']
                    ],
                    [
                        'name' => 'CityName4',
                        'landmarks' => ['Landmark7', 'Landmark8']
                    ],
                ],
            ],
        ];

        foreach ($data as $countryData) {
            $country = Country::create(['name' => $countryData['country']]);

            foreach ($countryData['cities'] as $cityData) {
                $city = $country->cities()->create(['name' => $cityData['name']]);

                foreach ($cityData['landmarks'] as $landmarkName) {
                    $city->areaLandmarks()->create(['name' => $landmarkName, 'coordinates' => 'DummyCoordinates']);
                }
            }
        }
    }
}


