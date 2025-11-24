<tbody id="invoiceItems" style="font-size: 10px;">
    @php
    $no = 1;
    @endphp
    @foreach ($peserta as $pesertas)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $pesertas->mou_peserta_nip }}</td>
        {{-- <td>{{ $pesertas->mou_peserta_nik }}</td> --}}
        <td>{{ $pesertas->mou_peserta_name }}</td>
        {{-- <td>{{ $pesertas->mou_peserta_ttl }}</td> --}}
        <td>
            @if ($pesertas->mou_peserta_jk == 'L')
            Laki - Laki
            @else
            Perempuan
            @endif
        </td>
        <td>{{ $pesertas->mou_peserta_email }}</td>
        <td>{{ $pesertas->mou_peserta_no_hp }}</td>
        <td>{{ $pesertas->mou_peserta_departemen }}</td>
        {{-- <td>

                            @if ($lokasi)
                            {{ $lokasi->master_cabang_city }}
        @else
        @endif
        </td> --}}
        <td>
            @php
            $lokasi = DB::table('log_lokasi_pasien')
            ->join(
            'master_cabang',
            'master_cabang.master_cabang_code',
            '=',
            'log_lokasi_pasien.lokasi_cabang',
            )
            ->where('log_lokasi_pasien.mou_peserta_code', $pesertas->mou_peserta_code)
            ->first();
            @endphp
            @if ($lokasi)
            {{ $lokasi->master_cabang_name }}
            @else
            @endif
        </td>

        <td style="text-align: center;">
            @php
            $ttd = DB::table('log_kehadiran_pasien')
            ->where('mou_peserta_code', $pesertas->mou_peserta_code)
            ->where('log_kehadiran_pasien_status', 1)
            ->first();
            @endphp
            @if ($ttd)
            <img src="{{$ttd->log_kehadiran_pasien_sign}}" width="50"> <br>
            {{$ttd->log_kehadiran_pasien_time}}
            @else
            <strong style="color: rgb(199, 27, 24)">Belum</strong>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>
