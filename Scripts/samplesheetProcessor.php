<?php

namespace Clarity\Scripts;

require_once(__DIR__ . '/../autoload.php');

use Clarity\Entity\Sample;
use Clarity\EntityFormatter\SampleFormatter;

///////////////
// FUNCTIONS //
///////////////

function checkIndexTypes(array &$samples, &$sample_types, &$split)
{
    $lanes_a = [];
    foreach ($samples as $sample) {
        $lane = $sample->getSamplesheetLane();
        $type = $sample->getIndexType();
        $lanes_a[$lane][] = $type;
        if ($type == 'tenx') {
            $split = true;
        }
        $sample_types[$type] = true;
    }
    foreach ($lanes_a as $lane => $types) {
        $types = array_unique($types);
        if (count($types) > 1) {
            $split = true;
        }
    }
}

function createSampleFromLine(array &$header, array &$line_a)
{
    $sample = new Sample();
    $i = 0;
    foreach ($header as $column) {
        if ($column == 'Sample_ID' || $column == 'SampleID') {
            $sample->setSamplesheetId($line_a[$i]);
        } elseif ($column == 'Sample_Name') {
            $sample->setSamplesheetName($line_a[$i]);
        } elseif ($column == 'index') {
            $sample->setSamplesheetIndex1($line_a[$i]);
        } elseif ($column == 'index2') {
            $sample->setSamplesheetIndex2($line_a[$i]);
        } elseif ($column == 'Sample_Project' || $column == 'SampleProject') {
            $sample->setSamplesheetProject($line_a[$i]);
        } elseif ($column == 'Lane') {
            $sample->setSamplesheetLane($line_a[$i]);
        } else {
            $sample->setSamplesheetExtra($column, $line_a[$i]);
        }
        ++$i;
    }
    return $sample;
}

function parseSamplesheet(&$inputFile, array &$header, array &$data, array &$samples)
{
    $inputSheet = fopen($inputFile, 'r') or die('Unable to open file ' . $inputFile . PHP_EOL);
    if ($inputSheet) {
        while (!feof($inputSheet)) {
            $line_a = fgetcsv($inputSheet);
            if (!empty($line_a)) {
                if (preg_match('#^\[([[:alpha:]]+)\]#', $line_a[0], $matches)) {
                    $section = $matches[1];
                    $data[$section][] = $line_a;
                    continue;
                }
                if (isset($section)) {
                    if ($section == 'Data') {
                        if (empty($header)) {
                            $header = $line_a;
                        } else {
                            $samples[] = createSampleFromLine($header, $line_a);
                        }
                    } else {
                        $data[$section][] = $line_a;
                    }
                }
            }
        }
    }
    fclose($inputSheet);
}

function separateSamples(&$samples, &$sample_types, &$default_samples, &$tenx_samples, &$dual_samples, &$long_samples, &$short_samples, &$split)
{
    if ($split) {
        $positions = [];
        if ($sample_types['tenx']) {
            foreach ($samples as $pos => $sample) {
                if ($sample->getIndexType() == 'tenx') {
                    $tenx_samples[] = $sample;
                    $positions[] = $pos;
                }
            }
            foreach ($positions as $position) {
                unset($samples[$position]);
            }
            $positions = [];
        }
        if ($sample_types['dual']) {
            foreach ($samples as $pos => $sample) {
                if ($sample->getIndexType() == 'dual') {
                    $dual_samples[] = $sample;
                    $positions[] = $pos;
                }
            }
            foreach ($positions as $position) {
                unset($samples[$position]);
            }
            $positions = [];
        }
        if ($sample_types['short']) {
            foreach ($samples as $pos => $sample) {
                if ($sample->getIndexType() == 'short') {
                    $short_samples[] = $sample;
                    $positions[] = $pos;
                }
            }
            foreach ($positions as $position) {
                unset($samples[$position]);
            }
            $positions = [];
        }
        if ($sample_types['long']) {
            foreach ($samples as $pos => $sample) {
                if ($sample->getIndexType() == 'long') {
                    $long_samples[] = $sample;
                    $positions[] = $pos;
                }
            }
            foreach ($positions as $position) {
                unset($samples[$position]);
            }
            $positions = [];
        }
    }
    foreach ($samples as $pos => $sample) {
        $default_samples[] = $sample;
    }
}

function writeSamplesheets(&$data, &$header, &$default_samples, &$tenx_samples, &$dual_samples, &$long_samples, &$short_samples)
{
    $formatter = new SampleFormatter();
    if (count($tenx_samples) > 0) {
        $outputFile = 'SampleSheet_tenx.csv';
        $output = '';
        foreach ($data as $section => $lines) {
            foreach ($lines as $line_a) {
                $output .= implode(',', $line_a) . PHP_EOL;
            }
        }
        $output .= $formatter->formatSamples($tenx_samples, 'mkfastq', $header);
        $outputSheet = fopen($outputFile, 'w');
        fwrite($outputSheet, $output);
        fclose($outputSheet);
        touch('configured_tenx');
    }
    if (count($dual_samples) > 0) {
        $outputFile = 'SampleSheet_dual.csv';
        $output = '';
        foreach ($data as $section => $lines) {
            foreach ($lines as $line_a) {
                $output .= implode(',', $line_a) . PHP_EOL;
            }
        }
        $output .= $formatter->formatSamples($dual_samples, 'bcl2fastq', $header);
        $outputSheet = fopen($outputFile, 'w');
        fwrite($outputSheet, $output);
        fclose($outputSheet);
        touch('configured_dual');
    }
    if (count($long_samples) > 0) {
        $outputFile = 'SampleSheet_long.csv';
        $output = '';
        foreach ($data as $section => $lines) {
            foreach ($lines as $line_a) {
                $output .= implode(',', $line_a) . PHP_EOL;
            }
        }
        $output .= $formatter->formatSamples($long_samples, 'bcl2fastq', $header);
        $outputSheet = fopen($outputFile, 'w');
        fwrite($outputSheet, $output);
        fclose($outputSheet);
        touch('configured_long');
    }
    if (count($short_samples) > 0) {
        $outputFile = 'SampleSheet_short.csv';
        $output = '';
        foreach ($data as $section => $lines) {
            foreach ($lines as $line_a) {
                $output .= implode(',', $line_a) . PHP_EOL;
            }
        }
        $output .= $formatter->formatSamples($short_samples, 'bcl2fastq', $header);
        $outputSheet = fopen($outputFile, 'w');
        fwrite($outputSheet, $output);
        fclose($outputSheet);
        touch('configured_short');
    }
    if (count($default_samples) > 0) {
        $outputFile = 'SampleSheet.csv';
        $output = '';
        foreach ($data as $section => $lines) {
            foreach ($lines as $line_a) {
                $output .= implode(',', $line_a) . PHP_EOL;
            }
        }
        $output .= $formatter->formatSamples($default_samples, 'bcl2fastq', $header);
        $outputSheet = fopen($outputFile, 'w');
        fwrite($outputSheet, $output);
        fclose($outputSheet);
        touch('configured_default');
    } else {
        if (file_exists('configured_default')) {
            unlink('configured_default');
        }
    }
}

//////////
// MAIN //
//////////

$inputFile = 'SampleSheet.csv';
$header = [];
$data = [];
$samples = [];
$split = false;
$sample_types = array(
    'short' => false,
    'long' => false,
    'dual' => false,
    'tenx' => false
);
$default_samples = [];
$short_samples = [];
$long_samples = [];
$dual_samples = [];
$tenx_samples = [];

parseSamplesheet($inputFile, $header, $data, $samples);
checkIndexTypes($samples, $sample_types, $split);
//echo "Samples: " . count($samples) . PHP_EOL;
separateSamples($samples, $sample_types, $default_samples, $tenx_samples, $dual_samples, $long_samples, $short_samples, $split);
//echo "default: " . count($default_samples) . PHP_EOL;
//echo "tenx: " . count($tenx_samples) . PHP_EOL;
//echo "dual: " . count($dual_samples) . PHP_EOL;
//echo "long: " . count($long_samples) . PHP_EOL;
//echo "short: " . count($short_samples) . PHP_EOL;
writeSamplesheets($data, $header, $default_samples, $tenx_samples, $dual_samples, $long_samples, $short_samples);
