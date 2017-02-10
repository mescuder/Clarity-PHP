<?php

namespace Clarity\Entity;

use Clarity\Entity\Container;

/**
 * Description of Tube
 *
 * @author Mickael Escudero
 */
class Tube extends Container
{

    public function __construct()
    {
        parent::__construct();
        $this->clarityTypeName = 'Tube';
        $this->clarityTypeEndpoint = 'containertypes/2';
    }

}
