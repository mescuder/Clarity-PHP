<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Container
 *
 * @author Mickael Escudero
 */
abstract class Container extends ApiResource
{

    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
    /**
     *
     * @var int $occupiedWells
     */
    protected $occupiedWells;
    
    /**
     *
     * @var string $placementId
     */
    protected $placementId;
    
    /**
     *
     * @var string $placementUri
     */
    protected $placementUri;
    
    /**
     *
     * @var string $placementValue
     */
    protected $placementValue;
    
    /**
     *
     * @var string $state
     */
    protected $state;
    
    /**
     *
     * @var string $typeId
     */
    protected $typeId;

    /**
     *
     * @var string $clarityTypeName
     */
    protected $typeName;
    
    /**
     *
     * @var string $typeUri
     */
    protected $typeUri;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set ClarityName
     * 
     * @param string $clarityName
     */
    public function setClarityName($clarityName)
    {
        $this->clarityName = $clarityName;
    }
    
    /**
     * Get ClarityName
     * 
     * @return string
     */
    public function getClarityName()
    {
        return $this->clarityName;
    }
    
    public function setPlacementId($placementId)
    {
        $this->placementId = $placementId;
    }
    
    public function setOccupiedWells($occupiedWells)
    {
        $this->occupiedWells = $occupiedWells;
    }
    
    public function getOccupiedWells()
    {
        return $this->occupiedWells;
    }
    
    public function getPlacementId()
    {
        return $this->placementId;
    }
    
    public function setPlacementUri($placementUri)
    {
        $this->placementUri = $placementUri;
    }
    
    public function getPlacementUri()
    {
        return $this->placementUri;
    }
    
    public function setPlacementValue($placementValue)
    {
        $this->placementValue = $placementValue;
    }
    
    public function getPlacementValue()
    {
        return $this->placementValue;
    }
    
    public function setState($state)
    {
        $this->state = $state;
    }
    
    public function getState()
    {
        return $this->state;
    }
    
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }
    
    public function getTypeId()
    {
        return $this->typeId;
    }
    
    /**
     * Set typeName
     * 
     * @param string $typeName
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
    }
    
    /**
     * Get typeName
     * 
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }
    
    /**
     * Set typeUri
     * 
     * @param string $typeUri
     */
    public function setTypeUri($typeUri)
    {
        $this->typeUri = $typeUri;
    }
    
    /**
     * Get typeUri
     * 
     * @return string
     */
    public function getTypeUri()
    {
        return $this->typeUri;
    }

}
