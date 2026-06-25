3.6.1 Use Case Diagram
 
Gambar 3.2 Use Case Diagram

Use Case adalah desain untuk menggambarkan fungsionalitas dari sistem dengan mengilustrasikan interaksi aktor dengan kegiatan sistem didalamnya. Pada Gambar 3.2 menampilkan rancangan Use Case yang didalamnya terdapat tiga pemeran atau aktor yakni admin, support (teknisi), dan user dimana ketiganya memiliki beberapa perbedaan kegiatan karena batasan-batasan akses guna keamanan dan efektivitas dalam pengelolaan IT Helpdesk. Aktor user dapat melakukan registrasi, login, membuat tiket pengaduan, melihat status tiket, berdiskusi di dalam obrolan detail tiket, serta menggunakan chatbot AI untuk mendapatkan bantuan teknis secara otomatis. Aktor support (teknisi) dapat login, melihat seluruh tiket yang masuk, meng-assign tiket kepada diri sendiri, mengubah status dan prioritas tiket, berdiskusi di dalam obrolan detail tiket, serta mencatat riwayat penanganan tiket. Aktor admin memiliki hak akses tertinggi yang dapat mengelola seluruh data pengguna termasuk mengubah role dan menghapus pengguna dari sistem, serta ikut berdiskusi di dalam obrolan tiket.
3.6.2 Activity Diagram 
Activity diagram menggambarkan alur interaksi dalam sistem dengan aktor. Tergambar kondisi yang terjadi didalam sistem pada setiap melakukan kegiatan. 
3.6.2.1 Activity Diagram Login
 
Gambar 3.3 Activity Diagram Login
Gambar 3.3 menjelaskan kegiatan user ketika melakukan proses login. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman login, memasukkan email dan password hingga sistem memverifikasi data yang diinputkan. Jika data yang dimasukkan sesuai dengan yang terdapat dalam database, sistem akan mengecek role pengguna untuk mengarahkan ke dashboard yang sesuai yaitu dashboard admin, dashboard support, atau dashboard user. Namun, jika data yang dimasukkan tidak valid, sistem akan memberikan pesan kesalahan dan meminta user untuk mencoba login kembali.
3.6.2.2 Activity Diagram User
 
Gambar 3.4 Activity Diagram User
Gambar 3.4 menjelaskan alur kegiatan user setelah berhasil login ke dalam sistem IT Helpdesk. User diarahkan ke dashboard user yang menampilkan ringkasan tiket berdasarkan status dan prioritas. User dapat membuat tiket baru dengan mengisi subject, description, dan category (Hardware, Software, Jaringan, Akun, Lainnya), kemudian sistem menyimpan tiket dengan status default 'open' dan prioritas 'low'. Selain itu, user dapat melihat daftar tiket miliknya, melihat detail tiket beserta riwayat perubahannya, serta menggunakan fitur chatbot AI untuk berkonsultasi mengenai permasalahan teknis IT secara langsung melalui sistem.
3.6.2.3 Activity Diagram Teknisi
 
Gambar 3.5 Activity Diagram Teknisi
Pada Gambar 3.5 menampilkan alur kegiatan teknisi atau support setelah melakukan login dan mendapatkan akses ke dalam aplikasi. Teknisi diarahkan ke dashboard support yang menampilkan statistik seluruh tiket termasuk jumlah total, status tiket (open, progress, resolved, closed), prioritas (high, medium, low), serta jumlah tiket yang sudah di-assign maupun belum. Teknisi dapat melihat seluruh tiket yang masuk, meng-assign tiket kepada diri sendiri, mengubah status dan prioritas tiket, serta menambahkan catatan penanganan pada setiap perubahan status yang akan tersimpan sebagai riwayat tiket.
3.6.2.4 Activity Diagram Admin
 
Gambar 3.6 Activity Diagram Admin
Kegiatan kelola data dilakukan oleh admin mencakup pengelolaan seluruh pengguna dalam sistem melalui dashboard admin. Admin dapat melihat daftar pengguna berdasarkan role yaitu user, support, dan admin. Admin memiliki hak akses untuk mengubah role pengguna antara user, support, dan admin sesuai kebutuhan organisasi. Selain itu, admin dapat menghapus pengguna dari sistem dengan catatan bahwa tiket yang pernah dibuat oleh pengguna tersebut tetap tersimpan dalam database karena kolom user_id bersifat nullable. Seluruh kegiatan aktor dan reaksi sistem tertera di dalamnya, proses ini dirancang untuk memudahkan admin dalam mengelola data pengguna secara efisien dan akurat.
3.6.3 Sequence Diagram 
3.6.3.1 Sequence Diagram User
 
Gambar 3.7 Sequence Diagram User
Rancangan pada Gambar 3.7 ini menjelaskan alur kegiatan user yang dilakukan didalam sistem melalui gambaran Sequence Diagram. Kegiatan diawali dari user mengakses halaman login dan memasukkan email serta password, sistem melakukan autentikasi melalui database users dan mengarahkan ke dashboard user. Selanjutnya user dapat membuat tiket baru dengan mengisi form yang berisi subject, description, dan category, lalu sistem menyimpan data ke tabel tickets dan menampilkan konfirmasi. User juga dapat mengakses fitur chatbot AI dengan mengirimkan pesan, sistem akan membuat atau mengambil sesi percakapan aktif dari tabel chatbot_conversations, mengirim pesan ke API Gemini AI melalui OpenRouter, menerima respons, lalu menyimpan pesan dan balasan ke tabel chat_messages dan menampilkan hasilnya kepada user.
 
3.6.3.2 Sequence Diagram Teknisi
 
Gambar 3.8 Sequence Diagram Teknisi
Gambar 3.8 menampilkan kegiatan teknisi (support) dalam melakukan kegiatan di dalam sistem melalui rancangan Sequence Diagram. Kegiatan aktor teknisi diawali dengan melakukan login dan diarahkan ke dashboard support yang menampilkan statistik tiket. Teknisi mengakses halaman daftar seluruh tiket, memilih tiket untuk dilihat detailnya, kemudian dapat melakukan assign tiket kepada diri sendiri melalui form assign. Setelah itu, teknisi dapat mengubah status tiket (open, progress, resolved, closed), mengubah prioritas (low, medium, high), dan menambahkan catatan penanganan. Setiap perubahan status akan dicatat secara otomatis oleh sistem ke dalam tabel ticket_histories sebagai riwayat penanganan tiket yang dapat ditelusuri kembali.
3.6.3.3 Sequence Diagram Admin
 
Gambar 3.9 Sequence Diagram Admin
Gambar 3.9 menampilkan kegiatan admin dalam melakukan kegiatan pengelolaan pengguna di dalam sistem melalui rancangan Sequence Diagram. Kegiatan aktor admin diawali dengan melakukan login dan diarahkan ke dashboard admin. Admin mengakses halaman kelola pengguna yang menampilkan daftar semua user berdasarkan role (user, support, admin). Admin dapat memilih pengguna tertentu untuk mengubah role-nya melalui form update role, sistem kemudian memperbarui data di tabel users dan menampilkan pesan konfirmasi. Selain itu, admin juga dapat menghapus pengguna dari sistem, dimana sistem akan melakukan pengecekan terlebih dahulu agar admin tidak dapat menghapus akun miliknya sendiri, lalu menghapus data pengguna dari database dan menampilkan konfirmasi keberhasilan.
3.6.4 Class Diagram
 
Gambar 3.10 Class Diagram
Gambar 3.10 menampilkan rancangan Class Diagram yang menggambarkan struktur kelas dan relasi antar entitas dalam sistem IT Helpdesk. Terdapat lima kelas utama yaitu User, Ticket, TicketHistory, ChatbotConversation, dan ChatMessage. Kelas User memiliki atribut id, name, email, password, role dan berelasi one-to-many dengan kelas Ticket (seorang user dapat memiliki banyak tiket), one-to-many dengan ChatbotConversation (seorang user dapat memiliki banyak sesi percakapan), serta one-to-many dengan TicketHistory. Kelas Ticket memiliki atribut subject, description, category, priority, status dan berelasi many-to-one dengan User melalui user_id dan assigned_to, serta one-to-many dengan TicketHistory. Kelas TicketHistory menyimpan riwayat perubahan status tiket dengan atribut old_status, new_status, dan notes. Kelas ChatbotConversation berelasi one-to-many dengan ChatMessage yang menyimpan pesan percakapan antara user dan chatbot AI dengan atribut message, sender_type, dan response.

3.6.1 Use Case Diagram
 
Gambar 3.2 Use Case Diagram
Gambar 3.2 menjelaskan interaksi antara aktor dengan use case (fitur) yang tersedia di dalam Sistem Helpdesk Chatbot AI. Pada diagram ini terdapat 3 (tiga) aktor utama yang terlibat, yaitu User, Teknisi, dan Admin. Aktor User memiliki hak akses untuk melakukan login, membuat tiket (yang meliputi pengisian judul, kategori, deskripsi, dan lampiran foto), melihat riwayat tiket, berdiskusi di dalam chat detail tiket, serta melakukan chat dengan Chatbot AI. Aktor Teknisi memiliki akses untuk melakukan login, melihat daftar tiket, mengambil tiket, memperbarui status tiket, dan berdiskusi di dalam chat detail tiket. Sementara itu, aktor Admin memiliki hak akses penuh terhadap semua fungsi sistem, termasuk login, membuat tiket, melihat riwayat tiket, melakukan chat dengan Chatbot AI, melihat daftar tiket, mengambil tiket, memperbarui status tiket, berdiskusi di dalam chat detail tiket, serta memiliki hak akses eksklusif untuk melakukan pengelolaan data pengguna (kelola pengguna) dan melihat laporan.

3.6.2.2 Activity Diagram Buat Tiket
 
Gambar 3.4 Activity Diagram Buat Tiket
Gambar 3.4 menjelaskan kegiatan user ketika melakukan proses pembuatan tiket. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman buat tiket, mengisi judul masalah, deskripsi, dan memilih kategori masalah hingga sistem melakukan validasi data yang diinputkan. Jika data yang dimasukkan valid dan lengkap sesuai dengan aturan validasi sistem, sistem akan menyimpan tiket baru ke database dengan prioritas default low dan mengarahkan pengguna kembali ke halaman daftar tiket serta menampilkan pesan sukses. Namun, jika data yang dimasukkan tidak valid, sistem akan menampilkan pesan kesalahan dan mengembalikan pengguna ke halaman form buat tiket untuk mengisi ulang data yang diperlukan.

3.6.2.3 Activity Diagram Chatbot
 
Gambar 3.5 Activity Diagram Chatbot
Gambar 3.5 menjelaskan kegiatan user ketika melakukan proses interaksi dengan chatbot. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman chatbot, mengirimkan pesan chat hingga sistem memvalidasi dan memproses pesan tersebut. Jika input pesan valid, sistem akan menyimpan pesan user ke database dan melakukan pemanggilan ke API Gemini melalui layanan OpenRouter. Apabila pemanggilan API berhasil, sistem akan mengambil respon dari AI, sedangkan jika pemanggilan API gagal, sistem akan menggunakan modul fallback keyword matching untuk mencocokkan kata kunci teknologi tertentu. Hasil respon (baik dari AI maupun fallback) kemudian disimpan ke dalam database sebelum dikirim dan ditampilkan kembali pada antarmuka chat user. Namun, jika pesan yang dikirimkan tidak valid, sistem akan menampilkan pesan kesalahan validasi dan meminta user untuk mengirim kembali pesan yang sesuai.

3.6.2.4 Activity Diagram Manajemen Pengguna
 
Gambar 3.6 Activity Diagram Manajemen Pengguna
Gambar 3.6 menjelaskan kegiatan admin ketika melakukan proses manajemen data pengguna. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh admin, mulai dari mengakses dashboard admin hingga sistem menampilkan data pengguna berdasarkan masing-masing role. Admin kemudian dapat memilih aksi yang ingin dilakukan, yaitu menghapus pengguna atau mengubah role pengguna. Jika admin memilih untuk menghapus pengguna, sistem akan memproses penghapusan data pengguna tersebut di database. Sementara itu, jika admin memilih untuk mengubah role pengguna, admin akan memilih role baru yang diinginkan, dan sistem akan mengupdate data role tersebut di database.

3.6.2.5 Activity Diagram Penanganan Tiket
 
Gambar 3.7 Activity Diagram Penanganan Tiket
Gambar 3.7 menjelaskan kegiatan staff support ketika melakukan proses penanganan tiket kendala. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh staff support, mulai dari mengakses daftar tiket kendala hingga sistem menampilkan seluruh daftar tiket yang masuk. Staff support kemudian memilih tiket tertentu untuk melihat detailnya, yang kemudian direspons sistem dengan menampilkan detail tiket tersebut. Setelah itu, staff support dapat menugaskan tiket kepada diri mereka sendiri, di mana sistem akan memperbarui status tiket menjadi progress. Selanjutnya, staff support dapat menginput perubahan detail tiket seperti memperbarui status atau prioritas, yang kemudian direspons sistem dengan memperbarui data tiket tersebut serta menyimpan riwayat perubahan tiket (ticket history) ke dalam database sebelum proses selesai.

