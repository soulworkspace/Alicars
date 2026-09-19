<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;

echo "<pre>";

$command = 'storage:link';

Artisan::call($command);
echo ">>> {$command}\n";
echo Artisan::output();

echo "\n---------------------------------\n";
echo "Done!";