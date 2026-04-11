<div class="modal-body p-0">
    <div class="bg-danger rounded-top-lg py-3 ps-4 pe-6">
        <h4 style="color: white;" class="mb-1" id="staticBackdropLabel">Form Order Kurir</h4>
        <p class="fs--2 mb-0">Support by <a class="link-600 fw-semi-bold" href="#!">Transforma</a></p>
    </div>
    <div class="p-4">
        <p>Pilih Sample Pasien Yang akan di ambil kurir</p>
        <div id="table-pemeriksaan-pasien">
            <table id="data-pemeriksaan" class="table table-striped fs--2" style="width:100%">
                <thead class="bg-200 text-700">
                    <tr>
                        <th>No</th>
                        <th>Nama Test Pemeriksaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer" id="loading-button">
    <button class="btn btn-primary" type="button" id="button-save-order-kurir-sample-pasien"><span class="fas fa-save"></span> Simpan & Kirim</button>
</div>
<script>
    new DataTable('#data-pemeriksaan', {
        responsive: true
    });
    new window.Choices(document.querySelector(".choices-single-pemeriksaan"));
</script>
