@extends('frontend.layouts.app')

@section('content')
    <div class="row-fluid">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">

                    <ul class="media-list">
                        <li class="media">
                            <div class="media-left">
                                <img class="media-object" src="{{ $wishlistOwner->picture }}"
                                     alt="Profile picture">
                            </div><!--media-left-->

                            <div class="media-body">
                                <h4 class="media-heading">
                                    {{ trans('wishlist.heading', [ 'name' => $wishlistOwner->name ]) }}<br/>
                                    <small>
                                        {{ trans('wishlist.joined') }} {{ $wishlistOwner->created_at->format('F jS, Y') }}
                                    </small>
                                </h4>

                                @permission('view-backend')
                                {{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration'), [], ['class' => 'btn btn-danger btn-xs']) }}
                                @endauth
                            </div><!--media-body-->
                        </li><!--media-->
                    </ul><!--media-list-->

                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="col-xs-12">
                            @if(count($appliances) == 0)
                                {{ trans('wishlist.empty') }}
                            @else
                                @foreach($appliances as $appliance)
                                    @include('frontend.wishlist.item')
                                @endforeach
                            @endif
                        </div><!--col-md-6-->
                    </div><!--row-->
                    @if(count($appliances) > 0)
                        {{ $appliances->links() }}
                    @endif
                </div><!--panel body-->
            </div><!-- panel -->
        </div><!-- col-xs-12 -->
    </div><!-- row -->
@endsection