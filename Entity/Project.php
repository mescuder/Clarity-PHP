<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Project
 *
 * @author Mickael Escudero
 */
class Project extends ApiResource {

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
     * @var string
     */
    protected $closeDate;

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
    
    /**
     *
     * @var array
     */
    protected $samples;

    public function __construct() {
        parent::__construct();
        $this->files = array();
        $this->samples = array();
        $udfs = yaml_parse_file(__DIR__ . '/../Config/project_clarity_udfs.yml');
        $this->setClarityUDFs($udfs);
    }

    public function getTabLine($mode = '') {
        $lineArray = array(
            'Name' => '',
            'ID' => '',
            'Scientist' => '',
            'Lab' => '',
            'Opening date' => '',
            'Closing date' => '',
            'Project type' => '',
            'Library prep method' => '',
            'Prep kit' => '',
            'Sample quota' => '',
            'Sample count' => '',
            'Sequencer type' => '',
            'Read length' => '',
            'Run type' => '',
            'Coverage' => '',
            'Depth' => '',
            'Genome' => '',
            'Funding source' => '',
            'Approximate cost' => '',
            'Fragment size' => '',
            'Number of cells' => '',
            'Bioinformatician' => '',
            'Description' => '',
            'Test ID' => '',
        );
        if ($mode == 'header') {
            $keys = array_keys($lineArray);
            $line = implode("\t", $keys) . PHP_EOL;
            return $line;
        }
        else {
            $lineArray['Name'] = $this->clarityName;
            $lineArray['ID'] = $this->clarityId;
            $lineArray['Scientist'] = $this->researcher->getFullName();
            $lineArray['Lab'] = $this->researcher->getLab()->getClarityName();
            $lineArray['Opening date'] = $this->openDate;
            $lineArray['Closing date'] = $this->closeDate;
            $lineArray['Project type'] = $this->clarityUDFs['Project type'];
            $lineArray['Library prep method'] = $this->clarityUDFs['Library Prep Method'];
            $lineArray['Prep kit'] = $this->clarityUDFs['Prep Kit'];
            $lineArray['Sample quota'] = $this->clarityUDFs['Sample quota'];
            $lineArray['Sequencer type'] = $this->clarityUDFs['Sequencer type'];
            $lineArray['Read length'] = $this->clarityUDFs['Read Length'];
            $lineArray['Run type'] = $this->clarityUDFs['Run Type'];
            $lineArray['Coverage'] = $this->clarityUDFs['Coverage'];
            $lineArray['Depth'] = $this->clarityUDFs['Depth'];
            $lineArray['Genome'] = $this->clarityUDFs['Genome build'];
            $lineArray['Funding source'] = $this->clarityUDFs['Funding source'];
            $lineArray['Approximate cost'] = $this->clarityUDFs['Approximate cost'];
            $lineArray['Fragment size'] = $this->clarityUDFs['Fragment Size'];
            $lineArray['Number of cells'] = $this->clarityUDFs['Number of experiments (total number of cells)'];
            $lineArray['Bioinformatician'] = $this->clarityUDFs['Bioinformatician'];
            $lineArray['Description'] = str_replace("\n", '', $this->clarityUDFs['Description']);
            $lineArray['Test ID'] = $this->clarityUDFs['Test ID'];
            foreach ($lineArray as $key => $value) {
                if (empty($value)) {
                    $lineArray[$key] = '';
                }
            }
            $lineArray['Sample count'] = count($this->samples);
            $values = array_values($lineArray);
            $line = implode("\t", $values) . PHP_EOL;
            return $line;
        }
    }

    public function projectToXml() {
        $projectElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/project.xsd');

        $projectElement['uri'] = $this->clarityUri;
        $projectElement->name = $this->clarityName;
        $projectElement->{'open-date'} = $this->openDate;
        $projectElement->researcher['uri'] = $this->researcherUri;

        if (!empty($this->closeDate)) {
            $projectElement->addChild('close-date', $this->closeDate, null);
        }
        
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

    public function xmlToProject() {
        $projectElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $projectElement['uri']->__toString();
        $this->clarityId = $projectElement['limsid']->__toString();
        $this->clarityName = $projectElement->name->__toString();
        $this->openDate = $projectElement->{'open-date'}->__toString();
        if (!empty($projectElement->{'close-date'})) {
            $this->closeDate = $projectElement->{'close-date'}->__toString();
        }
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
                'limsid' => $limsId,
                'uri' => $uri,
            );
            $this->setFile($file);
        }
    }

    /**
     * 
     * @param string $clarityName
     */
    public function setClarityName($clarityName) {
        $this->clarityName = $clarityName;
    }

    /**
     * 
     * @return string
     */
    public function getClarityName() {
        return $this->clarityName;
    }
    
    /**
     * 
     * @param string $closeDate
     */
    public function setCloseDate($closeDate)
    {
        $this->closeDate = $closeDate;
    }
    
    /**
     * 
     * @return string
     */
    public function getCloseDate()
    {
        return $this->closeDate;
    }

    /**
     * 
     * @param array $file
     */
    public function setFile(array $file) {
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
    public function setFiles($files) {
        if (empty($files)) {
            $this->files = array();
        } else {
            foreach ($files as $file) {
                $this->setFile($file);
            }
        }
    }

    /**
     * 
     * @param string $openDate
     */
    public function setOpenDate($openDate) {
        $this->openDate = $openDate;
    }

    /**
     * 
     * @return string
     */
    public function getOpenDate() {
        return $this->openDate;
    }

    /**
     * 
     * @param Researcher $researcher
     */
    public function setResearcher($researcher) {
        $this->researcher = $researcher;
    }

    /**
     * 
     * @return Researcher
     */
    public function getResearcher() {
        return $this->researcher;
    }

    /**
     * 
     * @param string $researcherId
     */
    public function setResearcherId($researcherId) {
        $this->researcherId = $researcherId;
    }

    /**
     * 
     * @return string
     */
    public function getResearcherId() {
        return $this->researcherId;
    }

    /**
     * 
     * @param string $researcherUri
     */
    public function setResearcherUri($researcherUri) {
        $this->researcherUri = $researcherUri;
    }

    /**
     * 
     * @return string
     */
    public function getResearcherUri() {
        return $this->researcherUri;
    }
    
    /**
     * 
     * @param array $samples
     */
    public function setSamples(array $samples)
    {
        $this->samples = $samples;
    }
    
    /**
     * 
     * @return array
     */
    public function getSamples()
    {
        return $this->samples;
    }
    
    /**
     * 
     * @param Sample $sample
     */
    public function addSample($sample)
    {
        $this->samples[] = $sample;
    }

}
