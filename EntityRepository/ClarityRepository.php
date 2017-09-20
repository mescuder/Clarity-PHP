<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;

/**
 * Description of ClarityRepository
 *
 * @author escudem
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
     * @var string $endpoint
     */
    protected $endpoint;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        $this->connector = $connector;
    }
    
    /**
     * 
     * @param string $xmlData
     * @return boolean
     */
    public function checkApiException($xmlData)
    {
        $element = new \SimpleXMLElement($xmlData);
        if ($element->getName() == 'exception') {
            echo $element->asXML() . PHP_EOL;
            return TRUE;
        }
        else {
            return FALSE;
        }
    }
    
    /**
     * 
     * @param string $search
     * @return string
     */
    public function replaceSpaceInSearchString($search)
    {
        return str_replace(' ', '+', $search);
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
