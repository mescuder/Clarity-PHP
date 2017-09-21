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

    public function asYAML(Project $project = null)
    {
        if (empty($project)) {
            $project = $this->project;
        }
        $yamlArray = array();
        $projectId = $project->getClarityId();
        $yamlArray[$projectId]['Project ID'] = $projectId;
        $yamlArray[$projectId]['Project Name'] = $project->getClarityName();
        $yamlArray[$projectId]['Researcher'] = $project->getResearcher()->getFullName();
        foreach ($project->getClarityUDFs() as $udf => $value) {
            $yamlArray[$projectId]['UDFs'][$udf] = $value;
        }

        return $yamlArray;
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
