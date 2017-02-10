<?php

namespace Clarity\Entity;

/**
 * Description of Container
 *
 * @author Mickael Escudero
 */
abstract class Container
{

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
     * @var string $clarityTypeEndpoint
     */
    protected $clarityTypeEndpoint;
    
    /**
     *
     * @var string $clarityTypeName
     */
    protected $clarityTypeName;
    
    /**
     *
     * @var string $clarityTypeUri
     */
    protected $clarityTypeUri;

    /**
     *
     * @var string $clarityUri
     */
    protected $clarityUri;

    public function __construct()
    {
        $this->clarityName = '';
    }

    /**
     * Set ClarityId
     * 
     * @param string $clarityId
     */
    public function setClarityId($clarityId)
    {
        $this->clarityId = $clarityId;
    }
    
    /**
     * Get ClarityId
     * 
     * @return string
     */
    public function getClarityId()
    {
        return $this->clarityId;
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
    
    /**
     * 
     * @param string $clarityTypeEndpoint
     */
    public function setClarityTypeEndpoint($clarityTypeEndpoint)
    {
        $this->clarityTypeEndpoint = $clarityTypeEndpoint;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityTypeEndpoint()
    {
        return $this->clarityTypeEndpoint;
    }
    
    /**
     * Set ClarityTypeName
     * 
     * @param string $clarityTypeName
     */
    public function setClarityTypeName($clarityTypeName)
    {
        $this->clarityTypeName = $clarityTypeName;
    }
    
    /**
     * Get ClarityTypeName
     * 
     * @return string
     */
    public function getClarityTypeName()
    {
        return $this->clarityTypeName;
    }
    
    /**
     * Set ClarityTypeUri
     * 
     * @param string $clarityTypeUri
     */
    public function setClarityTypeUri($clarityTypeUri)
    {
        $this->clarityTypeUri = $clarityTypeUri;
    }
    
    /**
     * Get ClarityTypeUri
     * 
     * @return string
     */
    public function getClarityTypeUri()
    {
        return $this->clarityTypeUri;
    }
    
    /**
     * Set ClarityUri
     * 
     * @param string $clarityUri
     */
    public function setClarityUri($clarityUri)
    {
        $this->clarityUri = $clarityUri;
    }
    
    /**
     * Get ClarityUri
     * 
     * @return string
     */
    public function getClarityUri()
    {
        return $this->clarityUri;
    }

}
