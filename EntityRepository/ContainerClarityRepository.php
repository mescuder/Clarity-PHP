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
    
    /**
     * 
     * @param string $xmlData
     * @return Container
     */
    public function apiAnswerToContainer($xmlData)
    {
        if ($this->checkApiException($xmlData)) {
            return null;
        }
        else {
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
    }
    
    /**
     * 
     * @param string $type
     * @return Container
     */
    public function createNew($type)
    {
        switch ($type) {
            case 'Tube':
                $container = new Tube();
                break;
            default:
                return null;
        }
        $typeUri = $this->getConnector()->getBaseUrl() . '/containertypes/' . $container->getTypeId();
        $container->setTypeUri($typeUri);
        $container->containerToXml();
        //echo $container->getXml() . PHP_EOL;
        $container = $this->save($container);
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
    
}
