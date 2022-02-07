@extends('frontend.layouts.reg')

@section('title', 'Registrasi')

@section('content')
@stack('before-styles')
    <link rel="stylesheet" type="text/css" href="/filepond/app.css">
@stack('after-styles')
    <div class="container py-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <x-frontend.card>

                    <x-slot name="body">
                        <div class="form-horizontal">
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
                            <h4 class="pb-2 text-center">
                                Pendaftaran Sudah Ditutup. <br>
                            </h4>
                            <h2 class="text-center">
                                شكراً
                            </h2>
                        </div>
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
                    url: 'upload-bukti-tf',
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
