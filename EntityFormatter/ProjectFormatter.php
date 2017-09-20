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
