<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Userdata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            'Afghanistan', 'Afrique du Sud', 'Albanie', 'Algérie', 'Allemagne', 'Andorre', 'Angola', 'Antigua-et-Barbuda', 'Argentine', 'Arménie', 'Australie', 'Autriche',
            'Azerbaïdjan', 'Bahamas', 'Bahreïn', 'Bangladesh', 'Barbade', 'Biélorussie', 'Belgique', 'Belize', 'Bénin', 'Bhoutan',
            'Bolivie', 'Bosnie-Herzégovine', 'Botswana', 'Brésil', 'Brunei', 'Bulgarie', 'Burkina Faso', 'Burundi', 'Cambodge', 'Cameroun',
            'Canada', 'Cap-Vert', 'Chili', 'Chine', 'Chypre', 'Colombie', 'Comores', 'Congo (République du Congo)', 'Congo (République Démocratique du Congo)', 'Cook (Îles)', 'Côte d’Ivoire',
            'Corée du Nord', 'Corée du Sud', 'Costa Rica', 'Croatie', 'Cuba', 'Danemark', 'Djibouti', 'Dominique', 'Égypte', 'Émirats arabes unis', 'El Salvador',
            'Équateur', 'Érythrée', 'Espagne', 'Estonie', 'Eswatini', 'États-Unis', 'Éthiopie', 'Fidji', 'Finlande', 'France', 'Gabon',
            'Gambie', 'Géorgie', 'Ghana', 'Grèce', 'Grenade', 'Guatemala', 'Guinée', 'Guinée équatoriale', 'Guinée-Bissau', 'Guyane', 'Haïti', 'Honduras',
            'Hongrie', 'Inde', 'Indonésie', 'Irak', 'Iran', 'Irlande', 'Islande', 'Israël', 'Italie', 'Jamaïque', 'Japon', 'Jordanie',
            'Kazakhstan', 'Kenya', 'Kiribati', 'Koweït', 'Kyrgyzstan', 'Laos', 'Lesotho', 'Lettonie', 'Liban', 'Liberia', 'Libye', 'Liechtenstein',
            'Lituanie', 'Luxembourg', 'Madagascar', 'Malaisie', 'Malawi', 'Maldives', 'Mali', 'Malte', 'Maroc', 'Marshalls (Îles)', 'Maurice',
            'Mauritanie', 'Mexique', 'Micronésie', 'Moldavie', 'Monaco', 'Mongolie', 'Monténégro', 'Mozambique', 'Myanmar', 'Namibie', 'Nauru', 'Népal',
            'Nicaragua', 'Niger', 'Nigéria', 'Niue', 'Norvège', 'Nouvelle-Zélande', 'Oman', 'Ouganda', 'Pakistan', 'Palaos', 'Panama', 'Papouasie-Nouvelle-Guinée',
            'Paraguay', 'Pays-Bas', 'Pérou', 'Philippines', 'Pologne', 'Portugal', 'Qatar', 'République dominicaine', 'République tchèque', 'République centrafricaine',
            'Roumanie', 'Royaume-Uni', 'Russie', 'Rwanda', 'Sahara occidental', 'Saint-Christophe-et-Niévès', 'Saint-Marin', 'Saint-Vincent-et-les-Grenadines', 'Sainte-Lucie',
            'Salomon (Îles)', 'Samoa', 'São Tomé-et-Principe', 'Sénégal', 'Serbie', 'Seychelles', 'Sierra Leone', 'Singapour', 'Slovaquie', 'Slovénie',
            'Somalie', 'Soudan', 'Soudan du Sud', 'Sri Lanka', 'Suède', 'Suisse', 'Suriname', 'Syrie', 'Tadjikistan', 'Tanzanie', 'Tchad', 'Thaïlande',
            'Timor oriental', 'Togo', 'Tonga', 'Trinité-et-Tobago', 'Tunisie', 'Turkménistan', 'Turquie', 'Tuvalu', 'Ukraine', 'Uruguay', 'Vanuatu', 'Vatican',
            'Venezuela', 'Viêt Nam', 'Yémen', 'Zambie', 'Zimbabwe',
            'Arabie saoudite', 'Macédoine du Nord', 'Ouzbékistan', 'Palestine'
        ];

        DB::transaction(function () use ($countries) {
            foreach (array_unique($countries) as $country) {
                Country::firstOrCreate(['name' => $country]);
            }

            $canonicalElSalvador = Country::query()->where('name', 'El Salvador')->orderBy('id')->first();
            if ($canonicalElSalvador) {
                Country::query()->where('name', 'Salvador (El)')->orderBy('id')->get()->each(function ($alias) use ($canonicalElSalvador) {
                    Userdata::query()->where('country_id', $alias->id)
                        ->update(['country_id' => $canonicalElSalvador->id]);
                    $alias->delete();
                });
            }

            $duplicateNames = Country::query()
                ->select('name')
                ->groupBy('name')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('name');

            foreach ($duplicateNames as $name) {
                $records = Country::query()->where('name', $name)->orderBy('id')->get();
                $canonical = $records->shift();

                foreach ($records as $duplicate) {
                    Userdata::query()->where('country_id', $duplicate->id)
                        ->update(['country_id' => $canonical->id]);
                    $duplicate->delete();
                }
            }
        });
    }
}
