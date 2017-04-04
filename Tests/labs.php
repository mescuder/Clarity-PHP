<?php

namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php');

//use Clarity\Entity\Lab;
use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\LabClarityRepository;

$connector = new ClarityApiConnector('test');
$repo = new LabClarityRepository($connector);


$mylab = $repo->find('202');
var_dump($mylab);

/*
$mylab->setClarityName('Test lab Micka API');
$mylab->labToXml();
$renamedlab = $repo->save($mylab);
var_dump($renamedlab);
echo PHP_EOL;
*/

//$mylab2 = $repo->findByName('Test lab Micka API');
//var_dump($mylab2);

/*
$lab = new Lab();
$lab->setClarityName('Renamed test lab Micka API');
$lab->labToXml();
var_dump($lab);
$newLab = $repo->save($lab);
var_dump($newLab);
*/
