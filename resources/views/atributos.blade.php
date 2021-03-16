@extends('templated') 
@section('body')  
	<p class="lead"> 
        Atributos
    </p>
    <div class="content">
    	<form id="buscar_form">
    	<input type="" name="" style="width: 65%;border-radius: 8%;border-color: transparent;" placeholder="Buscar Atributo" id="parametro_buscar">
    	<button type="submit" class="btn btn-info pe-7s-search" id="boton_buscar"></button>
    	<button type="button" class="btn btn-primary pe-7s-pen" data-toggle="modal" data-target="#new_attribute"></button>
    	</form>
    	<label id="label_msg" style="color: #FF0000"></label>
    </div>  
    <div class="card" id="table_attribute" >
        <div class="content table-responsive table-full-width" style="overflow-x: hidden;">
	        <table class="table table-hover table-striped">
	        	<thead> 
	        		<tr style="text-align: center;">
			            <th style="color: #000000;width: 15%;"><strong>ID</strong></th>
			        	<th style="color: #000000;width: 20%;"><strong>FECHA</strong></th>
			        	<th style="color: #000000;width: 60%;"><strong>ATRIBUTO</strong></th>
			        	<td style="width: 2.5%;"></td><td style="width: 2.5%;"></td>
			        	<!-- <th style="color: #000000;width: 25%;"><strong>ESTADO</strong></th> -->
		        	</tr>
	            </thead>
	            <tbody>
            		@foreach( $atributos as $key => $atributo )
            		<tr>
            			<form class="form_edit_attribute" id="{{ $atributo['id'] }}">
            				<td >{{ $key+1 }}</td>
            				<td >{{ date('d-m-Y', strtotime($atributo['fecha'])) }}</td>
            				<td >
            					<input  type="" id="attribute{{$atributo['id']}}" name="attribute" value="{{$atributo['nombre']}}" class="form-control">
            				</td>
            				<td >
            					<input type="" id="atributo_id_edit{{$atributo['id']}}" name="atributo_id_edit" hidden="true" readonly="true" value="{{$atributo['id']}}">
		            			<button style="width: 90%;" type="submit" class="btn btn-success pe-7s-check"></button>
	            			</td>
	            		</form>	
	            		<td >
	            			<button style="width: 90%;" type="button" class="btn btn-warning pe-7s-trash send_id" id="e{{$atributo['id']}}" data-toggle="modal" data-target="#eliminar"></button>
	            		</td>
            		</tr>
            		@endforeach
	            </tbody>
	        </table>
	    </div>
	</div>
@endsection

<!-- #$#$#$#$#$#$#$#$ -->
<!-- #$#$#$#$#$#$#$#$ -->
<!-- #$#$#$#$#$#$#$#$ -->

<div class="modal" id="new_attribute">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		        <h4 class="modal-title">Nuevo Atributo<button type="button" class="close" data-dismiss="modal">&times;</button></h4>
	      	</div>
			<div class="modal-body">
		    	<form method="POST" action="{{ route('store_atributo') }}">@csrf
		    		<input type="" name="atributo" class="form-control" placeholder="Atributo...">
		    </div>
		    <div class="modal-footer">
		    	<button type="submit" class="btn btn-success">Añadir</button>
		    	</form>
		    	<button></button> type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		    </div>
		</div>
	</div>
</div> 
<!-- #$#$#$#$#$#$#$#$ -->
<div class="modal" id="eliminar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<h4 style="color: #9279D0;"><strong>Desea Eliminar Este Atributo ?</strong></h4>
		    	<form id="form_delete_attribute">
		    		<input type="" name="id" hidden="true" readonly="true" id="id_atributo">
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
<!-- #$#$#$#$#$#$#$#$ -->
<!-- #$#$#$#$#$#$#$#$ -->
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function () {
    	jQuery('.send_id').on( "click", function() {
    		var id = $(this).attr('id');
    		id = id.slice(1, 100)
    		$("#id_atributo").val( id ); //alert(id);
    	});
    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#form_delete_attribute').on('submit', function(e) {
			e.preventDefault(); 
			var url =  '{{ config('app.api_rest_url') }}'+'/atrribute/'+$("#id_atributo").val();
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
		if ( res['Attribute'] == 'Deleted') {
			$('#eliminar').modal('hide');
			//$("#table_attribute").load(" #table_attribute");
			location.reload();
		} 
		else if ( res['Attribute'] == 'Resource Not Found') {
			$('#label_msg').html("Atributo No Encontrado");
		}
	} 
</script>
<script type="text/javascript"> 
	$(document).ready(function () {
		$('.form_edit_attribute').on('submit', function(e) {
			e.preventDefault();
			var id = $('#atributo_id_edit'+$(this).attr('id')).val();
			var atributo = $('#attribute'+$(this).attr('id')).val();

			/*const data = JSON.stringify(Object.fromEntries(new FormData(e.target)));
			const data = Object.fromEntries(new FormData(e.target));
			console.log(data);*/

			var url =  '{{ config('app.api_rest_url') }}'+'/atrribute/'+id;
			var myHeader = '{{ base64_decode($_SESSION["tkn"]) }}';
			fetch(url, {
			  method: 'PATCH', 
			  headers: new Headers({
			  	'auth-tkn-pms': myHeader,
			  	'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
			  }),
			  body: 'attribute='+atributo
			}) 
			.then((res) => res.json())
			.then((res) => {
    			show_answer_edit(res);
  			})
		});
	});
	function show_answer_edit(res) { 
		if ( res['Attribute'] == 'Update') {
			//$("#table_attribute").load(" #table_attribute");
			location.reload();
		}
	}
</script>
<script type="text/javascript">
	$(document).ready(function () {
    	/*jQuery('#boton_buscar').click(function(e) {  
    		var p_b = $('#parametro_buscar').val();
			if ( p_b == '') {
				window.location='{{ route('attributes') }}';
			}
			else {
				window.location='{{ url('atributos') }}'+'/'+p_b;
			}
    	});*/
    	$('#buscar_form').on('submit', function(e) {
			e.preventDefault();
			var p_b = $('#parametro_buscar').val();
			if ( p_b == '') {
				window.location='{{ route('attributes') }}';
			}
			else {
				window.location='{{ url('atributos') }}'+'/'+p_b;
			}
		});
    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		sessionStorage.setItem('is_reloaded','50');
	});
</script>