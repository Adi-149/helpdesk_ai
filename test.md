# LAPORAN PENGUJIAN BLACK BOX SYSTEM
## SISTEM HELPDESK CHATBOT AI

Pengujian *Black Box* ini dilakukan untuk memastikan fungsi utama sistem berjalan dengan baik dari sudut pandang pengguna akhir.

---

### A. Kasus Uji Pengujian (Test Cases)

| ID Test | Skenario Pengujian | Hasil yang Diharapkan (Expected Result) | Hasil Aktual | Kesimpulan |
| :--- | :--- | :--- | :--- | :---: |
| **TC-01** | Login dengan email dan password yang valid | Sistem berhasil melakukan autentikasi dan mengarahkan pengguna ke dashboard sesuai role (user/support/admin). | Sesuai dengan yang diharapkan | **Valid** |
| **TC-02** | Login dengan kredensial salah / tidak terdaftar | Sistem menolak akses dan menampilkan pesan error validasi kredensial. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-03** | User mengajukan tiket baru secara manual | Sistem menyimpan tiket ke database dengan status 'open' dan prioritas default 'low'. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-04** | User berinteraksi dengan Chatbot AI seputar IT | Chatbot memberikan respons solusi troubleshooting IT yang relevan. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-05** | User membuat tiket otomatis dari draf chatbot AI | Sistem menganalisis percakapan chatbot dan otomatis mengisi form tiket. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-06** | User mengirim pesan diskusi di obrolan tiket | Pesan terkirim dan tampil di halaman detail tiket untuk berdiskusi dengan teknisi. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-07** | Teknisi mengambil tiket masuk (Self-Assign) | Kolom assigned_to terisi ID teknisi dan status tiket otomatis berubah menjadi 'progress'. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-08** | Teknisi melihat rekomendasi solusi AI di tiket | Panel detail tiket menampilkan ringkasan, penyebab, dan saran solusi dari AI. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-09** | Teknisi mengubah status tiket menjadi 'Resolved' | Sistem menyimpan perubahan status dan AI membuat ringkasan penyelesaian. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-10** | Admin mengubah role pengguna lain | Hak akses role pengguna diperbarui dan tersimpan di database. | Sesuai dengan yang diharapkan | **Valid** |
| **TC-11** | Admin menghapus akun pengguna | Akun berhasil dihapus, tiket terkait tetap aman di database dengan user_id null. | Sesuai dengan yang diharapkan | **Valid** |

---

### B. Rekapitulasi Hasil Pengujian

*   **Total Skenario Pengujian**: 11
*   **Hasil Berhasil (Valid)**: 11
*   **Hasil Gagal (Tidak Valid)**: 0
*   **Persentase Keberhasilan**: 100%
