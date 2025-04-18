<div class="row">
    <div class="col-xxl-4">
        <a href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">Go To The Dashboard<br></a>
        <a href='/positions/4'>Go To Position #4<br></a>
        <a href='/incumbents/57'>Go To Incumbent #57<br></a>
        <a href='/reports/1'>Go To Reports<br></a>
        <a style="margin: 19px;" href="{{ route('positions.create')}}" class="btn btn-primary">New position</a>
    </div>
    <div class="col-xxl-4">
    </div>
    <div class="col" -xxl-3>
        <h1 class="display-5 text-end font:bold">
        PowerPCS
        </h1>
    </div>
    <div class="col" -xxl-1>
        <img src="{{asset('/images/PowerArmImageV2_Transp.png')}}" style="width:66.67px; height:100px;">
    </div>
</div>

