@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>User list</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <div class="x_title flex justify-content-between">
                        <div><a href="{{route('admin.user.create')}}" class="btn btn-info font-14">Add new</a></div>
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
                                <th class="text-center">name</th>
                                <th class="text-center">email</th>
                                <th class="text-center">access</th>
                                <th class="text-center">status</th>
                                <th class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=>$item)
                                    <tr>
                                        <th class="text-center">{{$key+1}}</th>
                                        <td class="text-center">{{$item->name}}</td>
                                        <td class="text-center">{{$item->email}}</td>
                                        <td class="text-center">{{$item->access}}</td>
                                        <td class="text-center">{{$item->status}}</td>
                                        <td class="flex align-center justify-center">
                                            <a href="{{route('admin.user.edit',['user'=>$item->id])}}" class="btn btn-info font-14">Edit</a>
                                            <form action="{{route('admin.user.destroy',['user'=>$item->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger font-14">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{$users->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
