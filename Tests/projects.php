<?php

namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php'); 

//use Clarity\Entity\Project;
//use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\UdfClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
//use Clarity\Entity\Project;

//$project = new Project();
//var_dump($project);

$connector = new ClarityApiConnector('test');
$projectRepo = new ProjectClarityRepository($connector);
$udfRepo = new UdfClarityRepository($connector);
//$researcherRepo = new ResearcherClarityRepository($connector);

$udfRepo->updateProjectUdfs();
$myproject = $projectRepo->find('ESC452');
//$myproject->setFiles(array());
$myproject->projectToXml();
echo $myproject->getXml() . PHP_EOL;
//$myproject = $projectRepo->save($myproject);
//echo $myproject->getXml() . PHP_EOL;
//var_dump($myproject);

/*
$myresearcher = $researcherRepo->find('654');
$newproject = new Project();
$newproject->setClarityName('Micka API project');
$newproject->setOpenDate('2017-03-14');
$newproject->setResearcherUri($myresearcher->getClarityUri());

$myproject = $projectRepo->find('BIO901');
$myproject->setClarityUDF('Funding source', 'Internal');
$myproject->projectToXml();
var_dump($myproject);
//var_dump($newproject);
$updatedproject = $projectRepo->save($myproject);
var_dump($updatedproject);
*/
