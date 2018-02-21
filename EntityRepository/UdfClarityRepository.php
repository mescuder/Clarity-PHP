<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;
use Clarity\Entity\Udf;

/**
 * Description of UdfClarityRepository
 *
 * @author escudem
 */
class UdfClarityRepository extends ClarityRepository
{

    /**
     * 
     * @param ClarityApiConnector $connector
     */
    public function __construct(ClarityApiConnector $connector)
    {
        parent::__construct($connector);
        $this->endpoint = 'configuration/udfs';
    }

    public function apiAnswerToUdf($xmlData)
    {
        if ($this->checkApiException($xmlData)) {
            return null;
        } else {
            $udf = new Udf();
            $udf->setXml($xmlData);
            $udf->xmlToUdf();
            return $udf;
        }
    }

    public function find($id)
    {
        $path = $this->endpoint . '/' . $id;
        $xmlData = $this->connector->getResource($path);
        return $this->apiAnswerToUdf($xmlData);
    }
    
    public function findAllForProjects()
    {
        $path = $this->endpoint . '?attach-to-name=Project';
        $xmlData = $this->connector->getResource($path);
        $udfs = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $udfs);
        return $udfs;
    }

    /**
     * 
     * @return array
     */
    public function findAllForSamples()
    {
        $path = $this->endpoint . '?attach-to-name=Sample';
        $xmlData = $this->connector->getResource($path);
        $udfs = array();
        $this->makeArrayFromMultipleAnswer($xmlData, $udfs);
        return $udfs;
    }

    /**
     * 
     * @param string $xmlData
     * @param array $udfs
     */
    public function makeArrayFromMultipleAnswer($xmlData, array &$udfs)
    {
        $tmpUdf = new Udf();
        $configsElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($configsElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'udfconfig':
                        $udfId = $tmpUdf->getClarityIdFromUri($childElement['uri']->__toString());
                        //echo 'Fetching ' . $projectUri . PHP_EOL;
                        $udf = $this->find($udfId);
                        $udfs[] = $udf;
                        break;
                    case 'next-page':
                        $lastPage = FALSE;
                        $nextUri = $childElement['uri']->__toString();
                        $nextUriBits = explode('?', $nextUri);
                        $path = $this->endpoint . '?' . end($nextUriBits);
                        $xmlData = $this->connector->getResource($path);
                        $configsElement = new \SimpleXMLElement($xmlData);
                        break 2;
                    default:
                        break;
                }
            }
        }
    }
    
    public function updateProjectUdfs()
    {
        $udfs = $this->findAllForProjects();
        $udfFile = __DIR__ . '/../Config/project_clarity_udfs.yml';
        $fields = [];
        foreach ($udfs as $udf) {
            $fields[$udf->getClarityName()] = [
                'type' => $udf->getType(),
                'required' => $udf->getIsRequired(),
                'value' => '',
            ];
        }
        yaml_emit_file($udfFile, $fields);
    }

    public function updateSampleUdfs()
    {
        $udfs = $this->findAllForSamples();
        $udfFile = __DIR__ . '/../Config/sample_clarity_udfs.yml';
        $fields = [];
        foreach ($udfs as $udf) {
            $fields[$udf->getClarityName()] = [
                'type' => $udf->getType(),
                'required' => $udf->getIsRequired(),
                'value' => '',
            ];
        }
        yaml_emit_file($udfFile, $fields);
    }

}
