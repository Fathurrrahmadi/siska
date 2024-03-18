
fetch('connection/read_data.php?tabel=penertiban_sfr')
.then(response => response.json())
.then(data => {
    const jenisPelanggaranCounts = data.data.reduce((acc, item) => {
        acc[item['JENIS PELANGGARAN']] = (acc[item['JENIS PELANGGARAN']] || 0) + 1;
        return acc;
    }, {});

    const ctx = document.getElementById('myChartpie').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'pie',// Jenis chart: bar, line, pie, dll.
        data: {
            labels: Object.keys(jenisPelanggaranCounts),
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: Object.values(jenisPelanggaranCounts),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    // Tambahkan warna lain sesuai kebutuhan
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    // Tambahkan border warna lain sesuai kebutuhan
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: 'Jumlah Pelanggaran per Jenis'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});

let myBarChart = null; // Inisialisasi variabel chart di luar agar bisa diakses oleh berbagai fungsi

function fetchDataAndCreateChart() {
  fetch('connection/read_data.php?tabel=penertiban_sfr')
  .then(response => response.json())
  .then(data => {
      const countsPerMonth = Array(12).fill(0); // Inisialisasi array dengan 12 elemen untuk setiap bulan

      data.data.forEach(item => {
          if (item['TANGGAL TINDAKAN']) {
              const month = new Date(item['TANGGAL TINDAKAN']).getMonth(); // Mengambil bulan dari tanggal (0-11)
              countsPerMonth[month]++; // Menambahkan jumlah kegiatan per bulan
          }
      });

      const ctx = document.getElementById('myChartbar').getContext('2d');
      
      // Jika chart sudah ada, hancurkan
      if (myBarChart) {
        myBarChart.destroy();
      }

      myBarChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'], // Label bulan
              datasets: [{
                  label: 'Jumlah Tindakan per Bulan',
                  data: countsPerMonth, // Data yang telah dihitung per bulan
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              },
              responsive: true,
              title: {
                  display: true,
                  text: 'Jumlah Tindakan per Bulan'
              },
          }
      });
  });
}

// Panggil fungsi untuk membuat chart
fetchDataAndCreateChart();
