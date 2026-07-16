<?php

$data = require 'data.php';

$count = 0;

// Passamos o $count como referência, pois iremos alterar o seu valor
array_walk($data, function () use(&$count){
    $count++;
});

echo "The number of countries participating is: $count\n";