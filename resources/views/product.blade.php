@extends('layouts.Front')
@section('meta')
    <meta content="{{$product->meta_keyword}}" name="keywords">
    <meta content="{{$product->meta_description}}" name="description">
@stop
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{$product->title}}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('index')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{$product->title}}</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach($product->productImages as $key=>$image)
                            <div class="carousel-item {{$key == 0 ? 'active' : ''}}">
                                <img class="w-100 h-100" src="{{$image->image}}" alt="{{$product->title}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{$product->title}}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mb-2">
                        <?php $rating = (int) calculateRating($product->ratings);?>
                        @for($i=1;$i<=5; $i++)
                            @if($i <= $rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
                <?php
                    $price = discount($product->price, $product->discount);
                ?>
                <div class="flex align-content-center">
                    <h3 class="font-weight-semi-bold mb-4">$<span class="product_price">{{$price}}</span></h3>
                    <h5 class="text-muted ml-2"><del>${{$product->price}}</del></h5>
                </div>
                <p class="mb-4">{{$product->shor_description}}</p>
                @foreach(array_values($product->productProperties->groupBy('property_id')->toArray()) as $productProperties)
                    <div class="d-flex mb-3 properties">
                        <?php
                            $property = $productProperties[0]['property']['property'];
                            $propertyId = $productProperties[0]['property']['id'];
                        ?>
                        <p class="text-dark font-weight-medium mb-0 mr-3">{{$property}}:</p>
                        @foreach($productProperties as $key=>$productProperty)
                            <div class="custom-control custom-radio custom-control-inline property">
                                <input type="hidden" name="{{$property}}[{{$productProperty['name']}}]" value="{{$productProperty['id']}}" />
                                <input onclick="property(`{{$price}}`)" type="radio" name="{{$property}}" value="{{$productProperty['price']}}" class="custom-control-input" id="{{$property}}-{{$key}}">
                                <label class="custom-control-label" for="{{$property}}-{{$key}}">{{$productProperty['name']}}</label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus" onclick="decrementProduct('{{$price}}')">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary text-center productCount" min="0" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus" onclick="incrementProduct('{{$price}}')">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3" onclick="addToCart('{{$product->id}}')"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
                <div class="d-flex pt-2">
                    <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="https://www.facebook.com/sharer/sharer.php?u={{route('front.product',['product'=>$product->id])}}">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="https://twitter.com/share?text=text goes here&url={{route('front.product',['product'=>$product->id])}}">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="https://www.linkedin.com/shareArticle?mini=true&url={{route('front.product',['product'=>$product->id])}}/watch?v=SBi92AOSW2E">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="https://www.pinterest.com/pin/create/button/?url={{route('front.product',['product'=>$product->id])}}&media={{$product->productImages[0]->image}}&description={{$product->title}}">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex pt-2">
                    <span>Seller name:</span> <b>{{$product->user->shopName()}}</b>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews ({{$product->comments->count()}})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <p>
                            {{$product->description}}
                        </p>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-2">
                        <table class="table">
                            <tbody>
                                @foreach($product->productSpecifications as $productSpecification)
                                    <tr>
                                        <th>{{$productSpecification->name}}</th>
                                        <td>{{$productSpecification->description}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4">{{$product->comments->count()}} review for "{{$product->title}}"</h4>
                                @foreach($product->comments as $comment)
                                    <?php $rating = (int)$comment->user->ratings()->where('product_id',$product->id)->first()->rating; ?>
                                    <div class="media mb-4">
                                        <img src="{{$comment->user->avatar()}}" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{$comment->user->name}}<small> - <i>{{$comment->created_at->toDateString()}}</i></small></h6>
                                            <div class="text-primary mb-2">
                                                @for($i=1;$i<=5; $i++)
                                                    @if($i <= $rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p>
                                                {{$comment->message}}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <x-error-validation-component :errors="$errors"></x-error-validation-component>
                                <div class="d-flex my-3">
                                    <p class="mb-0 mr-2">Your Rating * :</p>
                                    <div class="text-primary star">
                                        <i class="far fa-star" data-star="1"></i>
                                        <i class="far fa-star" data-star="2"></i>
                                        <i class="far fa-star" data-star="3"></i>
                                        <i class="far fa-star" data-star="4"></i>
                                        <i class="far fa-star" data-star="5"></i>
                                    </div>
                                </div>
                                <form action="{{route('front.product.comment',['product'=>$product->id])}}" method="post">
                                    @csrf
                                    <input type="hidden" name="rating" class="rating_star">
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" name="message" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" name="name" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" name="email" class="form-control" id="email">
                                    </div>
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach($relateds as $item)
                        <div class="card product-item border-0">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="{{$item->image->image}}" alt="{{$item->title}}">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{$item->title}}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>${{discount($item->price, $item->discount)}}</h6><h6 class="text-muted ml-2"><del>${{$item->price}}</del></h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{route('front.product',['product'=>$item->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                @guest()
                                    <a href="javascript:void(0)" onclick="alert('You need to login to the website')" class="btn btn-sm text-dark p-0"><i class="fas fa-heart text-primary mr-1"></i>Add To Wishlist</a>
                                @else
                                    <a href="{{route('front.add.wishlist',['product'=>$item->id])}}" class="btn btn-sm text-dark p-0"><i class="fas fa-heart text-primary mr-1"></i>Add To Wishlist</a>
                                @endguest
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
@stop
