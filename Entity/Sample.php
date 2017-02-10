<?php

namespace Clarity\Entity;

/**
 * Description of Sample
 *
 * @author Mickael Escudero
 */
class Sample
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
     * @var string $solexaId
     */
    protected $solexaId;

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
        $this->clarityUDFs = array();
        $udfs = yaml_parse_file('Config/sample_clarity_udfs.yml');
        foreach ($udfs as $udf) {
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
     * @param string $solexaId
     */
    public function setSolexaId($solexaId)
    {
        $this->solexaId = $solexaId;
    }

    /**
     * 
     * @return string
     */
    public function getSolexaId()
    {
        return $this->solexaId;
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
