<?php

use Illuminate\Support\Facades\File;

foreach (File::allFiles(__DIR__ . '/Routes') as $routeFile) {
    require $routeFile->getPathname();
}
