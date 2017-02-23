@extends('admin.documento.main')

@section('breadcrumb')	
    <li class="active">Documentos</li>
@stop

@section('module')
   <div id="documento-main">
        <div class="box box-success">
            <div class="box-body table-responsive">
                <table id="documento-search-table" class="table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        	<th>Id</th>
                            <th>Código</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@stop