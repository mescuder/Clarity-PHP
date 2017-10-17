<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityFormatter\ProjectFormatter;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;

/*
 * FUNCTIONS
 */

function parseOptions(&$options, &$search, &$input, &$format, &$server)
{
    if (array_key_exists('project-id', $options)) {
        $input = 'project-id';
        $search = $options['project-id'];
    } elseif (array_key_exists('project-name', $options)) {
        $input = 'project-name';
        $search = $options['project-name'];
    } elseif (array_key_exists('sample-id', $options)) {
        $input = 'sample-id';
        $search = $options['sample-id'];
    } elseif (array_key_exists('fastq', $options)) {
        $input = 'fastq';
        $search = $options['fastq'];
    }

    if (array_key_exists('format', $options)) {
        $format = $options['format'];
    }

    if (array_key_exists('server', $options)) {
        $server = $options['server'];
    }
}

function usage()
{
    $message = 'Usage: ' . PHP_EOL;
    $message .= 'php projectFinder.php --project-id|--project-name|--sample-id|--fastq <search value> [--format yaml] [--server <test or prod>]';
    return $message;
}

/*
 * MAIN
 */

$format = 'yaml';
$server = 'prod';
$search = '';
$input = 'project-id';

$shortopts = "";
$longopts = array("project-id:", "project-name:", "format:", "server:", "sample-id:", "fastq:");
$options = getopt($shortopts, $longopts);

parseOptions($options, $search, $input, $format, $server);

if (empty($search)) {
    echo 'No search value was provided' . PHP_EOL . usage() . PHP_EOL;
    exit;
}

$connector = new ClarityApiConnector($server);
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);
$labRepo = new LabClarityRepository($connector);
$projectFormatter = new ProjectFormatter();

$projects = $projectRepo->lookForProjects($search, $input, $researcherRepo, $labRepo);
foreach ($projects as $project) {
    echo $projectFormatter->format($project, $format);
}
