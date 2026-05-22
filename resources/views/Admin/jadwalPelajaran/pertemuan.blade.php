@extends('Layouts.template-admin')

@section('title', 'Pertemuan Pelajaran')

@section('breadcrumb')
    <ol class="breadcrumb justify-content-sm-start align-items-center mb-0">
        <li class="breadcrumb-item">
            <a href="/dashboard">
                <i data-feather="home"> </i>
            </a>
        </li>
        <li class="breadcrumb-item f-w-400 active">
            <a href="{{ route('jadwal.index') }}">Jadwal Pelajaran</a>
        </li>
        <li class="breadcrumb-item f-w-400 active">@yield('title')</li>
    </ol>
@endsection

@section('content')
    <div class="row">

        {{-- HEADER --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-body p-4">

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                        <div>
                            <h4 class="fw-bold mb-1">
                                {{ $jadwal->mataPelajaran->nama_mata_pelajaran }}
                            </h4>

                            <div class="text-muted">

                                Kelas
                                <strong>
                                    {{ $jadwal->kelas->nama_kelas }}
                                </strong>

                                •

                                {{ $jadwal->hari }}

                                •

                                {{ $jadwal->sesi->nama_sesi }}

                                ({{ $jadwal->sesi->jam_mulai }}
                                -
                                {{ $jadwal->sesi->jam_selesai }})

                            </div>

                            <div class="mt-2">

                                <span class="badge bg-primary-subtle text-primary">
                                    Semester {{ $jadwal->semester }}
                                </span>

                                <span class="badge bg-success-subtle text-success">
                                    {{ $jadwal->tahun_ajaran }}
                                </span>

                            </div>
                        </div>

                        <div>
                            <a href="{{ route('jadwal.index') }}" class="btn btn-light border rounded-pill px-4">

                                <i data-feather="arrow-left" class="me-1"></i>
                                Kembali

                            </a>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- STATISTIK --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Pertemuan
                            </p>

                            <h3 class="fw-bold mb-0">
                                {{ $pertemuanList->total() }}
                            </h3>

                        </div>

                        <div class="icon-box bg-primary-subtle text-primary rounded-circle">
                            <i data-feather="book-open"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Pertemuan Selesai
                            </p>

                            <h3 class="fw-bold mb-0 text-success">
                                {{ $pertemuanList->where('status', 'selesai')->count() }}
                            </h3>

                        </div>

                        <div class="icon-box bg-success-subtle text-success rounded-circle">
                            <i data-feather="check-circle"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Belum Dilaksanakan
                            </p>

                            <h3 class="fw-bold mb-0 text-warning">
                                {{ $pertemuanList->where('status', 'belum')->count() }}
                            </h3>

                        </div>

                        <div class="icon-box bg-warning-subtle text-warning rounded-circle">
                            <i data-feather="clock"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                <div class="card-header bg-white border-0 p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Daftar Pertemuan
                            </h5>

                            <p class="text-muted mb-0">
                                Kelola pertemuan, materi pembelajaran, dan absensi siswa.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Pertemuan
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th>
                                    Materi
                                </th>

                                <th>
                                    Status
                                </th>

                                <th class="text-center pe-4">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($pertemuanList as $pertemuan)
                                <tr>

                                    <td class="ps-4">

                                        <div class="fw-semibold">
                                            Pertemuan
                                            {{ $pertemuan->pertemuan_ke }}
                                        </div>

                                    </td>

                                    <td>

                                        {{ $pertemuan->tanggal->format('d F Y') }}

                                    </td>

                                    <td>

                                        @if ($pertemuan->materi)
                                            <div class="text-dark">
                                                {{ $pertemuan->materi }}
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic">
                                                Belum ada materi
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        <span
                                            class="badge bg-{{ $pertemuan->status_badge }}-subtle text-{{ $pertemuan->status_badge }} px-3 py-2 rounded-pill">

                                            {{ ucfirst($pertemuan->status) }}

                                        </span>

                                    </td>

                                    <td class="text-center pe-4">

                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- ABSENSI --}}
                                            <a href="{{ route('absensi.index', [
                                                'jadwal' => $jadwal->id_jadwal_pelajaran,
                                                'pertemuan' => $pertemuan->id_pertemuan,
                                            ]) }}"
                                                class="btn btn-sm btn-primary rounded-pill px-3">

                                                <i data-feather="check-square" class="icon-sm me-1"></i>

                                                Absensi

                                            </a>

                                            {{-- EDIT --}}
                                            <button class="btn btn-sm btn-light border rounded-pill px-3">

                                                <i data-feather="edit" class="icon-sm me-1"></i>

                                                Materi

                                            </button>

                                        </div>

                                    </td>

                                </tr>
                            @empty
                                <tr>

                                    <td colspan="5" class="text-center py-5">

                                        <div class="text-muted">

                                            <i data-feather="calendar" style="width: 48px; height: 48px;"
                                                class="mb-3"></i>

                                            <h6 class="fw-semibold">
                                                Belum Ada Pertemuan
                                            </h6>

                                            <p class="mb-0">
                                                Pertemuan otomatis akan muncul
                                                setelah jadwal dibuat.
                                            </p>

                                        </div>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                @if ($pertemuanList->hasPages())
                    <div class="card-footer bg-white border-0 p-4">

                        {{ $pertemuanList->links() }}

                    </div>
                @endif

            </div>

        </div>

    </div>

    {{-- MODAL EDIT PERTEMUAN --}}
    <div class="modal fade" id="editPertemuanModal" tabindex="-1" aria-labelledby="editPertemuanModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4 overflow-hidden">

                {{-- HEADER --}}
                <div class="modal-header bg-primary text-white border-0">

                    <div>
                        <h5 class="modal-title fw-bold" id="editPertemuanModalLabel">

                            Edit Pertemuan

                        </h5>

                        <small class="text-white-50">
                            Kelola materi dan status pembelajaran
                        </small>
                    </div>

                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                </div>

                {{-- FORM --}}
                <form method="POST" id="formEditPertemuan">

                    @csrf
                    @method('PUT')

                    <div class="modal-body p-4">

                        {{-- INFO --}}
                        <div class="alert alert-light border rounded-4 mb-4">

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <small class="text-muted d-block">
                                        Pertemuan
                                    </small>

                                    <div class="fw-semibold" id="modal_pertemuan_ke">

                                        -

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <small class="text-muted d-block">
                                        Tanggal
                                    </small>

                                    <div class="fw-semibold" id="modal_tanggal">

                                        -

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <small class="text-muted d-block">
                                        Status
                                    </small>

                                    <div class="fw-semibold" id="modal_status_text">

                                        -

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- MATERI --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Materi Pembelajaran

                            </label>

                            <textarea name="materi" id="edit_materi" rows="4" class="form-control rounded-4"
                                placeholder="Masukkan materi pembelajaran..."></textarea>

                        </div>

                        {{-- CATATAN --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">

                                Catatan Guru

                            </label>

                            <textarea name="catatan" id="edit_catatan" rows="3" class="form-control rounded-4"
                                placeholder="Tambahkan catatan pembelajaran..."></textarea>

                        </div>

                        {{-- STATUS --}}
                        <div>

                            <label class="form-label fw-semibold">

                                Status Pertemuan

                            </label>

                            <select name="status" id="edit_status" class="form-select rounded-4">

                                <option value="belum">
                                    Belum Dilaksanakan
                                </option>

                                <option value="selesai">
                                    Selesai
                                </option>

                                <option value="dibatalkan">
                                    Dibatalkan
                                </option>

                            </select>

                        </div>

                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer border-0 px-4 pb-4">

                        <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-primary rounded-pill px-4">

                            <i data-feather="save" class="icon-sm me-1"></i>

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        // Inisialisasi Feather Icons
        feather.replace();

        // Event listener untuk tombol edit materi
        const editButtons = document.querySelectorAll('.btn-edit-materi');
        const editPertemuanModal = new bootstrap.Modal(document.getElementById('editPertemuanModal'));
        const formEditPertemuan = document.getElementById('formEditPertemuan');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const pertemuanId = button.getAttribute('data-id');
                const pertemuanKe = button.getAttribute('data-pertemuan-ke');
                const tanggal = button.getAttribute('data-tanggal');
                const materi = button.getAttribute('data-materi');
                const catatan = button.getAttribute('data-catatan');
                const status = button.getAttribute('data-status');

                // Isi data ke dalam modal
                document.getElementById('modal_pertemuan_ke').textContent = `Pertemuan ${pertemuanKe}`;
                document.getElementById('modal_tanggal').textContent = new Date(tanggal).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                document.getElementById('modal_status_text').textContent = status.charAt(0).toUpperCase() + status.slice(1);
                document.getElementById('edit_materi').value = materi || '';
                document.getElementById('edit_catatan').value = catatan || '';

                // Set action form
                formEditPertemuan.action = `/admin/pertemuan/${pertemuanId}/update`;

                // Tampilkan modal
                editPertemuanModal.show();
            });
        });
    </script>
