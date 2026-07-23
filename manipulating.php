<?php

$data = require 'data.php';

function checkIfCountryHasSpaceInTheName(array $country): bool {
    return str_contains($country['country'], ' ');
}

$data = array_filter($data, 'checkIfCountryHasSpaceInTheName');

var_dump($data);