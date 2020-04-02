<?php

namespace app\models;

use app\models\User;
use app\models\Orders;
use yii\base\InvalidArgumentException;
use yii\base\Model;

class VerifyOrderForm extends Model
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var User
     */
    private $_user;
    private $_order;


    /**
     * Creates a form model with given token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token, $order_id, array $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('รหัส Token ต้องไม่เป็นค่าว่าง.');
        }
        if (empty($order_id)) {
            throw new InvalidArgumentException('ใบสั่งซื้อต้องไม่เป็นค่าว่าง.');
        }
        $this->_order = Orders::findOne([
            'id' => $order_id,
            'status' => 8
        ]);
        $this->_user = User::findByVerificationOrder($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Token ไม่ถูกต้อง.');
        }
        parent::__construct($config);
    }

    /**
     * Verify email
     *
     * @return User|null the saved model or null if saving fails
     */
    public function verifyEmail()
    {
        $order = $this->_order;
        $order->status = 9;
        return $order->save(false) ? $order : null;
    }
}
