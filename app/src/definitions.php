<?php

require_once  APP_ROOT . '/src/Config.php';
require_once  APP_ROOT . '/src/Db.php';

use function DI\create;

return [
    'config' => create(Config::class),
    'db' => create(Db::class)
];