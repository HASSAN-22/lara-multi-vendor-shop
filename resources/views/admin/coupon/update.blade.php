@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update coupon</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('admin.coupon.update',['id'=>$coupon['id']])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('patch')
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">For products <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="product_ids[]" multiple class="form-control font-14" id="product_ids">
                                        <?php
                                            $couponProducts = array_merge(array_map(fn($item)=>$item['id'], $couponProducts), [old('product_ids')]);
                                        ?>
                                        @foreach($products as $item)
                                            <option value="{{$item->id}}" {{in_array($item->id, $couponProducts) ? 'selected' : ''}}>{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Discount <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="discount" value="{{old('discount')??$coupon['percent']}}" placeholder="Discount %">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Limit user <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="limit_user" value="{{old('limit_user')??$coupon['limit_user']}}" placeholder="Limit user">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Expire at <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="date" class="form-control font-14" name="expire_at" value="{{old('expire_at')??explode(' ',$coupon['expire_at'])[0]}}" placeholder="Expire at">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.coupon.index')}}" class="btn btn-danger font-14">Back</a>
                                    <button type="submit" class="btn btn-success font-14">Insert</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
