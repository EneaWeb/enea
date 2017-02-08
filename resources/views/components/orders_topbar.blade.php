<br>
<div class="note note-info" style="font-size:16px">
    <p style="font-size:14px"> 
        1 {{ trans('x.order in progress') }} : 
        <span id="order-infos">{!! \App\Order::renderOrderInfos() !!}</span>

        <a href="/orders/clear-session-order" class="btn btn-danger btn-xs" style="float:right; margin-left:6px;">Elimina</a> 
        <a href="/orders/new/step4" class="btn btn-success btn-xs" style="float:right; margin-left:6px;">Conferma</a>
        @if (! (Request::segment(2) == 'orders' && Request::segment(3) == 'new') )
            <a href="/orders/new" class="btn btn-info btn-xs" style="float:right; margin-left:6px;">Continua</a> 
        @endif
    </p>
</div>