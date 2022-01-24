<?php

namespace App\Http\Controllers\Frontend;
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
 * Class HomeController.
 */
class HomeController extends Notification
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
    }

    public function index()
    {
        $sesidaftar = Str::random(10);
        Session::put('sesidaftar', $sesidaftar);
        return view('frontend.reg.index', compact('sesidaftar'));
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

    public function convertnotif($isi)
    {
        $notifikasi = str_replace('{Nama}', $this->nama, $isi);
        $notifikasi = str_replace('{E-mail}', $this->email, $notifikasi);
        $notifikasi = str_replace('{Gender}', $this->gender, $notifikasi);
        $notifikasi = str_replace('{No. Telepon}', $this->nohp, $notifikasi);
        $notifikasi = str_replace('{Kota}', $this->kota, $notifikasi);
        $notifikasi = str_replace('{Nominal Transfer}', $this->cekeventaktif->harga + $this->kodeunik, $notifikasi);

        return $notifikasi;
    }

    public function simpan()
    {
        $cekemail = Pendaftaran::
                where([
                    ['email', $this->email],
                ])->first();

        if ($cekemail) {
            return redirect()->back()->withFlashDanger('Email sudah terdaftar.')->withInput();
        } else {
            try {
                $kode = [1, 2, 3, 4, 5, 6, 7, 8, 9];

                $pendaftar = new Pendaftaran;
                $pendaftar->uuid            = Str::uuid();
                $pendaftar->kode            = rand(10000,99999);
                $pendaftar->nama            = strtoupper($this->nama);
                $pendaftar->email           = strtolower($this->email);
                $pendaftar->nohp_whatsapp   = $this->nohpwa;
                $pendaftar->nohp_telegram   = $this->nohptele;
                $pendaftar->domisili        = strtoupper($this->kota);
                $pendaftar->alamat          = strtoupper($this->alamat);
                $pendaftar->tgl_lahir       = $this->tgllahir;
                $pendaftar->gender          = $this->gender;
                $pendaftar->status          = '1'; // MENUNGGU KONFIRMASI
                $pendaftar->angkatan        = '4';
                $pendaftar->bukti_tf        = Session::get('filebuktitransfer');;
                $pendaftar->nominal         = 100004; // -- TUK SEMENTARA NOMINAL STATIS --
                $pendaftar->save();

                $isiwa = 'Assalamualaikum Warrohmatullah Wabarokatuh

Nama : '.$pendaftar->nama.'
Email : '.$pendaftar->email.'
No. WhatsApp : '.$pendaftar->nohp_whatsapp.'
No. Telegram : '.$pendaftar->nohp_telegram.'
Domisili : '.$pendaftar->domisili.'
Tanggal : '.$pendaftar->created_at.'

Mendaftarkan diri untuk mengikuti *Mufid Islamic Academy Angkatan 4*

Mohon menunggu untuk kami mengkonfirmasi data anda.
syukron.

Salam,

*Tim MUFID - MIA*';

                $this->notifwa($this->nohpwa, $isiwa);

            } catch (Throwable $td) {
                return redirect()->back()->withFlashDanger('Pendaftaran Gagal ! Terjadi kesalahan, mohon ulangi. Terima Kasih')->withInput();
            }
        }

        return redirect()->route('frontend.selesai');
    }

    public function uploadbuktitf(Request $request)
    {
        if ($_SERVER['HTTP_HOST'] == 'mufid-mia.com') {
            $file_bukti_transfer      = $request->file('filepond');
            $nama_file_bukti_transfer = '4-'.Str::random(5).'-'.Carbon::now().'.'.$file_bukti_transfer->getClientOriginalExtension();
            Session::put('filebuktitransfer', $nama_file_bukti_transfer); //membuat sesi nama file agar sesuai dengan pemilik pendaftar
            // Storage::disk('bukti-transfer-atthala')->put($nama_file_bukti_transfer, File::get($file_bukti_transfer));

            $buktitf         = Image::make($file_bukti_transfer);
            $lokasibuktitf   = public_path('../../../public_html/bukti-transfer/');
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
            $lokasibuktitf   = public_path('bukti-transfer/');
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
