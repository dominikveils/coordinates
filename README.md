## Install
```bash
$ composer require dominikveils/coordinates
```
## Usage
Usage example:
```php
<?php

require('vendor/autoload.php');

$coordinates = new DominikVeils\Geo\Coordinates;

$location1 = [
  'latitude' => 20.108218,
  'longitude' => -32.925546
];
$location2 = [
  'latitude' => 19.145051,
  'longitude' => -32.607256
];

$distance = $coordinates->distance($location1, $location2);

echo "Distance is: {$distance}km", PHP_EOL; // 112m


$locations = [
  [-47.572593, 25.206617],
  [-47.759626, 25.206617],
  [-47.755709, 25.643596],
  [-47.531959, 25.630001]
];

$latitude = -47.645916;
$longitude = 25.385293;

$contains = $coordinates->contains($latitude, $longitude, $locations);

var_dump($contains); // TRUE

$latitude = 20.108218;
$longitude = -32.925546;

$contains = $coordinates->contains($latitude, $longitude, $locations);

var_dump($contains); // FALSE
```
