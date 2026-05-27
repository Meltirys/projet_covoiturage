<?php

namespace App\Controllers\Journey;

use App\Controllers\BaseController;
use App\Models\JourneyRequestModel;
use App\Services\LocationService;

class RequestJourneyController extends BaseController
{
    public function index()
    {
        $requestModel = new JourneyRequestModel();
        $allRequest = $requestModel->findAll();
        return view('i');
    }

    
    public function create()
    {
        return view('itinerary/create/create_request_form');
    }

    public function save()
    {
        $post = $this->request->getPost();
        $rangeTime = $post['range-start'] . '-' . $post['range-end'];
        $locationService = new LocationService();
        $startLocationId = $locationService->getOrCreate(
            $post['start']['label'],
            $post['start']['city'],
            $post['start']['postcode'],
            $post['start']['lat'] ?? null,
            $post['start']['lon'] ?? null,
        );
        $endLocationId = $locationService->getOrCreate(
            $post['end']['label'],
            $post['end']['city'],
            $post['end']['postcode'],
            $post['end']['lat'] ?? null,
            $post['end']['lon'] ?? null,
        );
        $requestModel = new JourneyRequestModel();
        $requestModel->insert([
            'description'   => $post['description'],
            'range_of_time' => $rangeTime,
            'start'         => $startLocationId,
            'end'           => $endLocationId,
            'id_user'       => session('user_id'),
        ]);
        return redirect()->to('journey-request/')
            ->with('success', 'Votre annonce a été publiée');

    }
}
