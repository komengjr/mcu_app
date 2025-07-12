<div class="modal-body p-0">
    <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
        <h4 class="mb-1" id="staticBackdropLabel">Data Peserta MCU : <strong
                class="text-primary">{{ $data->master_company_name }} - {{ $data->company_mou_name }}</strong></h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
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
                        {{-- <div class="row gx-2 align-items-center">
                            <div class="col-auto">
                                <form class="row gx-2">
                                    <div class="col-auto"><small>Sort by:</small></div>
                                    <div class="col-auto">
                                        <select class="form-select form-select-sm" aria-label="Bulk actions">
                                            <option selected="">Best Match</option>
                                            <option value="Refund">Newest</option>
                                            <option value="Delete">Price</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto pe-0">
                                <a class="text-600 px-1" href="../../../app/e-commerce/product/product-list.html"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="Product List" aria-label="Product List"><svg
                                        class="svg-inline--fa fa-list-ul fa-w-16" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="list-ul" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M48 48a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm0 160a48 48 0 1 0 48 48 48 48 0 0 0-48-48zm448 16H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content p-3" id="menu-nik-nip">
        <table id="data-v3" class="table table-striped nowrap" style="width:100%">
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
</script>
