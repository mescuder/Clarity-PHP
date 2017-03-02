<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;

/**
 * Description of LabClarityRepository
 *
 * @author Mickael Escudero
 */
class LabClarityRepository
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
    protected $lab;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Lab $lab
     */
    public function __construct(ClarityApiConnector $connector = null, Lab $lab = null)
    {
        $this->endpoint = 'labs';
        $this->connector = $connector;
        $this->lab = $lab;
    }
    
    /**
     * 
     * @param string $id
     * @return Lab
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $data = $this->connector->getResource($path);
        $this->lab = new Lab();
        $this->lab->setXml($data);
        $this->lab->xmlToLab();
        $this->lab->setClarityIdFromUri();
        return $this->lab;
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
     * @param Lab $lab
     */
    public function setLab(Lab $lab)
    {
        $this->lab = $lab;
    }
    
    /**
     * 
     * @return Lab
     */
    public function getLab()
    {
        return $this->lab;
    }
    
}
