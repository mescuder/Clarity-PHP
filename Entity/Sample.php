<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Sample
 *
 * @author Mickael Escudero
 */
class Sample extends ApiResource
{

    /**
     *
     * @var string
     */
    protected $artifactId;
    
    /**
     *
     * @var string
     */
    protected $artifactUri;
    
    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
    /**
     *
     * @var Container $container
     */
    protected $container;

    /**
     *
     * @var string $containerId
     */
    protected $containerId;
    
    /**
     *
     * @var string $containerLocation
     */
    protected $containerLocation;
    
    /**
     *
     * @var string $containerUri
     */
    protected $containerUri;

    /**
     *
     * @var date $dateReceived
     */
    protected $dateReceived;

    /**
     *
     * @var string $projectId
     */
    protected $projectId;

    /**
     *
     * @var string $projectName
     */
    protected $projectName;

    /**
     *
     * @var string $projectUri
     */
    protected $projectUri;

    /**
     *
     * @var string $submitterFirst
     */
    protected $submitterFirst;
    
    /**
     *
     * @var string $submitterId
     */
    protected $submitterId;
    
    /**
     *
     * @var string $submitterLast
     */
    protected $submitterLast;
    
    /**
     *
     * @var string $submitterUri
     */
    protected $submitterUri;

    public function __construct()
    {
        parent::__construct();
        $udfs = yaml_parse_file(__DIR__ . '/../Config/sample_clarity_udfs.yml');
        $this->setClarityUDFs($udfs);
    }
    
    public function sampleToXml()
    {
        if (empty($this->clarityId)) {
            $sampleElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/samplecreation.xsd');
            $sampleElement->location->container['limsid'] = $this->containerId;
            $sampleElement->location->container['uri'] = $this->containerUri;
            $sampleElement->location->value = $this->containerLocation;
        }
        else {
            $sampleElement = simplexml_load_file('XmlTemplate/sample.xsd');
            $sampleElement->artifact['limsid'] = $this->artifactId;
            $sampleElement->artifact['uri'] = $this->artifactUri;
        }
        $sampleElement->name = $this->clarityName;
        $sampleElement->project['uri'] = $this->projectUri;
        $sampleElement->project['limsid'] = $this->projectId;
        
        $this->xml = $sampleElement->asXML();
        
        foreach ($this->xml->children('udf', true) as $udf) {
            $name = $udf->attributes()['name']->__toString();
            $udf[0] = $this->clarityUDFs[$name]['value'];
        }
        
        $this->formatXml();
    }
    
    public function xmlToSample()
    {
        $sampleElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $sampleElement['uri']->__toString();
        $this->clarityId = $sampleElement['limsid']->__toString();
        $this->clarityName = $sampleElement->name->__toString();
        $this->dateReceived = $sampleElement->{'date-received'}->__toString();
        $this->projectId = $sampleElement->project['limsid']->__toString();
        $this->projectUri = $sampleElement->project['uri']->__toString();
        $this->submitterUri = $sampleElement->submitter['uri']->__toString();
        $this->submitterFirst = $sampleElement->submitter->{'first-name'}->__toString();
        $this->submitterLast = $sampleElement->submitter->{'last-name'}->__toString();
        $this->artifactId = $sampleElement->artifact['limsid']->__toString();
        $this->artifactUri = $sampleElement->artifact['uri']->__toString();
        
        foreach ($sampleElement->xpath('//udf:field') as $udfElement) {
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
     * @param string $artifactId
     */
    public function setArtifactId($artifactId)
    {
        $this->artifactId = $artifactId;
    }
    
    /**
     * 
     * @return string
     */
    public function getArtifactId()
    {
        return $this->artifactId;
    }
    
    /**
     * 
     * @param string $artifactUri
     */
    public function setArtifactUri($artifactUri)
    {
        $this->artifactUri = $artifactUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getArtifactUri()
    {
        return $this->artifactUri;
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
     * @param Container $container
     */
    public function setContainer($container)
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
     * @param string $containerId
     */
    public function setContainerId($containerId)
    {
        $this->containerId = $containerId;
    }

    /**
     * 
     * @return string
     */
    public function getContainerId()
    {
        return $this->containerId;
    }
    
    /**
     * 
     * @param string $containerLocation
     */
    public function setContainerLocation($containerLocation)
    {
        $this->containerLocation = $containerLocation;
    }
    
    /**
     * 
     * @return string
     */
    public function getContainerLocation()
    {
        return $this->containerLocation;
    }

    /**
     * 
     * @param string $containerUri
     */
    public function setContainerUri($containerUri)
    {
        $this->containerUri = $containerUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getContainerUri()
    {
        return $this->containerUri;
    }
    
    /**
     * 
     * @param date $dateReceived
     */
    public function setDateReceived($dateReceived)
    {
        $this->dateReceived = $dateReceived;
    }

    /**
     * 
     * @return date
     */
    public function getDateReceived()
    {
        return $this->dateReceived;
    }

    /**
     * 
     * @param string $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * 
     * @return string
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * 
     * @param string $projectName
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    /**
     * 
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * 
     * @param string $projectUri
     */
    public function setProjectUri($projectUri)
    {
        $this->projectUri = $projectUri;
    }

    /**
     * 
     * @return string
     */
    public function getProjectUri()
    {
        return $this->projectUri;
    }

    /**
     * 
     * @param string $submitterFirst
     */
    public function setSubmitterFirst($submitterFirst)
    {
        $this->submitter = $submitterFirst;
    }

    /**
     * 
     * @return string
     */
    public function getSubmitterFirst()
    {
        return $this->submitterFirst;
    }
    
    /**
     * 
     * @param string $submitterId
     */
    public function setSubmitterId($submitterId)
    {
        $this->submitterId = $submitterId;
    }
    
    /**
     * 
     * @return string
     */
    public function getSubmitterId()
    {
        return $this->submitterId;
    }
    
    /**
     * 
     * @param string $submitterLast
     */
    public function setSubmitterLast($submitterLast)
    {
        $this->submitterLast = $submitterLast;
    }
    
    /**
     * 
     * @return string
     */
    public function getSubmitterLast()
    {
        return $this->submitterLast;
    }
    
    /**
     * 
     * @param string $submitterUri
     */
    public function setSubmitterUri($submitterUri)
    {
        $this->submitterUri = $submitterUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getSubmitterUri()
    {
        return $this->submitterUri;
    }

}
