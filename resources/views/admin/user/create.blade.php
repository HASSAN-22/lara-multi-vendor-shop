@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add new user</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Name <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="name" value="{{old('name')}}" placeholder="Name">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Email <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="email" class="form-control font-14" name="email" value="{{old('email')}}" placeholder="Email">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Password <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="password" class="form-control font-14" name="password" value="" placeholder="Password">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Access <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="access" id="access" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="admin" {{old('access') == 'admin' ? 'selected' : ''}}>Admin</option>
                                        <option value="vendor" {{old('access') == 'vendor' ? 'selected' : ''}}>Vendor</option>
                                        <option value="customer" {{old('access') == 'customer' ? 'selected' : ''}}>Customer</option>
                                    </select>
                                </div>
                            </div><div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Status <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="status" id="status" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="activated" {{old('status') == 'activated' ? 'selected' : ''}}>activated</option>
                                        <option value="deactivated" {{old('status') == 'deactivated' ? 'selected' : ''}}>deactivated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.user.index')}}" class="btn btn-danger font-14">Back</a>
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
