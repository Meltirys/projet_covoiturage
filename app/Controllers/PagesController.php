<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{
    public function home()
    {
        helper('form');

        return view('HomeView');
    }

    public function createJourney()
    {
        helper('form');

        $carModel = model(CarModel::class);
        $cars = $carModel->getCarsByUser(session('user_id')) ?? [];

        $data = [
            'type' => 'drive',
            'cars' => array_map(fn($c) => [
                'id_car' => $c['id_car'],
                'label' => $c['brand'] . ' - ' . $c['model'],
                'seats' => $c['number_of_seat'],
            ], $cars)
        ];

        return view('itinerary/create/CreateView', $data);
    }

    public function searchJourney()
    {
        return view('itinerary/search/SearchView');
    }
}
