<?php

namespace Clarity\Entity;

/**
 * Clarity
 * Description of Run
 *
 * @author Mickael Escudero
 */
class Run
{

    /**
     *
     * @var bigint $clusters
     */
    protected $clusters;

    /**
     *
     * @var bigint $clustersPF
     */
    protected $clustersPF;

    /**
     *
     * @var string $comments
     */
    protected $comments;

    /**
     *
     * @var string $containerId
     */
    protected $containerId;

    /**
     *
     * @var string $containerType
     */
    protected $containerType;

    /**
     *
     * @var string $containerUri
     */
    protected $containerUri;

    /**
     *
     * @var integer $cycles
     */
    protected $cycles;

    /**
     *
     * @var string $device
     */
    protected $device;

    /**
     *
     * @var datetime $endDate
     */
    protected $endDate;

    /**
     *
     * @var string $flowcellId 
     */
    protected $flowcellId;

    /**
     *
     * @var string $folderBasename
     */
    protected $folderBasename;

    /**
     *
     * @var string $instrumentCode
     */
    protected $instrumentCode;

    /**
     *
     * @var Collection $lanes
     */
    protected $lanes;

    /**
     *
     * @var datetime $startDate
     */
    protected $startDate;

    /**
     *
     * @var string $status
     */
    protected $status;

    /**
     *
     * @var string $type
     */
    protected $type;

    public function __construct()
    {
        $this->lanes = array();
    }

    /**
     * Set Clusters
     * 
     * @param bigint $clusters
     */
    public function setClusters($clusters)
    {
        $this->clusters = $clusters;
    }

    /**
     * Get Clusters
     * 
     * @return bigint
     */
    public function getClusters()
    {
        return $this->clusters;
    }

    /**
     * Set ClustersPF
     * 
     * @param bigint $clustersPF
     */
    public function setClustersPF($clustersPF)
    {
        $this->clustersPF = $clustersPF;
    }

    /**
     * Get ClustersPF
     * 
     * @return bigint
     */
    public function getClustersPF()
    {
        return $this->clustersPF;
    }

    /**
     * Set Comments
     * 
     * @param string $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Get Comments
     * 
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set ContainerId
     * 
     * @param string $containerId
     */
    public function setContainerId($containerId)
    {
        $this->containerId = $containerId;
    }

    /**
     * Get ContainerId
     * 
     * @return string
     */
    public function getContainerId()
    {
        return $this->containerId;
    }

    /**
     * Set ContainerType
     * 
     * @param string $containerType
     */
    public function setContainerType($containerType)
    {
        $this->containerType = $containerType;
    }

    /**
     * Get ContainerType
     * 
     * @return string
     */
    public function getContainerType()
    {
        return $this->containerType;
    }

    /**
     * Set ContainerUri
     * 
     * @param string $containerUri
     */
    public function setContainerUri($containerUri)
    {
        $this->containerUri = $containerUri;
    }

    /**
     * Get ContainerUri
     * 
     * @return string
     */
    public function getContainerUri()
    {
        return $this->containerUri;
    }

    /**
     * Set Cycles
     * 
     * @param int $cycles
     */
    public function setCycles($cycles)
    {
        $this->cycles = $cycles;
    }

    /**
     * Get Cycles
     * 
     * @return int
     */
    public function getCycles()
    {
        return $this->cycles;
    }

    /**
     * Set Device
     * 
     * @param string $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * Get Device
     * 
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set EndDate
     * 
     * @param datetime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Get EndDate
     * 
     * @return datetime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set flowcellId
     * 
     * @param string $flowcellId
     */
    public function setFlowcellId($flowcellId)
    {
        $this->flowcellId = $flowcellId;
    }

    /**
     * Get flowcellId
     * 
     * @return string
     */
    public function getFlowcellId()
    {
        return $this->flowcellId;
    }

    /**
     * Set FolderBasename
     * 
     * @param string $folderBasename
     */
    public function setFolderBasename($folderBasename)
    {
        $this->folderBasename = $folderBasename;
    }

    /**
     * Get FolderBasename
     * 
     * @return string
     */
    public function getFolderBasename()
    {
        return $this->folderBasename;
    }

    /**
     * Set InstrumentCode
     * 
     * @param string $instrumentCode
     */
    public function setInstrumentCode($instrumentCode)
    {
        $this->instrumentCode = $instrumentCode;
    }

    /**
     * Get InstrumentCode
     * 
     * @return string
     */
    public function getInstrumentCode()
    {
        return $this->instrumentCode;
    }

    /**
     * Add Lane to lanes Collection
     * 
     * @param Lane $lane
     */
    public function addLane($lane)
    {
        $this->lanes[] = $lane;
    }

    /**
     * Get Lanes
     * 
     * @return Collection
     */
    public function getLanes()
    {
        return $this->lanes;
    }

    /**
     * Set StartDate
     * 
     * @param datetime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Get StartDate
     * 
     * @return datetime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set Status
     * 
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get Status
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Type
     * 
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get Type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

}
