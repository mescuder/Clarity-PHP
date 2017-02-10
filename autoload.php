<?php

spl_autoload_register(
        function($class) {
            static $classes = null;
            if ($classes === null) {
                $classes = array(
                'Clarity\Connector\ClarityApiConnector'               => '/Connector/ClarityApiConnector.php',
                'Clarity\Entity\Run'                                  => '/Entity/Run.php',
                'Clarity\Entity\Container'                            => '/Entity/Container.php',
                'Clarity\Entity\Tube'                                 => '/Entity/Tube.php',
                'Clarity\Entity\Sample'                               => '/Entity/Sample.php',
                'Clarity\EntityRepository\ContainerClarityRepository' => '/EntityRepository/ContainerClarityRepository.php',
                'Clarity\EntityRepository\SampleClarityRepository'    => '/EntityRepository/SampleClarityRepository.php',
            );
        }
        if (isset($classes[$class])) {
            require_once __DIR__ . $classes[$class];
        }
    }, 
    true, 
    false
);
