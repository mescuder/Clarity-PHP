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
     * @var string $endpoint
     */
    protected $endpoint;
    
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
    
    public function save(Lab $lab)
    {
        if ($lab->getClarityId() === null) {
            $xmlData = $this->connector->postResource($this->endpoint, $lab->getXml());
            return $this->apiAnswerToLab($xmlData);
        }
        else {
            echo "The labs resource in Clarity does not support PUT to update a lab" . PHP_EOL;
            exit();
        }
    }
    
}
