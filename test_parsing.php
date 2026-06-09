<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = Illuminate\Http\Request::create('/services', 'GET', [
    'city' => 'Karachi',
    'locations' => ['Lahore, Pakistan'],
    'sort' => 'price_asc'
]);
// Let's dump the request array to see if it parses correctly
var_dump($req->all());
$q = \App\Models\Service::query();
$q->whereIn('location', $req->locations);
echo "Count matching locations IN ['Lahore, Pakistan']: " . $q->count() . "\n";

$req2 = Illuminate\Http\Request::create('/services?locations[]=Lahore,+Pakistan', 'GET');
var_dump($req2->all());
