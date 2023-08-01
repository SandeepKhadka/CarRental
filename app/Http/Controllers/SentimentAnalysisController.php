<?php

namespace App\Http\Controllers;



Use Sentiment\Analyzer;

class SentimentAnalysisController extends Controller
{

    public function analyzeSentiment($reviewText)
    {
        $analyzer = new Analyzer(); 
        // returns true or false
        $output_text = $analyzer->getSentiment($reviewText);
    }
}
