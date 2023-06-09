<?php

define('base_url', '/BIN_Checker/api/');

function myRoutes($uri)
{
    switch ($uri) {
        case base_url . "checker":
            include 'checker.php';

            break;

        case base_url . "checker_1":
            include 'checker1.php';

            break;
        case base_url . "checker_2":
            include 'checker2.php';

            break;
        case base_url . "checker_3":
            include 'checker3.php';

            break;
        default:
            echo '404 Page Not Found';
            break;
    }
}

$uri = $_SERVER['REQUEST_URI'];
myRoutes($uri);
