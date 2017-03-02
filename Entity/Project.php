<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Project
 *
 * @author Mickael Escudero
 */
class Project extends ApiResource
{
    
    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
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
        parent::__construct();
        //$this->clarityUDFs = array();
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
    
}
