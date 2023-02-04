@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update slider</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('admin.slider.update',['slider'=>$slider->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Title <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="title" value="{{old('title') ?? $slider->title}}" placeholder="Title">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Image <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="file" class="form-control font-14" name="image">
                                    @if(!is_null($slider->image))
                                        <div><img src="{{$slider->image}}" height="120" width="120" /></div>
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Link </label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="link" value="{{old('link') ?? $slider->link}}" placeholder="Link">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.slider.index')}}" class="btn btn-danger font-14">Back</a>
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
