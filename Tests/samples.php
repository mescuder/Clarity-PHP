<?php


namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\ContainerClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\SampleClarityRepository;
use Clarity\EntityRepository\UdfClarityRepository;
use Clarity\Entity\Tube;
use Clarity\Entity\Researcher;
use Clarity\Entity\Project;
use Clarity\Entity\Sample;


$connector = new ClarityApiConnector('test');
$udfRepo = new UdfClarityRepository($connector);
$sampleRepo = new SampleClarityRepository($connector);
$containerRepo = new ContainerClarityRepository($connector);
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);

$udfRepo->updateSampleUdfs();
//$samples = $sampleRepo->findAll();
//foreach ($samples as $sample) {
//    echo $sample->getClarityId() . PHP_EOL;
//}


$sample = $sampleRepo->find('BIO901A2');
$sample->setClarityUDF('Test multiline', 'This is a multiline comment');
$sample->sampleToXml();
$sample = $sampleRepo->save($sample);
echo $sample->getXml();

/*
echo $sample->getXml() . PHP_EOL;
$oldcomment = $sample->getClarityUDF('User Comments old');
$sample->sampleToXml();
$sample = $sampleRepo->save($sample);
echo $sample->getXml() . PHP_EOL;
 *
 */
/*
$sample = $sampleRepo->find('ESC452A1');
$sample->sampleToXml();
echo $sample->getXml();
//var_dump($sample);
*/

// Whole submission
/*
$tube = new Tube();
$typeUri = $containerRepo->getConnector()->getBaseUrl() . '/containertypes/' . $tube->getTypeId();
$tube->setTypeUri($typeUri);
$tube->containerToXml();
$tube = $containerRepo->save($tube);
$project = $projectRepo->find('BIO1103');
$researcher = $researcherRepo->find('858');
*/

/*
$newSample = new Sample();
//$newSample->setContainerId($tube->getClarityId());
//$newSample->setContainerUri($tube->getClarityUri());
$newSample->setContainerLocation('1:1');
$newSample->setClarityName('Test 3');
//$newSample->setProjectId($project->getClarityId());
//$newSample->setProjectUri($project->getClarityUri());
//$newSample->setSubmitterFirst($researcher->getFirstName());
//$newSample->setSubmitterLast($researcher->getLastName());
//$newSample->setSubmitterUri($researcher->getClarityUri());
$newSample->setClarityUDF('C1 Application', 'test');
$newSample->sampleToXml();
echo $newSample->getXml();
exit;
$newSample = $sampleRepo->save($newSample);
var_dump($newSample);
*/
