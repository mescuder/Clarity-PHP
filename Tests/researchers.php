<?php

namespace Clarity\Tests;

require_once('autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ResearcherClarityRepository;
//use Clarity\Entity\Researcher;

//$researcher = new Researcher();
//var_dump($researcher);

$connector = new ClarityApiConnector('test');
$repo = new ResearcherClarityRepository($connector);
$me = $repo->find('4');
var_dump($me);
