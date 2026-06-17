<?php

namespace App\Services;

use App\Models\TrackModel;
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
     * Save the track in the database.
     * @param array $start The starting point of the track in an array form. First value of the array must longitude and the the second one is latitude
     * @param array $end The end point of the track
     * @param array $stops Optional : Stops on the track
     * @param ?int $trackId = null Optional : Existing track ID for editing
     * 
     * @return int The id of the newly created track
     */
    public function saveTrack(array $start, array $end, array $stops = [], ?int $trackId = null): int
    {
        helper('french');
        $coordinates = $this->buildCoordinates($start, $end, $stops);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-car/geojson");
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

        $data = json_decode($response, true);

        if (empty($data['features'])) return false;

        //Retrieving the geometries
        $geometry = $data['features'][0]['geometry'];               // LineString GeoJSON
        $summary  = $data['features'][0]['properties']['summary'];  // Distance & duration

        // Saving in database
        $trackModel = model(TrackModel::class);

        $data = [
            'geojson'  => json_encode($geometry),   // The complete geometry
            'distance' => $summary['distance'],     // The number of meters
            'duration' => $summary['duration'],     // The duration
        ];

        // If $trackId isn't null, updates its existing row instead of inserting a new one
        if ($trackId !== null) {
            $saved = $trackModel->update($trackId, $data);

            if (!$saved) {
                throw new \RuntimeException('Impossible de créer le tracé');
            }

            return $trackId;
        }

        return $trackModel->insert($data);
    }

    /**
     * Build the coordinates for the api. It takes arrays in parameters. Each arrays must be coordinates array. The longitude is the first element expected and latitude is the second.
     * @param array $start The starting point of the track in an array form.
     * @param array $end The end point of the track
     * @param array $stops Optional : Stops on the track
     * 
     * @return string A string that is understable for the OpenRouteService api that contains all the coordinates of the track
     */
    private function buildCoordinates(array $start, array $end, array $stops = []): string
    {
        $res = "[";

        $res .= "[" . $start[0] . ',' . $start[1] . "], ";

        foreach ($stops as $stop) {
            $res .= "[" . $stop[0] . ',' . $stop[1] . "], ";
        }

        $res .= "[" . $end[0] . ',' . $end[1] . "]";

        $res .= "]";

        return $res;
    }
}
