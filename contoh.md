BAB IV 
HASIL DAN PEMBAHASAN 
Bagian ini menampilkan hasil implementasi dan fungsionalitas dalam 
rekayasa perangkat lunak dengan menerapkan sistem penyewaan bus pariwisata 
berbasis web. Perangkat lunak dan perangkat keras termasuk dalam pembahasan 
implementasi dan pengujian sistem. 
Implementasi 
Implementasi merupakan tahap krusial setelah perancangan dan analisis 
program selesai. Tahap ini berfokus pada pembangunan aplikasi yang 
merepresentasikan desain yang telah dibuat secara nyata. Tujuan utama 
implementasi adalah membangun aplikasi yang mudah dan nyaman digunakan oleh 
pengguna. Oleh karena itu, aplikasi perlu melalui proses pengujian dan 
penyempurnaan yang menyeluruh untuk meminimalisir kesalahan dan memastikan 
kelancaran sistem. Implementasi yang cermat dan terencana akan menghasilkan 
aplikasi yang siap diluncurkan dan memberikan manfaat bagi para user. 
Implementasi Perangkat Lunak 
Implementasi Perangkat Lunak Beberapa perangkat lunak yang perlu 
disiapkan selama pembangunan sistem ini adalah sebagai berikut: 
1. Laragon, digunakan sebagai web server lokal untuk menjalankan Apache dan 
MySQL. Berfungsi menjalankan proyek berbasis PHP secara lokal. 
2. PHP Digunakan sebagai bahasa pemrograman server untuk membangun 
logika aplikasi dan pengolahan data. 
3. Google Chrome Digunakan untuk mengakses dan menguji tampilan 
antarmuka website selama proses pengembangan dan pengujian sistem. 
4. Laravel Framework PHP yang digunakan dalam pengembangan sistem untuk 
mengatur struktur kode berbasis MVC, serta mempermudah routing, 
validasi, dan pengolahan database. 
55 
56 
5. Composer Digunakan untuk mengelola dependensi PHP yang dibutuhkan 
selama pengembangan sistem. 
6. Midtrans (Snap.js) Digunakan sebagai payment gateway untuk menangani 
proses pembayaran, termasuk pembuatan token transaksi dan callback ke 
sistem. 
Implementasi Database 
Dalam membuat sistem berbasis web dibutuhkan database dengan nama 
database bus, yang terdiri dari beberapa tabel yang telah dirancangkan sebelumnya 
pada tahap desain. Tabel-tabel tersebut antara lain: 
Gambar 4.1 Tabel Bus 
Sesuai dari yang rancang atau digambarkan sebelumnya, pada Gambar 4.1 
menghasilkan struktur tabel bus yang sudah diletakkan pada MySql. Tabel ini 
digunakan untuk menampung data bus. 
Gambar 4.2 Tabel Bussewa 
Pada Gambar 4.2 menampilkan struktur tabel bussewa yang sudah 
dimplementasikan pada MySql. Tabel ini digunakan untuk menampung antara data 
penyewaan dan data bus, kegunaannya adalah menampung data penyewaan yang 
menyewa bus lebih dari satu untuk kebutuhan jalannya sistem agar efisien. 
Gambar 4.3 Tabel Gallery 
57 
Pada Gambar 4.3 menampilkan struktur tabel gallery yang telah berada pada 
halaman PhpMyAdmin. Tabel ini digunakan untuk menampung alamat gambar
gambar bus pada detail bus. 
Gambar 4.4 Tabel Pembayaran 
Sesuai dari yang direncanakan sebelumnya, pada Gambar 4.4 menghasilkan 
struktur tabel pembayaran yang sudah diimplementasikan pada MySql. Tabel ini 
digunakan untuk menampung data pembayaran dari pengguna. Tabel ini 
dikonfigurasikan juga dengan midtrans agar tetap sinkron. 
Gambar 4.5 Tabel Penjemputan 
Pada Gambar 4.5 menampilkan struktur tabel penjemputan yang sudah 
diletakkan pada MySql. Tabel ini digunakan untuk menampung data penjemputan 
dimana terdapat harga_penjemputan berdasarkan wilayah kecamatan pada 
kabupaten tertentu agar memudahkan perhitungan biaya sewa. 
Gambar 4.6 Tabel Penyewaan 
58 
Tabel penyewan pada Gambar 4.6 menghasilkan struktur tabel utama pada 
sistem ini, terdapat beberapa pemanggilan dari tabel lain dengan terdapat gambar 
kunci berwarna abu dimana itu mendefinisikan sebagai foreign key. Data inputan 
user yang menyewa akan tersimpan di tabel penyewaan ini. 
Gambar 4.7 Tabel Tujuan 
Tabel tujuan pada gambar 4.7 merupakan tabel yang digunakan untuk 
menyimpan data tujuan, baik paket wisata maupun tujuan tujuan umum, selain 
sebagai informasi, tabel ini juga menampung harga_tujuan dimana untuk 
memudahkan dalam menentukan biaya sewa dan lama_hari untuk memperkirakan 
lama sewanya. 
Gambar 4.8 Tabel Users 
Tabel pada gambar 4.8 bernama users merupakan tabel yang digunakan untuk 
menampung data pengakses sistem, dimana terdapat email dan password sebagai 
kunci untuk login dan role sebagai pembeda antara pengakses user/pelanggan atau 
admin. 
Implementasi Antarmuka  
Salah satu langkah dalam memenuhi kebutuhan pengguna untuk berinteraksi 
dengan sistem yang dibuat adalah implementasi antar muka. Antarmuka yang baik 
59 
akan membantu pengguna memahami proses yang sedang dilakukan sistem, 
sehingga sistem dapat bekerja lebih baik.