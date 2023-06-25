<?php
require_once 'Transport.php';
require_once 'Bicycle.php';
require_once 'Boat.php';
require_once 'Car.php';

$bicycle = new Bicycle('Azimuth Scorpio', 15, 18);
$car = new Car('Tesla', 60, 5);
$car2 = new Car('Lamborghini', 120, 4);
$boat = new Boat('Razor', 40, 5);

$boat->setPassengers(5);
echo $car->startEngine() . "<br>";
echo $bicycle->ringBell() . "<br>";
echo $boat->sail() . "<br>";


$data = [$bicycle, $car, $car2, $boat];

$transport = new Transport();

var_dump($transport->getAllObjects($data));
