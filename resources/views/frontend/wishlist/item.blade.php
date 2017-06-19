<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ $appliance->title }}</h4>
    </div><!--panel-heading-->

    <div class="panel-body">
        <div class="row">
            <div class="col-xs-4 col-sm-4">
                <img class="img-responsive"
                     src="{{ asset('storage/appliances/' . $appliance->image) }}"
                     alt="{{ $appliance->title }}">
            </div>
            <div class="col-xs-8 col-sm-8">
                <h3>{{ $appliance->price_currency == 'EUR' ? '&euro;' : '' }}
                    &nbsp;{{ $appliance->price_amount/100 }}</h3>
                {!! $appliance->description !!}<br/>
                <div class="btn-group" role="group" aria-label="...">
                    @if ($logged_in_user && $wishlistOwner->id == $logged_in_user->id)
                        <form method="post"
                              action="{{ route('frontend.user.wishlist.appliance.remove', [ 'userId' => $logged_in_user->id ]) }}">
                            {{ csrf_field() }}
                            <input type="hidden" name="applianceId" value="{{ $appliance->appliance_id }}">
                            <button type="submit" class="btn btn-primary">Remove</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div><!--panel-body-->
</div><!--panel-->