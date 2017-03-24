<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Container;
use Clarity\Entity\Tube;

/**
 * Description of ContainerClarityRepository
 *
 * @author Mickael Escudero
 */
class ContainerClarityRepository extends ClarityRepository
{
    
    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'containers';
    }
    
    public function apiAnswerToContainer($xmlData)
    {
        $answerElement = simplexml_load_string($xmlData);
        $type = $answerElement->type['name'];
        switch ($type) {
            case 'Tube':
                $container = new Tube();
                break;
            default:
                return null;
        }
        $container->setXml($xmlData);
        $container->xmlToContainer();
        return $container;
    }
    
    /**
     * 
     * @param string $id
     * @return Container
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToContainer($xmlData);
    }
    
    /**
     * 
     * @param Container $container
     * @return Container
     */
    public function save(Container $container)
    {
        $container->containerToXml();
        if (empty($container->getClarityId())) {
            $xmlData = $this->connector->postResource($this->endpoint, $container->getXml());
            return $this->apiAnswerToContainer($xmlData);
        }
        else {
            $xmlData = $this->connector->putResource($this->endpoint, $container->getXml(), $container->getClarityId());
            return $this->apiAnswerToContainer($xmlData);
        }
    }
    
    /**
     * 
     * @return Container
     */
    public function xmlToContainer()
    {
        $type = $this->xml->{'type'}['name'];
        switch ($type) {
            case 'Tube':
                $container = new Tube();
                break;
            default:
                return null;
        }
        $container->setClarityId($this->xml['limsid']->__toString());
        $container->setClarityName($this->xml->name->__toString());
        $container->setClarityTypeUri($this->xml->type['uri']->__toString());
        $container->setClarityUri($this->xml['uri']->__toString());
        
        return $container;
    }
    
}
