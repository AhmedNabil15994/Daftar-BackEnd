<?php

namespace Modules\Vendor\Repositories\Vendor;

use Illuminate\Support\Facades\DB;
use Modules\Vendor\Entities\Payment;

class PaymentRepository
{
    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function getAll($order = 'id', $sort = 'desc')
    {
        $payments = $this->payment->orderBy($order, $sort)->get();
        return $payments;
    }

    public function findById($id)
    {
        $payment = $this->payment->find($id);
        return $payment;
    }

}
