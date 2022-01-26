@foreach ($dataexport as $data)
    {{ $data->gender === "L" ? "Mahasantri 04" : "Mahasantriwati 04" }}|{{ $data->gender === "L" ? "MI04".str_pad($data->id, 4, '0', STR_PAD_LEFT) : "MA04".str_pad($data->id, 4, '0', STR_PAD_LEFT) }}|{{ ucwords(strtolower($data->nama)) }}|{{ $data->gender }}
    <br>
@endforeach
