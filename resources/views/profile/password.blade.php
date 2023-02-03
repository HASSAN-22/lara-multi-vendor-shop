@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update password</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('password.update',['user'=>$user->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Previous password <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="password" class="form-control font-14" name="previous_password" value="" placeholder="Previous password">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">New password <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="password" class="form-control font-14" name="password" value="" placeholder="New password">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Confirm password <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="password" class="form-control font-14" name="password_confirmation" value="" placeholder="Confirm password">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
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
