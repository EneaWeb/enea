@extends('layout.main')

@section('content')

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
								<i class="icon-home"></i> {!!trans('x.Customer')!!} 
							</a>
						</li>
					</ul>
				</nav>
			</div>
			<!-- END PAGE SIDEBAR -->
			<div class="page-content-col">
				<!-- BEGIN PAGE BASE CONTENT -->
				<div class="profile">
					<div class="tabbable-line tabbable-full-width">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab"> {!!trans('x.Overview')!!} </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab"> {!!trans('x.Edit')!!} </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="tab_1_1">
									<div class="row">
											<div class="col-md-3">
												@if ($test_position == true)
													{!! $mapHelper->render($map) !!}
												@else 
													<img src="/assets/images/no-position.jpg" style="max-width:100%;"/>
												@endif
											</div>
											<div class="col-md-9">
												<div class="row">
													<div class="col-md-8 profile-info">
															<h1 class="font-green sbold uppercase">{!!$customer->companyname!!}</h1>
															<p>
																<strong>{!!$customer->sign!!}</strong><br>
																Ref. <strong>{!!$customer->name!!} {!!$customer->surname!!}</strong>
															</p>
															<p>
																<i class="fa fa-map-marker"></i> {!!$customer->address!!}<br>
																<i class="fa"></i> {!!$customer->postcode!!} {!!$customer->city!!} {!!$customer->province!!} - {!!$customer->country!!} <br>
															</p>
															<p>
																<i class="fa fa-phone"></i> {!!$customer->telephone!!} {!!$customer->mobile!!} <br>
																<i class="fa fa-envelope"></i> <a href="mailto:{!!$customer->email!!}"> {!!$customer->email!!} </a>
															</p>
															<!--
																<ul class="list-inline">
																</ul>
															-->
													</div>
												</div>
												<!--end row-->
												<div class="tabbable-line tabbable-custom-profile">
													<ul class="nav nav-tabs">
															<li class="active">
																<a href="#tab_1_11" data-toggle="tab"> {!!trans('x.Orders')!!} </a>
															</li>
															<li>
																<a href="#tab_1_22" data-toggle="tab"> {!!trans('x.Delivery Addresses')!!}  </a>
															</li>
															<li>
																<a href="#tab_1_23" data-toggle="tab"> History </a>
															</li>
													</ul>
													<div class="tab-content">
															<div class="tab-pane active" id="tab_1_11">
																<div class="portlet-body">
																	
																	 @include('components.orders_table')

																</div>
															</div>
															<!--tab-pane-->
															<div class="tab-pane" id="tab_1_22">
																<div class="tab-pane active" id="tab_1_2_2">

																	<table id="delivery_addresses" class="table datatable table-condensed">
																		<thead>
																				<tr>
																					<th>{!!trans('x.Address')!!}</th>
																					<th>{!!trans('x.City')!!}</th>
																					<th>{!!trans('x.Country')!!}</th>
																					<th>{!!trans('x.Options')!!}</th>
																				</tr>
																		</thead>
																		<tbody>
																				<tr>
																					<td>{!!$customer->address!!}</td>
																					<td>{!!$customer->postcode!!} {!!$customer->city!!} {!!$customer->province!!}</td>
																					<td>{!!$customer->country!!}</td>
																					<td>
																					</td>
																				</tr>
																				@foreach ($customer->deliveries as $delivery)
																				<tr>
																					<td>{!!$delivery->address!!}</td>
																					<td>{!!$delivery->city!!} {!!$delivery->province!!}</td>
																					<td>{!!$delivery->country!!}</td>
																					<td>
																						{{-- <span class="badge badge-danger">
																								<a href="#" onclick="confirm_delete_customer_delivery({!!$delivery->id!!})" style="color:inherit; padding:6px">
																									<span class="fa fa-ban"></span>
																								</a>
																						</span>
																						--}}
																					</td>
																				</tr>
																				@endforeach
																		</tbody>
																	</table>

																	<a href="#" data-toggle="modal" data-target="#modal_add_delivery">
																		<button class="btn btn-main">Aggiungi</button>
																	</a>

																</div>
															</div>
															<!--tab-pane-->
															<div class="tab-pane" id="tab_1_23">
																<div class="tab-pane active" id="tab_1_2_3">
																	<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
																			<ul class="feeds">
																				<li>
																					<div class="col1">
																							<div class="cont">
																								<div class="cont-col1">
																									<div class="label label-success">
																											<i class="fa fa-bell-o"></i>
																									</div>
																								</div>
																								<div class="cont-col2">
																									<div class="desc"> funzione in lavorazione
																									</div>
																								</div>
																							</div>
																					</div>
																					<div class="col2">
																							<div class="date"> .. </div>
																					</div>
																				</li>
																			</ul>
																	</div>
																</div>
															</div>
													</div>
												</div>
											</div>
									</div>
								</div>
								<!--tab_1_2-->
								<div class="tab-pane" id="tab_1_3">
									<div class="row profile-account">
											<div class="col-md-3">
												<ul class="ver-inline-menu tabbable margin-bottom-10">
													<li class="active">
														<a data-toggle="tab" href="#tab_personalinfo">
															<i class="fa fa-cog"></i> {!!trans('x.Personal info')!!} </a>
														<span class="after"> </span>
													</li>
												</ul>
											</div>
											<div class="col-md-9">
												<div class="tab-content">
													<div id="tab_personalinfo" class="tab-pane active">
														
														{!!Form::open(['url'=>'/customer/edit-customer', 'method'=>'POST', 'class'=>''])!!}
														{!!Form::hidden('id', $customer->id)!!}
														
														<div class="panel panel-default">
															<div class="panel-body">
																	<h3><span class="fa fa-user"></span> {!!trans('x.Profile')!!}</h3>
																	<p></p>
															</div>
															<div class="panel-body form-group-separated">
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Company Name')!!}</label>
																			{!!Form::input('text', 'companyname', $customer->companyname, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.First Name')!!}*</label>
																			{!!Form::input('text', 'name', $customer->name, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Sign')!!}</label>
																			{!!Form::input('text', 'sign', $customer->sign, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Vat')!!}</label>
																			{!!Form::input('text', 'vat', $customer->vat, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Address')!!}*</label>
																			{!!Form::input('text', 'address', $customer->address, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.City')!!}*</label>
																			{!!Form::input('text', 'city', $customer->city, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Province')!!}</label>
																			{!!Form::input('text', 'province', $customer->province, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Postcode')!!}</label>
																			{!!Form::input('text', 'postcode', $customer->postcode, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Country')!!}</label>
                                                                            {!!Form::select('country', Config::get('countries_'.Localization::getCurrentLocale()), $customer->country, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Telephone')!!}</label>
																			{!!Form::input('text', 'telephone', $customer->telephone, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Mobile')!!}</label>
																			{!!Form::input('text', 'mobile', $customer->mobile, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Email')!!}</label>
																			{!!Form::input('text', 'email', $customer->email, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																		<label class="control-label">{!!trans('x.Language')!!}</label>
																			{!!Form::select('language', $supportedLocales, $customer->language, ['class'=>'form-control'])!!}
																	</div>
																	<div class="form-group">
																			
																			{!!Form::submit(trans('x.Save'), ['class'=>'btn btn-danger'])!!}                                
																	</div>
															</div>
														</div>
													{!!Form::close()!!}
													</div>

												</div>
											</div>
											<!--end col-md-9-->
									</div>
								</div>
								<!--end tab-pane-->
							</div>
					</div>
				</div>
				<!-- END PAGE BASE CONTENT -->
			</div>
	</div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

{{-- MODALS --}}

@include('modals.customer.add_delivery')
@include('modals.customer.add_customer')

@stop