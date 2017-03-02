<?php

namespace Clarity\Tests;

require_once('autoload.php');

use Clarity\Entity\Lab;
use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\LabClarityRepository;

$connector = new ClarityApiConnector('test');
$repo = new LabClarityRepository($connector);


//$babs = $repo->find('2');
//var_dump($babs);


$lab = new Lab();
$lab->setClarityName('this is a test');
$lab->labToXml();
//var_dump($lab);

