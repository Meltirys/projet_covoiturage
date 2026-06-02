<?php

namespace App\Services;

use Config\OpenRoutesServices;

class TrackService
{

    private string $apiKey;

    public function __construct()
    {
        $config = config(OpenRoutesServices::class);
        $this->apiKey = $config->apiKey;
    }

    /**
     * @param array $start
     * @param array $end
     * @param array $stops
     * 
     * @return bool
     */
    public function saveTrack(array $start, array $end, array $stops = []): bool
    {
        $coordinates = $this->buildCoordinates($start, $end, $stops);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":' . $coordinates . '}');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
            "Authorization: " . $this->apiKey,
            "Content-Type: application/json; charset=utf-8"
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        var_dump($response);

        return true;
    }

    /**
     * Build the coordinates for the api
     * @param array $start The starting point of the track 
     * @param array $end The end point of the track
     * @param array $stops Optionnal : Stops on the track
     * 
     * @return string A string that is understable for the OpenRouteService api that contains all the coordinates of the track
     */
    private function buildCoordinates(array $start, array $end, array $stops = []) : string{
        $res = "[";

        $res .= "[" . $start['longitude'] . ',' . $start['latitude'] . "], ";

        foreach($stops as $stop){
            $res .= "[" . $stop['longitude'] . ',' . $stop['latitude'] . "], ";
        }

        $res .= "[" . $end['longitude'] . ',' . $end['latitude'] . "]";

        $res .= "]";

        var_dump($res);

        return $res;

    }
}
