@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Property list</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <div class="x_title flex justify-content-between">
                        <div><a href="{{route('admin.property.create')}}" class="btn btn-info font-14">Add new</a></div>
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
                                <th class="text-center">property</th>
                                <th class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($properties as $key=>$item)
                                    <tr>
                                        <th class="text-center">{{$key+1}}</th>
                                        <td class="text-center">{{$item->property}}</td>
                                        <td class="flex align-center justify-center">
                                            <a href="{{route('admin.property.edit',['property'=>$item->id])}}" class="btn btn-info font-14">Edit</a>
                                            <form action="{{route('admin.property.destroy',['property'=>$item->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger font-14">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{$properties->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
