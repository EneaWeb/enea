<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Input;
use App\Http\Requests;

class CustomizerController extends Controller
{
	public function index()
	{
		/*
		1) TOMAIA UP
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
		*/
			
		$varianti = [
			'tomaia_up' => [
				'materiale' => [
					'pitone' => [
						'colore' => [
							'ghost',
							'alloy',
							'deset',
							'black'
						]
					],
					'crosta' => [
						'colore' => [
							'nome_1',
							'nome_2',
							'nome_3',
							'nome_4',
							'nome_5'
						]
					],
					'pelle' => [
						'colore' => [
							'black',
							'plaster',
							'white',
							'avion',
							'sand'
						]
					]
				]
			],
			
			'tomaia_down' => [
				'materiale' => [
					'tessuto' => [
						'colore' => [
							'light_grey',
							'sand',
							'black',
							'white',
							'military'
						]
					]
				]
			],			
			
			'tacco' => [
				'materiale' => [
					'crosta'  => [
						'colore' => [
							'nome_1',
							'nome_2',
							'nome_3',
							'nome_4',
							'nome_5'
						]
					]
				]
			],
			
			'suola' => [
				'colore' => [
					'gesso',
					'military'
				]
			],
			
			'scritta' => [
				'si',
				'no'
			],
			
			'logo' => [
				'black',
				'white'
			]
		];
		
		$page_title = 'Cinzia Araia Customizer';
		return view('customizer.cinziaaraia', compact('varianti', 'page_title'));
	}
}
