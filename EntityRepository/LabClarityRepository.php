<?php

namespace Clarity\EntityRepository;

use Clarity\EntityRepository\ClarityRepository;
use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;

/**
 * Description of LabClarityRepository
 *
 * @author Mickael Escudero
 */
class LabClarityRepository extends ClarityRepository
{
    
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
        parent::__construct($connector);
        $this->endpoint = 'labs';
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
    
    public function save(Lab $lab = null)
    {
        
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
