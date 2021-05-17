@extends('templated')
<!-- MODALS -->
    <div class="modal" id="modal_evaluacion" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label_modal_header">Puntuación de Habitación</h5>
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
                        <form action="" method="POST" id="form_value_once_area">
                        <tbody id="t_body_atrr">
                        </tbody>
                    </table>
                    <hr>
                    <h4 style="text-align: right;color: #7F0040;font-weight: bold;" id="t_hab_label"></h4>
                </div>
                <div class="modal-footer">
                    <input type="" name="area_id" id="area_id_modal_point" hidden="true" readonly="true">
                    <input type="" name="area_body" id="area_body_modal_point" hidden="true" readonly="true">
                    <button type="submit" class="btn btn-primary">Guardar Puntajes</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>     
            </div>
        </div>
    </div>

    <div class="modal" id="modal_delete_areas" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_delete_areas_label">Eliminar "-----"</h5>
                    <button type="button" class="close" data-dismiss="modal" ><span aria-hidden="true"></span></button>
                </div>
                <form method="POST" id="delete_area_form">
                    <input type="" name="" id="dlt_area_id" hidden="true" readonly="true">
                        <input type="" name="" id="dlt_area_ref_id" hidden="true" readonly="true">
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Quitar Área</button>
                    </form>
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
    	<div class="row" id="page"> 
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
                                <textarea class="form-control" placeholder="Comentarios Pre Revisión" style="color: #4784E8;font-weight: bold;" id="comments_in"></textarea>
                            </form>
                            <script type="text/javascript">
                                $(document).ready(function(){

                                });
                            </script>
                        </div>
                        <div class="table-responsive" id="table_attr">
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
                                                <td id="area_nickname{{$item['id']}}">{{$item_b['nickname']}}</td>
                                                @if( is_null($item_b['identifier_value']) || $item_b['identifier_value'] == 0 || empty($item_b['identifier_value']) )
                                                    <td>Ninguno</td>
                                                @else 
                                                    <td>{{$item_b['identifier_value']}}</td>
                                                @endif
                                                <td class="rev_per" id="rev_per{{$item['ref_id_area']}}">{{$item['percent_review']}}</td>
                                                <input type="" name="area_ref_id{{$item['id']}}" id="att_name_{{$item['ref_id_area']}}" value="{{$item_b['nickname']}}" hidden="true" readonly="true" class="point_area_values">
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <button type="button" data-toggle="modal" data-target="#modal_evaluacion" class="btn btn-primary btn-sm attribute_admin" id="att_ad{{$item['ref_id_area']}}" name="{{$item['id']}}"><i class="pe-7s-news-paper"></i></button>  
                                                        <button type="button" class="btn btn-danger btn-sm delete_area_btn" id="area_id{{$item['id']}}" data-toggle="modal" data-target="#modal_delete_areas"><i class="pe-7s-trash"></i></button>
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
                        </div> 
                        <div class="table-responsive">
                            <form  method="POST" action="{{route('eva_new_area_add')}}">@csrf
                                <input type="" name="report_id" value="{{$datos['header']['id']}}" hidden="true" readonly="true" id="report_id_value">
                                <div class="row">
                                    <div class="col">  
                                        <label style="color: #4784e8;"><strong>Añadir Area</strong></label>
                                        <select class="form-control" name="area" id="add_area_form">
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
                                                <option id="{{$item['nickname']}}" value="{{$item['id']}}">{{$item['nickname']}}</option>
                                            @empty
                                            @endforelse
                                        </select> 
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-success" id="add_area_btn">-></button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
    			</div>
    		</div>
    	</div>
        <div class="row">
            <div class="col-md-9"></div>   
            <div class="col-md-2"> 
                <form method="POST" id="save_print_serialice">
                    <input type="" name="" id="ap_rst_ul" value="{{ env('API_REST_URL') }} " hidden="true" readonly="true">
                    <input type="" name="" id="ap_rst_tn" value="{{ $config['tkn'] }}" hidden="true" readonly="true">
                    <button type="submit" class="btn btn-info" id="print_sendDB">GUARDAR Y GENERAR PDF</button>
                </form>
            </div> <div class="col-md-1"></div>
        </div>
    </div>
@endsection
<script src="{{ asset('templated/js/jquery.3.2.1.min.js') }}" type="text/javascript" ></script>
<script type="text/javascript">
    $(document).ready(function() { 
        total_ptn_ha();
        $("#table_attr").scrollLeft(190);
        $('.attribute_admin').click(function() {  
            $("#table_atrr > tbody").empty();
            var id_area = $(this).attr("id").slice(6); //alert(id_area);
            $("#area_id_modal_point").val(id_area);
            $("#area_body_modal_point").val($(this).attr('name'));
            $("#label_modal_header").html('Puntuación de <strong>' + $("#att_name_"+id_area).val() + '</strong>' );
            var atributos = @json($datos['atributos']);//console.log(atributos);
            for (var i = atributos.length - 1; i >= 0; i--) { 
                if ( atributos[i]['ref_id_header'] == id_area) {
                    var tr = '<tr>';
                    tr += '<td style="color: #795AC6;font-weight: bold;"">';   
                    tr += atributos[i]['nickname'];
                    tr += '</td><td>';   
                    //tr += "<input type='number' onchange='max_ptn();' step='0.1'  min='0' max='"+atributos[i]['max_point']+"'>";
                    tr += "<input type='range' onchange='max_ptn("+[i]+");' id='at_in"+[i]+"' value='0.00'  step='0.1'  min='0'" +"max='"+atributos[i]['max_point']+"' name='"+atributos[i]['id']+"' class='att_area_val'>"; 
                    tr +=  "<h5 style='color: #005CC8;text-align: right;font-weight: bold;' name='at_in_label"+atributos[i]['id']+"' id='at_in_label"+[i]+"' class='att_cal' >0.00/"+atributos[i]['max_point']+"</h5>" ;  
                    tr += '</td></tr>'; 
                    $("#t_body_atrr").append(tr);
                }
            }
        }); 
        $('.delete_area_btn').click(function() {
           $('#dlt_area_id').val($(this).attr('id').slice(7));    
           $('#modal_delete_areas_label').html('Desea Quitar <strong>'+ $('#area_nickname'+$(this).attr('id').slice(7)).html() +'</strong> ?' ); //area_ref_id att_name_ dlt_area_ref_id
           $('#dlt_area_ref_id').val($("input[name=area_ref_id"+$(this).attr('id').slice(7)+"]").attr('id').slice(9)); 
        });   
    });
    function max_ptn(id) {
        value = $('#at_in'+id).val();
        max = $('#at_in'+id).attr("max"); 
        //alert(value+"-"+max);
        if ( parseFloat(value) > max) {
            $('#at_in'+id).val(max);
        }
        var res = $('#at_in_label'+id).html().split("/");
        $('#at_in_label'+id).html( $('#at_in'+id).val() +"/"+res[1]);
        total_ptn_ha();
    }; 
    function total_ptn_ha() {
        var valores = [];
        var val1 = 0;
        var val2 = 0;
        var x = 0;
        $('.att_cal').each(function(){
            valores[x] = $(this).html();
            valores[x] = valores[x].split("/");
            val1 += parseFloat(valores[x][0]);
            val2 += parseFloat(valores[x][1]);
            x++;
        });
        $('#t_hab_label').html('TOTAL   '+val1+'/'+val2);   
    };
</script>  
<script src="{{ asset('local_db.js') }}"></script>