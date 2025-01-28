<?php

namespace Database\Seeders;
use App\Models\Country;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = json_decode(file_get_contents('https://restcountries.com/v3.1/all'), true);
        foreach ($countries as $country) {
            Country::create(['name' => $country['name']['common']]);
        }
    }
}
    

