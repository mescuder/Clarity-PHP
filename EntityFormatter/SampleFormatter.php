<?php

namespace Clarity\EntityFormatter;

use Clarity\Entity\Sample;

/**
 * Description of SampleFormatter
 *
 * @author escudem
 */
class SampleFormatter
{

    public function asYAML(Sample &$sample)
    {
        $yamlArray = array();
        $sampleId = $sample->getClarityId();
        $yamlArray[$sampleId]['Sample ID'] = $sampleId;
        $yamlArray[$sampleId]['Sample Name'] = $sample->getClarityName();
        $yamlArray[$sampleId]['Project Name'] = $sample->getProject()->getClarityName();
        $yamlArray[$sampleId]['Researcher'] = $sample->getProject()->getResearcher()->getFullName();
        $yamlArray[$sampleId]['Lab'] = $sample->getProject()->getResearcher()->getLab()->getClarityName();
        $yamlArray[$sampleId]['Date received'] = $sample->getDateReceived();
        $yamlArray[$sampleId]['Date completed'] = $sample->getDateCompleted();
        $yamlArray[$sampleId]['Submitter'] = $sample->getSubmitterFirst() . ' ' . $sample->getSubmitterLast();

        foreach ($sample->getClarityUDFs() as $udf => $value) {
            $yamlArray[$sampleId]['UDFs'][$udf] = $value;
        }

        return yaml_emit($yamlArray);
    }

    public function formatSample(Sample &$sample, &$format)
    {
        switch ($format) {
            case 'yaml':
                return $this->asYAML($sample);
            default:
                return 'The specified format "' . $format . '" is not available' . PHP_EOL;
        }
    }

    public function formatSamples(array &$samples, $format)
    {
        switch ($format) {
            case 'tsv':
                $tsvArray = array();
                $this->prepareTsvArray($tsvArray, $samples);
                $tsvOutput = '';
                foreach ($tsvArray as $line) {
                    $tsvOutput .= implode("\t", $line) . PHP_EOL;
                }
                return $tsvOutput;
            case 'yaml':
                $yamlArray = array();
                $this->prepareYamlArray($yamlArray, $samples);
                return yaml_emit($yamlArray);
            default:
                return 'The specified format "' . $format . '" is not available' . PHP_EOL;
        }
    }
    
    public function prepareTsvArray(array &$tsvArray, &$samples)
    {
        $i = 0;
        $tsvArray[$i] = array('Sample ID', 'Sample Name', 'Project Name', 'Researcher', 'Lab', 'Date received', 'Date completed', 'Submitter');
        $tempSample = $samples[0];
        foreach ($tempSample->getClarityUDFs() as $udf => $value) {
            $tsvArray[$i][] = $udf;
        }
        foreach ($samples as $sample) {
            ++$i;
            $sampleId = $sample->getClarityId();
            $tsvArray[$i] = array($sampleId);
            $tsvArray[$i][] = $sample->getClarityName();
            $tsvArray[$i][] = $sample->getProject()->getClarityName();
            $tsvArray[$i][] = $sample->getProject()->getResearcher()->getFullName();
            $tsvArray[$i][] = $sample->getProject()->getResearcher()->getLab()->getClarityName();
            $tsvArray[$i][] = $sample->getDateReceived();
            $tsvArray[$i][] = $sample->getDateCompleted();
            $tsvArray[$i][] = $sample->getSubmitterFirst() . ' ' . $sample->getSubmitterLast();
            foreach ($sample->getClarityUDFs() as $udf => $value) {
                $tsvArray[$i][] = $value;
            }
        }
    }

    public function prepareYamlArray(array &$yamlArray, &$samples)
    {
        foreach ($samples as $sample) {
            $sampleId = $sample->getClarityId();
            $yamlArray[$sampleId]['Sample ID'] = $sampleId;
            $yamlArray[$sampleId]['Sample Name'] = $sample->getClarityName();
            $yamlArray[$sampleId]['Project Name'] = $sample->getProject()->getClarityName();
            $yamlArray[$sampleId]['Researcher'] = $sample->getProject()->getResearcher()->getFullName();
            $yamlArray[$sampleId]['Lab'] = $sample->getProject()->getResearcher()->getLab()->getClarityName();
            $yamlArray[$sampleId]['Date received'] = $sample->getDateReceived();
            $yamlArray[$sampleId]['Date completed'] = $sample->getDateCompleted();
            $yamlArray[$sampleId]['Submitter'] = $sample->getSubmitterFirst() . ' ' . $sample->getSubmitterLast();

            foreach ($sample->getClarityUDFs() as $udf => $value) {
                $yamlArray[$sampleId]['UDFs'][$udf] = $value;
            }
        }
        return $yamlArray;
    }

}
