<?php

require 'GoogleUrlApi.php';


// Create instance with key
$key = 'AIzaSyAi_r5GCQCRjEnoyN7c6LchevXGW1BiKQ4';
$googer = new GoogleURLAPI($key);

// Test: Shorten a URL
$shortDWName = $googer->shorten("http://dejanstojanovic.net/jquery-javascript/2016/january/copy-text-value-to-clipboard-using-jquery/");
echo $shortDWName; // returns http://goo.gl/i002

// Test: Expand a URL
$longDWName = $googer->expand($shortDWName);
echo $longDWName; // returns https://davidwalsh.name

?>
