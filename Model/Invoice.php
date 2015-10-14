<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 09.10.15
 * Time: 15:39
 */


require_once 'Document.php';

class Invoice extends Document {
    protected $paymentDate;
    protected $maturityDate;
    protected $item;
    protected $status = Document::STATUS_ISSUE;

    public function pay() {
        $this->paymentDate = date('Y-m-d');
        $this->status = Document::STATUS_PAID;
    }

    public function __set($paramName, $paramValue) {
        $this->$paramName = $paramValue;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }
    public function serializeToHTML() {
        $HTMLFromParent = parent::serializeToHTML();
        $HTMLFromThis = "<td>". $this->maturityDate ."</td>" .
        "<td>". $this->paymentDate ."</td>";
        return $HTMLFromParent . $HTMLFromThis;
    }


}