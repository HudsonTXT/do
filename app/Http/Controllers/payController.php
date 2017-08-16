<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class payController extends Controller
{


    public function index($page = null, Request $request)
    {
        $data = $request->all();
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
            if ($payment->validateSuccess($data)) {
                $order = $payment->getInvoiceId();

                if ($payment->getSum() == 100) {
                    return 'Оплата прошла успешно!';
                }

            }
        } elseif ($page == 'info') {
            if ($payment->validateResult($data)) {
                $order = $payment->getInvoiceId();

                if ($payment->getSum() == 100) {
                    DB::table('do_user')->where('id','=',2)->increment('coins',100);
                }

                // send answer
                return $payment->getSuccessAnswer(); // "OK1254487\n"
            }
        }

    }


}
