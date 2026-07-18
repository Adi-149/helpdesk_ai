<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketMessage;
use App\Models\TicketHistory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign keys and truncate related tables
        Schema::disableForeignKeyConstraints();
        TicketMessage::truncate();
        TicketHistory::truncate();
        DB::table('notifications')->truncate();
        Ticket::truncate();
        Schema::enableForeignKeyConstraints();

        // Get users and supports
        $users = User::where('role', 'user')->get();
        $supports = User::where('role', 'support')->get();

        if ($users->isEmpty() || $supports->isEmpty()) {
            // Fallback if no users or supports found
            $users = User::factory()->count(40)->create(['role' => 'user']);
            $supports = User::factory()->count(6)->create(['role' => 'support']);
        }

        // Variasi lokasi
        $generalLocations = [
            'Toko Putra 1 - Asrama Putra',
            'Toko Putra 2 - Asrama Putra',
            'Kantin Putra - Asrama Putra',
            'Toko Putri 1 - Asrama Putri',
            'Toko Putri 2 - Asrama Putri',
            'Kantin Putri - Asrama Putri',
            'Toserba Perekonomian Sunan Drajat',
            'Minimarket Perekonomian Sunan Drajat',
            'Unit Usaha Perekonomian Sunan Drajat'
        ];

        $networkLocations = [
            'MTs Sunan Drajat',
            'MTs Muallimin Muallimat (MMA)',
            'MA Muallimin Muallimat (MMA)',
            'MA Ma\'arif 7 Sunan Drajat',
            'SMPN 2 Paciran (berada di lingkungan pesantren)',
            'SMK Sunan Drajat',
            'Ma\'had Aly Sunan Drajat',
            'Universitas Sunan Drajat (UNSUDA)'
        ];

        $devices = [
            'Laptop Asus Kasir', 'PC Lenovo POS', 'Printer Thermal Epson', 'Scanner Honeywell', 'CCTV Dahua', 'Server POS Utama'
        ];

        $softwares = [
            'Aplikasi Olsera POS', 'Aplikasi iReap POS', 'Sistem Kasir PHP', 'Database MySQL', 'Windows 10 IoT'
        ];

        // 21 Skenario dasar untuk 7 kategori baru
        $templates = [
            // Category: Hardware POS (1-3)
            [
                'category' => 'Hardware POS',
                'subject' => 'PC Kasir mboten saget urip wonten {location}',
                'description' => 'Permisi Pak, PC Kasir wonten {location} mati total, mboten saget dipun uripaken sanajan tombol power sampun dipun pencet. Lampu indikator keyboard nggih pejah. Monggo dipun bantu, terima kasih.',
                'ai_summary' => 'PC Kasir mati total dan tidak merespon tombol power.',
                'ai_causes' => "- Kabel power terputus atau kendor\n- Power supply unit (PSU) PC terbakar/rusak\n- Stop kontak listrik mati.",
                'ai_recommendations' => "1. Cek koneksi kabel power ke stop kontak.\n2. Tes stop kontak menggunakan alat lain.\n3. Lakukan penggantian PSU jika terbukti rusak.",
                'ai_confidence' => '95%',
                'resolution_summary' => 'Kerusakan pada unit PSU PC Kasir, berhasil diganti dengan PSU baru berkapasitas sama.',
                'messages' => [
                    'user1' => 'Permisi Pak, PC Kasir mboten saget urip wonten {location}. Pripun nggih?',
                    'support1' => 'Selamat pagi. Nggih, cobi dipun cek rumiyin kabel power wingking CPU punopo sampun tancep kenceng?',
                    'user2' => 'Sampun kenceng Pak, nanging tetep mboten urip lampu indikatore.',
                    'support2' => 'Baik, kulo mrika mbeta PSU cadangan kagem ngecek hardware-nipun.',
                    'user3' => 'Matur nuwun Pak, saniki PC kasir sampun saged urip malih lancar.'
                ]
            ],
            [
                'category' => 'Hardware POS',
                'subject' => 'Layar Monitor POS berkedip-kedip wonten {location}',
                'description' => 'Halo tim IT, layar monitor mesin POS wonten {location} kedap-kedip terus warnanipun pudar semu ijo. Mboten nyaman kagem ngelayani pembeli. Mohon dipun cek kabel utawi monitore.',
                'ai_summary' => 'Layar monitor mesin POS mengalami flickering dan perubahan warna.',
                'ai_causes' => "- Kabel VGA/HDMI kendor atau rusak\n- Driver grafis bermasalah\n- Kerusakan fisik pada panel monitor.",
                'ai_recommendations' => "1. Kencangkan atau ganti kabel konektor video (VGA/HDMI).\n2. Tes monitor menggunakan PC/laptop lain.",
                'ai_confidence' => '92%',
                'resolution_summary' => 'Kabel VGA kendor di belakang monitor POS berhasil dirapikan dan dikencangkan kembali.',
                'messages' => [
                    'user1' => 'Halo Pak, monitor POS wonten {location} kedap-kedip lan warnane ijo. Pripun niki?',
                    'support1' => 'Halo. Biasane kabel konektor VGA kendor. Cobi dipun puter baut pengenceng kabele.',
                    'user2' => 'Sampun kulo puter baut-e nanging tetep sami Pak.',
                    'support2' => 'Nggih, kulo mbeta kabel VGA enggal mrika kagem dipun ganti.',
                    'user3' => 'Sampun sae warnane lan mboten kedap-kedip malih Pak. Suwun.'
                ]
            ],
            [
                'category' => 'Hardware POS',
                'subject' => 'Keyboard kasir tombol angka mboten merespon wonten {location}',
                'description' => 'Selamat siang Pak, tombol angka 7, 8, lan 9 wonten keyboard kasir {location} mboten berfungsi/macet. Dados kangelan menawi input nominal transaksi manual. Nyuwun tulung dipun priksa.',
                'ai_summary' => 'Beberapa tombol angka pada keyboard kasir tidak berfungsi.',
                'ai_causes' => "- Kotoran menyumbat membran tombol\n- Kerusakan mekanis keyboard\n- Kerusakan port USB.",
                'ai_recommendations' => "1. Bersihkan keyboard menggunakan compressed air.\n2. Coba ganti ke port USB lain.\n3. Ganti unit keyboard kasir.",
                'ai_confidence' => '89%',
                'resolution_summary' => 'Unit keyboard kasir diganti baru karena sirkuit membran tombol angka sudah putus terkena tetesan air.',
                'messages' => [
                    'user1' => 'Selamat siang Pak, tombol angka keyboard kasir mboten merespon wonten {location}.',
                    'support1' => 'Siang. Cobi dipun pindah port USB keyboard-ipun dhateng lubang sanese.',
                    'user2' => 'Sampun kulo pindah port USB tetep mboten saged dipun pencet tombol 7-8-9.',
                    'support2' => 'Nggih, kulo mbeta keyboard cadangan mrika kagem dipungantos.',
                    'user3' => 'Matur nuwun sanget Pak, sakmenika transaksi input nominal sampun lancar.'
                ]
            ],

            // Category: Printer Thermal (4-6)
            [
                'category' => 'Printer Thermal',
                'subject' => 'Printer thermal struk mboten medal kertas wonten {location}',
                'description' => 'Permisi Pak, printer thermal kagem nyithak struk belanja wonten {location} mboten medal kertasipun pas transaksi rampung. Lampu error warna abang kelap-kelip. Tulung dipun priksa.',
                'ai_summary' => 'Printer thermal struk belanja tidak mengeluarkan kertas dengan indikator error menyala.',
                'ai_causes' => "- Kertas thermal habis atau salah pasang arah terbalik\n- Roller penarik kertas macet\n- Cover printer belum tertutup rapat.",
                'ai_recommendations' => "1. Buka cover printer, cek arah kertas thermal.\n2. Pastikan cover tertutup dengan rapat.\n3. Bersihkan sisa kertas di roller.",
                'ai_confidence' => '94%',
                'resolution_summary' => 'Kertas thermal terpasang terbalik arah gulungannya. Posisi kertas diperbaiki dan printer berjalan normal kembali.',
                'messages' => [
                    'user1' => 'Permisi Pak, printer struk mboten medal kertas wonten {location}, error abang.',
                    'support1' => 'Selamat siang. Nopo kertas thermal-ipun nembene diganti? Coba priksa arah pasang gulungane.',
                    'user2' => 'Oh nggih wau nembe dipun ganti kancan kulo. Kadosipun arah gulungane terbalik.',
                    'support2' => 'Nggih monggo dipun walik rumiyin posisine, menawi tasih abang kabari kulo.',
                    'user3' => 'Sampun kulo walik lan saged nyithak malih Pak. Matur nuwun.'
                ]
            ],
            [
                'category' => 'Printer Thermal',
                'subject' => 'Hasil cetak printer thermal burem / mboten cetho wonten {location}',
                'description' => 'Halo tim IT, printer thermal struk wonten {location} hasil cetakan tulisanipun burem sanget lan mboten cetho dipun waca. Kuwatir pelanggan protes amargi rincian regane mboten ketingal.',
                'ai_summary' => 'Hasil cetak printer thermal buram dan tidak terbaca jelas.',
                'ai_causes' => "- Printhead thermal kotor terkena debu atau residu kertas\n- Kualitas kertas thermal buruk\n- Pengaturan density cetak terlalu rendah.",
                'ai_recommendations' => "1. Bersihkan printhead thermal menggunakan cutton bud bersentuhan alkohol.\n2. Ganti roll kertas thermal baru.",
                'ai_confidence' => '91%',
                'resolution_summary' => 'Dilakukan pembersihan pada printhead menggunakan alcohol swab karena berdebu tebal.',
                'messages' => [
                    'user1' => 'Halo Pak, hasil cetak printer thermal wonten {location} burem sanget.',
                    'support1' => 'Halo. Niku biasane printhead-e kotor. Kulo mriki nggih nggowo pembersih alkohol.',
                    'user2' => 'Nggih Pak mangga, ditunggu wonten ruangan.',
                    'support2' => 'Sampun kulo resiki printhead-nipun lan kulo tes cetak. Saniki tulisanipun sampun cetho malih.',
                    'user3' => 'Alhamdulillah, sampun ketingal cetho sanget tulisane. Matur nuwun.'
                ]
            ],
            [
                'category' => 'Printer Thermal',
                'subject' => 'Printer thermal mboten terdeteksi sistem POS wonten {location}',
                'description' => 'Selamat sore Pak, printer struk thermal wonten {location} dumadakan mboten terdeteksi wonten aplikasi kasir. Status printer offline, kabel USB sampun dipun tancepaken ulang nanging sami mawon.',
                'ai_summary' => 'Printer thermal tidak terdeteksi oleh aplikasi POS (Status Offline).',
                'ai_causes' => "- Kabel data USB rusak/putus\n- Driver printer crash di sistem operasi\n- Pemilihan port port virtual COM salah.",
                'ai_recommendations' => "1. Lakukan restart pada PC Kasir.\n2. Cek status driver printer di Device Manager.\n3. Hubungkan kabel ke port USB lain.",
                'ai_confidence' => '90%',
                'resolution_summary' => 'Driver USB Spooler crash pada OS Windows. Dilakukan restart service Print Spooler dan printer berfungsi kembali.',
                'messages' => [
                    'user1' => 'Selamat sore Pak, printer thermal mboten terdeteksi sistem POS wonten {location}.',
                    'support1' => 'Sore. Cobi dipun restart rumiyin PC Kasire, menawi tetep mboten saged kulo remote.',
                    'user2' => 'Sampun dipun restart tetep offline statusipun wonten aplikasi.',
                    'support2' => 'Kulo remote sekedap nggih, tak uripake print spooler service-e.',
                    'user3' => 'Sampun ijo status kasire lan saget ngeprint transaksi malih. Suwun Pak.'
                ]
            ],

            // Category: Barcode Scanner (7-9)
            [
                'category' => 'Barcode Scanner',
                'subject' => 'Barcode scanner mboten medal sinar laser wonten {location}',
                'description' => 'Permisi Pak, barcode scannerHoneywell wonten {location} pejah, mboten medal sinar lasere pas dipun pencet tombol pelatuke. Scanner mboten muni "beep" blas.',
                'ai_summary' => 'Barcode scanner mati dan tidak mengeluarkan laser pemindai.',
                'ai_causes' => "- Kabel USB RJ45 kendor atau terlepas dari scanner\n- Port USB PC kotor/rusak\n- Kerusakan hardware optik laser.",
                'ai_recommendations' => "1. Periksa sambungan kabel RJ45 di bagian bawah gagang scanner.\n2. Pindahkan konektor USB ke port belakang PC.\n3. Uji pada komputer lain.",
                'ai_confidence' => '93%',
                'resolution_summary' => 'Kabel konektor RJ45 di bawah gagang scanner kendor. Setelah dipasang kembali hingga mengunci (klik), scanner berfungsi kembali.',
                'messages' => [
                    'user1' => 'Permisi Pak, barcode scanner mboten medal sinar laser wonten {location}.',
                    'support1' => 'Siang. Cobi dipun cek kabel sing mlebu gagang scanner ngisor, ditutul punopo kenceng?',
                    'user2' => 'Oh nggih wau rada kendor Pak, niki kulo surung mlebet nanging dereng muni beep.',
                    'support2' => 'Cobi dipun copot kabel USB-e banjur tancepake malih dhateng PC kasire.',
                    'user3' => 'Sampun muni beep lan lasere urip sae Pak. Matur nuwun.'
                ]
            ],
            [
                'category' => 'Barcode Scanner',
                'subject' => 'Barcode scanner saged nyorot nanging mboten input data wonten {location}',
                'description' => 'Halo IT support, barcode scanner wonten {location} saged nyorot laser abang lan muni beep, ananging datanipun mboten mlebet dhateng aplikasi POS kasir. Kode barange mboten otomatis terisi.',
                'ai_summary' => 'Barcode scanner memindai tetapi tidak mengirimkan input data ke PC.',
                'ai_causes' => "- Mode konfigurasi barcode scanner berubah (misal salah scan kertas panduan manual)\n- Driver keyboard emulation terganggu.",
                'ai_recommendations' => "1. Scan barcode reset default yang ada di buku manual scanner.\n2. Buka aplikasi notepad dan coba pindai untuk mengetes input langsung.",
                'ai_confidence' => '88%',
                'resolution_summary' => 'Scanner direset ke setelan pabrik (factory default) menggunakan lembar barcode konfigurasi resmi.',
                'messages' => [
                    'user1' => 'Halo Pak, barcode scanner saged nyorot nanging mboten input data wonten {location}.',
                    'support1' => 'Halo. Coba buka Notepad wonten PC Kasir, banjur scan barcode barang. Punopo metu angkane?',
                    'user2' => 'Mboten medal blas angkane wonten Notepad Pak, mung muni beep tok.',
                    'support2' => 'Nggih, kulo mrika nggawa lembaran manual book kagem reset mode USB keyboard-e.',
                    'user3' => 'Sampun saged mlebet angkane wonten aplikasi kasir Pak. Terima kasih.'
                ]
            ],
            [
                'category' => 'Barcode Scanner',
                'subject' => 'Lensa barcode scanner lecet / baret wonten {location}',
                'description' => 'Selamat siang, lensa kaca bagian ngajeng barcode scanner wonten {location} baret-baret parah amargi sering kenging meja. Scanner dados angel sanget mindai kode barcode sing rada cilik. Nyuwun ganti lensa utawi unit enggal.',
                'ai_summary' => 'Lensa pemindai baret menyebabkan penurunan sensitivitas scan.',
                'ai_causes' => "- Benturan berulang dengan meja kasir\n- Pembersihan lensa kaca menggunakan kain kasar.",
                'ai_recommendations' => "1. Ganti unit barcode scanner dengan yang baru.\n2. Berikan holder/dudukan scanner agar tidak mudah terbentur.",
                'ai_confidence' => '94%',
                'resolution_summary' => 'Penggantian unit barcode scanner baru karena lensa pemindai baret permanen.',
                'messages' => [
                    'user1' => 'Selamat siang, lensa barcode scanner baret wonten {location}. Angel mindai barcode cilik.',
                    'support1' => 'Siang. Oh nggih, menawi baret kacane kudu diganti unit. Kulo jupukke stok gudang riyen.',
                    'user2' => 'Nggih Pak suwun, nopo saget dipun pasang sekalian holder-ipun?',
                    'support2' => 'Saget. Niki sampun kulo ganti unit anyar lengkap karo holdere supados aman.',
                    'user3' => 'Wah sip Pak, sekarang scan jadi cepat and aman ditaruh holder. Terima kasih.'
                ]
            ],

            // Category: Jaringan & Internet (10-12) - Hanya untuk sekolah/institusi
            [
                'category' => 'Jaringan & Internet',
                'subject' => 'Internet Wifi Lab Komputer putus mboten saget akses ujian wonten {location}',
                'description' => 'Permisi Pak, internet WiFi wonten Lab Komputer {location} putus total. Para siswa mboten saget ngakses portal ujian online sekolah. Indikator router wifi kelap-kelip abang. Nyuwun tulung enggal dipun dandanaken amargi ujian nembe berlangsung.',
                'ai_summary' => 'WiFi Lab Komputer putus total saat pelaksanaan ujian online.',
                'ai_causes' => "- Kabel fiber optic (FO) backbone putus\n- Router Access Point hang/error\n- Koneksi ISP utama down.",
                'ai_recommendations' => "1. Restart router access point di Lab Komputer.\n2. Cek koneksi port WAN router.\n3. Hubungi provider internet (ISP) jika jalur FO bermasalah.",
                'ai_confidence' => '96%',
                'resolution_summary' => 'Terjadi kerusakan pada kabel LAN WAN router AP, diganti kabel LAN patch cord baru.',
                'messages' => [
                    'user1' => 'Permisi Pak, internet Wifi Lab Komputer putus mboten saget akses ujian wonten {location}. Emergency!',
                    'support1' => 'Selamat pagi. Nggih, kulo langsung mlayu menyang Lab Komputer kagem ngecek routere.',
                    'user2' => 'Nggih Pak ditunggu, niki bocah-bocah rame mboten saget loading soal.',
                    'support2' => 'Sampun kulo ganti kabel LAN WAN routere sing wau kancingane patah. Koneksi internet sampun normal.',
                    'user3' => 'Alhamdulillah, lare-lare sampun saget login ujian malih. Matur nuwun sanget respons cepate.'
                ]
            ],
            [
                'category' => 'Jaringan & Internet',
                'subject' => 'Koneksi internet lambat / lemot sanget wonten {location}',
                'description' => 'Halo tim IT, internet WiFi kantor TU wonten {location} lemot sanget kagem upload berkas laporan dapodik sekolah. Kecepatan download namung angsal 1 Mbps saking biasanipun 30 Mbps. Nyuwun bantuanipun.',
                'ai_summary' => 'Koneksi internet WiFi kantor TU lambat ekstrim.',
                'ai_causes' => "- FUP kuota internet ISP habis\n- Bandwidth terpakai habis oleh pengguna lain yang sedang download besar/streaming\n- Interferensi sinyal nirkabel.",
                'ai_recommendations' => "1. Cek utilisasi bandwidth di mikrotik bandwitdh test.\n2. Batasi aktivitas download ilegal.\n3. Hubungi ISP untuk menanyakan status paket.",
                'ai_confidence' => '87%',
                'resolution_summary' => 'Ditemukan salah satu komputer sedang menjalankan update Windows otomatis di latar belakang yang memakan bandwidth. Update ditunda sementara waktu.',
                'messages' => [
                    'user1' => 'Halo Pak, internet WiFi kantor TU lemot sanget wonten {location}.',
                    'support1' => 'Halo. Badhe kulo cek riyen trafik bandwidth-ipun saking mikrotik pusat nggih.',
                    'user2' => 'Nggih Pak tulung, kulo badhe kirim berkas dapodik penting niki.',
                    'support2' => 'Niki wonten PC staf sing download update Windows gedi sanget, sampun kulo pause limit bandwidth-e.',
                    'user3' => 'Lancar jaya saniki Pak, file dapodik sampun saged terkirim. Suwun.'
                ]
            ],
            [
                'category' => 'Jaringan & Internet',
                'subject' => 'Kabel LAN komputer TU putus terkelupas wonten {location}',
                'description' => 'Permisi Pak, kabel LAN ingkang nyambungaken PC komputer TU sekolah wonten {location} putus amargi ketindihan lemari arsip. Bagian tembagane nganti ketingal lan mboten saget nyambung internet. Mohon dipun ganti kabel LAN enggal.',
                'ai_summary' => 'Kabel LAN PC TU terkelupas fisik dan tidak terkoneksi ke jaringan.',
                'ai_causes' => "- Kerusakan fisik kabel LAN akibat terjepit lemari arsip.",
                'ai_recommendations' => "1. Ganti kabel LAN patch cord dengan kabel UTP baru.\n2. Lakukan routing kabel yang aman agar tidak terjepit kembali.",
                'ai_confidence' => '95%',
                'resolution_summary' => 'Dilakukan crimping konektor RJ45 and penggantian kabel LAN sepanjang 5 meter dengan posisi peletakan kabel yang aman.',
                'messages' => [
                    'user1' => 'Permisi Pak, kabel LAN komputer TU putus terkelupas wonten {location}. Internet mboten nyambung.',
                    'support1' => 'Selamat siang. Iya Pak, kulo mbeta kabel LAN baru lan crimping tool mrika.',
                    'user2' => 'Nggih Pak, suwun sanget dipun bantu.',
                    'support2' => 'Sampun kulo ganti kabel LAN enggal nggih. Saniki PC sampun nyambung internet malih.',
                    'user3' => 'Sampun normal Pak, matur nuwun bantuane.'
                ]
            ],

            // Category: CCTV (13-15)
            [
                'category' => 'CCTV',
                'subject' => 'Kamera CCTV area kasir mati mboten wonten gambar wonten {location}',
                'description' => 'Selamat pagi, kamera CCTV ingkang madep area kasir wonten {location} mati total, tampilan wonten layar monitor DVR kosong ireng (No Video). CCTV niki penting kagem ngawasi transaksi uang kasir. Tulung dipun dandanaken.',
                'ai_summary' => 'Kamera CCTV area kasir mati (No Video) di monitor DVR.',
                'ai_causes' => "- Adaptor power supply CCTV mati/rusak\n- Konektor BNC kendor atau kabel coaxial terputus\n- Kamera CCTV mengalami kerusakan hardware.",
                'ai_recommendations' => "1. Cek supply tegangan listrik adaptor CCTV.\n2. Periksa koneksi konektor BNC di belakang DVR dan kamera.\n3. Uji kamera menggunakan port DVR lain.",
                'ai_confidence' => '93%',
                'resolution_summary' => 'Adaptor power supply 12V untuk kamera CCTV kasir terbakar, berhasil diganti dengan adaptor baru.',
                'messages' => [
                    'user1' => 'Selamat pagi Pak, kamera CCTV area kasir mati wonten {location}.',
                    'support1' => 'Pagi. Nggih, badhe kulo cek sekedap adaptor lan sambungan BNC kamera kasir kasebut.',
                    'user2' => 'Nggih Pak, kuwatir menawi wonten selisih kas mboten saged dipun cek rekamanipun.',
                    'support2' => 'Ternyata adaptor-e mati. Sampun kulo ganti adaptor 12V anyar, gambare sampun metu maneh.',
                    'user3' => 'Sampun muncul gambare wonten layar monitor DVR Pak. Suwun sanget.'
                ]
            ],
            [
                'category' => 'CCTV',
                'subject' => 'Tampilan rekaman CCTV burem lan reged wonten {location}',
                'description' => 'Permisi tim IT, tampilan CCTV wonten {location} burem sanget lan pating slorot amargi lensa kacane reged sanget ketutup bledug lan sawang laba-laba. Gambar mboten cetho kagem dipun pantau. Mohon dipun resiki lensa kacane.',
                'ai_summary' => 'Tampilan video CCTV buram karena lensa kotor oleh debu dan sarang laba-laba.',
                'ai_causes' => "- Akumulasi debu lingkungan luar ruangan\n- Sarang laba-laba menutupi sensor inframerah kamera.",
                'ai_recommendations' => "1. Bersihkan fisik luar kamera dan kaca lensa menggunakan lap microfiber.\n2. Semprot cairan pembersih lensa khusus.",
                'ai_confidence' => '90%',
                'resolution_summary' => 'Fisik kamera CCTV dibersihkan dari debu tebal dan jaring laba-laba menggunakan tangga dan lap basah.',
                'messages' => [
                    'user1' => 'Permisi Pak, tampilan CCTV burem lan reged wonten {location}.',
                    'support1' => 'Halo. Nggih, mangke kulo mbeta tangga kagem ngresiki lensa kacane.',
                    'user2' => 'Nggih Pak mangga, ditunggu wonten toko.',
                    'support2' => 'Sampun kulo resiki nganggo cairan khusus nggih lensane. Gambare wis cetho lan resik.',
                    'user3' => 'Wah sae sanget gambare sakmenika Pak, matur nuwun.'
                ]
            ],
            [
                'category' => 'CCTV',
                'subject' => 'DVR CCTV mboten nyimpen rekaman video wonten {location}',
                'description' => 'Halo Pak, kulo badhe ndelok rekaman CCTV dinten wingi wonten {location} nanging mboten saged dipun putar. Kadosipun harddisk DVR-e mboten nyimpen video rekaman sama sekali. DVR muni bip-bip terus-terusan.',
                'ai_summary' => 'DVR CCTV tidak menyimpan rekaman video dan berbunyi alarm (Beeping).',
                'ai_causes' => "- Harddisk internal DVR rusak (bad sector)\n- Kabel data SATA harddisk kendor\n- Harddisk belum diformat di sistem DVR.",
                'ai_recommendations' => "1. Cek status penyimpanan harddisk di menu sistem DVR.\n2. Coba kencangkan kabel SATA.\n3. Format harddisk atau ganti unit HDD baru.",
                'ai_confidence' => '91%',
                'resolution_summary' => 'Harddisk internal DVR kapasitas 1TB rusak total (Read-Write Failure). Dilakukan penggantian dengan Harddisk Seagate Surveillance 1TB baru.',
                'messages' => [
                    'user1' => 'Halo Pak, DVR CCTV mboten nyimpen rekaman video wonten {location}. DVR-e muni beeping.',
                    'support1' => 'Halo. Muni beeping biasane harddisk-e rusak/error. Badhe kulo cek dashboard DVR-ipun.',
                    'user2' => 'Nggih tulung dicek Pak, soale penting kagem rekaman keamanan.',
                    'support2' => 'Status harddisk-e memang bad sector. Niki sampun kulo ganti harddisk enggal khusus CCTV.',
                    'user3' => 'Sampun mboten beeping malih DVR-e lan sampun saged nyimpen rekaman malih. Suwun Pak.'
                ]
            ],

            // Category: Software POS (16-18)
            [
                'category' => 'Software POS',
                'subject' => 'Aplikasi POS kasir crash / mboten saget dibukak wonten {location}',
                'description' => 'Permisi Pak, aplikasi POS Kasir wonten {location} macet mboten saget dipun bukak blas. Saben di-klik medal error "Application crash - database connection failed". Transaksi penjualan dinten niki dados terhambat.',
                'ai_summary' => 'Aplikasi POS Kasir crash dan tidak bisa dibuka akibat gagal koneksi database lokal.',
                'ai_causes' => "- Service database lokal (MySQL/SQLite) mati\n- File konfigurasi aplikasi POS korup\n- OS Windows terkena virus/malware.",
                'ai_recommendations' => "1. Jalankan ulang service database local.\n2. Cek file database .db atau config di folder instalasi.\n3. Install ulang aplikasi POS jika diperlukan.",
                'ai_confidence' => '95%',
                'resolution_summary' => 'Service database MySQL lokal mati secara mendadak. Setelah dijalankan ulang (restart service), aplikasi POS berjalan normal kembali.',
                'messages' => [
                    'user1' => 'Permisi Pak, aplikasi POS kasir mboten saget dibukak wonten {location}. crash terus.',
                    'support1' => 'Selamat siang. Kulo remote via AnyDesk nggih PC Kasire, nyuwun ID AnyDesk-ipun?',
                    'user2' => 'Nggih Pak, ID-nipun 987 654 321. Monggo.',
                    'support2' => 'MySQL server lokalan-e mati wau. Sampun kulo start ulang lan aplikasine sampun saged kabukak.',
                    'user3' => 'Sampun saged digunakan kagem transaksi malih Pak. Matur nuwun sanget.'
                ]
            ],
            [
                'category' => 'Software POS',
                'subject' => 'Error gagal sinkronisasi data transaksi POS pusat wonten {location}',
                'description' => 'Halo IT support, aplikasi kasir POS wonten {location} mboten saget ngirim data transaksi harian dhateng server pusat. Medal error "Sync failed: Timeout". Kuwatir data penjualan mboten ke-update wonten dashboard pusat.',
                'ai_summary' => 'Aplikasi POS gagal sinkronisasi data transaksi harian ke server pusat.',
                'ai_causes' => "- Koneksi internet ke server pusat tidak stabil/lambat\n- Server pusat sedang maintenance/offline\n- Data transaksi korup.",
                'ai_recommendations' => "1. Cek stabilitas ping ke server pusat.\n2. Jalankan force sync manual di menu konfigurasi POS.\n3. Periksa log error sinkronisasi.",
                'ai_confidence' => '90%',
                'resolution_summary' => 'Terjadi kendala overload request di server pusat, setelah dilakukan penjadwalan ulang sinkronisasi manual di luar jam sibuk, data berhasil sinkron.',
                'messages' => [
                    'user1' => 'Halo Pak, gagal sinkronisasi data transaksi POS pusat wonten {location}.',
                    'support1' => 'Halo. Coba di-ping server.sunandrajat.id saking CMD, punopo nyambung?',
                    'user2' => 'Nyambung Pak, nanging respon-ipun lambat RTO kadang-kadang.',
                    'support2' => 'Oh nggih servere nembe sibuk, cobi mangke jam 9 bengi di-klik tombol sinkronisasi manual malih.',
                    'user3' => 'Sampun kulo coba jam 9 bengi wau Pak lan sukses sinkron kabeh. Suwun.'
                ]
            ],
            [
                'category' => 'Software POS',
                'subject' => 'Gagal input barang baru ing aplikasi kasir wonten {location}',
                'description' => 'Selamat siang Pak, kulo mboten saget nambahaken data produk barang enggal wonten aplikasi POS {location}. Tombol "Simpan Produk" mboten merespon lan mboten medal pop-up sukses. Tulung dipun cek konfigurasi software kasire.',
                'ai_summary' => 'Gagal menyimpan input produk baru di aplikasi POS kasir.',
                'ai_causes' => "- Kolom data wajib (seperti SKU/Harga) belum terisi penuh\n- Masalah hak akses user role kasir terbatas\n- Bug sistem database lokal write-locked.",
                'ai_recommendations' => "1. Pastikan seluruh form input terisi terutama kolom wajib.\n2. Naikkan level akses akun user sementara.\n3. Lakukan restart aplikasi.",
                'ai_confidence' => '88%',
                'resolution_summary' => 'Akun kasir tidak memiliki otorisasi untuk menambah produk baru. Level akses diperbarui menjadi Supervisor Kasir.',
                'messages' => [
                    'user1' => 'Selamat siang Pak, gagal input produk baru wonten aplikasi POS {location}.',
                    'support1' => 'Siang. Punopo wonten notifikasi error-e? Utawi akun sampeyan pancen mboten gadah akses?',
                    'user2' => 'Mboten medal error Pak, mung mboten saged diklik tombol simpene.',
                    'support2' => 'Nggih, akun kasir niku pancen diwatesi. Niki hak aksese sampun kulo ganti supervisor kasir.',
                    'user3' => 'Sampun saged nyimpen barang enggal saniki Pak. Matur nuwun sanget.'
                ]
            ],

            // Category: Server & Database (19-21)
            [
                'category' => 'Server & Database',
                'subject' => 'Database POS pusat lambat diakses wonten {location}',
                'description' => 'Permisi Pak, akses databse transaksi pusat saking {location} krasa lambat sanget. loading data laporan penjualan butuh wektu nganti 5 menit lan sering RTO. Kadosipun server databasene keberatan beban.',
                'ai_summary' => 'Akses database transaksi pusat lambat dan sering mengalami timeout.',
                'ai_causes' => "- Query database tidak terindeks dengan baik (lack of indexing)\n- Penggunaan memori RAM server database penuh\n- Koneksi jaringan ke database server terhambat.",
                'ai_recommendations' => "1. Jalankan query analyzer untuk melihat slow query log.\n2. Lakukan optimization/indexing tabel transaksi harian.\n3. Upgrade RAM server jika diperlukan.",
                'ai_confidence' => '94%',
                'resolution_summary' => 'Dilakukan optimasi tabel database (optimize table) dan pembuatan index baru pada kolom tanggal_transaksi untuk mempercepat query search.',
                'messages' => [
                    'user1' => 'Permisi Pak, database POS pusat lambat diakses wonten {location}. Pripun nggih?',
                    'support1' => 'Selamat siang. Nggih Pak, server database nembe kulo cek, panggunaan RAM-ipun pancen munggah dadi 98%.',
                    'user2' => 'Nopo saged dipun optimalkan Pak? Laporan mboten rampung-rampung niki.',
                    'support2' => 'Sampun kulo jalanaken optimalisasi tabel database lan hapus cache log lawas. RAM mudun dadi 40%.',
                    'user3' => 'Mantap Pak, sakmenika loading laporan database sampun cepet sanget. Matur nuwun.'
                ]
            ],
            [
                'category' => 'Server & Database',
                'subject' => 'Server database POS pusat mati mendadak wonten {location}',
                'description' => 'Halo tim IT, server database pusat POS wonten {location} mati mendadak. Kabeh aplikasi kasir cabang mboten saget login lan nyambung database pusat. Lampu indikator server pejah. Mohon dipun priksa mesin servere.',
                'ai_summary' => 'Server database pusat mati mendadak menyebabkan kegagalan sistem kasir cabang.',
                'ai_causes' => "- Kerusakan listrik/mati lampu lokal di ruang server\n- Kerusakan hardware server (overheat atau motherboard rusak)\n- Power supply unit server terbakar.",
                'ai_recommendations' => "1. Lakukan failover otomatis/manual ke server database backup.\n2. Periksa fisik server utama di ruang server (suhu/pendingin).\n3. Ganti kipas pendingin server yang rusak.",
                'ai_confidence' => '95%',
                'resolution_summary' => 'Motherboard server mengalami mati akibat overheat kipas pendingin rusak. Sementara sistem dialihkan ke server backup (mirroring).',
                'messages' => [
                    'user1' => 'Halo Pak, server database pusat POS mati mendadak wonten {location}. Darurat!',
                    'support1' => 'Halo. Kulo langsung mlebet ruang server pusat nggih kagem ngecek fisik mesine.',
                    'user2' => 'Nggih Pak cepet, kasir-kasir cabang antri dowo mboten saget transaksi.',
                    'support2' => 'Fisik server panas banget lan kipase mati. Niki kulo oper sistem database-e menyang server backup (failover).',
                    'user3' => 'Alhamdulillah, kasir-kasir cabang sampun saget transaksi maneh nganggo server backup. Suwun sanget.'
                ]
            ],
            [
                'category' => 'Server & Database',
                'subject' => 'Error Gagal backup database otomatis harian wonten {location}',
                'description' => 'Permisi Pak, sistem monitoring ngirim notifikasi bilih backup database otomatis harian wonten {location} gagal dinten niki. Pesan errore "Disk full / space not enough". Ajrih menawi data ilang yen server utama rusak. Tulung dipun priksa.',
                'ai_summary' => 'Backup database otomatis gagal karena media penyimpanan penuh.',
                'ai_causes' => "- Kapasitas harddisk/storage backup server habis karena akumulasi file lama\n- Script backup otomatis crash.",
                'ai_recommendations' => "1. Cek sisa kapasitas penyimpanan di server backup.\n2. Pindahkan atau hapus file backup lama (misal yang lebih dari 6 bulan).\n3. Jalankan script backup manual.",
                'ai_confidence' => '92%',
                'resolution_summary' => 'Harddisk eksternal penyimpanan backup penuh. File backup lama tahun lalu dipindahkan ke cold storage cloud, backup otomatis berjalan lancar kembali.',
                'messages' => [
                    'user1' => 'Permisi Pak, gagal backup database otomatis harian wonten {location} amargi disk full.',
                    'support1' => 'Selamat siang. Nggih, kulo resiki riyen file-file backup lawas ingkang sampun mboten dienggo.',
                    'user2' => 'Nggih Pak, kuwatir menawi data transaksi ilang sewaktu-waktu.',
                    'support2' => 'Sampun kulo hapus backup lami lan kulo jalankan script backup manual. Backup sukses 100%.',
                    'user3' => 'Sip Pak, matur nuwun respons cepate.'
                ]
            ],
        ];

        // Total tiket sing badhe dibuat: 100
        $totalTicketsToSeed = 100;
        $now = Carbon::now();

        // Helper function kagem ngganti placeholders
        $replacePlaceholders = function($text, $userEmail, $location, $device, $software) {
            return str_replace(
                ['{location}', '{device}', '{software}', '{user_email}'],
                [$location, $device, $software, $userEmail],
                $text
            );
        };

        // Helper function kagem nerjemahake Jawa Krama dadi Indonesia (kagem 40% tiket)
        $translateToIndonesian = function($text) {
            $map = [
                'Nyuwun tulung' => 'Minta tolong',
                'nyuwun tulung' => 'minta tolong',
                'Nyuwun sewu' => 'Permisi',
                'nyuwun sewu' => 'permisi',
                'Ngapunten' => 'Mohon maaf',
                'ngapunten' => 'mohon maaf',
                'nyuwun pirsa' => 'tanya',
                'nyambut damel' => 'bekerja',
                'Nyambut damel' => 'Bekerja',
                'serahterimaken' => 'serahterimakan',
                'sasampunipun' => 'setelah',
                'mlebet malih' => 'masuk lagi',
                'Mlebet malih' => 'masuk lagi',
                'mboten saget' => 'tidak bisa',
                'Mboten saget' => 'tidak bisa',
                'kelap-kelip' => 'berkedip-kedip',
                'Kelap-kelip' => 'berkedip-kedip',
                'matur nuwun sanget' => 'terima kasih banyak',
                'Matur nuwun sanget' => 'terima kasih banyak',
                'matur nuwun' => 'terima kasih',
                'Matur nuwun' => 'terima kasih',
                'maturnuwun' => 'terima kasih',
                'suwun sanget' => 'terima kasih banyak',
                'Suwun sanget' => 'terima kasih banyak',
                'ping tiga' => 'tiga kali',
                'sebataken' => 'sebutkan',
                'panjenengan' => 'Anda',
                'kadosipun' => 'sepertinya',
                'Kadosipun' => 'sepertinya',
                'namanipun' => 'namanya',
                'sakmenika' => 'sekarang',
                'Sakmenika' => 'sekarang',
                'dhumateng' => 'kepada',
                'dumateng' => 'kepada',
                'pangguna' => 'pengguna',
                'kekunci' => 'terkunci',
                'rumiyin' => 'terlebih dahulu',
                'sekedap' => 'sebentar',
                'Sekedap' => 'sebentar',
                'ngandhap' => 'bawah',
                'kemawon' => 'saja',
                'damelaken' => 'buatkan',
                'datanipun' => 'datanya',
                'ruwet' => 'berantakan',
                'adhem' => 'dingin',
                'kesrimpet' => 'tersangkut',
                'enjang' => 'pagi',
                'njaluk' => 'minta',
                'nyimpen' => 'menyimpan',
                'leren' => 'berhenti',
                'muni' => 'berbunyi',
                'banter' => 'kencang',
                'reresik' => 'membersihkan',
                'ngisor' => 'bawah',
                'mriki' => 'sini',
                'kulo' => 'saya',
                'Kulo' => 'saya',
                'mboten' => 'tidak',
                'Mboten' => 'tidak',
                'saget' => 'bisa',
                'Saget' => 'bisa',
                'sampun' => 'sudah',
                'Sampun' => 'sudah',
                'kesupen' => 'lupa',
                'Kesupen' => 'lupa',
                'dereng' => 'belum',
                'badhe' => 'akan',
                'Badhe' => 'akan',
                'riyen' => 'dulu',
                'Riyen' => 'dulu',
                'kagem' => 'untuk',
                'Kagem' => 'untuk',
                'wau' => 'tadi',
                'cobi' => 'coba',
                'Cobi' => 'coba',
                'abang' => 'merah',
                'lebet' => 'dalam',
                'mrika' => 'ke sana',
                'mbeta' => 'membawa',
                'Mbeta' => 'membawa',
                'risak' => 'rusak',
                'leres' => 'benar',
                'anyar' => 'baru',
                'dangu' => 'lama',
                'benter' => 'panas',
                'kesel' => 'lelah',
                'nggih' => 'iya',
                'Nggih' => 'iya',
                'wonten' => 'di',
                'saking' => 'dari',
                'punopo' => 'apakah',
                'nopo' => 'apakah',
                'niku' => 'itu',
                'niki' => 'ini',
                'Niki' => 'ini',
                'enten' => 'ada',
                'utawi' => 'atau',
                'suwun' => 'terima kasih',
                'Suwun' => 'terima kasih',
                'amargi' => 'karena',
                'Amargi' => 'karena',
                'pripun' => 'bagaimana',
                'Pripun' => 'bagaimana',
                'malih' => 'lagi',
                'dipun' => 'di',
                'nyuwun' => 'minta',
                'sewu' => 'maaf',
                'kasebut' => 'tersebut',
                'carane' => 'caranya',
                'ngaktifake' => 'mengaktifkan',
                'aktifake' => 'aktifkan',
                'monggo' => 'silakan',
                'Monggo' => 'silakan',
                'ananging' => 'tetapi',
                'nanging' => 'tetapi',
                'namung' => 'hanya',
                'tasih' => 'masih',
                'saged' => 'bisa',
                'dipun uripaken' => 'dinyalakan',
                'urip' => 'hidup',
                'uripaken' => 'nyalakan',
                'pejah' => 'mati',
                'uripake' => 'nyalakan',
                'dipungantos' => 'diganti',
                'walik' => 'balik',
                'waliklah' => 'baliklah',
                'cetho' => 'jelas',
                'dandanaken' => 'diperbaiki',
                'enggal' => 'baru',
                'lare-lare' => 'anak-anak',
                'dapodik' => 'dapodik',
                'baret' => 'baret',
                'slorot' => 'slorot',
                'reged' => 'kotor',
                'sawang' => 'sarang',
                'bip-bip' => 'bip-bip',
                'kabukak' => 'terbuka',
                'munggah' => 'naik',
                'mudun' => 'turun',
                'dienggo' => 'dipakai',
            ];
            
            // Urutkan key berdasarkan panjang string secara menurun agar frasa panjang diterjemahkan terlebih dahulu
            uksort($map, function($a, $b) {
                return strlen($b) - strlen($a);
            });
            
            $replaced = str_replace(array_keys($map), array_values($map), $text);
            return str_replace(array_keys($map), array_values($map), $replaced);
        };

        // Mulai looping kagem generate 100 tiket
        for ($i = 1; $i <= $totalTicketsToSeed; $i++) {
            // Pilih template adhedhasar sisa bagi (modulus 21)
            $templateIndex = ($i - 1) % count($templates);
            $tpl = $templates[$templateIndex];

            // Acak nilai kagem placeholders berdasarkan kategori
            if ($tpl['category'] === 'Jaringan & Internet') {
                $location = $networkLocations[array_rand($networkLocations)];
            } else {
                $location = $generalLocations[array_rand($generalLocations)];
            }
            $device = $devices[array_rand($devices)];
            $software = $softwares[array_rand($softwares)];

            // Pilih random user (pelapor)
            $user = $users->random();
            // Pilih random support (teknisi)
            $support = $supports->random();

            // Setel tanggal nggawe tiket (rentang 1 wulan pungkasan: 0 - 30 hari yang lalu)
            $daysAgo = rand(0, 30);
            $hoursAgo = rand(0, 23);
            $minutesAgo = rand(0, 59);
            $createdAt = $now->copy()->subDays($daysAgo)->subHours($hoursAgo)->subMinutes($minutesAgo);

            // Setel status secara lebih realistis berdasarkan umur tiket:
            // Tiket lama (> 7 hari) seharusnya sudah selesai (resolved atau closed)
            // Tiket baru (<= 7 hari) bisa berstatus open, progress, resolved, atau closed
            if ($daysAgo > 7) {
                // 30% resolved, 70% closed
                $statusRandom = rand(1, 10);
                if ($statusRandom <= 3) {
                    $status = 'resolved';
                } else {
                    $status = 'closed';
                }
            } else {
                // Tiket baru (<= 7 hari)
                if ($daysAgo === 0) {
                    // Hari ini: 60% open, 30% progress, 10% resolved
                    $statusRandom = rand(1, 10);
                    if ($statusRandom <= 6) {
                        $status = 'open';
                    } elseif ($statusRandom <= 9) {
                        $status = 'progress';
                    } else {
                        $status = 'resolved';
                    }
                } elseif ($daysAgo <= 2) {
                    // 1-2 hari lalu: 30% open, 40% progress, 20% resolved, 10% closed
                    $statusRandom = rand(1, 10);
                    if ($statusRandom <= 3) {
                        $status = 'open';
                    } elseif ($statusRandom <= 7) {
                        $status = 'progress';
                    } elseif ($statusRandom <= 9) {
                        $status = 'resolved';
                    } else {
                        $status = 'closed';
                    }
                } else {
                    // 3-7 hari lalu: 10% open, 20% progress, 30% resolved, 40% closed
                    $statusRandom = rand(1, 10);
                    if ($statusRandom <= 1) {
                        $status = 'open';
                    } elseif ($statusRandom <= 3) {
                        $status = 'progress';
                    } elseif ($statusRandom <= 6) {
                        $status = 'resolved';
                    } else {
                        $status = 'closed';
                    }
                }
            }

            // Set prioritas acak
            $priorities = ['low', 'medium', 'high'];
            $priority = $priorities[array_rand($priorities)];

            // Setel assigned_to (namung menawi mboten 'open')
            $assignedTo = ($status === 'open') ? null : $support->id;

            // Setel tanggal update (created_at + jeda acak)
            $updatedAt = $createdAt->copy();
            if ($status !== 'open') {
                // Jeda update acak 1-48 jam
                $updatedAt = $createdAt->copy()->addHours(rand(1, 48))->addMinutes(rand(0, 59));
                if ($updatedAt->gt($now)) {
                    $updatedAt = $now->copy();
                }
            }

            // Cek apakah tiket ini bagian dari 40% tiket yang mengutamakan bahasa Indonesia
            $isPrimarilyIndonesian = (($i % 5) === 0 || ($i % 5) === 1);

            // Ganti placeholder ing subyek lan deskripsi
            $subject = $replacePlaceholders($tpl['subject'], $user->email, $location, $device, $software);
            $description = $replacePlaceholders($tpl['description'], $user->email, $location, $device, $software);
            $aiSummary = $replacePlaceholders($tpl['ai_summary'], $user->email, $location, $device, $software);
            $aiCauses = $replacePlaceholders($tpl['ai_causes'], $user->email, $location, $device, $software);
            $aiRecommendations = $replacePlaceholders($tpl['ai_recommendations'], $user->email, $location, $device, $software);
            
            // Resolution summary namung kagem resolved/closed
            $resolutionSummary = null;
            if ($status === 'resolved' || $status === 'closed') {
                $resolutionSummary = $replacePlaceholders($tpl['resolution_summary'], $user->email, $location, $device, $software);
            }

            // Jika 40% tiket bahasa Indonesia, terjemahkan semua konten ke bahasa Indonesia penuh
            if ($isPrimarilyIndonesian) {
                $subject = $translateToIndonesian($subject);
                $description = $translateToIndonesian($description);
                $aiSummary = $translateToIndonesian($aiSummary);
                $aiCauses = $translateToIndonesian($aiCauses);
                $aiRecommendations = $translateToIndonesian($aiRecommendations);
                if ($resolutionSummary) {
                    $resolutionSummary = $translateToIndonesian($resolutionSummary);
                }
            }

            // Simpen data tiket
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'subject' => $subject . " (#" . $i . ")",
                'description' => $description,
                'category' => $tpl['category'],
                'priority' => $priority,
                'status' => $status,
                'assigned_to' => $assignedTo,
                'attachment' => null,
                'ai_summary' => $aiSummary,
                'ai_causes' => $aiCauses,
                'ai_recommendations' => $aiRecommendations,
                'ai_confidence' => $tpl['ai_confidence'],
                'resolution_summary' => $resolutionSummary,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ]);

            // ==========================================
            // GENERATE CHAT DIALOGUE (TICKET MESSAGES)
            // ==========================================
            $msgTemplates = $tpl['messages'];
            $msgCount = 0;

            if ($status === 'open') {
                $msgCount = 1; // Namung pesan awal user
            } elseif ($status === 'progress') {
                $msgCount = 3; // User -> Support -> User
            } else {
                $msgCount = 5; // User -> Support -> User -> Support -> User
            }

            // Simpen pesan obrolan kanthi jeda wektu sing natural
            $currentMsgTime = $createdAt->copy();

            for ($m = 1; $m <= $msgCount; $m++) {
                $senderId = null;
                $msgContent = '';

                if ($m === 1) {
                    $senderId = $user->id;
                    $msgContent = $replacePlaceholders($msgTemplates['user1'], $user->email, $location, $device, $software);
                } elseif ($m === 2) {
                    $senderId = $support->id;
                    $msgContent = $replacePlaceholders($msgTemplates['support1'], $user->email, $location, $device, $software);
                    $currentMsgTime = $currentMsgTime->copy()->addMinutes(rand(5, 30));
                } elseif ($m === 3) {
                    $senderId = $user->id;
                    $msgContent = $replacePlaceholders($msgTemplates['user2'], $user->email, $location, $device, $software);
                    $currentMsgTime = $currentMsgTime->copy()->addMinutes(rand(5, 30));
                } elseif ($m === 4) {
                    $senderId = $support->id;
                    $msgContent = $replacePlaceholders($msgTemplates['support2'], $user->email, $location, $device, $software);
                    $currentMsgTime = $currentMsgTime->copy()->addMinutes(rand(15, 120));
                } elseif ($m === 5) {
                    $senderId = $user->id;
                    $msgContent = $replacePlaceholders($msgTemplates['user3'], $user->email, $location, $device, $software);
                    $currentMsgTime = $currentMsgTime->copy()->addMinutes(rand(5, 30));
                }

                // Terjemahkan ke Indonesia jika tiket diset bahasa Indonesia
                if ($isPrimarilyIndonesian) {
                    $msgContent = $translateToIndonesian($msgContent);
                }

                // Cek supados wektu mboten ngliwati wektu saiki
                if ($currentMsgTime->gt($now)) {
                    $currentMsgTime = $now->copy();
                }

                TicketMessage::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $senderId,
                    'message' => $msgContent,
                    'created_at' => $currentMsgTime,
                    'updated_at' => $currentMsgTime,
                ]);
            }

            // ==========================================
            // GENERATE TICKET HISTORIES (STATUS LOGS)
            // ==========================================
            
            // History 1: Tiket dibuat (Kabeh status duwe niki)
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => $user->id,
                'old_status' => null,
                'new_status' => 'open',
                'notes' => 'Tiket berhasil dibuat.',
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);

            // History 2: Tiket dialihkan ke progress (Kagem progress, resolved, lan closed)
            if ($status !== 'open') {
                $progressTime = $createdAt->copy()->addMinutes(rand(5, 30));
                if ($progressTime->gt($now)) {
                    $progressTime = $now->copy();
                }

                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $support->id,
                    'old_status' => 'open',
                    'new_status' => 'progress',
                    'notes' => 'Teknisi mengambil alih tiket.',
                    'created_at' => $progressTime,
                    'updated_at' => $progressTime,
                ]);

                // History 3: Tiket diselesaikan (Kagem resolved lan closed)
                if ($status === 'resolved' || $status === 'closed') {
                    $resolvedTime = $updatedAt->copy();
                    if ($status === 'closed') {
                        $resolvedTime = $updatedAt->copy()->subMinutes(rand(10, 60));
                    }

                    TicketHistory::create([
                        'ticket_id' => $ticket->id,
                        'user_id' => $support->id,
                        'old_status' => 'progress',
                        'new_status' => 'resolved',
                        'notes' => 'Kendala berhasil diselesaikan oleh teknisi.',
                        'created_at' => $resolvedTime,
                        'updated_at' => $resolvedTime,
                    ]);

                    // History 4: Tiket ditutup dening user (Namung kagem closed)
                    if ($status === 'closed') {
                        TicketHistory::create([
                            'ticket_id' => $ticket->id,
                            'user_id' => $user->id,
                            'old_status' => 'resolved',
                            'new_status' => 'closed',
                            'notes' => 'Pengguna mengonfirmasi penyelesaian tiket.',
                            'created_at' => $updatedAt,
                            'updated_at' => $updatedAt,
                        ]);
                    }
                }
            }
        }
    }
}
