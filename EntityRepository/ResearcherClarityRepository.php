<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Researcher;

/**
 * Description of ResearcherClarityRepository
 *
 * @author Mickael Escudero
 */
class ResearcherClarityRepository extends ClarityRepository
{
    
    /**
     *
     * @var resource $connector
     */
    protected $connector;
    
    /**
     *
     * @var Researcher $researcher
     */
    protected $researcher;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Researcher $researcher
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'researchers';
    }
    
    public function apiAnswerToResearcher($xmlData)
    {
        $researcher = new Researcher();
        $researcher->setXml($xmlData);
        $researcher->xmlToResearcher();
        $researcher->setClarityIdFromUri();
        return $researcher;
    }
    
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToResearcher($xmlData);
    }
    
    public function save(Researcher $researcher)
    {
        if ($researcher->getClarityId() === null) {
            $xmlData = $this->connector->postResource($this->endpoint, $researcher->getXml());
            return $this->apiAnswerToResearcher($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $researcher->getXml(), $researcher->getClarityId());
            return $this->apiAnswerToResearcher($xmlData);
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
     * @param Researcher $researcher
     */
    public function setResearcher(Researcher $researcher)
    {
        $this->researcher = $researcher;
    }
    
    /**
     * 
     * @return Researcher
     */
    public function getResearcher()
    {
        return $this->researcher;
    }
    
}
