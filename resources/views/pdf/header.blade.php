    <header id="header">
        <div style="display:inline-block; float:left; width:50%; text-align:left">
            <img src="{{public_path()}}/assets/images/brands/{!!$brand->logo!!}" style="max-height:150px"/>
        </div>
        <div style="display:inline-block; float:left; width:50%; text-align:right">
            <br>
            <h3 style="text-align:right">{!!strtoupper(trans('messages.Order Confirmation'))!!}</h3>
            <br>
            <table style="margin-left:auto">
                <tr>
                    <td><h6 style="text-align:right; padding-right:30px; color:#770476">
                        {!!strtoupper(trans('messages.Reference'))!!}:
                    </h6></td>
                    <td><h6 style="text-align:right"># {!!strtoupper(Auth::user()->options->brand_in_use->slug)!!}-{!!$order->id!!}</h6></td>
                </tr>
                <tr>
                    <td><h6 style="text-align:right; padding-right:30px; color:#770476">
                        {!!strtoupper(trans('auth.Receiver'))!!}:
                    </h6></td>
                    <td><h6 style="text-align:right"> {!!strtoupper($order->customer->companyname)!!}</h6></td>
                </tr>
                <tr>
                    <td><h6 style="text-align:right; padding-right:30px; color:#770476">
                        {!!strtoupper(trans('messages.Agent'))!!}:
                    </h6></td>
                    <td><h6 style="text-align:right"> {!!strtoupper($order->user->profile->companyname)!!}</h6></td>
                </tr>
                <tr>
                    <td><h6 style="text-align:right; padding-right:30px; color:#770476">
                        {!!strtoupper(trans('messages.Date'))!!}:
                    </h6></td>
                    <td><h6 style="text-align:right"> {{ $order->created_at->format('d/m/Y') }}</h6></td>
                </tr>
            </table>
        </div>
    </header>