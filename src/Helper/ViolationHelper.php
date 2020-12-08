<?php


namespace App\Helper;


use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationHelper
{
    static public function build(ConstraintViolationListInterface $list){
        $error = [];

        /**
         * @var ConstraintViolationInterface $violation
         */
        foreach ($list as $violation ){
            $error [$violation->getPropertyPath()][]= $violation->getMessage();
        }
        return json_encode($error);
    }
}