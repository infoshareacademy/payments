<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 09.10.15
 * Time: 15:39
 */

namespace piedPiperPaymentModel;


class invoice extends document {
    protected $paymentDate;
    protected $maturityDate;
    protected $item;
    protected $status = document::STATUS_ISSUE;

    public function pay() {
        $this->paymentDate = date('Y-m-d');
        $this->status = document::STATUS_PAID;
    }

    public function __set($paramName, $paramValue) {
        $this->$paramName = $paramValue;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }


}