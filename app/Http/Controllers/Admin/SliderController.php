<?php

namespace App\Http\Controllers\Admin;

use App\Auxiliary\Uploader\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    private $DIRECTORY = 'uploader/slider';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Slider::class);
        $sliders = Slider::latest()->paginate(config('app.paginate'));
        return view('admin.slider.index',compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Slider::class);
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $this->authorize('create',Slider::class);
        $slider = Slider::create([
            'image'=>Upload::upload($request,'image',$this->DIRECTORY),
            'title'=>$request->title,
            'link'=>$request->link
        ]);
        return responseMessage($slider,'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $this->authorize('update',$slider);
        return view('admin.slider.update',compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $this->authorize('update',$slider);
        $slider = $slider->update([
            'image'=>Upload::upload($request,'image',$this->DIRECTORY,$slider->image),
            'title'=>$request->title,
            'link'=>$request->link
        ]);
        return responseMessage($slider,'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $this->authorize('delete',$slider);
        if($slider->delete()){
            removeFile($slider->image);
            return responseMessage(true,'delete');
        }
        return responseMessage(false,'delete');
    }
}
