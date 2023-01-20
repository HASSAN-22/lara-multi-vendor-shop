<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuaranteeRequest;
use App\Models\Guarantee;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny',Guarantee::class);
        $guarantees = Guarantee::latest()->search()->paginate(config('app.paginate'));
        return view('admin.guarantee.index',compact('guarantees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Guarantee::class);
        return view('admin.guarantee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuaranteeRequest $request)
    {
        $this->authorize('create',Guarantee::class);
        $guarantee = Guarantee::create(['guarantee'=>$request->guarantee]);
        return responseMessage($guarantee,'create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function show(Guarantee $guarantee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantee $guarantee)
    {
        $this->authorize('update',$guarantee);
        return view('admin.guarantee.update',compact('guarantee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function update(GuaranteeRequest $request, Guarantee $guarantee)
    {
        $this->authorize('update',$guarantee);
        $guarantee = $guarantee->update(['guarantee'=>$request->guarantee]);
        return responseMessage($guarantee,'update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guarantee $guarantee)
    {
        $this->authorize('delete',$guarantee);
        return responseMessage($guarantee->delete(),'delete');
    }
}
