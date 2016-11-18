<?php

namespace Application\Validate;

/**
 * Class User
 * @package Application\Validate
 */
class User extends \Zend\Validator\AbstractValidator
{

    /**
     * @param mixed $request
     * @return bool
     */
    public function isValid($request)
    {
        return true;
    }

}