<?php

namespace App\Services;

use App\Models\TrackModel;
use Config\OpenRoutesServices;

class TrackService
{

    private string $apiKey;
    private TrackModel $db;

    public function __construct()
    {
        $config = config(OpenRoutesServices::class);
        $this->apiKey = $config->apiKey;
        $this->db = model(TrackModel::class);
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

        if (empty($data['features'])) {
            log_message('error', 'No features. Full response: ' . json_encode($data));
            throw new \RuntimeException('ORS returned no route');
        }

        //Retrieving the geometries
        $geometry = $data['features'][0]['geometry'];               // LineString GeoJSON
        $summary  = $data['features'][0]['properties']['summary'];  // Distance & duration

        // Saving in database
        $data = [
            'geojson'  => json_encode($geometry),   // The complete geometry
            'distance' => $summary['distance'],     // The number of meters
            'duration' => $summary['duration'],     // The duration
        ];

        // If $trackId isn't null, updates its existing row instead of inserting a new one
        if ($trackId !== null) {
            $saved = $this->db->update($trackId, $data);

            if (!$saved) {
                throw new \RuntimeException('Impossible de créer le tracé');
            }

            return $trackId;
        }

        $insertId = $this->db->insert($data, true);

        if (!$insertId) {
            log_message('error', 'Track insert failed');
            log_message('error', json_encode($this->db->errors()));
            log_message('error', json_encode($data));
        }

        return $insertId;
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
        $coordinates = [$start];

        foreach ($stops as $stop) {
            if (isset($stop[0], $stop[1])) {
                $coordinates[] = $stop;
            }
        }

        $coordinates[] = $end;

        return json_encode($coordinates);
    }

    /**
     * Checks if a given point is on a given track, within a given range of distance.
     * @param array $startPoint An array where the first element is the longitude and the second element is the longitude. No keys needed
     * @param ?array $endPoint An array where the first element is the longitude and the second element is the longitude. No keys needed
     * @param int $idTrack The id of the track
     * @param int $maxDistance Optionnal: The maximum distance between the point and a point on of the track, in meters. Default is 2500m
     * 
     * @return bool True if the given point is on track, false otherwise
     */
    public function isOnTrack(array $startPoint, ?array $endPoint, int $idTrack, int $maxDistance = 2500): bool
    {

        $track = $this->db->find($idTrack);
        $json = json_decode($track['geojson']); // We retrieve the points 
        $trackPoints = $json->coordinates;
        $startValidated = false;
        $endValidated = is_null($endPoint) ? true : false; //If no end points are given, then it's true by default


        foreach ($trackPoints as $trackPoint) {

            $distance = haversine_distance(
                ($startValidated ? $endPoint : $startPoint)[0], //If the start is validated, we search the end, if not we search the start
                ($startValidated ? $endPoint : $startPoint)[1], //If the start is validated, we search the end, if not we search the start
                $trackPoint[0],
                $trackPoint[1]
            );

            if ($distance < $maxDistance) {
                $startValidated ? $endValidated = true : $startValidated = true; //Validates the tested point
            }

            // When both starting point and end point are on the track, stops the execution and returns true
            if ($startValidated && $endValidated) return true;
        }

        return false;
    }
}
