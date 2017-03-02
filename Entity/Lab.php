<?php

namespace Clarity\Entity;

/**
 * Description of Lab
 *
 * @author Mickael Escudero
 */
class Lab
{
    
    /**
     *
     * @var string $clarityId
     */
    protected $clarityId;
    
    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
    /**
     *
     * @var string $clarityUri
     */
    protected $clarityUri;
    
    /**
     *
     * @var string $xml
     */
    protected $xml;
    
    public function __construct()
    {
        
    }
    
    public function xmlToLab()
    {
        $labElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $labElement['uri']->__toString();
        $this->clarityName = $labElement->name->__toString();
    }
    
    /**
     * 
     * @param string $clarityId
     */
    public function setClarityId($clarityId)
    {
        $this->clarityId = $clarityId;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityId()
    {
        return $this->clarityId;
    }
    
    /**
     * 
     * @param string $clarityName
     */
    public function setClarityName($clarityName)
    {
        $this->clarityName = $clarityName;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityName()
    {
        return $this->clarityName;
    }
    
    /**
     * 
     * @param string $clarityUri
     */
    public function setClarityUri($clarityUri)
    {
        $this->clarityUri = $clarityUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityUri()
    {
        return $this->clarityUri;
    }
    
    public function setXml($xml)
    {
        $this->xml = $xml;
    }
    
    public function getXml()
    {
        return $this->xml;
    }
    
}
