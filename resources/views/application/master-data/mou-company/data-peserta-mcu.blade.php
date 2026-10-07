<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    @if (Auth::user()->access_code == 'master')
    <div class="p-3">
        <div class="card border">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col-sm-auto mb-2 mb-sm-0">
                        <h6>Menu</h6>
                    </div>
                    <div class="col-sm-auto">
                        <button class="btn btn-danger btn-sm" id="button-sinkron-nip-nik"
                            data-code="{{ $data->company_mou_code }}">Sinkron NIK -> NIP</button>
                        <button class="btn btn-warning btn-sm" id="button-hapus-double"
                            data-code="{{ $data->company_mou_code }}">
                            <span class="fas fa-user-slash me-1"></span> Hapus Peserta Double
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="tab-content p-3 pt-0" id="menu-nik-nip">
        <table id="data-v3" class="table table-striped nowrap border" style="width:100%">
            <thead class="bg-200 text-700 fs--2">
                <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>NIK</th>
                    <th>TTL</th>
                    <th>Jenis Kelamin</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>NIP</th>
                    <th>Departemen</th>
                    <th>Paket</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="fs--2">
                @php
                $no = 1;
                @endphp
                @foreach ($peserta as $pesertas)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pesertas->mou_peserta_name }}</td>
                    <td>{{ $pesertas->mou_peserta_nik }}</td>
                    <td>{{ $pesertas->mou_peserta_ttl }}</td>
                    <td>
                        @if ($pesertas->mou_peserta_jk == 'L')
                        Laki - Laki
                        @else
                        Perempuan
                        @endif
                    </td>
                    <td>{{ $pesertas->mou_peserta_email }}</td>
                    <td>{{ $pesertas->mou_peserta_no_hp }}</td>
                    <td>{{ $pesertas->mou_peserta_nip }}</td>
                    <td>{{ $pesertas->mou_peserta_departemen }}</td>
                    <td>
                        @php
                        $paket = DB::table('company_mou_agreement')
                        ->where('mou_agreement_code', $pesertas->mou_agreement_code)
                        ->first();
                        @endphp
                        @if ($paket)
                        {{ $paket->mou_agreement_name }}
                        @else
                        <span class="badge bg-danger">Belum Memilih Paket</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-falcon-primary dropdown-toggle" id="btnGroupVerticalDrop2"
                                type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><span class="fas fa-align-left me-1"
                                    data-fa-transform="shrink-3"></span>Option</button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop2">
                                <button class="dropdown-item text-primary" id="button-update-data-peserta-mcu" data-code="{{$pesertas->mou_peserta_code}}"><span
                                        class="far fa-edit"></span>
                                    Edit Peserta</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-warning" id="button-reset-data-signature-mcu" data-code="{{$pesertas->mou_peserta_code}}"><span
                                        class="fas fa-signature"></span>
                                    Reset Signature</button>
                                <div class="dropdown-divider"></div>
                                <button class="dropdown-item text-danger" id="button-remove-data-signature-mcu" data-code="{{$pesertas->mou_peserta_code}}"><span
                                        class="fas fa-trash"></span>
                                    Hapus Peserta
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    new DataTable('#data-v3', {
        responsive: true
    });

    // Script untuk tombol Hapus Peserta Double
    $(document).on('click', '#button-hapus-double', function() {
        let code = $(this).data('code');

        if (confirm('Yakin ingin menghapus peserta yang double? Peserta yang sudah memiliki data transaksi/log lokasi tidak akan dihapus.')) {
            $.ajax({
                url: "{{ route('mou.peserta.hapus_double') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    code: code
                },
                beforeSend: function() {
                    // Opsional: tampilkan loading
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // Reload halaman untuk memperbarui tabel
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus data double.');
                }
            });
        }
    });
</script>
