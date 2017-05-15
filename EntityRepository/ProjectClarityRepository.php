<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Project;
use Clarity\Entity\Researcher;

/**
 * Description of ProjectClarityRepository
 *
 * @author Mickael Escudero
 */
class ProjectClarityRepository extends ClarityRepository
{
    
    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'projects';
    }
    
    /**
     * 
     * @param string $xmlData
     * @return Project
     */
    public function apiAnswerToProject($xmlData)
    {
        if ($this->checkApiException($xmlData)) {
            return null;
        }
        else {
            $project = new Project();
            $project->setXml($xmlData);
            $project->xmlToProject();
            $project->setClarityIdFromUri();
            return $project;
        }
    }
    
    public function createNewProjectFromObject(Project $project, Researcher $prodResearcher)
    {
        $project->setClarityUri(null);
        $project->setClarityId(null);
        $project->setFiles(null);
        $project->setResearcherUri($prodResearcher->getClarityUri());
        $project->projectToXml();
        echo $project->getXml() . PHP_EOL;
        $project = $this->save($project);
        return $project;
    }
    
    /**
     * 
     * @param string $id
     * @return Project
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToProject($xmlData);
    }
    
    public function findAll()
    {
        $path = $this->endpoint;
        $xmlData = $this->connector->getResource($path);
        $projects = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $projects);
        return $projects;
    }
    
    /**
     * 
     * @param string $name
     * @return array
     */
    public function findByName($name)
    {
        $search = $this->replaceSpaceInSearchString($name);
        $path = $this->endpoint . '?name=' . $search;
        // echo $path . PHP_EOL;
        $xmlData = $this->connector->getResource($path);
        $projects = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $projects);
        return $projects;
    }
    
    
    /**
     * 
     * @param string $xmlData
     * @param array $projects
     */
    public function makeArrayFromMultipleAnswer($xmlData, array &$projects)
    {
        $projectsElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($projectsElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'project':
                        $projectId = $childElement['limsid']->__toString();
                        //echo 'Fetching ' . $projectUri . PHP_EOL;
                        $project = $this->find($projectId);
                        $projects[] = $project;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint. '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $projectsElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }
    
    /**
     * 
     * @param Project $project
     * @return Project
     */
    public function save(Project $project)
    {
        if (empty($project->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $project->getXml());
            return $this->apiAnswerToProject($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $project->getXml(), $project->getClarityId());
            return $this->apiAnswerToProject($xmlData);
        }
    }
    
}
