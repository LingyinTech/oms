<?php


namespace backend\models\vo;


use backend\base\Model;

class OrderForm extends Model
{

    public $id;
    public $shop_id;
    public $customer_name;
    public $pay_method;
    public $order_type;

    public $real_name;

    public $barCode = '';

    public $skuList = [];

}