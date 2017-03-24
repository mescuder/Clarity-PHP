<?php


namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php'); 

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\SampleClarityRepository;
use Clarity\Entity\Sample;


$connector = new ClarityApiConnector('test');
$sampleRepo = new SampleClarityRepository($connector);

$sample = $repo->find('COD731A25');
//var_dump($repo->getXml());
echo $repo->getXml()->asXML();
echo PHP_EOL;
var_dump($sample);

/*
$newSample = new Sample();
$newSample->setContainerId('27-1401');
$newSample->setContainerUri('');
$newSample->setContainerLocation('1:1');
$newSample->setClarityName('PHP submission 1');
$newSample->setProjectId('ESC452');
$newSample->setProjectUri('');
$newSample->setSubmitterFirst('Mickael');
$newSample->setSubmitterLast('Escudero');
$newSample->setSubmitterUri('');
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
    'value' => 'blabla'
);
$udfs['Volume (uL)'] = array(
    'name'  => 'Volume (uL)',
    'value' => 20
);
$newSample->setClarityUDFs($udfs);
//var_dump($newSample);
$repo->setSample($newSample);
$answer = $repo->save();
echo $answer;
 * 
 */
