@extends('templated') 
@section('body')  
	<p class="lead"> 
        Resumen de Área
    </p>
    <div class="content">
		<dl>
			<dt>ID</dt>
			<dd>{{$header['id']}}</dd>
			<dt>AREA</dt>
			<dd>{{$header['nickname']}}</dd>
			<dt>CATEGORIA</dt>
			<dd>{{$header['categorie']}}</dd>
			<dt>ORIGEN</dt>
			<dd>{{$header['identifier_key']}}</dd>
			<sub><dt>REFERENCIA</dt><dd>{{$header['link']}}</dd></sub>		
			<dt>ESTADO ACTUAL</dt>
			<dd>{{$header['estado']}}</dd>
		</dl>   
	</div>
    <!--<a href="#" data-toggle="collapse" data-target="#body_area">Atributos del Área</a>
    <div id="body_area" class="collapse">


    </div>-->
    <div>
    	<table class="table">
    		<thead>
    			<tr>
    				<th style="text-align: center;">ID </th>
    				<th style="text-align: center;"> ATRIBUTO </th>
    				<th style="text-align: center;"> PUNTAJE MAXIMO </th>
    				<th style="text-align: center;"> NICKNAME </th>
    			</tr>
    		</thead>
    		<tbody>
    			@forelse( $body as $key => $item )
    				@if( $item['status'] != 1 )
	    			<tr>
	    				<!--<td>{{$item['id']}}</td>--><td style="text-align: center;">{{$key+1}}</td>
	    				<td style="text-align: center;">{{$item['atributo']}}</td>
	    				<td style="text-align: center;">{{$item['max_point']}}</td>
	    				<td style="text-align: center;">{{$item['nickname']}}</td>
	    			</tr>
	    			@endif
    			@empty
    				<tr>
    					<td colspan="4" style="text-align: right;">Sin Atributos Asignados..!</td>
    				</tr>
    			@endforelse
    		</tbody>
    	</table>
    </div>
@endsection