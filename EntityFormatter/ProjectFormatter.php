<?php

namespace Clarity\EntityFormatter;

use Clarity\Entity\Project;

/**
 * Description of ProjectFormatter
 *
 * @author escudem
 */
class ProjectFormatter
{

    protected $project;

    public function __construct($project = null)
    {
        if (!empty($project)) {
            $this->setProject($project);
        }
    }

    public function asYAML(Project $project)
    {
        $yamlArray = array();
        $projectId = $project->getClarityId();
        $yamlArray[$projectId]['Project ID'] = $projectId;
        $yamlArray[$projectId]['Project Name'] = $project->getClarityName();
        $yamlArray[$projectId]['Researcher'] = $project->getResearcher()->getFullName();
        $yamlArray[$projectId]['Lab'] = $project->getResearcher()->getLab()->getClarityName();
        $yamlArray[$projectId]['Opening date'] = $project->getOpenDate();
        $yamlArray[$projectId]['Closing date'] = $project->getCloseDate();
        foreach ($project->getClarityUDFs() as $udfName => $properties) {
            $value = $properties['value'];
            if ($udfName == 'Description') {
                $value = str_replace("\n", '', $value);
            }
            $yamlArray[$projectId]['UDFs'][$udfName] = $value;
        }

        return yaml_emit($yamlArray);
    }
    
    public function format(Project &$project, &$format)
    {
        if (empty($project)) {
            $project = $this->project;
        }
        
        switch ($format) {
            case 'yaml':
                return $this->asYAML($project);
            default:
                return 'The specified format "' . $format . '" is not available' . PHP_EOL;
        }
    }

    public function setProject($project)
    {
        $this->project = $project;
    }

    public function getProject()
    {
        return $this->project;
    }

}
