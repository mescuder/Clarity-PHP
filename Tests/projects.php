<?php

namespace Clarity\Tests;

require_once('autoload.php'); 

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ProjectClarityRepository;
//use Clarity\Entity\Project;

//$project = new Project();
//var_dump($project);

$connector = new ClarityApiConnector('test');
$repo = new ProjectClarityRepository($connector);
$myproject = $repo->find('ESC452');
var_dump($myproject);
