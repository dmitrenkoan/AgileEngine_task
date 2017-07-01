<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\Voucher;
use App\OrderVoucher;
use Validator;

class OrderController extends Controller
{
    // route function
    public function add(Request $request)
    {
        if($this->addOrder($request->product_id)) {
            $result = true;
        }
        else {
            $result = false;
        }

        return view('layouts.orderAdd', [
            'result' => $result
        ]);
    }


    // add order to database table
    static public function addOrder($product_id)
    {
        $product = Product::find($product_id);
        if(!empty($product->id)) {
            $arVoucherID = array();
            $order = new Order();
            $order->products_id = $product->id;
            $arDiscountPriceInfo = ProductController::calcProductDiscountPrice($product);
            $order->order_sum = $arDiscountPriceInfo['discount_price'];
            if($order->save()) {

                if(!empty($arDiscountPriceInfo['ob_vouchers'])) {
                    foreach($arDiscountPriceInfo['ob_vouchers'] as $voucher) {
                        $arVoucherID[] = $voucher->id;
                        self::orderVoucherAdd($order, $voucher);
                    }
                }
                Voucher::destroy($arVoucherID);
                Product::destroy($product->id);
            }
            return true;
        }
        else {
            return false;
        }
    }

    // add voucher to OrderVaucher table
    static function orderVoucherAdd($order, $voucher)
    {
        $orderVoucher = new OrderVoucher();
        $orderVoucher->orders_id = $order->id;
        $orderVoucher->vouchers_id = $voucher->id;
        return $orderVoucher->save();
    }

    // add order by api request
    static public function apiOrderAdd(Request $request) {
        if(self::orderAddValidate($request)) {
            if(self::addOrder($request->products_id)) {
                return [
                    'text' => 'order successfully created',
                    'status' => 201
                ];
            }

        }
        else {
            return [
                'text' => 'Failed to create order',
                'status' => 400
            ];
        }



    }

    static public function orderAddValidate(Request $request)
    {
        $v = Validator::make($request->all(), [
            'products_id' => 'required|integer',
        ]);
        if($v->fails()) {
            return false;
        }
        else {
            return true;
        }
    }

}
