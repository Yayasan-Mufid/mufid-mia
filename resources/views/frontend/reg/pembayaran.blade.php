@extends('frontend.layouts.reg')

@section('title', 'MIA | Pembayaran')

@section('content')
@stack('before-styles')
    <link rel="stylesheet" type="text/css" href="/filepond/app.css">
@stack('after-styles')
<div class="container py-4 mt-4">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="https://mufid.or.id/wp-content/themes/yayasan-mufid/assets/images/mufid-logo.svg" width="150">

                        <div class="pt-4">
                            Form Pembayaran Registrasi Peserta MIA
                            <div class="text-muted">
                                Angkatan 4
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label font-weight-bold">Kode Pembayaran</label>
                            <div class="form-group">
                                <input style="font-weight: 700; background-color: #fff;" onkeyup="this.value = this.value.toLowerCase();" autocomplete="new-password" type="text" name="nama" value="request()->nama }}" id="nama" placeholder="Nama Lengkap" maxlength="191" required="required" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label font-weight-bold">Nama</label>
                            <div class="form-group">
                                <input style="font-weight: 700; background-color: #fff;" onkeyup="this.value = this.value.toLowerCase();" autocomplete="new-password" type="text" name="nama" value="request()->nama }}" id="nama" placeholder="Nama Lengkap" maxlength="191" required="required" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label class="form-label font-weight-bold">Nominal</label>
                            <div class="form-group">
                                    <input style="font-weight: 700; background-color: #fff;" type="text" name="nominal" value="Rp. $data->total }}"  maxlength="191" required="required" class="form-control" disabled>
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->
                    <div class="row">
                        <div class="col">
                            <label class="form-label font-weight-bold">Status</label>
                            <div class="form-group">
                                <input style="font-weight: 700; background-color: #fff;" type="text" name="status" value="$status }}" class="form-control border-$wstatus }} text-$wstatus }}" disabled>
                            </div><!--form-group-->
                        </div><!--col-->
                    </div><!--row-->


                    {{-- @if ($data->status == '1') --}}
                        <form id="fform" action="/simpan-invoice" method="post">
                            @csrf
                            <input type="text" name="id" value="$data->id }}" hidden>
                            <div class="form-group row">
                                <label class="form-label col-12">Rekening Tujuan Yang Ditransfer</label>
                                <div class="col-12">
                                    <select class="form-control" name="rekening" required>
                                        <option value="BANK BSI = 123456789">BANK BSI = 123456789 a/n Yayasan Mufid Balikpapan</option>
                                    </select>
                                </div><!--col-->
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <input type="file" class="upload-buktitransfer" required/>
                                    <span class="help-block text-muted" style="font-size: 10px; font-weight: 700; ">Maksimal File 10 MB</span>
                                </div><!--col-->
                            </div>
                            <div class="row">
                                <div class="col" style="">
                                    <div class="form-group mb-0 clearfix d-none" id="btn-submit">
                                        <button type="submit" class="btn btn-pill btn-block btn-info btn-block">
                                            Upload Bukti Transfer <i class="fa fa-upload"></i>
                                        </button>
                                    </div><!--form-group-->
                                </div><!--col-->
                            </div><!--row-->
                        </form>
                    {{-- @else
                        <div class="row">
                            <div class="col">
                                <label class="form-label font-weight-bold">Waktu Upload</label>
                                <div class="form-group">
                                    <input style="font-weight: 700; background-color: #fff;" type="text" name="status " value="$data->waktu_upload ?? '' }}" class="form-control" disabled>
                                </div><!--form-group-->
                            </div><!--col-->
                        </div><!--row-->
                        <img src="/app/public/bukti-transfer/$data->bukti_tf ?? '' }}" class="img-fluid rounded" alt="">
                    @endif --}}
                </div><!-- card-body -->
            </div><!-- card -->
        </div>
    </div><!-- col-md-8 -->
</div><!-- row -->
@stack('before-scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script> --}}

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
                    url: '/upload-invoice',
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

@push('after-scripts')
@if(config('access.captcha.registration'))
@captchaScripts
@endif
@endpush
