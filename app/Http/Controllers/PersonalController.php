<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class PersonalController extends Controller
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
        return view('rbac.personal.index', [
            'user'  => User::where('uuid', Auth::user()->uuid)->first(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'old_password'  => ['required'],
                'password'      => ['required', 'string', 'confirmed'],
            ]);

            if ($validator->fails()) {
                $errors = json_decode($validator->errors(), true);
                $this->code = 202;
                return response()->json([
                    'metadata' => array(
                        'message' => errorValidasi($validator->errors()),
                        'code' => $this->code,
                    ),
                    'response' => $errors,
                ], $this->code);
            }
        }
        $uuid = Auth::user()->uuid;
        $user = User::where('uuid', $uuid)->first();

        if ($request->password && $request->old_password) {
            if ($user && Hash::check($request->old_password, $user->password)) {
                User::find($uuid)->update([
                    'password'      => Hash::make($request->password),
                ]);
            } else {
                throw new Exception("Password sekarang salah!");
            }
        }

        if (!$request->password) {
            $this->code = 202;
            $this->message = "Tidak ada data yang diubah";
        } else {
            $this->message = "Data berhasil diubah";
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function updateProfile(Request $request)
    {
        $photo = null;
        if ($request->hasFile('photo')) {
            if ($request->file('photo')->isValid()) {
                $avatar = Config::get('storage.avatar');
                if (!File::exists($avatar)) File::makeDirectory($avatar, 0777, true);

                $file = $request->file('photo');
                $image = 'emp-' . Auth::user()->nik . '.' . $file->getClientOriginalExtension();

                //Resize Function
                $image_resize = Image::make($file->getRealPath());

                $newWidth = 250;
                $newHeight = 250;
                $image_resize->resize($newWidth, $newHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image_resize->save($avatar . '/' . $image);

                $photo = base64_encode(file_get_contents($avatar . '/' . $image));

                User::find(Auth::user()->uuid)->update([
                    'photo' => $photo,
                ]);

                array_map('unlink', glob($avatar . "/emp-*"));
            }
        }else{
            $this->code = 202;
            $this->message = "Tidak ada data yang diubah";
        }
        
        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }
}
