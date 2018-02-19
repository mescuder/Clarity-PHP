<?php

namespace Clarity\Tests;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\UdfClarityRepository;
use Clarity\Entity\Udf;


$connector = new ClarityApiConnector('prod');
$udfRepo = new UdfClarityRepository($connector);

/*
$udfs = $udfRepo->findAllForSamples();
foreach ($udfs as $udf) {
    echo $udf->getXml() . PHP_EOL;
}
 * 
 */
$udf = $udfRepo->find('1256');
$udf->udfToXml();
var_dump($udf);
