<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CarModel;

class PagesController extends BaseController
{
    /**
     * Home page
     */
    public function home()
    {
        helper('form');

        return view('HomeView');
    }

    /**
     * Journey creation page
     */
    public function createJourney()
    {
        helper('form');

        $carModel = model(CarModel::class);

        $userId = session()->get('user_id');

        $cars = $carModel->getCarsByUser($userId);

        $data = [
            'cars' => array_map(fn($c) => [
                'id_car' => $c['id_car'],
                'label' => $c['brand'] . ' - ' . $c['model'],
                'seats' => $c['number_of_seat'],
            ], $cars)
        ];

        return view('itinerary/create/CreateView', $data);
    }

    /**
     * Itinerary search page
     */
    public function searchJourney()
    {
        helper('form');

        return view('itinerary/search/SearchView');
    }
}
