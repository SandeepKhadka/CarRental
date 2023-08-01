<?php

namespace App\Http\Controllers\MachineLearning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Http;

class ReverseImageSearchController extends Controller
{

    public function uploadImage(Request $request)
    {
        // dd($request->all());
        // Get the uploaded image from the request
        $file = $request->file('image');

        // Send the image to the Flask application
        $client = new Client();
        $response = $client->request('POST', 'http://127.0.0.1:5000', [
            'multipart' => [
                [
                    'name' => 'query_img',
                    'contents' => fopen($file->getPathname(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ]
            ]
        ]);

        // Parse the search results from the Flask application's response
        $results = json_decode($response->getBody(), true);
        $ids = array_map(function ($file_path) {
            $filename = pathinfo($file_path, PATHINFO_FILENAME);
            $last_underscore_pos = strrpos($filename, '__');
            return substr($filename, $last_underscore_pos + 2);
        }, $results);
        // dd($ids);

        // Render the search results in the view
        // return view('search_results', ['results' => $results]);
        // $json_ids = json_encode($ids);
        // $url = route('search', [
        //     'ids' => $json_ids,
        // ]);

        // Redirect to the URL
        // return redirect($url);
        return redirect()->route('search',compact('ids'));
    }


    public function similarImageSearch(Request $request)
    {
        dd($request->all());
    }

    // public function getImagePaths()
    // {
    //     $imageFolder = public_path() . '/uploads/product';
    //     $files = array_diff(scandir($imageFolder), array('.', '..'));
    //     $imagePaths = [];

    //     foreach ($files as $file) {
    //         $imagePaths[] = $imageFolder . '/' . $file;
    //     }

    //     return response()->json($imagePaths);
    // }

    // public function sendImagePaths()
    // {
    //     $imagePaths = $this->getImagePaths();

    //     $client = new Client();
    //     $response = $client->post('http://127.0.0.1:5000', [
    //         'json' => [
    //             'image_paths' => $imagePaths,
    //         ],
    //     ]);

    //     return response()->json(json_decode($response->getBody()));
    // }
}
