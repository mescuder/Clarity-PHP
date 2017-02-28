<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Project;

/**
 * Description of ProjectClarityRepository
 *
 * @author Mickael Escudero
 */
class ProjectClarityRepository
{
    
    /**
     *
     * @var resource $connector
     */
    protected $connector;
    
    /**
     *
     * @var string $endpoint
     */
    protected $endpoint;
    
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
    public function __construct(ClarityApiConnector $connector = null, Project $project = null)
    {
        $this->endpoint = 'projects';
        $this->connector = $connector;
        $this->project = $project;
    }
    
    /**
     * 
     * @param string $id
     * @return Project
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $data = $this->connector->getResource($path);
        $this->project = new Project();
        $this->project->setXML($data);
        $this->project->xmlToProject();
        return $this->project;
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
