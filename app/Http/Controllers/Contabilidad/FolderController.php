<?php

namespace App\Http\Controllers\Contabilidad;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contabilidad\Folder;
use DB, Log, Datatables,Cache;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Folder::query();
            $query->select('folder.id as id','folder_codigo', 'folder_nombre');
            return Datatables::of($query)->make(true);
        }
        return view('contabilidad.folders.index');
    }

    /**
    * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create ()
    {
        return view('contabilidad.folders.create');
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

            $folder = new Folder;
            if ($folder->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Folder
                    $folder->fill($data);
                    $folder->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Folder::$key_cache );
                    return response()->json(['success' => true, 'id' => $folder->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $folder->errors]);
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
        $folder = Folder::findOrFail($id);
        if ($request->ajax()) {
            return response()->json($folder);
        }
        return view('contabilidad.folders.show', ['folder' => $folder]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $folder = Folder::findOrFail($id);
        return view('contabilidad.folders.edit', ['folder' => $folder]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $folder = Folder::findOrFail($id);
            if ($folder->isValid($data)) {
                DB::beginTransaction();
                try {
                    // Folder
                    $folder->fill($data);
                    $folder->save();

                    // Commit Transaction
                    DB::commit();

                    //Forget cache
                    Cache::forget( Folder::$key_cache );
                    return response()->json(['success' => true, 'id' => $folder->id]);
                }catch(\Exception $e){
                    DB::rollback();
                    Log::error($e->getMessage());
                    return response()->json(['success' => false, 'errors' => trans('app.exception')]);
                }
            }
            return response()->json(['success' => false, 'errors' => $folder->errors]);
        }
        abort(403);
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
