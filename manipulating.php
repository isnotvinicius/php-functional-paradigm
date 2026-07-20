<?php

$data = require 'data.php';

$modifiedArray = array_map(function (array $data) {
    $data['country'] = strtoupper($data['country']);
    return $data;
}, $data);

var_dump($modifiedArray);