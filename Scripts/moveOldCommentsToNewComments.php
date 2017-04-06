<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Connector\ClarityApiConnector;
use Clarity\EntityRepository\SampleClarityRepository;
use Clarity\Entity\Sample;

$connector = new ClarityApiConnector('test');
$sampleRepo = new SampleClarityRepository($connector);

$samples = $sampleRepo->findAll();
foreach ($samples as $sample) {
    $modified = FALSE;
    if (!empty($sample->getClarityUDF('User Comments old')['value'])) {
        $modified = TRUE;
        $oldUserComments = $sample->getClarityUDF('User Comments old')['value'];
        echo $sample->getClarityId() . ' -> User Comments old: ' . $oldUserComments . PHP_EOL;
        $sample->setClarityUDFs(array(
            'User Comments old' => array('name' => 'User Comments old', 'value' => ''),
            'User Comments' => array('name' => 'User Comments', 'value' => $oldUserComments)
        ));
    }
    if (!empty($sample->getClarityUDF('ASF Comments old')['value'])) {
        $modified = TRUE;
        $oldAsfComments = $sample->getClarityUDF('ASF Comments old')['value'];
        echo $sample->getClarityId() . ' -> ASF Comments old: ' . $oldAsfComments . PHP_EOL;
        $sample->setClarityUDFs(array(
            'ASF Comments old' => array('name' => 'ASF Comments old', 'value' => ''),
            'ASF Comments' => array('name' => 'ASF Comments', 'value' => $oldAsfComments)
        ));
    }
    if ($modified) {
        $sample->sampleToXml();
        echo 'Saving ' . $sample->getClarityId() . PHP_EOL;
        $sample = $sampleRepo->save($sample);
        echo 'User Comments: ' . $sample->getClarityUDF('User Comments')['value'] . PHP_EOL;
        echo 'ASF Comments: ' . $sample->getClarityUDF('ASF Comments')['value'] . PHP_EOL;
        echo PHP_EOL;
    }
}
