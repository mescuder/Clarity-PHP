<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Sample;

/**
 * Description of SampleClarityRepository
 *
 * @author Mickael Escudero
 */
class SampleClarityRepository
{

    /**
     *
     * @var resource $connector
     */
    protected $connector;

    /**
     *
     * @var string $endpoint
     */
    protected $endpoint;

    /**
     *
     * @var Sample $sample
     */
    protected $sample;

    /**
     *
     * @var SimpleXMLElement $xml
     */
    protected $xml;

    /**
     * 
     * @param ClarityApiConnector $connector
     * @param Sample $sample
     */
    public function __construct(ClarityApiConnector $connector = null, Sample $sample = null)
    {
        $this->endpoint = 'samples';
        $this->connector = $connector;
        $this->sample = $sample;
    }

    /**
     * 
     * @param string $id
     * @return Sample
     */
    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $data = $this->connector->getResource($path);
        $this->xml = new \SimpleXMLElement($data);
        $this->sample = $this->xmlToSample();

        return $this->sample;
    }

    /**
     * 
     * @param Sample $sample
     * @return Sample
     */
    public function save(Sample $sample = null)
    {
        if ($sample === null) {
            $sample = $this->sample;
        }
        if ($sample->getClarityId() === null) {
            $this->xml = simplexml_load_file('XmlTemplate/samplecreation.xsd');
            $this->xml->location->container['limsid'] = $sample->getContainerId();
            $this->xml->location->container['uri'] = $sample->getContainerUri();
            $this->xml->location->value = $sample->getContainerLocation();
        }
        $this->xml->name = $sample->getClarityName();
        $this->xml->project['uri'] = $sample->getProjectUri();
        $this->xml->project['limsid'] = $sample->getProjectId();
        $this->xml->submitter['uri'] = $sample->getSubmitterUri();
        $this->xml->submitter->{'first-name'} = $sample->getSubmitterFirst();
        $this->xml->submitter->{'last-name'} = $sample->getSubmitterLast();
        
        foreach ($this->xml->children('udf', true) as $udf) {
            $name = $udf->attributes()['name']->__toString();
            $udf[0] = $sample->getClarityUDF($name)['value'];
        }
        
        return $this->xml->asXML();
        
        if ($sample->getClarityId() === null)
        {
            return $this->connector->postResource($this->endpoint, $this->xml->asXML());
        }
        else 
        {
            return $this->connector->putResource();
        }
    }

    /**
     * 
     * @return Sample
     */
    public function xmlToSample()
    {
        $sample = new Sample();
        $sample->setClarityId($this->xml['limsid']->__toString());
        $sample->setClarityName($this->xml->name->__toString());
        $sample->setClarityUri($this->xml['uri']->__toString());
        $sample->setDateReceived($this->xml->{'date-received'}->__toString());
        $sample->setProjectId($this->xml->project['limsid']->__toString());
        $sample->setProjectUri($this->xml->project['uri']->__toString());
        $sample->setSubmitterFirst($this->xml->submitter->{'first-name'}->__toString());
        $sample->setSubmitterLast($this->xml->submitter->{'last-name'}->__toString());
        $sample->setArtifactId($this->xml->artifact['limsid']->__toString());
        $sample->setArtifactUri($this->xml->artifact['uri']->__toString());

        foreach ($this->xml->xpath('//udf:field') as $udf) {
            $field = $udf['name']->__toString();
            $value = $udf->__toString();
            $clarityUDF = array('name' => $field,
                'value' => $value,
            );
            $sample->setClarityUDF($clarityUDF);
        }

        return $sample;
    }

    /**
     * 
     * @param resource $connector
     */
    public function setConnector(resource $connector)
    {
        $this->connector = $connector;
    }

    /**
     * 
     * @return resource
     */
    public function getConnector()
    {
        return $this->connector;
    }

    /**
     * 
     * @param Sample $sample
     */
    public function setSample(Sample $sample)
    {
        $this->sample = $sample;
    }

    /**
     * 
     * @return Sample
     */
    public function getSample()
    {
        return $this->sample;
    }

    /**
     * 
     * @param SimpleXMLElement $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }

    /**
     * 
     * @return SimpleXMLElement
     */
    public function getXml()
    {
        return $this->xml;
    }

}
