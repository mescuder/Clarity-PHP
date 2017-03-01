<?php

namespace Clarity\Tests;

require_once('autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\LabClarityRepository;

$connector = new ClarityApiConnector('test');
$repo = new LabClarityRepository($connector);
$babs = $repo->find('2');
var_dump($babs);
