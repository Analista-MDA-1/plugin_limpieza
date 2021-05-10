@extends('templated') 
@section('body')  
	<p class="lead"> 
        Gestión de Área
    </p>
    <div class="content">
	    <form>
	    	<input type="" name="" class="form-control" placeholder="Apodo o Identificador del Area" value="{{$header['nickname']}}">
	    	<select class="form-control">  
	    		@forelse( $categorias as $categoria)
	    			<option value="{{ $categoria['id'] }}">{{ $categoria['categorie'] }}</option>
	    		@empty
	    			<option value="nix">No Hay Categorías Guardadas</option>
	    		@endforelse
	    	</select>
	    	<select class="form-control">
    			@if( $header['identifier_key'] ==  'Propio' )
    				<option value="1">Propio</option>
    				<option value="2">PMS-Externo</option>
    			@elseif( $header['identifier_key'] ==  'Externo' )
    				<option value="2">PMS-Externo</option>
    				<option value="1">Propio</option>
    			@endif
    		</select>
    		<select class="form-control">
		    	@if( $header['estado'] ==  'Disponible' )
		    		<option value="1">{{$header['estado']}}</option>
		    		<option value="2">En Uso</option>
		    		<option value="3">Sucia</option>
		    		<option value="4">Deshabilitada</option>
		    	@elseif( $header['estado'] ==  'En Uso' )
		    		<option value="2">{{$header['estado']}}</option>
		    		<option value="3">Sucia</option>
		    		<option value="4">Deshabilitada</option>
		    		<option value="1">Disponible</option>
		    	@elseif( $header['estado'] ==  'Sucia' )
		    		<option value="3">{{$header['estado']}}</option>
		    		<option value="2">En Uso</option>
		    		<option value="4">Deshabilitada</option>
		    		<option value="1">Disponible</option>
		    	@elseif( $header['estado'] ==  'Deshabilitada' )
		    		<option value="4">{{$header['estado']}}</option>
		    		<option value="3">Sucia</option>
		    		<option value="1">Disponible</option>
		    		<option value="2">En Uso</option>
		    	@endif
		    </select>
		    <button class="btn btn-success">Editar</button>
	    </form>
	</div>
    <a href="#" data-toggle="collapse" data-target="#body_area">Atributos del Área</a>
    <div id="body_area" class="collapse">
    
	    <div class="card" style="overflow: hidden;">
	    	<div class="content table-responsive table-full-width">
	    		<table class="table table-hover table-striped">
	    			<thead>
	    				<tr>
	    					<th style="color: #000000;width: 5%;text-align: center;"><strong>ID</strong></th>
	    					<th style="color: #000000;width: 25%;text-align: center;"><strong>ATRIBUTO</strong></th>
	    					<th style="color: #000000;width: 25%;text-align: center;"><strong>MAX PUNTAJE</strong></th>
	    					<th style="color: #000000;width: 25%;text-align: center;"><strong>NICKNAME</strong></th>
	    				</tr>
	    			</thead>
	    			<tbody>
	    				@forelse ( $body as $key => $line )
	    					<tr>
		    					<form class="form_edit_body_area" id="{{ $line['id'] }}">
		    					<td style="color: #000000;text-align: center;">
		    						{{ $key+1 }}
		    						<input type="" name="id" hidden="true" readonly="true" value="{{ $line['id'] }}" id="body_id{{ $line['id'] }}">
		    					</td>
		    					<td style="color: #000000;text-align: center;">{{ $line['atributo'] }}</td>
		    					<td style="color: #000000;text-align: center;">
		    						<input type="number" name="max_point" value="{{ $line['max_point'] }}" style="text-align: center;" id="point_id{{ $line['id'] }}" step="0.001">
		    					</td>
		    					<td style="color: #000000;text-align: center;">
		    						<input type="" name="nickname" value="{{ $line['nickname'] }}" style="text-align: center;" id="apodo_id{{ $line['id'] }}">
		    					</td>
		    					<td><button type="submit" class="btn btn-success pe-7s-check"></button></td>
		    					<td><button type="button" class="btn btn-warning pe-7s-trash send_id" data-toggle="modal" data-target="#eliminar" id="a{{ $line['id'] }}"></button></td>
		    					</form>  
	    					</tr>
	    				@empty
	    					<tr>
	    						<td colspan="5" style="text-align: right;color: #FF0000">No hay Atributos Asignados..!</td>
	    					</tr>
	    				@endforelse
	    			</tbody>
	    		</table>
	    	</div>
	    </div>
	    <br>
	    <div class="content">
	    	<form method="POST" action="{{ route('store_body') }}"> @csrf
	    		<div class="row">
	    			<div class="col-md-4">
	    				<select class="form-control" name="ref_id_attribute">
	    					<option value="nix">Seleccionar Atributo</option>
	    					@forelse ( $atributos as $atributo )
	    						<option value="{{ $atributo['id'] }}">{{ $atributo['attribute'] }}</option>
	    					@empty
	    						<option value="nix">No Hay Atributos Guardados</option>
	    					@endforelse
	    				</select>
	    			</div>
	    			<div class="col-md-4">
	    				<input type="number" name="max_point" class="form-control" placeholder="Máximo Puntaje" step="0.001">
	    			</div>
	    			<div class="col-md-4">
	    				<input type="" name="nickname" class="form-control" placeholder="Nickname">
	    			</div>
	    			<input type="" name="ref_id_header" hidden="true" readonly="true" value="{{$id_header}}">
	    		</div> 
	    		<button type="submit" hidden="true"></button>
	    	</form>
	    </div>

    </div>
@endsection
<!-- #$#$#$#$#$#$#$#$ -->
<div class="modal" id="eliminar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 style="color: #9279D0;"><strong>Desea Eliminar Este Atributo Asignado ?</strong></h4>
		    	<form id="form_delete_attribute_asign">
		    		<input type="" name="id" hidden="true" readonly="true" id="id_atributo_asignado">
		    </div>
		    <div class="modal-footer">
		    	<button type="submit" class="btn btn-success">Eliminar</button>
		    	</form>
		    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		    </div>
		</div>
	</div>
</div>
<!-- #$#$#$#$#$#$#$#$ -->
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function () {  
		var is_reloaded = JSON.parse(sessionStorage.getItem('is_reloaded'));
		if ( is_reloaded == 100 ) {
			$('#body_area').collapse();
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function () {
    	jQuery('.send_id').on( "click", function() { 
    		var id = $(this).attr('id');
    		id = id.slice(1, 100);
    		$("#id_atributo_asignado").val( id ); 
    	});
    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#form_delete_attribute_asign').on('submit', function(e) {
			e.preventDefault(); 
			var url =  '{{ config('app.api_rest_url') }}'+'/area_attribute/'+$("#id_atributo_asignado").val();
			var myHeader = '{{ base64_decode($_SESSION["tkn"]) }}';
			fetch(url, {
			  method: 'DELETE',
			  headers: new Headers({'auth-tkn-pms': myHeader}),
			}) 
			.then((response) => response.json())
			.then((response) => {
    			show_answer_delete(response);
  			})
		});
	});
	function show_answer_delete(res) {
		if ( res['Body_Area'] == 'Deleted') {
			$('#eliminar').modal('hide');
			sessionStorage.setItem('is_reloaded','100');
			location.reload();
		} 
		else if ( res['Body_Area'] == 'Resource Not Found') {
			$('#label_msg').html("Atributo Asignado No Encontrado");
		}
	} 
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.form_edit_body_area').on('submit', function(e) {
			e.preventDefault();
			var id = $('#body_id'+$(this).attr('id')).val();
			var puntaje = $('#point_id'+$(this).attr('id')).val();
			var apodo = $('#apodo_id'+$(this).attr('id')).val();

			var url =  '{{ config('app.api_rest_url') }}'+'/area_attribute/'+id;
			var myHeader = '{{ base64_decode($_SESSION["tkn"]) }}';
			fetch(url, {
			  method: 'PATCH', 
			  headers: new Headers({
			  	'auth-tkn-pms': myHeader,
			  	'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
			  }),
			  body: 'max_point='+puntaje+'&&nickname='+apodo
			}) 
			.then((res) => res.json())
			.then((res) => {
    			show_answer_edit(res);
  			})
		});
	});
	function show_answer_edit(res) { 
		if ( res['Body_Area'] == 'Update') {
			sessionStorage.setItem('is_reloaded','100');
			location.reload();
		}
	}
</script>