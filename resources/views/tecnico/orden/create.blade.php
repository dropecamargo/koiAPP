@extends('tecnico.orden.main')

@section('module')
	<div id="ordenes-create"></div>

	<section id="orden-content-section">
	    <!-- Modal info remision -->
	    <div class="modal fade" id="modal-create-remision" data-backdrop="static" data-keyboard="false" aria-hidden="true">
	        <div class="modal-dialog modal-lg" role="document">
	            <div class="modal-content">
	                <div class="modal-header small-box {{ config('koi.template.bg') }}">
	                    <button type="button" class="close icon-close-koi" data-dismiss="modal" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                    </button>
	                    <h4><strong>Tecnico - Nueva remisión</strong></h4>
	                </div>
	                {!! Form::open(['id' => 'form-remrepu', 'data-toggle' => 'validator']) !!}
	                    <div class="modal-body" id="modal-remision-wrapper-show-info">
	                        <div class="content-modal">
	                        </div>
	                    </div>
	                {!! Form::close() !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-sm click-store-remsion">Continuar</button>
                    </div>
	            </div>
	        </div>
	    </div>

	    <script type="text/template" id="add-remision-tpl">
		    <div class="row">
		        <div class="form-group col-md-3">
		            <label for="remrepu2_serie" class="control-label">Producto</label>
		            <div class="input-group input-group-sm">
		                <span class="input-group-btn">
		                    <button type="button" class="btn btn-default btn-flat btn-koi-search-producto-component" data-field="remrepu2_serie">
		                        <i class="fa fa-barcode"></i>
		                    </button>
		                </span>
		                <input id="remrepu2_serie" placeholder="Referencia" class="form-control producto-koi-component" name="remrepu2_serie" type="text" maxlength="15" data-legalizacion="true" data-wrapper="producto_create" data-name="remrepu2_nombre" required>
		            </div>
		        </div>
		        <div class="col-md-6 col-xs-10"><br>
		            <input id="remrepu2_nombre" name="remrepu2_nombre" placeholder="Nombre producto" class="form-control input-sm" type="text" readonly required>
		        </div>
		        <div class="form-group col-md-2">
		            <label for="remrepu2_cantidad" class="control-label">Cantidad</label>
		            <input type="number" name="remrepu2_cantidad" id="remrepu2_cantidad" min="1" class="form-control input-sm">
		        </div>
		        <div class="form-group col-md-1"><br>
		            <button type="button" class="btn btn-success btn-sm btn-block click-add-item">
		                <i class="fa fa-plus"></i>
		            </button>
		        </div>
		    </div>
		    
		    <!-- table table-bordered table-striped -->
		    <div class="table-responsive no-padding">
		        <table id="browse-legalizacions-list" class="table table-hover table-bordered" cellspacing="0">
		            <thead>
		                <tr>
		                    <th width="5%"></th>
		                    <th width="10%">Referencia</th>
		                    <th width="40%">Nombre</th>
		                    <th width="10%">Cantidad</th>
		                </tr>
		            </thead>
		            <tbody>
		                {{-- Render content remrepu --}}
		            </tbody>
		        </table>
		    </div>
		</script>
	</section>
@stop