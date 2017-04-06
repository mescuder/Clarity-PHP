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
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'researchers';
    }
    
    public function apiAnswerToResearcher($xmlData)
    {
        $this->checkApiException($xmlData);
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
        if (empty($researcher->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $researcher->getXml());
            return $this->apiAnswerToResearcher($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $researcher->getXml(), $researcher->getClarityId());
            return $this->apiAnswerToResearcher($xmlData);
        }
    }
    
}
