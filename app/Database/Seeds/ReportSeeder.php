<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $reports = [
            // Resolved reports
            [
                'date'        => '2026-01-15 10:23:00',
                'comment'     => 'Cet utilisateur a tenu des propos inappropriés pendant le trajet.',
                'is_resolved' => true,
                'reporter'    => 8,
                'reported'    => 9,
            ],
            [
                'date'        => '2026-01-22 14:45:00',
                'comment'     => 'Comportement agressif lors de la prise en charge.',
                'is_resolved' => true,
                'reporter'    => 10,
                'reported'    => 11,
            ],
            [
                'date'        => '2026-02-03 09:12:00',
                'comment'     => 'Le conducteur ne s\'est pas présenté au point de rendez-vous.',
                'is_resolved' => true,
                'reporter'    => 12,
                'reported'    => 13,
            ],
            [
                'date'        => '2026-02-18 16:30:00',
                'comment'     => 'Profil trompeur, les informations ne correspondaient pas à la réalité.',
                'is_resolved' => true,
                'reporter'    => 14,
                'reported'    => 15,
            ],
            [
                'date'        => '2026-02-25 11:05:00',
                'comment'     => 'Retard de plus d\'une heure sans prévenir.',
                'is_resolved' => true,
                'reporter'    => 16,
                'reported'    => 17,
            ],
            [
                'date'        => '2026-03-07 08:55:00',
                'comment'     => 'Conduite dangereuse et vitesse excessive.',
                'is_resolved' => true,
                'reporter'    => 18,
                'reported'    => 17,
            ],
            [
                'date'        => '2026-03-14 13:20:00',
                'comment'     => 'L\'utilisateur a annulé la réservation au dernier moment à plusieurs reprises.',
                'is_resolved' => true,
                'reporter'    => 1,
                'reported'    => 2,
            ],

            // Unresolved reports
            [
                'date'        => '2026-04-01 17:42:00',
                'comment'     => 'Comportement irrespectueux envers les autres passagers.',
                'is_resolved' => false,
                'reporter'    => 10,
                'reported'    => 15,
            ],
            [
                'date'        => '2026-04-08 10:15:00',
                'comment'     => 'Le véhicule était dans un état de propreté déplorable.',
                'is_resolved' => false,
                'reporter'    => 16,
                'reported'    => 19,
            ],
            [
                'date'        => '2026-04-12 14:30:00',
                'comment'     => 'Tentative d\'escroquerie, demande de paiement en dehors de la plateforme.',
                'is_resolved' => false,
                'reporter'    => 10,
                'reported'    => 18,
            ],
            [
                'date'        => '2026-04-19 09:00:00',
                'comment'     => 'Musique trop forte malgré plusieurs demandes.',
                'is_resolved' => false,
                'reporter'    => 12,
                'reported'    => 17,
            ],
            [
                'date'        => '2026-04-22 11:35:00',
                'comment'     => 'Le passager a laissé ses affaires dans le véhicule intentionnellement.',
                'is_resolved' => false,
                'reporter'    => 13,
                'reported'    => 11,
            ],
            [
                'date'        => '2026-05-02 15:50:00',
                'comment'     => 'Faux avis laissés sur le profil pour nuire à la réputation.',
                'is_resolved' => false,
                'reporter'    => 11,
                'reported'    => 12,
            ],
            [
                'date'        => '2026-05-10 08:20:00',
                'comment'     => 'Utilisation d\'un compte avec une fausse identité.',
                'is_resolved' => false,
                'reporter'    => 13,
                'reported'    => 14,
            ],
            [
                'date'        => '2026-05-28 16:10:00',
                'comment'     => 'Harcèlement par messages après le trajet.',
                'is_resolved' => false,
                'reporter'    => 15,
                'reported'    => 16,
            ],
        ];

        $this->db->table('Report')->insertBatch($reports);
    }
}
