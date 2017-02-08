{{--
.mt-step-col .active = in progress
.mt-step-col .done = done
.mt-step-col .first = first
.mt-step-col .last = last
--}}

<?php $s = Request::segment(4); ?>

<div class="mt-element-step">
    <div class="row step-line">
        <a href="/orders/new/step1">
            <div class="col-xs-3 col-md-3 mt-step-col first 
            @if ($s == 'step1')
                active
            @else
                done
            @endif
            ">
                <div class="mt-step-number bg-white">
                    <i class="fa fa-user"></i>
                </div>
                <div class="mt-step-title uppercase font-grey-cascade">1 - {{trans('x.Customer')}}</div>
                <div class="mt-step-content font-grey-cascade">{{trans('x.Select infos about Customer')}}</div>
            </div>
        </a>
        <a href="/orders/new/step2">
            <div class="col-xs-3 col-md-3 mt-step-col
            @if ($s == 'step2')
                active
            @elseif ($s == 'step3' || $s == 'step4')
                done
            @endif
            ">
                <div class="mt-step-number bg-white">
                    <i class="fa fa-cog"></i>
                </div>
                <div class="mt-step-title uppercase font-grey-cascade">2 - {{trans('x.Options')}}</div>
                <div class="mt-step-content font-grey-cascade">{{trans('x.Select some options')}}</div>
            </div>
        </a>
        <a href="/orders/new/step3">
            <div class="col-xs-3 col-md-3 mt-step-col
            @if ($s == 'step3')
                active
            @elseif ($s == 'step4')
                done
            @endif
            ">
                <div class="mt-step-number bg-white">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="mt-step-title uppercase font-grey-cascade">3 - {{trans('x.Products')}}</div>
                <div class="mt-step-content font-grey-cascade">{{trans('x.Add products to Cart')}}</div>
            </div>
        </a>
        <a href="/orders/new/step4">
            <div class="col-xs-3 col-md-3 mt-step-col last
            @if ($s == 'step4')
                active
            @endif
            ">
                <div class="mt-step-number bg-white">
                    <i class="fa fa-check"></i>
                </div>
                <div class="mt-step-title uppercase font-grey-cascade">4 - {{trans('x.Confirm')}}</div>
                <div class="mt-step-content font-grey-cascade">{{trans('x.Overview and confirm order')}}</div>
            </div>
        </a>
    </div>
</div>