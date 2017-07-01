<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Voucher;
use DB;
use Validator;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $arSort = $this->templateSort($request);

        // Get product list items
        $obProductList = $this->getProductList($arSort['current']);
        if(!empty($obProductList)) {
            foreach($obProductList as $key => &$obProduct) {
                // calculate product discount price
                $arDiscountPrice = self::calcProductDiscountPrice($obProduct);
                $obProduct->discount_price = $arDiscountPrice['discount_price'];
                $arProductNumber[] = $obProduct->id;
            }
            sort($arProductNumber);
        }
        return view('layouts.task', [
            'obProductList' => $obProductList,
            'arSort' => $arSort,
            'arProductNumber' => $arProductNumber
        ]);
    }

    public function getProductList($arSort)
    {
        $obProductList = Product::orderBy($arSort['field'], $arSort['order'])->get();
        return $obProductList;
    }

    // calculate a product discount price also get all vouchers which are bound with a product
    static function calcProductDiscountPrice($product)
    {
        $discount = NULL;
        $maxDiscountPercentage = 60;
        $obPercentList = VoucherController::getVoucherList($product->id);

        if(!empty($obPercentList)) {
            foreach($obPercentList as $obPercentage) {
                    $discount += $obPercentage->percent;
                    if($discount >= $maxDiscountPercentage) {
                        $discount = $maxDiscountPercentage;
                        break;
                    }
            }
        }
        $discountPrice = (100 - $discount)/100*$product->price;
        $result = [
            'ob_vouchers' => $obPercentList,
            'discount_price' => $discountPrice
        ];
        return $result;
    }

    // api create a new product
    static public function add(Request $request)
    {

        // check a key and a secret in the header


            //validate the sent data
            if (self::dataAddValidate($request)) {

                $product = new Product();


                $product->name = $request->name;
                $product->price = $request->price;
                $product->deleted_at = NULL;

                $product->save();
                return [
                    'text' => 'product successfully created',
                    'status' => 201
                ];
            }
            else {
                return [
                    'text' => 'Failed to create product',
                    'status' => 400
                ];
            }




    }

    // validate the request data
    static public function dataAddValidate(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'price' => 'required|numeric',
        ]);
        if($v->fails()) {
            return false;
        }
        else {
            return true;
        }
    }

    // return a sort field and order of product list. Also returns a sort order for links in the view
    public function templateSort(Request $request) {
        switch($request->sort) {
            case "number":
                $arTemplateSort['current']['field'] = "id";
                if($request->order == "asc") {
                    $arTemplateSort['current']['order'] = "asc";
                    $arTemplateSort['number']['order'] = "desc";
                }
                else {
                    $arTemplateSort['current']['order'] = "desc";
                    $arTemplateSort['number']['order'] = "asc";
                }
                $arTemplateSort['name']['order'] = "asc";
                break;
            case "name":
                $arTemplateSort['current']['field'] = "name";
                if($request->order == "asc") {
                    $arTemplateSort['current']['order'] = "asc";
                    $arTemplateSort['name']['order'] = "desc";
                }
                else {
                    $arTemplateSort['current']['order'] = "desc";
                    $arTemplateSort['name']['order'] = "asc";
                }
                $arTemplateSort['number']['order'] = "asc";
            break;
            default:
                $arTemplateSort['current']['field'] = 'id';
                $arTemplateSort['current']['order'] = 'asc';
                $arTemplateSort['name']['order'] = "asc";
                $arTemplateSort['number']['order'] = "desc";

            break;
        }
        return $arTemplateSort;
    }

}
