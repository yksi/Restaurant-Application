<?php

namespace Application\Aware;

use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Validator\EmailAddress;
use Zend\Validator\InArray;
use Zend\Validator\StringLength;

/**
 * Class Register
 * @package Application\Aware
 */
class Register extends Form
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
                'name' => 'email',
                'type' => 'text',
                'required' => true,
                'validators' => [
                    new EmailAddress()
                ]

            ]
        );

        $this->add(
            [
                'name' => 'name',
                'type' => 'text',
                'required' => true,
                'validators' => [
                    new StringLength(
                        [
                            'min' => 6,
                            'max' => 100
                        ]
                    )
                ],
            ]
        );

        $this->add(
            [
                'name' => 'password',
                'type' => 'password',
                'required' => true,
                'validators' => [
                    new StringLength(
                        [
                            'min' => 6,
                            'max' => 100
                        ]
                    )
                ],
            ]
        );

        $this->add(
            [
                'name' => 'role',
                'type' => 'text',
                'required' => true,
                'validators' => [
                    new InArray(
                        [
                            'haystack' => [
                                'cook',
                                'waiter'
                            ]
                        ]
                    )
                ]
            ]
        );

        $this->setAttribute('method', Request::METHOD_POST);
    }

}