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
                        <form action="{{route('admin.category.update',['category'=>$category->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Title <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="title" value="{{old('title') ?? $category->title}}" placeholder="Title">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Parent <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="parent_id" id="parent_id" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="0">parent</option>
                                        @foreach($categories as $item)
                                            <option value="{{$item->id}}" {{in_array($item->id, [old('parent_id'),$category->parent_id]) ? 'selected' : ''}}>{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Status <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="status" id="status" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="activated" {{in_array('activated',[old('status'),$category->status]) ? 'selected' : ''}}>activated</option>
                                        <option value="deactivated" {{in_array('deactivated',[old('status'),$category->status]) ? 'selected' : ''}}>deactivated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Meta description</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <textarea name="meta_description" id="meta_description" cols="4" rows="4" class="form-control font-14">{{old('meta_description') ?? old('meta_description')}}</textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Meta keyword</label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <textarea name="meta_keyword" id="meta_keyword" cols="4" rows="4" class="form-control font-14">{{old('meta_keyword') ?? old('meta_keyword')}}</textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.category.index')}}" class="btn btn-danger font-14">Back</a>
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
