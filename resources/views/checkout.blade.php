@extends('layouts.Front')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <x-error-validation-component :errors="$errors"></x-error-validation-component>
        <form action="{{route('front.order')}}" method="post">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                        <div class="row">
                            <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Name</label>
                                        <input class="form-control" name="name" value="{{old('name')??$user->name}}" type="text">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input class="form-control" type="email" name="email" value="{{old('email')??$user->email}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Address</label>
                                        <input class="form-control" type="text"  name="address" value="{{old('address')??$user->address}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text"  name="city" value="{{old('city')??$user->city}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Province</label>
                                        <input class="form-control" type="text"  name="province" value="{{old('province')??$user->province}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Plaque</label>
                                        <input class="form-control" type="text"  name="plak" value="{{old('plak')??$user->plak}}">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>National id</label>
                                        <input class="form-control" type="text"  name="national_id" value="{{old('national_id')??$user->national_id}}">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                        </div>
                        <div class="card-body">
                            <h5 class="font-weight-medium mb-3">Products</h5>
                            <?php $total = 0;?>
                            @foreach($baskets as $basket)
                                    <?php
                                        $product = $basket->product;
                                        $price = discount($product->price, $product->discount);
                                        $propertyPrice = $basket->basketProperties()->with('productProperty')->get()->sum('productProperty.price');
                                        $totalPrice = ($price * $basket->count) + $propertyPrice;
                                        $total += ($totalPrice + $propertyPrice);
                                    ?>
                                <div class="d-flex justify-content-between">
                                    <p>{{$product->title}}</p>
                                    <p>${{number_format($totalPrice, 2)}}</p>
                                </div>
                            @endforeach
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium">${{number_format($total, 2)}}</h6>
                            </div>
                            @if($discount > 0)
                                <div class="d-flex justify-content-between mb-3 pt-1">
                                    <h6 class="font-weight-medium">Discount coupon</h6>
                                    <h6 class="font-weight-medium">${{$discount}}</h6>
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
                                <h5 class="font-weight-bold">${{number_format(discount($total+10,$discount),2)}}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Payment</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="paypal" id="paypal">
                                    <label class="custom-control-label" for="paypal">Paypal</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="directcheck" id="directcheck">
                                    <label class="custom-control-label" for="directcheck">Direct Check</label>
                                </div>
                            </div>
                            <div class="">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="payment" value="banktransfer" id="banktransfer">
                                    <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->
@stop
