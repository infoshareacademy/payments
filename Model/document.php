<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 09.10.15
 * Time: 15:38
 */

namespace piedPiperPaymentModel;


class document
{

    protected $number;
    protected $issueDate;
    protected $amount;
    protected $sender;
    /**
     * @var $receiver string jest to parametr ktory definiuje odbiorce
     */
    protected $receiver;

    const STATUS_ISSUE = 1;
    const STATUS_PAID = 2;


    public static $numberOfDocuments = 0;

    public function __set($paramName, $paramValue) {
        $this->$paramName = $paramValue;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }

    public function __contruct() {
        self::$numberOfDocuments++;
    }

}

