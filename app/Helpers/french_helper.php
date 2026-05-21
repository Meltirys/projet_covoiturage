<?php

if (!function_exists('format_date_fr')) {
    function format_date_fr(string $datetime): string {
        $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
        $timestamp   = strtotime($datetime);
        $jour  = $jours[date('w', $timestamp)];
        $num   = date('d', $timestamp);
        $month = $mois[(int) date('n', $timestamp) - 1];
        $time  = date('H\hi', $timestamp);

        return "$jour. $num $month - $time";
    }
}


?>