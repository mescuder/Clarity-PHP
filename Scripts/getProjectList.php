<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;
use Clarity\Entity\Researcher;
use Clarity\Entity\Project;
use Clarity\Entity\Sample;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\SampleClarityRepository;

$prodConnector = new ClarityApiConnector('prod');
$labProdRepo = new LabClarityRepository($prodConnector);
$researcherProdRepo = new ResearcherClarityRepository($prodConnector);
$projectProdRepo = new ProjectClarityRepository($prodConnector);
$sampleProdRepo = new SampleClarityRepository($prodConnector);

$projects = $projectProdRepo->findAll();
$projectCount = count($projects);

$output = $projects[0]->getTabLine('header');
//echo $projectCount . ' projects found' . PHP_EOL;

foreach ($projects as $project) {
    $id = $project->getClarityId();
    $researcher = $researcherProdRepo->find($project->getResearcherId());
    $lab = $labProdRepo->find($researcher->getLabId());
    $samples = $sampleProdRepo->findByProjectId($id);
    $researcher->setLab($lab);
    $project->setResearcher($researcher);
    $project->setSamples($samples);
    $output .= $project->getTabLine();
}

echo $output;
