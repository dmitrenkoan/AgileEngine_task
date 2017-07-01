@extends('template')

@section('content')
    @if(!empty($obProductList))
    <div class="container-fluid text-center">
        <div class="row border equal header">
            <div class="col-sm-1 text-center">
                <p>
                    <a href="?sort=number&order={{$arSort['number']['order']}}"> №</a>
                </p>
            </div>
            <div class="col-sm-5 text-center">
                <a href="?sort=name&order={{$arSort['name']['order']}}">Title</a>
            </div>
            <div class="col-sm-3 text-center">
                Price
            </div>
            <div class="col-sm-3 text-center">

            </div>


        </div>
        @foreach($obProductList as $key => $product_item)
        <div class="row border equal">
            <div class="col-sm-1 text-center">
               <p>

                <h3>{{array_search($product_item->id, $arProductNumber) +1}}</h3>
                </p>
            </div>
            <div class="col-sm-5 text-center">
                <h3>{{$product_item->name}}</h3>


            </div>
            <div class="col-sm-3 text-center">
                @if($product_item->discount_price < $product_item->price)
                    <div class="old-price">
                        {{$product_item->price}} <span class="currency">UAH</span>
                    </div>

                @endif
                    <div class="price">
                        {{$product_item->discount_price}} <span class="currency">UAH</span>
                    </div>
            </div>
            <div class="col-sm-3 text-center">
                <form action="/order/add" method="POST">
                    <input type="hidden" name="product_id" value="{{$product_item->id}}"/>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn" type="submit">
                        Buy
                    </button>
                </form>
            </div>


        </div>
        @endforeach
    </div>
    @endif
@endsection