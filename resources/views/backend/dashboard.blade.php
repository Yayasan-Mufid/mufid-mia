@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')

    <div class="card" style="min-width: 1000px">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h4 class="card-title mb-0">
                        Data Pendaftaran
                    </h4>
                </div><!--col-->
            </div><!--row-->

            <form class="row mt-4" action="{{ url()->current() }}">
                <div class="col-12">
                    <div class="d-print-none row mt-4">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="pb-2 col-6" >
                                    <div style="padding-top: 5px; padding-bottom: 5px">
                                        <label class="form-check-label">Nama / Email / No. HP</label>
                                    </div>
                                    <input class="form-control" type="text" value="{{ request()->nama ?? '' }}" name="nama" style="font-size: small" />
                                </div>
                                <div class="pb-2 col-6" >
                                    <div style="padding-top: 5px; padding-bottom: 5px">
                                        <label class="form-check-label">Alamat / Kota</label>
                                    </div>
                                    <input class="form-control" type="text" value="{{ request()->alamat ?? '' }}" name="alamat" style="font-size: small" />
                                </div>
                            </div>
                        </div>
                        <div class="pb-2 col">
                            <div  style="padding-top: 5px; padding-bottom: 5px">
                                <label class="form-check-label">Status</label>
                            </div>
                            <select id="status" name="status" class="form-control">
                                <option value="">Semua</option>
                                <option value="1">Konfirmasi</option>
                                <option value="2">Aktif</option>
                            </select>
                        </div>
                        <div class="pb-2 col">
                            <div  style="padding-top: 5px; padding-bottom: 5px">
                                <label class="form-check-label">Jenis</label>
                            </div>
                            <select id="jenis" name="jenis" class="form-control">
                                <option value="">Semua</option>
                                <option value="L">IKHWAN</option>
                                <option value="P">AKHWAT</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <div class="row">
                        <div class="col-1">
                            <select class="form-control form-control-sm" name="perpage" id="perpage">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <a href="#" data-toggle="modal" data-target="#exportdata" class="btn btn-sm btn-primary btn-success">
                                <i class="fas fa-download"></i> Export
                            </a>
                            {{-- <a href="/admin/transaksi/cnl/resi" class="btn btn-sm btn-primary ">
                                <i class="fas fa-book"></i> Resi CNL
                            </a> --}}
                        </div>
                        <div class="col text-right">
                        </div>
                        <div class="col-4 text-right" style="padding-bottom:20px;">
                            <div class="align-middle">
                                <button type="submit" class="btn btn-primary btn-sm btn-block btn-pill" > <i class="fas fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row kotak-atas" style="font-size: 11px; text-transform: uppercase; font-weight: 600">
                <div class="col-2">
                    Nama
                </div>
                <div class="col-3">
                    Email
                </div>
                <div class="col-2 pl-0">
                    Kontak
                </div>
                <div class="col-1">
                    Bukti TF
                </div>
                <div class="col">
                    Jenis
                </div>
            </div>

            <div class="row mt-4" style="margin-top: 0.35rem!important;">
                <div class="col">
                    @php
                    $first  = 0;
                    $end    = 0;
                    @endphp
                    @foreach ($datapendaftar as $key => $data)
                    <div class="legend">
                        <div class="row kotak">
                            <div class="col-2">
                                <a data-toggle="collapse" href="#detail1"
                                    aria-expanded="false" style="color: rgb(56, 56, 56);">
                                    <div><strong>{{ $data->nama }}</strong></div>
                                    <div class="small text-muted">
                                        @php
                                            $birth = !empty($data->tgl_lahir) ? $data->tgl_lahir : \Carbon\Carbon::now()->format('Y-m-d');
                                            $umur = !empty(\Carbon\Carbon::parse($birth)->age) ? \Carbon\Carbon::parse($birth)->age : '0';
                                        @endphp
                                            {{ $data->tgl_lahir }} | {{ $umur ?? '-' }} Tahun
                                    </div>
                                </a>
                            </div>
                            <div class="col-3">
                                {{ $data->email }}
                                <div class="small text-muted">
                                    Daftar : {{ $data->created_at }}
                                </div>
                            </div>
                            <div class="col-2" style="margin-left: 0px">
                                <div class="row">
                                    <div class="col pl-0">
                                        <div class="text-muted" style="font-size: 11px">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>WhatsApp</td>
                                                        <td>: <strong>{{ $data->nohp_whatsapp }}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telegram</td>
                                                        <td>: <strong>{{ $data->nohp_telegram }}</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-1">
                                <div style="position; fixed">
                                    <img class="zoom" src="{{ '/bukti-transfer/'.$data->bukti_tf ?? '404.jpg' }}" alt="" height="50">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col-4">
                                        {{-- <a data-toggle="collapse" href="#detail{{ $key + $datapendaftar->firstItem() }}" aria-expanded="false"> --}}
                                        <a data-toggle="collapse" href="#detail1" aria-expanded="false">
                                            <div class="text-muted font-weight-bold" style="font-size: 12px; text-transform: uppercase;">
                                                @if ($data->gender == 'L')
                                                    IKHWAN
                                                @elseif ($data->gender == 'P')
                                                    AKHWAT
                                                @endif
                                            </div>
                                            <div class="text-muted" style="font-size: 9px; text-transform: uppercase;">
                                                ANGKATAN {{ $data->angkatan }}
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <form action="">
                                            <input type="hidden" name="metode" value="konfirmasi">
                                            {{-- <input type="hidden" name="id" value="{{ $data->id }}"> --}}
                                            <input type="hidden" name="id" value="{{ $data->id }}">
                                            @if ($data->status == 1)
                                                <button class="btn btn-warning" style="color:rgb(56, 56, 56)">
                                                    <i class="fas fa-edit"></i> Konfirmasi
                                                </button>
                                            @else
                                                <button class="btn btn-info">
                                                    <i class="fas fa-check"></i> Aktif
                                                </button>
                                            @endif
                                        </form>
                                        {{-- @include('backend.transaksi.includes.status') --}}
                                    </div>
                                    <div class="col-2" style="padding: 0px">

                                        <div class="btn-group dropleft">

                                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-cog"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                {{-- <a href="/admin/transaksi?id={{ $data->id }}&metode=edit" class="dropdown-item">
                                                    Edit
                                                </a> --}}
                                                <a href="#" title="Hapus" data-method="delete" data-trans-button-cancel="Batal" data-trans-button-confirm="Hapus"
                                                data-trans-title=" dihapus?" class=" dropdown-item" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                                    <form action=""  onsubmit="return confirm('Apakah Anda yakin data dihapus ?');" style="display:none">
                                                        <input type="hidden" name="metode" value="hapus">
                                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                                    </form>
                                                    Hapus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" style="color: #4e4e4e">
                                <div class="col">
                                    {{-- <div class="collapse" id="detail{{ $key + $datapendaftar->firstItem() }}"> --}}
                                    <div class="collapse" id="detail1">
                                        <hr>
                                        <table class="table table-sm table-borderless" style="margin-bottom: 0rem">
                                            <thead style="font-weight: 400;">
                                                <th width="200">Tgl. Konfirmasi</th>
                                                <th>Alamat</th>
                                                <th>Kota</th>
                                            </thead>
                                            <tbody style="font-weight: 300;">
                                                <tr>
                                                    <td>
                                                        {{ $data->waktu_konfirmasi }}
                                                    </td>
                                                    <td>
                                                        {{ $data->alamat }}
                                                    </td>
                                                    <td>
                                                        {{ $data->domisili }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                    $first  = $datapendaftar->firstItem();
                    $end    = $key + $datapendaftar->firstItem();
                    @endphp
                    @endforeach
                </div>
            </div>


            <div class="row">
                <div class="col-7">
                    <div class="float-left">
                        {!! $first !!} - {!! $end !!} From {!! $datapendaftar->total() !!} Data
                    </div>
                </div><!--col-->

                <div class="col-5">
                    <div class="float-right">
                        {!! $datapendaftar->appends(request()->query())->links() !!}
                    </div>
                </div><!--col-->
            </div><!--row-->
        </div><!--card-body-->
    </div><!--card-->
@endsection
