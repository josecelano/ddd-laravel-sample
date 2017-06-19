@extends('frontend.layouts.app')

@section('content')
    <div class="row">

        <div class="col-xs-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-home"></i> {{ trans('navs.general.home') }}
                </div>

                <div class="panel-body">
                    <p>{{ trans('strings.frontend.welcome_to', ['place' => app_name()]) }}.</p>
                    <p>{{ trans('strings.frontend.homepage') }}.</p>
                    <p>Fork me on GitHub: <a href="https://github.com/josecelano/my-favourite-appliances">josecelano/ddd-laravel-sample</a>
                    </p>
                </div>
            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!--row-->
@endsection