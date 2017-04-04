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
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'labs';
    }
    
    public function apiAnswerToLab($xmlData)
    {
        $lab = new Lab();
        $lab->setXml($xmlData);
        $lab->xmlToLab();
        $lab->setClarityIdFromUri();
        return $lab;
    }
    
    /**
     * 
     * @param string $id
     * @return Lab
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToLab($xmlData);
    }
    
    public function findByName($name)
    {
        $search = $this->replaceSpaceInSearchString($name);
        $path = $this->endpoint . '?name=' . $search;
        $searchResult = $this->connector->getResource($path);
        $xmlResults = $this->getResourcesFromSearchResult($searchResult);
        $xmlData = $xmlResults[0];
        return $this->apiAnswerToLab($xmlData);
    }
    
    public function save(Lab $lab)
    {
        if (empty($lab->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $lab->getXml());
            return $this->apiAnswerToLab($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $lab->getXml(), $lab->getClarityId());
            return $this->apiAnswerToLab($xmlData);
        }
    }
    
}
