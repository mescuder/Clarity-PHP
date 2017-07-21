<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Run;

function parseOptions(array &$options, &$runName, &$flowcellId, &$outFile, &$server) {
    foreach ($options as $option => $value) {
        switch ($option) {
            case 'run-name':
                $runName = $value;
                break;
            case 'flowcell-id':
                $flowcellId = $value;
                break;
            case 'outfile':
                $outFile = $value;
                break;
            case 'server':
                $server = $value;
                break;
        }
    }
}

// Characters: boolean; Followed by a colon: required value; Followed by two colons: optional value
$shortOpts = '';
$longOpts = array('run-name::', 'flowcell-id::', 'outfile::', 'server:');
$options = getopt($shortOpts, $longOpts);

$cwd = realpath('.');
$runName = basename($cwd);
$flowcellId = '';
$outFile = '';
$server = 'prod';

parseOptions($options, $runName, $flowcellId, $outFile, $server);
$run = new Run();
if (!empty($flowcellId)) {
    $run->setFlowcellId($flowcellId);
} elseif (!empty($runName)) {
    $run->setRunName($runName);
    $run->setRunInfoFromRunName();
}

var_dump($run);
