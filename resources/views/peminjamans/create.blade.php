@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-semibold text-dark">📚 Tambah Peminjaman Alat</h3>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">← Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light fw-semibold">
                     Informasi Peminjaman
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="nama_peminjam" class="form-control" placeholder="Masukkan nama peminjam" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Kembali</label>
                            <input type="date" name="tanggal_kembali" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold"> Daftar Alat Dipinjam</span>
                    <button type="button" class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPilihAlat">
                        ➕ Tambah Alat
                    </button>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0" id="tabelPinjam">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Nama Alat</th>
                                    <th>Kode</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center text-muted" id="emptyRow">
                                    <td colspan="5">Belum ada alat dipilih</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="2"
                                placeholder="Catatan tambahan jika ada"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            💾 Simpan Peminjaman
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PILIH ALAT --}}
<div class="modal fade" id="modalPilihAlat" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Pilih Alat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchAlat" class="form-control mb-3" placeholder="Cari nama/kode alat...">
                <div id="listAlatModal" class="list-group"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputSearch = document.getElementById('searchAlat');
    const listAlat = document.getElementById('listAlatModal');
    const modalPilihAlat = document.getElementById('modalPilihAlat');
    const tbody = document.querySelector('#tabelPinjam tbody');

    // Load semua alat saat modal dibuka
    modalPilihAlat.addEventListener('shown.bs.modal', () => {
    inputSearch.focus();
    loadAlat('');
    });


    // AJAX search realtime
    inputSearch.addEventListener('keyup', () => loadAlat(inputSearch.value));

    function loadAlat(keyword = '') {
        axios.get('{{ route("alat.search") }}', { params: { search: keyword } })
        .then(res => {
            listAlat.innerHTML = '';
            res.data.forEach(alat => {
                const item = document.createElement('button');
                item.className = 'list-group-item list-group-item-action';
                item.textContent = `${alat.nama_alat} — (${alat.kode_alat})`;

                item.addEventListener('click', () => {
                    tambahKeList(alat);
                    bootstrap.Modal.getInstance(modalPilihAlat).hide();
                });

                listAlat.appendChild(item);
            });
        })
        .catch(err => {
            console.error(err.response?.data || err);
            listAlat.innerHTML = '<div class="text-danger p-2">Gagal memuat data alat.</div>';
        });
    }

    function tambahKeList(alat) {
        // ❌ Cegah duplikasi
        if (document.getElementById(`row-${alat.kode_alat}`)) {
            Swal.fire({
                icon: 'warning',
                title: 'Duplikasi Alat',
                text: 'Alat ini sudah dipilih sebelumnya.',
                confirmButtonText: 'OK'
            });
            return;
        }


        const row = document.createElement('tr');
        row.id = `row-${alat.kode_alat}`;
        row.innerHTML = `
            <td class="text-center"></td>
            <td>
                <strong>${alat.nama_alat}</strong>
                <input type="hidden" name="items[${alat.kode_alat}][nama]" value="${alat.nama_alat}">
            </td>
            <td>
                ${alat.kode_alat}
                <input type="hidden" name="items[${alat.kode_alat}][kode]" value="${alat.kode_alat}">
            </td>
            <td>
                <input type="number"
                       name="items[${alat.kode_alat}][qty]"
                       class="form-control"
                       value="1"
                       min="1"
                       required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm">🗑</button>
            </td>
        `;

        row.querySelector('button').onclick = () => {
            row.remove();
            refreshNo();
        };

        tbody.appendChild(row);
        refreshNo();
    }

    function refreshNo() {
        const rows = document.querySelectorAll('#tabelPinjam tbody tr:not(#emptyRow)');
        document.getElementById('emptyRow')?.classList.toggle('d-none', rows.length > 0);

        rows.forEach((tr, i) => {
            tr.children[0].innerText = i + 1;
        });
    }

});

document.querySelector('form').addEventListener('submit', function(e) {
    const pinjam = document.querySelector('[name="tanggal_pinjam"]').value;
    const kembali = document.querySelector('[name="tanggal_kembali"]').value;

    if (kembali < pinjam) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Tanggal tidak valid',
            text: 'Tanggal kembali tidak boleh lebih awal dari tanggal pinjam'
        });
    }

    if (!document.querySelector('#tabelPinjam tbody tr:not(#emptyRow)')) {
        e.preventDefault();
        Swal.fire('Oops', 'Pilih minimal satu alat', 'warning');
    }
});
    
</script>

@endsection
