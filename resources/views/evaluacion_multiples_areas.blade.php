@extends('templated')
<!-- MODALS -->
    <div class="modal" id="modal_evaluacion" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Puntuación de Habitación</h5>
                    <button type="button" class="close" data-dismiss="modal" ><span aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm" id="table_atrr">
                        <thead>
                            <tr>
                                <th>Atributo</th>
                                <th>Puntaje</th>
                            </tr>
                        </thead>
                        <tbody id="t_body_atrr">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<!-- END MODALS -->
@section('body') 
	<p class="lead">
        Evaluación
    </p> 
    <div class="container-fluid">
        <!--<style type="text/css">
            .modal-backdrop{
                position: relative; 
            }
        </style>-->
    	<div class="row">
    		<div class="col-md-2"></div>
    		<div class="col-md-8">
    			<div class="card">
    			 	<div class="content"> 
                        <div class="content">
                            <form>
                                <label class="label" style="float: left;">Fecha</label>
                                <label class="label" style="float: right;">Usuario</label>
                                <br>
                                <textarea class="form-control" placeholder="Comentarios Pre Revisión"></textarea>
                            </form>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Area</th>
                                    <th>NickName</th>
                                    <th>Puntaje Actual</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse( $datos['aleat_areas'] as $key => $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item['nickname']}}</td>
                                    <td>{{$item['id']}}</td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" data-toggle="modal" data-target="#modal_evaluacion" class="btn btn-primary btn-sm attribute_admin" id="att_ad{{$item['id']}}"><i class="pe-7s-news-paper"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm"><i class="pe-7s-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        <form>
                            <div class="row">
                                <div class="col">  
                                    <label>Añadir Area</label>
                                    <select class="form-control">
                                        @forelse( $datos['todas_areas'] as $key => $item)
                                            <option id="{{$item['nickname']}}">{{$item['nickname']}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col">
                                    <button class="btn btn-success">-></button>
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
    $(document).ready(function() { 
        $('.attribute_admin').click(function() {  
            $("#table_atrr > tbody").empty();
            var id_area = $(this).attr("id").slice(6); 
            var atributos = @json($datos['atributos']);//console.log(atributos);
            for (var i = atributos.length - 1; i >= 0; i--) { 
                if ( atributos[i]['ref_id_header'] == id_area) {
                    var tr = '<tr>';
                    tr += '<td>'; 
                    tr += atributos[i]['nickname'];
                    tr += '</td><td>'; 
                    //tr += "<input type='number' onchange='max_ptn();' step='0.1'  min='0' max='"+atributos[i]['max_point']+"'>";
                    tr += "<input type='number' onchange='max_ptn("+[i]+");' id='at_in"+[i]+"'  step='0.1'  min='0'" +"max='"+atributos[i]['max_point']+"'>";
                    tr += '</td></tr>'; 
                    $("#t_body_atrr").append(tr);
                }
            }
        });
    });
    function max_ptn(id) {
        value = $('#at_in'+id).val();
        max= $('#at_in'+id).attr("max"); 
        if ( value > max) {
            $('#at_in'+id).val(max);
        }
    }
</script>