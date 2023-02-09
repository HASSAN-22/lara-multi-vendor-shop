@extends('layouts.Front')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Image</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Property price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody class="align-middle">
                    <?php $total = 0;?>
                        @foreach($baskets as $basket)
                            <tr>
                                <?php
                                    $product = $basket->product;
                                    $price = discount($product->price, $product->discount);
                                    $propertyPrice = $basket->basketProperties()->with('productProperty')->get()->sum('productProperty.price');
                                    $totalPrice = ($price * $basket->count) + $propertyPrice;
                                    $total += ($totalPrice + $propertyPrice);
                                ?>
                            <td class="align-middle">
                                <img src="{{$product->image->image}}" alt="" width="120" height="120">
                            </td>
                            <td class="align-middle"><a href="{{route('front.product',['product'=>$product->id])}}">{{$product->title}}</a></td>
                            <td class="align-middle">${{number_format($price,2)}}</td>
                            <td class="align-middle">${{number_format($propertyPrice,2)}}</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" onclick="updateBasketCount('{{$product->id}}')">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary text-center cartCount" min="0" value="{{$basket->count}}">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" onclick="updateBasketCount('{{$product->id}}')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">${{number_format($totalPrice,2)}}</td>
                            <td class="align-middle">
                                <form action="{{route('front.delete-basket',['basket'=>$basket->id])}}" method="post">
                                    @csrf
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" action="{{route('front.cart.coupon')}}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="coupon" class="form-control p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">${{number_format($total,2)}}</h6>
                        </div>
                        @if(session('discount') or $discount != 0)
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Coupon discount</h6>
                                <h6 class="font-weight-medium">{{session('discount') ?? $discount}}%</h6>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            @if(session('discount') or $discount != 0)
                                <?php
                                    $percent = session('percent') ?? $discount;
                                ?>
                                <h5 class="font-weight-bold">${{number_format(discount($total,$percent)+10,2)}}</h5>
                            @else
                                <h5 class="font-weight-bold">${{number_format($total+10,2)}}</h5>
                            @endif

                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

@stop
