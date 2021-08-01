<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pengguna;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class PenggunaController extends Controller
{
    /**
     * @OA\SecurityScheme(
     *    securityScheme="bearerAuth",
     *    type="http",
     *    scheme="bearer"
     * )
     * 
     * @OA\Post(
     *     security={{"bearerAuth":{}}},
     *     path="/pengguna/login",
     *     tags={"login"},
     *     summary="Melakukan Login",
     *     description="Login",
     *     operationId="login",
     *     @OA\Parameter(
     *          name="email",
     *          description="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="passwd",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index()
    {
        $o_pengguna = new pengguna();
        $pengguna = $o_pengguna->all();
        return response([
            "status" => "200",
            "data" => $pengguna,
        ], 200);
    }

    public function cari(Request $request)
    {
        $nama = $request["nama"] ?? "";
        $alamat = $request["alamat"] ?? "";
        $id = $request["id"] ?? "";

        if ($id == "") {
            $pengguna = pengguna::where("nama", "like", "%" . $nama . "%")
                ->where("alamat", "like", "%" . $alamat . "%")
                ->get();
        } else {
            $pengguna = pengguna::where("id", $id)->get();
        }

        return response([
            "status" => "200",
            "data" => $pengguna,
        ], 200);
    }

    public function tambah(Request $request)
    {
        $data = $request->only('nama', 'email', 'password', 'konfirmasi_password', 'alamat');
        $validate = Validator::make($data, [
            'nama' => "required",
            'email' => "required|email",
            'password' => "required|min:8",
            'konfirmasi_password' => "required|same:password",
            'alamat' => "required"

        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        $proses = pengguna::create([
            'nama' => $request->nama,
            'email' =>  $request->email,
            'password' =>  bcrypt($request->password),
            'alamat' =>  $request->alamat,
        ]);

        if ($proses) {
            return response([
                "status" => "200",
                "data" => "Data Berhasil Ditambahkan",
            ], 200);
        } else {
            return response([
                "status" => "400",
                "data" => "Terjadi Kesalahan Tambah",
            ], 400);
        }
    }


    public function ubah(Request $request)
    {
        $data = $request->only('id', 'nama', 'email', 'password', 'konfirmasi_password', 'alamat');
        $validate = Validator::make($data, [
            'id' => "required",
            'nama' => "required",
            'email' => "required|email",
            'password' => "required|min:8",
            'konfirmasi_password' => "required|same:password",
            'alamat' => "required"
        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        $proses = pengguna::where("id", $request["id"])->update([
            'nama' => $request->nama,
            'email' =>  $request->email,
            'password' =>  bcrypt($request->password),
            'alamat' =>  $request->alamat,
        ]);

        if ($proses) {
            return response([
                "status" => "200",
                "data" => "Data Berhasil Ditambahkan",
            ], 200);
        } else {
            return response([
                "status" => "400",
                "data" => "Terjadi Kesalahan Tambah",
            ], 400);
        }
    }
    public function hapus(Request $request)
    {
        $data = $request->only('id');
        $validate = Validator::make($data, [
            'id' => "required"
        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        $proses = pengguna::where("id", $request["id"])->delete();


        if ($proses) {
            return response([
                "status" => "200",
                "data" => "Data Berhasil Dihapus",
            ], 200);
        } else {
            return response([
                "status" => "400",
                "data" => "Terjadi Kesalahan Penghapus",
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $data = $request->only('email', 'password');
        $validate = Validator::make($data, [
            'email' => "required|email",
            'password' => "required|min:8",
        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        JWTAuth::factory()->setTTL(60);
        if ($token = JWTAuth::attempt($data)) {
            return response([
                "status" => "200",
                "data" => $token,
            ], 200);
        } else {
            return response([
                "status" => "401",
                "data" => "Email Password Tidak sesuai",
                // "data" => "Email Salah",
            ], 401);
        }
    }
}
