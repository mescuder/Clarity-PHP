<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Entity\Sample;

///////////////
// FUNCTIONS //
///////////////

function createSampleFromLine(array &$header, array &$line_a) {
    $sample = new Sample();
    $i = 0;
    foreach ($header as $column) {
        if ($column == 'Sample_ID' || $column == 'SampleID') {
            
        }
    }
    exit();
}

//////////
// MAIN //
//////////

$inputFile = 'SampleSheet.csv';
$data = array();
$samples = array();
$section = null;
$data_header = array();

$inputSheet = fopen($inputFile, 'r') or die('Unable to open file ' . $inputFile . PHP_EOL);
if ($inputSheet) {
    while (!feof($inputSheet)) {
        $line_a = fgetcsv($inputSheet);
        if (!empty($line_a)) {
            if (!is_null($section) && $section != 'Settings') {
                if ($section == 'Data') {
                    if (empty($data_header)) {
                        $data_header = $line_a;
                    } else {
                        $samples[] = createSampleFromLine($data_header, $line_a);
                    }
                } else {
                    //var_dump($line_a);
                    $data[$section][] = $line_a;
                }
            }
            if (preg_match('#^\[([[:alpha:]]+)\]#', $line_a[0], $matches)) {
                $section = $matches[1];
            }
        }
    }
}
fclose($inputSheet);

$outputSheet = '';
