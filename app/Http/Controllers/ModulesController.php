<?php

namespace App\Http\Controllers;

use App\Models\Modules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class ModulesController extends Controller
{

    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('rbac.modules.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }

        return view('rbac.modules.form', [
            'url'   => url('/modules/store'),
        ]);
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
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'name'         => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Modules::create([
                'name'          => $request->name,
                'link'          => $request->link,
                'description'   => $request->description,
                'is_active'     => $request->is_active,
            ]);

            $this->message = "Data berhasil disimpan";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $uuid)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }
        $data = Modules::where('uuid', $uuid)->first();
        return view('rbac.modules.form', [
            'url'       => url('/modules/update/' . $uuid),
            'data'      => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'name'  => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $this->response = Modules::find($uuid)->update([
                'name'          => $request->name,
                'link'          => $request->link,
                'description'   => $request->description,
                'is_active'     => $request->is_active,
            ]);

            $this->message = "Data berhasil diubah";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $uuid)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            DB::beginTransaction();

            $this->response = Modules::find($uuid)->delete();

            $this->message = "Data berhasil dihapus";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        $data  = Modules::select(['modules.*',]);
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-dark btn-sm waves-effect"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Set Permission : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->uuid . '"' .
                    ' data-action-url="modules/formAction/' . $data->uuid . '"' .
                    ' data-bs-target="#form-modal">' .
                    'Set Permission' .
                    '</button>' .
                    '<button class="btn btn-info btn-sm waves-effect"' .
                    ' data-bs-toggle="modal"' .
                    ' data-title="Edit Data : ' . $data->name  . '"' .
                    ' data-post-id="' . $data->uuid . '"' .
                    ' data-action-url="modules/edit/' . $data->uuid . '"' .
                    ' data-bs-target="#form-modal">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm waves-effect"' .
                    ' onclick="deleteData(\'' . $data->uuid . '\');">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }

    public function formAction(Request $request, $uuid)
    {

        if (!$request->ajax()) {
            return redirect('');
        }

        $data = Modules::where('uuid', $uuid)->first();
        return view('rbac.modules.formAction', [
            'url'       => url('/modules/storeAction/' . $uuid),
            'data'      => $data
        ]);
    }

    public function storeAction(Request $request, $modules_uuid)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            $validator = Validator::make($request->all(), [
                'modules_uuid'  => ['required'],
                'name'          => ['required'],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            DB::beginTransaction();

            $exist = Permission::where('modules_uuid', $modules_uuid)
                ->where('name', $request->name)
                ->first();

            if (!$exist) {
                $this->response = Permission::create([
                    'modules_uuid'  => $modules_uuid,
                    'name'          => $request->name,
                    'guard_name'    => 'web',
                    'description'   => $request->description,
                    'is_active'     => $request->is_active,
                ]);
                $this->message = "Data berhasil disimpan";
            } else {
                Permission::find($exist->id)->update([
                    'modules_uuid'  => $modules_uuid,
                    'name'          => $request->name,
                    'description'   => $request->description,
                    'is_active'     => $request->is_active,
                ]);

                $this->response = Permission::where('id', $exist->id)->first();
                $this->message = "Data berhasil diupdate";
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function deleteAction(Request $request, $uuid)
    {
        try {
            if (!$request->ajax()) {
                return redirect('');
            }

            DB::beginTransaction();
            $this->response = Permission::find($uuid)->delete();
            $this->message = "Data berhasil dihapus";
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 201;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function tableDetail(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }

        $data  = Permission::where('modules_uuid', $request->modules_uuid)->get();
        return DataTables::of($data)
            ->addColumn('btn', function ($data) {
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<button class="btn btn-info btn-sm waves-effect btn-edit-detail">' .
                    'Edit' .
                    '</button>' .
                    '<button class="btn btn-danger btn-sm waves-effect btn-delete-detail">' .
                    'Hapus' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
