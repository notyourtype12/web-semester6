
$(document).ready(function () {
    // ================= DELETE =================
    $(document).on("click", ".btnDeleteKeluarga", function (e) {
        e.preventDefault();

        const id = $(this).data("id");
        const nama = $(this).data("nama_lengkap");

        swal({
            title: "Yakin ingin menghapus?",
            text: `Data surat "${nama}" akan dihapus!`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                swal({
                    title: "Berhasil!",
                    text: "Data berhasil dihapus",
                    icon: "success",
                    buttons: false,
                    timer: 3000,
                });

                setTimeout(() => {
                    $("#formHapus" + id).submit();
                }, 500);
            }
        });
    });

    // ================= TAMBAH =================
    $("#btnTambah").click(function () {
        let form = $("#keluargaForm");

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/admin/master_kartukeluarga/masuk");

        $("#modalKeluargaLabel").text("Tambah Data Kepala Keluarga");

        var myModal = new bootstrap.Modal(
            document.getElementById("modalKeluarga"),
        );
        myModal.show();
    });

    // ================= EDIT =================
    $(".btnEditKeluarga").click(function () {
        let data = $(this).data();

        $("#modalKeluargaLabel").text("Edit Data Kepala Keluarga");

        let form = $("#keluargaForm");
        let actionUrl = "/admin/master_kartukeluarga/" + data.no_kk;

        form.attr("action", actionUrl);
        form.find('input[name="_method"]').remove();
        form.append('<input type="hidden" name="_method" value="PUT">');

        $("#no_kk").val(data.no_kk);
        $("#nik").val(data.nik);
        $("#nama_lengkap").val(data.nama_lengkap);
        $("#alamat").val(data.alamat);
        $("#rt").val(data.rt);
        $("#rw").val(data.rw);
        $("#kode_pos").val(data.kode_pos);
        $("#desa").val(data.desa);
        $("#kecamatan").val(data.kecamatan);
        $("#kabupaten").val(data.kabupaten);
        $("#provinsi").val(data.provinsi);
        $("#tanggal_dibuat").val(data.tanggal_dibuat);

        var myModal = new bootstrap.Modal(
            document.getElementById("modalKeluarga"),
        );
        myModal.show();
    });

    // ================= AUTO RESET =================
    $("#modalKeluarga").on("hidden.bs.modal", function () {
        let form = $("#keluargaForm");

        form[0].reset();
        form.find('input[name="_method"]').remove();
        form.attr("action", "/admin/master_kartukeluarga/masuk");

        form.find("input").not("[type=hidden]").val("");

        $("#modalKeluargaLabel").text("Tambah Data Kepala Keluarga");
    });
});

document.getElementById("tanggal_dibuat").addEventListener("focus", function (e) {
    this.showPicker && this.showPicker(); // Untuk browser yang support showPicker()
});

const input = document.getElementById('input-cari');
    let timeout = null;

input.addEventListener('input', function () {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        document.getElementById('form-cari').submit();
    }, 500); // tunggu 500ms setelah mengetik terakhir
});
