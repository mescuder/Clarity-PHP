<?php

namespace Clarity\Tests;

require_once('autoload.php'); 

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ContainerClarityRepository;
//use Clarity\Entity\Tube;


$connector = new ClarityApiConnector('test');
$repo = new ContainerClarityRepository($connector);

$tube = $repo->find('27-1401');
//var_dump($repo->getXml());
echo $repo->getXml()->asXML();
echo PHP_EOL;
var_dump($tube);

//$newTube = new Tube();
//$repo->setContainer($newTube);
//$answer = $repo->save();
//echo $answer;
