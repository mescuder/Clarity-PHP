<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;
use Clarity\Entity\Project;
use Clarity\Entity\Researcher;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;

function parseOptions(&$options) {
    if (array_key_exists('p', $options) && array_key_exists('project', $options)) {
        exit('Both -p and --project options were provided. Pick only one' . PHP_EOL);
    } elseif (array_key_exists('project', $options)) {
        return $options['project'];
    } elseif (array_key_exists('p', $options)) {
        return $options['p'];
    } else {
        exit('No project name or ID was provided' . PHP_EOL);
    }
}

$connector = new ClarityApiConnector('prod');
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);
$labRepo = new LabClarityRepository($connector);

$shortopts = "p:";
$longopts = array("project:");
$options = getopt($shortopts, $longopts);

$search = parseOptions($options);
$projects = $projectRepo->lookForProject($search);

$yamlArray = array();
foreach ($projects as $project) {
    $projectId = $project->getClarityId();
    $researcher = $researcherRepo->find($project->getResearcherId());
    $lab = $labRepo->find($researcher->getLabId());
    $researcher->setLab($lab);
    $project->setResearcher($researcher);
    $yamlArray[$projectId]['Project ID'] = $projectId;
    $yamlArray[$projectId]['Project Name'] = $project->getClarityName();
    $yamlArray[$projectId]['Researcher'] = $project->getResearcher()->getFullName();
    foreach ($project->getClarityUDFs() as $udf => $value) {
        $yamlArray[$projectId]['UDFs'][$udf] = $value;
    }
}
echo yaml_emit($yamlArray) . PHP_EOL;
