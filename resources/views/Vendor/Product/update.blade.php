@extends('layouts.Panel.panel')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update product</h2>
                        <div class="clearfix"></div>
                    </div>
                    <x-error-message-component></x-error-message-component>
                    <x-error-validation-component :errors="$errors"></x-error-validation-component>
                    <div class="x_content">
                        <form action="{{route('vendor.product.update',['product'=>$product->id])}}" method="post" enctype="multipart/form-data" id="demo-form2" class="form-horizontal form-label-left">
                            @csrf
                            @method('PATCH')
                            <div class="row product">
                                <div class="col-sm-6 col-md-6 col-xs-12 product-box">
                                    <div><h5>Product Detail</h5></div>
                                    <div class="clearfix"></div>
                                    <div class="">
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control font-14" name="title" value="{{old('title') ?? $product->title}}" placeholder="Title">
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="category_id" id="category_id" class="form-control font-14">
                                                    <option value="" selected disabled>--- Select item ---</option>
                                                    @foreach($categories as $item)
                                                        <option value="{{$item->id}}" {{in_array($item->id, [old('category_id'),$product->category_id]) ? 'selected' : ''}}>{{$item->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Brand <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="brand_id" id="brand_id" class="form-control font-14">
                                                    <option value="" selected disabled>--- Select item ---</option>
                                                    @foreach($brands as $item)
                                                        <option value="{{$item->id}}" {{in_array($item->id, [old('brand_id'),$product->brand_id]) ? 'selected' : ''}}>{{$item->brand_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Guarantee <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="guarantee_id" id="guarantee_id" class="form-control font-14">
                                                    <option value="" selected disabled>--- Select item ---</option>
                                                    @foreach($guarantees as $item)
                                                        <option value="{{$item->id}}" {{in_array($item->id, [old('guarantee_id'),$product->guarantee_id]) ? 'selected' : ''}}>{{$item->guarantee}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Price <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control font-14" name="price" value="{{old('price')??$product->price}}" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Discount percent<b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control font-14" name="discount" value="{{old('discount')??$product->discount}}" placeholder="Discount percent">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Count <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" class="form-control font-14" name="count" value="{{old('count')??$product->count}}" placeholder="Count">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Is original <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="is_original" id="is_original" class="form-control font-14">
                                                    <option value="" selected disabled>--- Select item ---</option>
                                                    <option value="yes" {{in_array('yes',[old('is_original'),$product->is_original]) ? 'selected' : ''}}>yes</option>
                                                    <option value="no" {{in_array('no',[old('is_original'),$product->is_original]) ? 'selected' : ''}}>no</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status <b class="text-danger font-14">*</b></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select name="status" id="status" class="form-control font-14">
                                                    <option value="" selected disabled>--- Select item ---</option>
                                                    <option value="pending_confirmation" {{in_array('pending_confirmation',[old('status'),$product->status]) ? 'selected' : ''}}>pending confirmation</option>
                                                    <option value="activated" {{in_array('activated',[old('status'),$product->status]) ? 'selected' : ''}}>activated</option>
                                                    <option value="deactivated" {{in_array('deactivated',[old('status'),$product->status]) ? 'selected' : ''}}>deactivated</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">short description </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="short_description" id="short_description" class="form-control col-md-12 col-xs-12 font-14" placeholder="short description">{{old('short_description')??$product->short_description}}</textarea>
                                                <div class="red-alert"><span class="">Max 300 character</span></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">description </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="description" id="description" class="form-control col-md-12 col-xs-12 font-14" placeholder="description">{{old('description')??$product->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta description </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="meta_description" id="meta_description" class="form-control col-md-12 col-xs-12 font-14" placeholder="Meta description">{{old('meta_description')??$product->meta_description}}</textarea>
                                                <div class="red-alert"><span class="">Max 3000 character</span></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group mt-3">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Meta keyword </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="meta_keyword" id="meta_keyword" class="form-control col-md-12 col-xs-12 font-14" placeholder="Meta keyword">{{old('meta_keyword')??$product->meta_keyword}}</textarea>
                                                <div class="red-alert"><span class="">Max 3000 character</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-xs-12 product-box">
                                    <div><h5>Product specifications</h5></div>
                                    <div class="clearfix"></div>
                                    <div class="">
                                        <div class="row">
                                            <div class="form-group col-sm-12" style="background:#f2f2f2; padding:2rem;">
                                                <div>
                                                    <label class="control-label col-md-6 col-sm-6 col-xs-6 right-left h6" for="property">Properties</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <button type="button" onclick="addProperty()" class="btn btn-info">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Property</th>
                                                            <th class="text-center">Name</th>
                                                            <th class="text-center">Count</th>
                                                            <th class="text-center">Price</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="property">
                                                            @foreach($product->productProperties as $key=>$property)
                                                                <tr id="property_{{$key}}">
                                                                    <td class="text-center">
                                                                        <select name="property_ids[{{$key}}]" class="form-control col-md-12 col-xs-12 font-14">
                                                                            <option value="" selected="" disabled="">--- Select Item ---</option>
                                                                            @foreach($properties as $item)
                                                                                <option value="{{$item->id}}" {{$item->id == $property->property_id ? 'selected' : ''}}>{{$item->property}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="property_names" name="property_names[{{$key}}]" value="{{$property->name}}" class="form-control col-md-12 col-xs-12 font-14">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="property_counts" name="property_counts[{{$key}}]" value="{{$property->count}}"  class="form-control col-md-12 col-xs-12 font-14">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" id="property_prices" name="property_prices[{{$key}}]" value="{{$property->price}}"  class="form-control col-md-12 col-xs-12 font-14">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" onclick="deleteRow('#property_{{$key}}')" class="btn btn-danger">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-12" style="background:#f2f2f2; padding:2rem;">
                                                <div>
                                                    <label class="control-label col-md-6 col-sm-6 col-xs-6 right-left h6" for="property">Specifications</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <button type="button" onclick="addSpecifications()" class="btn btn-info">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">name</th>
                                                            <th class="text-center">Description</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="specification">
                                                            @foreach($product->productSpecifications as $key=>$specification)
                                                                <tr id="Specification_{{$key}}">
                                                                    <td>
                                                                        <input type="text" id="property_names" name="specification_names[{{$key}}]" value="{{$specification->name}}" class="form-control col-md-12 col-xs-12 font-14">
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="specification_descriptions[{{$key}}]" id="specification_descriptions" class="form-control col-md-12 col-xs-12 font-14">{{$specification->description}}</textarea>
                                                                        <div class="red-alert"><span class="">Max 300 character</span></div>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" onclick="deleteRow('#Specification_{{$key}}')" class="btn btn-danger">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-12" style="background:#f2f2f2; padding:2rem;">
                                                <div>
                                                    <label class="control-label col-md-6 col-sm-6 col-xs-6 right-left h6" for="property">Images</label>
                                                    <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                                        <button type="button" onclick="addImage()" class="btn btn-info">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Select image</th>
                                                            <th class="text-center">image</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="image">
                                                            @foreach($product->productImages as $key=>$image)
                                                                <tr id="image_{{$key}}">
                                                                    <td>
                                                                        <input type="file" id="images" onchange="loadFile(event, '{{$key}}')" name="images[{{$key}}]" class="form-control col-md-12 col-xs-12 font-14"
                                                                               style="background-color:#e6e6e6;" >
                                                                        <div class="red-alert"><span class="">Allowed format: jpg,jpeg,png | Allowed size: {{config('app.image_size')}} KB </span></div>
                                                                    </td>
                                                                    <td>
                                                                        <img id="prev_image_{{$key}}" src="{{$image->image}}" width="70" height="70" />
                                                                    </td>
                                                                    <td><button type="button" onclick="deleteImage('{{$image->id}}','#image_{{$key}}')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                                                                <tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group mt-3">
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <a  href="{{route('vendor.product.index')}}" class="btn btn-danger font-14">Back</a>
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
@section('b_js')
    <script>
        let propertyCount = '<?php echo count($product->productProperties); ?>';
        let Specification = '<?php echo count($product->productSpecifications); ?>';
        let imageCount = '<?php echo count($product->productImages); ?>';
        function addProperty(){
            let data = `
                 <tr id="property_${propertyCount}">
                    <td class="text-center">
                        <select name="property_ids[${propertyCount}]" class="form-control col-md-12 col-xs-12 font-14">
                            <option value="" selected="" disabled="">--- Select Item ---</option>
                             @foreach($properties as $item)
            <option value="{{$item->id}}" {{old('property_id') == $item->id ? 'selected' : ''}}>{{$item->property}}</option>
                            @endforeach
            </select>
        </td>
        <td>
            <input type="text" id="property_names" name="property_names[${propertyCount}]" class="form-control col-md-12 col-xs-12 font-14">
                    </td>
                    <td>
                        <input type="text" id="property_counts" name="property_counts[${propertyCount}]" class="form-control col-md-12 col-xs-12 font-14">
                    </td>
                    <td>
                        <input type="text" id="property_prices" name="property_prices[${propertyCount}]" class="form-control col-md-12 col-xs-12 font-14">
                    </td>
                    <td>
                        <button type="button" onclick="deleteRow('#property_${propertyCount}')" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `
            propertyCount++
            $(data).appendTo('#property');
        }

        function addSpecifications(){
            let data = `
                 <tr id="Specification_${Specification}">
                    <td>
                        <input type="text" id="property_names" name="specification_names[${Specification}]" class="form-control col-md-12 col-xs-12 font-14">
                    </td>
                    <td>
                        <textarea name="specification_descriptions[${Specification}]" id="specification_descriptions" class="form-control col-md-12 col-xs-12 font-14"></textarea>
                        <div class="red-alert"><span class="">Max 300 character</span></div>
                    </td>
                    <td>
                        <button type="button" onclick="deleteRow('#Specification_${Specification}')" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `
            Specification++
            $(data).appendTo('#specification');
        }

        function addImage(){
            data =`
                <tr id="image_${imageCount}">
                    <td>
                        <input type="file" id="images" onchange="loadFile(event, ${imageCount})" name="images[${imageCount}]" class="form-control col-md-12 col-xs-12 font-14"
                        style="background-color:#e6e6e6;" >
                        <div class="red-alert"><span class="">Allowed format: jpg,jpeg,png | Allowed size: {{config('app.image_size')}} KB </span></div>
                    </td>
                    <td>
                        <img id="prev_image_${imageCount}" width="70" height="70" />
                    </td>
                    <td><button type="button" onclick="deleteRow('#image_${imageCount}')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                <tr>
            `
            $(data).appendTo('#image');
            imageCount ++;
        }

        let loadFile = function(event, imgCount) {
            console.log(event.target.files[0])
            $('#prev_image_'+imgCount).attr('src',URL.createObjectURL(event.target.files[0]));
        };

        function deleteRow(id){
            $(id).remove();
        }

        function deleteImage(imageId,rawId){
            if(confirm('Are you sure you want to delete this image?')){
                axios.post('/admin/deleteImage/'+imageId,{'_token':token()}).then(resp=>{
                    deleteRow(rawId);
                    alert('Delete successfully')
                }).catch(err=>{
                    alert('Server error')
                })
            }

        }

        $(document).ready(function(){

        })
    </script>
@stop
