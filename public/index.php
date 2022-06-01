<?php

declare(strict_types=1);

use LosRomka\Shop\Application;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$_COOKIE['username'] = 'admin';

$application = new Application();

echo $application->run();
