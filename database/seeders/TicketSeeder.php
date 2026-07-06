<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and supports
        $users = User::where('role', 'user')->get();
        $supports = User::where('role', 'support')->get();

        if ($users->isEmpty() || $supports->isEmpty()) {
            // Fallback if no users or supports found
            $users = User::factory()->count(5)->create(['role' => 'user']);
            $supports = User::factory()->count(3)->create(['role' => 'support']);
        }

        // Templates for realistic tickets
        $templates = [
            'Akun' => [
                [
                    'subject' => 'Lupa password akun Portal Akademik',
                    'description' => 'Saya tidak dapat mengakses akun portal akademik saya karena lupa password. Sudah mencoba reset via email tetapi token tidak masuk ke inbox.',
                    'ai_summary' => 'Pengguna tidak dapat login ke Portal Akademik karena lupa password dan email token reset tidak terkirim.',
                    'ai_causes' => "- Kredensial password lama tidak valid atau kadaluarsa\n- Konfigurasi server SMTP email pengirim mengalami kendala\n- Email tersaring ke folder spam atau folder promosi.",
                    'ai_recommendations' => "1. Lakukan reset password secara manual dari panel administrasi user.\n2. Verifikasi status akun pengguna apakah aktif atau dinonaktifkan.\n3. Uji pengiriman SMTP server untuk reset token.",
                    'ai_confidence' => '95%',
                    'resolution_summary' => 'Masalah: Lupa login portal akademik.\nPenyebab: Lupa password lama.\nSolusi: Reset password manual berhasil dilakukan oleh teknisi dan kredensial baru dikirim ke kontak terdaftar.'
                ],
                [
                    'subject' => 'Akun SIMPEG terkunci setelah salah password',
                    'description' => 'Saya mencoba login ke aplikasi SIMPEG untuk mengisi data cuti, tetapi setelah 3 kali salah memasukkan password, akun saya langsung terkunci dan tidak bisa diakses.',
                    'ai_summary' => 'Akun SIMPEG pengguna terkunci secara otomatis akibat kegagalan otentikasi login berturut-turut.',
                    'ai_causes' => "- Proteksi brute-force mengunci akun secara otomatis\n- Pengguna salah memasukkan kombinasi karakter password.",
                    'ai_recommendations' => "1. Buka kunci akun (unlock account) melalui modul admin SIMPEG.\n2. Lakukan reset password dan minta pengguna menggunakan kombinasi huruf besar dan angka.",
                    'ai_confidence' => '92%',
                    'resolution_summary' => 'Masalah: Akun SIMPEG terkunci.\nPenyebab: Salah memasukkan password 3 kali.\nSolusi: Teknisi membuka kunci akun di sistem admin dan membantu mereset password baru.'
                ],
                [
                    'subject' => 'Gagal verifikasi OTP di Aplikasi Kehadiran',
                    'description' => 'Aplikasi presensi online di HP saya meminta kode verifikasi OTP saat masuk, tetapi SMS OTP tidak kunjung masuk ke nomor HP saya.',
                    'ai_summary' => 'Masalah penerimaan kode OTP via SMS pada aplikasi presensi online.',
                    'ai_causes' => "- Saldo gateway SMS habis atau sedang limit\n- Provider seluler pengguna mengalami gangguan penerimaan pesan premium\n- Format nomor HP salah di database.",
                    'ai_recommendations' => "1. Periksa log pengiriman gateway SMS untuk melihat error.\n2. Uji kirim SMS manual ke nomor pengguna untuk pengecekan jaringan.\n3. Berikan opsi pengiriman alternatif OTP (seperti email).",
                    'ai_confidence' => '87%',
                    'resolution_summary' => 'Masalah: Kode OTP SMS tidak diterima.\nPenyebab: Gangguan pada operator seluler pengguna.\nSolusi: Teknisi sementara waktu mengganti metode verifikasi ke e-mail agar user dapat presensi.'
                ]
            ],
            'Hardware' => [
                [
                    'subject' => 'Printer Epson L3110 Ruang Administrasi macet (Paper Jam)',
                    'description' => 'Printer mengalami paper jam terus menerus saat kami mencetak laporan bulanan. Lampu indikator kertas berkedip merah dan tidak bisa ditarik.',
                    'ai_summary' => 'Printer Epson L3110 mengalami paper jam dan tidak dapat menarik kertas.',
                    'ai_causes' => "- Adanya benda asing (klip kertas/debu tebal) pada roller penarik\n- Penempatan kertas pada tray miring atau terlalu penuh\n- Sensor deteksi kertas mengalami kegagalan fungsi.",
                    'ai_recommendations' => "1. Periksa bagian dalam tray kertas untuk mendeteksi benda asing secara visual.\n2. Bersihkan karet roller penarik menggunakan pembersih khusus.\n3. Lakukan test print halaman kosong.",
                    'ai_confidence' => '90%',
                    'resolution_summary' => 'Masalah: Printer paper jam.\nPenyebab: Ditemukan klip kertas menyangkut di dalam gigi roller penarik.\nSolusi: Teknisi membongkar bodi printer bagian atas dan mengeluarkan klip kertas secara hati-hati.'
                ],
                [
                    'subject' => 'Komputer Unit Gawat Darurat lambat dan sering mati sendiri',
                    'description' => 'Komputer di meja pendaftaran UGD sangat lambat saat membuka aplikasi pendaftaran, serta sering tiba-tiba mati sendiri tanpa ada peringatan.',
                    'ai_summary' => 'PC pendaftaran UGD mengalami penurunan performa ekstrim dan sering shutdown otomatis.',
                    'ai_causes' => "- Overheating pada prosesor akibat fan/heatsink berdebu atau pasta kering\n- Power supply unit (PSU) tidak stabil atau mengalami drop tegangan\n- Penyimpanan HDD/SSD sudah dalam kondisi bad sector.",
                    'ai_recommendations' => "1. Lakukan pembersihan debu fisik pada CPU dan ganti thermal paste prosesor.\n2. Periksa kestabilan PSU dengan alat tester.\n3. Lakukan diagnostic test pada HDD/SSD.",
                    'ai_confidence' => '88%',
                    'resolution_summary' => 'Masalah: Komputer lambat dan restart acak.\nPenyebab: Thermal paste kering dan debu menyumbat kipas CPU hingga terjadi overheat.\nSolusi: Teknisi membersihkan debu CPU, mengganti thermal paste baru, dan menambah memori RAM 4GB.'
                ],
                [
                    'subject' => 'Monitor LCD berkedip dan muncul garis horizontal',
                    'description' => 'Tampilan layar monitor di ruang rapat utama berkedip terus menerus dan menampilkan garis warna-warni horizontal di bagian tengah layar.',
                    'ai_summary' => 'Gangguan visual berupa distorsi garis horizontal dan kedipan pada layar monitor.',
                    'ai_causes' => "- Kabel konektor (HDMI/VGA) tidak terpasang kencang atau rusak/terkelupas\n- Port output grafis pada PC kotor atau longgar\n- Panel LCD monitor mengalami kerusakan sirkuit internal.",
                    'ai_recommendations' => "1. Lakukan penggantian kabel VGA/HDMI dengan kabel cadangan baru.\n2. Hubungkan monitor ke perangkat PC lain untuk mengisolasi masalah.\n3. Periksa apakah driver GPU pada PC telah diperbarui.",
                    'ai_confidence' => '84%',
                    'resolution_summary' => 'Masalah: Layar berkedip dan bergaris.\nPenyebab: Kerusakan pada kabel HDMI yang tertekuk.\nSolusi: Melakukan penggantian kabel HDMI baru berkualitas tinggi.'
                ]
            ],
            'Jaringan' => [
                [
                    'subject' => 'Koneksi internet WiFi di Gedung B Lantai 2 sering putus',
                    'description' => 'Sinyal WiFi Staff-Net di lantai 2 gedung B terdeteksi lemah dan sering terputus sendiri secara acak setiap beberapa menit.',
                    'ai_summary' => 'Koneksi WiFi tidak stabil dan sering terputus di Gedung B lantai 2.',
                    'ai_causes' => "- Jangkauan access point kurang luas atau terhalang dinding partisi beton\n- Interferensi sinyal nirkabel dari kanal frekuensi tetangga yang padat\n- Beban koneksi pengguna yang terlalu tinggi di AP tersebut.",
                    'ai_recommendations' => "1. Posisikan ulang access point ke area terbuka tanpa penghalang.\n2. Konfigurasikan pemindahan kanal frekuensi nirkabel ke kanal kosong.\n3. Tambah unit repeater jika diperlukan.",
                    'ai_confidence' => '89%',
                    'resolution_summary' => 'Masalah: WiFi putus-putus.\nPenyebab: Interferensi saluran frekuensi dengan AP gedung sebelah.\nSolusi: Teknisi memindahkan kanal frekuensi AP di lantai 2 ke saluran bebas interferensi.'
                ],
                [
                    'subject' => 'Komputer staff keuangan tidak terhubung jaringan kabel (LAN)',
                    'description' => 'Di sudut kanan bawah layar ada tanda silang merah pada ikon jaringan. Saya sudah mencoba mencolokkan ulang kabel LAN tetapi tetap tidak bisa tersambung ke jaringan kantor.',
                    'ai_summary' => 'Kegagalan koneksi jaringan kabel ethernet (LAN) pada komputer staf keuangan.',
                    'ai_causes' => "- Kabel LAN (RJ45) putus di tengah atau pin konektor rusak\n- Port RJ45 di dinding (wall outlet) atau port switch tidak aktif\n- Driver Network Interface Card (NIC) tidak terinstal dengan benar.",
                    'ai_recommendations' => "1. Uji kabel LAN menggunakan LAN tester.\n2. Coba colokkan kabel ke port switch lain yang terbukti aktif.\n3. Periksa konfigurasi IP address (apakah DHCP atau statis salah).",
                    'ai_confidence' => '91%',
                    'resolution_summary' => 'Masalah: LAN tidak tersambung.\nPenyebab: Konektor RJ45 pemisah pengunci pecah sehingga longgar.\nSolusi: Teknisi melakukan crimping ulang kepala konektor RJ45 baru pada kabel LAN.'
                ],
                [
                    'subject' => 'Gagal akses ke Server File Sharing lokal',
                    'description' => 'Semua staf di divisi pemasaran tidak bisa mengakses folder bersama (Server File Sharing) dengan alamat \\\\192.168.1.50. Muncul pesan Network Path Not Found.',
                    'ai_summary' => 'Akses terputus menuju server file sharing internal perusahaan.',
                    'ai_causes' => "- IP Address server file sharing berubah atau server mati/restart\n- Blokir port sharing file (port 445 SMB) oleh firewall komputer klien\n- Masalah routing/segmen IP antar divisi.",
                    'ai_recommendations' => "1. Lakukan ping ke IP server 192.168.1.50 dari komputer korban.\n2. Pastikan service file sharing SMB pada server dalam kondisi aktif.\n3. Periksa aturan inbound/outbound pada firewall jaringan.",
                    'ai_confidence' => '86%',
                    'resolution_summary' => 'Masalah: Server file sharing tidak bisa diakses.\nPenyebab: Listrik server padam akibat UPS mati mendadak.\nSolusi: Teknisi menyalakan ulang server secara fisik dan memverifikasi konfigurasi IP statis.'
                ]
            ],
            'Software' => [
                [
                    'subject' => 'Aplikasi SIMRS gagal menyimpan data pasien baru',
                    'description' => 'Muncul pesan error "SQLSTATE[23000]: Integrity constraint violation" ketika kami menyimpan formulir pendaftaran pasien rawat jalan.',
                    'ai_summary' => 'Aplikasi SIMRS mengalami error runtime database saat entri data pasien.',
                    'ai_causes' => "- Adanya data ganda pada kolom bernilai unik (seperti NIK atau nomor rekam medis)\n- Validasi form aplikasi tidak mendeteksi input kosong di kolom wajib\n- Skema database yang belum dimigrasikan dengan benar.",
                    'ai_recommendations' => "1. Periksa log database SIMRS untuk mengetahui kolom yang memicu error.\n2. Tinjau data duplikat di tabel pasien.\n3. Perbaiki validasi input pada kode program pendaftaran.",
                    'ai_confidence' => '88%',
                    'resolution_summary' => 'Masalah: Error pendaftaran pasien SIMRS.\nPenyebab: Percobaan input NIK pasien yang sudah terdaftar di sistem sebelumnya.\nSolusi: Teknisi menambahkan validasi pengecekan duplikasi NIK sebelum form disubmit.'
                ],
                [
                    'subject' => 'Aplikasi Microsoft Word macet (Not Responding) saat dibuka',
                    'description' => 'Setiap kali saya membuka aplikasi Word untuk membuat surat, aplikasi langsung macet dan muncul tulisan Not Responding, lalu tertutup sendiri.',
                    'ai_summary' => 'Aplikasi Microsoft Word mengalami crash sesaat setelah diluncurkan.',
                    'ai_causes' => "- Add-ins pihak ketiga yang rusak atau tidak kompatibel\n- Berkas instalasi Office mengalami kerusakan (corrupted file)\n- Profil template Word default (normal.dotm) rusak.",
                    'ai_recommendations' => "1. Jalankan Word dalam Safe Mode untuk menguji add-ins.\n2. Lakukan perbaikan aplikasi Office melalui menu Control Panel (Quick Repair).\n3. Hapus berkas normal.dotm yang lama agar Word membuat yang baru.",
                    'ai_confidence' => '85%',
                    'resolution_summary' => 'Masalah: Word crash Not Responding.\nPenyebab: Add-in pihak ketiga (Mendeley/Grammarly) tidak kompatibel.\nSolusi: Menonaktifkan add-in bermasalah melalui opsi menu Word Safe Mode.'
                ],
                [
                    'subject' => 'E-mail Outlook tidak bisa mengirim pesan (Error 0x800CCC0F)',
                    'description' => 'Saya bisa menerima email masuk di Microsoft Outlook, tetapi saat mencoba membalas email, e-mail tersebut tetap tersangkut di Outbox dengan kode error 0x800CCC0F.',
                    'ai_summary' => 'Outlook gagal mengirim e-mail klien dengan kode error SMTP.',
                    'ai_causes' => "- Port SMTP (port 25 atau 587) diblokir oleh ISP atau antivirus komputer\n- Pengaturan server SMTP keluar salah konfigurasinya (misal butuh otentikasi)\n- Ukuran lampiran e-mail yang hendak dikirim melebihi batas.",
                    'ai_recommendations' => "1. Pastikan opsi 'My outgoing server (SMTP) requires authentication' dicentang.\n2. Ubah port SMTP keluar ke port alternatif (misal port 587 dengan TLS).\n3. Nonaktifkan sementara perlindungan scan email keluar pada antivirus.",
                    'ai_confidence' => '90%',
                    'resolution_summary' => 'Masalah: Outlook gagal mengirim email.\nPenyebab: Port SMTP 25 terblokir oleh ISP baru.\nSolusi: Teknisi mengubah port SMTP menjadi 587 dengan enkripsi STARTTLS.'
                ]
            ],
            'Lainnya' => [
                [
                    'subject' => 'Permintaan instalasi software desain grafis (Photoshop)',
                    'description' => 'Saya memerlukan aplikasi Adobe Photoshop di komputer saya untuk kebutuhan membuat materi promosi kegiatan divisi humas.',
                    'ai_summary' => 'Permintaan instalasi perangkat lunak Adobe Photoshop untuk keperluan kerja humas.',
                    'ai_causes' => "- Kebutuhan pekerjaan baru dari divisi Humas\n- Belum terinstalnya perangkat lunak grafis di PC pemohon.",
                    'ai_recommendations' => "1. Lakukan instalasi perangkat lunak dengan lisensi resmi kantor.\n2. Jika lisensi penuh kosong, tawarkan software open-source alternatif seperti GIMP.",
                    'ai_confidence' => '94%',
                    'resolution_summary' => 'Masalah: Permintaan instalasi Photoshop.\nPenyebab: Pengguna membutuhkan aplikasi desain untuk pekerjaan promosi.\nSolusi: Teknisi menginstalkan Adobe Creative Cloud dengan lisensi korporasi resmi kantor.'
                ],
                [
                    'subject' => 'Keluhan kebisingan AC di Ruang server',
                    'description' => 'AC di dalam ruang server berbunyi sangat keras dan mengeluarkan getaran yang mengganggu. Takutnya ini mempengaruhi suhu server.',
                    'ai_summary' => 'Kebisingan tidak wajar pada pendingin udara (AC) ruang server.',
                    'ai_causes' => "- Bearing kipas indoor AC aus atau kendor baut pengikatnya\n- Adanya komponen kompresor/outdoor AC yang bermasalah merambat ke unit indoor\n- AC sudah lama tidak diservis berkala.",
                    'ai_recommendations' => "1. Panggil teknisi spesialis pendingin udara gedung untuk servis berkala.\n2. Monitor suhu ruang server melalui sensor IoT agar tetap di bawah 20 derajat Celcius.",
                    'ai_confidence' => '83%',
                    'resolution_summary' => 'Masalah: AC ruang server bising.\nPenyebab: Kerusakan pada bearing motor blower indoor.\nSolusi: Teknisi melakukan servis besar AC, mengganti bearing blower, dan membersihkan kisi pendingin.'
                ],
                [
                    'subject' => 'Lampu LED ruang staff IT redup dan berkedip',
                    'description' => 'Dua lampu tabung LED di atas meja kerja kami sudah redup dan berkedip-kedip sehingga membuat mata lelah saat bekerja.',
                    'ai_summary' => 'Kerusakan fisik lampu LED penerangan di ruang staf IT.',
                    'ai_causes' => "- Masa pakai lampu LED sudah habis atau komponen driver internal rusak\n- Sakelar lampu kotor atau sambungan kabel kendur.",
                    'ai_recommendations' => "1. Lakukan penggantian fisik lampu LED dengan lampu baru.\n2. Periksa kelistrikan fitting lampu dengan testpen.",
                    'ai_confidence' => '92%',
                    'resolution_summary' => 'Masalah: Lampu LED berkedip.\nPenyebab: Masa pakai driver ballast LED habis.\nSolusi: Mengganti bohlam tabung LED yang baru di fitting lampu ruang IT.'
                ]
            ]
        ];

        // Seed 100 tickets
        $totalTicketsToSeed = 100;
        $categories = array_keys($templates);
        $priorities = ['low', 'medium', 'high'];
        $statuses = ['open', 'progress', 'resolved', 'closed'];

        // Dates distribution: over the last 90 days
        $now = Carbon::now();

        for ($i = 1; $i <= $totalTicketsToSeed; $i++) {
            $category = $categories[array_rand($categories)];
            $templateList = $templates[$category];
            $template = $templateList[array_rand($templateList)];

            // Randomize dates to look natural in dashboards
            // 80% old tickets, 20% recent tickets (last 7 days)
            if (rand(1, 10) <= 8) {
                $daysAgo = rand(8, 90);
            } else {
                $daysAgo = rand(0, 7);
            }
            $createdAt = $now->copy()->subDays($daysAgo)->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            // Random user
            $user = $users->random();

            // Status distribution: 
            // 45% closed, 30% resolved, 15% progress, 10% open
            $randVal = rand(1, 100);
            if ($randVal <= 45) {
                $status = 'closed';
            } elseif ($randVal <= 75) {
                $status = 'resolved';
            } elseif ($randVal <= 90) {
                $status = 'progress';
            } else {
                $status = 'open';
            }

            // Support assignment
            $assignedTo = null;
            if ($status !== 'open') {
                $assignedTo = $supports->random()->id;
            }

            // Updated at is created_at + some time (for non-open tickets)
            $updatedAt = $createdAt->copy();
            if ($status !== 'open') {
                $updatedAt = $createdAt->copy()->addDays(rand(0, 3))->addHours(rand(1, 12));
                if ($updatedAt->gt($now)) {
                    $updatedAt = $now->copy();
                }
            }

            // Prioritas random
            $priority = $priorities[array_rand($priorities)];

            // Build ticket data
            $ticketData = [
                'user_id' => $user->id,
                'subject' => $template['subject'] . ' (Uji #' . $i . ')',
                'description' => $template['description'] . ' Silakan dibantu untuk perbaikan segera.',
                'category' => $category,
                'priority' => $priority,
                'status' => $status,
                'assigned_to' => $assignedTo,
                'ai_summary' => $template['ai_summary'],
                'ai_causes' => $template['ai_causes'],
                'ai_recommendations' => $template['ai_recommendations'],
                'ai_confidence' => $template['ai_confidence'],
                'attachment' => null,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];

            // If resolved or closed, include resolution summary
            if ($status === 'resolved' || $status === 'closed') {
                $ticketData['resolution_summary'] = $template['resolution_summary'];
            }

            Ticket::create($ticketData);
        }
    }
}
