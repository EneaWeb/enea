@extends('layout.customizer.main')

@section('content')
{{ HTML::style('/assets/css/customizer.css') }} {{-- add some style --}}

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
			
				<div id="panel-headings" style="position:absolute; margin-left:-54px">
				
					<div class="pannello-heading" role="tab">
						<h4 class="pannello-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-tomaiaup" aria-expanded="true" aria-controls="toggle-tomaiaup" style="background-color:#8d0000" id="headingOne">
								{{-- Titolo del pannello --}}
								<br>
							</a>
						</h4>
					</div>
					<div class="pannello-heading" role="tab">
						<h4 class="pannello-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#toggle-tomaiadown" aria-expanded="true" aria-controls="toggle-tomaiadown" style="background-color:#8d0000" id="headingTwo">
								{{-- Titolo del pannello --}}
								<br>
							</a>
						</h4>
					</div>
				</div>
				
				<div class="pannello">
				
					<div id="toggle-tomaiaup" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingOne">
						<div class="pannello-body" style="padding:10px">
							{{-- Corpo del pannello --}}
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
						</div>
					</div>
					
					<div id="toggle-tomaiadown" class="pannello-collapse collapse" role="tabpannello" aria-labelledby="headingOne">
						<div class="pannello-body" style="padding:10px">
							{{-- Corpo del pannello --}}
							<p>asfasfasfasf</p>
						</div>
					</div>
				</div>
			{{-- end of pannello --}}
			{{-- end of #accordion --}}

					<button class="change_01" id="01b">01 rosso</button>
					<button class="change_02" id="02b">02 rosso</button>
					<button class="change_03" id="03b">03 rosso</button>
					<button class="change_04" id="04b">04 rosso</button>

					<br><br>

					<button class="change_01" id="01c">01 blu</button>
					<button class="change_02" id="02c">02 blu</button>
					<button class="change_03" id="03c">03 blu</button>
					<button class="change_04" id="04c">04 blu</button>

					<br><br>

					<button class="change_01" id="01d">01 verde</button>
					<button class="change_02" id="02d">02 verde</button>
					<button class="change_03" id="03d">03 verde</button>
					<button class="change_04" id="04d">04 verde</button>
					
					
					
					
       </div>
   </div>
</div>
{{-- END CONTENT FRAME LEFT --}}

{{-- START CONTENT FRAME BODY --}}
<div class="content-frame-body content-frame-body-left" style="padding-top:0; display:none;>
   <div class="panel panel-default">
       <div class="panel-body">
           	<div class="img-container" style="height:100vh;">
					<img src="/assets/images/cinziaaraia_customizer/shadow.png"/>
					<img src="/assets/images/cinziaaraia_customizer/scarpa_bg.png"/>
					<img src="/assets/images/cinziaaraia_customizer/front_tomaiaup_crosta_angel.png" id="tomaiaup"/>
					<img src="/assets/images/cinziaaraia_customizer/front_tomaiadown_black.png" id="tomaiadown"/>
					<img src="/assets/images/cinziaaraia_customizer/front_tacco_black.png" id="tacco"/>
					<img src="/assets/images/cinziaaraia_customizer/front_scritta_white.png" id="scritta"/>
					<img src="/assets/images/cinziaaraia_customizer/front_logo_black.png" id="logo"/>
				</div>
       </div>
   </div>

</div>
{{-- END CONTENT FRAME BODY --}}
</div>

<script>

$(document).ready(function(){
	
	$('.content-frame-body').delay( 800 ).fadeIn( 999, function() {
    	// Animation complete
  	});;	

  $('.collapse.in').prev('.pannello-heading').addClass('active');
  $('#accordion, #bs-collapse')
    .on('show.bs.collapse', function(a) {
      $(a.target).prev('.pannello-heading').addClass('active');
    })
    .on('hide.bs.collapse', function(a) {
      $(a.target).prev('.pannello-heading').removeClass('active');
    });


    $('#one').fadeOut(500, function() {
        $('#one').attr("src","/newImage.png");
        $('#one').fadeIn(500);
    });


	$('.change_01').click(function(){
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+ this.id +'.png';
	   $('#_01').fadeOut(200, function() {
			$('#_01').attr("src", idToSRC );
			$('#_01').fadeIn(400);
		});
	});
	
	$('.change_02').click(function(){
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+ this.id +'.png';
	   $('#_02').fadeOut(200, function() {
			$('#_02').attr("src", idToSRC );
			$('#_02').fadeIn(400);
		});
	});
	
	$('.change_03').click(function(){
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+ this.id +'.png';
	   $('#_03').fadeOut(200, function() {
			$('#_03').attr("src", idToSRC );
			$('#_03').fadeIn(400);
		});
	});
	
	$('.change_04').click(function(){
	   var idToSRC = '/assets/images/cinziaaraia_customizer/'+ this.id +'.png';
	   $('#_04').fadeOut(200, function() {
			$('#_04').attr("src", idToSRC );
			$('#_04').fadeIn(400);
		});
	});

});
</script>


@stop