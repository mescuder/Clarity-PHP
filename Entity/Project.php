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
     * @var array $files
     */
    protected $files;
    
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
    
    public function __construct()
    {
        parent::__construct();
        $this->files = array();
        $udfs = yaml_parse_file(__DIR__ . '/../Config/project_clarity_udfs.yml');
        $this->setClarityUDFs($udfs);
    }
    
    public function projectToXml()
    {
        $projectElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/project.xsd');
        
        $projectElement['uri'] = $this->clarityUri;
        $projectElement->name = $this->clarityName;
        $projectElement->{'open-date'} = $this->openDate;
        $projectElement->researcher['uri'] = $this->researcherUri;
        
        foreach ($projectElement->children('udf', true) as $udfElement) {
            $name = $udfElement->attributes()['name']->__toString();
            $udfElement[0] = $this->clarityUDFs[$name];
        }
        
        foreach ($this->files as $file) {
            $fileElement = $projectElement->addChild('file', null, 'http://genologics.com/ri/file');
            foreach ($file as $attribute => $value) {
                $fileElement->addAttribute($attribute, $value);
            }
        }
        
        $this->xml = $projectElement->asXML();
        $this->formatXml();
    }
    
    public function xmlToProject()
    {
        $projectElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $projectElement['uri']->__toString();
        $this->clarityId = $projectElement['limsid']->__toString();
        $this->clarityName = $projectElement->name->__toString();
        $this->openDate = $projectElement->{'open-date'}->__toString();
        $this->researcherUri = $projectElement->researcher['uri']->__toString();
        $this->researcherId = $this->getClarityIdFromUri($this->researcherUri);
        
        foreach ($projectElement->xpath('//udf:field') as $udfElement) {
            $field = $udfElement['name']->__toString();
            $value = $udfElement->__toString();
            $this->setClarityUDF($field, $value);
        }
        
        foreach ($projectElement->xpath('//file:file') as $fileElement) {
            $limsId = $fileElement['limsid']->__toString();
            $uri = $fileElement['uri']->__toString();
            $file = array(
                'limsid'  => $limsId,
                'uri' => $uri,
                );
            $this->setFile($file);
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
     * @param array $file
     */
    public function setFile(array $file)
    {
        if (array_key_exists('limsid', $file)) {
            $limsId = $file['limsid'];
            $this->files[$limsId]['limsid'] = $limsId;
            
            if (array_key_exists('uri', $file)) {
                $this->files[$limsId]['uri'] = $file['uri'];
            }
        }
    }
    
    /**
     * 
     * @param array $files
     */
    public function setFiles($files)
    {
        if (empty($files)) {
            $this->files = array();
        }
        else {
            foreach ($files as $file) {
                $this->setFile($file);
            }
        }
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
        $this->researcherUri = $researcherUri;
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
