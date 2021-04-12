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
                    <button type="button" class="btn btn-primary">Guardar Puntajes</button>
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
                                <label class="label" style="float: left; color: #4784e8;">Fecha <strong>{{ date("d-m-Y g:i a", strtotime($datos['header']['date'])) }}</strong></label>
                                <label class="label" style="float: right;color: #4784e8;">Usuario <strong>{{$config['username']}}</strong></label>
                                <br>
                                <input type="" name="id" hidden="true" readonly="true" value="{{$datos['header']['id']}}">
                                <textarea class="form-control" placeholder="Comentarios Pre Revisión">{{$datos['header']['comentarios_in']}}</textarea>
                            </form>
                        </div>
                        <table class="table">
                            <thead>
                                <tr style="background-color: #4784e8;">   
                                    <th style="color: #FFFFFF;text-align: center;"><strong>Id</strong></th>
                                    <th style="color: #FFFFFF;text-align: center;"><strong>Area</strong></th>
                                    <th style="color: #FFFFFF;text-align: center;"><strong>NickName</strong></th>
                                    <th style="color: #FFFFFF;text-align: center;"><strong>Puntaje Actual</strong></th>
                                    <th style="color: #FFFFFF;text-align: center;"></th>
                                </tr>  
                            </thead>
                             <tbody>
                                @forelse( $datos['aleat_areas'] as $key => $item)
                                    @forelse( $datos['todas_areas'] as $key_b => $item_b)
                                        @if($item_b['id'] == $item['ref_id_area'])
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$item_b['nickname']}}</td>
                                            @if( is_null($item_b['identifier_value']) || $item_b['identifier_value'] == 0 || empty($item_b['identifier_value']) )
                                                <td>Ninguno</td>
                                            @else 
                                                <td>{{$item_b['identifier_value']}}</td>
                                            @endif
                                            <td>{{$item['percent_review']}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button type="button" data-toggle="modal" data-target="#modal_evaluacion" class="btn btn-primary btn-sm attribute_admin" id="att_ad{{$item['ref_id_area']}}"><i class="pe-7s-news-paper"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm"><i class="pe-7s-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @empty
                                    @endforelse
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        <form>
                            <div class="row">
                                <div class="col">  
                                    <label style="color: #4784e8;"><strong>Añadir Area</strong></label>
                                    <select class="form-control">
                                        @php
                                            $count = 0;
                                            foreach( $datos['todas_areas'] as $key_a => $item_a) {
                                                foreach( $datos['aleat_areas'] as $key_b => $item_b) {
                                                    if( $item_a['id'] == $item_b['ref_id_area']) {
                                                        $count++;
                                                    }
                                                }
                                                if( $count > 0 ) {
                                                    unset($datos['todas_areas'][$key_a]);
                                                }
                                                $count = 0;
                                            }
                                        @endphp

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
            var id_area = $(this).attr("id").slice(6); //alert(id_area);
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