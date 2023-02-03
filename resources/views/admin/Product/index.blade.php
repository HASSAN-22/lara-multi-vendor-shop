@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Product list</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <div class="x_title flex justify-content-between">
                        <div><a href="{{route('admin.product.create')}}" class="btn btn-info font-14">Add new</a></div>
                        <div>
                            <form action="" method="get">
                                @csrf
                                <input type="search" name="search" class="form-control font-14" placeholder="Type and press enter" />
                            </form>
                        </div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-responsive-sm">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">User</th>
                                <th class="text-center">Title</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Is original</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $key=>$item)
                                    <tr>
                                        <th class="text-center">{{$key+1}}</th>
                                        <td class="text-center">{{$item->user->name}}</td>
                                        <td class="text-center">{{$item->title}}</td>
                                        <td class="text-center">{{$item->category->title}}</td>
                                        <td class="text-center"><img src="{{$item->image->image??'/product.jpg'}}" width="70" height="70" /></td>
                                        <td class="text-center">{{number_format($item->price,2)}}$</td>
                                        <td class="text-center">{{$item->discount}}%</td>
                                        <td class="text-center">{{$item->is_original}}</td>
                                        <td class="text-center">{{$item->status}}</td>
                                        <td class="flex align-center justify-center">
                                            <a href="{{route('admin.product.edit',['product'=>$item->id])}}" class="btn btn-info font-14">Edit</a>
                                            <form action="{{route('admin.product.destroy',['product'=>$item->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger font-14">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{$products->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
