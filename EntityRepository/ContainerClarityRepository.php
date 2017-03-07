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
class ContainerClarityRepository
{
    
    /**
     *
     * @var resource $curlHandle
     */
    protected $connector;
    
    /**
     *
     * @var Container $container
     */
    protected $container;
    
    /**
     *
     * @var SimpleXMLElement $xml 
     */
    protected $xml;
    
    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Container $container
     */
    public function __construct(ClarityApiConnector $connector = null, Container $container = null)
    {
        $this->endpoint = 'containers';
        $this->container = $container;
        $this->connector = $connector;
    }
    
    /**
     * 
     * @param string $id
     * @return Container
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $data = $this->connector->getResource($path);
        $this->xml = new \SimpleXMLElement($data);
        $this->container = $this->xmlToContainer();
        
        return $this->container;
    }
    
    /**
     * 
     * @param Container $container
     * @return string
     */
    public function save(Container $container = null)
    {
        if ($container === null)
        {
            $container = $this->container;
        }
        $this->xml = simplexml_load_file('XmlTemplate/container.xsd');
        $this->xml->type['name'] = $container->getClarityTypeName();
        $this->xml->type['uri'] = $this->connector->getBaseUrl() . '/'. $container->getClarityTypeEndpoint();
        $this->xml->name = $container->getClarityName();
        
        if ($container->getClarityId() === null)
        {
            return $this->connector->postResource($this->endpoint, $this->xml->asXML());
        }
        else 
        {
            return $this->connector->putResource();
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
    
    /**
     * 
     * @param Container $container
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
    
    /**
     * 
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
    
    /**
     * 
     * @param resource $connector
     */
    public function setConnector(resource $connector)
    {
        $this->connector = $connector;
    }
    
    /**
     * 
     * @return resource
     */
    public function getConnector()
    {
        return $this->connector;
    }
    
    /**
     * 
     * @param SimpleXMLElement $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }
    
    /**
     * 
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }
    
}
