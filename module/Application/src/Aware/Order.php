<?php

namespace Application\Aware;

use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;

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
                'type' => 'text',
                'required' => false,
                'validation_group' => [
                    new StringLength(
                        [
                            'min' => 3,
                            'max' => 100
                        ]
                    )
                ],
            ]
        );

        $this->add(
            [
                'name' => 'dish',
                'type' => 'text',
                'required' => true,
                'validation_group' => [
                    new StringLength(
                        [
                            'min' => 3,
                            'max' => 100
                        ]
                    )
                ],
            ]
        );

        $this->add(
            [
                'name' => 'minutes',
                'type' => 'text',
                'required' => false,
                'validation_group' => [
                    new InArray(
                        [
                            'haystack' => [
                                \Application\Entity\Order::STATUS_CLOSED,
                                \Application\Entity\Order::STATUS_DONE,
                                \Application\Entity\Order::STATUS_WAIT,
                                \Application\Entity\Order::STATUS_NEW,
                            ]
                        ]
                    )
                ],
            ]
        );

        $this->setAttribute('method', Request::METHOD_POST);
    }

}