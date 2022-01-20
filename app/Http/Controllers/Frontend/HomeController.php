<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Image;

/**
 * Class HomeController.
 */
class HomeController
{
    public function index()
    {
        $sesidaftar = Str::random(10);
        Session::put('sesidaftar', $sesidaftar);
        return view('frontend.reg.index', compact('sesidaftar'));
    }

    public function pembayaran()
    {
        return view('frontend.reg.pembayaran');
    }

    public function uploadbuktitf(Request $request)
    {
        if ($_SERVER['HTTP_HOST'] == 'reg.mufid.or.id') {
            $file_bukti_transfer      = $request->file('filepond');
            $nama_file_bukti_transfer = '4-'.Str::random(5).'-'.Carbon::now().'.'.$file_bukti_transfer->getClientOriginalExtension();
            Session::put('filebuktitransfer', $nama_file_bukti_transfer); //membuat sesi nama file agar sesuai dengan pemilik pendaftar
            // Storage::disk('bukti-transfer-atthala')->put($nama_file_bukti_transfer, File::get($file_bukti_transfer));

            $buktitf         = Image::make($file_bukti_transfer);
            $lokasibuktitf   = public_path('../../../public_html/reg.mufid.or.id/bukti-transfer/');
            $buktitf->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $buktitf->save($lokasibuktitf.Session::get('filebuktitransfer'));
        } else {
            $file_bukti_transfer      = $request->file('filepond');
            $nama_file_bukti_transfer = '4-'.Str::random(5).'-'.Carbon::now().'.'.$file_bukti_transfer->getClientOriginalExtension();
            Session::put('filebuktitransfer', $nama_file_bukti_transfer); //membuat sesi nama file agar sesuai dengan pemilik pendaftar
            // Storage::disk('bukti-transfer')->put($nama_file_bukti_transfer, File::get($file_bukti_transfer));

            $buktitf         = Image::make($file_bukti_transfer);
            $lokasibuktitf   = public_path('bukti-transfer');
            $buktitf->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $buktitf->save($lokasibuktitf.Session::get('filebuktitransfer'));
        }
    }

    public function selesai()
    {
        return view('frontend.reg.selesai');
    }
}
