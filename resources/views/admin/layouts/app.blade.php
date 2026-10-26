<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin CMS') | PKBM Al Falah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @php
        $adminSchoolProfile = \App\Models\SchoolProfile::first();
        $adminUser = auth()->user();
        $adminInitials = collect(explode(' ', $adminUser->name ?? 'Admin'))
            ->filter()
            ->take(2)
            ->map(fn($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');
    @endphp

    <div class="admin-shell" id="adminShell">
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-brand-wrap">
                <a class="admin-brand" href="{{ route('admin.index') }}">
                    @if ($adminSchoolProfile?->logo)
                        <img
                            src="{{ asset('storage/' . ltrim($adminSchoolProfile->logo, '/')) }}"
                            alt="Logo PKBM Al Falah"
                            class="admin-brand-logo-img"
                        >
                    @else
                        <span class="admin-brand-logo-badge" aria-hidden="true">
                            <i class="mdi mdi-school-outline"></i>
                        </span>
                    @endif
                    <div class="admin-brand-text">
                        <strong>PKBM Al Falah</strong>
                        <span>Sumur Batu</span>
                    </div>
                </a>
            </div>

            <nav class="admin-nav" aria-label="Navigasi admin">
                <div class="admin-nav-section">
                    <a href="{{ route('admin.index') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.index')])>
                        <i class="mdi mdi-view-dashboard-outline admin-nav-icon"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <span class="admin-nav-group-label">Website</span>
                    <a href="{{ route('admin.school-profile.information') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.school-profile.*')])>
                        <i class="mdi mdi-information-outline admin-nav-icon"></i>
                        <span>Informasi Umum</span>
                    </a>
                    <a href="{{ route('admin.organization-structures.index') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.organization-structures.*')])>
                        <i class="mdi mdi-sitemap-outline admin-nav-icon"></i>
                        <span>Struktur Organisasi</span>
                    </a>
                    <a href="{{ route('admin.documentation-events.index') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.documentation-events.*')])>
                        <i class="mdi mdi-image-multiple-outline admin-nav-icon"></i>
                        <span>Dokumentasi</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <span class="admin-nav-group-label">Pendaftaran</span>
                    <a href="{{ route('admin.registration.information') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.registration.*')])>
                        <i class="mdi mdi-account-plus-outline admin-nav-icon"></i>
                        <span>Informasi Pendaftaran</span>
                    </a>
                </div>

                <div class="admin-nav-section">
                    <span class="admin-nav-group-label">Guru</span>
                    <a href="{{ route('admin.teachers.index') }}" @class(['admin-nav-item', 'active' => request()->routeIs('admin.teachers.*')])>
                        <i class="mdi mdi-account-group-outline admin-nav-icon"></i>
                        <span>Data Guru</span>
                    </a>
                </div>
            </nav>

            <div class="admin-sidebar-footer">
                <div class="admin-sidebar-user">
                    <div class="admin-sidebar-avatar" aria-hidden="true">
                        {{ $adminInitials ?: 'AD' }}
                    </div>
                    <div class="admin-sidebar-user-meta">
                        <strong class="admin-sidebar-user-name">{{ $adminUser->name ?? 'Admin Sekolah' }}</strong>
                        <span class="admin-sidebar-user-role">Administrator</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="admin-sidebar-logout-form">
                    @csrf
                    <button class="admin-sidebar-logout-btn" type="submit" title="Logout dari sistem">
                        <i class="mdi mdi-logout"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button type="button" class="admin-sidebar-toggle" id="sidebarToggle" aria-label="Buka menu navigasi">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <div class="admin-topbar-title-wrap">
                        <strong class="admin-topbar-title">Administrator PKBM Al Falah</strong>
                        <p class="admin-topbar-subtitle">Kelola konten website dan data sekolah</p>
                    </div>
                </div>

                <div class="admin-topbar-right">
                    <div class="admin-topbar-status">
                        <span class="admin-status-dot"></span>
                        <span class="admin-status-text">Sistem Online</span>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if (session('status'))
                    <div class="admin-alert admin-alert-info">
                        <i class="mdi mdi-information admin-alert-icon"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if (session('success'))
                    <div class="admin-alert admin-alert-success">
                        <i class="mdi mdi-check-circle admin-alert-icon"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="admin-alert admin-alert-danger">
                        <i class="mdi mdi-alert-circle admin-alert-icon"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('temporary_password'))
                    <div class="admin-alert admin-alert-warning">
                        <i class="mdi mdi-key-variant admin-alert-icon"></i>
                        <div>
                            Password sementara akun: <strong>{{ session('temporary_password') }}</strong>
                            <small style="display: block; opacity: 0.85;">Harap salin password ini dan berikan kepada guru terkait.</small>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Live Preview for Single Image Upload
        window.previewSingleImage = function(input, previewId, placeholderId, infoId, clearBtnId, originalSrc) {
            const file = input.files && input.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const info = document.getElementById(infoId);
            const clearBtn = document.getElementById(clearBtnId);

            if (!file) return;

            if (!file.type.startsWith('image/')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Didukung',
                    text: 'Harap pilih file gambar (JPEG, PNG, JPG, WEBP, SVG).',
                    confirmButtonColor: '#15803D'
                });
                input.value = '';
                return;
            }

            const maxMb = parseFloat(input.dataset.maxSize || '4');
            const maxBytes = maxMb * 1024 * 1024;
            if (file.size > maxBytes) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran File Terlalu Besar',
                    text: `Ukuran file (${(file.size / (1024 * 1024)).toFixed(1)} MB) melebihi batas maksimal ${maxMb} MB.`,
                    confirmButtonColor: '#15803D'
                });
                input.value = '';
                return;
            }

            const objectUrl = URL.createObjectURL(file);
            if (preview) {
                preview.src = objectUrl;
                preview.style.display = 'block';
            }
            if (placeholder) {
                placeholder.style.display = 'none';
            }
            if (info) {
                const sizeKb = (file.size / 1024).toFixed(0);
                info.innerHTML = `<i class="mdi mdi-check-circle"></i> <span>${file.name} (${sizeKb} KB)</span>`;
                info.style.display = 'flex';
            }
            if (clearBtn) {
                clearBtn.style.display = 'inline-flex';
            }
        };

        window.clearSingleImage = function(inputId, previewId, placeholderId, infoId, clearBtnId, originalSrc) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const info = document.getElementById(infoId);
            const clearBtn = document.getElementById(clearBtnId);

            if (input) input.value = '';
            if (info) {
                info.innerHTML = '';
                info.style.display = 'none';
            }
            if (clearBtn) {
                clearBtn.style.display = 'none';
            }

            if (originalSrc && originalSrc !== '') {
                if (preview) {
                    preview.src = originalSrc;
                    preview.style.display = 'block';
                }
                if (placeholder) placeholder.style.display = 'none';
            } else {
                if (preview) preview.style.display = 'none';
                if (placeholder) placeholder.style.display = 'flex';
            }
        };

        // Live Preview for Multiple Images (Dokumentasi)
        window.previewMultipleImages = function(input, gridId, infoId, clearBtnId) {
            const grid = document.getElementById(gridId);
            const info = document.getElementById(infoId);
            const clearBtn = document.getElementById(clearBtnId);
            if (!grid) return;

            grid.innerHTML = '';

            const files = Array.from(input.files || []);
            if (files.length === 0) {
                if (info) info.style.display = 'none';
                if (clearBtn) clearBtn.style.display = 'none';
                return;
            }

            if (files.length > 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maksimal 10 Foto',
                    text: 'Anda hanya dapat mengunggah maksimal 10 foto sekaligus.',
                    confirmButtonColor: '#15803D'
                });
                input.value = '';
                if (info) info.style.display = 'none';
                if (clearBtn) clearBtn.style.display = 'none';
                return;
            }

            let totalSize = 0;
            files.forEach(file => {
                totalSize += file.size;
                const col = document.createElement('div');
                col.className = 'admin-multi-preview-item';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;

                const badge = document.createElement('span');
                badge.className = 'preview-badge';
                badge.textContent = file.name;

                col.appendChild(img);
                col.appendChild(badge);
                grid.appendChild(col);
            });

            if (info) {
                const totalMb = (totalSize / (1024 * 1024)).toFixed(1);
                info.innerHTML = `<i class="mdi mdi-check-circle"></i> <span>${files.length} foto dipilih (Total: ${totalMb} MB)</span>`;
                info.style.display = 'flex';
            }
            if (clearBtn) {
                clearBtn.style.display = 'inline-flex';
            }
        };

        window.clearMultipleImages = function(inputId, gridId, infoId, clearBtnId) {
            const input = document.getElementById(inputId);
            const grid = document.getElementById(gridId);
            const info = document.getElementById(infoId);
            const clearBtn = document.getElementById(clearBtnId);

            if (input) input.value = '';
            if (grid) grid.innerHTML = '';
            if (info) {
                info.innerHTML = '';
                info.style.display = 'none';
            }
            if (clearBtn) clearBtn.style.display = 'none';
        };

        // DOM Ready: Sidebar toggle, Form Validation & Delete Confirmation via SweetAlert2
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar collapse toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const adminShell = document.getElementById('adminShell');
            if (sidebarToggle && adminShell) {
                sidebarToggle.addEventListener('click', function() {
                    adminShell.classList.toggle('sidebar-collapsed');
                });
            }

            // Global SweetAlert Form Validation & Delete Confirmation
            document.querySelectorAll('form').forEach(form => {
                if (form.method.toUpperCase() === 'GET') return;

                // Handle Delete confirmation
                const isDelete = form.querySelector('input[name="_method"][value="DELETE"]');
                if (isDelete) {
                    form.onsubmit = null;
                    form.addEventListener('submit', function(e) {
                        if (form.dataset.confirmed === 'true') return;
                        e.preventDefault();

                        Swal.fire({
                            title: 'Konfirmasi Penghapusan',
                            text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#DC2626',
                            cancelButtonColor: '#64748B',
                            confirmButtonText: '<i class="mdi mdi-delete-outline"></i> Ya, Hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            focusCancel: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.dataset.confirmed = 'true';
                                form.submit();
                            }
                        });
                    });
                    return;
                }

                // Handle Required Form Validation before Submit
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();

                        const invalidInput = form.querySelector(':invalid');
                        let fieldLabel = 'yang bertanda wajib';
                        if (invalidInput) {
                            const labelElem = form.querySelector(`label[for="${invalidInput.id}"]`);
                            if (labelElem) {
                                fieldLabel = `"${labelElem.textContent.trim().replace(/\*$/, '')}"`;
                            } else if (invalidInput.placeholder) {
                                fieldLabel = `"${invalidInput.placeholder}"`;
                            } else if (invalidInput.name) {
                                fieldLabel = `"${invalidInput.name}"`;
                            }
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: 'Kolom Wajib Belum Diisi',
                            html: `Harap periksa dan lengkapi kolom <b>${fieldLabel}</b> sebelum menyimpan formulir.`,
                            confirmButtonColor: '#15803D',
                            confirmButtonText: 'Lengkapi Data'
                        }).then(() => {
                            if (invalidInput) {
                                invalidInput.focus();
                                invalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    }
                });
            });

            @if (session('status') || session('success'))
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: @json(session('status') ?? session('success')),
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Perhatian',
                    text: @json(session('error')),
                    confirmButtonColor: '#15803D'
                });
            @endif
        });
    </script>
</body>
</html>
