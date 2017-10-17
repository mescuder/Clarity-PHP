<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityFormatter\SampleFormatter;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\SampleClarityRepository;

/*
 * FUNCTIONS
 */

function parseOptions(&$options, &$search, &$input, &$format, &$server)
{
    if (array_key_exists('sample-id', $options)) {
        $input = 'sample-id';
    } elseif (array_key_exists('sample-name', $options)) {
        $input = 'sample-name';
    } elseif (array_key_exists('project-id', $options)) {
        $input = 'project-id';
    } elseif (array_key_exists('project-name', $options)) {
        $input = 'project-name';
    } elseif (array_key_exists('fastq', $options)) {
        $input = 'fastq';
    } else {
        echo 'No input option provided' . PHP_EOL;
        usage();
        exit;
    }
    $search = $options[$input];
    
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
    $message .= 'php sampleFinder.php --sample-id|--sample-name|--project-id|--project-name|--fastq <search value> [--format yaml] [--server <test or prod>]';
    return $message;
}

/*
 * MAIN
 */

$format = 'yaml';
$server = 'prod';
$search = '';
$input = '';

$shortopts = '';
$longopts = array('sample-id:', 'sample-name:', 'project-id:', 'project-name:', 'format:', 'server:', 'fastq:');
$options = getopt($shortopts, $longopts);

parseOptions($options, $search, $input, $format, $server);

if (empty($search)) {
    echo 'No search value was provided' . PHP_EOL . usage() . PHP_EOL;
    exit;
}

$connector = new ClarityApiConnector($server);
$sampleRepo = new SampleClarityRepository($connector);
$projectRepo = new ProjectClarityRepository($connector);
$researcherRepo = new ResearcherClarityRepository($connector);
$labRepo = new LabClarityRepository($connector);
$sampleFormatter = new SampleFormatter();

$samples = $sampleRepo->lookForSamples($search, $input, $projectRepo, $researcherRepo, $labRepo);
echo $sampleFormatter->formatSamples($samples, $format);
