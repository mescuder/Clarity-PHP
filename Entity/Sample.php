<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Sample
 *
 * @author escudem
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
     * @var string $dateCompleted
     */
    protected $dateCompleted;

    /**
     *
     * @var date $dateReceived
     */
    protected $dateReceived;

    /**
     *
     * @var string $indexType
     */
    protected $indexType;

    /**
     *
     * @var Project $project
     */
    protected $project;

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
     * @var type array
     */
    protected $samplesheetExtras;

    /**
     *
     * @var string $samplesheetId
     */
    protected $samplesheetId;

    /**
     *
     * @var string $samplesheetIndex1
     */
    protected $samplesheetIndex1;

    /**
     *
     * @var string $samplesheetIndex2
     */
    protected $samplesheetIndex2;

    /**
     *
     * @var int $samplesheetLane
     */
    protected $samplesheetLane;

    /**
     *
     * @var string $samplesheetName
     */
    protected $samplesheetName;

    /**
     *
     * @var string $samplesheetProject
     */
    protected $samplesheetProject;

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
        $this->samplesheetLane = 0;
        $udfs = yaml_parse_file(__DIR__ . '/../Config/sample_clarity_udfs.yml');
        $this->setClarityUDFs($udfs);
        $this->samplesheetExtras = array();
        $this->samplesheetIndex1 = '';
        $this->samplesheetIndex2 = '';
        $this->samplesheetLane = '1';
    }
    
    public function determineIndexType()
    {
        $index1 = $this->samplesheetIndex1;
        $index2 = $this->samplesheetIndex2;
        if (!empty($index1) && !empty($index2)) {
            return 'dual';
        } elseif (!empty($index1) && preg_match('#^[ATGC]{6}$#', $index1)) {
            return 'short';
        } elseif (!empty($index1) && preg_match('#^[ATGC]{8}$#', $index1)) {
            return 'long';
        } elseif (!empty($index1) && preg_match('#^SI[-_]#', $index1)) {
            return 'tenx';
        } elseif (empty($index1) && empty($index2)) {
            return 'none';
        }
    }

    /**
     * 
     * @param string $sampleId
     * @return string
     */
    public function getProjectIdFromSampleId($sampleId = null)
    {
        if (empty($sampleId)) {
            $sampleId = $this->clarityId;
        }

        if ($this->isClarityId($sampleId)) {
            $matches = array();
            preg_match('#^([[:alpha:]]{3}\d+)A\d+$#', $sampleId, $matches);
            return $matches[1];
        }
    }

    public function isClarityId($search)
    {
        if (preg_match('#^[[:alpha:]]{3}\d+A\d+$#', $search)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function revComp($index)
    {
        $index_c = '';
        $nuc2nuc = array(
            'A' => 'T',
            'T' => 'A',
            'C' => 'G',
            'G' => 'C'
        );
        for ($i = 0; $i < strlen($index); $i++) {
            $nuc = $index[$i];
            $index_c .= $nuc2nuc[$nuc];
        }
        $index_rc = strrev($index_c);
        return $index_rc;
    }

    public function sampleToXml()
    {
        if (empty($this->clarityId)) {
            $sampleElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/samplecreation.xsd');
            $sampleElement->location->container['limsid'] = $this->containerId;
            $sampleElement->location->container['uri'] = $this->containerUri;
            $sampleElement->location->value = $this->containerLocation;
        } else {
            $sampleElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/sample.xsd');
            $sampleElement['uri'] = $this->clarityUri;
            $sampleElement['limsid'] = $this->clarityId;
            if (empty($this->dateReceived)) {
                unset($sampleElement->{'date-received'});
            } else {
                $sampleElement->{'date-received'} = $this->dateReceived;
            }
            if (empty($this->dateCompleted)) {
                unset($sampleElement->{'date-completed'});
            } else {
                $sampleElement->{'date-completed'} = $this->dateCompleted;
            }
            $sampleElement->artifact['limsid'] = $this->artifactId;
            $sampleElement->artifact['uri'] = $this->artifactUri;
        }
        $sampleElement->name = $this->clarityName;
        $sampleElement->project['uri'] = $this->projectUri;
        $sampleElement->project['limsid'] = $this->projectId;
        $sampleElement->submitter['uri'] = $this->submitterUri;
        $sampleElement->submitter->{'first-name'} = $this->submitterFirst;
        $sampleElement->submitter->{'last-name'} = $this->submitterLast;

        foreach ($this->clarityUDFs as $udfName => $properties) {
            $udfType = $properties['type'];
            $udfValue = $properties['value'];
            $udfElement = $sampleElement->addChild('field', $udfValue, 'http://genologics.com/ri/userdefined');
            $udfElement->addAttribute('type', $udfType);
            $udfElement->addAttribute('name', $udfName);
        }

        $this->xml = $sampleElement->asXML();
        $this->formatXml();
    }

    public function xmlToSample()
    {
        $sampleElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $sampleElement['uri']->__toString();
        $this->clarityId = $sampleElement['limsid']->__toString();
        $this->clarityName = $sampleElement->name->__toString();
        $this->dateReceived = $sampleElement->{'date-received'}->__toString();
        if (!empty($sampleElement->{'date-received'})) {
            $this->dateCompleted = $sampleElement->{'date-completed'}->__toString();
        }
        if (!empty($sampleElement->{'date-completed'})) {
            $this->dateCompleted = $sampleElement->{'date-completed'}->__toString();
        }
        if (!empty($sampleElement->project['limsid'])) {
            $this->projectId = $sampleElement->project['limsid']->__toString();
            $this->projectUri = $sampleElement->project['uri']->__toString();
        }
        $this->submitterUri = $sampleElement->submitter['uri']->__toString();
        $this->submitterFirst = $sampleElement->submitter->{'first-name'}->__toString();
        $this->submitterLast = $sampleElement->submitter->{'last-name'}->__toString();
        $this->artifactId = $sampleElement->artifact['limsid']->__toString();
        $this->artifactUri = $sampleElement->artifact['uri']->__toString();

        foreach ($sampleElement->xpath('//udf:field') as $udfElement) {
            $name = $udfElement['name']->__toString();
            $value = $udfElement->__toString();
            $this->setClarityUDF($name, $value);
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
     * @param string $dateCompleted
     */
    public function setDateCompleted($dateCompleted)
    {
        $this->dateCompleted = $dateCompleted;
    }

    /**
     * 
     * @return string
     */
    public function getDateCompleted()
    {
        return $this->dateCompleted;
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
    
    public function setIndexType($indexType)
    {
        $this->indexType = $indexType;
    }
    
    public function getIndexType()
    {
        return $this->indexType;
    }

    /**
     * 
     * @param Project $project
     */
    public function setProject(&$project)
    {
        $this->project = $project;
    }

    /**
     * 
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
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
    
    public function setSamplesheetExtra($key, $value)
    {
        $this->samplesheetExtras[$key] = $value;
    }
    
    public function getSamplesheetExtra($key)
    {
        return $this->samplesheetExtras[$key];
    }
    
    /**
     * 
     * @return array
     */
    public function getSamplesheetExtras()
    {
        return $this->samplesheetExtras;
    }

    /**
     * 
     * @param string $samplesheetId
     */
    public function setSamplesheetId($samplesheetId)
    {
        $this->samplesheetId = $samplesheetId;
    }

    /**
     * 
     * @return string
     */
    public function getSamplesheetId()
    {
        return $this->samplesheetId;
    }

    /**
     * 
     * @param string $samplesheetIndex1
     */
    public function setSamplesheetIndex1($samplesheetIndex1)
    {
        $samplesheetIndex1 = strtoupper(trim($samplesheetIndex1));
        if (!empty($samplesheetIndex1)) {
            preg_match('#^([0-9a-z-_]+)#i', $samplesheetIndex1, $matches);
            $samplesheetIndex1 = $matches[1];
        }
        $this->samplesheetIndex1 = $samplesheetIndex1;
        $this->setIndexType($this->determineIndexType());
    }

    /**
     * 
     * @return string
     */
    public function getSamplesheetIndex1()
    {
        return $this->samplesheetIndex1;
    }

    /**
     * 
     * @param string $samplesheetIndex2
     */
    public function setSamplesheetIndex2($samplesheetIndex2)
    {
        $samplesheetIndex2 = strtoupper(trim($samplesheetIndex2));
        if (!empty($samplesheetIndex2)) {
            preg_match('#^([0-9a-z-_]+)#i', $samplesheetIndex2, $matches);
            $samplesheetIndex2 = $matches[1];
        }
        $this->samplesheetIndex2 = $samplesheetIndex2;
        $this->setIndexType($this->determineIndexType());
    }

    /**
     * 
     * @return string
     */
    public function getSamplesheetIndex2()
    {
        return $this->samplesheetIndex2;
    }

    /**
     * 
     * @param int $samplesheetLane
     */
    public function setSamplesheetLane($samplesheetLane)
    {
        $this->samplesheetLane = $samplesheetLane;
    }

    /**
     * 
     * @return int
     */
    public function getSamplesheetLane()
    {
        return $this->samplesheetLane;
    }

    /**
     * 
     * @param string $samplesheetName
     */
    public function setSamplesheetName($samplesheetName)
    {
        $this->samplesheetName = $samplesheetName;
    }

    /**
     * 
     * @return string
     */
    public function getSamplesheetName()
    {
        return $this->samplesheetName;
    }

    /**
     * 
     * @param string $samplesheetProject
     */
    public function setSamplesheetProject($samplesheetProject)
    {
        $this->samplesheetProject = $samplesheetProject;
    }

    /**
     * 
     * @return string
     */
    public function getSamplesheetProject()
    {
        return $this->samplesheetProject;
    }

    /**
     * 
     * @param string $submitterFirst
     */
    public function setSubmitterFirst($submitterFirst)
    {
        $this->submitterFirst = $submitterFirst;
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
