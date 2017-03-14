<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Project;

/**
 * Description of ProjectClarityRepository
 *
 * @author Mickael Escudero
 */
class ProjectClarityRepository extends ClarityRepository
{
    
    /**
     *
     * @var resource $connector
     */
    protected $connector;
    
    /**
     *
     * @var Project $project
     */
    protected $project;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Project $project
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'projects';
    }
    
    public function apiAnswerToProject($xmlData)
    {
        $project = new Project();
        $project->setXml($xmlData);
        $project->xmlToProject();
        $project->setClarityIdFromUri();
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
    
    public function save(Project $project)
    {
        if ($project->getClarityId() === null) {
            $xmlData = $this->connector->postResource($this->endpoint, $project->getXml());
            return $this->apiAnswerToProject($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $project->getXml(), $project->getClarityId());
            return $this->apiAnswerToProject($xmlData);
        }
    }
    
    /**
     * 
     * @param resource $connector
     */
    public function setConnector(resource $connector)
    {
        $this->connector = $connector;
    }
    
    /**
     * 
     * @return resource
     */
    public function getConnector()
    {
        return $this->connector;
    }
    
    /**
     * 
     * @param Project $project
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
    }
    
    /**
     * 
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }
    
}
