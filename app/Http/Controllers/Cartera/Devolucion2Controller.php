<?php

namespace App\Http\Controllers\Cartera;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Cartera\Devolucion2, App\Models\Cartera\Devolucion1, App\Models\Cartera\Factura2;
use DB, Log;

class Devolucion2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->has('id_factura2')) {

                $factura2 = Factura2::getFactura2($request->id_factura2);
                $object = new \stdClass();
                $object->model = [];
                foreach ($factura2 as $value) {
                    if (($value->factura2_cantidad - $value->factura2_devueltas) > 0) {
                        $factura2 = Devolucion2::modelCreate($value);
                        $object->model[] = $factura2;
                    }
                }
                return response()->json($object->model);
            }
            $devolucion2 = Devolucion2::getDevolucion2($request->id);
            return response()->json($devolucion2);
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
