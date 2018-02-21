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
    if (!empty($sample->getClarityUDF('User Comments old'))) {
        $modified = TRUE;
        $oldUserComments = $sample->getClarityUDF('User Comments old');
        echo $sample->getClarityId() . ' -> User Comments old: ' . $oldUserComments . PHP_EOL;
        $sample->setClarityUDF('User Comments old', '');
        $sample->setClarityUDF('User Comments', $oldUserComments);
    }
    if (!empty($sample->getClarityUDF('ASF Comments old'))) {
        $modified = TRUE;
        $oldAsfComments = $sample->getClarityUDF('ASF Comments old');
        echo $sample->getClarityId() . ' -> ASF Comments old: ' . $oldAsfComments . PHP_EOL;
        $sample->setClarityUDF('ASF Comments old', '');
        $sample->setClarityUDF('ASF Comments', $oldAsfComments);
    }
    if ($modified) {
        $sample->sampleToXml();
        echo 'Saving ' . $sample->getClarityId() . PHP_EOL;
        $sample = $sampleRepo->save($sample);
        echo 'User Comments: ' . $sample->getClarityUDF('User Comments') . PHP_EOL;
        echo 'ASF Comments: ' . $sample->getClarityUDF('ASF Comments') . PHP_EOL;
        echo PHP_EOL;
    }
}
