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
    protected $isControlledVocabulary;
    
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
    
    public function udfToXml()
    {
        $fieldElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/udf.xsd');
        
        $fieldElement['uri'] = $this->clarityUri;
        $fieldElement['type'] = $this->type;
        $fieldElement->name = $this->clarityName;
        $fieldElement->{'attach-to-name'} = $this->attachToName;
        $fieldElement->{'attach-to-category'} = $this->attachToCategory;
        $fieldElement->{'show-in-lablink'} = $this->showInLablink;
        $fieldElement->{'allow-non-preset-values'} = $this->allowNonPreset;
        $fieldElement->{'first-preset-is-default-value'} = $this->firstPresetIsDefault;
        $fieldElement->{'show-in-tables'} = $this->showInTables;
        $fieldElement->{'is-editable'} = $this->isEditable;
        $fieldElement->{'is-deviation'} = $this->isDeviation;
        $fieldElement->{'is-required'} = $this->isRequired;
        $fieldElement->{'is-controlled-vocabulary'} = $this->isControlledVocabulary;
        foreach ($this->presets as $preset) {
            $presetElement = $fieldElement->addChild('preset', $preset, '');
        }
        
        $this->xml = $fieldElement->asXML();
        $this->formatXml();
    }
    
    public function xmlToUdf()
    {
        $fieldElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $fieldElement['uri']->__toString();
        $this->type = $fieldElement['type']->__toString();
        $this->setClarityIdFromUri();
        $this->clarityName = $fieldElement->name->__toString();
        $this->attachToName = $fieldElement->{'attach-to-name'}->__toString();
        $this->attachToCategory = $fieldElement->{'attach-to-category'}->__toString();
        $this->showInLablink = $fieldElement->{'show-in-lablink'}->__toString();
        $this->allowNonPreset = $fieldElement->{'allow-non-preset-values'}->__toString();
        $this->firstPresetIsDefault = $fieldElement->{'first-preset-is-default-value'}->__toString();
        $this->showInTables = $fieldElement->{'show-in-tables'}->__toString();
        $this->isEditable = $fieldElement->{'is-editable'}->__toString();
        $this->isDeviation = $fieldElement->{'is-deviation'}->__toString();
        $this->isRequired = $fieldElement->{'is-required'}->__toString();
        $this->isControlledVocabulary = $fieldElement->{'is-controlled-vocabulary'}->__toString();
        foreach ($fieldElement->xpath('preset') as $presetElement) {
            $preset = htmlspecialchars($presetElement->__toString());
            $this->addPreset($preset);
        }
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
    public function setIsControlledVocabulary($isControlledVocabulary)
    {
        $this->isControlledVocabulary = $isControlledVocabulary;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsControlledVocabulary()
    {
        return $this->isControlledVocabulary;
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
