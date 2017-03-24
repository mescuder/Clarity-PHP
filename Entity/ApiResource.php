<?php

namespace Clarity\Entity;

/**
 * Description of ApiResource
 *
 * @author Mickael Escudero
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
    
    public function clarityIdFromUri()
    {
        return end(explode('/', $this->clarityUri));
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
        $this->clarityId = $this->clarityIdFromUri();
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
     * @param array $udf
     */
    public function setClarityUDF(array $udf)
    {
        if (array_key_exists('name', $udf)) {
            $name = $udf['name'];
            $this->clarityUDFs[$name]['name'] = $name;
            
            if (array_key_exists('value', $udf)) {
                $this->clarityUDFs[$name]['value'] = $udf['value'];
            }
            if (array_key_exists('required', $udf)) {
                $this->clarityUDFs[$name]['required'] = $udf['required'];
            }
            if (array_key_exists('type', $udf)) {
                $this->clarityUDFs[$name]['type'] = $udf['type'];
            }
        }
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
        foreach ($udfs as $udf) {
            $this->setClarityUDF($udf);
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
