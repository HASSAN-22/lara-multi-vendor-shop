<div class="x_title">
    @if(session()->has('alert'))
        <div class="alert alert-{{session('color')}} text-center">{{session('alert')}}</div>
    @elseif(session()->has('manual'))
        <div class="alert alert-info text-center">{{session('manual')}}</div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger text-center">{{session('error')}}</div>
    @endif
    <div class="clearfix"></div>
</div>
