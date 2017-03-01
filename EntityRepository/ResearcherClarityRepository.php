<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Researcher;

/**
 * Description of ResearcherClarityRepository
 *
 * @author Mickael Escudero
 */
class ResearcherClarityRepository
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
     * @var Researcher $researcher
     */
    protected $researcher;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Researcher $researcher
     */
    public function __construct(ClarityApiConnector $connector = null, Researcher $researcher = null)
    {
        $this->endpoint = 'researchers';
        $this->connector = $connector;
        $this->researcher = $researcher;
    }
    
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $data = $this->connector->getResource($path);
        $this->researcher = new Researcher();
        $this->researcher->setXml($data);
        $this->researcher->xmlToResearcher();
        return $this->researcher;
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
