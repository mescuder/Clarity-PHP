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
    
    public function asBcl2fastq(Sample &$sample)
    {
        $index1 = $sample->getSamplesheetIndex1();
        $index2 = $sample->getSamplesheetIndex2();
        // regex to see if index1 is [ATGC]+ and if yes compute rev_comp (if no it's tenx)
        $output_a = [];
        $output_a[] = $sample->getSamplesheetLane();
        $output_a[] = $sample->getSamplesheetProject();
        $output_a[] = $sample->getSamplesheetId();
        $output_a[] = $index1;
        if (preg_match('#^[ATGC]+$#', $index1)) {
            $index1_rc = $sample->revComp($index1);
            $output_a[] = $index1;
            $output_a[] = $index1_rc;
        }
        $output_a[] = $index2;
        if (preg_match('#^[ATGC]+$#', $index2)) {
            $index2_rc = $sample->revComp($index2);
            $output_a[] = $index2;
            $output_a[] = $index2_rc;
        }
        return implode(',', $output_a);
    }

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

        foreach ($sample->getClarityUDFs() as $udfName => $properties) {
            $yamlArray[$sampleId]['UDFs'][$udfName] = $properties['value'];
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
            case 'bcl2fastq':
                $output = 'Lane,Sample_Project,Sample_ID,index,index_original,index_rc,index2,index2_original,index2_rc' . PHP_EOL;
                foreach ($samples as $sample) {
                    $output .= $this->asBcl2fastq($sample) . PHP_EOL;
                }
                return $output;
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
        foreach ($tempSample->getClarityUDFs() as $udfName => $properties) {
            $tsvArray[$i][] = $udfName;
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
            foreach ($sample->getClarityUDFs() as $udfName => $properties) {
                $tsvArray[$i][] = $properties['value'];
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

            foreach ($sample->getClarityUDFs() as $udfName => $properties) {
                $yamlArray[$sampleId]['UDFs'][$udfName] = $properties['value'];
            }
        }
        return $yamlArray;
    }

}
