@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update user</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('admin.user.update',['user'=>$user->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Name <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="text" class="form-control font-14" name="name" value="{{old('name') ?? $user->name}}" placeholder="Name">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Email <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="email" class="form-control font-14" name="email" value="{{old('email') ?? $user->email}}" placeholder="Email">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Password <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="password" class="form-control font-14" name="password" value="" placeholder="If it does not change the password, leave it blank">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Access <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="access" id="access" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="admin" {{in_array('admin',[old('access'),$user->access]) ? 'selected' : ''}}>Admin</option>
                                        <option value="vendor" {{in_array('vendor',[old('access'),$user->access]) ? 'selected' : ''}}>Vendor</option>
                                        <option value="customer" {{in_array('customer',[old('access'),$user->access]) ? 'selected' : ''}}>Customer</option>
                                    </select>
                                </div>
                            </div><div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12">Status <b class="text-danger font-14">*</b></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <select name="status" id="status" class="form-control font-14">
                                        <option value="" selected disabled>--- Select item ---</option>
                                        <option value="activated" {{in_array('activated',[old('status'),$user->status]) ? 'selected' : ''}}>activated</option>
                                        <option value="deactivated" {{in_array('deactivated',[old('status'),$user->status]) ? 'selected' : ''}}>deactivated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="form-group mt-3">
                                <label class="control-label col-md-2 col-sm-2 col-xs-12"></label>
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('admin.user.index')}}" class="btn btn-danger font-14">Back</a>
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
