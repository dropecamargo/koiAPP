<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\ActivoFijo,App\Models\Contabilidad\TipoActivo, App\Models\Base\Tercero;
use Log, Datatables;

class ActivoFijoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            if ($request->has('datatables')) {
                $query = ActivoFijo::getActivosFijos();
                return Datatables::of($query)->make(true);
            }
            if ($request->has('id')) {
                $activofijo = ActivoFijo::getActivoFijo($request->id);
                return response()->json($activofijo);
            }
        }
        return view('contabilidad.activofijos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $activofijo = new ActivoFijo;
            if ($activofijo->isValid($data)) {
                try {
                    // Recupero responsable
                    $responsable = Tercero::where('tercero_nit', $request->activofijo_responsable)->first();
                    if (!$responsable instanceof Tercero) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar responsable, por favor verifique la información o consulte al administrador']);
                    }
                    // Recupero tipo activo
                    $tipoactivo = TipoActivo::find($request->activofijo_tipoactivo);
                    if (!$tipoactivo instanceof TipoActivo) {
                        return response()->json(['success' => false, 'errors' => 'No es posible recuperar el tipo de activo, por favor verifique la información o consulte al administrador']);
                    }
                    return response()->json([ 'success' => true, 'id' => uniqid(), 'tercero_nombre' => $responsable->getName(), 'tipoactivo_nombre' => $tipoactivo->tipoactivo_nombre ]);
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $activofijo->errors]);
        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $activofijo = ActivoFijo::getActivoFijo($id);
        return view('contabilidad.activofijos.show', ['activofijos' => $activofijo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
