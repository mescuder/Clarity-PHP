<?php

namespace Clarity\Entity;

/**
 * Description of Run
 *
 * @author escudem
 */
class Run
{

    /**
     *
     * @var Container
     */
    protected $container;

    /**
     *
     * @var string
     */
    protected $containerId;

    /**
     *
     * @var string
     */
    protected $containerUri;

    /**
     *
     * @var string
     */
    protected $flowcellId;

    /**
     *
     * @var string
     */
    protected $runName;

    /**
     *
     * @var string
     */
    protected $runNumber;

    /**
     *
     * @var string
     */
    protected $sequencer;

    /**
     *
     * @var array
     */
    protected $sequencers;

    /**
     *
     * @var string
     */
    protected $startDate;

    public function __construct() {
        $this->sequencers = yaml_parse_file(__DIR__ . '/../Config/sequencers.yml');
    }

    public function setRunInfoFromRunName() {
        $runInfo = $this->getRunInfoFromRunName();
        $this->flowcellId = $runInfo['flowcellId'];
        $this->startDate = $runInfo['startDate'];
        $this->sequencer = $runInfo['sequencer'];
        $this->runNumber = $runInfo['runNumber'];
    }

    public function getRunInfoFromRunName($runName = null) {
        $runInfo = array(
            'startDate' => '',
            'sequencer' => '',
            'runNumber' => '',
            'flowcellId' => '',
        );
        if (empty($runName)) {
            $runName = $this->runName;
        }
        if (preg_match('#^\d{6}_\w+_\d{4}_#', $runName)) {
            $runBits = explode('_', $runName);
            $date = \DateTime::createFromFormat('ymd', $runBits[0]);
            $runInfo['startDate'] = $date->format('Y-m-d');
            $runInfo['sequencer'] = $runBits[1];
            $runInfo['runNumber'] = $runBits[2];
            $sideFlowcell = $runBits[3];
            if (preg_match('#^[AB]#', $sideFlowcell)) {
                $runInfo['flowcellId'] = substr($sideFlowcell, 1);
            } elseif (preg_match('#^0+-#', $sideFlowcell)) {
                $runInfo['flowcellId'] = (explode('-', $sideFlowcell)[1]);
            }
        } else {
            $runInfo['flowcellId'] = $runName;
        }
        return $runInfo;
    }

    public function getSequencerInfo() {
        return $this->sequencers[$this->sequencer];
    }

    public function setFlowcellId($flowcellId) {
        $this->flowcellId = strtoupper($flowcellId);
    }

    public function getFlowcellid() {
        return $this->flowcellId;
    }

    public function setRunName($runName) {
        $this->runName = strtoupper($runName);
    }

    public function getRunName() {
        return $this->runName;
    }

    public function setSequencer($sequencer) {
        $this->sequencer = $sequencer;
    }

    public function getSequencer() {
        return $this->sequencer;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getStartDate() {
        return $this->startDate;
    }

}
