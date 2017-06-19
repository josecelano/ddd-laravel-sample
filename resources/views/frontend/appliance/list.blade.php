@extends('frontend.layouts.app')

@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('appliances.category.small_appliances') }}</div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            @foreach($appliances as $appliance)
                                @include('frontend.appliance.list-item')
                            @endforeach
                        </div><!--col-md-6-->
                    </div><!--row-->
                    {{ $appliances->links() }}
                </div><!--panel body-->
            </div><!-- panel -->
        </div><!-- col-xs-12 -->
    </div><!-- row -->
@endsection