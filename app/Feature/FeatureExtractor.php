<?php

namespace App\Feature;

use PIL\Image;
use Tensorflow\Tensor;
use Tensorflow\TensorShape;
use Tensorflow\Types;
use Tensorflow\Graph;
use Tensorflow\Session;

class FeatureExtractor
{
    protected $modelPath;

    public function __construct()
    {
        $this->modelPath = public_path('models/tensorflow_inception_graph.pb');
    }

    public function extract(Image $image)
    {
        $graph = new Graph();
        $graphDef = file_get_contents($this->modelPath);
        $graph->import($graphDef, '');
        $tensor = $this->preprocessImage($image);
        $session = new Session($graph);
        $result = $session->run(
            ['pool_3/_reshape:0'],
            ['input:0' => $tensor],
            []
        );
        return $result[0]->data();
    }

    protected function preprocessImage(Image $image)
    {
        $width = 299;
        $height = 299;
        $image = $image->resize([$width, $height]);
        $data = $image->getdata();
        $data = array_map(function ($pixel) {
            return [$pixel[0], $pixel[1], $pixel[2]];
        }, $data);
        $data = array_chunk($data, $width);
        $data = array_map(function ($row) {
            return [implode('', array_column($row, 0)), implode('', array_column($row, 1)), implode('', array_column($row, 2))];
        }, $data);
        $data = array_chunk($data, $height);
        $data = array_map(function ($chunk) {
            return implode('', array_column($chunk, 0)) . implode('', array_column($chunk, 1)) . implode('', array_column($chunk, 2));
        }, $data);
        $data = array_map(function ($byteString) {
            return array_map(function ($byte) {
                return ord($byte);
            }, str_split($byteString));
        }, $data);
        $data = array_values($data);
        return new Tensor($data, Types::UINT8, new TensorShape([1, $width, $height, 3]));
    }
}
