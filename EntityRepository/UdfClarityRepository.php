<?php

namespace Clarity\EntityRepository;

use Clarity\Connector\ClarityApiConnector;

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
        $configsElement = new \SimpleXMLElement($xmlData);
        $lastPage = FALSE;
        while (!$lastPage) {
            $lastPage = TRUE;
            foreach ($configsElement->children() as $childElement) {
                $childName = $childElement->getName();
                switch ($childName) {
                    case 'udfconfig':
                        $projectId = $childElement['limsid']->__toString();
                        //echo 'Fetching ' . $projectUri . PHP_EOL;
                        $project = $this->find($projectId);
                        $udfs[] = $project;
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

}
