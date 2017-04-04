<?php


namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php'); 

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ContainerClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\SampleClarityRepository;
use Clarity\Entity\Tube;
use Clarity\Entity\Researcher;
use Clarity\Entity\Project;
use Clarity\Entity\Sample;


$connector = new ClarityApiConnector('test');
$sampleRepo = new SampleClarityRepository($connector);
$containerRepo = new ContainerClarityRepository($connector);
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);


$sample = $sampleRepo->find('BIO901A1');
$oldcomment = $sample->getClarityUDF('User Comments old')['value'];
$sample->setClarityUDFs(array(
    'User Comments old' => array('name' => 'User Comments old', 'value' => ''),
    'User Comments' => array('name' => 'User Comments', 'value' => $oldcomment)
));
//$sample->setClarityUDF(array('name' => 'User Comments old', 'value' => 'This is a comment'));
$sample->sampleToXml();
$sample = $sampleRepo->save($sample);
echo $sample->getXml() . PHP_EOL;


// Whole submission
/*
$tube = new Tube();
$typeUri = $containerRepo->getConnector()->getBaseUrl() . '/containertypes/' . $tube->getTypeId();
$tube->setTypeUri($typeUri);
$tube->containerToXml();
$tube = $containerRepo->save($tube);
$project = $projectRepo->find('BIO901');
$researcher = $researcherRepo->find('654');

$newSample = new Sample();
$newSample->setContainerId($tube->getClarityId());
$newSample->setContainerUri($tube->getClarityUri());
$newSample->setContainerLocation('1:1');
$newSample->setClarityName('PHP submission 2');
$newSample->setProjectId($project->getClarityId());
$newSample->setProjectUri($project->getClarityUri());
$newSample->setSubmitterFirst($researcher->getFirstName());
$newSample->setSubmitterLast($researcher->getLastName());
$newSample->setSubmitterUri($researcher->getClarityUri());
$udfs = array();
$udfs['End Type'] = array(
    'name'  => 'End Type',
    'value' => 'Paired End'
);
$udfs['Read Length'] = array(
    'name'  => 'Read Length',
    'value' => '100'
);
$udfs['Sample Type'] = array(
    'name'  => 'Sample Type',
    'value' => 'gDNA'
);
$udfs['Volume (uL)'] = array(
    'name'  => 'Volume (uL)',
    'value' => 20
);
$newSample->setClarityUDFs($udfs);
$newSample->sampleToXml();
echo $newSample->getXml() . PHP_EOL;
$newSample = $sampleRepo->save($newSample);
var_dump($newSample);
 * 
 */
