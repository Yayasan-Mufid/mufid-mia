@php
$first  = 0;
$end    = 0;
@endphp
@foreach ($dataexport as $key => $data)
    {{ $data->gender === "L" ? "Mahasantri 04" : "Mahasantriwati 04" }}|{{ $data->gender === "L" ? "MI04".str_pad($key + $dataexport->firstItem(), 4, '0', STR_PAD_LEFT) : "MA04".str_pad($key + $dataexport->firstItem(), 4, '0', STR_PAD_LEFT) }}|{{ ucwords(strtolower($data->nama)) }}|{{ $data->gender }}
    <br>
@php
$first  = $dataexport->firstItem();
$end    = $key + $dataexport->firstItem();
@endphp
@endforeach
