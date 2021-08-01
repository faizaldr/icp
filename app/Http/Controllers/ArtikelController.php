<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class ArtikelController extends Controller
{
  
     public function index()
    {
        $o_pengguna = new Artikel();
        $pengguna = $o_pengguna->all();
        return response([
            "status" => "200",
            "data" => $pengguna,
        ], 200);
    }

    public function cari(Request $request)
    {
        $judul = $request["judul"] ?? "";
        $isi = $request["isi"] ?? "";
        $id = $request["id"] ?? "";

        if ($id == "") {
            $pengguna = Artikel::where("judul", "like", "%" . $judul . "%")
                ->where("isi", "like", "%" . $isi . "%")
                ->get();
        } else {
            $pengguna = Artikel::where("id", $id)->get();
        }

        return response([
            "status" => "200",
            "data" => $pengguna,
        ], 200);
    }

    public function tambah(Request $request)
    {
        $data = $request->only('judul', 'isi');
        $validate = Validator::make($data, [
            'judul' => "required",
            'isi' => "required"
        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        $proses = Artikel::create([
            'judul' => $request->judul,
            'isi' =>  $request->isi,
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
        $data = $request->only('id', 'judul','isi');
        $validate = Validator::make($data, [
            'id' => "required",
            'judul' => "required",
            'isi' => "required"
        ]);

        if ($validate->fails()) {
            return response([
                "status" => "400",
                "data" => $validate->messages(),
            ], 400);
        }

        $proses = Artikel::where("id", $request["id"])->update([
            'judul' => $request->judul,
            'isi' =>  $request->isi,
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

        $proses = Artikel::where("id", $request["id"])->delete();


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

}