<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeBase;
use App\Models\User;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari admin untuk audit trail
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : null;

        $now = now();

        $data = [
            // ==========================================
            // KATEGORI 1: Informasi WiFi dan Jaringan (8 entri)
            // ==========================================
            [
                'category' => 'wifi',
                'title' => 'WiFi Kantin Putri',
                'keywords' => 'wifi, kantin putri, password, ssid, internet, putri, kantin',
                'content' => "SSID: Kantin-Putri-WiFi\nPassword: KantinPutri123\nGateway: 192.168.12.1\nPenanggung Jawab: Ahmad (Tim IT)\nLokasi Access Point: Pojok timur Kantin Putri (dekat etalase utama).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi Kantin Putra',
                'keywords' => 'wifi, kantin putra, password, ssid, internet, putra, kantin',
                'content' => "SSID: Kantin-Putra-WiFi\nPassword: KantinPutra456\nGateway: 192.168.13.1\nPenanggung Jawab: Ahmad (Tim IT)\nLokasi Access Point: Dinding tengah Kantin Putra (dekat kasir).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi Toko Putra 1',
                'keywords' => 'wifi, toko putra 1, password, ssid, internet, toko, putra, kasir',
                'content' => "SSID: Toko-Putra1-WiFi\nPassword: TokoPutra1Aman\nGateway: 192.168.14.1\nPenanggung Jawab: Fajar (Tim IT)\nLokasi Access Point: Plafon area kasir Toko Putra 1.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi Toko Putra 2',
                'keywords' => 'wifi, toko putra 2, password, ssid, internet, toko, putra, kasir 2',
                'content' => "SSID: Toko-Putra2-WiFi\nPassword: TokoPutra2Jaya\nGateway: 192.168.15.1\nPenanggung Jawab: Fajar (Tim IT)\nLokasi Access Point: Belakang meja utama Toko Putra 2.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi Toko Putri 1',
                'keywords' => 'wifi, toko putri 1, password, ssid, internet, toko, putri, kasir 1',
                'content' => "SSID: Toko-Putri1-WiFi\nPassword: TokoPutri1Berkah\nGateway: 192.168.16.1\nPenanggung Jawab: Rizki (Tim IT)\nLokasi Access Point: Area pintu masuk utama Toko Putri 1.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi Toko Putri 2',
                'keywords' => 'wifi, toko putri 2, password, ssid, internet, toko, putri, kasir 2',
                'content' => "SSID: Toko-Putri2-WiFi\nPassword: TokoPutri2Rapi\nGateway: 192.168.17.1\nPenanggung Jawab: Rizki (Tim IT)\nLokasi Access Point: Sudut ruang tengah Toko Putri 2.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi UNSUDA',
                'keywords' => 'wifi, unsuda, universitas, password, ssid, internet, kampus, dosen, mahasiswa',
                'content' => "SSID: UNSUDA-Campus-Net\nPassword: KampusUnsuda2026\nGateway: 10.10.20.1\nPenanggung Jawab: Tsalis (Kordinator Jaringan UNSUDA)\nLokasi Access Point: Tersebar di gedung rektorat, lobi utama, dan ruang dosen.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'wifi',
                'title' => 'WiFi SMK Sunan Drajat',
                'keywords' => 'wifi, smk sunan drajat, password, ssid, internet, smk, sekolah, lab, penanggung jawab',
                'content' => "SSID: SMK-SD-SmartWiFi\nPassword: SMKSunanDrajatHebat\nGateway: 10.10.30.1\nPenanggung Jawab: Ahmad (Staf IT SMK Sunan Drajat)\nLokasi Access Point: Lab Komputer 1 & 2, Ruang Guru, dan Lobi SMK.",
                'access_level' => 'teknisi',
            ],

            // ==========================================
            // KATEGORI 2: Informasi Perangkat IT (8 entri)
            // ==========================================
            [
                'category' => 'perangkat',
                'title' => 'Printer Thermal Toko',
                'keywords' => 'printer thermal, kasir, toko, cetak struk, pos, printer, bluetooth, usb',
                'content' => "Nama Perangkat: Epson TM-T82X (Thermal Printer)\nLokasi: Kasir Toko Putra 1, Toko Putra 2, Toko Putri 1, Toko Putri 2.\nDeskripsi: Printer cetak struk POS berkecepatan tinggi menggunakan kertas thermal 80mm. Terkoneksi via USB ke komputer kasir.\nPenanggung Jawab: Fajar (Tim IT - 089688267122).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Barcode Scanner Kasir',
                'keywords' => 'barcode scanner, scanner, pembaca barcode, toko, kasir, ean, qr',
                'content' => "Nama Perangkat: Honeywell HH360 (Linear Imaging Scanner)\nLokasi: Semua kasir unit usaha perekonomian.\nDeskripsi: Barcode scanner genggam kabel USB untuk membaca kode barang belanjaan.\nPenanggung Jawab: Fajar (Tim IT).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'CCTV Area Putri',
                'keywords' => 'cctv, kamera pengawas, putri, asrama, keamanan',
                'content' => "Nama Perangkat: Hikvision IP Camera 4MP Dome\nLokasi: Lorong masuk asrama putri, gerbang putri, dan kantin putri.\nDeskripsi: Kamera pengawas IP yang terhubung ke NVR utama di ruang IT melalui switch PoE.\nPenanggung Jawab: Rizki (Tim IT Security).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Komputer Kasir POS',
                'keywords' => 'komputer kasir, pc pos, kasir pc, komputer, pos software',
                'content' => "Nama Perangkat: PC All-in-One Asus V222\nLokasi: Meja kasir Toko Putra & Putri.\nDeskripsi: Unit komputer kasir berspesifikasi Core i3, RAM 8GB, SSD 256GB running OS Windows 10 dan Aplikasi POS offline-online client.\nPenanggung Jawab: Fajar (Tim IT).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Router Utama Mikrotik',
                'keywords' => 'router, mikrotik, rb4011, core router, gateway, ip, mikrotik router',
                'content' => "Nama Perangkat: MikroTik RB4011iGS+5iQ-SG\nLokasi: Gedung Server Utama (Rak 1).\nDeskripsi: Router core utama yang membagi bandwidth internet, routing antar unit pendidikan, dan manajemen IP address internal.\nPenanggung Jawab: Tsalis (Network Engineer - 089688267122).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Switch Distribusi Ruang IT',
                'keywords' => 'switch, hub, switch hub, poe, sfp, lan, gigabit',
                'content' => "Nama Perangkat: Ruijie Reyee RG-ES224GC (24-Port Gigabit)\nLokasi: Ruang IT & Server Pendidikan.\nDeskripsi: Switch managed gigabit untuk distribusi kabel LAN ke komputer staf, access point, dan PC teknisi.\nPenanggung Jawab: Ahmad (Network Support).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Access Point Lobi UNSUDA',
                'keywords' => 'access point, ap, wifi sender, TP-Link, omada, eap225',
                'content' => "Nama Perangkat: TP-Link Omada EAP225 Ceiling Mount\nLokasi: Plafon tengah lobi Universitas Sunan Drajat (UNSUDA).\nDeskripsi: Access point dual-band yang melayani WiFi mahasiswa dan tamu dengan kontroler Omada cloud.\nPenanggung Jawab: Tsalis (Network Support).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'perangkat',
                'title' => 'Server POS Database',
                'keywords' => 'server, database server, server database, mysql, local server',
                'content' => "Nama Perangkat: Dell PowerEdge T150 Tower Server\nLokasi: Gedung Server Utama (Rak 2).\nDeskripsi: Server penyimpan database transaksi POS unit usaha Sunan Drajat dengan backup harian otomatis.\nPenanggung Jawab: Abid (System Administrator).",
                'access_level' => 'teknisi',
            ],

            // ==========================================
            // KATEGORI 3: Informasi Lokasi dan Unit Kerja (9 entri)
            // ==========================================
            [
                'category' => 'lokasi',
                'title' => 'Kantin Putra',
                'keywords' => 'kantin putra, lokasi kantin putra, tempat makan putra',
                'content' => "Lokasi: Area kompleks asrama putra, sebelah barat Masjid Sunan Drajat.\nDeskripsi: Pusat jajanan dan makanan santri putra yang menyediakan berbagai makanan berat dan minuman.\nJam Buka: 06:00 - 21:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Kantin Putri',
                'keywords' => 'kantin putri, lokasi kantin putri, tempat makan putri',
                'content' => "Lokasi: Kompleks asrama putri, dekat gerbang masuk asrama putri.\nDeskripsi: Unit kantin khusus santri putri yang dikelola oleh pengurus asrama putri.\nJam Buka: 06:30 - 21:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Toko Putra 1',
                'keywords' => 'toko putra 1, lokasi toko putra 1, minimarket putra 1',
                'content' => "Lokasi: Depan kantor administrasi pondok putra.\nDeskripsi: Toko kelontong/minimarket yang menyediakan kebutuhan harian santri putra, kitab, dan seragam pesantren.\nJam Buka: 07:00 - 22:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Toko Putra 2',
                'keywords' => 'toko putra 2, lokasi toko putra 2, minimarket putra 2',
                'content' => "Lokasi: Area parkir luar utara kompleks Pondok Pesantren Sunan Drajat.\nDeskripsi: Unit toko kedua yang melayani pembelian santri serta masyarakat umum sekitar pondok.\nJam Buka: 07:00 - 22:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Toko Putri 1',
                'keywords' => 'toko putri 1, lokasi toko putri 1, minimarket putri 1',
                'content' => "Lokasi: Di dalam kompleks asrama putri, dekat wisma tamu putri.\nDeskripsi: Toko penyedia barang harian, kosmetik, jajanan, dan atribut santri khusus putri.\nJam Buka: 07:30 - 21:30 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Toko Putri 2',
                'keywords' => 'toko putri 2, lokasi toko putri 2, minimarket putri 2',
                'content' => "Lokasi: Kompleks sekolah putri (dekat gedung MA Ma'arif 7 Putri).\nDeskripsi: Minimarket penunjang kebutuhan sekolah dan jajanan santri putri di jam istirahat sekolah.\nJam Buka: 07:00 - 16:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Perekonomian Sunan Drajat',
                'keywords' => 'perekonomian, kantor perekonomian, unit usaha, bisnis pondok',
                'content' => "Lokasi: Gedung Unit Usaha Lantai 1, sebelah timur Koperasi Syariah Sunan Drajat.\nDeskripsi: Kantor pusat administrasi dan keuangan seluruh unit bisnis, mini market, kantin, dan air minum pondok.\nKontak: 0322-xxx-xxx.",
                'access_level' => 'user',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Gedung Server Utama',
                'keywords' => 'gedung server, server room, ruang server utama, lokasi server',
                'content' => "Lokasi: Lantai 2 Gedung IT Center, bersebelahan dengan Kantor Pusat Administrasi Pesantren.\nDeskripsi: Ruang khusus dengan pendingin 24 jam dan access control ketat yang menyimpan server database, core switch, dan pusat backup data.\nPenanggung Jawab: Abid (Admin Server).",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'lokasi',
                'title' => 'Ruang IT Helpdesk',
                'keywords' => 'ruang it, helpdesk room, kantor it, teknisi ruangan',
                'content' => "Lokasi: Gedung IT Center Lantai 1, dekat area lobi utama.\nDeskripsi: Ruang kerja tim support IT helpdesk, tempat melakukan perbaikan perangkat keras, penerimaan konsultasi, dan koordinasi lapangan.\nHubungi: 089688267122.",
                'access_level' => 'user',
            ],

            // ==========================================
            // KATEGORI 4: Informasi Lembaga Pendidikan (8 entri)
            // ==========================================
            [
                'category' => 'pendidikan',
                'title' => 'MTs Sunan Drajat',
                'keywords' => 'mts sunan drajat, mts sd, madrasah tsanawiyah, sekolah mts',
                'content' => "Lokasi: Kompleks Pendidikan Utara Pesantren.\nDeskripsi: Madrasah Tsanawiyah terakreditasi A dengan program kelas tahfidz dan reguler.\nKontak: 0812-3456-7890\nInformasi Jaringan: Terhubung ke sub-LAN Gedung Pendidikan Utara, dilayani AP Ruijie di lobi MTs.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'MTs Muallimin Muallimat (MMA)',
                'keywords' => 'mts mma, muallimin muallimat, sekolah mma, pondok mma',
                'content' => "Lokasi: Kompleks Pesantren Tengah.\nDeskripsi: Pendidikan tingkat menengah pertama dengan fokus pengkajian kitab kuning secara intensif (kurikulum salafiyah).\nKontak: 0812-7777-6666\nInformasi Jaringan: Terkoneksi dengan kabel fiber optic langsung ke Gedung Server Utama.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'MA Muallimin Muallimat (MMA)',
                'keywords' => 'ma mma, madrasah aliyah mma, aliyah muallimin muallimat',
                'content' => "Lokasi: Kompleks Pesantren Tengah (sebelah gedung MTs MMA).\nDeskripsi: Kelanjutan jenjang pendidikan dari MTs MMA dengan penekanan pada pendalaman ilmu alat (Nahwu Sharaf) dan Fiqh lanjutan.\nKontak: 0812-7777-5555\nInformasi Jaringan: Menggunakan switch sub-distribusi MMA Lantai 2.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'MA Ma\'arif 7 Sunan Drajat',
                'keywords' => 'ma maarif 7, aliyah maarif, ma m7, sekolah aliyah',
                'content' => "Lokasi: Kompleks Pendidikan Selatan, dekat asrama Al-Ghazali.\nDeskripsi: Madrasah Aliyah umum di bawah naungan LP Ma'arif NU dengan jurusan IPA, IPS, dan Keagamaan.\nKontak: 0813-8888-9999\nInformasi Jaringan: Dilayani WiFi 'MA-MAARIF7-WIFI' dengan voucher login untuk siswa.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'SMPN 2 Paciran',
                'keywords' => 'smpn 2 paciran, smp negeri, smp 2, sekolah negeri',
                'content' => "Lokasi: Sebelah barat kompleks pesantren (akses jalan luar).\nDeskripsi: Sekolah menengah pertama negeri yang bekerja sama dengan pesantren Sunan Drajat untuk memfasilitasi santri yang ingin sekolah umum negeri.\nKontak: 0322-8610xx\nInformasi Jaringan: Memiliki jaringan internet mandiri (Telkom IndiHome) dengan koordinasi backup dari Tim IT Pondok.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'SMK Sunan Drajat',
                'keywords' => 'smk sunan drajat, smk sd, sekolah smk, kejuruan, penanggung jawab jaringan',
                'content' => "Lokasi: Kompleks Pendidikan Barat Pesantren.\nDeskripsi: SMK unggulan dengan jurusan TKJ, RPL, Multimedia, Tata Busana, Otomotif, dan Listrik.\nKontak: 0857-3333-2222\nPenanggung Jawab Jaringan: Ahmad (Staf IT SMK Sunan Drajat).\nInformasi Jaringan: Memiliki Lab Komputer dengan koneksi LAN terstruktur 60 PC, terhubung ke ISP utama pesantren via SFP Fiber Optic.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'Ma\'had Aly Sunan Drajat',
                'keywords' => 'mahad aly, perguruan tinggi salaf, mahad aly sd',
                'content' => "Lokasi: Lantai 3 Gedung Rektorat UNSUDA.\nDeskripsi: Pendidikan tinggi pesantren (takhassus) dengan konsentrasi kajian Fiqh dan Ushul Fiqh (Tafaqquh Fiddin) setara Strata 1.\nKontak: 0852-1111-2222\nInformasi Jaringan: Akses internet melalui LAN Rektorat dan AP Ruijie Mahad-Aly.",
                'access_level' => 'user',
            ],
            [
                'category' => 'pendidikan',
                'title' => 'Universitas Sunan Drajat (UNSUDA)',
                'keywords' => 'unsuda, universitas sunan drajat, kampus unsuda, perguruan tinggi',
                'content' => "Lokasi: Jl. Raya Paciran No.02, Kompleks Pesantren Sunan Drajat.\nDeskripsi: Universitas yang menyediakan program sarjana (S1) berbagai program studi seperti Ekonomi Syariah, Hukum, Teknik, dan Tarbiyah.\nKontak: 0322-861611\nInformasi Jaringan: Pusat data kampus di Gedung Rektorat. Menggunakan bandwidth terdedikasi 100 Mbps dari core IT pondok.",
                'access_level' => 'user',
            ],

            // ==========================================
            // KATEGORI 5: SOP Penanganan Masalah (6 entri)
            // ==========================================
            [
                'category' => 'sop',
                'title' => 'SOP Internet Mati',
                'keywords' => 'sop internet mati, internet down, koneksi mati, jaringan putus, tidak ada internet',
                'content' => "Langkah Penanganan Internet Mati:\n1. Periksa lampu indikator pada Router/Switch setempat. Jika merah/mati, periksa adaptor power.\n2. Coba ping ke gateway local (misal 192.168.1.1 atau gateway unit masing-masing).\n3. Lakukan ping ke DNS Google (8.8.8.8) untuk memastikan koneksi luar.\n4. Jika hanya 1 perangkat yang mati, cek kabel LAN atau modul WiFi perangkat tersebut.\n5. Jika mati satu area/gedung, laporkan segera ke Tim Network IT (089688267122 / Tsalis) untuk cek jalur fiber optic atau konfigurasi switch distribusi.",
                'access_level' => 'user',
            ],
            [
                'category' => 'sop',
                'title' => 'SOP Printer Thermal Tidak Mencetak',
                'keywords' => 'sop printer thermal tidak mencetak, printer rusak, printer tidak respon, printer kasir mati',
                'content' => "Langkah Penanganan Printer Thermal Mati/Tidak Respon:\n1. Pastikan kabel power printer terpasang dengan baik dan tombol power menyala (lampu biru/hijau).\n2. Cek lampu indikator 'Error' atau 'Paper Out'. Jika lampu merah berkedip, isi ulang kertas thermal baru secara presisi.\n3. Periksa koneksi kabel USB dari printer ke komputer kasir. Coba pindahkan ke port USB lain.\n4. Buka Control Panel -> Devices and Printers di Windows kasir, pastikan status printer EPSON TM-T82X adalah 'Ready' (bukan 'Offline').\n5. Jika status offline, klik kanan -> lihat antrean cetak -> klik 'Printer' -> hilangkan centang 'Use Printer Offline'.\n6. Jika masih gagal, lakukan restart komputer kasir dan printer.",
                'access_level' => 'user',
            ],
            [
                'category' => 'sop',
                'title' => 'SOP Barcode Scanner Tidak Terbaca',
                'keywords' => 'sop barcode scanner tidak terbaca, scanner tidak bunyi, barcode error, scanner kasir',
                'content' => "Langkah Penanganan Barcode Scanner Error:\n1. Pastikan lampu laser scanner menyala saat pelatuk ditekan.\n2. Jika laser tidak menyala, cek kabel USB scanner di komputer kasir, pastikan tidak longgar.\n3. Bersihkan lensa kaca scanner dari debu atau sidik jari menggunakan kain bersih.\n4. Coba scan kode barcode ke aplikasi Notepad untuk melihat apakah angka barcode muncul. Jika tidak muncul angka, berarti scanner tidak terdeteksi sebagai input keyboard (lakukan reset scanner dengan membaca barcode panduan bawaan).\n5. Hubungi Tim IT Support (Fajar) jika scanner masih tidak merespon sama sekali.",
                'access_level' => 'user',
            ],
            [
                'category' => 'sop',
                'title' => 'SOP CCTV Offline',
                'keywords' => 'sop cctv offline, cctv mati, dvr offline, nvr mati, kamera tidak tampil',
                'content' => "Langkah Penanganan CCTV Offline:\n1. Periksa apakah semua kamera atau hanya beberapa kamera yang offline di monitor NVR.\n2. Jika semua kamera offline, periksa NVR utama dan pastikan kabel network terhubung ke switch network dan status IP NVR aktif.\n3. Jika hanya 1-2 kamera offline, cek switch PoE terdekat yang menyuplai daya ke kamera tersebut. Coba restart switch PoE (cabut colokan listrik 10 detik lalu pasang kembali).\n4. Periksa konektor RJ45 di ujung kamera (apakah berkarat/kotor karena air hujan).\n5. Laporkan ke Support Security IT (Rizki) jika memerlukan perbaikan fisik di ketinggian AP/Kamera.",
                'access_level' => 'teknisi',
            ],
            [
                'category' => 'sop',
                'title' => 'SOP Software POS Error',
                'keywords' => 'sop software pos error, pos macet, aplikasi kasir error, transaksi gagal',
                'content' => "Langkah Penanganan Aplikasi POS Kasir Error:\n1. Jika aplikasi freeze/hang, buka Task Manager (Ctrl + Shift + Esc) lalu pilih aplikasi POS dan klik 'End Task'. Buka kembali aplikasi.\n2. Jika muncul error koneksi database, pastikan PC kasir terhubung ke LAN dan server database (ping server 192.168.10.10).\n3. Cek sisa memori/storage pada komputer kasir. Hapus file cache temporary jika storage penuh.\n4. Jika error terjadi saat sinkronisasi data barang, lakukan restart service database local di kasir.\n5. Jika masalah berlanjut, hubungi Tim Software IT untuk support remote login via AnyDesk.",
                'access_level' => 'user',
            ],
            [
                'category' => 'sop',
                'title' => 'SOP Server Tidak Dapat Diakses',
                'keywords' => 'sop server tidak dapat diakses, server down, database error, server mati',
                'content' => "Langkah Penanganan Server Down/Database Tidak Dapat Diakses:\n1. Lakukan ping ke IP Server (192.168.10.10) dari jaringan local.\n2. Jika ping RTO (Request Time Out), lakukan pengecekan fisik ke Gedung Server Utama.\n3. Periksa lampu indikator daya server Dell PowerEdge. Jika mati, pastikan unit UPS menyala dan kabel power terpasang.\n4. Jika server menyala namun RTO, periksa kabel LAN yang masuk ke LAN port server dan status switch core di atas rak server.\n5. Hubungi Admin Utama (Abid) untuk pengecekan service mysql, apache, atau error OS server via console server.",
                'access_level' => 'teknisi',
            ],

            // ==========================================
            // KATEGORI 6: FAQ Internal (5 entri)
            // ==========================================
            [
                'category' => 'faq',
                'title' => 'Cara Membuat Tiket Helpdesk',
                'keywords' => 'cara membuat tiket, buat tiket helpdesk, lapor masalah, buat laporan',
                'content' => "Cara membuat tiket bantuan:\n1. Login ke aplikasi IT Helpdesk ini.\n2. Masuk ke menu 'Tiket' di bagian atas halaman.\n3. Klik tombol 'Tambah Tiket Baru' atau 'Buat Tiket'.\n4. Isi kolom: Subjek, Deskripsi Masalah, Kategori, Prioritas, dan unggah foto bukti kerusakan jika ada.\n5. Klik tombol 'Simpan/Kirim'. Tiket Anda akan otomatis masuk ke sistem dan tim teknisi akan segera merespon.",
                'access_level' => 'user',
            ],
            [
                'category' => 'faq',
                'title' => 'Cara Menghubungi Teknisi Jaringan',
                'keywords' => 'kontak teknisi jaringan, hubungi teknisi, nomor it helpdesk, whatsapp teknisi',
                'content' => "Jika mengalami kendala jaringan internet atau butuh penanganan langsung:\n- Hubungi Kantor IT Center di lantai 1 Gedung IT Center.\n- Kontak WhatsApp Teknisi Jaringan: 089688267122 (Tsalis / Fajar).\n- Jam Operasional IT Helpdesk: Senin - Sabtu, Pukul 08:00 - 16:00 WIB.",
                'access_level' => 'user',
            ],
            [
                'category' => 'faq',
                'title' => 'Cara Login Sistem Helpdesk',
                'keywords' => 'cara login sistem, login helpdesk, cara masuk akun, login gagal',
                'content' => "Langkah masuk ke sistem helpdesk:\n1. Buka browser dan akses halaman utama helpdesk.\n2. Masukkan alamat email terdaftar (contoh: user@gmail.com) dan password Anda.\n3. Centang 'Remember me' jika ingin tetap login di perangkat pribadi.\n4. Klik 'Masuk/Login'. Jika lupa password, klik link 'Lupa Password?' untuk mereset via email terdaftar.",
                'access_level' => 'user',
            ],
            [
                'category' => 'faq',
                'title' => 'Cara Reset Password Akun',
                'keywords' => 'cara reset password akun, lupa sandi, ganti password, reset email',
                'content' => "Jika Anda lupa sandi atau ingin mengganti password:\n1. Di halaman login, klik tombol 'Lupa password Anda?'.\n2. Tulis alamat email Anda lalu klik 'Kirim Tautan Reset'.\n3. Buka kotak masuk email Anda, buka pesan dari IT Helpdesk, lalu klik link reset password di dalamnya.\n4. Masukkan password baru Anda dan konfirmasi. Selesai!\n*Bagi staf/santri yang tidak memiliki akses email luar, silakan hubungi admin di Ruang IT Center untuk reset manual.",
                'access_level' => 'user',
            ],
            [
                'category' => 'faq',
                'title' => 'Cara Menggunakan Chatbot AI',
                'keywords' => 'cara menggunakan chatbot, tanya chatbot, chatbot ai helpdesk, tanya ai',
                'content' => "Panduan Chatbot AI:\n- Anda dapat mengklik tombol ikon chat biru di sudut kanan bawah halaman mana saja untuk membuka widget Chatbot AI.\n- Ketik pertanyaan Anda (misal: 'Bagaimana cara reset password?' atau 'Berapa password wifi kantin putri?') lalu tekan enter.\n- Chatbot akan menjawab berdasarkan basis pengetahuan pesantren secara instan.\n- Sesi chat dibatasi maksimal 10 pesan user per sesi. Anda dapat menghapus riwayat chat kapan saja dengan mengklik ikon tempat sampah di atas widget.",
                'access_level' => 'user',
            ],
        ];

        foreach ($data as $item) {
            KnowledgeBase::create(array_merge($item, [
                'is_active' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
