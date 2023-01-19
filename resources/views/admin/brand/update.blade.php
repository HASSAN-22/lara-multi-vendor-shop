@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update category</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('admin.brand.update',['brand'=>$brand->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brand for user <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="user_id" id="user_id" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="0">parent</option>
                                        @foreach($users as $item)
                                            <option value="{{$item->id}}" {{in_array($item->id, [old('user_id'),$brand->user_id]) ? 'selected' : ''}}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brand name </label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="brand_name" value="{{old('brand_name') ?? $brand->brand_name}}" placeholder="Brand website">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brand Logo <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="file" class="form-control font-14" name="brand_logo">
                                    @if(!is_null($brand->brand_logo))
                                        <div><img src="{{$brand->brand_logo}}" height="120" width="120" /></div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Brand website </label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="brand_website" value="{{old('brand_website') ?? $brand->brand_website}}" placeholder="Brand website">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Status <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="status" id="status" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="activated" {{in_array('activated',[old('status'),$brand->status]) ? 'selected' : ''}}>activated</option>
                                        <option value="deactivated" {{in_array('deactivated',[old('status'),$brand->status]) ? 'selected' : ''}}>deactivated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.brand.index')}}" class="btn btn-danger font-14">Back</a>
                                    <button type="submit" class="btn btn-success font-14">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
