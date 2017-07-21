<?php

namespace Clarity\Entity;

use Clarity\Entity\Container;

/**
 * Description of Tube
 *
 * @author escudem
 */
class Tube extends Container
{

    public function __construct() {
        parent::__construct();
        $this->typeName = 'Tube';
        $this->typeId = '2';
    }

    public function containerToXml() {
        if (empty($this->clarityId)) {
            $containerElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/containercreation.xsd');
        } else {
            $containerElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/container.xsd');
            $containerElement['uri'] = $this->clarityUri;
            $containerElement['limsid'] = $this->clarityId;
            $containerElement->{'occupied-wells'} = $this->occupiedWells;
            $containerElement->placement['uri'] = $this->placementUri;
            $containerElement->placement['limsid'] = $this->placementId;
            $containerElement->placement->value = $this->placementValue;
            $containerElement->state = $this->state;
        }
        $containerElement->name = $this->clarityName;
        $containerElement->type['uri'] = $this->typeUri;
        $containerElement->type['name'] = $this->typeName;

        $this->xml = $containerElement->asXML();
        $this->formatXml();
    }

    public function xmlToContainer() {
        $containerElement = new \SimpleXMLElement($this->xml);
        $this->clarityId = $containerElement['limsid']->__toString();
        $this->clarityUri = $containerElement['uri']->__toString();
        $this->clarityName = $containerElement->name->__toString();
        $this->typeName = $containerElement->type['name']->__toString();
        $this->typeUri = $containerElement->type['uri']->__toString();
        $this->occupiedWells = $containerElement->{'occupied-wells'}->__toString();
        if (!empty($containerElement->placement)) {
            $this->placementUri = $containerElement->placement['uri']->__toString();
            $this->placementId = $containerElement->placement['limsid']->__toString();
            $this->placementValue = $containerElement->placement->value->__toString();
        }
        $this->state = $containerElement->state->__toString();
    }

}
