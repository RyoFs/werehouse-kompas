@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">👥 Kelola Pengguna</h4>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        ➕ Tambah User
    </button>
</div>

{{-- TABLE --}}
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{-- EDIT --}}
                            <button
                                class="btn btn-warning btn-sm edit-btn"
                                data-id="{{ $user->id }}"
                                data-name="{{ $user->name }}"
                                data-email="{{ $user->email }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editUserModal">
                                ✏️ Edit
                            </button>

                            {{-- DELETE --}}
                            <form action="{{ route('user.destroy', $user->id) }}"
                                method="POST"
                                class="d-inline form-delete-user">
                                @csrf
                                @method('DELETE')

                                <button type="button" class="btn btn-danger btn-sm btn-delete-user">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada data user
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL EDIT USER --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" id="formEditUser" class="modal-content">
            @csrf
            @method('PUT')

            <div class="modal-header bg-warning">
                <h5 class="modal-title">✏️ Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="editEmail" class="form-control" required>
                </div>

                <div class="mb-3">
                <label class="form-label">
                    Password <small class="text-muted">(opsional)</small>
                </label>

                <div class="input-group">
                    <input
                        type="password"
                        id="editPassword"
                        name="password"
                        class="form-control"
                        placeholder="Kosongkan jika tidak diubah"
                    >

                    <button type="button"
                            class="btn btn-outline-secondary"
                            onclick="togglePasswordById('editPassword', 'edit-eye-off', 'edit-eye-on')">
                        <svg id="edit-eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3l18 18M10.58 10.58a3 3 0 004.24 4.24"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.88 9.88l4.24 4.24"/>
                        </svg>

                        <svg id="edit-eye-on" style="display:none" xmlns="http://www.w3.org/2000/svg"
                            width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    c4.478 0 8.268 2.943 9.542 7
                                    -1.274 4.057-5.064 7-9.542 7
                                    -4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-warning">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TAMBAH USER --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('user.store') }}" method="POST" class="modal-content">
            @csrf

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">➕ Tambah User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                <label class="form-label">Password</label>

                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="masukan password min 6 karakter"
                        required
                    >

                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <svg id="eye-off" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/>
                        </svg>

                        <svg id="eye-on" style="display:none" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>


            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT EDIT USER --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       EDIT USER (ISI DATA)
    ========================== */
    const editButtons = document.querySelectorAll('.edit-btn');
    const formEdit    = document.getElementById('formEditUser');
    const nameInput   = document.getElementById('editName');
    const emailInput  = document.getElementById('editEmail');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id    = this.dataset.id;
            const name  = this.dataset.name;
            const email = this.dataset.email;

            formEdit.action = "{{ route('user.update', ':id') }}".replace(':id', id);
            nameInput.value  = name;
            emailInput.value = email;
        });
    });

    /* =========================
       RESET PASSWORD SAAT MODAL DITUTUP
    ========================== */
    const editModal     = document.getElementById('editUserModal');
    const editPassword  = document.getElementById('editPassword');
    const editEyeOff    = document.getElementById('edit-eye-off');
    const editEyeOn     = document.getElementById('edit-eye-on');

    editModal.addEventListener('hidden.bs.modal', function () {
        editPassword.value = '';
        editPassword.type  = 'password';

        editEyeOff.style.display = 'block';
        editEyeOn.style.display  = 'none';
    });
    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('.form-delete-user');

            Swal.fire({
                title: 'Yakin hapus user?',
                text: 'User yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});


/* =========================
   TOGGLE PASSWORD TAMBAH USER
========================== */
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeOff = document.getElementById('eye-off');
    const eyeOn  = document.getElementById('eye-on');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOff.style.display = 'none';
        eyeOn.style.display  = 'block';
    } else {
        passwordInput.type = 'password';
        eyeOff.style.display = 'block';
        eyeOn.style.display  = 'none';
    }
}


/* =========================
   TOGGLE PASSWORD EDIT USER
========================== */
function togglePasswordById(inputId, eyeOffId, eyeOnId) {
    const input  = document.getElementById(inputId);
    const eyeOff = document.getElementById(eyeOffId);
    const eyeOn  = document.getElementById(eyeOnId);

    if (!input) return;

    if (input.type === 'password') {
        input.type = 'text';
        eyeOff.style.display = 'none';
        eyeOn.style.display  = 'block';
    } else {
        input.type = 'password';
        eyeOff.style.display = 'block';
        eyeOn.style.display  = 'none';
    }
}
</script>


@endsection
