<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;
use Clarity\Entity\Researcher;
use Clarity\Entity\Project;
use Clarity\Entity\Sample;
use Clarity\EntityRepository\ProjectClarityRepository;
use Clarity\EntityRepository\SampleClarityRepository;
use Clarity\EntityRepository\ResearcherClarityRepository;
use Clarity\EntityRepository\LabClarityRepository;
use Clarity\EntityRepository\ContainerClarityRepository;

/**
 * 
 * @param Lab $testLab
 * @param LabClarityRepository $labRepo
 * @return Lab
 */
function prepareLab(Lab $testLab, LabClarityRepository $labRepo) {
    $prodLabs = $labRepo->findByName($testLab->getClarityName());
    $labCount = count($prodLabs);
    if ($labCount < 1) {
        echo 'No lab found with the name: ' . $testLab->getClarityName() . PHP_EOL;
        $prodLab = $labRepo->createNewLabFromObject($testLab);
        echo 'Created lab ' . $prodLab->getClarityId() . PHP_EOL;
        echo $prodLab->getXml() . PHP_EOL;
        return $prodLab;
    } elseif ($labCount > 1) {
        echo 'More than one lab found with the name: ' . $testLab->getClarityName() . PHP_EOL;
        exit;
    } else {
        $prodLab = $prodLabs[0];
        echo 'Found existing lab ' . $prodLab->getClarityId() . PHP_EOL;
        echo $prodLab->getXml() . PHP_EOL;
        return $prodLab;
    }
}

/**
 * 
 * @param Project $testProject
 * @param ProjectClarityRepository $projectRepo
 * @param Researcher $prodResearcher
 * @return Project
 */
function prepareProject(Project $testProject, ProjectClarityRepository $projectRepo, Researcher $prodResearcher) {
    $prodProjects = $projectRepo->findByName($testProject->getClarityName());
    $projectCount = count($prodProjects);
    if ($projectCount < 1) {
        echo 'No project found with the name: ' . $testProject->getClarityName() . PHP_EOL;
        $testProject->setClarityUDF('Test ID', $testProject->getClarityId());
        $prodProject = $projectRepo->createNewProjectFromObject($testProject, $prodResearcher);
        echo 'Created project ' . $prodProject->getClarityId() . PHP_EOL;
        echo $prodProject->getXml() . PHP_EOL;
        return $prodProject;
    } elseif ($projectCount > 1) {
        echo 'More than one project with the name: ' . $testProject->getClarityName() . PHP_EOL;
        exit;
    } else {
        $prodProject = $prodProjects[0];
        echo 'Found existing project ' . $prodProject->getClarityId() . PHP_EOL;
        return $prodProject;
    }
}

/**
 * 
 * @param Researcher $testResearcher
 * @param ResearcherClarityRepository $researcherRepo
 * @param Lab $prodLab
 * @return Researcher
 */
function prepareResearcher(Researcher $testResearcher, ResearcherClarityRepository $researcherRepo, Lab $prodLab) {
    $prodResearchers = $researcherRepo->findByFirstAndLastNames($testResearcher->getFirstName(), $testResearcher->getLastName());
    $researcherCount = count($prodResearchers);
    if ($researcherCount < 1) {
        echo 'No researcher found with the name: ' . $testResearcher->getFullName() . PHP_EOL;
        $prodResearcher = $researcherRepo->createNewResearcherFromObject($testResearcher, $prodLab);
        if (empty($prodResearcher)) {
            echo 'Failed to create researcher ' . $testResearcher->getFullName() . PHP_EOL;
            exit(1);
        }
        echo 'Created researcher ' . $prodResearcher->getClarityId() . PHP_EOL;
        echo $prodResearcher->getXml() . PHP_EOL;
        return $prodResearcher;
    } elseif ($researcherCount > 1) {
        echo 'More than one researcher found with the name: ' . $testResearcher->getFullName() . PHP_EOL;
        exit;
    } else {
        $prodResearcher = $prodResearchers[0];
        echo 'Found existing researcher ' . $prodResearcher->getClarityId() . PHP_EOL;
        return $prodResearcher;
    }
}

/**
 * 
 * @param array $testSamples
 * @param SampleClarityRepository $sampleRepo
 * @param ContainerClarityRepository $containerRepo
 * @param Project $prodProject
 * @param Researcher $submitter
 */
function processSamples(array $testSamples, SampleClarityRepository $sampleRepo, ContainerClarityRepository $containerRepo, Project $prodProject, Researcher $submitter) {
    $testSampleCount = count($testSamples);
    $prodSamples = $sampleRepo->findByProjectId($prodProject->getClarityId());
    $prodSampleCount = count($prodSamples);
    if ($prodSampleCount < $testSampleCount) {
        echo 'There are less samples in prod (' . $prodSampleCount . ') than in test (' . $testSampleCount . ') for project: ' . $prodProject->getClarityName() . PHP_EOL;
        $prodSampleNames = array();
        foreach ($prodSamples as $prodSample) {
            $prodSampleNames[] = $prodSample->getClarityName();
        }
        foreach ($testSamples as $testSample) {
            if (!in_array($testSample->getClarityName(), $prodSampleNames)) {
                echo 'Sample not found in prod: "' . $testSample->getClarityName() . '"' . PHP_EOL;
                $testSample->setClarityUDF('Test ID', $testSample->getClarityId());
                $prodSample = $sampleRepo->createNewSampleFromObject($testSample, $containerRepo, $submitter, $prodProject);
                if (empty($prodSample)) {
                    echo 'Failed to create sample "' . $testSample->getClarityName() . '"' . PHP_EOL;
                } else {
                    echo 'Created sample ' . $prodSample->getClarityId() . PHP_EOL;
                    echo $prodSample->getXml() . PHP_EOL;
                    $prodSamples[] = $prodSample;
                }
            }
        }
        $newProdSampleCount = count($prodSamples);
        echo 'There are now ' . $newProdSampleCount . ' samples in prod and ' . $testSampleCount . ' samples in test for project: ' . $prodProject->getClarityName() . PHP_EOL;
    } elseif ($prodSampleCount == $testSampleCount) {
        echo 'There are as many samples in prod (' . $prodSampleCount . ') and in test (' . $testSampleCount . ') for project: ' . $prodProject->getClarityName() . PHP_EOL;
    } else {
        echo 'There are more samples in prod (' . $prodSampleCount . ') than in test (' . $testSampleCount . ') for project: ' . $prodProject->getClarityName() . PHP_EOL;
    }
    return $prodSamples;
}

$testConnector = new ClarityApiConnector('test');
$projectTestRepo = new ProjectClarityRepository($testConnector);
$sampleTestRepo = new SampleClarityRepository($testConnector);
$researcherTestRepo = new ResearcherClarityRepository($testConnector);
$labTestRepo = new LabClarityRepository($testConnector);
$containerTestRepo = new ContainerClarityRepository($testConnector);
$prodConnector = new ClarityApiConnector('prod');
$projectProdRepo = new ProjectClarityRepository($prodConnector);
$sampleProdRepo = new SampleClarityRepository($prodConnector);
$researcherProdRepo = new ResearcherClarityRepository($prodConnector);
$labProdRepo = new LabClarityRepository($prodConnector);
$containerProdRepo = new ContainerClarityRepository($prodConnector);

$submitters = $researcherProdRepo->findByFirstAndLastNames('Mickael', 'Escudero');
if (empty($submitters)) {
    echo 'Could not find submitter' . PHP_EOL;
    exit(1);
} else {
    $submitter = $submitters[0];
}

//$testProjectIds = array('COD731');

$shortopts = "p:";
$options = getopt($shortopts);
if (array_key_exists('p', $options)) {
    $testProjectId = $options['p'];
} else {
    exit('No project ID was provided' . PHP_EOL);
}

//foreach ($testProjectIds as $testProjectId) {
$testProject = $projectTestRepo->find($testProjectId);
if (empty($testProject)) {
    echo 'Project ' . $testProjectId . ' not found' . PHP_EOL;
    exit;
} else {
    //echo $testProject->getXml() . PHP_EOL;
    echo 'Got project ' . $testProjectId . PHP_EOL;
}

$testResearcher = $researcherTestRepo->find($testProject->getResearcherId());
if (empty($testResearcher)) {
    echo 'Researcher ' . $testProject->getResearcherId() . ' not found' . PHP_EOL;
    exit;
} else {
    //echo $testResearcher->getXml() . PHP_EOL;
    echo 'Got researcher ' . $testResearcher->getClarityId() . PHP_EOL;
}

$testLab = $labTestRepo->find($testResearcher->getLabId());
if (empty($testLab)) {
    echo 'Lab ' . $testResearcher->getLabId() . ' not found' . PHP_EOL;
    exit;
} else {
    //echo $testLab->getXml() . PHP_EOL;
    echo 'Got lab ' . $testLab->getClarityId() . PHP_EOL;
}

$testSamples = $sampleTestRepo->findByProjectId($testProject->getClarityId());
if (empty($testSamples)) {
    echo 'No samples found for project ' . $testProjectId . PHP_EOL;
} else {
    foreach ($testSamples as $testSample) {
        //echo $testSample->getXml() . PHP_EOL;
        echo 'Got sample ' . $testSample->getClarityId() . PHP_EOL;
    }
}

echo PHP_EOL;
$prodLab = prepareLab($testLab, $labProdRepo);
$prodResearcher = prepareResearcher($testResearcher, $researcherProdRepo, $prodLab);
$prodProject = prepareProject($testProject, $projectProdRepo, $prodResearcher);
$prodSamples = processSamples($testSamples, $sampleProdRepo, $containerProdRepo, $prodProject, $submitter);
//}
