@extends('templated')
@section('body') 
	<p class="lead">
        Areas
    </p> 
    <div class="content">
    	<form id="buscar_form"> 
        	<input type="" name="" style="width: 65%;border-radius: 8%;border-color: transparent;" placeholder="Buscar Area" id="parametro_buscar">
        	<button type="submit" class="btn btn-info pe-7s-search"></button>
    	</form> 
    </div>
    <div class="card" style="overflow: hidden;">
        <div class="content table-responsive table-full-width">
	        <table class="table table-hover table-striped">
	        	<thead>
	        		<tr>
			            <th style="color: #000000;width: 10%;text-align: center;"><strong>ID</strong></th>
			        	<th style="color: #000000;width: 20%;"><strong>CATEGORIA</strong></th>
			        	<th style="color: #000000;width: 15%;text-align: center;"><strong>TIPO</strong></th>
			        	<th style="color: #000000;width: 20%;text-align: center;"><strong>NICKNAME</strong></th>
			        	<th style="color: #000000;width: 20%;"><strong>ESTADO AREA</strong></th>
		        	</tr>
	            </thead>
	            <tbody>
	            	@foreach( $areas as $key => $area )
    					<tr>
    						<form>
			            		<td style="width: 10%;text-align: center;">{{ $key+1 }}</td>
			            		<td style="width: 20%;">{{ $area['categoria'] }}</td>
			            		<td style="width: 15%;text-align: center;">{{ $area['tipo'] }}</td>
			            		<td style="width: 20%;text-align: center;">{{ $area['nickname'] }}</td>
			            		<td style="width: 20%;">{{ $area['estado'] }}</td>
			            		<td style="width: 5%;" >
			            			<a href="{{ route('ver_area', $area['id'])}}" class="btn btn-info pe-7s-look"></a>
			            		</td>
			            		<td style="width: 5%;">
			            			<a href="{{ route('gestionar_area', $area['id'])}}" class="btn btn-success pe-7s-note"></a>
			            		</td>
			            		<td style="width: 5%;" >
			            			<button type="button" class="btn btn-warning pe-7s-trash send_id" id="c{{$area['id']}}" data-toggle="modal" data-target="#eliminar"></button>
			            		</td>
		            		</form>		
    					</tr>
	    			@endforeach
	            </tbody>
	        </table>
	    </div>
	</div>
@endsection
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#buscar_form').on('submit', function(e) {
			e.preventDefault();
			var p_b = $('#parametro_buscar').val();
			if ( p_b == '') {
				window.location='{{ route('ver_areas') }}';
			}
			else {
				window.location='{{ url('ver_areas') }}'+'/'+p_b;
			}
		});
	});
</script>
<!-- #$#$#$#$#$#$#$#$ -->
<div class="modal" id="eliminar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 style="color: #9279D0;"><strong>Desea Eliminar Esta Area ?</strong></h4>
		    	<form id="form_delete_categorie">
		    		<input type="" hidden="true" name="id"  readonly="true" id="id_area">
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
<script type="text/javascript">
	$(document).ready(function () {
    	jQuery('.send_id').on( "click", function() {
    		var id = $(this).attr('id');
    		id = id.slice(1, 100)
    		$("#id_area").val( id );
    	});
    });
</script>
<!-- #$#$#$#$#$#$#$#$ -->
<script type="text/javascript">
	$(document).ready(function () {
		$('#form_delete_categorie').on('submit', function(e) {
			e.preventDefault(); 
			var url =  '{{ config('app.api_rest_url') }}'+'/area/'+$("#id_area").val();
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
		if ( res['Area'] == 'Deleted') {
			$('#eliminar').modal('hide');
			//$("#table_attribute").load(" #table_attribute");
			location.reload();
		} 
		else if ( res['Area'] == 'Resource Not Found') {
			$('#label_msg').html("Area No Encontrado");
		}
	} 
</script>
<script type="text/javascript">
	$(document).ready(function () {
		sessionStorage.setItem('is_reloaded','50');
	});
</script>