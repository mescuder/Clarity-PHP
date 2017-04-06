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

//$samples = $sampleRepo->findAll();
//foreach ($samples as $sample) {
//    echo $sample->getClarityId() . PHP_EOL;
//}

/*
$sample = $sampleRepo->find('BAR716A1');
echo $sample->getXml() . PHP_EOL;
$oldcomment = $sample->getClarityUDF('User Comments old');
$sample->setClarityUDFs(array(
    'User Comments old' => '',
    'User Comments' => $oldcomment,
));
$sample->sampleToXml();
$sample = $sampleRepo->save($sample);
echo $sample->getXml() . PHP_EOL;
 * 
 */
$sample = $sampleRepo->find('BAR716A1');
$sample->sampleToXml();
var_dump($sample);

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
$udfs['End Type'] = 'Paired End';
$udfs['Read Length'] = '100';
$udfs['Sample Type'] = 'gDNA';
$udfs['Volume (uL)'] = 20;
$newSample->setClarityUDFs($udfs);
$newSample->sampleToXml();
echo $newSample->getXml() . PHP_EOL;
$newSample = $sampleRepo->save($newSample);
var_dump($newSample);
 * 
 */
