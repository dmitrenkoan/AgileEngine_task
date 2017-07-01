@extends('template')

@section('content')
    <div class="container-fluid text-center">
        <div class="row content">
            <div class="col-sm-12 text-left margin">
                @if($result)
                    <h3>Order successfully created</h3>
                    <p>Product and all bound vouchers removed</p>
                    <hr>
                    <p>Go to <a href="/">main</a> page</p>
                @else
                    <h3>Failed order add</h3>
                @endif
            </div>

        </div>
    </div>
@endsection