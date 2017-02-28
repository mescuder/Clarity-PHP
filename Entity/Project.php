<?php

namespace Clarity\Entity;

/**
 * Description of Project
 *
 * @author Mickael Escudero
 */
class Project
{
    
    /**
     *
     * @var string
     */
    protected $clarityId;
    
    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
    /**
     *
     * @var array $clarityUDFs
     */
    protected $clarityUDFs;
    
    /**
     *
     * @var string $clarityUri
     */
    protected $clarityUri;
    
    /**
     *
     * @var string $openDate
     */
    protected $openDate;
    
    /**
     *
     * @var Researcher $researcher
     */
    protected $researcher;
    
    /**
     *
     * @var string $researcherId
     */
    protected $researcherId;
    
    /**
     *
     * @var string $researcherUri
     */
    protected $researcherUri;
    
    /**
     *
     * @var string $xml
     */
    protected $xml;
    
    public function __construct()
    {
        $this->clarityUDFs = array();
        $udfs = yaml_parse_file('Config/project_clarity_udfs.yml');
        $this->setClarityUDFs($udfs);
    }
    
    public function xmlToProject()
    {
        $projectElement = new \SimpleXMLElement($this->xml);
        $this->clarityId = $projectElement['limsid']->__toString();
        $this->clarityName = $projectElement->name->__toString();
        $this->openDate = $projectElement->{'open-date'}->__toString();
        $this->researcherUri = $projectElement->researcher['uri']->__toString();
        
        foreach ($projectElement->xpath('//udf:field') as $udfElement) {
            $field = $udfElement['name']->__toString();
            $value = $udfElement->__toString();
            $udf = array(
                'name'  => $field,
                'value' => $value,
            );
            $this->setClarityUDF($udf);
        }
    }
    
    public function setClarityId($clarityId)
    {
        $this->clarityId = $id;
    }
    
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
     * @param string $openDate
     */
    public function setOpenDate($openDate)
    {
        $this->openDate = $openDate;
    }
    
    /**
     * 
     * @return string
     */
    public function getOpenDate()
    {
        return $this->openDate;
    }
    
    /**
     * 
     * @param Researcher $researcher
     */
    public function setResearcher($researcher)
    {
        $this->researcher = $researcher;
    }
    
    /**
     * 
     * @return Researcher
     */
    public function getResearcher()
    {
        return $this->researcher;
    }
    
    /**
     * 
     * @param string $researcherId
     */
    public function setResearcherId($researcherId)
    {
        $this->researcherId = $researcherId;
    }
    
    /**
     * 
     * @return string
     */
    public function getResearcherId()
    {
        return $this->researcherId;
    }
    
    /**
     * 
     * @param string $researcherUri
     */
    public function setResearcherUri($researcherUri)
    {
        $this->clarityUri = $clarityUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getResearcherUri()
    {
        return $this->researcherUri;
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
