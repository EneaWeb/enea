@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
   <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->
        <div class="page-sidebar">
            <nav class="navbar" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!-- Collect the nav links, forms, and other content for toggling -->
                <ul class="nav navbar-nav margin-bottom-35">
                    <li class="active">
                        <a href="#">
                            <i class="icon-home"></i> {!!trans('x.Product')!!}
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- END PAGE SIDEBAR -->
                  
        <div class="page-content-col">

        {!!Form::open(['url'=>'/catalogue/products/new', 'method'=>'POST'])!!}

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet">
                        <div class="portlet-title">
                            <div class="caption">
                                {!!trans('x.New Product')!!}
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tabbable-bordered">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_edit" data-toggle="tab"> {!!trans('x.Edit')!!} </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    
                                    <div class="tab-pane portlet-body flip-scroll active" id="tab_edit">
                                        
                                        <div class="row">
                                        
                                            <div class="col-md-6 col-lg-5 form-horizontal">

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Season')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('season_id', \App\Season::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Type')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('type_id', \App\Type::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>
                                                
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Model')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('prodmodel_id', \App\ProdModel::pluck('name', 'id'), '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Name')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::text('name', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">SKU</label>
                                                        <div class="col-md-9">
                                                            {!!Form::text('sku', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Description')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::textarea('description', '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Has variations')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('has_variations', ['1'=>trans('x.Yes'), '0'=>trans('x.No')], '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">{!!trans('x.Active')!!}</label>
                                                        <div class="col-md-9">
                                                            {!!Form::select('active', ['1'=>trans('x.Yes'), '0'=>trans('x.No')], '', ['class'=>'form-control'])!!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group" style="text-align:right">
                                                    <br><br>
                                                        {!!Form::submit(trans('x.Save'), ['class'=>'btn btn-danger btn-lg'])!!}
                                                    </div>
                                                    
                                            </div>

                                            <div class="col-md-6 col-lg-7">

                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-dark"></i>
                                                            <span class="caption-subject font-dark sbold uppercase">{!!trans('x.Variations Creation')!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form-horizontal">

                                                        <div class="form-group">

                                                            <label for="multiple" class="col-md-3 control-label">{!!trans('x.Attributes')!!}</label>
                                                            <div class="col-md-9">
                                                                <select id="variations" class="form-control select2-multiple" multiple>
                                                                    @foreach(\App\Attribute::all() as $attribute)
                                                                        <optgroup label="{!!$attribute->name!!}">
                                                                        @foreach ($attribute->terms as $term)
                                                                            <option value="{!!$term->id!!}" data-attribute="{!!$term->attribute->id!!}">{!!$term->name!!}</option>
                                                                        @endforeach
                                                                        </optgroup>
                                                                    @endforeach
                                                                </select>

                                                                <br>

                                                                <button type="button" class="btn btn-info" id="create-variations">
                                                                    {!!trans('x.Create variations from attributes')!!}
                                                                </button>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="portlet light bordered">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-settings font-dark"></i>
                                                            <span class="caption-subject font-dark sbold uppercase">{!!trans('x.Variations')!!}</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body form-horizontal">
                                                        <div class="form-group">
                                                            <div class="col-md-12" id="variations-container">
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->

        {!!Form::close()!!}
        
        </div>
        
   </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@stop

{{-- file script form multi select2 : [..]/component-selec2.min.js --}}

@section('pages-scripts')

    <script>

        $('#create-variations').on('click', function(){

            priceLists = JSON.parse('{!!\App\PriceList::pluck('id')->toJSON()!!}');

            var content = '';
            var attributes = new Array();
            $('#variations :selected').each(function(i, selected){ 
                thisTerm = $(selected).val();
                thisAttribute = $(selected).data('attribute');
                attributes.push({ attribute: thisAttribute, term: thisTerm });
            });

            $.ajax({
                url : '/catalogue/products/create-variations',
                method : 'GET',
                data: { _token: '{!!csrf_token()!!}', attributes : attributes }
            })
            .success(function(msg){
                 $('#variations-container').empty().hide().html(msg).fadeIn();
            })
            .error(function(){
                alert('ajax error');
            })

        })

    </script>

@stop
