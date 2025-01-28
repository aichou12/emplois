<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmploisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('emplois')->insert([
            // Secteur Informatique
            ['nom' => 'Développeur Web', 'secteur_id' => 1],
            ['nom' => 'Développeur Mobile', 'secteur_id' => 1],
            ['nom' => 'Administrateur Systèmes', 'secteur_id' => 1],
            ['nom' => 'Data Scientist', 'secteur_id' => 1],

            // Secteur Médecine
            ['nom' => 'Médecin Généraliste', 'secteur_id' => 2],
            ['nom' => 'Infirmier', 'secteur_id' => 2],
            ['nom' => 'Pharmacien', 'secteur_id' => 2],
            ['nom' => 'Chirurgien', 'secteur_id' => 2],

            // Secteur Finance
            ['nom' => 'Analyste Financier', 'secteur_id' => 3],
            ['nom' => 'Contrôleur de Gestion', 'secteur_id' => 3],
            ['nom' => 'Comptable', 'secteur_id' => 3],
            ['nom' => 'Banquier', 'secteur_id' => 3],

            // Secteur Éducation
            ['nom' => 'Professeur', 'secteur_id' => 4],
            ['nom' => 'Éducateur', 'secteur_id' => 4],
            ['nom' => 'Formateur', 'secteur_id' => 4],
            ['nom' => 'Directeur d\'École', 'secteur_id' => 4],

            // Secteur Construction
            ['nom' => 'Ingénieur Civil', 'secteur_id' => 5],
            ['nom' => 'Architecte', 'secteur_id' => 5],
            ['nom' => 'Chef de Chantier', 'secteur_id' => 5],
            ['nom' => 'Maçon', 'secteur_id' => 5],

            // Secteur Agriculture
            ['nom' => 'Agriculteur', 'secteur_id' => 6],
            ['nom' => 'Ouvrier Agricole', 'secteur_id' => 6],
            ['nom' => 'Technicien Agricole', 'secteur_id' => 6],
            ['nom' => 'Ingénieur Agronome', 'secteur_id' => 6],

            // Secteur Transports
            ['nom' => 'Conducteur de Bus', 'secteur_id' => 7],
            ['nom' => 'Chauffeur de Camion', 'secteur_id' => 7],
            ['nom' => 'Gestionnaire de Logistique', 'secteur_id' => 7],
            ['nom' => 'Responsable Transport', 'secteur_id' => 7],

            // Secteur Tourisme
            ['nom' => 'Guide Touristique', 'secteur_id' => 8],
            ['nom' => 'Agent de Voyage', 'secteur_id' => 8],
            ['nom' => 'Directeur de Complexe Touristique', 'secteur_id' => 8],
            ['nom' => 'Réceptionniste', 'secteur_id' => 8],

            // Secteur Ressources humaines
            ['nom' => 'Chargé de Recrutement', 'secteur_id' => 9],
            ['nom' => 'Responsable Formation', 'secteur_id' => 9],
            ['nom' => 'Directeur RH', 'secteur_id' => 9],
            ['nom' => 'Gestionnaire de Paie', 'secteur_id' => 9],

            // Secteur Marketing
            ['nom' => 'Responsable Marketing', 'secteur_id' => 10],
            ['nom' => 'Chargé de Communication', 'secteur_id' => 10],
            ['nom' => 'Community Manager', 'secteur_id' => 10],
            ['nom' => 'Chef de Produit', 'secteur_id' => 10],

            // Secteur Vente
            ['nom' => 'Commercial', 'secteur_id' => 11],
            ['nom' => 'Vendeur', 'secteur_id' => 11],
            ['nom' => 'Chef des Ventes', 'secteur_id' => 11],
            ['nom' => 'Responsable Service Client', 'secteur_id' => 11],

            // Secteur Logistique
            ['nom' => 'Gestionnaire de Stock', 'secteur_id' => 12],
            ['nom' => 'Responsable Logistique', 'secteur_id' => 12],
            ['nom' => 'Coordinateur de Transport', 'secteur_id' => 12],
            ['nom' => 'Agent de Transit', 'secteur_id' => 12],

            // Secteur Design
            ['nom' => 'Designer Graphique', 'secteur_id' => 13],
            ['nom' => 'UI/UX Designer', 'secteur_id' => 13],
            ['nom' => 'Illustrateur', 'secteur_id' => 13],
            ['nom' => 'Architecte d\'Intérieur', 'secteur_id' => 13],

            // Secteur Art et culture
            ['nom' => 'Artiste Peintre', 'secteur_id' => 14],
            ['nom' => 'Musicien', 'secteur_id' => 14],
            ['nom' => 'Comédien', 'secteur_id' => 14],
            ['nom' => 'Danseur', 'secteur_id' => 14],

            // Secteur Communication
            ['nom' => 'Responsable Communication', 'secteur_id' => 15],
            ['nom' => 'Rédacteur', 'secteur_id' => 15],
            ['nom' => 'Journaliste', 'secteur_id' => 15],
            ['nom' => 'Chargé de Presse', 'secteur_id' => 15],

            // Secteur Énergie
            ['nom' => 'Ingénieur en Énergie', 'secteur_id' => 16],
            ['nom' => 'Technicien en Énergie', 'secteur_id' => 16],
            ['nom' => 'Chef de Projet Énergie', 'secteur_id' => 16],
            ['nom' => 'Opérateur Énergie', 'secteur_id' => 16],

            // Secteur Industrie
            ['nom' => 'Ouvrier Industriel', 'secteur_id' => 17],
            ['nom' => 'Ingénieur Industriel', 'secteur_id' => 17],
            ['nom' => 'Technicien de Maintenance', 'secteur_id' => 17],
            ['nom' => 'Responsable Production', 'secteur_id' => 17],

            // Secteur Télécommunications
            ['nom' => 'Technicien Réseaux', 'secteur_id' => 18],
            ['nom' => 'Ingénieur Télécom', 'secteur_id' => 18],
            ['nom' => 'Responsable Télécom', 'secteur_id' => 18],
            ['nom' => 'Opérateur de Télécommunications', 'secteur_id' => 18],

            // Secteur Automobile
            ['nom' => 'Mécanicien Automobile', 'secteur_id' => 19],
            ['nom' => 'Technicien Automobile', 'secteur_id' => 19],
            ['nom' => 'Ingénieur Automobile', 'secteur_id' => 19],
            ['nom' => 'Responsable Après-Vente', 'secteur_id' => 19],

            // Secteur Événementiel
            ['nom' => 'Organisateur d\'Événements', 'secteur_id' => 20],
            ['nom' => 'Chargé de Communication Événementielle', 'secteur_id' => 20],
            ['nom' => 'Coordinateur Événementiel', 'secteur_id' => 20],
            ['nom' => 'Responsable Logistique Événementielle', 'secteur_id' => 20],
        ]);
    }
}

