@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Slider list</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <div class="x_title flex justify-content-between">
                        <div><a href="{{route('admin.slider.create')}}" class="btn btn-info font-14">Add new</a></div>
                        <div>
                        </div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped table-responsive-sm">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">title</th>
                                <th class="text-center">image</th>
                                <th class="text-center">link</th>
                                <th class="text-center">action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $key=>$item)
                                    <tr>
                                        <th class="text-center">{{$key+1}}</th>
                                        <td class="text-center">{{$item->title}}</td>
                                        <td class="text-center"><img src="{{$item->image}}" width="120" height="120" /></td>
                                        <td class="text-center"><a href="{{$item->link}}" target="_blank">Open website</a></td>
                                        <td class="flex align-center justify-center">
                                            <a href="{{route('admin.slider.edit',['slider'=>$item->id])}}" class="btn btn-info font-14">Edit</a>
                                            <form action="{{route('admin.slider.destroy',['slider'=>$item->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?')" class="btn btn-danger font-14">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>{{$sliders->render()}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
