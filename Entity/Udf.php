<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Udf
 *
 * @author escudem
 */
class Udf extends ApiResource
{
    
    /**
     *
     * @var boolean $allowNonPreset
     */
    protected $allowNonPreset;
    
    /**
     *
     * @var string $attachToCategory
     */
    protected $attachToCategory;
    
    /**
     *
     * @var string $attachToName
     */
    protected $attachToName;
    
    /**
     *
     * @var string $clarityName
     */
    protected $clarityName;
    
    /**
     *
     * @var boolean $firstPresetIsDefault
     */
    protected $firstPresetIsDefault;
    
    /**
     *
     * @var boolean $isControlledVocabulary
     */
    protected $isControlledVocavulary;
    
    /**
     *
     * @var boolean $isDeviation
     */
    protected $isDeviation;
    
    /**
     *
     * @var boolean $isEditable
     */
    protected $isEditable;
    
    /**
     *
     * @var boolean $isRequired
     */
    protected $isRequired;
    
    /**
     *
     * @var array $presets
     */
    protected $presets;
    
    /**
     *
     * @var boolean $showInLablink
     */
    protected $showInLablink;
    
    /**
     *
     * @var boolean $showInTables
     */
    protected $showInTables;
    
    /**
     *
     * @var string $type
     */
    protected $type;
    
    public function __construct()
    {
        parent::__construct();
        $this->presets = [];
    }
    
    /**
     * 
     * @param boolean $allowNonPreset
     */
    public function setAllowNonPreset($allowNonPreset)
    {
        $this->allowNonPreset = $allowNonPreset;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getAllowNonPreset()
    {
        return $this->allowNonPreset;
    }
    
    /**
     * 
     * @param string $attachToCategory
     */
    public function setAttachToCategory($attachToCategory)
    {
        $this->attachToCategory = $attachToCategory;
    }
    
    /**
     * 
     * @return string
     */
    public function getAttachToCategory()
    {
        return $this->attachToCategory;
    }
    
    /**
     * 
     * @param string $attachToName
     */
    public function setAttachToName($attachToName)
    {
        $this->attachToName = $attachToName;
    }
    
    /**
     * 
     * @return string
     */
    public function getAttachToName()
    {
        return $this->attachToName;
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
     * @param boolean $firstPresetIsDefault
     */
    public function setFirstPresetIsDefault($firstPresetIsDefault)
    {
        $this->firstPresetIsDefault = $firstPresetIsDefault;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getFirstPresetIsDefault()
    {
        return $this->firstPresetIsDefault;
    }
    
    /**
     * 
     * @param boolean $isControlledVocabulary
     */
    public function setIsControlledVocavulary($isControlledVocabulary)
    {
        $this->isControlledVocavulary = $isControlledVocabulary;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsControlledVocabulary()
    {
        return $this->isControlledVocavulary;
    }
    
    /**
     * 
     * @param boolean $isDeviation
     */
    public function setIsDeviation($isDeviation)
    {
        $this->isDeviation = $isDeviation;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsDeviation()
    {
        return $this->isDeviation;
    }
    
    /**
     * 
     * @param boolean $isEditable
     */
    public function setIsEditable($isEditable)
    {
        $this->isEditable = $isEditable;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsEditable()
    {
        return $this->isEditable;
    }
    
    /**
     * 
     * @param boolean $isRequired
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }
    
    /**
     * 
     * @param array $presets
     */
    public function setPresets(array $presets)
    {
        $this->presets = $presets;
    }
    
    /**
     * 
     * @return array
     */
    public function getPresets()
    {
        return $this->presets;
    }
    
    /**
     * 
     * @param string $preset
     */
    public function addPreset($preset)
    {
        $this->presets[] = $preset;
    }
    
    /**
     * 
     * @param boolean $showInLablink
     */
    public function setShowInLablink($showInLablink)
    {
        $this->showInLablink = $showInLablink;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getShowInLablink()
    {
        return $this->showInLablink;
    }
    
    /**
     * 
     * @param boolean $showInTables
     */
    public function setShowInTables($showInTables)
    {
        $this->showInTables = $showInTables;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getShowInTables()
    {
        return $this->showInTables;
    }
    
    /**
     * 
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
}
