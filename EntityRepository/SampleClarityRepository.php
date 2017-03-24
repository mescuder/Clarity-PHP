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
    
    public function apiAnswerToSample($xmlData)
    {
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
        }
    }

}
