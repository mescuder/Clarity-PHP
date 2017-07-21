<?php

namespace Clarity\EntityRepository;

use Clarity\EntityRepository\ClarityRepository;
use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Lab;

/**
 * Description of LabClarityRepository
 *
 * @author escudem
 */
class LabClarityRepository extends ClarityRepository {

    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector) {
        parent::__construct($connector);
        $this->endpoint = 'labs';
    }

    /**
     * 
     * @param string $xmlData
     * @return Lab
     */
    public function apiAnswerToLab($xmlData) {
        if ($this->checkApiException($xmlData)) {
            return null;
        } else {
            $lab = new Lab();
            $lab->setXml($xmlData);
            $lab->xmlToLab();
            $lab->setClarityIdFromUri();
            return $lab;
        }
    }
    
    /**
     * 
     * @param Lab $lab
     * @return Lab
     */
    public function createNewLabFromObject(Lab $lab)
    {
        $lab->setClarityUri(null);
        $lab->setClarityId(null);
        $lab->labToXml();
        echo $lab->getXml() . PHP_EOL;
        $lab = $this->save($lab);
        return $lab;
    }

    /**
     * 
     * @param string $id
     * @return Lab
     */
    public function find($id) {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToLab($xmlData);
    }

    /**
     * 
     * @param string $name
     * @return array
     */
    public function findByName($name) {
        $search = $this->replaceSpaceInSearchString($name);
        $path = $this->endpoint . '?name=' . $search;
        //echo $path . PHP_EOL;
        $xmlData = $this->connector->getResource($path);
        $labs = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $labs);
        return $labs;
    }
    
    /**
     * 
     * @param string $xmlData
     * @param array $labs
     */
    public function makeArrayFromMultipleAnswer($xmlData, array &$labs)
    {
        $labsElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($labsElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'lab':
                        $labUri = $childElement['uri']->__toString();
                        $lab = new Lab();
                        $labId = $lab->getClarityIdFromUri($labUri);
                        //echo 'Fetching ' . $labUri . PHP_EOL;
                        $lab = $this->find($labId);
                        $labs[] = $lab;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint. '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $labsElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * 
     * @param Lab $lab
     * @return Lab
     */
    public function save(Lab $lab) {
        if (empty($lab->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $lab->getXml());
            return $this->apiAnswerToLab($xmlData);
        } else {
            $xmlData = $this->connector->putResource($this->endpoint, $lab->getXml(), $lab->getClarityId());
            return $this->apiAnswerToLab($xmlData);
        }
    }

}
