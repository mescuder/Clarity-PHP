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
    
    public function setAllowNonPreset(boolean $allowNonPreset)
    {
        $this->allowNonPreset = $allowNonPreset;
    }
    
    public function getAllowNonPreset()
    {
        return $this->allowNonPreset;
    }
    
    public function setAttachToCategory($attachToCategory)
    {
        $this->attachToCategory = $attachToCategory;
    }
    
    public function getAttachToCategory()
    {
        return $this->attachToCategory;
    }
    
    public function setAttachToName($attachToName)
    {
        $this->attachToName = $attachToName;
    }
    
    public function getAttachToName()
    {
        return $this->attachToName;
    }
    
}
