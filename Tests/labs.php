<?php

namespace Clarity\Tests;

require_once('autoload.php');

use Clarity\Entity\Lab;
use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\LabClarityRepository;

$connector = new ClarityApiConnector('test');
$repo = new LabClarityRepository($connector);


$mylab = $repo->find('202');
var_dump($mylab);

echo PHP_EOL;

/*
$lab = new Lab();
$lab->setClarityName('Test lab Micka API');
$lab->labToXml();
//var_dump($lab);
$newLab = $repo->save($lab);
var_dump($newLab);
*/
