@extends('templated')
@section('body') 
	<p class="lead">
        1era Fase de Evaluación
    </p> 
    <div class="container-fluid">
    	<div class="row">
    		<div class="col-md-2"></div>
    		<div class="col-md-8">
    			 <div class="card">
    			 	<div class="content">
                        <form method="POST" action="{{ route('evaluar_type') }}"> @csrf
                        	<div class="row">
                        		<div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de Evaluación</label>
                                        <select class="form-control" id="evaluation_type" name="type">
                                        	<option value="200xc">Selección Manual</option>
                                        	<option value="350ms">Selección Aleatoria</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" hidden="true" id="div_quantity">
                                    <div class="form-group">
                                        <label>Cantidad</label>
                                        <input type="" name="quantity" class="form-control">
                                    </div>
                                </div>
                        	</div>
                        	<div class="row">
                        		<div class="col-md-9"></div>
                        		<div class="col-md-2">
                        			<button type="submit" class="btn btn-success">Siguiente</button>
                        		</div>
                        	</div>
                        </form>
                    </div>
    			 </div>
    		</div>
    	</div>
    </div>
@endsection
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
	$(document).ready(function () {
		//console.log($("#evaluation_type option:selected").val());
		if ( $("#evaluation_type option:selected").val() == '350ms') {
    			$("#div_quantity").show();
    	}
    	$('#evaluation_type').change(function() {
    		var evaluation_type = $("#evaluation_type option:selected").val();
    		//console.log(evaluation_type);
    		if ( evaluation_type == '350ms') {
    			$("#div_quantity").show();
    		}
    		else if( evaluation_type == '200xc') {
    			$("#div_quantity").hide();
    		}
    	});
    });
</script>