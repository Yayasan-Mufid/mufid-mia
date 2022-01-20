@extends('frontend.layouts.reg')

@section('title', 'MIA | Registrasi')

@section('content')
@stack('before-styles')
    <link rel="stylesheet" type="text/css" href="/filepond/app.css">
@stack('after-styles')
    <div class="container py-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <x-frontend.card>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.login')">
                            <div class="text-center">
                                <img src="https://mufid.or.id/wp-content/themes/yayasan-mufid/assets/images/mufid-logo.svg" width="150">

                                <div class="pt-4">
                                    Registrasi Peserta MIA
                                    <div class="text-muted">
                                        Angkatan 4
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input autocomplete="new-password" type="email" name="email" value="{{ old('email') }}"  class="form-control" maxlength="100" placeholder="Alamat Email" required="" >
                                    </div><!--col-->
                                </div><!--row-->
                            </div><!--row-->
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input autocomplete="new-password" type="text" name="nama" value="{{ old('nama') }}"  class="form-control" maxlength="100" placeholder="Nama Lengkap" required="" >
                                    </div><!--col-->
                                </div><!--row-->
                            </div><!--row-->
                            <div class="form-group row">
                                <div class="col-md-9 col-form-label">
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" type="radio" value="L" name="gender" required>
                                        <label class="form-check-label">IKHWAN</label>
                                    </div>
                                    <div class="form-check form-check-inline mr-1">
                                        <input class="form-check-input" type="radio" value="P" name="gender">
                                        <label class="form-check-label">AKHWAT</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row pb-4">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                +62
                                            </span>
                                        </div>
                                        <input id="nohp" type="number" name="nohp" value="{{ old('nohp') }}" class="form-control" maxlength="12" placeholder="No. Handphone WhatsApp" required="">
                                    </div><!--form-group-->
                                    @if ($errors->has('nohp'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nohp') }}</strong>
                                        </span>
                                    @endif
                                </div><!--col-->
                                <div class="col-12">
                                    <span class="help-block text-muted" style="font-size: 10px; font-weight: 700">Tidak Pakai Angka 0 . Contoh : 81234563789</span>
                                </div>
                            </div><!--row-->

                            <div class="row pb-4">
                                <div class="col-12">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                +62
                                            </span>
                                        </div>
                                        <input id="nohp_tele" type="number" name="nohp_tele" value="{{ old('nohp_tele') }}" class="form-control" maxlength="12" placeholder="No. Handphone Telegram" required="">
                                    </div><!--form-group-->
                                    @if ($errors->has('nohp'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('nohp_tele') }}</strong>
                                        </span>
                                    @endif
                                </div><!--col-->
                                <div class="col-12">
                                    <span class="help-block text-muted" style="font-size: 10px; font-weight: 700">Tidak Pakai Angka 0 . Contoh : 81234563789</span>
                                </div>
                            </div><!--row-->

                            <div class="form-group">
                                <label style="padding-right: 10px">Tanggal Lahir</label>
                                <select name="tgl">
                                    @for ($a = 1; $a <= 31; $a++)
                                        <option value="{{ $a }}">{{ $a }}</option>
                                    @endfor
                                </select>
                                <select name="bln">
                                    @for ($a = 1; $a <= 12; $a++)
                                        <option value="{{ $a }}">{{ $a }}</option>
                                    @endfor
                                </select>
                                <select name="thn">
                                    @for ($a = 1950; $a <= 2015; $a++)
                                        <option value="{{ $a }}">{{ $a }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group row">
                                <label class="col-3 form-control-label" >Alamat Domisili</label>
                                <div class="col-9">
                                    <textarea class="form-control" name="alamat" value="{{ old('alamat') }}" placeholder="Alamat Domisili"></textarea>
                                </div><!--col-->
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <input autocomplete="new-password" type="text" name="kota" value="{{ old('kota') }}"  class="form-control" maxlength="100" placeholder="Kota Domisili" required="" >
                                    </div><!--col-->
                                </div><!--row-->
                            </div><!--row-->

                            <div class="form-group row">
                                <div class="col-md-12 table-responsive" style="padding-top: 20px">
                                    <table class="table table-sm table-striped nowarp" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <td>Biaya Pendaftaran<div class="text-muted">Rp. 100.000</div></td>
                                                <td class="text-center"><input id="biaya-daftar" type="checkbox" value="" checked disabled/></td>
                                            </tr>
                                            <tr>
                                                <td>Kode Unik Angkatan 4 <div class="text-muted">Rp. 4</div></td>
                                                <td class="text-center"><input id="biaya-daftar" type="checkbox" value="" checked disabled/></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><strong>Total</strong> </td>
                                                <td class="text-center"><div class="text-muted">Rp. 100.004</div></td>
                                            </tr>
                                            {{-- <tr>
                                                <td>Pembayaran modul dan buku prestasi <div class="text-muted">Rp. 60.000</div></td>
                                                <td><input id="biaya-modul" name="bayar_modul" type="checkbox" value="" /></td>
                                            </tr>
                                            <tr>
                                                <td>Mushaf Al-Quran Non Terjemah <div class="text-muted">Rp. 110.000</div></td>
                                                <td><input id="biaya-mushaf" name="bayar_mushaf" type="checkbox" value="" /></td>
                                            </tr> --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="form-label col-12">Rekening Tujuan Yang Ditransfer</label>

                                <div class="col-12">
                                    <div class="alert alert-info" role="alert">
                                        <div>
                                            Rekening <strong>BSI (Bank Syariah Indonesia)</strong> ex BNI Syariah No rekening :
                                            <br>
                                            <div class="text-center" style="font-size: 20px">1121130026</div>
                                            a/n <strong>Yayasan Muflih untuk Islam dan Dakwah (MUFID) (MIA)</strong>.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <input type="file" class="upload-buktitransfer" required/>
                                    <span class="help-block text-muted" style="font-size: 10px; font-weight: 700; ">Maksimal File 10 MB</span>
                                </div><!--col-->
                            </div>


                            <div class="form-group row mb-0 clearfix d-none" id="btn-submit">
                                <div class="col-md-12">
                                    <button style="box-shadow: 0 4px 20px 0 rgb(0 0 0 / 14%), 0 7px 10px -5px rgb(207 20 24);"
                                            class="btn btn-primary btn-block btn-pill font-weight-bold"
                                            type="submit">
                                        DAFTAR
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row mb-0 clearfix" id="btn-submit-dis">
                                <div class="col-md-12">
                                    <button class="btn btn-light btn-block btn-pill font-weight-bold" disabled>
                                        DAFTAR
                                    </button>
                                </div>
                            </div>
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
                <div class="text-center">
                    <p class="text-muted">
                        Yayasan Mufid Balikpapan © 2022
                    </p>
                </div>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="/filepond/app.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<script>
    $(function(){
        $.fn.filepond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            FilePondPluginImageResize
        );
    });

    $(function(){
            $('.upload-buktitransfer').filepond({
                labelIdle: '<span class="filepond--label-action"> Upload File/Foto Bukti Transfer.</span>',
                allowMultiple: false,
                acceptedFileTypes: "image/png, image/jpeg",
                allowFileSizeValidation: true,
                maxFileSize: '10MB',
                server: {
                    url: '/upload-bukti-tf',
                    process: {
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        onload: (response) => response.key,
                        onerror: (response) => response.data,
                        ondata: (formData) => {
                            return console.log('sukses');
                        }
                    }
                }
            });

            $('.upload-buktitransfer').on('FilePond:processfile', function(e) {
                document.getElementById("btn-submit").classList.remove('d-none');
                document.getElementById("btn-submit-dis").classList.add('d-none');
            });

        });
    $(document).ready(function () {
        $('#fform').on('submit',function(e) {
            if (pond.status != 4) {
                return false;
            }
            $(this).find(':input[type=submit]').hide();
            return true;
        });
    });

</script>
@endsection
