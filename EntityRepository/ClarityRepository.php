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
     */
    public function checkApiException($xmlData)
    {
        $element = new \SimpleXMLElement($xmlData);
        if ($element->getName() == 'exception') {
            echo $element->asXML() . PHP_EOL;
            exit;
        }
    }
    
    public function getResourcesFromSearchResult($xmlResult)
    {
        $xmlResults = array();
        $xmlElement = new \SimpleXMLElement($xmlResult);
        if ($xmlElement->count() == 0) {
            return $xmlResults;
        }
        else {
            foreach ($xmlElement->children() as $childElement) {
                $fullpath = $childElement['uri']->__toString();
                $path = $this->endpoint . '/' . end(explode('/', $fullpath));
                $xmlResults[] = $this->connector->getResource($path);
            }
            return $xmlResults;
        }   
    }
    
    public function replaceSpaceInSearchString($search)
    {
        return str_replace(' ', '%20', $search);
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
