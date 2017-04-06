<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Sample;

/**
 * Description of SampleClarityRepository
 *
 * @author Mickael Escudero
 */
class SampleClarityRepository extends ClarityRepository
{

    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'samples';
    }
    
    /**
     * 
     * @param string $xmlData
     * @return Sample
     */
    public function apiAnswerToSample($xmlData)
    {
        $this->checkApiException($xmlData);
        $sample = new Sample();
        $sample->setXml($xmlData);
        $sample->xmlToSample();
        return $sample;
    }

    /**
     * 
     * @param string $id
     * @return Sample
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToSample($xmlData);
    }
    
    public function findAll()
    {
        $path = $this->endpoint;
        $xmlData = $this->connector->getResource($path);
        $samples = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $samples);
        return $samples;
    }
    
    public function makeArrayFromMultipleAnswer($xmlData, &$samples)
    {
        $samplesElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($samplesElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'sample':
                        $sampleId = $childElement['limsid']->__toString();
                        //echo 'Fetching ' . $childElement['uri']->__toString() . PHP_EOL;
                        $sample = $this->find($sampleId);
                        $samples[] = $sample;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint. '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $samplesElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }
    
    /**
     * 
     * @param Sample $sample
     * @return Sample
     */
    public function save(Sample $sample)
    {
        if (empty($sample->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $sample->getXml());
            return $this->apiAnswerToSample($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $sample->getXml(), $sample->getClarityId());
            return $this->apiAnswerToSample($xmlData);
        }
    }

}
