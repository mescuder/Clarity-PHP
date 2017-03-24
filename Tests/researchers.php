<?php

namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Entity\Researcher;
use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\LabClarityRepository;
//use Clarity\Entity\Researcher;

//$researcher = new Researcher();
//var_dump($researcher);

$connector = new ClarityApiConnector('test');
$researcherRepo = new ResearcherClarityRepository($connector);
$myresearcher = $researcherRepo->find('654');
var_dump($myresearcher);

/*
$labRepo = new LabClarityRepository($connector);
$mylab = $labRepo->findByName('Test lab Micka API');
$researcher = new Researcher();
$researcher->setFirstName('Micka');
$researcher->setLastName('Bioinformatics');
$researcher->setEmail('test@example.com');
$researcher->setLabUri($mylab->getClarityUri());
$researcher->setUsername('mickatest');
$researcher->setPassword('testpassword');
$researcher->setRole('Collaborator');
$researcher->setInitials('MBX');
$researcher->researcherToXml();
var_dump($researcher);
echo PHP_EOL;
//$newResearcher = $researcherRepo->save($researcher);
//var_dump($newResearcher);
*/
