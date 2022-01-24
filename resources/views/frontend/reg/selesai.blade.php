@extends('frontend.layouts.reg')

@section('title', 'Selesai')

@section('content')
    <div class="container py-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <x-frontend.card>

                    <x-slot name="body">
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
                                <p class="text-center">
                                    Pendaftaran selesai.
                                    <br>
                                    Mohon periksa <u>notifikasi WhatsApp</u> yang kami kirimkan dan tunggu proses konfirmasi dari kami.
                                    <br>
                                    Syukron.
                                </p>
                            </div><!--row-->
                        </div><!--row-->
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

@endsection
