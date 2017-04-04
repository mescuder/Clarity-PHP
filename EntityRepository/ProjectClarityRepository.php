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
     * @param ClarityApiConnector $connector
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
