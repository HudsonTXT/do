<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class payController extends Controller
{


    public function index($page)
    {

        $payment = new \Idma\Robokassa\Payment(
            'danceonline', 'SyXtbRxxsp107Ms5kx2M', 'b00wpwIrL0Elmf2y5WNu', true
        );

        if (empty($page)) {
            $payment
                ->setInvoiceId(1)//id
                ->setSum(100)//amoint
                ->setDescription('Покупка рубинов');

            // redirect to payment url
            return response()->redirectTo($payment->getPaymentUrl());
        } elseif ($page == 'success') {
            if ($payment->validateSuccess($_POST)) {
                $order = 1;

                if ($payment->getSum() == 100) {
                    return 'Оплата прошла успешно!';
                }

            }
        } elseif ($page == 'check') {
            if ($payment->validateResult($_POST)) {
                $order = $payment->getInvoiceId();

                if ($payment->getSum() == 100) {

                }

                // send answer
                return $payment->getSuccessAnswer(); // "OK1254487\n"
            }
        }

    }


}
