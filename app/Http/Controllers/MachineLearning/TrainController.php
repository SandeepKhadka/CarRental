<?php

namespace App\Http\Controllers\MachineLearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Train;

// use App\Train;

class TrainController extends Controller
{
    public function extractFeatures()
    {
        $train = new Train();
        $train->extract('public/uploads/similar_images');
        return 'Features extracted successfully.';
    }
}
