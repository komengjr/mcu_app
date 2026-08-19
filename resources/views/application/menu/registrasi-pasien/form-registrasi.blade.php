<style>
    /* Styling Badge & Chip Interaktif */
    .pemeriksaan-badge-container {
        max-height: 220px;
        overflow-y: auto;
        padding: 10px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    .badge-test-item {
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        font-size: 0.8rem !important;
        padding: 6px 12px !important;
        border-radius: 20px !important;
        user-select: none;
        display: inline-flex;
        align-items: center;
        margin: 3px;
    }

    .badge-test-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .badge-test-item.active-test {
        background-color: #e63757 !important;
        color: #ffffff !important;
        border-color: #e63757 !important;
    }

    /* Scrollbar Tipis Modern */
    .pemeriksaan-badge-container::-webkit-scrollbar {
        width: 5px;
    }

    .pemeriksaan-badge-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
</style>

<div class="modal-body p-0">
    <!-- Header Modal -->
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel"><i class="fas fa-user-plus me-2"></i>Form Order Pasien</h4>
        <p class="fs--2 mb-0 text-white-50">Support by <a class="link-light fw-semi-bold" href="#!">Transforma</a></p>
    </div>

    <div class="p-4">
        <!-- Form Main Pasien -->
        <form id="form-add-pasien" class="row g-3" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="token_registrasi" value="{{ $token }}" id="token_registrasi">

            <div class="col-md-12">
                <label class="form-label fw-bold" for="nama_lengkap">Nama Lengkap <small class="text-danger">*</small></label>
                <input class="form-control" id="nama_lengkap" type="text" name="nama_lengkap" placeholder="Contoh: JOHN DOE" style="text-transform: uppercase;" required />
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold" for="tgl_lahir">Tanggal Lahir <small class="text-danger">*</small></label>
                <input class="form-control" id="tgl_lahir" type="date" name="tgl_lahir" required />
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold" for="jk">Jenis Kelamin <small class="text-danger">*</small></label>
                <select name="jk" class="form-select" id="jk" required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L">Laki - Laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold" for="no_induk">NIK</label>
                <input class="form-control" id="no_induk" type="text" name="no_induk" placeholder="3517XXXXXXXXXXXX" />
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold" for="kurir">Nama Kurir</label>
                <input class="form-control" id="kurir" type="text" name="kurir" placeholder="Contoh: Ahmad Shobirin" />
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold" for="nama_rujukan">Pilih Perujuk <small class="text-danger">*</small></label>
                <select name="nama_rujukan" class="form-select choices-single-rujukan" id="nama_rujukan">
                    <option value="">Pilih Rujukan</option>
                    @foreach ($user as $users)
                    <option value="{{ $users->userid }}">{{ $users->fullname }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <hr class="my-4">

        <!-- Bagian Pemilihan Pemeriksaan via Badge -->
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-flask text-danger me-2"></i>Pilih Test Pemeriksaan</h5>
            <span class="badge bg-soft-info text-info"><i class="fas fa-mouse-pointer me-1"></i>Klik badge untuk menambah / menghapus</span>
        </div>

        <!-- Search Filter untuk Badge -->
        <div class="mb-2">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                <input type="text" id="search-pemeriksaan" class="form-control border-start-0" placeholder="Cari nama pemeriksaan di sini...">
            </div>
        </div>

        <!-- Container Badge Items -->
        <div class="pemeriksaan-badge-container mb-3" id="badge-container">
            @foreach ($pemeriksaan as $pem)
            <button type="button"
                class="btn btn-sm btn-outline-secondary badge-test-item"
                data-code="{{ $pem->master_test_code }}"
                data-name="{{ strtolower($pem->master_test_name) }}">
                <i class="fas fa-plus circle-icon me-1"></i>
                <span>{{ $pem->master_test_name }}</span>
            </button>
            @endforeach
        </div>

        <!-- Tabel Ringkasan Pemeriksaan Terpilih -->
        <div class="card border border-1 shadow-none">
            <div class="card-header bg-light py-2">
                <h6 class="mb-0 text-dark fw-bold fs--1"><i class="fas fa-list-check me-2"></i>Item Pemeriksaan Terpilih</h6>
            </div>
            <div class="card-body p-0" id="table-pemeriksaan-pasien">
                <table class="table table-striped table-sm fs--1 mb-0" style="width:100%">
                    <thead class="bg-200 text-800">
                        <tr>
                            <th width="8%" class="ps-3">No</th>
                            <th>Nama Test Pemeriksaan</th>
                            <th width="15%" class="text-center pe-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">
                                <em>Belum ada pemeriksaan yang dipilih. Silakan klik badge di atas.</em>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer bg-light" id="loading-button">
    <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Batal</button>
    <button class="btn btn-danger btn-sm px-4" type="button" id="button-save-data-pasien">
        <i class="fas fa-paper-plane me-1"></i> Simpan & Kirim
    </button>
</div>

<script>
    $(document).ready(function() {
        // 1. Inisialisasi Choices.js
        if (document.querySelector(".choices-single-rujukan")) {
            new window.Choices(document.querySelector(".choices-single-rujukan"));
        }

        // 2. Filter / Search Realtime untuk Badge
        $("#search-pemeriksaan").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".badge-test-item").filter(function() {
                $(this).toggle($(this).data("name").indexOf(value) > -1);
            });
        });

        // 3. Handling Klik Badge Pemeriksaan (Toggle Tambah & Hapus)
        $(document).off("click", ".badge-test-item").on("click", ".badge-test-item", function(e) {
            e.preventDefault();

            var $badge = $(this);
            var testCode = $badge.data("code");
            var tokenReg = $("#token_registrasi").val();

            // Validasi Form Identitas Pasien Dulu
            const nama = $("#nama_lengkap").val();
            const tgl_lahir = $("#tgl_lahir").val();
            const jk = $("#jk").val();

            if (nama === "" || tgl_lahir === "" || jk === "") {
                Swal.fire({
                    icon: "error",
                    title: "Perhatian",
                    text: "Mohon isi Nama Lengkap, Tanggal Lahir, dan Jenis Kelamin terlebih dahulu!",
                });
                return;
            }

            // A. JIKA BADGE BELUM AKTIF -> SIMPAN ITEM
            if (!$badge.hasClass("active-test")) {

                $('#table-pemeriksaan-pasien').html(
                    '<div class="text-center my-3"><div class="spinner-border text-danger spinner-border-sm" role="status"></div> Menambahkan...</div>'
                );

                $.ajax({
                    url: "{{ route('monitoring_hasil_save_pemeriksaan') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "data_registrasi": tokenReg,
                        "data_pemeriksaan": testCode
                    },
                    dataType: 'html',
                }).done(function(data) {
                    // Update tampilan badge
                    $badge.addClass("active-test").removeClass("btn-outline-secondary");
                    $badge.find("i").removeClass("fa-plus").addClass("fa-check");

                    // Render ulang table
                    $('#table-pemeriksaan-pasien').html(data);
                }).fail(function() {
                    Swal.fire('Error', 'Gagal menambahkan data pemeriksaan', 'error');
                });

            } else {
                // B. JIKA BADGE SUDAH AKTIF -> HAPUS ITEM

                $('#table-pemeriksaan-pasien').html(
                    '<div class="text-center my-3"><div class="spinner-border text-danger spinner-border-sm" role="status"></div> Menghapus...</div>'
                );

                $.ajax({
                    url: "{{ route('monitoring_hasil_remove_pemeriksaan') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "code": testCode, // dikirim sebagai master_test_code / code
                        "data_pemeriksaan": testCode, // dikirim cadangan jika controller pakai key ini
                        "reg": tokenReg,
                        "data_registrasi": tokenReg
                    },
                    dataType: 'html',
                }).done(function(data) {
                    // Update tampilan badge kembali ke awal
                    $badge.removeClass("active-test").addClass("btn-outline-secondary");
                    $badge.find("i").removeClass("fa-check").addClass("fa-plus");

                    // Render ulang table
                    $('#table-pemeriksaan-pasien').html(data);
                }).fail(function() {
                    Swal.fire('Error', 'Gagal menghapus item pemeriksaan', 'error');
                });
            }
        });

        // 4. Handling tambahan jika user menghapus data LANGSUNG dari Tombol Hapus di dalam Tabel
        $(document).off("click", "#button-remove-pemeriksaan_pasien").on("click", "#button-remove-pemeriksaan_pasien", function(e) {
            e.preventDefault();
            var testCode = $(this).data("code");
            var reg = $(this).data("reg");

            $('#table-pemeriksaan-pasien').html(
                '<div class="text-center my-3"><div class="spinner-border text-danger spinner-border-sm" role="status"></div> Menghapus...</div>'
            );

            $.ajax({
                url: "{{ route('monitoring_hasil_remove_pemeriksaan') }}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": testCode,
                    "reg": reg
                },
                dataType: 'html',
            }).done(function(data) {
                // Kembalikan status badge terkait di atas menjadi non-aktif
                var $badge = $('.badge-test-item[data-code="' + testCode + '"]');
                if ($badge.length) {
                    $badge.removeClass("active-test").addClass("btn-outline-secondary");
                    $badge.find("i").removeClass("fa-check").addClass("fa-plus");
                }

                $('#table-pemeriksaan-pasien').html(data);
            }).fail(function() {
                Swal.fire('Error', 'Gagal menghapus item', 'error');
            });
        });
    });
</script>
