<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        // check a key and a secret in the header
        if(ApiSettingsController::checkAuth($request->header('Auth'))) {
            $action = $request->action;

            switch ($action) {
                case "addProduct":
                    $response = ProductController::add($request);
                break;
                case "addVoucher":
                    $response = VoucherController::add($request);
                break;
                case "voucherProductBindAdd":
                    $response = VoucherController::addVoucherProductBind($request);
                break;
                case "voucherProductBindRemove":
                    $response = VoucherController::removeVoucherProductBind($request);
                break;
                case "orderAdd":
                    $response = OrderController::apiOrderAdd($request);
                break;
                default:
                    response('undefined action', 400);
                break;
            }
            return response($response['text'], $response['status']);
        }
        else {
            return response('wrong key or secret', 403);
        }

    }
}
