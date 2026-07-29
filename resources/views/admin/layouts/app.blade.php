@php
$setting = \App\Models\Setting::first();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin Dashboard')</title>
    <link rel="icon" href="{{ Storage::url($setting->favicon) }}" type="image/x-icon">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <style>
        body {
            background-color: #f5f5f5;
        }

        /* Sidebar */
        /* #sidebar { width: 250px; min-height: 100vh; background-color: #212529; position: fixed; left: 0; top: 0; transition: all 0.3s; z-index:1040; color:#fff; } */
        #sidebar {
            width: 250px;
            height: 100vh;
            background-color: #212529;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1040;
            color: #fff;
            overflow-y: auto;
            overflow-x: hidden;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        #sidebar::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        #sidebar.collapsed {
            left: -250px;
        }

        #mainContent {
            margin-left: 250px;
            transition: all 0.3s;
        }

        #mainContent.expanded {
            margin-left: 0;
        }

        .nav-link {
            color: #adb5bd;
            transition: 0.2s;
        }

        .nav-link:hover {
            color: #fff;
            background-color: #343a40;
        }

        .nav-link.active {
            color: #fff;
            background-color: #495057;
        }

        .collapse .nav-link {
            padding-left: 1.5rem;
            font-size: 0.9rem;
        }

        #mobileOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1035;
            display: none;
        }

        @media(max-width:768px) {
            #sidebar {
                left: -250px;
            }

            #sidebar.show {
                left: 0;
            }

            #mainContent {
                margin-left: 0;
            }
        }

        /* Rotate collapse arrow */
        .rotate {
            transition: transform 0.3s;
        }

        .rotate.show {
            transform: rotate(90deg);
        }

        .bg-purple {
            background: linear-gradient(to right, #6f42c1, #5a33a5);
        }

        .bg-indigo {
            background: linear-gradient(to right, #6610f2, #5b0fd1);
        }

        .bg-pink {
            background: linear-gradient(to right, #d63384, #c2185b);
        }

        .bg-teal {
            background: linear-gradient(to right, #20c997, #198754);
        }

        .bg-orange {
            background: linear-gradient(to right, #fd7e14, #f76700);
        }

        .bg-gradient-purple {
            background: linear-gradient(to right, #6f42c1, #5a33a5);
        }
    </style>
    @yield('style')
</head>

<body>

    <!-- Sidebar -->
    @include('admin.layouts.sidebar')

    <!-- Mobile Overlay -->
    <div id="mobileOverlay"></div>

    <!-- Main Content -->
    <div id="mainContent" class="flex-grow-1 d-flex flex-column">

        <!-- Topbar -->
       <!-- Topbar -->
        <header style="
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
            padding: 0 20px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        ">
            {{-- Left: Toggle + Breadcrumb --}}
            <div class="d-flex align-items-center gap-3">
                <button id="sidebarToggle" style="
                    width: 34px;
                    height: 34px;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    background: transparent;
                    color: #6b7280;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    cursor: pointer;
                    transition: all 0.15s;
                " onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db';"
                   onmouseout="this.style.background='transparent'; this.style.borderColor='#e5e7eb';">
                    <i class="fas fa-bars" style="font-size: 13px;"></i>
                </button>

                {{-- Current page label --}}
                <div class="d-none d-md-flex align-items-center gap-2">
                    <span style="font-size: 12px; color: #9ca3af;">Admin</span>
                    <i class="fas fa-chevron-right" style="font-size: 9px; color: #d1d5db;"></i>
                    <span style="font-size: 13px; font-weight: 600; color: #111827;">
                        @yield('title', 'Dashboard')
                    </span>
                </div>
            </div>

            {{-- Right: Actions --}}
            <div class="d-flex align-items-center gap-2">

                {{-- Visit Site --}}
                <a href="/" target="_blank" style="
                    width: 34px;
                    height: 34px;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #6b7280;
                    text-decoration: none;
                    transition: all 0.15s;
                " onmouseover="this.style.background='#f9fafb'; this.style.color='#111827';"
                   onmouseout="this.style.background='transparent'; this.style.color='#6b7280';"
                   title="Visit Site">
                    <i class="fas fa-external-link-alt" style="font-size: 12px;"></i>
                </a>

                {{-- Currency Switcher --}}
                {{--<form method="POST" action="{{ route('admin.currency.update') }}" style="margin: 0;">
                    @csrf
                    <select name="currency" onchange="this.form.submit()" style="
                        height: 34px;
                        border: 1px solid #e5e7eb;
                        border-radius: 8px;
                        background: transparent;
                        font-size: 12px;
                        font-weight: 600;
                        color: #374151;
                        padding: 0 10px;
                        cursor: pointer;
                        outline: none;
                        transition: border-color 0.15s;
                    ">
                        <option value="৳" {{ $setting->currency == '৳' ? 'selected' : '' }}>৳ BDT</option>
                        <option value="$" {{ $setting->currency == '$' ? 'selected' : '' }}>$ USD</option>
                    </select>
                </form>--}}

                {{-- Divider --}}
                <div style="width: 1px; height: 24px; background: #e5e7eb;"></div>

                {{-- Profile Dropdown --}}
                <div class="dropdown">
                    <button class="d-flex align-items-center gap-2" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false"
                        style="
                            border: 1px solid #e5e7eb;
                            border-radius: 10px;
                            background: transparent;
                            padding: 4px 10px 4px 5px;
                            cursor: pointer;
                            transition: all 0.15s;
                            height: 38px;
                        "
                        onmouseover="this.style.background='#f9fafb';"
                        onmouseout="this.style.background='transparent';">

                        {{-- Avatar --}}
                        <div style="
                            width: 26px;
                            height: 26px;
                            border-radius: 7px;
                            overflow: hidden;
                            flex-shrink: 0;
                            background: linear-gradient(135deg, #ea4f0c, #f68e12);
                            display: flex;
                            align-items: center;
                            justify-content: center;
                        ">
                            @if(Auth::guard('admin')->user()->image)
                                <img src="{{ Storage::url(Auth::guard('admin')->user()->image) }}"
                                    style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <span style="font-size: 11px; font-weight: 700; color: #fff;">
                                    {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                                </span>
                            @endif
                        </div>

                        <span class="d-none d-md-inline" style="font-size: 13px; font-weight: 600; color: #111827;">
                            {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                        </span>
                        <i class="fas fa-chevron-down" style="font-size: 9px; color: #9ca3af;"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end" style="
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
                        padding: 6px;
                        min-width: 180px;
                        margin-top: 6px;
                    ">
                        {{-- User Info --}}
                        <li>
                            <div style="padding: 8px 10px 10px; border-bottom: 1px solid #f1f5f9; margin-bottom: 4px;">
                                <div style="font-size: 13px; font-weight: 600; color: #111827;">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</div>
                                <div style="font-size: 11px; color: #9ca3af;">Administrator</div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.settings') }}" style="
                                border-radius: 8px;
                                font-size: 13px;
                                padding: 8px 10px;
                                color: #374151;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                                <i class="fas fa-user" style="font-size: 12px; color: #9ca3af; width: 16px;"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.change.password') }}" style="
                                border-radius: 8px;
                                font-size: 13px;
                                padding: 8px 10px;
                                color: #374151;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                            ">
                                <i class="fas fa-key" style="font-size: 12px; color: #9ca3af; width: 16px;"></i>
                                Change Password
                            </a>
                        </li>
                        <li><hr style="margin: 4px 0; border-color: #f1f5f9;"></li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="
                                    border-radius: 8px;
                                    font-size: 13px;
                                    padding: 8px 10px;
                                    color: #ef4444;
                                    display: flex;
                                    align-items: center;
                                    gap: 8px;
                                    width: 100%;
                                ">
                                    <i class="fas fa-sign-out-alt" style="font-size: 12px; width: 16px;"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow-1 p-3">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle -->
   

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif


    <script>
        $(document).ready(function() {
            const sidebar = $('#sidebar'),
                overlay = $('#mobileOverlay'),
                main = $('#mainContent');

            $('#sidebarToggle').click(function() {
                if ($(window).width() < 768) {
                    sidebar.toggleClass('show');
                    overlay.toggle();
                } else {
                    sidebar.toggleClass('collapsed');
                    main.toggleClass('expanded');
                }
            });

            overlay.click(function() {
                sidebar.removeClass('show');
                overlay.hide();
            });

            // Rotate arrow for collapse
            document.querySelectorAll('.collapse').forEach(function(collapseEl) {
                collapseEl.addEventListener('show.bs.collapse', function() {
                    this.previousElementSibling.querySelector('.rotate').classList.add('show');
                });
                collapseEl.addEventListener('hide.bs.collapse', function() {
                    this.previousElementSibling.querySelector('.rotate').classList.remove('show');
                });
            });
        });
    </script>
    

    <script>
        $(document).ready(function() {
            
            $('.summernote').summernote({
                height: 300, 
                placeholder: 'Write something here...', 
                tabsize: 2,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ] 
            });
        });

    </script>
    @yield('script')
</body>

</html>