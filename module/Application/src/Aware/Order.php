<?php

namespace Application\Aware;

use Zend\Form\Form;
use Zend\Http\Request;

/**
 * Class Register
 * @package Application\Aware
 */
class Order extends Form
{

    /**
     * Register constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name, $options);

        $this->add(
            [
                'name' => 'name',
                'type' => 'text'
            ]
        );

        $this->add(
            [
                'name' => 'dish',
                'type' => 'text'
            ]
        );


        $this->setAttribute('method', Request::METHOD_POST);
    }

}