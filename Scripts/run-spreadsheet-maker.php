<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityFormatter\ProjectFormatter;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\UdfClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;

$servers = array('oxford', 'prod');
$shortopts = "";
$longopts = array("project-name:");
$options = getopt($shortopts, $longopts);
if (array_key_exists('project-name', $options)) {
    $projectName = $options['project-name'];
    foreach ($servers as $server) {
        $connector = new ClarityApiConnector($server);
        $udfRepo = new UdfClarityRepository($connector);
        $udfRepo->updateProjectUdfs();
        $projectRepo = new ProjectClarityRepository($connector);
        $researcherRepo = new ResearcherClarityRepository($connector);
        $labRepo = new LabClarityRepository($connector);
        
        $projects = $projectRepo->findByName($projectName);
        if (count($projects) == 1) {
            $project = $projects[0];
            $researcher = $researcherRepo->find($project->getResearcherId());
            $lab = $labRepo->find($researcher->getLabId());
            echo $lab->getClarityName();
            exit(0);
        }
    }
}

echo '';
