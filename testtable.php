<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<style>
/* Tambahkan border di sisi kiri kolom pertama grup */
/* Berikan border kanan untuk memisahkan kolom */
.border-right {
  border-right: 2px solid #000;
}

/* Berikan border pada grup header untuk efek kotak */
.group-border {
  border: 2px solid #000;
}

</style>
</head>
<body>
<table id="example" class="display" style="width:100%">
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


<script>
        $(document).ready(function() {
            $('#example').DataTable({
                "scrollX": true,
                "columnDefs": [
                    { "className": "border-left", "targets": [5] }, // Indeks untuk kolom awal grup 'NAMA STASIUN RADIO SIARAN'
                    { "className": "border-right", "targets": [9] }, // Indeks untuk kolom akhir grup 'NAMA STASIUN RADIO SIARAN'
                    { "className": "border-left", "targets": [10] }, // Indeks untuk kolom awal grup 'LOKASI PEMANCAR'
                    { "className": "border-right", "targets": [16] } // Indeks untuk kolom akhir grup 'LOKASI PEMANCAR'
                ],
                "ajax": {
                    "url": "read_data.php?tabel=pengukuran_radio_fm",
                    "type": "GET",
                    "dataSrc": function(json) {
                    console.log(json); // Log the received data to the console
                    return json.data; // Make sure that this matches your server response
    }
                },
                "columns": [
                    { "data": "ID" },
                    { "data": "NO_SPT" },
                    { "data": "TGL_SPT" },
                    { "data": "TANGGAL_PENGUKURAN" },
                    { "data": "NO_ISR" },
                    { "data": "NSR_PENYELENGGARA" },
                    { "data": "NSR_ALAMAT" },
                    { "data": "NSR_KAB_KOTA" },
                    { "data": "NSR_TELP_FAX" },
                    { "data": "NSR_EMAIL" },
                    { "data": "LP_LATITUDE" },
                    { "data": "LP_LONGITUDE" },
                    { "data": "LP_ALAMAT" },
                    { "data": "LP_KAB_KOTA" },
                    { "data": "LP_TINGGI_LOKASI" },
                    { "data": "LP_TINGGI_GEDUNG" },
                    { "data": "LP_TINGGI_MENARA" },
                    { "data": "SP_P_MERK" },
                    { "data": "SP_P_JENIS_TYPE" },
                    { "data": "SP_P_FREKUENSI" },
                    { "data": "SP_P_KELAS_EMISI" },
                    { "data": "SP_P_BANDWIDTH" },
                    { "data": "SP_P_MODULASI" },
                    { "data": "SP_P_MAX_POWER" },
                    { "data": "SP_A_JENIS_ANTENA" },
                    { "data": "SP_A_POLARISASI" },
                    { "data": "SP_A_JUMLAH_ELEMEN" },
                    { "data": "SP_A_GAIN" },
                    { "data": "SP_A_BEAM_ANTENA_ARAH" },
                    { "data": "SP_A_JENIS_KABEL_FEEDER" },
                    { "data": "SP_A_PANJANG_KABEL_FEEDER" },
                    { "data": "HU_KANAL" },
                    { "data": "HU_FREKUENSI_TERUKUR" },
                    { "data": "HU_LEVEL" },
                    { "data": "HU_BANDWIDTH" },
                    { "data": "HU_FIELD_STRENGTH" },
                    { "data": "HU_DAYA" },
                    { "data": "HU_MODULASI" },
                    { "data": "HU_DEVIASI" },
                    { "data": "HU_OUTPUT_MAX" },
                    { "data": "HU_H_H1" },
                    { "data": "HU_H_H2" },
                    { "data": "HU_H_H3" },
                    { "data": "STL" },
                    { "data": "KETERANGAN" }
                ]
            });
        });
    </script>

</body>


</html>
