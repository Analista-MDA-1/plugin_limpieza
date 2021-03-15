@extends('templated') 
@section('body') 
	<p class="lead"> 
        Categorías
    </p>
        <div class="content">
    	<form id="buscar_form">
        	<input type="" name="" style="width: 65%;border-radius: 8%;border-color: transparent;" placeholder="Buscar Categoría" id="parametro_buscar">
        	<button type="submit" class="btn btn-info pe-7s-search"></button>
        	<button type="button" class="btn btn-primary pe-7s-pen" data-toggle="modal" data-target="#new_categorie"></button>
    	</form> 
    </div>
    <div class="card" id="table_attribute" >
        <div class="content table-responsive table-full-width" style="overflow-x: hidden;">
	        <table class="table table-hover table-striped">
	        	<thead> 
	        		<tr>
			            <th style="color: #000000;width: 10%;"><strong>ID</strong></th>
			        	<th style="color: #000000;width: 15%;"><strong>CATEGORIA</strong></th>
			        	<th style="color: #000000;width: 25%;"><strong>DESCRIPCION</strong></th>
		        	</tr>
	            </thead>
	            <tbody>
            		@foreach( $categorias as $key => $categoria )
            		<tr>
            			<form class="form_edit_attribute" id="{{ $categoria['id'] }}">
            				<td >{{ $key+1 }}</td>
            				<td>
            					<input  type="" id="categoria{{$categoria['id']}}" name="attribute" value="{{$categoria['categorie']}}" class="form-control">
            				</td>
            				<td>
            					<input type="" name="attribute" value="{{$categoria['description']}}" class="form-control" id="descripcion{{$categoria['id']}}">
            				</td>
            				<td >
            					<input type="" id="atributo_id_edit{{$categoria['id']}}" name="atributo_id_edit" hidden="true" readonly="true" value="{{$categoria['id']}}">
		            			<button style="width: 90%;" type="submit" class="btn btn-success pe-7s-check"></button>
	            			</td>
	            		</form>	
	            		<td >
	            			<button style="width: 90%;" type="button" class="btn btn-warning pe-7s-trash send_id" id="e{{$categoria['id']}}" data-toggle="modal" data-target="#eliminar"></button>
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

<div class="modal" id="new_categorie">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		        <h4 class="modal-title">Nueva Categoría<button type="button" class="close" data-dismiss="modal">&times;</button></h4>
	      	</div>
			<div class="modal-body">
		    	<form method="POST" action="{{ route('store_categoria') }}">@csrf
		    		<input type="" name="categoria" class="form-control" placeholder="Categoría...">
		    		<textarea class="form-control" placeholder="Descripción" name="descripcion"></textarea>
		    </div>
		    <div class="modal-footer">
		    	<button type="submit" class="btn btn-success">Añadir</button>
		    	</form>
		    	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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
			var url =  '{{ config('app.api_rest_url') }}'+'/categorie/'+$("#id_atributo").val();
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
		if ( res['Categorie'] == 'Deleted') {
			$('#eliminar').modal('hide');
			//$("#table_attribute").load(" #table_attribute");
			location.reload();
		} 
		else if ( res['Categorie'] == 'Resource Not Found') {
			$('#label_msg').html("Categoría No Encontrado");
		}
	} 
</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('.form_edit_attribute').on('submit', function(e) {
			e.preventDefault();
			var id = $('#atributo_id_edit'+$(this).attr('id')).val();
			var categoria = $('#categoria'+$(this).attr('id')).val();
			var descripcion = $('#descripcion'+$(this).attr('id')).val();
			/*const data = JSON.stringify(Object.fromEntries(new FormData(e.target)));
			const data = Object.fromEntries(new FormData(e.target));
			console.log(data);*/

			var url =  '{{ config('app.api_rest_url') }}'+'/categorie/'+id;
			var myHeader = '{{ base64_decode($_SESSION["tkn"]) }}';
			fetch(url, {
			  method: 'PATCH', 
			  headers: new Headers({
			  	'auth-tkn-pms': myHeader,
			  	'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
			  }),
			  body: 'categorie='+categoria+'&&description='+descripcion
			}) 
			.then((res) => res.json())
			.then((res) => {
    			show_answer_edit(res);
  			})
		});
	});
	function show_answer_edit(res) { 
		if ( res['Categorie'] == 'Update') {
			//$("#table_attribute").load(" #table_attribute");
			location.reload();
		}
	}
</script>
<!-- #$$#$#$#$#$#$#$#43 -->
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
				window.location='{{ route('categories') }}';
			}
			else {
				window.location='{{ url('categorias') }}'+'/'+p_b;
			}
		});
    });
</script>
<script type="text/javascript">
	$(document).ready(function () {
		sessionStorage.setItem('is_reloaded','50');
	});
</script>