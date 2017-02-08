@extends('layout.main')

@section('content')

<!-- BEGIN SIDEBAR CONTENT LAYOUT -->
<div class="page-content-container">
   <div class="page-content-row">
        <!-- BEGIN PAGE SIDEBAR -->

            @include('sidebars.catalogue')

            @include('pages.catalogue._products_gallery')

    </div>
</div>
<!-- END SIDEBAR CONTENT LAYOUT -->

@stop