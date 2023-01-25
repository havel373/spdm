<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $prodis = Prodi::get();
        if($request->ajax()){
            $prodi = Prodi::get();
            if($request->prodi == ''){
                $mahasiswas = Mahasiswa::
                join('users','mahasiswas.user_id','=','users.id')
                ->where('users.nama', 'like', '%' . $request->keywords . '%')
                ->paginate(5);
            }else{
                $mahasiswas = Mahasiswa::
                join('users','mahasiswas.user_id','=','users.id')
                ->where('users.nama', 'like', '%' . $request->keywords . '%')
                ->where('mahasiswas.prodi', $request->prodi)
                ->paginate(5);
            }
            return view('pages.users.dashboard.list', compact('mahasiswas','prodi'));
        }
        return view('pages.users.dashboard.index', compact('prodis'));
    }
}
