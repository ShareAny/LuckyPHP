<?php

use CodeMommy\WebPHP\Environment;

return array(
    // Route Type: pathinfo, map or symfony
    'type' => 'symfony',
    // Route Configure
    // any, get, post...
    'get' => array(
        '/' => 'IndexController.index'
    )
);