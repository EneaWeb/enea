<!-- START BREADCRUMB -->
<ol class="breadcrumb">
	{{-- <li><a href="/">HOME</a></li> --}}
	<?php $before = ''; ?>
	@if (Request::url() !== Request::root())
		@foreach (explode('/',str_replace(Request::root().'/', '', Request::url())) as $k => $segment)
			<?php $this_segment = urldecode(str_replace('-',' ',$segment)); 
					$before .= '/'.$this_segment; ?>
			@if (strlen($this_segment) <= 16)
				<li><a href="{!!$before!!}">{!!$this_segment!!}</a></li>
			@endif
		@endforeach
	@endif
</ol>
<!-- END BREADCRUMB -->