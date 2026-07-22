BAB I
PENDAHULUAN

1.1 Latar Belakang
Perkembangan teknologi informasi mendorong berbagai organisasi dan perusahaan untuk meningkatkan kualitas layanan digital, khususnya dalam bidang pelayanan dan dukungan pengguna (user support). Salah satu layanan yang banyak digunakan adalah sistem helpdesk ticketing berbasis web yang berfungsi untuk mencatat, mengelola, dan memantau berbagai keluhan atau permasalahan pengguna secara terstruktur. Sistem helpdesk memungkinkan setiap laporan pengguna dicatat dalam bentuk tiket sehingga proses penanganan masalah dapat dilakukan secara lebih terorganisir dan efisien. Penggunaan sistem helpdesk juga membantu proses pencatatan masalah secara sistematis, menjaga keamanan dan keakuratan data, serta mengurangi terjadinya duplikasi data sehingga memudahkan pihak IT Support dalam melakukan pengelolaan dan pelaporan permasalahan secara terkomputerisasi (Wardhani et al., 2020).
Dalam perkembangannya, banyak sistem helpdesk mulai menerapkan chatbot sebagai media komunikasi otomatis antara pengguna dan sistem. Chatbot digunakan untuk membantu menjawab pertanyaan pengguna secara cepat tanpa harus menunggu respon dari admin atau tim IT support. Penerapan chatbot pada sistem helpdesk mampu meningkatkan efisiensi pelayanan karena pengguna dapat memperoleh respon secara real-time kapan saja dibutuhkan. Selain itu, chatbot juga membantu mengurangi beban kerja administrator dengan menangani pertanyaan umum secara otomatis sehingga proses pelayanan menjadi lebih cepat, efektif, dan terorganisir. Pengembangan chatbot juga terus mengalami kemajuan menuju sistem percakapan real-time yang lebih cerdas dan interaktif dalam mendukung kebutuhan pelayanan digital (Suta et al., 2020).
Sebagian besar chatbot yang digunakan pada sistem helpdesk masih menggunakan metode rule-based atau template response, yaitu sistem chatbot yang memberikan jawaban berdasarkan kata kunci tertentu dan pola jawaban yang telah ditentukan sebelumnya. Metode tersebut menyebabkan chatbot hanya mampu
 
menjawab pertanyaan yang sesuai dengan template yang tersedia. Akibatnya, chatbot seringkali tidak dapat memberikan jawaban yang relevan ketika pengguna memberikan pertanyaan di luar pola yang telah ditentukan. Kondisi ini menyebabkan kualitas interaksi antara pengguna dan sistem menjadi kurang optimal serta menurunkan efektivitas layanan helpdesk berbasis chatbot (Bhuthada et al., 2023).
Keterbatasan chatbot berbasis rule-based tersebut menunjukkan bahwa sistem helpdesk modern memerlukan teknologi yang mampu memahami konteks percakapan pengguna secara lebih baik. Meskipun penerapan chatbot telah banyak digunakan dalam layanan digital, sebagian besar implementasi chatbot pada sistem helpdesk masih berfokus pada respon otomatis sederhana dan belum mampu memberikan interaksi yang fleksibel terhadap berbagai jenis pertanyaan pengguna. Beberapa penelitian sebelumnya juga masih menggunakan pendekatan berbasis aturan yang menyebabkan chatbot hanya dapat memberikan jawaban sesuai pola yang telah ditentukan sebelumnya (Bhuthada et al., 2023). Akibatnya, kualitas komunikasi antara pengguna dan sistem menjadi kurang optimal ketika chatbot menghadapi pertanyaan yang lebih kompleks atau berada di luar template yang tersedia. Oleh karena itu, diperlukan pengembangan chatbot berbasis AI yang mampu memberikan respon lebih natural, kontekstual, dan interaktif untuk meningkatkan efektivitas layanan helpdesk berbasis web (Jadhav et al., 2022).
Selain itu, penerapan teknologi AI pada sistem helpdesk juga masih menghadapi beberapa kendala, khususnya dalam proses pengembangan dan implementasi model AI secara mandiri. Pengembangan Large Language Model (LLM) membutuhkan sumber daya yang besar, seperti dataset dalam jumlah banyak, infrastruktur komputasi tinggi, serta proses pelatihan model yang kompleks (Dam et al., 2024). Kondisi tersebut menyebabkan tidak semua organisasi atau pengembang mampu membangun sistem chatbot AI secara mandiri. Seiring perkembangan teknologi, layanan API AI modern seperti OpenRouter mulai banyak digunakan karena mampu menyediakan fitur AI yang lebih mudah diintegrasikan ke dalam aplikasi berbasis web tanpa memerlukan proses pembangunan model dari awal. Namun, implementasi API AI pada sistem helpdesk ticketing berbasis web masih belum banyak diterapkan dalam penelitian pengembangan sistem sehingga diperlukan penelitian lebih lanjut untuk mengetahui efektivitas integrasi AI dalam meningkatkan kualitas pelayanan helpdesk digital (Nze, 2024).
Perkembangan teknologi Artificial Intelligence (AI), khususnya pada bidang Natural Language Processing (NLP), memberikan peluang untuk meningkatkan kemampuan chatbot menjadi lebih cerdas dan interaktif. Teknologi AI memungkinkan chatbot memahami konteks percakapan pengguna serta menghasilkan respon yang lebih natural dan relevan (Jadhav et al., 2022). Saat ini, berbagai layanan AI modern seperti OpenRouter menyediakan API yang dapat digunakan untuk mengintegrasikan kemampuan AI ke dalam aplikasi berbasis web secara lebih mudah dan efisien. Penggunaan API AI memungkinkan pengembang memanfaatkan teknologi Large Language Model (LLM) tanpa harus membangun model AI dari awal yang membutuhkan sumber daya besar dan proses pengembangan yang kompleks (Dam et al., 2024).
Penerapan AI melalui layanan API juga memberikan keuntungan dari sisi pengembangan sistem karena memungkinkan integrasi teknologi kecerdasan buatan tanpa memerlukan infrastruktur komputasi yang besar. Melalui API, aplikasi dapat memanfaatkan kemampuan pemrosesan bahasa alami yang telah disediakan oleh penyedia layanan AI untuk memahami maksud pengguna, menghasilkan jawaban yang relevan, serta mendukung interaksi yang lebih natural (Kim, 2023). Pendekatan ini tidak hanya mempercepat proses pengembangan sistem, tetapi juga membantu meningkatkan akurasi respon chatbot dibandingkan dengan metode berbasis aturan yang terbatas pada pola tertentu. Oleh karena itu, pemanfaatan API AI menjadi salah satu alternatif yang efektif untuk meningkatkan kualitas layanan digital yang membutuhkan komunikasi otomatis dengan pengguna (Gupta & Gupta, 2022).
Integrasi API AI pada sistem helpdesk ticketing berbasis web dapat menjadi solusi untuk meningkatkan kualitas layanan chatbot. Dengan memanfaatkan API AI, chatbot tidak hanya memberikan jawaban berdasarkan template, tetapi juga mampu merespon pertanyaan pengguna dengan topik pembahasan yang lebih luas, khususnya dalam bidang teknologi informasi. Selain itu, chatbot berbasis AI dapat memberikan respon yang lebih fleksibel, interaktif, dan sesuai dengan konteks pertanyaan pengguna sehingga pengalaman pengguna dalam menggunakan layanan helpdesk menjadi lebih baik. Kemampuan ini memungkinkan chatbot untuk memberikan informasi yang lebih relevan dan membantu pengguna memperoleh solusi awal secara cepat tanpa harus menunggu respon dari admin atau tim IT support. Dengan demikian, proses pelayanan dapat berlangsung lebih efektif dan responsif dalam memenuhi kebutuhan pengguna (Nze, 2024).
Berdasarkan permasalahan tersebut, diperlukan pengembangan sistem helpdesk ticketing berbasis web yang terintegrasi dengan API chatbot berbasis Artificial Intelligence. Integrasi AI dalam sistem ini tidak hanya berfungsi sebagai media komunikasi otomatis (chatbot) bagi pengguna, melainkan juga dirancang untuk mengotomatisasi alur penanganan tiket secara cerdas. Penelitian ini memiliki beberapa kelebihan utama dibandingkan sistem helpdesk konvensional, antara lain:
1. **Otomatisasi Alur Triage & Support**: Chatbot tidak hanya menjawab pertanyaan, melainkan mampu menganalisis jalannya obrolan untuk menyusun draf tiket bantuan secara otomatis (judul, deskripsi, kategori, prioritas) serta memberikan analisis prediktif AI berupa perkiraan penyebab, rekomendasi penanganan, dan tingkat keyakinan (confidence score).
2. **Rekomendasi Kasus Serupa (Knowledge Base AI)**: Membantu teknisi mempercepat penanganan masalah dengan merekomendasikan maksimal tiga riwayat tiket lama yang sudah diselesaikan (`resolved`/`closed`) yang memiliki kemiripan masalah secara semantik dibantu oleh model bahasa besar (LLM).
3. **Mekanisme Keandalan (High Reliability) & Fallback**: Mengantisipasi kegagalan koneksi atau pembatasan kuota API OpenRouter dengan mengimplementasikan pencarian bertingkat; dimulai dari pencarian dokumen pada basis pengetahuan lokal (Knowledge Base) secara offline, hingga beralih ke pencocokan pola kata kunci (Regular Expression/Regex).
4. **Ringkasan Resolusi Otomatis**: Membantu penyusunan laporan akhir (resolution summary) secara otomatis setelah tiket diselesaikan oleh teknisi untuk memperkaya dokumentasi Knowledge Base di masa mendatang.

Pada penelitian ini, integrasi AI dilakukan menggunakan layanan API AI melalui OpenRouter karena lebih mudah diimplementasikan serta tidak memerlukan proses pembangunan Large Language Model (LLM) secara mandiri. Dengan adanya integrasi tersebut, diharapkan sistem helpdesk dapat berjalan secara lebih efektif, mengurangi beban kerja admin dan teknisi, serta meningkatkan kepuasan pengguna. Oleh karena itu, penelitian ini dilakukan dengan judul “Integrasi API Chatbot Berbasis Artificial Intelligence pada Sistem Helpdesk Ticketing Berbasis Web” yang bertujuan untuk merancang dan membangun sistem helpdesk berbasis web yang terintegrasi dengan layanan API AI secara menyeluruh guna mengoptimalkan proses pelayanan bantuan dan penanganan kendala IT.


1.2 Rumusan Masalah
Berdasarkan latar belakang yang telah diuraikan, maka rumusan masalah dalam penelitian ini adalah sebagai berikut:
1.	Bagaimana mengintegrasikan API chatbot berbasis Artificial Intelligence pada sistem helpdesk ticketing berbasis web?
2.	Bagaimana implementasi chatbot berbasis AI dalam memberikan respon otomatis yang lebih interaktif dan kontekstual terhadap pertanyaan pengguna?
3.	Bagaimana mengimplementasikan asisten AI untuk membantu teknisi dalam menganalisis tiket, mencari riwayat tiket serupa, dan merangkum hasil penyelesaian tiket secara otomatis?

1.3 Batasan Masalah
Agar penelitian lebih terarah dan tidak menyimpang dari tujuan yang telah ditentukan, maka penelitian ini memiliki beberapa batasan masalah sebagai berikut:
1.	Sistem yang dibangun berupa sistem helpdesk ticketing berbasis web.
2.	Sistem difokuskan pada pengelolaan tiket keluhan dan pertanyaan pengguna terkait layanan teknologi informasi.
3.	Sistem chatbot menggunakan layanan Artificial Intelligence yang diakses melalui OpenRouter API sebagai media komunikasi dengan model bahasa besar (Large Language Model/LLM).
4.	Chatbot digunakan untuk memberikan respon otomatis dalam bentuk teks terhadap pertanyaan pengguna serta menganalisis percakapan untuk merekomendasikan pembuatan draf tiket secara otomatis.
5.	Topik pembahasan chatbot difokuskan pada bidang teknologi dan penggunaan sistem helpdesk.
6.	Sistem tidak membangun atau melatih Large Language Model (LLM) secara mandiri, tetapi memanfaatkan layanan API AI yang telah tersedia.
7.	Pengguna sistem dibedakan menjadi 3 (tiga) peran utama, yaitu User (Pengguna/Pelapor), Support (Teknisi), dan Admin.
8.	Pengujian sistem dilakukan menggunakan metode Blackbox Testing untuk menguji fungsi-fungsi pada sistem.
9.	Sistem dikembangkan berbasis web dan tidak membahas implementasi aplikasi mobile secara khusus.
10.	Penelitian difokuskan pada integrasi API chatbot berbasis Artificial Intelligence, asisten rekomendasi teknisi, dan pengelolaan tiket helpdesk, bukan pada pengembangan model AI secara mendalam.

1.4 Tujuan Penelitian
Tujuan yang ingin dicapai dalam penelitian ini adalah sebagai berikut:
1.	Mengimplementasikan integrasi API chatbot berbasis Artificial Intelligence ke dalam sistem helpdesk ticketing berbasis web.
2.	Mengembangkan fitur chatbot yang mampu memberikan respon otomatis secara lebih interaktif, kontekstual, dan mampu menyusun draf tiket pengaduan secara otomatis berdasarkan riwayat percakapan.
3.	Mengembangkan asisten AI yang dapat membantu teknisi (support) dalam melakukan analisis penyebab kendala, memberikan rekomendasi solusi, mencari riwayat kasus serupa, serta merangkum penyelesaian tiket secara otomatis.

1.5 Manfaat Penelitian
Manfaat yang diharapkan dari penelitian ini adalah sebagai berikut:
1. Manfaat Teoritis
Penelitian ini diharapkan dapat memberikan kontribusi dalam pengembangan ilmu pengetahuan di bidang teknologi informasi, khususnya terkait integrasi API chatbot berbasis Artificial Intelligence pada sistem helpdesk ticketing berbasis web.
2. Manfaat Praktis
Bagi organisasi, penelitian ini diharapkan dapat membantu meningkatkan efektivitas layanan helpdesk dan mempercepat waktu penanganan kendala pengguna.
a.	Bagi pengguna, penelitian ini diharapkan dapat memberikan kemudahan dalam memperoleh solusi cepat melalui chatbot AI dan mempermudah pembuatan tiket kendala secara otomatis.
b.	Bagi teknisi (support), penelitian ini diharapkan dapat memberikan asisten analisis kendala yang cerdas berupa draf rekomendasi penanganan, riwayat kasus serupa, dan penyusunan draf ringkasan penyelesaian secara otomatis untuk menghemat waktu penulisan laporan.
c.	Bagi pengembang, penelitian ini dapat menjadi referensi dalam pengembangan sistem berbasis web yang terintegrasi dengan layanan API Artificial Intelligence secara komprehensif.
3. Manfaat Akademis
Penelitian ini diharapkan dapat menjadi referensi bagi penelitian selanjutnya yang berkaitan dengan sistem helpdesk ticketing, chatbot, Artificial Intelligence, dan integrasi API pada sistem informasi berbasis web.
 
BAB II
TINJAUAN PUSTAKA

2.1 Studi Literatur
Penelitian mengenai implementasi chatbot dalam sistem informasi menunjukkan bahwa teknologi ini berperan penting dalam meningkatkan efisiensi layanan dan kepuasan pengguna. (Wahid et al., 2024) mengembangkan chatbot berbasis Artificial Intelligence (AI) dan Natural Language Processing (NLP) pada sistem penerimaan mahasiswa baru yang terbukti mampu mempercepat waktu respon serta meningkatkan kepuasan pengguna hingga 85%. Selanjutnya, (Putra et al., 2022) mengimplementasikan chatbot berbasis NLP menggunakan platform Dialogflow pada aplikasi customer service, yang hasilnya mampu mengurangi frekuensi pertanyaan pengguna hingga 92,82% sehingga meningkatkan efektivitas kerja tim layanan pelanggan dan mengurangi beban kerja manual. Selain itu, (Febriansyah & Hertantyo, 2025) melalui tinjauan sistematis menemukan bahwa implementasi chatbot sebagai virtual assistant dapat meningkatkan efisiensi layanan dengan tingkat akurasi hingga 90% serta kepuasan pengguna sebesar 82,1%, meskipun masih diperlukan pengembangan lebih lanjut menggunakan teknik deep learning agar sistem menjadi lebih adaptif dan akurat.
Selain penerapan chatbot, penelitian mengenai sistem helpdesk ticketing juga banyak dilakukan untuk meningkatkan efisiensi pengelolaan dan penanganan keluhan pada sistem informasi. (Wildan, 2022) merancang sistem helpdesk ticketing berbasis web untuk menggantikan proses pencatatan manual menggunakan Microsoft Excel yang dinilai kurang efisien dan berisiko kehilangan data, dengan menggunakan metode Rapid Application Development (RAD) serta pemodelan DFD dan ERD. Penelitian lain oleh (Alfauzain et al., 2022) mengimplementasikan sistem helpdesk ticketing pada layanan rumah sakit untuk mengelola keluhan pasien secara terstruktur sehingga memudahkan proses dokumentasi, pemantauan, dan peningkatan kualitas layanan. Sementara itu, (Aris, 2020) mengembangkan aplikasi helpdesk ticketing untuk perusahaan jasa teknologi informasi guna mengatasi permasalahan pengelolaan keluhan yang sebelumnya 
tidak terorganisir, dengan menggunakan metode PIECES dan model prototype serta penerapan algoritma Forward Chaining, sehingga sistem mampu membantu proses pelacakan, verifikasi, dan evaluasi kinerja tim secara lebih efektif dan sistematis.
Penelitian terkait integrasi API dalam sistem informasi juga banyak dilakukan untuk meningkatkan efisiensi layanan dan interoperabilitas antar sistem. (Fitrahriansyah & Jaman, 2022) mengembangkan sistem berbasis web untuk pemesanan teknisi on-call yang dilengkapi fitur lokasi pengguna dan pelaporan layanan, sehingga membantu mempercepat proses penanganan dengan tingkat kepuasan pengguna yang baik. Penelitian lain oleh Sari (2024) mengimplementasikan penggunaan API dari Large Language Model (LLM) yaitu Gemini pada aplikasi berbasis web, yang menunjukkan bahwa integrasi API mampu mendukung fungsionalitas aplikasi secara optimal. Selain itu, (Tri Toto Wiharjianto et al., 2024) mengintegrasikan REST API dan platform Yellow.ai pada chatbot untuk mengelola perubahan data karyawan, yang terbukti mampu mengurangi jumlah trouble ticket hingga 54,3% serta mempercepat proses administrasi, sehingga meningkatkan efisiensi layanan secara signifikan.
Berdasarkan beberapa penelitian tersebut, dapat disimpulkan bahwa sistem helpdesk ticketing, teknologi chatbot berbasis Artificial Intelligence, serta integrasi API memiliki peran yang signifikan dalam meningkatkan efisiensi layanan dan kualitas pengelolaan sistem informasi. Sistem helpdesk ticketing mampu membantu proses pencatatan dan pengelolaan keluhan secara terstruktur, sementara chatbot dapat mengotomatisasi respon terhadap pertanyaan pengguna sehingga mengurangi beban kerja tim layanan. Di sisi lain, integrasi API memungkinkan berbagai sistem untuk saling terhubung dan bertukar data secara lebih cepat dan fleksibel. Namun, sebagian besar penelitian masih mengembangkan ketiga komponen tersebut secara terpisah dan belum mengoptimalkan integrasi di antara ketiganya dalam satu sistem yang terpadu. Oleh karena itu, penelitian ini mengusulkan pengembangan sistem helpdesk ticketing berbasis web yang terintegrasi dengan chatbot berbasis Artificial Intelligence melalui API, sehingga proses pelayanan pengguna dapat dilakukan secara lebih otomatis, responsif, dan efisien.
 
Tabel 2.1 Literatur Review 
No	Peneliti	Judul Penelitian	Metode / Teknologi	Hasil Penelitian	Gap Penelitian
1	Wahid (2024)	Implementasi Chatbot Berbasis Natural Language Processing Pada Web Lppmb Di Uniqhba	Artificial Intelligence, NLP	Meningkatkan kecepatan respon dan kepuasan pengguna hingga 85%	Hanya berfungsi sebagai media Q&A interaktif statis dan belum terintegrasi dengan sistem helpdesk ticketing untuk pencatatan keluhan
2	Putra (2022)	Implementation Of Chatbot Customer Service Features On Pt Dian Prima Jayaraya Using Dialogflow	NLP, Dialogflow	Mengurangi pertanyaan pengguna hingga 92,82% dan meningkatkan efisiensi layanan	Hanya mengotomatisasi percakapan FAQ customer service melalui Dialogflow dan belum terhubung ke sistem penanganan tiket kendala
3	Febriansyah (2025)	Implementasi Chatbot Sebagai Virtual Assistant : Systematic Literature Review	AI, PRISMA Review	Meningkatkan efisiensi layanan (akurasi 90%) dan kepuasan pengguna (82,1%)	Penelitian bersifat tinjauan literatur sistematis (SLR) tanpa adanya perancangan dan implementasi aplikasi helpdesk yang terintegrasi secara riil

4	Wildan (2022)	Perancangan Sistem Ticketing Helpdesk Pada Pt Arthatech  Selaras Berbasis Web
	RAD, DFD, ERD	Menggantikan pencatatan manual menjadi  sistem terkomputerisasi	Pengelolaan tiket helpdesk masih mengandalkan input manual  oleh staf tanpa dukungan chatbot AI untuk respon mandiri oleh staf tanpa dukungan chatbot AI untuk respon mandiri
5	Alfauzain (2022)	Sosialisasi Penerapan Sistem Helpdesk Ticketing  Berbasis Web Dalam Penanganan  	Sistem informasi	Meningkatkan pengelolaan dan monitoring  keluhan pasien	Fokus pada alur monitoring manual, tidak memiliki fitur otomatisasi AI  untuk analisis kendala, prioritas 
Tabel 2.1 Lanjutan
No	Peneliti	Judul Penelitian	Metode / Teknologi	Hasil Penelitian	Gap Penelitian
		Keluhan Layanan Di Rumah Sakit Ibu Dan Anak Mutiara Bunda Padang			tiket, maupun pembuatan solusi
6	Aris (2020)	Perancangan Aplikasi Helpdesk Ticketing Dengan Penerapan Algoritma Forward Chaining (Stusi Kasus: Pt Idemas Solusindo Sentosa)	PIECES, Prototype, UML, Forward Chaining	Mempermudah tracking, verifikasi, dan evaluasi tiket	Meskipun menggunakan Forward Chaining untuk analisis, penentuan diagnosa belum interaktif dan tidak terintegrasi dengan chatbot AI berbasis percakapan
7	Fitrahriansyah (2022)	Pemanfaatan Application Programming Interface (API) Pada Aplikasi  Layanan Jasa Perbaikan Kendaraan Bermotor	SDLC Prototype	Meningkatkan efisiensi layanan dan kepuasan pengguna	Pemanfaatan API hanya terbatas pada integrasi data/fitur layanan  konvensional tanpa adanya otomatisasi berbasis kecerdasan buatan (AI)
8	Sari (2024)	Implementasi Gemini API Untuk Generatif Teks Deskripsi Karya Otomatis Dalam Aplikasi Pameran Berbasis Web Dengan Metode Waterfall	LLM API (Gemini), Waterfall	API dapat diintegrasikan dan berjalan sesuai fungsi	Integrasi Gemini API hanya difokuskan pada generator deskripsi karya pameran, bukan untuk memecahkan kendala teknis atau mendukung penanganan sistem helpdesk
9	Tri Toto (2024)	Implementasi Rest Api Dan Yellow.Ai Untuk Mengurangi 	REST API, Yellow.ai	Mengurangi trouble ticket hingga 54,3% dan 	Fokus integrasi chatbot (Yellow.ai) hanya untuk mengurangi trouble ticket 
Tabel 2.1 Lanjutan
No	Peneliti	Judul Penelitian	Metode / Teknologi	Hasil Penelitian	Gap Penelitian
		Jumlah Trouble Ticket Data Rekening Yang Berulang Dengan Chatbot Tbig Olive		mempercepat proses	berulang tipe tertentu, tidak menyediakan asisten rekomendasi solusi bagi teknisi

Berdasarkan Tabel 2.1, penelitian terdahulu menunjukkan bahwa chatbot berbasis AI telah banyak diterapkan untuk meningkatkan kualitas layanan dan efisiensi komunikasi dengan pengguna. Selain itu, sistem helpdesk ticketing juga telah dikembangkan untuk mengelola dan memantau proses penanganan keluhan secara terstruktur. Namun, sebagian besar penelitian masih berfokus pada fungsi chatbot sebagai media tanya jawab atau pada sistem ticketing yang berjalan secara terpisah. Belum banyak penelitian yang mengintegrasikan chatbot AI dengan sistem helpdesk ticketing secara menyeluruh, mulai dari analisis kendala, pembuatan tiket otomatis, rekomendasi penanganan bagi teknisi, hingga pembentukan basis pengetahuan dari tiket yang telah diselesaikan. Oleh karena itu, penelitian ini mengusulkan integrasi API chatbot berbasis Artificial Intelligence pada sistem helpdesk ticketing berbasis web untuk mendukung proses layanan yang lebih efektif dan cerdas.

2.2 Tinjauan Teori
Tinjauan teori merupakan landasan konseptual yang digunakan sebagai dasar dalam penelitian ini. Teori-teori yang dibahas meliputi konsep sistem helpdesk ticketing, chatbot, Artificial Intelligence, API, serta website yang berkaitan dengan pengembangan sistem. Tinjauan teori ini bertujuan untuk memberikan pemahaman mengenai konsep-konsep yang digunakan dalam penelitian sekaligus menjadi dasar dalam perancangan dan implementasi sistem yang dikembangkan.
 
2.2.1 Sistem Helpdesk Ticketing
Sistem helpdesk ticketing merupakan sistem layanan yang digunakan oleh organisasi, khususnya perusahaan di bidang teknologi informasi, untuk menangani permintaan layanan, keluhan, serta permasalahan teknis yang dilaporkan oleh pengguna. Sistem ini berfungsi sebagai penghubung antara pengguna dan penyedia layanan, sehingga setiap permasalahan dapat ditangani secara terstruktur dan terdokumentasi dengan baik. Dalam praktiknya, sistem ini membantu perusahaan dalam mengelola volume laporan yang terus meningkat, sehingga dapat mengurangi penumpukan masalah yang belum terselesaikan serta menekan biaya pengembangan dan pemeliharaan sistem (Kumar et al., 2023).
Sistem helpdesk ticketing dikembangkan untuk meningkatkan efektivitas proses pelayanan dan dukungan teknis dalam suatu organisasi. Sebelum adanya sistem ticketing, proses pelaporan masalah umumnya dilakukan melalui media konvensional seperti telepon, pesan singkat, maupun email, yang sering kali menyebabkan kesulitan dalam pencatatan dan pelacakan laporan. Kondisi tersebut dapat mengakibatkan terjadinya kehilangan data laporan, keterlambatan penanganan masalah, hingga kesalahan komunikasi antara pengguna dan tim teknis. Dengan adanya sistem helpdesk ticketing, seluruh laporan pengguna dapat disimpan dalam satu sistem terpusat sehingga proses pengelolaan dan pemantauan laporan menjadi lebih mudah dilakukan.
Sistem helpdesk ticketing umumnya berbasis web dan menyediakan platform terpusat yang memungkinkan pengguna untuk mengirimkan laporan dalam bentuk tiket serta memantau proses penyelesaiannya. Setiap tiket yang masuk akan dicatat, diproses, dan diperbarui statusnya secara otomatis, sehingga memudahkan komunikasi antara pengguna dan tim teknis. Dibandingkan dengan metode konvensional seperti penggunaan email, sistem ini mampu mengurangi kesalahan komunikasi dan meningkatkan efisiensi dalam penanganan masalah. Selain itu, sistem ini dapat diakses secara fleksibel baik oleh pengguna internal maupun eksternal organisasi (Gadkari et al., 2025).
Dalam penerapannya, setiap tiket yang dibuat biasanya memiliki informasi penting seperti nomor tiket, kategori masalah, tingkat prioritas (low, medium, high), waktu pelaporan, serta status penyelesaian. Informasi tersebut membantu tim helpdesk dalam menentukan prioritas penanganan masalah sesuai tingkat urgensinya. Pada penelitian ini, kategori tiket diklasifikasikan secara spesifik ke dalam tujuh klaster utama, yaitu Hardware POS, Printer Thermal, Barcode Scanner, Jaringan & Internet, CCTV, Software POS, serta Server & Database, guna memastikan setiap laporan ditangani oleh teknisi yang tepat. Pada sistem penanganan helpdesk modern, alur kerja ini dibagi menjadi beberapa tingkatan (support tier): pertama, First-Level Support (Tier 1) yang menangani keluhan awal secara otomatis menggunakan chatbot berbasis kecerdasan buatan (AI); dan kedua, Second-Level Support (Tier 2) yang menangani kendala teknis kompleks oleh staf teknisi (support) dengan dukungan analisis data AI.
Lebih lanjut, sistem helpdesk ticketing juga berperan sebagai media komunikasi terpusat dalam menangani insiden yang terjadi di dalam organisasi. Setiap laporan yang masuk akan diteruskan kepada pihak yang berwenang, seperti tim IT helpdesk, manajer IT, hingga teknisi yang bertanggung jawab dalam penyelesaian masalah. Dengan adanya sistem ini, proses pelacakan, pengelolaan, serta penyelesaian tiket menjadi lebih mudah dan terorganisir. Transparansi proses pelayanan kepada pengguna juga dijaga melalui pencatatan riwayat perubahan tiket secara terperinci (ticket history) yang mencatat perpindahan status mulai dari open, progress, resolved, hingga closed, sehingga seluruh aktivitas penanganan terdokumentasi dengan baik (Chanchad et al., 2023).
Keberadaan sistem helpdesk ticketing memberikan manfaat tambahan dalam menjaga transparansi proses pelayanan kepada pengguna. Pengguna dapat mengetahui perkembangan status laporan yang telah dikirimkan secara real-time, termasuk menerima notifikasi otomatis setiap kali terjadi perubahan status tiket atau pesan baru dari teknisi. Transparansi tersebut membantu meningkatkan kepercayaan pengguna terhadap layanan yang diberikan karena proses penanganan masalah dapat dipantau secara langsung. Selain itu, dokumentasi riwayat tiket yang tersimpan di dalam sistem juga dapat digunakan sebagai referensi basis pengetahuan apabila masalah serupa terjadi kembali di masa mendatang.
Seiring dengan perkembangan teknologi informasi, sistem helpdesk ticketing kini mulai dikombinasikan dengan teknologi lain seperti chatbot, kecerdasan buatan, dan sistem notifikasi otomatis untuk meningkatkan kualitas pelayanan. Integrasi tersebut memungkinkan pengguna memperoleh respon yang lebih cepat dan membantu tim teknis dalam menangani laporan secara lebih efisien. Oleh karena itu, sistem helpdesk ticketing menjadi salah satu solusi penting dalam mendukung proses pelayanan dan pengelolaan permasalahan pengguna di berbagai organisasi dan perusahaan modern.
2.2.2 Chatbot
Chatbot merupakan program komputer yang dirancang untuk mensimulasikan percakapan antara manusia dan mesin melalui teks maupun suara. Chatbot bekerja dengan memanfaatkan teknologi Artificial Intelligence (AI) untuk memahami konteks pertanyaan pengguna dan memberikan respon yang sesuai secara otomatis. Sistem ini dapat menghasilkan respon dinamis berdasarkan input yang diberikan pengguna serta mampu belajar dari berbagai interaksi sebelumnya melalui algoritma machine learning, sehingga kualitas respon yang dihasilkan dapat terus meningkat seiring waktu (Jadhav et al., 2022).
Pada dasar-dasar pengembangannya, chatbot dikembangkan untuk mempermudah proses komunikasi antara pengguna dan sistem komputer. Sebelum teknologi chatbot berkembang, proses pelayanan digital umumnya masih dilakukan secara manual oleh operator atau customer service sehingga pengguna harus menunggu respon dalam waktu tertentu. Dengan adanya chatbot, proses komunikasi dapat dilakukan secara otomatis dan real-time tanpa harus selalu melibatkan tenaga manusia. Hal ini menjadikan chatbot sebagai salah satu solusi teknologi yang banyak diterapkan dalam mendukung pelayanan digital modern.
Dalam implementasinya, chatbot dapat bekerja menggunakan berbagai pendekatan teknologi, mulai dari rule-based hingga AI-based chatbot. Chatbot berbasis rule-based bekerja menggunakan aturan dan pola tertentu yang telah ditentukan sebelumnya sehingga respon yang diberikan bergantung pada kata kunci atau pilihan menu yang dipilih pengguna. Sementara itu, chatbot berbasis AI memiliki kemampuan yang lebih kompleks karena mampu memahami bahasa alami pengguna melalui teknologi Natural Language Processing (NLP) dan machine learning. Dengan kemampuan tersebut, chatbot AI dapat memberikan respon yang lebih fleksibel dan kontekstual sesuai dengan kebutuhan pengguna.
Dalam perkembangannya, chatbot telah banyak digunakan pada berbagai platform seperti aplikasi pesan, situs web, maupun aplikasi mobile untuk berbagai keperluan, seperti layanan pelanggan, penyedia informasi, hingga asisten virtual. Chatbot dapat diklasifikasikan berdasarkan tujuan dan fungsinya, seperti customer service chatbot, informational chatbot, personal assistant, hingga chatbot di bidang kesehatan dan pendidikan. Untuk menjaga efisiensi penggunaan layanan API kecerdasan buatan, chatbot modern umumnya menerapkan manajemen sesi percakapan dengan pembatasan jumlah pesan per sesi, serta menyediakan opsi penghapusan riwayat obrolan agar pengguna dapat memulai percakapan baru dari awal. Namun, dalam pengembangannya, chatbot juga menghadapi beberapa tantangan, seperti pemahaman konteks percakapan, integrasi dengan sistem backend, personalisasi layanan, serta aspek keamanan dan penerimaan pengguna (Shah et al., 2023).
Seiring dengan kemajuan teknologi AI dan machine learning, penggunaan chatbot semakin meningkat dalam berbagai bidang kehidupan. Chatbot tidak hanya digunakan sebagai alat komunikasi, tetapi juga sebagai sarana untuk meningkatkan efisiensi operasional dan mengurangi ketergantungan terhadap tenaga manusia dalam menangani berbagai permintaan pengguna. Dengan kemampuannya dalam memberikan respon secara cepat dan akurat, chatbot menjadi salah satu teknologi penting dalam mendukung layanan digital modern, termasuk dalam sistem helpdesk, dimana chatbot dapat memberikan respon awal secara otomatis sebelum diteruskan ke proses penanganan lebih lanjut (Gupta & Gupta, 2022).
Dalam sistem helpdesk, chatbot berfungsi sebagai media interaksi awal antara pengguna dan sistem layanan. Ketika pengguna mengalami kendala atau ingin menyampaikan keluhan, chatbot dapat memberikan respon awal berupa informasi atau solusi sederhana. Jika masalah tidak dapat diselesaikan secara otomatis melalui percakapan, chatbot dapat menganalisis seluruh riwayat obrolan tersebut untuk menyusun draf tiket bantuan secara otomatis, meliputi judul, deskripsi, kategori, prioritas, ringkasan masalah, kemungkinan penyebab, hingga rekomendasi penanganan awal bagi teknisi. Selain itu, untuk memastikan ketersediaan layanan saat koneksi API AI terputus, chatbot dilengkapi dengan mekanisme fallback bertingkat yang mendahulukan pencarian jawaban pada basis pengetahuan lokal sebelum beralih ke pencocokan kata kunci berbasis ekspresi reguler (Regex). Integrasi chatbot dengan sistem helpdesk membantu meningkatkan kecepatan pelayanan, mempermudah komunikasi, serta meningkatkan pengalaman pengguna dalam memperoleh layanan digital yang responsif dan sesuai dengan kebutuhan pengguna.
2.2.3 Artificial Intelligence
Artificial Intelligence (AI) atau kecerdasan buatan merupakan cabang ilmu komputer yang berfokus pada pengembangan sistem yang mampu meniru kecerdasan manusia dalam melakukan berbagai tugas, seperti pengambilan keputusan, pemrosesan bahasa, dan pengenalan pola. AI mencakup berbagai subbidang, seperti machine learning, deep learning, computer vision, dan robotika. Machine learning memungkinkan sistem untuk belajar dari data dan meningkatkan kinerjanya secara bertahap, sedangkan deep learning merupakan bagian dari machine learning yang menggunakan jaringan saraf tiruan untuk memproses data dalam skala besar dan kompleks (L. & G S, 2021).
Pada awal perkembangannya, AI hanya menggunakan sistem berbasis aturan sederhana yang bekerja berdasarkan instruksi yang telah ditentukan sebelumnya. Namun, seiring dengan perkembangan teknologi dan meningkatnya kemampuan komputasi, AI berkembang menjadi sistem yang mampu mempelajari pola dari data serta menghasilkan keputusan secara otomatis. Perkembangan tersebut membuat AI semakin banyak digunakan dalam berbagai bidang untuk membantu menyelesaikan pekerjaan yang sebelumnya dilakukan secara manual oleh manusia.
Perkembangan AI telah mengalami kemajuan pesat dari sistem berbasis aturan sederhana hingga teknologi modern yang memanfaatkan machine learning, deep learning, dan Large Language Model (LLM). LLM merupakan model kecerdasan buatan berbasis deep learning yang dilatih menggunakan dataset teks skala masif sehingga mampu mengenali konteks, melakukan generatif teks, klasifikasi kategori dan prioritas secara akurat, serta menyusun ringkasan dokumen. Penerapan AI telah meluas ke berbagai bidang, seperti kesehatan, keuangan, dan pendidikan, serta memberikan dampak transformasional dalam meningkatkan efisiensi dan kualitas layanan. Namun demikian, pengembangan AI juga menghadapi tantangan, seperti isu bias, privasi, dan dampak terhadap tenaga kerja, sehingga diperlukan pendekatan yang bertanggung jawab dalam implementasinya (Rahman & Mehnaz, 2024).
Dalam penerapannya, AI digunakan untuk membantu proses analisis data, otomatisasi pekerjaan, serta pengambilan keputusan secara lebih cepat dan akurat. AI juga mampu mengolah data dalam jumlah besar untuk menemukan pola dan informasi yang sulit dianalisis secara manual. Kemampuan tersebut membuat AI menjadi salah satu teknologi penting dalam mendukung transformasi digital di berbagai sektor industri dan layanan modern.
Dalam konteks layanan digital, AI berperan penting dalam meningkatkan pengalaman pengguna melalui penyediaan layanan yang lebih personal, cepat, dan efisien. AI mampu mengolah data dalam jumlah besar untuk menghasilkan informasi yang relevan serta mendukung pengambilan keputusan secara otomatis. Selain itu, AI juga memungkinkan terciptanya mekanisme nilai tambah dalam layanan, seperti klasifikasi permasalahan secara cerdas, analisis kemiripan kasus, rekomendasi solusi berbasis riwayat data, dan komunikasi yang lebih responsif antara sistem dan pengguna. Dengan kemampuan tersebut, AI menjadi teknologi kunci dalam pengembangan sistem modern, termasuk dalam integrasi chatbot dan sistem helpdesk ticketing yang membutuhkan akurasi dan kecepatan tinggi dalam merespons kebutuhan pengguna (Kim, 2023).
Dalam sistem chatbot dan helpdesk, AI digunakan untuk memahami pertanyaan pengguna, memberikan respon otomatis yang kontekstual, serta membantu proses analisis dan pengambilan keputusan yang sebelumnya bergantung sepenuhnya pada tenaga manusia. Kemampuan AI dalam memproses teks secara semantik memungkinkan sistem untuk mengidentifikasi kategori dan tingkat urgensi suatu permasalahan secara otomatis, menemukan kasus-kasus serupa dari riwayat yang telah diselesaikan, hingga menyusun ringkasan penyelesaian secara terstruktur. Dengan adanya AI, sistem helpdesk dapat memberikan pelayanan yang lebih responsif dan membantu mengurangi ketergantungan terhadap proses manual, sehingga penggunaan AI dalam sistem helpdesk dan chatbot menjadi salah satu solusi penting dalam meningkatkan kualitas layanan digital di era modern.
 
2.2.4 API (Application Programming Interface)
Application Programming Interface (API) merupakan sekumpulan aturan, protokol, dan mekanisme yang memungkinkan berbagai aplikasi perangkat lunak untuk saling berkomunikasi dan bertukar data secara terstruktur. API berfungsi sebagai perantara yang menghubungkan satu sistem dengan sistem lainnya tanpa mengharuskan pengguna memahami proses internal yang kompleks. Ketika suatu aplikasi membutuhkan data atau layanan tertentu, aplikasi tersebut akan mengirimkan permintaan (request) sesuai dengan format yang telah ditentukan oleh API, kemudian sistem tujuan akan memproses permintaan tersebut dan mengembalikan respon (response) yang diinginkan. Dengan adanya mekanisme ini, pengembang dapat memanfaatkan fungsi dari sistem lain secara efisien tanpa harus membangun seluruh sistem dari awal (Park et al., 2025).
Konsep kerja API dapat dianalogikan seperti layanan di restoran, di mana pengguna berperan sebagai pelanggan yang memilih layanan dari menu yang tersedia, sedangkan API bertindak sebagai perantara yang menyampaikan permintaan kepada sistem penyedia layanan. Sistem tersebut kemudian memproses permintaan dan mengembalikan hasil kepada pengguna melalui API. Analogi ini menunjukkan bahwa pengguna tidak perlu mengetahui bagaimana proses internal berlangsung, karena seluruh kompleksitas sistem telah disembunyikan di balik API. Selain itu, API juga menyediakan format komunikasi yang terstandarisasi sehingga memudahkan integrasi antar aplikasi yang berbeda platform maupun bahasa pemrograman (Park et al., 2025).
Dalam perkembangan teknologi modern, API memiliki peran yang sangat penting terutama dalam mendukung integrasi sistem pada lingkungan komputasi awan (cloud computing). Berbagai layanan cloud menyediakan API melalui model layanan seperti Platform as a Service (PaaS), Software as a Service (SaaS), dan Infrastructure as a Service (IaaS), sehingga memungkinkan aplikasi untuk saling terhubung secara fleksibel dan scalable. Selain itu, API juga berkontribusi dalam meningkatkan modularitas dan interoperabilitas sistem, di mana setiap komponen aplikasi dapat dikembangkan secara terpisah namun tetap dapat berkomunikasi dengan baik. Penelitian menunjukkan bahwa REST API merupakan jenis API yang paling banyak digunakan, sementara teknologi seperti GraphQL mulai berkembang karena kemampuannya dalam mengoptimalkan pengambilan data pada sistem yang kompleks (Mohammed Mudassir & Mohammed Mushtaq, 2024; Qazi, 2023).
Dalam implementasi sistem berbasis Artificial Intelligence (AI), API banyak digunakan untuk menghubungkan aplikasi dengan layanan model bahasa besar (Large Language Model/LLM) yang disediakan oleh pihak ketiga. Salah satu layanan yang banyak digunakan adalah OpenRouter, yaitu platform penyedia API yang memungkinkan pengembang mengakses berbagai model AI dari beberapa penyedia dalam satu antarmuka yang terintegrasi. OpenRouter berfungsi sebagai agregator yang menyediakan akses ke berbagai model AI seperti OpenAI, Anthropic, Google Gemini, Meta Llama, Mistral, dan DeepSeek melalui satu endpoint API yang seragam. Dengan pendekatan tersebut, pengembang tidak perlu melakukan integrasi terpisah ke masing-masing penyedia layanan AI sehingga proses pengembangan menjadi lebih sederhana dan fleksibel.
Melalui OpenRouter, aplikasi dapat mengirimkan permintaan berupa pertanyaan atau instruksi ke model AI yang dipilih, kemudian menerima respon yang dihasilkan oleh model tersebut melalui mekanisme REST API. Penggunaan OpenRouter juga memberikan kemudahan dalam pengelolaan model AI karena pengembang dapat mengganti atau membandingkan model yang digunakan tanpa melakukan perubahan besar pada struktur aplikasi. Dalam penelitian ini, OpenRouter digunakan sebagai API provider yang menghubungkan sistem helpdesk chatbot dengan model Artificial Intelligence untuk memproses pertanyaan pengguna dan menghasilkan jawaban secara otomatis. Pemanfaatan OpenRouter diharapkan dapat meningkatkan fleksibilitas sistem serta mempermudah pengembangan dan pemeliharaan layanan chatbot berbasis AI.
Meskipun memberikan banyak manfaat, penggunaan API juga memiliki tantangan terutama dalam aspek keamanan dan pengelolaan. API sering menjadi titik rentan terhadap serangan karena adanya penggunaan kode pihak ketiga yang tidak sepenuhnya terlihat oleh pengembang, sehingga meningkatkan potensi celah keamanan. Banyak organisasi masih bergantung pada keamanan jaringan secara umum tanpa memperhatikan keamanan API secara khusus, yang dapat memperbesar risiko terjadinya pelanggaran data. Selain itu, keterbatasan dalam menemukan dan memanfaatkan API secara optimal juga menjadi kendala, sehingga diperlukan sistem pendukung seperti direktori API dan teknologi analisis berbasis OpenAPI Specification (OAS) untuk meningkatkan kemudahan pencarian, interoperabilitas, dan penggunaan kembali API. Oleh karena itu, pengelolaan dan pengamanan API yang baik menjadi faktor penting agar manfaat API dapat dimaksimalkan dalam pengembangan sistem informasi modern (Ma et al., 2023; Qazi, 2023).
2.2.5 Website
Website merupakan kumpulan halaman yang saling terhubung dan dapat diakses melalui jaringan internet menggunakan peramban (web browser). Website digunakan sebagai media untuk menyajikan informasi, menyediakan layanan, serta memfasilitasi interaksi antara pengguna dan sistem. Dalam perkembangan teknologi informasi, website menjadi salah satu platform yang banyak digunakan karena dapat diakses dari berbagai perangkat tanpa memerlukan instalasi aplikasi khusus. Menurut Sibero (2013), website adalah suatu sistem yang berkaitan dengan dokumen yang digunakan sebagai media untuk menampilkan teks, gambar, multimedia, dan data lainnya melalui jaringan internet. Website umumnya dibangun menggunakan teknologi seperti HTML, CSS, dan JavaScript pada sisi antarmuka (frontend), serta bahasa pemrograman dan basis data pada sisi server (backend).
Berdasarkan sifatnya, website dapat dibedakan menjadi dua jenis, yaitu website statis dan website dinamis. Website statis memiliki konten yang relatif tetap dan perubahan isi dilakukan secara langsung pada kode sumber halaman. Sementara itu, website dinamis memungkinkan konten berubah secara otomatis berdasarkan data yang tersimpan dalam basis data dan interaksi pengguna. Sistem informasi modern umumnya menggunakan website dinamis karena lebih fleksibel dalam pengelolaan data and pengembangan fitur. Menurut Wahyudin dan Rahayu (2020), sistem informasi berbasis website banyak digunakan karena mampu meningkatkan efektivitas pengelolaan informasi dan memberikan kemudahan akses bagi pengguna.
Dalam penelitian ini, website digunakan sebagai platform utama untuk menjalankan sistem helpdesk chatbot AI. Melalui website, pengguna dapat mengakses layanan helpdesk, berinteraksi dengan chatbot, mengajukan pertanyaan, serta melihat informasi yang diberikan oleh sistem. Selain itu, website memungkinkan integrasi dengan API AI sehingga proses komunikasi antara pengguna dan chatbot dapat berlangsung secara real-time. Penggunaan website juga memudahkan pengelolaan sistem karena dapat diakses melalui berbagai perangkat yang memiliki koneksi internet tanpa memerlukan instalasi tambahan.
 
BAB III
METODOLOGI PENELITIAN

Pada bab ini dijelaskan metodologi yang digunakan dalam pengembangan Sistem Helpdesk Chatbot AI berbasis web. Pengembangan sistem ini membutuhkan pengumpulan data serta analisis kebutuhan yang akan digunakan pada sistem mulai dari desain penelitian, teknik pengumpulan data, pengembangan dan implementasi sistem serta validasi dan hasil evaluasi.

3.1 Metode Pengumpulan Data
Metode pengumpulan data merupakan langkah awal dalam pelaksanaan penelitian. Dalam penelitian ini, penulis menggunakan metode observasi terhadap proses layanan helpdesk yang berjalan sebagai objek penelitian. Metode observasi dipilih karena dapat memberikan gambaran secara langsung mengenai alur pelayanan, permasalahan yang terjadi, serta kebutuhan pengguna terhadap sistem helpdesk yang akan dikembangkan. Sebagai penguat dalam pemenuhan literatur dan informasi, penulis mengumpulkan beberapa dokumen seperti jurnal oleh peneliti terdahulu, buku, artikel ilmiah, dan dokumentasi resmi yang terkait dengan penelitian ini guna referensi dan rujukan, baik yang membahas metode penelitian yaitu Waterfall, sistem helpdesk, chatbot, Artificial Intelligence (AI), Application Programming Interface (API), aplikasi berbasis website, serta Laravel sebagai framework pengembang sistem.
Hasil dari pengumpulan data meliputi informasi mengenai proses layanan helpdesk yang berjalan, jenis pertanyaan yang sering diajukan pengguna, prosedur penanganan keluhan dan permintaan bantuan, kebutuhan pengguna terhadap layanan bantuan digital, serta kebutuhan integrasi API AI dalam sistem chatbot. Seluruh data ini dikumpulkan untuk keperluan pengembangan aplikasi Sistem Helpdesk Chatbot AI berbasis web.
 

 
3.2 Metodologi Penelitian
Metodologi penelitian yang digunakan dalam pengembangan sistem ini adalah metode rekayasa perangkat lunak dengan pendekatan model Waterfall. Model ini dipilih karena bersifat sistematis dan terstruktur, dimulai dari tahap analisis kebutuhan hingga tahap implementasi dan pemeliharaan. Sebelum pengembangan dimulai, penulis terlebih dahulu melakukan pengumpulan data melalui observasi dan studi literatur yang mencakup proses layanan helpdesk, kebutuhan pengguna, teknologi chatbot, teknologi Artificial Intelligence (AI), serta integrasi API yang akan digunakan dalam sistem.
Adapun tahapan dalam metode Waterfall yang diterapkan meliputi:
1.	Analisis Kebutuhan, mengidentifikasi kebutuhan fungsional dan non-fungsional sistem.
2.	Desain Sistem, merancang alur kerja sistem, basis data, dan antarmuka aplikasi.
3.	Implementasi, mengembangkan sistem sesuai dengan desain yang telah dibuat.
4.	Pengujian, memastikan sistem berjalan sesuai dengan kebutuhan dan tujuan penelitian.
5.	Pemeliharaan, melakukan perbaikan atau pengembangan sistem berdasarkan hasil evaluasi dan umpan balik pengguna.

3.3 Analisis Kebutuhan Sistem
Analisis kebutuhan sistem adalah proses dalam penelitian yang bertujuan untuk memperoleh informasi, model, dan spesifikasi perangkat lunak yang diinginkan serta perangkat keras yang dibutuhkan dalam pengembangan Sistem Helpdesk Chatbot AI. Analisis kebutuhan dibedakan menjadi dua jenis, yaitu kebutuhan fungsional dan kebutuhan non-fungsional.
3.3.1 Analisis Kebutuhan Fungsional
Kebutuhan fungsional adalah kebutuhan yang menjelaskan layanan atau fungsi yang harus disediakan oleh sistem agar dapat digunakan oleh pengguna. Kebutuhan ini mendefinisikan bagaimana sistem merespon input, memproses data, dan menghasilkan output.
Adapun kebutuhan fungsional pada Sistem Helpdesk Chatbot AI antara lain:
1.	Pengguna (User) dapat mengakses halaman chatbot melalui website untuk berkonsultasi mengenai permasalahan teknologi informasi secara real-time.
2.	Pengguna (User) dapat membuat tiket bantuan secara otomatis berdasarkan hasil analisis obrolan dengan chatbot atau membuatnya secara manual melalui formulir pembuatan tiket.
3.	Pengguna (User) dapat mengunggah file lampiran gambar/foto sebagai bukti kendala teknis pada tiket bantuan.
4.	Pengguna (User) dapat melihat riwayat dan memantau status perkembangan tiket bantuan miliknya.
5.	Pengguna (User) dan Staf Support (Teknisi) dapat berinteraksi dan berdiskusi melalui obrolan pesan di dalam detail tiket bantuan.
6.	Staf Support (Teknisi) dapat menugaskan tiket baru yang masuk kepada dirinya sendiri (self-assign) untuk segera ditangani.
7.	Staf Support (Teknisi) dapat memperbarui status tiket (open, progress, resolved, closed) dan menentukan skala prioritas tiket (low, medium, high).
8.	Staf Support (Teknisi) dapat melihat analisis prediktif AI berupa ringkasan masalah, perkiraan penyebab, langkah rekomendasi penanganan, dan tingkat keyakinan AI.
9.	Staf Support (Teknisi) dapat melihat rekomendasi kasus serupa yang bersumber dari tiket lama berstatus resolved/closed untuk mempermudah proses penyelesaian tiket.
10.	Sistem dapat mengotomatisasi pembuatan ringkasan penyelesaian (resolution summary) menggunakan AI ketika tiket telah diselesaikan atau ditutup.
11.	Sistem dapat mengirimkan notifikasi unread secara real-time kepada pengguna saat terjadi perubahan status tiket atau saat ada pesan masuk baru.
12.	Admin dapat mengelola seluruh data pengguna sistem (menghapus pengguna dan memperbarui peran/role pengguna).
13.	Admin dapat melihat laporan visualisasi statistik tiket dan kinerja layanan melalui dashboard admin.
14.	Sistem dapat mengirimkan pertanyaan obrolan chatbot ke API AI melalui OpenRouter dan menampilkan responnya kepada pengguna secara otomatis.
3.3.2 Analisis Kebutuhan Non Fungsional
Kebutuhan non-fungsional adalah spesifikasi teknis yang harus dipenuhi oleh sistem agar dapat beroperasi secara optimal. Kebutuhan ini meliputi aspek kinerja, keamanan, kompatibilitas, dan infrastruktur pendukung sistem, seperti perangkat keras dan perangkat lunak.
1. Perangkat Keras
Perangkat keras diperlukan untuk mendukung proses perancangan, pengembangan, dan pengujian sistem. Spesifikasi minimum perangkat keras yang digunakan dalam penelitian ini adalah:
a.	Processor : Intel Core i5-8350U CPU @ 1.70 GHz
b.	RAM : 8 GB
c.	Penyimpanan : SSD 128 GB
d.	Sistem Operasi : Windows 11 Pro
2. Perangkat Lunak
Perangkat lunak digunakan untuk mendukung proses perancangan, pengembangan, dan implementasi sistem. Adapun perangkat lunak yang digunakan adalah:
a.	Microsoft Office 2019 – untuk dokumentasi penelitian
b.	Laragon – sebagai web server dan database server
c.	MySQL – sebagai basis data sistem
d.	Microsoft Edge – browser untuk pengujian aplikasi
e.	Draw.io – pembuatan diagram UML
f.	Figma – perancangan antarmuka pengguna (UI)
g.	Visual Studio Code – editor kode program
h.	Laravel – framework pengembangan aplikasi web
i.	Git dan GitHub – manajemen versi kode program



3.4 Desain Sistem
Perancangan desain sistem pada penelitian ini menggunakan UML (Unified Modeling Language) yang terdiri dari Use Case Diagram, Activity Diagram, Sequence Diagram, dan Class Diagram. Pengembangan antarmuka website yang mudah digunakan dan responsif menjadi salah satu aspek penting dalam perancangan Sistem Helpdesk Chatbot AI. Dengan dirancangnya desain sistem, akan lebih mudah dalam memberikan gambaran alur kerja sistem secara keseluruhan, mendukung komunikasi selama proses pengembangan, serta memastikan bahwa setiap komponen sistem dapat saling terintegrasi dengan baik. Perancangan ini juga mempermudah identifikasi kebutuhan pengguna, mengurangi risiko kesalahan selama pengembangan, dan memberikan panduan yang jelas untuk implementasi serta pengujian sistem agar hasil akhirnya sesuai dengan tujuan yang telah ditetapkan.
Selain itu, desain sistem juga mencakup perancangan integrasi API Artificial Intelligence (AI) yang berfungsi sebagai mesin pemrosesan pertanyaan pengguna. Melalui integrasi tersebut, chatbot dapat menghasilkan jawaban secara otomatis berdasarkan pertanyaan yang diberikan pengguna sehingga dapat meningkatkan kualitas layanan helpdesk dan mengurangi beban kerja petugas dalam menangani pertanyaan yang berulang.

3.5 Alur Perancangan Sistem
Alur perancangan sistem digambarkan melalui dua bagian diagram alur (flowchart) terintegrasi yang menjelaskan siklus hidup tiket gangguan dan titik integrasi kecerdasan buatan (Artificial Intelligence). Pemisahan alur ini bertujuan untuk menyajikan visualisasi yang terstruktur mengenai batasan peran antara interaksi awal pengguna (user) dengan penanganan teknis oleh staf teknisi (support).




 Gambar 3.1 Flowchart Aplikasi Bagian 1
Gambar 3.1 Flowchart Aplikasi Bagian 1: Inisiasi, Triage, dan Pembuatan Tiket menjelaskan tahap awal sistem yang dimulai dari proses autentikasi masuk pengguna. Pengguna diarahkan untuk melakukan konsultasi mandiri terlebih dahulu dengan Chatbot AI sebagai pendukung tingkat pertama (first-level support). Jika solusi chatbot tidak menyelesaikan kendala, pengguna dapat membuat tiket melalui dua metode: otomatis atau manual. Pada metode otomatis, AI menganalisis riwayat percakapan chat untuk menyusun draf formulir tiket secara otomatis (kategori, deskripsi, dan judul) yang kemudian dikonfirmasi oleh pengguna. Pada metode manual, pengguna mengisi formulir secara mandiri di mana AI tetap bekerja di latar belakang untuk menganalisis data masukan secara real-time. Tiket yang berhasil tersimpan di database kemudian memicu sistem mengirim notifikasi tiket baru ke staf teknisi, yang dijembatani oleh On-Page Connector A menuju alur berikutnya.
Gambar 3.2 Flowchart Aplikasi Bagian 2
Gambar 3.2 Flowchart Aplikasi Bagian 2: Penanganan, Resolusi, dan Penutupan Tiket menggambarkan proses penyelesaian masalah yang diteruskan dari titik A. Setelah staf teknisi melakukan self-assign tiket dari dashboard, status tiket berubah menjadi In Progress dan sistem mengirimkan notifikasi kepada pengguna. Saat teknisi membuka detail tiket, modul asisten AI secara otomatis menyajikan analisis prediktif berupa ringkasan masalah, perkiraan penyebab, rekomendasi langkah penanganan, serta menampilkan maksimal tiga riwayat kasus serupa yang telah ditutup sebelumnya sebagai referensi. Teknisi kemudian melakukan tindakan perbaikan dan mengubah status tiket menjadi Resolved. Setelah status berubah, AI kembali menganalisis riwayat diskusi tiket untuk merangkum hasil penyelesaian secara otomatis ke dalam kolom resolution_summary. Terakhir, sistem meminta verifikasi pengguna; jika disetujui, tiket akan ditutup (Closed) dan dimasukkan ke dalam basis pengetahuan (knowledge base), namun jika perbaikan dirasa belum tuntas, tiket dapat dibuka kembali (reopened) untuk ditangani ulang oleh teknisi.
 
3.6 Perancangan Sistem UML 
UML adalah bahasa pemodelan visual yang digunakan untuk merancang dan memodelkan sistem perangkat lunak. Dilansir dari Visual Paradigm, UML mencakup notasi grafis yang digunakan untuk merepresentasikan berbagai aspek dari sistem, termasuk struktur sistem, perilaku sistem, interaksi antara objek, dan lingkungan di mana sistem beroperasi. Menurut Grady Booch, salah satu ahli yang terlibat dalam pengembangan Unified Modeling Language, UML adalah “bahasa pemodelan visual yang dapat digunakan untuk merepresentasikan sistem perangkat lunak yang berbeda, mulai dari sistem yang sederhana hingga sistem yang kompleks.”(Faulina, 2023)
3.6.1 Use Case Diagram
 Use Case Diagram merupakan salah satu diagram dalam Unified Modeling Language (UML) yang digunakan untuk menggambarkan interaksi antara aktor dengan sistem serta kebutuhan fungsional yang dimiliki oleh sistem dari sudut pandang pengguna (Kurniawan, 2018). Diagram ini membantu pengembang dalam mengidentifikasi fungsi-fungsi yang dapat diakses oleh setiap aktor yang terlibat dalam sistem (TechTarget, 2020). Pada penelitian ini, Use Case Diagram digunakan untuk memodelkan interaksi antara aktor, yaitu pengguna (user), teknisi, dan administrator dengan Sistem Helpdesk Chatbot AI. Diagram ini menggambarkan hak akses serta fungsi yang dapat dilakukan oleh masing-masing aktor, seperti mengelola tiket, melakukan konsultasi melalui chatbot AI, menangani permasalahan pengguna, dan mengelola data sistem. Dengan adanya Use Case Diagram, kebutuhan fungsional sistem dapat teridentifikasi dengan lebih jelas sebelum proses pengembangan sistem dilakukan.
Gambar 3.2 Use Case Diagram
Gambar 3.2 menjelaskan interaksi antara aktor dengan use case (fitur) yang tersedia di dalam Sistem Helpdesk Chatbot AI. Pada diagram ini terdapat 3 (tiga) aktor utama yang terlibat, yaitu User, Teknisi, dan Admin. Aktor User memiliki hak akses untuk melakukan login, membuat tiket (yang meliputi pengisian judul, kategori, deskripsi, dan lampiran foto), melihat riwayat tiket, serta melakukan chat dengan Chatbot AI. Aktor Teknisi memiliki akses untuk melakukan login, melihat daftar tiket, mengambil tiket, dan memperbarui status tiket. Sementara itu, aktor Admin memiliki hak akses penuh terhadap semua fungsi sistem, termasuk login, membuat tiket, melihat riwayat tiket, melakukan chat dengan Chatbot AI, melihat daftar tiket, mengambil tiket, memperbarui status tiket, serta memiliki hak akses eksklusif untuk melakukan pengelolaan data pengguna (kelola pengguna) dan melihat laporan.
3.6.2 Activity Diagram 
Activity Diagram merupakan salah satu diagram UML yang digunakan untuk menggambarkan alur kerja (workflow) atau urutan aktivitas dalam suatu sistem. Pada penelitian ini, Activity Diagram digunakan untuk menggambarkan alur proses pada Sistem Helpdesk Chatbot AI, mulai dari pengguna melakukan login, membuat tiket, memperoleh analisis dari chatbot AI, hingga proses penanganan tiket oleh teknisi dan penutupan tiket. Dengan Activity Diagram, alur kerja sistem dapat divisualisasikan dengan jelas sehingga memudahkan proses perancangan dan implementasi sistem (Dennis et al., 2015).
3.6.2.1 Activity Diagram Login
Gambar 3.3 Activity Diagram Login
Gambar 3.3 menjelaskan kegiatan user ketika melakukan proses login. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman login, memasukkan email dan password hingga sistem memverifikasi data yang diinputkan. Jika data yang dimasukkan sesuai dengan yang terdapat dalam database, sistem akan mengecek role pengguna untuk mengarahkan ke dashboard yang sesuai yaitu dashboard admin, dashboard support, atau dashboard user. Namun, jika data yang dimasukkan tidak valid, sistem akan memberikan pesan kesalahan dan meminta user untuk mencoba login kembali.
3.6.2.2 Activity Diagram Buat Tiket 
Gambar 3.4 Activity Diagram Buat Tiket
Gambar 3.4 menjelaskan kegiatan user ketika melakukan proses pembuatan tiket. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman buat tiket, mengisi judul masalah, deskripsi, dan memilih kategori masalah hingga sistem melakukan validasi data yang diinputkan. Jika data yang dimasukkan valid dan lengkap sesuai dengan aturan validasi sistem, sistem akan menyimpan tiket baru ke database dengan prioritas default low dan mengarahkan pengguna kembali ke halaman daftar tiket serta menampilkan pesan sukses. Namun, jika data yang dimasukkan tidak valid, sistem akan menampilkan pesan kesalahan dan mengembalikan pengguna ke halaman form buat tiket untuk mengisi ulang data yang diperlukan.
3.6.2.3 Activity Diagram Chatbot AI 
Gambar 3.5 Activity Diagram Chatbot
Gambar 3.5 menjelaskan kegiatan user ketika melakukan proses interaksi dengan chatbot. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh user, mulai dari mengakses halaman chatbot, mengirimkan pesan chat hingga sistem memvalidasi dan memproses pesan tersebut. Jika input pesan valid, sistem akan menyimpan pesan user ke database dan melakukan pemanggilan ke API melalui layanan OpenRouter. Apabila pemanggilan API berhasil, sistem akan mengambil respon dari AI. Sedangkan jika pemanggilan API gagal, sistem akan menggunakan mekanisme fallback bertingkat: pertama, mencari jawaban relevan di basis pengetahuan lokal (Knowledge Base) menggunakan pencocokan kata kunci, dan jika tidak ditemukan, sistem beralih ke pencocokan pola ekspresi reguler (Regex). Hasil respon (baik dari AI maupun fallback) kemudian disimpan ke dalam database sebelum dikirim dan ditampilkan kembali pada antarmuka chat user. Selain percakapan mandiri, user juga dapat mengklik tombol analisis percakapan untuk menghasilkan draf tiket bantuan secara otomatis berdasarkan riwayat obrolan tersebut. Namun, jika pesan yang dikirimkan tidak valid, sistem akan menampilkan pesan kesalahan validasi dan meminta user untuk mengirim kembali pesan yang sesuai.
3.6.2.4 Activity Diagram Kelola Pengguna 
Gambar 3.6 Activity Diagram Kelola Pengguna
Gambar 3.6 menjelaskan kegiatan admin ketika melakukan proses manajemen data pengguna. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh admin, mulai dari mengakses dashboard admin hingga sistem menampilkan data pengguna berdasarkan masing-masing role. Admin kemudian dapat memilih aksi yang ingin dilakukan, yaitu menghapus pengguna atau mengubah role pengguna. Jika admin memilih untuk menghapus pengguna, sistem akan memproses penghapusan data pengguna tersebut di database. Sementara itu, jika admin memilih untuk mengubah role pengguna, admin akan memilih role baru yang diinginkan, dan sistem akan mengupdate data role tersebut di database.
3.6.2.5 Activity Diagram Penanganan Tiket 
Gambar 3.7 Activity Diagram Penanganan Tiket
Gambar 3.7 menjelaskan kegiatan staff support ketika melakukan proses penanganan tiket kendala. Diagram ini menggambarkan langkah-langkah yang dilakukan oleh staff support, mulai dari mengakses daftar tiket kendala hingga sistem menampilkan seluruh daftar tiket yang masuk. Staff support kemudian memilih tiket tertentu untuk melihat detailnya, yang kemudian direspons sistem dengan menampilkan detail tiket tersebut beserta analisis prediktif AI (ringkasan masalah, kemungkinan penyebab, rekomendasi penanganan) dan rekomendasi kasus serupa secara otomatis. Setelah itu, staff support dapat menugaskan tiket kepada diri sendiri (self-assign), di mana sistem akan memperbarui status tiket menjadi progress. Selanjutnya, staff support dapat menginput perubahan detail tiket seperti memperbarui status atau prioritas, yang kemudian direspons sistem dengan memperbarui data tiket tersebut, menyusun ringkasan penyelesaian otomatis oleh AI jika status berubah menjadi resolved/closed, serta menyimpan riwayat perubahan tiket (ticket history) ke dalam database sebelum proses selesai.
3.6.3 Sequence Diagram 
Sequence Diagram merupakan salah satu diagram UML yang digunakan untuk menggambarkan interaksi antar objek atau aktor dalam sistem berdasarkan urutan waktu. Diagram ini menunjukkan pesan atau komunikasi yang terjadi antara aktor dan sistem secara berurutan dari awal hingga akhir proses. Sequence Diagram membantu dalam memahami alur proses serta pertukaran informasi yang terjadi pada setiap fungsi sistem (Dennis et al., 2015).
Pada penelitian ini, Sequence Diagram digunakan untuk memodelkan urutan interaksi antara pengguna, teknisi, administrator, dan Sistem Helpdesk Chatbot AI. Diagram ini menggambarkan proses yang terjadi pada setiap fitur sistem, seperti pembuatan tiket, analisis masalah oleh chatbot AI, penanganan tiket oleh teknisi, serta pengelolaan data oleh administrator. Dengan Sequence Diagram, alur komunikasi antar komponen sistem dapat dipahami secara lebih rinci sehingga memudahkan proses pengembangan dan implementasi sistem (Satzinger et al., 2016). Selain itu, Sequence Diagram membantu mengidentifikasi pertukaran data dan respons sistem pada setiap tahapan proses sehingga potensi kesalahan dalam perancangan sistem dapat diminimalkan.


3.6.3.1 Sequence Diagram User
Gambar 3.7 Sequence Diagram User
Rancangan pada Gambar 3.7 ini menjelaskan alur kegiatan user yang dilakukan didalam sistem melalui gambaran Sequence Diagram. Kegiatan diawali dari user mengakses halaman login dan memasukkan email serta password, sistem melakukan autentikasi melalui database users dan mengarahkan ke dashboard user. Selanjutnya user dapat membuat tiket baru dengan mengisi form yang berisi subject, description, dan category, lalu sistem menyimpan data ke tabel tickets dan menampilkan konfirmasi. User juga dapat mengakses fitur chatbot AI dengan mengirimkan pesan, sistem akan membuat atau mengambil sesi percakapan aktif dari tabel chatbot_conversations, mengirim pesan ke API Gemini AI melalui OpenRouter, menerima respons, lalu menyimpan pesan dan balasan ke tabel chat_messages dan menampilkan hasilnya kepada user.
3.6.3.2 Sequence Diagram Teknisi
Gambar 3.8 Sequence Diagram Teknisi
Gambar 3.8 menampilkan kegiatan teknisi (support) dalam melakukan kegiatan di dalam sistem melalui rancangan Sequence Diagram. Kegiatan aktor teknisi diawali dengan melakukan login dan diarahkan ke dashboard support yang menampilkan statistik tiket. Teknisi mengakses halaman daftar seluruh tiket, memilih tiket untuk dilihat detailnya, kemudian sistem secara otomatis menampilkan panel analisis prediktif AI (ringkasan masalah, kemungkinan penyebab, rekomendasi penanganan, dan tingkat keyakinan) serta panel rekomendasi kasus serupa dari tiket lama berstatus resolved/closed yang diperoleh melalui perbandingan semantik oleh model AI. Selanjutnya, teknisi dapat melakukan assign tiket kepada diri sendiri (self-assign) melalui tombol assign. Setelah itu, teknisi dapat mengubah status tiket (open, progress, resolved, closed), mengubah prioritas (low, medium, high), dan menambahkan catatan penanganan. Jika status diubah menjadi resolved atau closed, sistem secara otomatis memanggil API OpenRouter untuk menyusun ringkasan penyelesaian (resolution summary) berdasarkan riwayat diskusi tiket. Setiap perubahan status juga dicatat secara otomatis oleh sistem ke dalam tabel ticket_histories sebagai riwayat penanganan tiket yang dapat ditelusuri kembali.
3.6.3.3 Sequence Diagram Admin
Gambar 3.9 Sequence Diagram Admin
Gambar 3.9 menampilkan kegiatan admin dalam melakukan kegiatan pengelolaan di dalam sistem melalui rancangan Sequence Diagram. Kegiatan aktor admin diawali dengan melakukan login dan diarahkan ke dashboard admin. Admin mengakses halaman kelola pengguna yang menampilkan daftar semua user berdasarkan role (user, support, admin). Admin dapat memilih pengguna tertentu untuk mengubah role-nya melalui form update role, sistem kemudian memperbarui data di tabel users dan menampilkan pesan konfirmasi. Selain itu, admin juga dapat menghapus pengguna dari sistem, dimana sistem akan melakukan pengecekan terlebih dahulu agar admin tidak dapat menghapus akun miliknya sendiri, lalu menghapus data pengguna dari database dan menampilkan konfirmasi keberhasilan.
Selain pengelolaan pengguna, admin juga memiliki hak eksklusif untuk mengelola dokumen basis pengetahuan (Knowledge Base) melalui halaman khusus manajemen Knowledge Base. Admin dapat membuat dokumen baru dengan mengisi judul, kategori, kata kunci, konten, dan level akses, memperbarui dokumen yang ada, serta mengaktifkan atau menonaktifkan dokumen. Setiap aksi admin terhadap dokumen Knowledge Base dicatat secara otomatis ke dalam tabel knowledge_base_logs sebagai riwayat aktivitas administratif.
Meskipun admin memiliki hak akses terhadap seluruh fitur sistem, Sequence Diagram Admin menampilkan proses kelola pengguna dan kelola Knowledge Base karena keduanya merupakan aktivitas eksklusif yang tidak dimiliki oleh aktor lain. Aktivitas yang sama dengan user dan support telah dijelaskan pada Sequence Diagram masing-masing aktor.
3.6.4 Class Diagram
Class Diagram merupakan salah satu diagram UML yang digunakan untuk menggambarkan struktur statis suatu sistem. Diagram ini menunjukkan kelas-kelas yang terdapat dalam sistem, atribut yang dimiliki setiap kelas, metode yang dapat dijalankan, serta hubungan antar kelas seperti association, aggregation, composition, dan inheritance. Class Diagram berfungsi sebagai dasar dalam perancangan basis data dan pengembangan perangkat lunak karena mampu menggambarkan struktur objek secara detail (Satzinger et al., 2016).
Gambar 3.10 Class Diagram

Pada penelitian ini, Class Diagram digunakan untuk memodelkan struktur data pada Sistem Helpdesk Chatbot AI. Diagram ini menggambarkan hubungan antara kelas-kelas utama seperti pengguna (user), tiket (ticket), riwayat tiket (ticket history), percakapan chatbot (chatbot conversation), pesan chatbot (chatbot message), dan diskusi tiket (ticket chat). Dengan adanya Class Diagram, struktur sistem dan hubungan antar entitas dapat dipahami dengan lebih jelas sehingga memudahkan proses implementasi sistem dan perancangan basis data (Dennis et al., 2015). 
Gambar 3.10 menampilkan rancangan Class Diagram yang menggambarkan struktur kelas dan relasi antar entitas dalam sistem IT Helpdesk. Terdapat enam kelas utama yaitu User, Ticket, TicketHistory, TicketMessage, ChatbotConversation, dan ChatMessage. Kelas User memiliki atribut id, name, email, password, role dan berelasi one-to-many dengan kelas Ticket (seorang user dapat memiliki banyak tiket), one-to-many dengan ChatbotConversation (seorang user dapat memiliki banyak sesi percakapan), one-to-many dengan TicketHistory, serta one-to-many dengan TicketMessage (diskusi di tiket). Kelas Ticket memiliki atribut id, user_id, subject, description, category, priority, status, assigned_to dan berelasi many-to-one dengan User melalui user_id dan assigned_to, one-to-many dengan TicketHistory, serta one-to-many dengan TicketMessage. Kelas TicketHistory menyimpan riwayat perubahan status tiket dengan atribut old_status, new_status, dan notes. Kelas TicketMessage menyimpan pesan diskusi di dalam tiket dengan atribut message. Kelas ChatbotConversation berelasi one-to-many dengan ChatMessage yang menyimpan pesan percakapan antara user dan chatbot AI dengan atribut message, sender_type, dan response.

3.7 Struktur Tabel Database
Struktur tabel dalam database adalah kerangka kerja yang digunakan untuk mengatur data yang akan disimpan dalam aplikasi. Setiap tabel dalam database terdiri dari kolom (fields) yang merepresentasikan atribut atau karakteristik dari data, dan baris (records) yang merepresentasikan data aktual yang disimpan. Struktur tabel dirancang untuk memenuhi kebutuhan aplikasi, memastikan data tersimpan secara efisien, terstruktur, dan mudah diakses.
3.7.1 Tabel Users
Tabel 3.1 Struktur Tabel Users
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
name	varchar	255	Nama pengguna
email	varchar	255	Email unik pengguna
email_verified_at	timestamp	-	Waktu verifikasi email (nullable)
password	varchar	255	Kata sandi terenkripsi
remember_token	varchar	100	Token remember me (nullable)
role	varchar	255	Hak akses pengguna (default: user)
created_at	timestamp	-	Waktu data dibuat
updated_at	timestamp	-	Waktu data diperbarui

Perancangan tabel users ini dimanfaatkan sebagai autentikasi pengguna ketika akan masuk ke dalam sistem yang dinamai dengan aktivitas Login. Pada Tabel 3.1 struktur tabel users ini menyimpan informasi pengguna dengan kolom id sebagai Primary Key atau unik, name, email, password, dan role. Kolom id menjadikan identifikasi unik bagi setiap pengguna untuk masuk ke dalam sistem untuk mengurangi proses ganda. Kolom name adalah data sebagai informasi diri user. Email dan password berperan untuk kegiatan login pengguna. Kolom role digunakan untuk membedakan hak akses antara admin dan user biasa. Dengan tujuan faktor keamanan dalam akses lebih terjaga.
3.7.2 Tabel Tickets
Tabel 3.2 Struktur Tabel Tickets
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
user_id	bigint	20	Foreign Key ke tabel users (nullable)
subject	varchar	255	Subjek tiket
description	text	-	Deskripsi permasalahan
category	varchar	255	Kategori tiket
priority	enum	'low', 'medium', 'high'	Tingkat prioritas tiket
status	enum	'open', 'progress', 'resolved', 'closed'	Status tiket (default: open)
Tabel 3.2 Lanjutan
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
attachment	varchar	255	Path file lampiran gambar (nullable)
assigned_to	bigint	20	Foreign Key ke tabel users (nullable)
ai_summary	text	-	Ringkasan masalah oleh AI (nullable)
ai_causes	text	-	Kemungkinan penyebab oleh AI (nullable)
ai_recommendations	text	-	Rekomendasi penanganan oleh AI (nullable)
ai_confidence	varchar	255	Tingkat keyakinan analisis AI (nullable)
resolution_summary	text	-	Ringkasan penyelesaian oleh AI (nullable)
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Tabel 3.2 ini digunakan untuk menyimpan data tiket pengaduan atau permintaan bantuan yang diajukan oleh pengguna. Kolom id bertindak sebagai Primary Key yang menjamin setiap tiket memiliki identifikasi unik. Kolom user_id berfungsi sebagai Foreign Key yang merujuk ke tabel users untuk mengidentifikasi pengguna yang membuat tiket, kolom ini bersifat nullable agar riwayat tiket tetap tersimpan meskipun user dihapus. Kolom subject dan description menyimpan judul dan detail permasalahan. Kolom category digunakan untuk mengkategorikan jenis tiket. Kolom priority menentukan tingkat urgensi tiket dengan pilihan low, medium, dan high. Kolom status mencatat progres penanganan tiket. Kolom attachment menyimpan path lampiran file gambar bukti kendala teknis. Kolom assigned_to sebagai Foreign Key merujuk ke tabel users untuk menentukan teknisi support yang menangani tiket tersebut. Kolom ai_summary, ai_causes, ai_recommendations, dan ai_confidence menyimpan data analisis kendala serta langkah penanganan teknis yang dihasilkan secara dinamis oleh asisten AI. Kolom resolution_summary menyimpan teks ringkasan hasil penyelesaian akhir yang disusun otomatis oleh AI ketika tiket berstatus resolved atau closed.

3.7.3 Tabel Ticket Histories
Tabel 3.3 Struktur Tabel Ticket Histories
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
ticket_id	bigint	20	Foreign Key ke tabel tickets
user_id	bigint	20	Foreign Key ke tabel users
old_status	enum	'open', 'progress', 'resolved', 'closed'	Status sebelumnya (nullable)
new_status	enum	'open', 'progress', 'resolved', 'closed'	Status baru
notes	text	-	Catatan perubahan status (nullable)
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Struktur tabel yang terdapat pada Tabel 3.3 bernama ticket_histories dimana tabel basis data ini digunakan untuk menyimpan riwayat perubahan status pada setiap tiket. Terdapat kolom id sebagai Primary Key, kolom ticket_id sebagai Foreign Key yang merujuk ke tabel tickets untuk menandai tiket mana yang mengalami perubahan status, dan kolom user_id sebagai Foreign Key yang merujuk ke tabel users untuk mencatat siapa yang melakukan perubahan status. Kolom old_status dan new_status menyimpan status sebelum dan sesudah perubahan. Kolom notes digunakan untuk menyimpan catatan tambahan terkait perubahan status tersebut.
3.7.4 Tabel Chatbot Conversations
Tabel 3.4 Struktur Tabel Chatbot Conversations
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
user_id	bigint	20	Foreign Key ke tabel users
title	varchar	255 (default: 'New Conversation')	Judul percakapan
status	varchar	255 (default: 'active')	Status percakapan ('active' atau 'closed')
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Tabel chatbot_conversations pada Tabel 3.4 digunakan untuk menyimpan data sesi percakapan chatbot antara pengguna dan sistem AI. Kolom id bertindak sebagai Primary Key yang menjamin setiap percakapan memiliki identifikasi unik. Kolom user_id berfungsi sebagai Foreign Key yang merujuk ke tabel users untuk mengidentifikasi pengguna yang memulai percakapan. Kolom title menyimpan judul percakapan dengan nilai default 'New Conversation'. Kolom status mencatat apakah percakapan masih aktif atau sudah ditutup, sehingga sistem dapat mengelola sesi percakapan dengan baik.
3.7.5 Tabel Chat Messages
Tabel 3.5 Struktur Tabel Chat Messages
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
chatbot_conversation_id	bigint	20	Foreign Key ke tabel chatbot_conversations
user_id	bigint	20	Foreign Key ke tabel users
message	longText	-	Pesan yang dikirim
sender_type	varchar	255	Tipe pengirim ('user' atau 'bot')
response	longText	-	Respon chatbot (nullable)
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Tabel 3.5 ini menyimpan data mengenai pesan-pesan dalam percakapan chatbot. Kolom id bertindak sebagai Primary Key. Kolom chatbot_conversation_id berfungsi sebagai Foreign Key yang merujuk ke tabel chatbot_conversations untuk menandai pesan tersebut milik sesi percakapan mana. Kolom user_id sebagai Foreign Key merujuk ke tabel users untuk mengidentifikasi pengguna yang mengirim pesan. Kolom message menyimpan isi pesan yang dikirim. Kolom sender_type membedakan apakah pesan dikirim oleh pengguna ('user') atau oleh sistem AI ('bot'). Kolom response menyimpan balasan dari chatbot AI yang bersifat nullable karena tidak semua pesan memerlukan respons langsung.

3.7.6 Tabel Ticket Messages
Tabel 3.6 Struktur Tabel Ticket Messages
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
ticket_id	bigint	20	Foreign Key ke tabel tickets (on cascade delete)
user_id	bigint	20	Foreign Key ke tabel users (on cascade delete)
message	text	-	Isi pesan obrolan diskusi tiket
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Struktur tabel yang terdapat pada Tabel 3.6 bernama ticket_messages digunakan untuk menyimpan riwayat pesan diskusi/obrolan di dalam detail tiket bantuan. Tabel ini memfasilitasi komunikasi dua arah secara langsung antara pelapor (user) dengan teknisi penanggung jawab (support) serta administrator dalam upaya mencari solusi atas permasalahan teknis. Kolom id bertindak sebagai Primary Key. Kolom ticket_id dan user_id bertindak sebagai Foreign Key yang masing-masing merujuk ke tabel tickets dan users. Kolom message menampung pesan percakapan diskusi tersebut.

3.7.7 Tabel Knowledge Base
Tabel 3.7 Struktur Tabel Knowledge Base
Nama Kolom	Tipe Data	Panjang/Nilai	Keterangan
id	bigint	20	Primary Key
title	varchar	255	Judul dokumen basis pengetahuan
category	varchar	255	Kategori dokumen (Hardware POS, Printer Thermal, dll.)
keywords	text	-	Kata kunci pencarian dokumen
content	text	-	Isi/konten dokumen basis pengetahuan
access_level	varchar	255	Level akses dokumen (public atau internal)
is_active	tinyint	1 (default: 1)	Status aktif/nonaktif dokumen
created_by	bigint	20	Foreign Key ke tabel users (pembuat dokumen)
updated_by	bigint	20	Foreign Key ke tabel users (pembaruan terakhir)
created_at	timestamp	-	Waktu data dibuat (nullable)
updated_at	timestamp	-	Waktu data diperbarui (nullable)

Tabel 3.7 ini digunakan untuk menyimpan dokumen basis pengetahuan (Knowledge Base) yang dikelola oleh administrator. Kolom id bertindak sebagai Primary Key. Kolom title menyimpan judul dokumen yang digunakan sebagai referensi utama pengguna. Kolom category mengklasifikasikan dokumen berdasarkan klaster masalah yang didukung sistem. Kolom keywords menyimpan kata kunci yang digunakan oleh sistem untuk mencocokkan pertanyaan pengguna dengan dokumen yang relevan saat mekanisme fallback aktif. Kolom content menyimpan isi solusi atau panduan teknis secara lengkap. Kolom access_level menentukan apakah dokumen dapat diakses secara publik atau hanya untuk pengguna internal. Kolom is_active menentukan apakah dokumen tersebut aktif dan dapat digunakan oleh sistem pencarian Knowledge Base. Kolom created_by dan updated_by sebagai Foreign Key mencatat identitas administrator yang membuat dan terakhir memperbarui dokumen sebagai bagian dari log akuntabilitas.

3.8 Perancangan Interface 
Perancangan interface dimaksud untuk memberikan gambaran dan perancangan mengenai tampilan halaman aplikasi yang akan dibangun. Rancangan ini akan memudahkan programmer dalam menggambarkan tata letak tampilan yang akan diimplementasikan ke dalam aplikasi. Desain antarmuka ini dibuat menggunakan figma sebagai alat perancangan utama yang berfungsi sebagai acuan visual.
Gambar 3.11 Desain Login
Halaman login digunakan oleh pengguna untuk masuk ke dalam Sistem Helpdesk Ticketing dengan memasukkan email dan password yang telah terdaftar. Sistem akan melakukan autentikasi untuk memverifikasi data pengguna dan menentukan hak akses berdasarkan peran yang dimiliki, yaitu user, support, atau admin. Jika data yang dimasukkan valid, pengguna akan diarahkan ke halaman utama sesuai hak aksesnya, sedangkan jika tidak valid, sistem akan menampilkan pesan kesalahan dan meminta pengguna untuk login kembali.
Gambar 3.12 Desain Dashboard User
Dashboard user merupakan halaman utama yang ditampilkan setelah pengguna berhasil login ke dalam sistem. Halaman ini menyajikan informasi ringkasan terkait aktivitas pengguna, seperti jumlah tiket yang telah dibuat serta status masing-masing tiket. Selain itu, pengguna dapat dengan mudah membuat tiket pengaduan baru melalui fitur yang tersedia pada halaman dashboard untuk melaporkan permasalahan atau meminta bantuan kepada tim support.

Gambar 3.13 Desain Form Pembuatan Tiket
Halaman pembuatan tiket digunakan oleh user untuk melaporkan kerusakan atau permasalahan yang terjadi dengan mengisi data yang diperlukan, seperti judul laporan, kategori masalah, dan deskripsi kerusakan. Setelah data dikirim, sistem akan menyimpan laporan sebagai tiket yang dapat diproses oleh tim support.
Gambar 3.14 Desain Riwayat Tiket
Halaman riwayat tiket digunakan untuk menampilkan daftar tiket yang telah dibuat oleh user beserta informasi status penanganannya. Melalui halaman ini, user dapat memantau perkembangan setiap tiket yang diajukan, mulai dari status terbuka, sedang diproses, hingga selesai ditangani oleh tim support. 
Gambar 3.15 Desain Dashboard Support / Teknisi
Halaman dashboard support menampilkan ringkasan statistik penanganan tiket bagi staf teknisi. Informasi yang ditampilkan mencakup total tiket masuk, jumlah tiket yang belum ditangani, sedang diproses, selesai diselesaikan, grafik kategori tiket, serta prioritas tingkat urgensi tiket. Halaman ini dirancang untuk memudahkan teknisi support memantau antrean tugas penanganan kendala IT secara efisien.
Selain menampilkan informasi statistik, dashboard support juga menyediakan akses cepat ke daftar tiket yang menjadi tanggung jawab teknisi. Melalui halaman ini, teknisi dapat melihat detail tiket, memperbarui status penanganan, menentukan prioritas, serta melakukan komunikasi dengan pengguna terkait perkembangan penyelesaian masalah. Dengan tersedianya informasi yang terpusat pada satu halaman, proses monitoring dan pengelolaan tiket dapat dilakukan secara lebih efektif sehingga membantu meningkatkan kecepatan respons dan kualitas layanan helpdesk.
 
Gambar 3.16 Desain Dashboard Admin
Halaman dashboard admin digunakan untuk mengelola data pengguna dan basis pengetahuan yang terdaftar dalam sistem. Melalui halaman ini, admin dapat mengubah dan menghapus data pengguna serta mengatur hak akses sesuai dengan peran yang dimiliki. Admin juga dapat mengakses halaman manajemen Knowledge Base untuk membuat, memperbarui, mengaktifkan, atau menonaktifkan dokumen panduan teknis yang digunakan sebagai referensi chatbot dan teknisi.
 
Gambar 3.17 Desain Chatbot Bantuan
Fitur chatbot digunakan untuk memberikan respon otomatis terhadap pertanyaan yang diajukan oleh pengguna terkait permasalahan teknologi informasi. Melalui fitur ini, pengguna dapat berkonsultasi secara mandiri dan memperoleh solusi awal secara cepat tanpa harus langsung membuat tiket. Setelah percakapan berlangsung, pengguna dapat menggunakan fitur analisis percakapan untuk menghasilkan draf tiket bantuan secara otomatis berdasarkan riwayat obrolan tersebut, sehingga proses pelaporan menjadi lebih mudah dan efisien.
 
BAB IV
HASIL DAN PEMBAHASAN


Bagian ini menampilkan hasil implementasi dan fungsionalitas dalam rekayasa perangkat lunak dengan menerapkan Sistem Helpdesk Chatbot AI berbasis web. Perangkat lunak dan perangkat keras termasuk dalam pembahasan implementasi dan pengujian sistem.

4.1 Implementasi
Implementasi merupakan tahap krusial setelah perancangan dan analisis program selesai. Tahap ini berfokus pada pembangunan aplikasi yang merepresentasikan desain yang telah dibuat secara nyata. Tujuan utama implementasi adalah membangun aplikasi yang mudah dan nyaman digunakan oleh pengguna. Oleh karena itu, aplikasi perlu melalui proses pengujian dan penyempurnaan yang menyeluruh untuk meminimalisir kesalahan dan memastikan kelancaran sistem. Implementasi yang cermat dan terencana akan menghasilkan aplikasi yang siap diluncurkan dan memberikan manfaat bagi para user.

4.3 Implementasi Sistem
Implementasi sistem merupakan tahap penerapan hasil analisis dan perancangan yang telah dilakukan pada tahap sebelumnya ke dalam bentuk aplikasi yang dapat digunakan oleh pengguna. Pada penelitian ini, implementasi dilakukan dengan membangun Sistem Helpdesk Ticketing Berbasis Web yang terintegrasi dengan API Chatbot Artificial Intelligence untuk membantu proses pelaporan dan penanganan permasalahan teknologi informasi. Implementasi mencakup pengembangan basis data, logika aplikasi, integrasi API chatbot AI, serta antarmuka pengguna yang mendukung aktivitas pengguna, teknisi, dan administrator. Hasil implementasi sistem selanjutnya akan dijelaskan melalui tampilan dan fungsi dari setiap fitur yang telah dibangun.
4.3.1 Halaman Dashboard User 
 
Gambar 4.9 Halaman Dashboard User
Halaman dashboard user pada Gambar 4.9 adalah tampilan awal yang akan muncul setelah aktor user (pelanggan) berhasil melakukan proses login. Tampilan ini menyajikan statistik ringkasan tiket yang dimiliki oleh user tersebut berdasarkan status tiket (open, progress, resolved, closed) dan prioritas penanganan (low, medium, high), serta menampilkan daftar 5 tiket pengaduan terbaru milik user. 
Segmen 4.1 Dashboard User
1	@extends('layouts.app') 
2	@section('content') 
3	<div class="py-12"> 
4	    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
5	        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6"> 
6	            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
7	                <div class="text-sm font-medium text-gray-500">Tiket Terbuka</div> 
8	                <div class="text-3xl font-semibold">{{ $ticketsByStatus['open'] }}</div> 
9	            </div> 
10	            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"> 
11	                <div class="text-sm font-medium text-gray-500">Sedang Diproses</div> 
12	                <div class="text-3xl font-semibold">{{ $ticketsByStatus['progress'] }}</div> 
13	            </div> 
14	        </div> 
15	    </div> 
16	</div> 
17	@endsection 
Segmen 4.1 kode ini merupakan bagian dari tampilan halaman dashboard user. Penggunaan @extends('layouts.app') berfungsi sebagai master layout untuk menjaga konsistensi elemen visual seperti header, navigasi, dan footer. Pada bagian @section('content'), statistik jumlah tiket user diakses dari variabel $ticketsByStatus untuk ditampilkan dalam bentuk kartu grid yang responsif.
4.1.3.2 Halaman Daftar Tiket User 
 
Gambar 4.10 Halaman Daftar Tiket User
Tampilan halaman pada Gambar 4.10 menampilkan seluruh riwayat tiket kendala yang diajukan oleh user. Halaman ini dilengkapi dengan fitur penyaringan (filter) berdasarkan status tiket, prioritas, kategori masalah, serta tanggal pembuatan tiket. Dengan adanya pagination, data tiket disajikan sebanyak 15 data per halaman agar memudahkan navigasi pengguna.
Segmen 4.2 Halaman Daftar Tiket User
1	public function index(Request $request) 
2	{ 
3	    if (auth()->user()->role === 'support') { 
4	        return redirect()->route('support.tickets'); 
5	    } 
6	    $filterStatus = $request->query('status'); 
7	    $filterPriority = $request->query('priority'); 
8	    $filterCategory = $request->query('category'); 
9	    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
10	    if (auth()->user()->role !== 'admin') { 
11	        $ticketsQuery->where('user_id', auth()->id()); 
12	    } 
13	    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
14	    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
15	    return view('tickets.index', compact('tickets', 'categories')); 
16	} 

Pada Segmen 4.2 menjelaskan kode pengendali (controller) untuk menampilkan halaman daftar tiket. Fungsi index() akan memverifikasi peran pengguna terlebih dahulu. Jika pengguna adalah support, sistem akan mengarahkannya ke halaman tiket support. Sementara itu, untuk user biasa, query database dibatasi hanya untuk mengambil tiket milik mereka sendiri sebelum akhirnya dikirimkan ke blade views untuk dirender.
4.1.3.3 Halaman Pembuatan Tiket Baru 
 
Gambar 4.11 Halaman Pembuatan Tiket Baru
Pada gambar 4.11 menampilkan formulir pembuatan tiket baru yang diakses oleh user. Formulir ini meminta input subjek masalah, deskripsi kendala secara detail, pemilihan kategori kendala dari tujuh pilihan yang tersedia (Hardware POS, Printer Thermal, Barcode Scanner, Jaringan & Internet, CCTV, Software POS, dan Server & Database), serta opsi unggah berkas lampiran pendukung berupa foto atau gambar.
Segmen 4.3 Form Pembuatan Tiket
1	<form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data"> 
2	    @csrf 
3	    <div class="mb-4"> 
4	        <label for="subject">Subjek Masalah</label> 
5	        <input type="text" name="subject" id="subject" required class="form-input"> 
6	    </div> 
7	    <div class="mb-4"> 
8	        <label for="category">Kategori</label> 
9	        <select name="category" id="category" required class="form-select"> 
10	            <option value="Hardware">Hardware</option> 
11	            <option value="Software">Software</option> 
12	            <option value="Jaringan">Jaringan</option> 
13	            <option value="Akun">Akun</option> 
14	            <option value="Lainnya">Lainnya</option> 
15	        </select> 
16	    </div> 
17	    <div class="mb-4"> 
18	        <label for="attachment">Lampiran Gambar (Opsional)</label> 
19	        <input type="file" name="attachment" id="attachment" accept="image/"> 
20	    </div> 
21	    <button type="submit" class="btn-submit">Kirim Tiket</button> 
22	</form> 

Segmen 4.3 menampilkan rancangan formulir Blade HTML untuk mengunggah tiket. Atribut enctype="multipart/form-data" digunakan agar form dapat memproses unggahan file gambar lampiran secara aman. Validasi masukan dilakukan di sisi server untuk memastikan semua data wajib terisi sesuai format.
4.1.3.4b Halaman Rekomendasi Kasus Serupa (Knowledge Base)
 
Gambar 4.12b Halaman Rekomendasi Kasus Serupa

Di samping panel analisis utama, halaman detail tiket juga dilengkapi dengan panel "Kasus Serupa" khusus untuk aktor teknisi (support) dan admin. Fitur ini berfungsi sebagai basis pengetahuan (knowledge base) dinamis yang memindai tiket lama berstatus resolved atau closed yang memiliki kemiripan kategori dan isi keluhan dengan tiket aktif.
Segmen 4.4b Logika Pencarian Kasus Serupa Berbasis AI
1	 private function findSimilarTickets($ticket): array
2	 {
3	 $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed'])
4	 ->whereNotNull('resolution_summary')
5	 ->where('id', '!=', $ticket->id)->latest()->take(15)->get(['id', 'subject', 'category', 'resolution_summary']);
6	 if ($resolvedTickets->isEmpty()) { return []; }
7	 $candidatesText = "";
8	 foreach ($resolvedTickets as $candidate) {
9	 $candidatesText .= "ID: {$candidate->id} | Kategori: {$candidate->category} | Judul: {$candidate->subject}\n";
10	 $candidatesText .= "Resolusi: " . \Illuminate\Support\Str::limit($candidate->resolution_summary, 150) . "\n---\n";
11	 }
12	 $systemPrompt = "Anda adalah asisten pencari kasus IT Helpdesk yang cerdas. Bandingkan tiket aktif dengan daftar tiket lama. Temukan maks 3 tiket serupa...";
13	 $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [
14	 'model' => env('OPENROUTER_MODEL', 'gpt-4o-mini'),
15	 'messages' => [
16	 ['role' => 'system', 'content' => $systemPrompt],
17	 ['role' => 'user', 'content' => "TICKET AKTIF:\nJudul: {$ticket->subject}...\n\nDAFTAR KASUS LAMA:\n{$candidatesText}"]
18	 ]
19	 ]);
20	 // ... parsing json dan mengembalikan array berisi similarity & reason ...
21	 }
Segmen 4.4b di atas memaparkan logika controller dalam menemukan kasus serupa. Staf IT tidak perlu mencari secara manual di basis data. Model AI (Gemini/GPT) akan membandingkan konteks permasalahan secara semantik dan mengembalikan rekomendasi 3 tiket selesai beserta penilaian kemiripan (Tinggi/Sedang) serta alasan teknis mengapa solusi tiket tersebut relevan dijadikan rujukan penanganan.

4.1.3.4 Halaman Detail Tiket & Analisis AI 
 
Gambar 4.12 Halaman Detail Tiket & Analisis AI
Halaman detail tiket pada Gambar 4.12 menampilkan rincian dari satu tiket kendala terpilih. Pada halaman ini, staff teknisi dan admin dapat melihat data laporan pengguna beserta visualisasi analisis AI secara real-time yang bersumber dari API OpenRouter. AI akan menyajikan ringkasan masalah, dugaan penyebab, rekomendasi solusi, serta persentase keyakinan (confidence). Integrasi AI pada halaman detail tiket ini bertujuan untuk meminimalkan waktu yang dibutuhkan teknisi dalam melakukan investigasi awal. Dengan adanya modul analisis otomatis, teknisi dapat langsung memahami duduk perkara kendala tanpa harus membaca teks deskripsi yang panjang atau tidak terstruktur dari user.
Segmen 4.4 Detail Tiket & Rekomendasi AI
1	@if($ticket->ai_summary) 
2	<div class="bg-blue-50 p-4 rounded-lg mb-6 border border-blue-200"> 
3	    <h3 class="text-lg font-medium text-blue-800">Analisis Otomatis AI Helpdesk</h3> 
4	    <p><strong>Ringkasan Masalah:</strong> {{ $ticket->ai_summary }}</p> 
5	    <p><strong>Kemungkinan Penyebab:</strong></p> 
6	    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_causes)) !!}</div> 
7	    <p><strong>Rekomendasi Penanganan:</strong></p> 
8	    <div class="text-sm text-gray-700">{!! nl2br(e($ticket->ai_recommendations)) !!}</div> 
9	    <p><strong>Tingkat Keyakinan AI:</strong> <span class="badge">{{ $ticket->ai_confidence }}</span></p> 
10	</div> 
11	@endif 

Segmen 4.4 menjelaskan kode tampilan detail tiket yang memproses render bersyarat (@if) untuk menampilkan analisis AI. Apabila kolom `ai_summary` pada tabel tickets terisi, sistem akan mencetak panel analisis terstruktur dengan styling khusus menggunakan kelas Tailwind CSS untuk mempermudah teknisi dalam mengidentifikasi masalah secara cepat. Empat parameter utama yang diproses dan ditampilkan oleh AI meliputi:
1. Ringkasan Masalah (`ai_summary`): Penjelasan singkat 1-2 kalimat mengenai inti masalah yang dilaporkan pengguna.
2. Kemungkinan Penyebab (`ai_causes`): Analisis beberapa faktor teknis yang memicu terjadinya kendala tersebut.
3. Rekomendasi Penanganan (`ai_recommendations`): Panduan langkah demi langkah bagi teknisi untuk menyelesaikan kendala terkait.
4. Tingkat Keyakinan AI (`ai_confidence`): Persentase estimasi tingkat akurasi atau keyakinan model kecerdasan buatan terhadap rekomendasi yang diajukan.
4.1.3.5 Halaman Diskusi Tiket (Obrolan Detail) 
 
Gambar 4.13 Halaman Diskusi Tiket
Di dalam halaman detail tiket terdapat modul obrolan diskusi seperti terlihat pada Gambar 4.13. Modul ini difungsikan agar pembuat tiket (user), teknisi yang ditugaskan, dan administrator dapat melakukan tanya jawab secara interaktif guna mempercepat koordinasi pemecahan masalah teknis.
Segmen 4.5 Pengiriman Pesan Obrolan Tiket
1	public function storeMessage(Request $request, $id) 
2	{ 
3	    $request->validate(['message' => 'required|string|max:1000']); 
4	    $ticket = Ticket::findOrFail($id); 
5	    $user = auth()->user(); 
6	    if ($ticket->user_id !== $user->id && $user->role !== 'support' && $user->role !== 'admin') { 
7	        abort(403, 'Anda tidak memiliki akses ke tiket ini.'); 
8	    } 
9	    $msg = TicketMessage::create([ 
10	        'ticket_id' => $ticket->id, 
11	        'user_id'   => $user->id, 
12	        'message'   => $request->message, 
13	    ]); 
14	    return redirect()->route('tickets.show', $ticket->id)->with('success', 'Pesan berhasil dikirim.'); 
15	} 

Pada Segmen 4.5 menjelaskan logika controller untuk menyimpan pesan diskusi baru. Metode storeMessage() melakukan pengecekan otorisasi ketat guna memastikan hanya aktor yang berhak (pemilik tiket, teknisi pemroses, atau admin) yang dapat menyisipkan rekaman ke dalam tabel `ticket_messages`, diikuti dengan pengiriman notifikasi otomatis kepada pihak terkait.
4.1.3.6 Halaman Chatbot AI (Konsultasi Mandiri) 
 
Gambar 4.14 Halaman Chatbot AI
Halaman Chatbot AI pada Gambar 4.14 memfasilitasi user untuk melakukan konsultasi masalah IT secara mandiri dengan asisten cerdas Gemini AI. Untuk memastikan fungsionalitas asisten ini berjalan optimal dan tidak disalahgunakan, sistem dirancang dengan beberapa aturan serta batasan logis di tingkat backend:
1. Penyaringan Topik Khusus IT: Menggunakan System Prompt ketat untuk membatasi ruang lingkup obrolan hanya pada bidang teknologi, troubleshooting komputer, jaringan, dan software. Pertanyaan non-teknis akan ditolak secara otomatis secara sopan.
2. Format Jawaban Plain Text: Bot dipaksa untuk menjawab dalam teks biasa tanpa format markdown guna menjaga kerapihan gelembung obrolan pada antarmuka Chatbot UI.
3. Pembatasan Sesi Diskusi: Jumlah pengiriman pesan pengguna dibatasi maksimal 10 pesan (`MAX_USER_MESSAGES = 10`) untuk setiap sesi aktif guna meminimalisir biaya penggunaan API OpenRouter.
4. Hotline Pengaduan: Apabila percakapan mencapai batas atau solusi tidak ditemukan, chatbot akan menyarankan pembuatan tiket resmi atau langsung menghubungi nomor teknisi yang tertera.
Apabila API OpenRouter/Gemini mengalami kendala koneksi atau limit kuota, sistem menyediakan mekanisme fallback bertingkat: pertama, sistem akan mencari jawaban yang relevan di dalam basis pengetahuan lokal (Knowledge Base) secara offline menggunakan pencocokan kata kunci. Jika tidak ditemukan, sistem secara otomatis beralih ke pencocokan pola ekspresi reguler (Regular Expression/Regex) agar pengguna selalu mendapatkan respon operasional dasar tanpa mengalami kekosongan jawaban.
Segmen 4.6 Pemrosesan Chatbot dan Fallback Regex
1	private function getFallbackResponse(string $message): string 
2	{ 
3	    $message = strtolower($message); 
4	    $fallbacks = [ 
5	        '/\b(wifi|internet|jaringan|koneksi|sinyal|lemot|lag)\b/i' => 
6	            "Sepertinya Anda mengalami masalah koneksi. Coba langkah berikut:\n1. Pastikan WiFi Anda menyala.\n2. Coba restart router atau modem Anda.", 
7	        '/\b(error|bug|masalah|rusak|gagal|crash|freeze)\b/i' => 
8	            "Jelaskan lebih detail tentang error atau masalah teknis yang Anda hadapi. Berikan informasi seperti: pesan error dan kapan terjadi.", 
9	    ]; 
10	    foreach ($fallbacks as $pattern => $response) { 
11	        if (preg_match($pattern, $message)) { 
12	            return $response; 
13	        } 
14	    } 
15	    return "Maaf, sepertinya saya sedang mengalami gangguan koneksi ke server AI utama. Silakan coba tanyakan lagi."; 
16	} 

Segmen 4.6 ini diimplementasikan di dalam `ChatbotController` sebagai pengaman apabila koneksi OpenRouter mengalami kendala. Logika mencocokkan input masukan pengguna dengan kata kunci kunci menggunakan fungsi preg_match() PHP. Apabila kecocokan pola ditemukan, pesan petunjuk standar akan langsung dikirim kembali ke antarmuka user.
Selain percakapan mandiri, halaman ini memfasilitasi pembuatan tiket instan berbasis kecerdasan buatan. Dengan mengklik tombol "Analisis Percakapan", seluruh pesan obrolan antara pengguna dan bot dalam sesi tersebut akan dikirimkan kembali ke OpenRouter. Model AI akan menganalisis riwayat obrolan dan menyusun rancangan tiket terstruktur berformat JSON yang berisi: subjek, deskripsi detail kendala, penentuan kategori otomatis, penentuan prioritas masalah, ringkasan AI, dugaan penyebab, dan rekomendasi solusi. Rancangan JSON ini akan otomatis diisi ke dalam formulir pendaftaran tiket agar mempermudah pengguna.
Segmen 4.6b Analisis Percakapan Menjadi Draf Tiket
1	public function analyzeConversation(Request $request): JsonResponse 
2	   { 
3	       $conversation = ChatbotConversation::where('user_id', auth()->id())->where('status', 'active')->first(); 
4	       if (!$conversation) { return response()->json(['success' => false, 'message' => 'Tidak ada percakapan aktif.'], 404); } 
5	       $messages = $conversation->messages()->orderBy('created_at', 'asc')->get(); 
6	       if ($messages->isEmpty()) { return response()->json(['success' => false, 'message' => 'Percakapan kosong.'], 400); } 
7	       $conversationText = ""; 
8	       foreach ($messages as $msg) { 
9	           $sender = $msg->sender_type === 'user' ? 'User' : 'Asisten AI'; 
10	          $conversationText .= "[$sender]: " . $msg->message . "\n"; 
11	      } 
12	      $systemPrompt = "Anda adalah asisten analisis IT Helpdesk yang cerdas. Tugas Anda adalah menganalisis riwayat percakapan... dan menyusun rancangan tiket bantuan dalam format JSON yang valid."; 
13	      $model = env('OPENROUTER_MODEL', 'gpt-4o-mini'); 
14	      $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [ 
15	          'model' => $model, 
16	          'messages' => [ 
17	              ['role' => 'system', 'content' => $systemPrompt], 
18	              ['role' => 'user', 'content' => "Berikut adalah riwayat percakapan untuk dianalisis:\n\n" . $conversationText] 
19	          ], 
20	          'temperature' => 0.5, 
21	      ]); 
22	      // ... parsing json dan mengembalikan response ke frontend 
23	  } 

Segmen 4.6b di atas merupakan potongan kode metode `analyzeConversation()` di dalam `ChatbotController`. Logika ini mengambil seluruh rekaman chat dalam database, membangun string percakapan secara kronologis, dan mengirimkannya ke API OpenRouter dengan System Prompt khusus yang memaksa output berupa JSON valid. Data JSON tersebut kemudian diurai (decode) di sisi server sebelum dikembalikan ke antarmuka pengguna sebagai respons JSON.
4.1.3.7 Halaman Form Login & Autentikasi 
 
Gambar 4.15 Halaman Form Login
Halaman login pada Gambar 4.15 adalah gerbang utama otentikasi pengakses sistem. Formulir ini memvalidasi kombinasi email dan password unik pengguna. Setelah proses verifikasi sukses, sistem akan mengarahkan pengguna ke rute dashboard masing-masing sesuai dengan peran yang terdaftar di database.
Segmen 4.7 Rute Pengalihan Login Berdasarkan Role
1	Route::get('/dashboard', function () { 
2	    $user = auth()->user(); 
3	    if ($user->role === 'admin') { 
4	        return redirect()->route('admin.dashboard'); 
5	    } 
6	    if ($user->role === 'support') { 
7	        return redirect()->route('dashboard.support'); 
8	    } 
9	    return redirect()->route('dashboard.user'); 
10	})->middleware(['auth', 'verified'])->name('dashboard'); 

Segmen kode pada Segmen 4.7 ini mengelola pengalihan pengguna yang berhasil login. Pengecekan middleware `auth` dan `verified` memastikan sesi pengguna valid. Perbedaan logika peran diuji menggunakan struktur kondisi if untuk menentukan apakah pengguna diarahkan ke dashboard admin, support, atau user.
4.1.3.8 Halaman Form Registrasi Pengguna Baru 
 
Gambar 4.16 Halaman Form Registrasi
Halaman registrasi memfasilitasi pembuatan akun pengguna baru agar dapat mengakses fitur helpdesk. Formulir ini meminta nama lengkap, email unik, kata sandi, dan konfirmasi kata sandi. Secara sistem, setiap akun baru yang didaftarkan melalui halaman ini akan otomatis mendapatkan peran awal (role) sebagai 'user'.
Segmen 4.8 Validasi Pendaftaran Akun
1	protected function validator(array $data) 
2	{ 
3	    return Validator::make($data, [ 
4	        'name' => ['required', 'string', 'max:255'], 
5	        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
6	        'password' => ['required', 'string', 'min:8', 'confirmed'], 
7	    ]); 
8	} 

Segmen 4.8 ini menguraikan fungsi validator pendaftaran bawaan sistem Laravel. Aturan 'unique:users' memvalidasi agar tidak ada email ganda di dalam tabel users, sedangkan aturan 'confirmed' memastikan masukan konfirmasi sandi sama persis dengan kolom password utama.
4.1.3.9 Halaman Dashboard Support (Teknisi) 
 
Gambar 4.17 Halaman Dashboard Support
Halaman utama bagi aktor support (teknisi) ditampilkan pada Gambar 4.17. Dasbor ini menyajikan visualisasi data statistik yang komprehensif, mencakup jumlah tiket aktif, statistik tiket per status, tingkat prioritas tiket, kategori kerusakan terbanyak, jumlah tiket yang belum ditugaskan (unassigned), serta ringkasan tiket yang baru masuk.
Segmen 4.9 Statistik Tiket pada Dashboard Support
1	public function supportDashboard() 
2	{ 
3	    $totalTickets = Ticket::count(); 
4	    $ticketsByStatus = [ 
5	        'open' => Ticket::where('status', 'open')->count(), 
6	        'progress' => Ticket::where('status', 'progress')->count(), 
7	        'resolved' => Ticket::where('status', 'resolved')->count(), 
8	        'closed' => Ticket::where('status', 'closed')->count(), 
9	    ]; 
10	    $unassignedTickets = Ticket::where('status', 'open')->whereNull('assigned_to')->count(); 
11	    $recentTickets = Ticket::latest()->take(5)->get(); 
12	    return view('dashboard.support', compact('totalTickets', 'ticketsByStatus', 'unassignedTickets', 'recentTickets')); 
13	} 

Segmen 4.9 menjelaskan fungsi supportDashboard() di dalam `DashboardController`. Data statistik dihitung menggunakan agregasi Eloquent `count()` dari tabel tickets berdasarkan status dan penugasan teknisi. Data ini dipasok ke view `dashboard.support` untuk ditampilkan sebagai panel informasi penanganan harian teknisi.
4.1.3.10 Halaman Daftar Seluruh Tiket Masuk 
 
Gambar 4.18 Halaman Daftar Tiket Masuk
Halaman ini menampilkan seluruh daftar tiket pengaduan yang masuk dari seluruh user di dalam database seperti terlihat pada Gambar 4.18. Halaman ini dapat diakses oleh teknisi dan admin untuk memantau beban antrean tiket kendala secara menyeluruh.
Segmen 4.10 Pengambilan Tiket Masuk
1	public function all(Request $request) 
2	{ 
3	    $filterStatus = $request->query('status'); 
4	    $ticketsQuery = Ticket::with(['user', 'assignedSupport'])->latest(); 
5	    if ($filterStatus) { 
6	        $ticketsQuery->where('status', $filterStatus); 
7	    } 
8	    $tickets = $ticketsQuery->paginate(15)->appends($request->query()); 
9	    $categories = Ticket::select('category')->distinct()->orderBy('category')->pluck('category'); 
10	    return view('support.tickets', compact('tickets', 'categories')); 
11	} 

Segmen 4.10 menunjukkan implementasi fungsi all() untuk mengambil seluruh data tiket di sistem. Relasi database `user` dan `assignedSupport` dipanggil dengan metode eager loading `with()` agar meminimalisir kueri ke database (N+1 query problem) saat mencetak daftar tiket di halaman support.
4.1.3.11 Halaman Penugasan Tiket (Self-Assign) 
 
Gambar 4.19 Halaman Penugasan Tiket
Untuk menangani masalah yang masuk, teknisi dapat memilih tombol penugasan tiket pada halaman detail tiket seperti Gambar 4.19. Tindakan ini memicu pembaruan kolom `assigned_to` pada tiket menjadi ID teknisi yang sedang login dan otomatis mengubah status tiket dari `open` menjadi `progress`.
Segmen 4.11 Proses Self-Assign Tiket
1	public function assign(Request $request, $id) 
2	{ 
3	    $request->validate([ 
4	        'assigned_to' => 'required|in:' . auth()->id(), 
5	    ], [ 
6	        'assigned_to.in' => 'Anda hanya dapat menugaskan tiket untuk diri Anda sendiri.', 
7	    ]); 
8	    $ticket = Ticket::findOrFail($id); 
9	    if ($ticket->assigned_to !== null) { 
10	        return redirect()->route('support.tickets')->with('error', 'Tiket ini sudah ditugaskan ke teknisi lain.'); 
11	    } 
12	    $ticket->assigned_to = auth()->id(); 
13	    $ticket->status = 'progress'; 
14	    $ticket->save(); 
15	    if ($ticket->user) { 
16	        $ticket->user->notify(new TicketAssignedNotification($ticket, auth()->user())); 
17	    } 
18	    return redirect()->route('support.tickets')->with('success', 'Tiket berhasil ditugaskan...'); 
19	}

Segmen 4.11 di atas adalah fungsi assign() di dalam `TicketController`. Validasi `'in:' . auth()->id()` memastikan teknisi hanya bisa mengklaim tiket untuk dirinya sendiri. Sistem juga dilengkapi dengan pemeriksaan `if ($ticket->assigned_to !== null)` guna mencegah terjadinya race condition apabila terdapat dua teknisi yang menekan tombol klaim pada saat yang bersamaan. Setelah berhasil, notifikasi `TicketAssignedNotification` akan dikirimkan langsung ke user pembuat tiket.
4.1.3.12 Halaman Pembaruan Tiket & AI Resolution 
 
Gambar 4.20 Halaman Pembaruan Tiket
Teknisi diberikan hak untuk memperbarui status penanganan tiket (open, progress, resolved, closed), mengubah skala prioritas, serta memasukkan catatan akhir. Saat status tiket diubah menjadi `resolved` atau `closed`, sistem memanggil OpenRouter secara otomatis untuk menyusun ringkasan penyelesaian (resolution summary) berdasarkan riwayat chat tiket tersebut.
Segmen 4.12 Pembaruan Status dan AI Resolution Summary
1	if (in_array($request->status, ['resolved', 'closed']) && empty($ticket->resolution_summary)) { 
2	    $ticket->resolution_summary = $this->generateResolutionSummary($ticket, $request->notes); 
3	} 
4	$ticket->save(); 
5	TicketHistory::create([ 
6	    'ticket_id' => $ticket->id, 
7	    'user_id' => auth()->id(), 
8	    'old_status' => $oldStatus, 
9	    'new_status' => $request->status, 
10	    'notes' => $finalNotes ?: null, 
11	]); 

Segmen 4.12 memaparkan sebagian logika pembaruan tiket di `TicketController`. Ketika status penyelesaian dicapai (`resolved` atau `closed`), fungsi pembantu `generateResolutionSummary` dieksekusi untuk merangkum seluruh percakapan diskusi tiket dan catatan teknisi menjadi satu laporan solusi yang padat dan jelas. Selanjutnya, riwayat perubahan ini disimpan ke dalam tabel `ticket_histories` sebagai log audit pelacakan kinerja teknisi.
Untuk memahami bagaimana ringkasan akhir solusi tersebut dihasilkan, sistem mendefinisikan fungsi internal yang memanggil model AI dengan struktur masukan detail kendala, catatan teknisi, serta jalannya diskusi antara user dan support.

Segmen 4.12b Logika Pembuatan Ringkasan Solusi AI
1	   private function generateResolutionSummary($ticket, $techNotes = null): string 
2	   { 
3	       try { 
4	           $apiKey = env('OPENROUTER_API_KEY', ''); 
5	           if (empty($apiKey)) { return "Masalah: {$ticket->subject}\nPenyebab: Tidak dapat menganalisis...\nSolusi: Tiket diselesaikan oleh teknisi."; } 
6	           $discussionMessages = $ticket->messages()->orderBy('created_at', 'asc')->get(); 
7	           $discussionText = ""; 
8	           foreach ($discussionMessages as $msg) { 
9	               $role = $msg->user->role === 'support' ? 'Teknisi' : ($msg->user->role === 'admin' ? 'Admin' : 'User'); 
10	              $discussionText .= "[$role - {$msg->user->name}]: {$msg->message}\n"; 
11	          } 
12	          $systemPrompt = "Anda adalah asisten dokumentasi IT Helpdesk. Tugas Anda adalah menganalisis riwayat tiket... Ringkasan harus berformat persis seperti berikut:\nMasalah:\n[...]\nPenyebab:\n[...]\nSolusi:\n[...]\nStatus:\nSelesai"; 
13	          $model = env('OPENROUTER_MODEL', 'gpt-4o-mini'); 
14	          $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [ 
15	              'model' => $model, 
16	              'messages' => [ 
17	                  ['role' => 'system', 'content' => $systemPrompt], 
18	                  ['role' => 'user', 'content' => "TICKET DETAILS:\nJudul: {$ticket->subject}...\nCATATAN TEKNISI:\n{$techNotes}\nDISKUSI:\n{$discussionText}"] 
19	              ], 
20	              'temperature' => 0.3, 
21	          ]); 
22	          if ($response->successful()) { return trim($response->json()['choices'][0]['message']['content']); } 
23	      } catch (\Exception $e) { Log::error('Generate Resolution Summary Failed: ' . $e->getMessage()); } 
24	      return "Masalah: {$ticket->subject}\nPenyebab: Diidentifikasi oleh teknisi secara langsung.\nSolusi: Langkah penanganan diselesaikan berdasarkan diskusi.\nStatus: Selesai."; 
25	  } 

Segmen 4.12b merupakan logika pengolahan data riwayat penanganan tiket pada backend. Kode ini melakukan:
1. Pengumpulan seluruh pesan percakapan internal tiket untuk mengetahui alur pemecahan masalah.
2. Formulasi prompt terstruktur yang memandu model AI agar hanya membalas dalam struktur baku (Masalah, Penyebab, Solusi, Status).
3. Pengiriman HTTP Request dengan tingkat temperature yang rendah (0.3) agar respon AI lebih konsisten dan deterministik.
4. Penyediaan pesan fallback standar apabila integrasi API terputus demi menjamin integritas data status tiket di database.

4.1.3.12c Fitur Rekomendasi Kasus Serupa (Knowledge Base)
Dalam proses penanganan tiket kendala aktif, sistem dirancang untuk dapat merekomendasikan riwayat kasus serupa kepada teknisi sebagai basis pengetahuan (Knowledge Base). Rekomendasi ini dihasilkan dengan membandingkan informasi tiket aktif dengan data riwayat tiket lama yang sudah diselesaikan (`resolved`/`closed`).

Segmen 4.12c Pencarian Kasus Serupa Berbasis AI
1	private function findSimilarTickets($ticket): array 
2	{ 
3	    try { 
4	        $resolvedTickets = Ticket::whereIn('status', ['resolved', 'closed']) 
5	            ->whereNotNull('resolution_summary') 
6	            ->where('id', '!=', $ticket->id) 
7	            ->latest()->take(15)->get(['id', 'subject', 'category', 'resolution_summary']); 
8	        if ($resolvedTickets->isEmpty()) { return []; } 
9	        $apiKey = env('OPENROUTER_API_KEY', ''); 
10	        if (empty($apiKey)) { return []; } 
11	        $candidatesText = ""; 
12	        foreach ($resolvedTickets as $candidate) { 
13	            $resolution = \Illuminate\Support\Str::limit($candidate->resolution_summary, 150); 
14	            $candidatesText .= "ID: {$candidate->id} | Kategori: {$candidate->category} | Judul: {$candidate->subject}\nResolusi: {$resolution}\n---\n"; 
15	        } 
16	        $systemPrompt = "Anda adalah asisten pencari kasus IT Helpdesk yang cerdas. Tugas Anda adalah membandingkan sebuah tiket kendala aktif dengan daftar tiket lama yang sudah diselesaikan. Temukan maksimal 3 tiket paling serupa..."; 
17	        $model = env('OPENROUTER_MODEL', 'gpt-4o-mini'); 
18	        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])->post('https://openrouter.ai/api/v1/chat/completions', [ 
19	            'model' => $model, 
20	            'messages' => [ 
21	                ['role' => 'system', 'content' => $systemPrompt], 
22	                ['role' => 'user', 'content' => "TICKET AKTIF:\nJudul: {$ticket->subject}\nDeskripsi: {$ticket->description}\n\nDAFTAR KASUS LAMA:\n{$candidatesText}"] 
23	            ], 
24	            'temperature' => 0.2, 
25	        ]); 
26	        if ($response->successful()) { 
27	            $matches = json_decode(trim($response->json()['choices'][0]['message']['content']), true); 
28	            // ... parsing matches ke database dan memetakan tiket serupa ... 
29	        } 
30	    } catch (\Exception $e) { Log::error('Find Similar Tickets Failed: ' . $e->getMessage()); } 
31	    return []; 
32	}

Fungsi `findSimilarTickets` pada Segmen 4.12c berjalan dengan menyaring maksimal 15 tiket terakhir yang berstatus diselesaikan/ditutup. Daftar kandidat tersebut dikirimkan ke model AI bersama dengan rincian tiket aktif menggunakan prompt dengan tingkat temperature rendah (0.2) untuk mendapatkan akurasi perbandingan kemiripan (*similarity matching*). Model AI kemudian mengembalikan maksimal 3 tiket serupa dalam format JSON array yang memuat deskripsi tingkat kesamaan dan alasannya.

4.1.3.13 Halaman Dashboard Admin 
 
Gambar 4.21 Halaman Dashboard Admin
Halaman utama administrator pada Gambar 4.21 menyajikan ringkasan administratif global. Admin dapat memantau statistik total seluruh tiket, sebaran kategori, prioritas masalah, serta daftar seluruh pengguna sistem yang dibagi berdasarkan peran (user biasa, staff support, dan administrator).
Segmen 4.13 Tampilan Data Pengguna pada Dashboard Admin
1	public function index(): View 
2	{ 
3	    $users = User::where('role', 'user')->get(); 
4	    $supportStaff = User::where('role', 'support')->get(); 
5	    $admins = User::where('role', 'admin')->get(); 
6	    $totalTickets = Ticket::count(); 
7	    return view('admin.dashboard', compact('users', 'supportStaff', 'admins', 'totalTickets')); 
8	} 

Segmen 4.13 menunjukkan pemrosesan dashboard admin di dalam `AdminController`. Fungsi index() mengambil semua data pengguna dari tabel users yang dikelompokkan sesuai dengan perannya (`role`) untuk dipetakan ke dalam tabel kelola akun pada view admin.
4.1.3.14 Halaman Kelola Data Pengguna (Manajemen Akun) 
 
Gambar 4.22 Halaman Kelola Data Pengguna
Sebagai pemegang otoritas tertinggi, admin dapat mengelola akun pengguna pada halaman Gambar 4.22. Aksi yang dapat dilakukan oleh admin meliputi penyesuaian hak akses role pengguna (misal menaikkan user menjadi support) serta penghapusan akun pengguna dari basis data.
Segmen 4.14 Logika Penghapusan Akun Pengguna
1	public function deleteUser(Request $request, User $user): RedirectResponse 
2	{ 
3	    if ($user->id === auth()->id()) { 
4	        return redirect()->route('admin.dashboard')->with('error', 'Anda tidak dapat menghapus akun admin Anda sendiri.'); 
5	    } 
6	    $user->delete(); 
7	    return redirect()->route('admin.dashboard')->with('status', 'Pengguna berhasil dihapus.'); 
8	} 

Segmen 4.14 menunjukkan metode deleteUser() di dalam `AdminController`. Terdapat logika pengaman penting yang mencegah admin untuk tidak sengaja menghapus akun miliknya sendiri yang sedang aktif digunakan untuk login.

4.1.3.14b Halaman Manajemen Basis Pengetahuan (Knowledge Base) 
Administrator diberikan otoritas untuk mengelola dokumen basis pengetahuan (Knowledge Base) guna meningkatkan kecerdasan chatbot dan referensi teknisi. Halaman ini menyediakan antarmuka untuk membuat data baru, memperbarui konten, serta mengaktifkan atau menonaktifkan artikel.

Segmen 4.14b Logika Penyimpanan Data Knowledge Base Baru
1	public function store(Request $request): RedirectResponse 
2	{ 
3	    $validated = $request->validate([ 
4	        'title'        => 'required|string|max:255', 
5	        'category'     => 'required|in:' . implode(',', array_keys(KnowledgeBase::CATEGORIES)), 
6	        'keywords'     => 'required|string|max:1000', 
7	        'content'      => 'required|string', 
8	        'access_level' => 'required|in:' . implode(',', array_keys(KnowledgeBase::ACCESS_LEVELS)), 
9	        'is_active'    => 'sometimes|boolean', 
10	    ]); 
11	    $validated['is_active']   = $request->boolean('is_active', true); 
12	    $validated['created_by']  = auth()->id(); 
13	    $validated['updated_by']  = auth()->id(); 
14	    $knowledge = KnowledgeBase::create($validated); 
15	    KnowledgeBaseLog::create([ 
16	        'knowledge_base_id' => $knowledge->id, 
17	        'user_id'           => auth()->id(), 
18	        'action'            => 'create', 
19	        'new_data'          => $knowledge->toArray(), 
20	    ]); 
21	    return redirect()->route('admin.knowledge-base.index')->with('status', 'Data knowledge berhasil ditambahkan.'); 
22	}

Segmen 4.14b di atas menunjukkan fungsi `store` pada `KnowledgeBaseController`. Validasi `'in:'` digunakan untuk menjamin agar inputan kategori dan level akses sesuai dengan konstanta yang didefinisikan pada model `KnowledgeBase`. Sistem juga secara otomatis mencatat riwayat penambahan dokumen tersebut ke dalam tabel `knowledge_base_logs` untuk pelacakan aktivitas administratif.

4.1.3.15 Halaman Laporan & Statistik Kinerja 
 
Gambar 4.23 Halaman Laporan
Halaman laporan pada Gambar 4.23 membantu admin menganalisis kinerja helpdesk. Halaman ini memuat visualisasi statistik kinerja teknisi (jumlah tiket yang ditugaskan, diselesaikan, dan diproses), tren jumlah tiket bulanan selama 6 bulan terakhir, serta tabel kueri tiket terfilter yang dapat dicetak atau diekspor.
Segmen 4.15 Agregasi Kinerja Bulanan dan Teknisi
1	$supportStaff = User::where('role', 'support')->get()->map(function ($staff) { 
2	    $staff->assigned_count = Ticket::where('assigned_to', $staff->id)->count(); 
3	    $staff->resolved_count = Ticket::where('assigned_to', $staff->id)->whereIn('status', ['resolved', 'closed'])->count(); 
4	    return $staff; 
5	}); 
6	$monthlyData = []; 
7	for ($i = 5; $i >= 0; $i--) { 
8	    $date = Carbon::now()->subMonths($i); 
9	    $monthlyData[] = [ 
10	        'month' => $date->translatedFormat('M Y'), 
11	        'total' => Ticket::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count(), 
12	    ]; 
13	} 

Segmen 4.15 merupakan logika pengolahan data laporan pada `ReportController`. Fungsi memetakan daftar staf support menggunakan penambahan atribut kustom (`assigned_count`, `resolved_count`) serta mengumpulkan data kuantitatif bulanan menggunakan perulangan Carbon untuk disajikan dalam bentuk grafik tren bulanan.
4.2 Pengujian Black Box
Pengujian Black Box dilakukan untuk menguji fungsionalitas sistem berdasarkan masukan dan keluaran yang dihasilkan tanpa memperhatikan struktur kode program. Pengujian ini bertujuan untuk memastikan bahwa seluruh fitur pada Sistem Helpdesk Chatbot AI dapat berjalan sesuai dengan kebutuhan pengguna.
4.2.1 Hasil Pengujian Black Box
Tabel 4.1 Hasil Pengujian Black Box Sistem Helpdesk Chatbot AI
ID Test	Skenario Pengujian	Hasil yang Diharapkan (Expected Result)	Hasil Aktual	Kesimpulan
TC-01	Login dengan email dan password yang valid	Sistem berhasil melakukan autentikasi dan mengarahkan pengguna ke dashboard sesuai role (user, teknisi, atau admin).	Sesuai dengan yang diharapkan.	Valid
TC-02	Login dengan kredensial salah atau tidak terdaftar	Sistem menolak akses dan menampilkan pesan kesalahan login.	Sesuai dengan yang diharapkan.	Valid
TC-03	User mengajukan tiket baru secara manual	Sistem menyimpan tiket ke database dengan status open dan prioritas default low.	Sesuai dengan yang diharapkan.	Valid
TC-04	User berinteraksi dengan Chatbot AI mengenai masalah IT	Chatbot memberikan respons yang relevan sesuai pertanyaan pengguna.	Sesuai dengan yang diharapkan.	Valid
TC-05	User membuat tiket otomatis dari hasil analisis chatbot	Sistem mengisi form tiket secara otomatis berdasarkan hasil percakapan.	Sesuai dengan yang diharapkan.	Valid
TC-06	User mengirim pesan diskusi pada tiket	Pesan tersimpan dan ditampilkan pada halaman detail tiket.	Sesuai dengan yang diharapkan.	Valid
TC-07	Teknisi mengambil tiket masuk (self-assign)	Sistem menetapkan teknisi sebagai penanggung jawab tiket dan mengubah status menjadi progress.	Sesuai dengan yang diharapkan.	Valid
TC-08	Teknisi melihat rekomendasi solusi dari AI	Sistem menampilkan ringkasan masalah, penyebab, dan rekomendasi solusi.	Sesuai dengan yang diharapkan.	Valid
TC-09	Teknisi menyelesaikan tiket	Sistem menyimpan status resolved dan menghasilkan ringkasan penyelesaian otomatis.	Sesuai dengan yang diharapkan.	Valid
TC-10	Admin mengubah role pengguna	Sistem memperbarui hak akses pengguna sesuai role baru.	Sesuai dengan yang diharapkan.	Valid
TC-11	Admin menghapus akun pengguna	Sistem menghapus akun pengguna tanpa memengaruhi data tiket yang sudah ada.	Sesuai dengan yang diharapkan.	Valid
4.2.2 Analisis Hasil Pengujian
Berdasarkan hasil pengujian Black Box yang telah dilakukan terhadap 11 skenario pengujian, seluruh fungsi sistem dapat berjalan sesuai dengan kebutuhan yang telah ditentukan. Fitur autentikasi berhasil memvalidasi pengguna berdasarkan kredensial dan hak akses masing-masing. Modul pengelolaan tiket memungkinkan pengguna membuat tiket secara manual maupun melalui hasil analisis chatbot AI.
Selain itu, fitur chatbot AI mampu memberikan bantuan awal terkait permasalahan teknologi informasi serta menghasilkan draf tiket secara otomatis. Pada sisi teknisi, sistem berhasil mendukung proses penanganan tiket mulai dari pengambilan tiket, pemberian rekomendasi solusi berbasis AI, hingga penyelesaian tiket. Sementara itu, administrator dapat mengelola pengguna dan hak akses sistem dengan baik.
4.2.3 Rekapitulasi Hasil Pengujian
Tabel 4.2 Rekapitulasi Hasil Pengujian Black Box
No	Keterangan	Jumlah
1	Total Skenario Pengujian	11
2	Skenario Berhasil (Valid)	11
3	Skenario Gagal (Tidak Valid)	0
4	Persentase Keberhasilan	100%
Berdasarkan rekapitulasi pengujian, seluruh skenario pengujian memperoleh hasil valid dengan tingkat keberhasilan sebesar 100%. Hasil tersebut menunjukkan bahwa Sistem Helpdesk Chatbot AI telah memenuhi kebutuhan fungsional yang dirancang dan dapat digunakan sesuai tujuan penelitian.

4.3 Pembahasan
Pembahasan hasil penelitian ini difokuskan pada analisis efektivitas implementasi Sistem Helpdesk Chatbot AI berbasis web dan kontribusinya terhadap peningkatan efisiensi penanganan kendala IT di lingkungan instansi/organisasi. Analisis dilakukan dengan menghubungkan hasil pengujian Black Box dan User Acceptance Test (UAT) dengan teori serta tujuan perancangan sistem.
4.3.1 Analisis Fungsionalitas Sistem (Black Box)
Berdasarkan hasil pengujian Black Box yang ditunjukkan pada sub-bab sebelumnya, persentase keberhasilan sistem mencapai 100% (11 skenario valid dari total 11 skenario uji). Hasil ini menunjukkan bahwa:
1. Logika otorisasi multi-role (User, Support, Admin) telah terimplementasi dengan aman. Pengguna dialihkan ke rute dashboard masing-masing secara otomatis pasca-autentikasi.
2. Relasi basis data berjalan stabil, terutama penanganan penghapusan data pengguna (User Deletion) di mana sistem menerapkan foreign key nullable pada kolom user_id di tabel tickets, sehingga riwayat laporan tiket tetap terjaga meskipun akun pelapor dihapus.
3. Penanganan integrasi eksternal (API OpenRouter) telah dilengkapi dengan mekanisme error handling yang andal. Jika API Gemini/OpenRouter mengalami gangguan koneksi, sistem pertama-tama akan mencari jawaban yang relevan di dalam basis pengetahuan lokal (Knowledge Base) aplikasi secara offline. Jika tidak ditemukan, sistem akan secara dinamis beralih ke pencocokan kata kunci terprogram (Regular Expression/Regex) untuk tetap dapat memberikan respon operasional dasar secara instan kepada pengguna.
4.3.2 Analisis Pengelolaan Data dan Transparansi Sistem
Sistem helpdesk yang dikembangkan menerapkan prinsip transparansi dan keterlacakan data secara menyeluruh di setiap lapisan proses. Setiap perubahan status tiket (open, progress, resolved, closed) dicatat secara otomatis ke dalam tabel ticket_histories sebagai log audit yang dapat digunakan untuk melacak kinerja teknisi dan waktu respons penanganan. Selain itu, setiap penambahan atau pembaruan dokumen pada basis pengetahuan (Knowledge Base) oleh administrator juga dicatat secara rinci ke dalam tabel knowledge_base_logs yang memuat informasi aksi, data sebelum perubahan, dan data setelah perubahan. Mekanisme pencatatan ini mendukung akuntabilitas pengelolaan sistem secara menyeluruh dan memudahkan proses audit di masa mendatang.
4.3.3 Kontribusi Fitur Kecerdasan Buatan (AI)
Penerapan model AI melalui OpenRouter memberikan dampak signifikan pada siklus hidup helpdesk di empat aspek utama:
1. Triage Otomatis (First-Level Support): Chatbot AI mampu menangani kendala IT umum pengguna secara mandiri 24/7. Hal ini mereduksi beban kerja teknisi agar dapat berfokus pada masalah hardware/jaringan yang lebih kritis di lapangan.
2. Rekomendasi Kasus Serupa: Fitur pencarian semantik berbasis AI membantu teknisi menemukan hingga tiga tiket lama yang sudah diselesaikan (resolved/closed) dengan permasalahan yang mirip secara kontekstual. Rekomendasi ini disertai penilaian tingkat kemiripan (Tinggi/Sedang) serta alasan teknis relevansinya, sehingga teknisi tidak perlu mencari secara manual di seluruh riwayat basis data.
3. Standardisasi Dokumentasi (Resolution Summary): Ketika tiket diselesaikan (resolved/closed), AI secara otomatis merangkum riwayat obrolan dan catatan perbaikan teknisi menjadi format laporan yang seragam (Masalah, Penyebab, Solusi, Status). Ringkasan ini tersimpan di kolom resolution_summary tiket dan menjadi sumber data referensi bagi fitur pencarian kasus serupa untuk tiket-tiket berikutnya.
4. Efisiensi Waktu Penanganan: Integrasi fitur analisis draf tiket otomatis dari obrolan chatbot mempercepat proses pelaporan tiket oleh pengguna tanpa perlu mengisi formulir panjang secara manual dari awal. Sistem secara otomatis mengisi judul, kategori, deskripsi, prioritas, hingga rekomendasi penanganan awal berdasarkan konteks percakapan yang telah berlangsung.
 


DAFTAR PUSTAKA

Alfauzain, A., Wijayanto, T., Srimayarti, B. N., Novita, D., Zulfatly, Z., Lismanto, P., & Rafeta, N. T. (2022). Sosialisasi Penerapan Sistem Helpdesk Ticketing Berbasis Web dalam Penanganan Keluhan Layanan di Rumah Sakit Ibu dan Anak Mutiara Bunda Padang. Jurnal Abdidas, 2(6), 1479-1486. https://doi.org/10.31004/abdidas.v2i6.528

Aris, A. (2020). Perancangan Aplikasi Helpdesk Ticketing dengan Penerapan Algoritma Forward Chaining (Studi Kasus: PT Idemas Solusindo Sentosa). Jurnal SIMETRIS, 11(2), 445-454. https://doi.org/10.24176/simet.v11i2.4267

Bhuthada, P., Bhutada, P., Kari, V., & Sridhar, P. (2023). A Comprehensive Survey on Chatbot Systems: AI Versus Rule-Based Approaches. International Journal of Advanced Computer Science and Applications, 14(3), 261-270. https://doi.org/10.14569/IJACSA.2023.0140328

Chanchad, J., Hongsakulvasu, N., & Techasan, P. (2023). Development of IT Helpdesk Ticketing System with Priority Classification Using Machine Learning. Journal of Information Technology and Computer Science, 8(2), 89-102. https://doi.org/10.25126/jitecs.20238296

Dam, H. Q., Neupane, B., Nkemdirim, O., & Truong, H. (2024). Challenges and Opportunities of Large Language Models in Low-Resource Settings. arXiv preprint arXiv:2404.02538. https://doi.org/10.48550/arXiv.2404.02538

Dennis, A., Wixom, B. H., & Tegarden, D. (2015). Systems Analysis and Design: An Object-Oriented Approach with UML (5th ed.). John Wiley & Sons.

Faulina, R. (2023). Analisis Pemodelan Sistem Menggunakan Unified Modeling Language (UML) pada Sistem Informasi. Jurnal Teknologi dan Manajemen Informatika, 9(1), 1-9. https://doi.org/10.26905/jtmi.v9i1.8821

Febriansyah, M. R., & Hertantyo, E. (2025). Implementasi Chatbot sebagai Virtual Assistant: Systematic Literature Review. Jurnal Ilmiah Informatika Komputer, 30(1), 55-66. https://doi.org/10.35760/ik.2025.v30i1.7892

Fitrahriansyah, F., & Jaman, A. (2022). Pemanfaatan Application Programming Interface (API) pada Aplikasi Layanan Jasa Perbaikan Kendaraan Bermotor. Jurnal Ilmiah Rekayasa dan Manajemen Sistem Informasi, 8(2), 211-218. https://doi.org/10.20414/jrmsi.v8i2.6134

Gadkari, A., Patil, A., & Sharma, V. (2025). Design and Development of Web-Based IT Helpdesk Ticketing System for Organizational Support. International Journal of Computer Applications, 187(1), 1-6. https://doi.org/10.5120/ijca2025924781

Gupta, S., & Gupta, A. (2022). Natural Language Processing for Chatbot Development: A Systematic Review. Journal of Physics: Conference Series, 2236(1), 012042. https://doi.org/10.1088/1742-6596/2236/1/012042

Jadhav, V., Shrivastava, A., & Deokar, S. (2022). AI-Powered Chatbots: An Analysis of Technologies and Applications for Customer Service. International Journal of Engineering Research & Technology, 11(4), 18-23. https://doi.org/10.17577/IJERTV11IS040136

Kim, T. (2023). Artificial Intelligence Integration in Digital Service Platforms: Challenges and Opportunities. IEEE Access, 11, 34521-34535. https://doi.org/10.1109/ACCESS.2023.3271894

Kumar, R., Singh, A., & Verma, N. (2023). Modern Web-Based IT Helpdesk Management System: Design and Implementation. International Journal of Engineering Research and Technology, 12(5), 1023-1030. https://doi.org/10.17577/IJERTV12IS050234

Kurniawan, T. A. (2018). Pemodelan Use Case (UML): Evaluasi Terhadap Beberapa Kesalahan dalam Praktik. Jurnal Teknologi Informasi dan Ilmu Komputer, 5(1), 77-86. https://doi.org/10.25126/jtiik.201851610

Lim, T. M., & Gunasinghe, D. S. (2021). Artificial Intelligence and Machine Learning: Concepts, Applications, and Future Prospects. International Journal of Advanced Computer Science and Applications, 12(8), 1-10. https://doi.org/10.14569/IJACSA.2021.0120801

Ma, C., Wang, J., & Zhang, L. (2023). Security Analysis of APIs in Modern Web Applications: Challenges and Best Practices. IEEE Transactions on Dependable and Secure Computing, 20(3), 1850-1862. https://doi.org/10.1109/TDSC.2023.3258701

Mohammed Mudassir, G., & Mohammed Mushtaq, A. (2024). Comparative Analysis of REST API and GraphQL in Modern Web Architecture. International Journal of Computer Trends and Technology, 72(2), 22-29. https://doi.org/10.14445/22312803/IJCTT-V72I2P104

Nze, I. C. (2024). Integration of AI Chatbot in Digital Service Delivery: Opportunities and Challenges. International Journal of Computer Science and Technology, 5(1), 1-10. https://doi.org/10.47191/ijcst/v5-i1-01

Park, J., Lee, H., & Kim, S. (2025). Scalable API Architecture Design for Modern Web Applications. ACM Transactions on Internet Technology, 25(1), 1-28. https://doi.org/10.1145/3648433

Putra, D. A., Nugroho, A. S., & Sari, D. R. (2022). Implementation of Chatbot Customer Service Features on PT Dian Prima Jayaraya Using Dialogflow. Journal of Applied Informatics and Computing, 6(1), 21-30. https://doi.org/10.30871/jaic.v6i1.3562

Qazi, S. (2023). API Design Patterns: A Comparative Study of REST and GraphQL. International Journal of Software Engineering and Computer Systems, 9(1), 81-93. https://doi.org/10.15282/ijsecs.9.1.2023.7.0112

Rahman, M. M., & Mehnaz, S. (2024). Ethical Implications of Artificial Intelligence in Society: A Comprehensive Review. Heliyon, 10(3), e25253. https://doi.org/10.1016/j.heliyon.2024.e25253

Sari, D. N. (2024). Implementasi Gemini API untuk Generatif Teks Deskripsi Karya Otomatis dalam Aplikasi Pameran Berbasis Web dengan Metode Waterfall. Jurnal Pengembangan Teknologi Informasi dan Ilmu Komputer, 8(2), 1205-1213. https://j-ptiik.ub.ac.id/index.php/j-ptiik/article/view/13254

Satzinger, J. W., Jackson, R. B., & Burd, S. D. (2016). Systems Analysis and Design in a Changing World (7th ed.). Cengage Learning.

Shah, R., Maheshwari, K., & Patel, H. (2023). A Survey on Challenges in Chatbot Development and Deployment. Expert Systems with Applications, 228, 120352. https://doi.org/10.1016/j.eswa.2023.120352

Sibero, A. F. K. (2013). Web Programming Power Pack. MediaKom.

Suta, P., Lua, S., Wangsuk, B., & Thipsanthia, P. (2020). An Overview of Machine Learning in Chatbots. International Journal of Computer Science and Information Security, 18(10), 1-6. https://doi.org/10.5281/zenodo.4106870

TechTarget. (2020). What is a use case diagram? TechTarget. Diakses dari https://www.techtarget.com/searchsoftwarequality/definition/use-case-diagram

Tri Toto Wiharjianto, Hendrawan, A., & Amrillah, M. F. (2024). Implementasi REST API dan Yellow.AI untuk Mengurangi Jumlah Trouble Ticket Data Rekening yang Berulang dengan Chatbot TBIG Olive. Journal of Information System, 10(1), 88-97. https://doi.org/10.21512/jis.v10i1.9876

Wahid, A., Heriyanto, R., & Arfan, M. (2024). Implementasi Chatbot Berbasis Natural Language Processing pada Web LPPMB di UNIQHBA. Jurnal Informatika, 11(1), 45-54. https://doi.org/10.31294/ji.v11i1.17342

Wardhani, R., Destiana, H., & Suryani, E. (2020). Perancangan dan Implementasi Sistem Helpdesk Ticketing Berbasis Web. Jurnal SISFOKOM, 9(3), 67-78. https://doi.org/10.32736/sisfokom.v9i3.890

Wildan, M. (2022). Perancangan Sistem Ticketing Helpdesk pada PT Arthatech Selaras Berbasis Web. Jurnal Rekayasa Informasi, 11(2), 123-132. https://doi.org/10.31294/jri.v11i2.13564
