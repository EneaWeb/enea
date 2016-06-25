@extends('layout.customizer.main')

@section('content')
{{ HTML::style('/assets/css/customizer.css') }} {{-- add some style --}}

<div style="display:none" id="pre-load-images">
@foreach (File::allFiles(public_path().'/assets/images/cinziaaraia_customizer/back/') as $file)
<img src="/assets/images/cinziaaraia_customizer/back/{!!$file->getFilename()!!}" style="height:1px; width:1px" />
@endforeach
@foreach (File::allFiles(public_path().'/assets/images/cinziaaraia_customizer/front/') as $file)
<img src="/assets/images/cinziaaraia_customizer/front/{!!$file->getFilename()!!}" style="height:1px; width:1px" />
@endforeach
</div>

<div class="content-frame">

{{--	1) TOMAIA UP
			3 MATERIALI - Pitone Stampato, Crosta, Pelle (come esempio su fogli)
			14 COLORI - #4 Pitoni, #5 Croste, #5 Pelli (come esempio su fogli)
		2) TOMAIA DOWN
			1 MATERIALE - Tessuto
			5 COLORI - Light Grey, Sand, Black, White, Military (come esempio su fogli)
		3) TACCO
			2 MATERIALI - Pelle, Crosta (come esempio su fogli)  // verificare
			10 COLORI - 5x Pelli, 5x Croste (come esempio su fogli)  // verificare
		4) SUOLA
			2 COLORI - Gesso, Military (come esempio su fogli)
		5) SCRITTA
		SI/NO
		6) LOGO
			2 COLORI - Black, White
--}}

{{-- START CONTENT FRAME LEFT --}}
<div class="content-frame-right">
   <div class="panel panel-default">
      <div class="panel-body" id="accordion">
		
			<div id="panel-headings">
			
				{{-- TOMAIA UP --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="TOMAIA U" data-placement="left" >
						<a class="mytoggle active" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-tomaiaup" aria-expanded="false" aria-controls="toggle-tomaiaup" id="headingTomaiaup">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				{{-- TOMAIA DOWN --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="TOMAIA D" data-placement="left" >
						<a class="mytoggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-tomaiadown" aria-expanded="false" aria-controls="toggle-tomaiadown" id="headingTomaiadown">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				{{-- TACCO --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="TACCO" data-placement="left" >
						<a class="mytoggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-tacco" aria-expanded="false" aria-controls="toggle-tacco" id="headingTacco">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				{{-- SUOLA --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="SUOLA" data-placement="left" >
						<a class="mytoggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-suola" aria-expanded="false" aria-controls="toggle-suola" id="headingSuola">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				{{-- SCRITTA --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="SCRITTA" data-placement="left" >
						<a class="mytoggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-scritta" aria-expanded="false" aria-controls="toggle-scritta" id="headingScritta">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				{{-- LOGO --}}
				<div class="pannello-heading" role="tab">
					<h4 class="pannello-title" data-tool="tooltip" title="LOGO" data-placement="left" >
						<a class="mytoggle" role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-logo" aria-expanded="false" aria-controls="toggle-logo" id="headingLogo">
							{{-- Titolo del pannello --}}
							<br>
						</a>
					</h4>
				</div>
				
			</div>
			
			<div class="pannello">
			
				{{-- TOMAIA UP --}}
				<div id="toggle-tomaiaup" class="pannello-collapse collapse in" role="tabpannello" aria-labelledby="headingTomaiaup">
					<div class="pannello-body" style="padding:10px">
						{{-- Corpo del pannello --}}
						<br>
						<h3 style="text-align:center">TOMAIA UP</h3>
						<br>
						<select name="type" class="form-control" id="material-select">
							<option value="sub-material-crosta">CROSTA</option>
							<option value="sub-material-pelle">PELLE</option>
							<option value="sub-material-pitone">PITONE STAMPATO</option>
						</select>
						<br><br>
						<div class="sub-material sub-material-crosta material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/crosta_black.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_crosta_black"
									data-tool="tooltip" title="CROSTA BLACK" data-title="CROSTA BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/crosta_alma.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_crosta_alma"
									data-tool="tooltip" title="CROSTA ALMA" data-title="CROSTA ALMA" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/crosta_angel.jpg');" 
									class="square change_tomaiaup square-selected" 
									id="tomaiaup_crosta_angel"
									data-tool="tooltip" title="CROSTA ANGEL" data-title="CROSTA ANGEL" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/crosta_marmo.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_crosta_marmo"
									data-tool="tooltip" title="CROSTA MARMO" data-title="CROSTA MARMO" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/crosta_pearl.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_crosta_pearl"
									data-tool="tooltip" title="CROSTA PEARL" data-title="CROSTA PEARL" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="sub-material sub-material-pelle material-pannello" style="display:none">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_black.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pelle_black"
									data-tool="tooltip" title="PELLE BLACK" data-title="PELLE BLACK" PELLE BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_white.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pelle_white"
									data-tool="tooltip" title="PELLE WHITE" data-title="PELLE WHITE" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_avion.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pelle_avion"
									data-tool="tooltip" title="PELLE AVION" data-title="PELLE AVION" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_sand.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pelle_sand"
									data-tool="tooltip" title="PELLE SAND" data-title="PELLE SAND" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_gesso.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pelle_gesso"
									data-tool="tooltip" title="PELLE GESSO" data-title="PELLE GESSO" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
						<div class="sub-material sub-material-pitone material-pannello" style="display:none">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pitone_black.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pitone_black"
									data-tool="tooltip" title="PITONE BLACK" data-title="PITONE BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pitone_ghost.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pitone_ghost"
									data-tool="tooltip" title="PITONE GHOST" data-title="PITONE GHOST" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pitone_alloy.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pitone_alloy"
									data-tool="tooltip" title="PITONE ALLOY" data-title="PITONE ALLOY" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pitone_sand.jpg');" 
									class="square change_tomaiaup" 
									id="tomaiaup_pitone_sand"
									data-tool="tooltip" title="PITONE SAND" data-title="PITONE SAND" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
					</div>
				</div>
				{{-- TOMAIA DOWN --}}
				<div id="toggle-tomaiadown" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingTomaiadown">
					<div class="pannello-body" style="padding:10px">
						{{-- Corpo del pannello --}}
						<br>
						<h3 style="text-align:center">TOMAIA DOWN</h3>
						<br>
						<div class="material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/tessuto_black.jpg');" 
									class="square change_tomaiadown square-selected" 
									id="tomaiadown_tessuto_black"
									data-tool="tooltip" title="TESSUTO BLACK" data-title="TESSUTO BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/tessuto_white.jpg');" 
									class="square change_tomaiadown" 
									id="tomaiadown_tessuto_white"
									data-tool="tooltip" title="TESSUTO WHITE" data-title="TESSUTO WHITE" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/tessuto_military.jpg');" 
									class="square change_tomaiadown" 
									id="tomaiadown_tessuto_military"
									data-tool="tooltip" title="TESSUTO MILITARY" data-title="TESSUTO MILITARY" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/tessuto_sand.jpg');" 
									class="square change_tomaiadown" 
									id="tomaiadown_tessuto_sand"
									data-tool="tooltip" title="TESSUTO SAND" data-title="TESSUTO SAND" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/tessuto_grey.jpg');" 
									class="square change_tomaiadown" 
									id="tomaiadown_tessuto_grey"
									data-tool="tooltip" title="TESSUTO GREY" data-title="TESSUTO GREY" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>

					</div>
				</div>
				{{-- TACCO --}}
				<div id="toggle-tacco" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingTacco">
					<div class="pannello-body" style="padding:10px">
						{{-- Corpo del pannello --}}
						<br>
						<h3 style="text-align:center">TACCO</h3>
						<br>
						<div class="material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_black.jpg');" 
									class="square change_tacco square-selected" 
									id="tacco_pelle_black" 
									data-tool="tooltip" title="PELLE BLACK" data-title="PELLE BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_white.jpg');" 
									class="square change_tacco" 
									id="tacco_pelle_white"
									data-tool="tooltip" title="PELLE WHITE" data-title="PELLE WHITE"data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_avion.jpg');" 
									class="square change_tacco" 
									id="tacco_pelle_avion"
									data-tool="tooltip" title="PELLE AVION" data-title="PELLE AVION" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_sand.jpg');" 
									class="square change_tacco" 
									id="tacco_pelle_sand"
									data-tool="tooltip" title="PELLE SAND" data-title="PELLE SAND" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/pelle_gesso.jpg');" 
									class="square change_tacco" 
									id="tacco_pelle_gesso"
									data-tool="tooltip" title="PELLE GESSO" data-title="PELLE GESSO" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
					</div>
				</div>
				{{-- SUOLA --}}
				<div id="toggle-suola" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingSuola">
					<div class="pannello-body" style="padding:10px">
						{{-- Corpo del pannello --}}
						<br>
						<h3 style="text-align:center">SUOLA</h3>
						<br>
						<div class="material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/suola_gesso.jpg');" 
									class="square change_suola square-selected" 
									id="suola_gesso"
									data-tool="tooltip" title="SUOLA GESSO" data-title="GESSO" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/suola_military.jpg');" 
									class="square change_suola" 
									id="suola_military"
									data-tool="tooltip" title="SUOLA MILITARY" data-title="MILITARY" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
					</div>
					</div>
				</div>
				{{-- SCRITTA --}}
				<div id="toggle-scritta" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingScritta">
					<div class="pannello-body" style="padding:10px">
						{{-- Corpo del pannello --}}
						<br>
						<h3 style="text-align:center">DON'T FORGET..</h3>
						<br>
						<div class="material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/scritta_white.jpg');" 
									class="square change_scritta square-selected" 
									id="scritta_white"
									data-tool="tooltip" title="SCRITTA WHITE" data-title="WHITE" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/scritta_black.jpg');" 
									class="square change_scritta" 
									id="scritta_black"
									data-tool="tooltip" title="SCRITTA BLACK" data-title="BLACK" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/scritta_none.jpg');" 
									class="square change_scritta" 
									id="scritta_none"
									data-tool="tooltip" title="NESSUNA SCRITTA" data-title="NESSUNA" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
						
					</div>
				</div>
				{{-- LOGO --}}
				<div id="toggle-logo" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingLogo">
					<div class="pannello-body" style="padding:10px">
						<br>
						<h3 style="text-align:center">LOGO</h3>
						<br>
						{{-- Corpo del pannello --}}
						<div class="material-pannello">
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/logo_white.jpg');" 
									class="square change_logo" 
									id="logo_white"
									data-tool="tooltip" title="LOGO WHITE" data-title="WHITE" data-placement="top" >
							</div>
							<div style="background:url('/assets/images/cinziaaraia_customizer/squares/logo_black.jpg');" 
									class="square change_logo square-selected" 
									id="logo_black"
									data-tool="tooltip" title="LOGO BLACK" data-title="BLACK" data-placement="top" >
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
       </div>
   </div>
   <div class="panel panel-default">
   	<div class="panel-body">
	   	<div class="pannello-body" style="padding:20px">
	   		<br>
	   		<h3 style="text-align:center">OPZIONE CREATA</h3>
	   		<p id="description-option">
	   			[TomaiaUp] <strong><span id="option-tomaiaup">CROSTA ANGEL</span></strong> 
	   			<br>[TomaiaDown] <strong><span id="option-tomaiadown">TESSUTO BLACK</span></strong> 
	   			<br>[Tacco] <strong><span id="option-tacco">PELLE BLACK</span></strong> 
	   			<br>[Suola] <strong><span id="option-suola">GESSO</span></strong> 
	   			<br>[Scritta] <strong><span id="option-scritta">WHITE</span></strong> 
	   			<br>[Logo] <strong><span id="option-logo">BLACK</span></strong>
	   		</p>
	   		<br>
	   		<btn class="btn btn-danger">Inserisci nell'ordine <span class="fa fa-shopping-cart"></span></btn>
	   		<br>
	   	</div>
	   </div>
   </div>
</div>
{{-- END CONTENT FRAME LEFT --}}

{{-- START CONTENT FRAME BODY --}}
<div class="content-frame-body content-frame-body-left" style="padding-top:0; display:none;>
   <div class="panel panel-default">
       <div class="panel-body">
       	<a href="#" id="rotation"><img src="/assets/images/cinziaaraia_customizer/rotate.png"/></a>
           	<div class="img-container" style="height:100vh;">
					<img src="/assets/images/cinziaaraia_customizer/front/shadow.png" id="shadow"/>
					<!-- <img src="/assets/images/cinziaaraia_customizer/scarpa_bg.png"/> -->
					<img src="/assets/images/cinziaaraia_customizer/front/tomaiaup_crosta_angel.png" id="tomaiaup"/>
					<img src="/assets/images/cinziaaraia_customizer/front/tomaiadown_tessuto_black.png" id="tomaiadown"/>
					<img src="/assets/images/cinziaaraia_customizer/front/tacco_pelle_black.png" id="tacco"/>
					<img src="/assets/images/cinziaaraia_customizer/front/suola_gesso.png" id="suola"/>
					<img src="/assets/images/cinziaaraia_customizer/front/scritta_white.png" id="scritta"/>
					<img src="/assets/images/cinziaaraia_customizer/front/logo_black.png" id="logo"/>
				</div>
       </div>
   </div>

</div>
{{-- END CONTENT FRAME BODY --}}
</div>

<script>

$(document).ready(function(){
	
	position = 'front';
	
	$('[data-tool="tooltip"]').tooltip(); 

	$('.content-frame-body').delay( 800 ).fadeIn( 999, function() {
    	// Animation complete
  	});;
  	
	$('#rotation').click(function(){
		var shadowHref = $('#shadow').attr('src');
		var tomaiaupHref = $('#tomaiaup').attr('src');
		var tomaiadownHref = $('#tomaiadown').attr('src');
		var taccoHref = $('#tacco').attr('src');
		var suolaHref = $('#suola').attr('src');
		var scrittaHref = $('#scritta').attr('src');
		var logoHref = $('#logo').attr('src');

		if (tomaiaupHref.indexOf('front') > -1) {
			
			window.position = 'back';
			
		   $('#shadow').fadeOut(20, function() {
				$('#shadow').attr("src", shadowHref.replace('front', 'back') );
				$('#shadow').fadeIn(600);
			});
			$('#tomaiaup').fadeOut(20, function() {
				$('#tomaiaup').attr("src", tomaiaupHref.replace('front', 'back') );
				$('#tomaiaup').fadeIn(600);
			});
			$('#tomaiadown').fadeOut(20, function() {
				$('#tomaiadown').attr("src", tomaiadownHref.replace('front', 'back') );
				$('#tomaiadown').fadeIn(600);
			});
			$('#tacco').fadeOut(20, function() {
				$('#tacco').attr("src", taccoHref.replace('front', 'back') );
				$('#tacco').fadeIn(600);
			});
			$('#suola').fadeOut(20, function() {
				$('#suola').attr("src", suolaHref.replace('front', 'back') );
				$('#suola').fadeIn(600);
			});
			$('#scritta').fadeOut(20, function() {
				$('#scritta').attr("src", scrittaHref.replace('front', 'back') );
				$('#scritta').fadeIn(600);
			});
			$('#logo').fadeOut(20, function() {
				$('#logo').attr("src", logoHref.replace('front', 'back') );
				$('#logo').fadeIn(600);
			});
		}
		if (tomaiaupHref.indexOf('back') > -1) {
			
			window.position = 'front';
			
		   $('#shadow').fadeOut(20, function() {
				$('#shadow').attr("src", shadowHref.replace('back', 'front') );
				$('#shadow').fadeIn(600);
			});
			$('#tomaiaup').fadeOut(20, function() {
				$('#tomaiaup').attr("src", tomaiaupHref.replace('back', 'front') );
				$('#tomaiaup').fadeIn(600);
			});
			$('#tomaiadown').fadeOut(20, function() {
				$('#tomaiadown').attr("src", tomaiadownHref.replace('back', 'front') );
				$('#tomaiadown').fadeIn(600);
			});
			$('#tacco').fadeOut(20, function() {
				$('#tacco').attr("src", taccoHref.replace('back', 'front') );
				$('#tacco').fadeIn(600);
			});
			$('#suola').fadeOut(20, function() {
				$('#suola').attr("src", suolaHref.replace('back', 'front') );
				$('#suola').fadeIn(600);
			});
			$('#scritta').fadeOut(20, function() {
				$('#scritta').attr("src", scrittaHref.replace('back', 'front') );
				$('#scritta').fadeIn(600);
			});
			$('#logo').fadeOut(20, function() {
				$('#logo').attr("src", logoHref.replace('back', 'front') );
				$('#logo').fadeIn(600);
			});
		}
	});

	$('.mytoggle').click(function(e){
		e.preventDefault();
		$('.pannello-collapse').hide();
		$('.mytoggle').removeClass('active');
		$(this).addClass('active');
		id = $(this).attr('href');
		$(id).fadeToggle();
		return false;
	});
	
	$('#material-select').change(function(e){
		e.preventDefault();
		$('.sub-material').hide();
		classe = $( "#material-select option:selected" ).attr('value');
		$('.'+(classe)).fadeToggle();
		return false;
	});

	$('.change_tomaiaup').click(function(){
		// red border
		$('.change_tomaiaup').removeClass('square-selected');	$(this).addClass('square-selected');

		// change description
		title = $(this).data('title');
		$('#option-tomaiaup').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#tomaiaup').fadeOut(20, function() {
			$('#tomaiaup').attr("src", idToSRC );
			$('#tomaiaup').fadeIn(600);
		});
	});
	
	$('.change_tomaiadown').click(function(){
		// red border
		$('.change_tomaiadown').removeClass('square-selected');	$(this).addClass('square-selected');
		
		// change description
		title = $(this).data('title');
		$('#option-tomaiadown').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#tomaiadown').fadeOut(20, function() {
			$('#tomaiadown').attr("src", idToSRC );
			$('#tomaiadown').fadeIn(600);
		});
	});
	
	$('.change_tacco').click(function(){
		// red border
		$('.change_tacco').removeClass('square-selected');	$(this).addClass('square-selected');
		
		// change description
		title = $(this).data('title');
		$('#option-tacco').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#tacco').fadeOut(300, function() {
			$('#tacco').attr("src", idToSRC );
			$('#tacco').fadeIn(300);
		});
	});
	
	$('.change_suola').click(function(){
		// red border
		$('.change_suola').removeClass('square-selected');	$(this).addClass('square-selected');
		
		// change description
		title = $(this).data('title');
		$('#option-suola').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#suola').fadeOut(300, function() {
			$('#suola').attr("src", idToSRC );
			$('#suola').fadeIn(300);
		});
	});
	
	$('.change_scritta').click(function(){
		// red border
		$('.change_scritta').removeClass('square-selected');	$(this).addClass('square-selected');
		
		// change description
		title = $(this).data('title');
		$('#option-scritta').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#scritta').fadeOut(300, function() {
			$('#scritta').attr("src", idToSRC );
			$('#scritta').fadeIn(300);
		});
	});
	
	$('.change_logo').click(function(){
		// red border
		$('.change_logo').removeClass('square-selected');	$(this).addClass('square-selected');
		
		// change description
		title = $(this).data('title');
		$('#option-logo').text(title);
		
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+position+'/'+ this.id +'.png';
	   $('#logo').fadeOut(300, function() {
			$('#logo').attr("src", idToSRC );
			$('#logo').fadeIn(300);
		});
	});
	

});
</script>


@stop