<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;

/**
 * Description of ClarityRepository
 *
 * @author Mickael Escudero
 */
abstract class ClarityRepository
{
    
    /**
     *
     * @var ClarityApiConnector $connector
     */
    protected $connector;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector = null)
    {
        $this->connector = $connector;
    }
    
    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function setConnector(ClarityApiConnector $connector)
    {
        $this->connector = $connector;
    }
    
    /**
     * 
     * @return ClarityApiConnector
     */
    public function getConnector()
    {
        return $this->connector;
    }
    
}
