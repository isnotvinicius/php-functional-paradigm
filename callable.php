<?php

function bar(callable $func): void
{
    echo "Running another function: ";
    echo $func();
}

$foo = function() {
    return 'Another function';
};

bar($foo);