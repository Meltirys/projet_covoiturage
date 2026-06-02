<?php

if (!function_exists('format_date_fr')) {
    function format_date_fr(string $datetime): string
    {
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
if (!function_exists('secondsToTime')) {
    function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
    }
}
