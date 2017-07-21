<?php

namespace Clarity\Entity;

/**
 * Description of ApiResource
 *
 * @author escudem
 */
abstract class ApiResource
{
    
    /**
     *
     * @var string $clarityId
     */
    protected $clarityId;
    
    /**
     *
     * @var string $clarityUDFs
     */
    protected $clarityUDFs;
    
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
        $this->clarityUDFs = array();
    }
    
    public function formatXml()
    {
        $doc = new \DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML($this->xml);
        $this->xml = $doc->saveXML();
    }
    
    public function setClarityIdFromUri()
    {
        $this->clarityId = $this->getClarityIdFromUri();
    }
    
    public function getClarityIdFromUri($uri = null)
    {
        if (empty($uri)) {
            $uri = $this->clarityUri;
        }
        $delimiter = '/';
        $uriBits = explode($delimiter, $uri);
        return end($uriBits);
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
     * @param string $field
     * @param string $value
     */
    public function setClarityUDF($field, $value)
    {
        $this->clarityUDFs[$field] = $value;
    }
    
    /**
     * 
     * @param string $name
     * @return array
     */
    public function getClarityUDF($name)
    {
        return $this->clarityUDFs[$name];
    }
    
    /**
     * 
     * @param array $udfs
     */
    public function setClarityUDFs(array $udfs)
    {
        foreach ($udfs as $field => $value) {
            $this->setClarityUDF($field, $value);
        }
    }
    
    /**
     * 
     * @return array
     */
    public function getClarityUDFs()
    {
        return $this->clarityUDFs;
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
    
    /**
     * 
     * @param string $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }
    
    /**
     * 
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }
    
}
