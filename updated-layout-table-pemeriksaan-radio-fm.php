<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table SFR</title>




    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <!-- FixedColumns CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.1.0/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css"> -->

    <!-- <link rel="stylesheet" href="./assets/compiled/css/table-edit.css"> -->
  <link rel="stylesheet" href="./assets/compiled/css/app.css">
  <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">

</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo">
                <a href="index.html"><img src="" alt="" srcset="">SISKA</a>
            </div>
            <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--system-uicons" width="20" height="20"
                    preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                            opacity=".3"></path>
                        <g transform="translate(-210 -1)">
                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                            <circle cx="220.5" cy="11.5" r="4"></circle>
                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                        </g>
                    </g>
                </svg>
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                    <label class="form-check-label"></label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                    role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 24 24">
                    <path fill="currentColor"
                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                    </path>
                </svg>
            </div>
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li
                class="sidebar-item  ">
                <a href="index.html" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>


            </li>

            <li
                class="sidebar-item  has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-stack"></i>
                    <span>Monitoring</span>
                </a>

                <ul class="submenu ">

                    <li class="submenu-item  ">
                        <a href="layout-monitor-kabkot.html" class="submenu-link">Pita Frequensi Radio Kab/Kota</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="layout-monitor-marabahaya.html" class="submenu-link">Pita Frequensi Marabahaya</a>

                    </li>

                </ul>

            </li>

            <li
                class="sidebar-item ">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-collection-fill"></i>
                    <span>Pemanfaatan perangkat SMFR</span>
                </a>

            </li>

            <li
                class="sidebar-item  active has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Pemeriksaan Stasiun Radio</span>
                </a>

                <ul class="submenu active ">

                    <li class="submenu-item  ">
                        <a href="layout-default.html" class="submenu-link">Microwave Link</a>

                    </li>

                    <li class="submenu-item active ">
                        <a href="layout-vertical-1-column.html" class="submenu-link">Pengukuran Stasiun Siaran Radio FM</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="layout-vertical-navbar.html" class="submenu-link">Pengukuran Stasiun Radio TV Digital</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="layout-rtl.html" class="submenu-link">Monitoring APT</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="layout-penanganan-table.html" class="submenu-link">Prima Aksi</a>

                    </li>


                </ul>


            </li>



            <li
            class="sidebar-item  ">
            <a href="layout-penanganan-gangguan.php" class='sidebar-link'>
                <i class="bi bi-file-earmark-medical-fill"></i>
                <span>Penanganan Ganguan</span>
            </a>
            </li>


            <li
            class="sidebar-item has-sub ">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-pen-fill"></i>
                <span>Penertiban</span>
            </a>

                <ul class="submenu  ">

                    <li class="submenu-item  ">
                        <a href="layout-table-SFR-modified.php" class="submenu-link">SFR spektur frekuensi radio</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="form-editor-ckeditor.html" class="submenu-link">APT</a>

                    </li>

                    <li class="submenu-item  ">
                        <a href="form-editor-summernote.html" class="submenu-link">denda</a>

                    </li>


                </ul>
            </li>

            <li
                class="sidebar-item  ">
                <a href="layout-form-input.html" class='sidebar-link'>
                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                    <span>Input Data</span>
                </a>
            </li>


        </ul>
    </div>
</div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pemeriksaan Radio FM</h3>
                <p class="text-subtitle text-muted">List Pemeriksaan Radio FM</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pemeriksaan Radio FM </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Basic Tables start -->
    <section class="section">
        <div class="card">
            <div class="card-header">
            <a href="testinput2.html" class="btn btn-primary">Tambah Data Baru</a>


            </div>
            <div class="card-body">


                <div class="datatable_wrapper">

                <table id="table_rfm" class="display" style="width:100%">
                    <thead>
                        <tr>
                        <th rowspan="3" class="group-border">ID</th>
                        <th rowspan="3" class="group-border">NO SPT</th>
                        <th rowspan="3" class="group-border">TGL SPT</th>
                        <th rowspan="3" class="group-border">TANGGAL Pengukuran</th>
                        <th rowspan="3" class="group-border">NO ISR</th>
                        
                        <th colspan="5" class="group-border">NAMA STASIUN RADIO SIARAN</th> 

                        <th colspan="7" class="group-border">LOKASI PEMANCAR</th>

                        <th colspan="14" class="group-border">SPESIFIKASI PERANGKAT</th>

                        <th colspan="11" class="group-border">HASIL UKUR</th> 
                        <th rowspan="3" class="border-right">STL</th>
                        <th rowspan="3" class="border-right">Keterangan</th>
                        </tr>
                        <tr>
                        <!-- Isi untuk 'NAMA STASIUN RADIO SIARAN' -->
                        <th rowspan="2" class="border-right">PENYELENGGARA</th>
                        <th rowspan="2" class="border-right">ALAMAT</th>
                        <th rowspan="2" class="border-right">kab/kota</th>
                        <th rowspan="2" class="border-right">TELP/FAX</th>
                        <th rowspan="2">E-MAIL</th>

                        <!-- Isi untuk 'LOKASI PEMANCAR' -->
                        <th rowspan="2">LATITUDE</th>
                        <th rowspan="2" class="border-right">LONGITUDE</th>
                        <th rowspan="2" class="border-right">ALAMAT</th>
                        <th rowspan="2" class="border-right">kab/kota</th>
                        <th rowspan="2" class="border-right">TINGGI LOKASI (mdpl)</th>
                        <th rowspan="2" class="border-right">TINGGI GEDUNG (m)</th>
                        <th rowspan="2">TINGGI MENARA (m)</th>

                        <!-- Sub-grup header 'PEMANCAR' -->
                        <th colspan="7" class="group-border">PEMANCAR</th>
                        <!-- Sub-grup header 'ANTENA' -->
                        <th colspan="7" class="group-border">ANTENA</th>
                        
                        <!-- Kolom untuk 'HASIL UKUR' -->
                        <th rowspan="2" class="group-border">FREKUENSI TERUKUR</th>
                        <th rowspan="2" class="group-border">LEVEL</th>
                        <th rowspan="2" class="group-border">BANDWIDTH</th>
                        <th rowspan="2" class="group-border">FIELD STRENGTH</th>
                        <th rowspan="2" class="group-border">DAYA</th>
                        <th rowspan="2" class="group-border">MODULASI</th>
                        <th rowspan="2" class="group-border">DEVIASI</th>
                        <th rowspan="2" class="group-border">OUTPUT MAX</th>
                        <!-- Kolom untuk 'HARMONISA' -->
                        <th colspan="3" class="group-border">HARMONISA</th>
                        </tr>
                        
                        <tr>
                        <!-- Anak kolom untuk 'PEMANCAR' -->
                        <th class="border-right">MERK</th>
                        <th class="border-right">JENIS/TYPE</th>
                        <th class="border-right">FREKUENSI</th>
                        <th class="border-right">KELAS EMISI</th>
                        <th class='border-right'>BANDWIDTH</th>
                        <th class="border-right">Modulasi</th>
                        <th class="border-right">MAX POWER</th>

                        <!-- Anak kolom untuk 'ANTENA' -->
                        <th class="border-right">JENIS ANTENA</th>
                        <th class="border-right">POLARISASI</th>
                        <th class="border-right">JUMLAH ELEMEN</th>
                        <th class="border-right">GAIN</th>
                        <th class="border-right">BEAM/ANTTENA</th>
                        <th class="border-right">JENIS KABEL/FEEDER</th>
                        <th class="border-right">PANJANG KABEL/FEEDER</th>
                        
                    

                        <!-- Kolom untuk 'HARMONISA' -->
                        <th class="border-right">H1</th>
                        <th class="border-right">H2</th>
                        <th class="border-right">H3</th>
                        </tr>
                    
                    </thead>
                    <tbody>
                        <!-- Isi data untuk setiap baris di sini -->
                    </tbody>
              </table>

                    
                </div>
              
            </div>
        </div>


    </section>


</div>


  

<!-- <script src="assets/static/js/pages/datatables.js"></script>  -->
    
<script src="assets/compiled/js/app.js"></script>
    
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<!-- jQuery -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- <script src="assets/extensions/jquery/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- FixedColumns JS -->
<script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> -->


<script>
        $(document).ready(function() {
        
$('#table_rfm').DataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
        "url": "connection/read_data.php?tabel=pengukuran_radio_fm",
        "type": "POST"
    },
    "pageLength": 5,
    "columns": [
        {"data": "ID"},
        {"data": "NO_SPT"},
        {"data": "TGL_SPT"},
        {"data": "TANGGAL_PENGUKURAN"},
        {"data": "NO_ISR"},
        {"data": "NSR_PENYELENGGARA"},
        {"data": "NSR_ALAMAT"},
        {"data": "NSR_KAB_KOTA"},
        {"data": "NSR_TELP_FAX"},
        {"data": "NSR_EMAIL"},
        {"data": "LP_LATITUDE"},
        {"data": "LP_LONGITUDE"},
        {"data": "LP_ALAMAT"},
        {"data": "LP_KAB_KOTA"},
        {"data": "LP_TINGGI_LOKASI"},
        {"data": "LP_TINGGI_GEDUNG"},
        {"data": "LP_TINGGI_MENARA"},
        {"data": "SP_P_MERK"},
        {"data": "SP_P_JENIS_TYPE"},
        {"data": "SP_P_FREKUENSI"},
        {"data": "SP_P_KELAS_EMISI"},
        {"data": "SP_P_BANDWIDTH"},
        {"data": "SP_P_MODULASI"},
        {"data": "SP_P_MAX_POWER"},
        {"data": "SP_A_JENIS_ANTENA"},
        {"data": "SP_A_POLARISASI"},
        {"data": "SP_A_JUMLAH_ELEMEN"},
        {"data": "SP_A_GAIN"},
        {"data": "SP_A_BEAM_ANTENA_ARAH"},
        {"data": "SP_A_JENIS_KABEL_FEEDER"},
        {"data": "SP_A_PANJANG_KABEL_FEEDER"},
        {"data": "HU_KANAL"},
        {"data": "HU_FREKUENSI_TERUKUR"},
        {"data": "HU_LEVEL"},
        {"data": "HU_BANDWIDTH"},
        {"data": "HU_FIELD_STRENGTH"},
        {"data": "HU_DAYA"},
        {"data": "HU_MODULASI"},
        {"data": "HU_DEVIASI"},
        {"data": "HU_OUTPUT_MAX"},
        {"data": "HU_H_H1"},
        {"data": "HU_H_H2"},
        {"data": "HU_H_H3"},
        {"data": "STL"},
        {"data": "KETERANGAN"}
    ],
    "scrollX": true
});

    });
   

    

  
</script>
<footer>

    <div class="footer clearfix mb-0 text-muted">
        <div class="float-start">
            <p>2023 &copy; Mazer</p>
        </div>
        
    </div>
</footer>
</body>


</html>



