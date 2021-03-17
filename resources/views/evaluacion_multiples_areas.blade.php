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
                    <div>
                        <label>dnkdnkdnk</label>
                    </div>
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
                                @forelse( $datos['aleat_areas'] as $Key => $item)
                                @empty
                                @endforelse
                                <tr>
                                    <td>{{$Key}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" data-toggle="modal" data-target="#modal_evaluacion" class="btn btn-primary btn-sm"><i class="pe-7s-news-paper"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm"><i class="pe-7s-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <form>
                            <div>
                                <label>Area</label>
                                <select class="form-control"></select>
                                <button class="btn btn-success"></button>
                            </div>
                        </form>
                    </div>
    			</div>
    		</div>
    	</div>
    </div>
@endsection