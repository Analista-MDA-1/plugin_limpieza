@extends('templated')
@section('body') 
	<p class="lead">
        Nueva Area
    </p>
    <div class="content"> 
    	<form method="POST" action="{{route('store_header_area')}}">@csrf
    		<select class="form-control" name="ref_id_categorie">
    			<option value="nix" style="color: #0000FF;">Seleccionar Categoría</option>
                @foreach( $datos['categorias'] as $categoria)
                    <option value="{{$categoria['id']}}">{{$categoria['categoria']}}</option>
                @endforeach
    		</select>
    		<select class="form-control" id="fuente_area" name="fuente_area">
    			<option value="nix" style="color: #0000FF;">Fuente de Area</option>
    			<option value="1">Propia</option>
    			<option value="2">PMS o Externo</option>
    		</select>
    		<select class="form-control" style="display: none;"  id="area_externa" name="area_externa">
    			<option value="nix" style="color: #0000FF;">Area Externa</option>
    		</select>
    		<input type="" name="nickname" class="form-control" placeholder="Apodo o Identificador del Area">
		    <select class="form-control" name="statu_area">
		    	<option value="nix" style="color: #0000FF;">Seleccionar Estado Area</option>
                <option value="1">Disponible</option>
                <option value="2">En Uso</option>
                <option value="3">Sucia</option>
                <option value="4">Deshabilitada</option>
		    </select>
		    <br>
		    <button type="reset" class="btn btn-dark">Deshacer</button>
		    <button type="submit" class="btn btn-success">Añadir</button>
    	</form> 
    </div> 
@endsection
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#fuente_area").change(function() { 
            if ( $( "#fuente_area option:selected" ).val() == 2) { 
                $('#area_externa').show();
            }
            else {
                $('#area_externa').hide();
            }
        });
    });
</script> 
<script type="text/javascript">
    $(document).ready(function () {
        sessionStorage.setItem('is_reloaded','50');
    });
</script>