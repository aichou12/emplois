<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            'Afghanistan', 'Albanie', 'Algérie', 'Andorre', 'Angola', 'Antigua-et-Barbuda', 'Argentine', 'Arménie', 'Australie', 'Autriche',
            'Azerbaïdjan', 'Bahamas', 'Bahreïn', 'Bangladesh', 'Barbade', 'Biélorussie', 'Belgique', 'Belize', 'Bénin', 'Bhoutan',
            'Bolivie', 'Bosnie-Herzégovine', 'Botswana', 'Brésil', 'Brunei', 'Bulgarie', 'Burkina Faso', 'Burundi', 'Cambodge', 'Cameroun',
            'Canada', 'Cap-Vert', 'Chili', 'Chine', 'Chypre', 'Colombie', 'Comores', 'Congo (République du Congo)', 'Congo (République Démocratique du Congo)', 'Cook (Îles)',
            'Corée du Nord', 'Corée du Sud', 'Costa Rica', 'Croatie', 'Cuba', 'Danemark', 'Djibouti', 'Dominique', 'Égypte', 'El Salvador',
            'Équateur', 'Érythrée', 'Espagne', 'Estonie', 'Eswatini', 'États-Unis', 'Éthiopie', 'Fidji', 'Finlande', 'France', 'Gabon',
            'Gambie', 'Géorgie', 'Ghana', 'Grèce', 'Grenade', 'Guatemala', 'Guinée', 'Guinée-Bissau', 'Guyane', 'Haïti', 'Honduras',
            'Hongrie', 'Inde', 'Indonésie', 'Irak', 'Iran', 'Irlande', 'Islande', 'Israël', 'Italie', 'Jamaïque', 'Japon', 'Jordanie',
            'Kazakhstan', 'Kenya', 'Kiribati', 'Koweït', 'Kyrgyzstan', 'Laos', 'Lesotho', 'Lettonie', 'Liban', 'Liberia', 'Libye', 'Liechtenstein',
            'Lituanie', 'Luxembourg', 'Madagascar', 'Malaisie', 'Malawi', 'Maldives', 'Mali', 'Malte', 'Maroc', 'Marshalls (Îles)', 'Maurice',
            'Mauritanie', 'Mexique', 'Micronésie', 'Moldavie', 'Monaco', 'Mongolie', 'Monténégro', 'Mozambique', 'Namibie', 'Nauru', 'Népal',
            'Nicaragua', 'Niger', 'Nigéria', 'Niue', 'Norvège', 'Nouvelle-Zélande', 'Oman', 'Ouganda', 'Pakistan', 'Palaos', 'Panama', 'Papouasie-Nouvelle-Guinée',
            'Paraguay', 'Pays-Bas', 'Pérou', 'Philippines', 'Pologne', 'Portugal', 'Qatar', 'République dominicaine', 'République tchèque', 'République centrafricaine',
            'Roumanie', 'Royaume-Uni', 'Russie', 'Rwanda', 'Sahara occidental', 'Saint-Christophe-et-Niévès', 'Saint-Marin', 'Saint-Vincent-et-les-Grenadines', 'Sainte-Lucie',
            'Salomon (Îles)', 'Salvador (El)', 'Samoa', 'São Tomé-et-Principe', 'Sénégal', 'Serbie', 'Seychelles', 'Sierra Leone', 'Singapour', 'Slovaquie', 'Slovénie',
            'Somalie', 'Soudan', 'Soudan du Sud', 'Sri Lanka', 'Suède', 'Suisse', 'Suriname', 'Syrie', 'Sénégal', 'Tadjikistan', 'Tanzanie', 'Tchad', 'Thaïlande',
            'Timor oriental', 'Togo', 'Tonga', 'Trinité-et-Tobago', 'Tunisie', 'Turkménistan', 'Turquie', 'Tuvalu', 'Ukraine', 'Uruguay', 'Vanuatu', 'Vatican',
            'Venezuela', 'Viêt Nam', 'Yémen', 'Zambie', 'Zimbabwe'
        ];

        foreach ($countries as $country) {
            Country::create([
                'name' => $country,
            ]);
        }
    }
}
