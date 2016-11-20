<?php

namespace Application\Aware;

use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;

/**
 * Class Register
 * @package Application\Aware
 */
class Login extends Form
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
                'name' => 'password',
                'type' => 'password',
                'required' => true,
                'validation_group' => [
                    new StringLength(
                        [
                            'min' => 6,
                            'max' => 100
                        ]
                    )
                ],
            ]
        );

        $this->setAttribute('method', Request::METHOD_POST);
    }

}