<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Pendaftaran;
use Image;
use Throwable;
use Illuminate\Notifications\Notification;

/**
 * Class DashboardController.
 */
class DashboardController
{
    public function __construct(){
        $this->nama          = request()->nama ?? null;
        $this->email         = request()->email ?? null;
        $this->gender        = request()->gender ?? null;
        $this->tgllahir      = request()->tgl . '-' . request()->bln . '-' . request()->thn ?? null;
        $this->nohpwa        = $this->nohp(request()->nohpwa) ?? null;
        $this->nohptele      = $this->nohp(request()->nohptele) ?? null;
        $this->kota          = request()->kota ?? null;
        $this->alamat        = request()->alamat ?? null;
        $this->perpage       = request()->perpage ?? 5;
    }

    public function nohp($nomor){
        if (substr($nomor, 0, 1) === '0') {
            return substr($nomor, 1);
        } elseif (substr($nomor, 0, 2) === '62') {
            return substr($nomor, 2);
        } elseif (substr($nomor, 0, 3) === '+62') {
            return substr($nomor, 3);
        } else {
            return $nomor;
        }
    }

    public function notifwa($nomorhp, $isipesan)
    {
        // $datawa = json_decode($isipesan);

        $data = array(
            "phone_no"  => $nomorhp,
            "key"		=> env('WA_KEY'),
            "message"	=> $isipesan,
            "skip_link"	=> True // This optional for skip snapshot of link in message
        );
        $data_string = json_encode($data);

        $ch = curl_init(env('WA_URL'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        echo $res=curl_exec($ch);
        curl_close($ch);
    }

    public function index()
    {
        if (request()->metode == 'hapus') {
            $hapuspendaftar = Pendaftaran::find(request()->id);
            $hapuspendaftar->delete();
            return redirect()->back()->withFlashSuccess('Pendaftar atas nama '.$hapuspendaftar->nama.' - '.$hapuspendaftar->email.' Berhasil Dihapus !');
        }

        if (request()->metode == 'konfirmasi') {

            try {
                $konfirmasi                   = Pendaftaran::find(request()->id);
                $konfirmasi->status           = 2;
                $konfirmasi->waktu_konfirmasi = Carbon::now();
                $konfirmasi->save();

                $isiwa = 'Ahlan wa sahlan, '.$konfirmasi->nama.'
Selamat bergabung di Mufid Islamic Academy Angkatan 4

Untuk selanjutnya, dipersilakan untuk bergabung ke dalam grup (sambil menunggu pembagian kelas) dengan mengklik tautan berikut:

Ikhwan : https://chat.whatsapp.com/HRCR7aNAXyrBkjZixAIHzC
Akhwat : https://chat.whatsapp.com/K2Bc6FMTtCoB6OkzowGaUU

Salam,

*Tim MUFID - MIA*';

                $this->notifwa($konfirmasi->nohp_whatsapp, $isiwa);

            } catch (Throwable $td) {
                return redirect()->back()->withFlashDanger('Konfirmasi Gagal ! Terjadi kesalahan, mohon hubungi programmer. <br>Terima Kasih');
            }
        }

        $datapendaftar = Pendaftaran::
                when(request()->get('nama'), function ($query) {
                    if( request()->get('nama') != null) {
                        return $query->whereRaw('LOWER(nama) LIKE ? ', '%' . strtolower(request()->get('nama')) . '%')
                        ->orWhereRaw('LOWER(email) LIKE ? ', '%' . strtolower(request()->get('nama')) . '%')
                        ->orWhereRaw('nohp_whatsapp LIKE ? ', '%' . strtolower(request()->get('nama')) . '%')
                        ->orWhereRaw('nohp_telegram LIKE ? ', '%' . strtolower(request()->get('nama')) . '%');
                    }
                })
                ->when(request()->get('alamat'), function ($query) {
                    if( request()->get('alamat') != null) {
                        return $query->whereRaw('LOWER(alamat) LIKE ? ', '%' . strtolower(request()->get('alamat')) . '%')
                                    ->orWhereRaw('LOWER(domisili) LIKE ? ', '%' . strtolower(request()->get('alamat')) . '%');
                    }
                })
                ->when(request()->get('status'), function ($query) {
                    if( request()->get('status') != null) {
                        return $query->where('status', request()->get('status'));
                    }
                })
                ->when(request()->get('jenis'), function ($query) {
                    if( request()->get('jenis') != null) {
                        return $query->where('gender', request()->get('jenis'));
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate($this->perpage);

        return view('backend.dashboard', compact('datapendaftar'));
    }
}
