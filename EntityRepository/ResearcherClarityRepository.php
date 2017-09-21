<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Researcher;
use Clarity\Entity\Lab;

/**
 * Description of ResearcherClarityRepository
 *
 * @author escudem
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
    
    /**
     * 
     * @param string $xmlData
     * @return Researcher
     */
    public function apiAnswerToResearcher($xmlData)
    {
        if ($this->checkApiException($xmlData)) {
            return null;
        }
        else {
            $researcher = new Researcher();
            $researcher->setXml($xmlData);
            $researcher->xmlToResearcher();
            $researcher->setClarityIdFromUri();
            return $researcher;
        }
    }
    
    public function createNewResearcherFromObject(Researcher $researcher, Lab $lab)
    {
        $researcher->setClarityUri(null);
        $researcher->setClarityId(null);
        $researcher->setUsername(null);
        $researcher->setPassword(null);
        $researcher->setLocked(null);
        $researcher->setRoles(array());
        $researcher->setLabUri($lab->getClarityUri());
        $researcher->researcherToXml();
        echo $researcher->getXml() . PHP_EOL;
        $researcher = $this->save($researcher);
        return $researcher;
    }
    
    /**
     * 
     * @param string $id
     * @return Researcher
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToResearcher($xmlData);
    }
    
    /**
     * 
     * @param string $firstName
     * @param string $lastName
     * @return array
     */
    public function findByFirstAndLastNames($firstName, $lastName)
    {
        $firstName = $this->replaceSpaceInSearchString($firstName);
        $lastName = $this->replaceSpaceInSearchString($lastName);
        $path = $this->endpoint . '?firstname=' . $firstName . '&lastname=' . $lastName;
        //echo $path . PHP_EOL;
        $xmlData = $this->connector->getResource($path);
        $researchers = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $researchers);
        return $researchers;
    }
    
    
    /**
     * 
     * @param string $xmlData
     * @param array $researchers
     */
    public function makeArrayFromMultipleAnswer($xmlData, array &$researchers)
    {
        $researchersElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($researchersElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'researcher':
                        $researcherUri = $childElement['uri']->__toString();
                        $researcher = new Researcher();
                        $researcherId = $researcher->getClarityIdFromUri($researcherUri);
                        //echo 'Fetching ' . $researcherUri . PHP_EOL;
                        $researcher = $this->find($researcherId);
                        $researchers[] = $researcher;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint. '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $researchersElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }

    
    /**
     * 
     * @param Researcher $researcher
     * @return Researcher
     */
    public function save(Researcher $researcher)
    {
        $researcherId = $researcher->getClarityId();
        if (empty($researcherId)) {
            $xmlData = $this->connector->postResource($this->endpoint, $researcher->getXml());
            return $this->apiAnswerToResearcher($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $researcher->getXml(), $researcherId);
            return $this->apiAnswerToResearcher($xmlData);
        }
    }
    
}
