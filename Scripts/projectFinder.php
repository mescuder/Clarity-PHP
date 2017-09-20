<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;
use Clarity\Entity\Project;
use Clarity\Entity\Researcher;
use Clarity\EntityFormatter\ProjectFormatter;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;

function parseOptions(&$options) {
    if (array_key_exists('p', $options) && array_key_exists('project', $options)) {
        trigger_error('Both -p and --project options were provided. Pick only one.');
        exit;
    } elseif (array_key_exists('project', $options)) {
        return $options['project'];
    } elseif (array_key_exists('p', $options)) {
        return $options['p'];
    } else {
        trigger_error('No project name or ID was provided.');
        exit;
    }
}

$connector = new ClarityApiConnector('prod');
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);
$labRepo = new LabClarityRepository($connector);
$outputFormat = 'yaml';
$formatter = new ProjectFormatter();

$shortopts = "p:";
$longopts = array("project:");
$options = getopt($shortopts, $longopts);

$search = parseOptions($options);
$projects = $projectRepo->lookForProject($search, $researcherRepo, $labRepo);
foreach ($projects as $project) {
    echo yaml_emit($formatter->asYAML($project));
}
