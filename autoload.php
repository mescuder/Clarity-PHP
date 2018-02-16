<?php

spl_autoload_register(
        function($class) {
            static $classes = null;
            if ($classes === null) {
                $classes = [
                'Clarity\Connector\ClarityApiConnector'                => '/Connector/ClarityApiConnector.php',
                'Clarity\Entity\ApiResource'                           => '/Entity/ApiResource.php',
                'Clarity\Entity\Container'                             => '/Entity/Container.php',
                'Clarity\Entity\Tube'                                  => '/Entity/Tube.php',
                'Clarity\Entity\Sample'                                => '/Entity/Sample.php',
                'Clarity\Entity\Project'                               => '/Entity/Project.php',
                'Clarity\Entity\Researcher'                            => '/Entity/Researcher.php',
                'Clarity\Entity\Lab'                                   => '/Entity/Lab.php',
                'Clarity\Entity\Run'                                   => '/Entity/Run.php',
                'Clarity\Entity\Udf'                                   => '/Entity/Udf.php',
                'Clarity\EntityRepository\ClarityRepository'           => '/EntityRepository/ClarityRepository.php',
                'Clarity\EntityRepository\ContainerClarityRepository'  => '/EntityRepository/ContainerClarityRepository.php',
                'Clarity\EntityRepository\SampleClarityRepository'     => '/EntityRepository/SampleClarityRepository.php',
                'Clarity\EntityRepository\ProjectClarityRepository'    => '/EntityRepository/ProjectClarityRepository.php',
                'Clarity\EntityRepository\ResearcherClarityRepository' => '/EntityRepository/ResearcherClarityRepository.php',
                'Clarity\EntityRepository\LabClarityRepository'        => '/EntityRepository/LabClarityRepository.php',
                'Clarity\EntityRepository\UdfClarityRepository'        => '/EntityRepository/UdfClarityRepository.php',
                'Clarity\EntityFormatter\ProjectFormatter'             => '/EntityFormatter/ProjectFormatter.php',
                'Clarity\EntityFormatter\SampleFormatter'              => '/EntityFormatter/SampleFormatter.php',
                ];
        }
        if (isset($classes[$class])) {
            require_once __DIR__ . $classes[$class];
        }
    }, 
    true, 
    false
);
