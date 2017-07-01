<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Voucher;
use App\VoucherProduct;
use Validator;

class VoucherController extends Controller
{
    // selecting all active vouchers, its discount tiers of the certain product
    static public function getVoucherList($product_id)
    {
        $curDate = date('Y-m-d');
        // get all vouchers which are active today and are bound with a current product. Also get a voucher discount percentage.
        $obPercentList = DB::table('voucher_products')
            ->join('vouchers', 'voucher_products.vouchers_id', '=', 'vouchers.id')
            ->join('discount_tiers', 'vouchers.discount_tiers_id', '=', 'discount_tiers.id')
            ->where('voucher_products.products_id' , '=', $product_id)
            ->where('vouchers.start_date', '<=', $curDate)
            ->where('vouchers.end_date', '>=', $curDate)
            ->where('vouchers.deleted_at', '=', NULL)
            ->select('discount_tiers.percent', 'vouchers.id')
            ->get();

        return $obPercentList;
    }

    // api create a new voucher
    static public function add(Request $request) {


            //validate the sent data
            if (self::dataAddValidate($request)) {

                $voucher = new Voucher();


                $voucher->IDs = $request->IDs;
                $voucher->start_date = $request->start_date;
                $voucher->end_date = $request->end_date;
                $voucher->discount_tiers_id = $request->discount_tiers_id;
                $voucher->deleted_at = NULL;

                $voucher->save();
                return [
                    'text' => 'voucher successfully created',
                    'status' => 201
                ];
            }
            else {
                return [
                    'text' => 'Failed to create voucher',
                    'status' => 400
                ];
            }

    }


    static public function dataAddValidate(Request $request)
    {
        $v = Validator::make($request->all(), [
            'IDs' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'discount_tiers_id' => 'required|integer',
        ]);
        if($v->fails()) {
            return false;
        }
        else {
            return true;
        }
    }

    static public function addVoucherProductBind(Request $request) {


            //validate the sent data
            if (self::dataAddBindValidate($request)) {



                // check if the current bind has been already exist
                if(self::checkExistBind($request->products_id, $request->vouchers_id)) {
                    return [
                        'text' => "this bind has been already exist",
                        'status' => 400
                    ];
                }
                else {
                    // create a Voucher product bind
                    $voucherProduct = new VoucherProduct();

                    $voucherProduct->products_id = $request->products_id;
                    $voucherProduct->vouchers_id = $request->vouchers_id;

                    $voucherProduct->save();
                    return [
                        'text' => 'voucher successfully bound',
                        'status' => 201
                    ];
                }


            }
            else {
                return [
                    'text' => 'Failed to create voucher',
                    'status' => 400
                ];
            }



    }

    static public function dataAddBindValidate($request) {
        $v = Validator::make($request->all(), [
            'products_id' => 'required|integer',
            'vouchers_id' => 'required|integer',
        ]);
        if($v->fails()) {
            return false;
        }
        else {
            return true;
        }
    }

    static public function checkExistBind($product_id, $voucher_id) {
        $voucherProduct = new VoucherProduct();
        $voucherBind = $voucherProduct->where('products_id', $product_id)->where('vouchers_id', $voucher_id)->first();
        if(!empty($voucherBind->id)) {
            return true;
        }
        else {
            return false;
        }
    }

    static public function removeVoucherProductBind(Request $request) {


            //validate the sent data
            if (self::dataAddBindValidate($request)) {



                // delete voucher product bind
                if(self::removeBind($request->products_id, $request->vouchers_id)) {

                    return [
                        'text' => 'voucher bind to the product was successfully deleted',
                        'status' => 202
                    ];
                }
                else {
                    return [
                        'text' => 'There is no such a voucher-product bind',
                        'status' => 400
                    ];
                }


            }
            else {
                return [
                    'text' => 'failed to search a bind',
                    'status' => 400
                ];

            }


    }


    static public function removeBind($product_id, $voucher_id)
    {
        $voucherProduct = new VoucherProduct();

        if($voucherProduct->where('products_id', $product_id)->where('vouchers_id', $voucher_id)->delete()) {
            return true;
        }
        else {
            return false;
        }
    }
}
