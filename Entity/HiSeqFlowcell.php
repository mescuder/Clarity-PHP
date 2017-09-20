<?php

namespace Clarity\Entity;

use Clarity\Entity\Container;

/**
 * Description of HiSeqFlowcell
 *
 * @author escudem
 */
class HiSeqFlowcell extends Container
{
    
    public function __construct()
    {
        parent::__construct();
        $this->typeName = 'Illumina HiSeq Flow Cell';
        $this->typeId = '17';
    }
    
}
