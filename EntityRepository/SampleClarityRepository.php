<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Sample;
use Clarity\Entity\Project;
use Clarity\Entity\Researcher;
use Clarity\Entity\Tube;
use Clarity\EntityRepository\ContainerClarityRepository;

/**
 * Description of SampleClarityRepository
 *
 * @author escudem
 */
class SampleClarityRepository extends ClarityRepository
{

    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'samples';
    }

    /**
     * 
     * @param string $xmlData
     * @return Sample
     */
    public function apiAnswerToSample($xmlData)
    {
        if ($this->checkApiException($xmlData)) {
            return null;
        } else {
            $sample = new Sample();
            $sample->setXml($xmlData);
            $sample->xmlToSample();
            return $sample;
        }
    }

    public function createNewSampleFromObject(Sample $sample, ContainerClarityRepository $containerRepo, Researcher $submitter, Project $project = null)
    {
        $sample->setClarityId(null);
        $sample->setClarityUri(null);

        if (!empty($project)) {
            $sample->setProjectId($project->getClarityId());
            $sample->setProjectUri($project->getClarityUri());
        }
        $sample->setSubmitterUri($submitter->getClarityUri());
        $sample->setSubmitterFirst($submitter->getFirstName());
        $sample->setSubmitterLast($submitter->getLastName());
        $container = $containerRepo->createNew('Tube');
        if (empty($container)) {
            echo 'Failed to create new container for sample "' . $sample->getClarityName() . '"' . PHP_EOL;
            exit;
        } else {
            echo 'Created container ' . $container->getClarityId() . ' for sample "' . $sample->getClarityName() . '"' . PHP_EOL;
            $sample->setContainerId($container->getClarityId());
            $sample->setContainerUri($container->getClarityUri());
            switch ($container->getTypeName()) {
                case 'Tube':
                    $sample->setContainerLocation('1:1');
                    break;
                default:
                    break;
            }
        }

        $sample->sampleToXml();
        echo $sample->getXml() . PHP_EOL;
        $sample = $this->save($sample);
        return $sample;
    }

    /**
     * 
     * @param string $id
     * @return Sample
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToSample($xmlData);
    }

    /**
     * 
     * @return array
     */
    public function findAll()
    {
        $path = $this->endpoint;
        $xmlData = $this->connector->getResource($path);
        $samples = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $samples);
        return $samples;
    }

    public function findByName($name)
    {
        $search = $this->replaceSpaceInSearchString($name);
        $path = $this->endpoint . '?name=' . $search;
        // echo $path . PHP_EOL;
        $xmlData = $this->connector->getResource($path);
        $samples = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $samples);
        return $samples;
    }

    /**
     * 
     * @param string $id
     * @return array
     */
    public function findByProjectId($id)
    {
        $path = $this->endpoint . '?projectlimsid=' . $id;
        $xmlData = $this->connector->getResource($path);
        $samples = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $samples);
        return $samples;
    }

    public function lookForSamples(&$search, &$input, ProjectClarityRepository &$projectRepo = null, ResearcherClarityRepository &$researcherRepo = null, LabClarityRepository &$labRepo = null)
    {
        $sample = new Sample();
        $samples = array();

        if ($input == 'sample-id') {
            $samples[] = $this->find($search);
        } elseif ($input == 'sample-name') {
            $samples = $this->findByName($search);
        } elseif ($input == 'project-id') {
            $samples = $this->findByProjectId($search);
        } elseif ($input == 'project-name') {
            
        } elseif ($input == 'fastq') {
            
        }

        if (empty($samples) || empty($samples[0])) {
            echo 'No matching samples' . PHP_EOL;
        }

        $projectId = '';
        $project = new Project();
        foreach ($samples as $sample) {
            if ($sample->getProjectId() != $projectId) {
                $projectId = $sample->getProjectId();
                if (!empty($projectRepo)) {
                    $project = $projectRepo->find($projectId);
                    if (!empty($researcherRepo)) {
                        $researcher = $researcherRepo->find($project->getResearcherId());
                        if (!empty($labRepo)) {
                            $lab = $labRepo->find($researcher->getLabId());
                            $researcher->setLab($lab);
                        }
                        $project->setResearcher($researcher);
                    }
                }
            }
            $sample->setProject($project);
        }

        return $samples;
    }

    /**
     * 
     * @param string $xmlData
     * @param array $samples
     */
    public function makeArrayFromMultipleAnswer($xmlData, array &$samples)
    {
        $samplesElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($samplesElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'sample':
                        $sampleId = $childElement['limsid']->__toString();
                        //echo 'Fetching ' . $childElement['uri']->__toString() . PHP_EOL;
                        $sample = $this->find($sampleId);
                        $samples[] = $sample;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint . '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $samplesElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * 
     * @param Sample $sample
     * @return Sample
     */
    public function save(Sample $sample)
    {
        $sampleId = $sample->getClarityId();
        if (empty($sampleId)) {
            $xmlData = $this->connector->postResource($this->endpoint, $sample->getXml());
            return $this->apiAnswerToSample($xmlData);
        } else {
            $xmlData = $this->connector->putResource($this->endpoint, $sample->getXml(), $sampleId);
            return $this->apiAnswerToSample($xmlData);
        }
    }

}
