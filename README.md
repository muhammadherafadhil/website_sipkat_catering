Product Requirements Document (PRD)
Sistem Informasi Pemesanan Katering Berbasis Web Menggunakan Framework Laravel untuk Mempermudah Pengelolaan Pesanan dan Transaksi Pelanggan
Informasi
Komponen	Keterangan
Nama Produk	Sistem Informasi Pemesanan Katering Berbasis Web (SIPKAT)
Jenis Proyek	Pengembangan website
Framework dan Bahasa	Laravel dan PHP
Basis Data	MySQL
Antarmuka	HTML, CSS, JavaScript, Tailwind (website responsif)
Pengguna	Administrator dan Pelanggan

Bab 1. Pendahuluan
1.1 Latar Belakang
Usaha katering mengelola menu makanan, penerimaan pesanan, pencatatan transaksi, konfirmasi pembayaran, dan penyelesaian pesanan. Bila dilakukan manual, informasi menu, jumlah pesanan, harga, jadwal, dan status pembayaran tersebar di berbagai media pencatatan, sehingga pengelola sulit memantau pesanan, memeriksa transaksi, dan menyusun laporan penjualan. Pelanggan pun harus berulang kali menanyakan ketersediaan menu, harga, dan perkembangan pesanan.
SIPKAT dikembangkan untuk menyediakan informasi menu, memfasilitasi pemesanan, menghitung total biaya otomatis, mencatat pembayaran, memantau status pesanan, dan membantu administrator mengelola data serta laporan transaksi. Laravel dipilih karena mendukung arsitektur website terstruktur, pengelolaan basis data, validasi masukan, autentikasi, dan pengembangan fitur CRUD (Create, Read, Update, Delete).

1.2 Identifikasi Masalah
1.	Pengelolaan menu dan harga memerlukan pencatatan terstruktur agar informasi untuk pelanggan sesuai dengan data yang dikelola.
2.	Pencatatan pesanan manual berpotensi salah pada jumlah, harga, jadwal, dan data pelanggan.
3.	Perhitungan total biaya perlu konsisten berdasarkan menu, kuantitas, dan biaya pengiriman.
4.	Status pesanan dan pembayaran perlu dikelola agar administrator dan pelanggan mengetahui perkembangan pesanan.
5.	Pencatatan transaksi dan laporan penjualan membutuhkan data yang terorganisasi dan dapat ditelusuri.

1.3 Rumusan Masalah
1.	Bagaimana merancang dan membangun sistem informasi pemesanan katering berbasis web menggunakan Laravel?
2.	Bagaimana menerapkan pengelolaan menu, pemesanan, dan perhitungan total biaya secara terstruktur?
3.	Bagaimana membangun pencatatan pembayaran dan pengelolaan status pesanan?
4.	Bagaimana menyediakan laporan transaksi berdasarkan periode untuk memantau penjualan?
5.	Bagaimana menguji fungsi sistem agar sesuai dengan kebutuhan yang ditetapkan?

1.4 Tujuan Pengembangan
1.	Menghasilkan website pemesanan katering berbasis web dengan Laravel.
2.	Menyediakan pengelolaan kategori menu, menu, harga, dan ketersediaan.
3.	Memfasilitasi pelanggan melihat menu dan memesan melalui website.
4.	Mengotomatisasi perhitungan total biaya berdasarkan rincian pesanan.
5.	Menyediakan pencatatan dan verifikasi pembayaran serta pembaruan status pesanan.
6.	Menyediakan laporan transaksi berdasarkan periode.

1.5 Manfaat Pengembangan
Pihak	Manfaat
Pengelola katering	Mengelola menu dan harga, mencatat pesanan, memantau pembayaran dan status, serta menyusun laporan penjualan dari data transaksi
Pelanggan	Melihat menu dan harga, memesan melalui website, memeriksa rincian dan total biaya, memantau status pesanan, dan melihat riwayat pemesanan
Pengembang	Menerapkan Laravel, CRUD, autentikasi, validasi, relasi basis data, pemisahan hak akses, dan pengujian web.

1.6 Batasan Masalah
1.	Sistem berupa website berbasis Laravel (PHP) dengan basis data MySQL.
2.	Terdapat dua peran: administrator dan pelanggan.
3.	Administrator mengelola kategori, menu, pesanan, pembayaran, status pesanan, dan laporan.
4.	Pelanggan melihat menu, mengelola akun, membuat pesanan, membayar, dan memantau status pesanan.
5.	Pembayaran bersifat manual (transfer bank dan atau tunai) verifikasi dilakukan administrator.
6.	Tidak ada payment gateway, integrasi kurir eksternal, aplikasi mobile native, maupun fitur kecerdasan buatan.
7.	Pengiriman dikelola melalui alamat dan jadwal yang dicatat pada pesanan, dengan biaya pengiriman tetap yang ditetapkan pengelola.
8.	Diskon, promo, ekspor laporan PDF atau Excel, dan notifikasi 
9.	Pengujian difokuskan pada fungsi, validasi, hak akses, dan konsistensi data.

Bab 2. Gambaran Umum Produk
2.1 Deskripsi Produk
SIPKAT menghubungkan pengelolaan katering oleh administrator dengan pemesanan oleh pelanggan. Pelanggan melihat katalog, memilih menu dan jumlah, mengisi alamat dan jadwal, lalu mengirim pesanan sistem menghitung total biaya dari rincian pesanan. Administrator mengelola menu dan kategori, memeriksa dan mengonfirmasi pesanan, memverifikasi pembayaran, memperbarui status, dan melihat laporan. Seluruh data disimpan dalam basis data sehingga pesanan, pembayaran, dan perubahan status dapat ditelusuri.

2.2 Nilai Utama
Kemudahan pemesanan : Pelanggan memesan melalui antarmuka web
Keteraturan data : Menu, pelanggan, pesanan, dan pembayaran tersimpan dalam basis data
Konsistensi perhitungan : Total dihitung sistem berdasarkan rincian pesanan
Transparansi status	: Pelanggan memantau status pesanan melalui akun masing-masing
Kemudahan pemantauan : Administrator memeriksa pesanan dan pembayaran melalui dashboard
Ketersediaan laporan : Transaksi dirangkum berdasarkan periode

2.3 Asumsi
1.	Usaha katering memiliki daftar menu, harga, dan informasi ketersediaan produk.
2.	Administrator bertanggung jawab atas pengelolaan data dan verifikasi transaksi.
3.	Pelanggan memiliki perangkat yang dapat membuka website dan mengisi data dengan benar.
4.	Kebijakan batas waktu pemesanan, biaya pengiriman, dan kemampuan memenuhi pesanan ditetapkan pengelola.
5.	Pembayaran dinyatakan lunas hanya setelah diperiksa administrator.


2.4 Pemangku Kepentingan
Pemangku kepentingan dalam sistem ini terdiri atas pemilik atau pengelola katering yang menentukan kebutuhan operasional dan kebijakan pemesanan, administrator yang mengelola data, pesanan, pembayaran, dan laporan, serta pelanggan yang melihat menu, memesan, dan memantau transaksi.

Bab 3. Pengguna dan Hak Akses
Pengaturan hak akses diterapkan di sisi server, bukan hanya dengan menyembunyikan tombol atau menu. Akun administrator dibuat melalui proses yang dikendalikan pengelola, bukan melalui registrasi publik. Administrator dan pelanggan sama-sama dapat melihat beranda, katalog, dan detail menu serta melakukan login dan logout. Pelanggan dapat melakukan registrasi akun, membuat pesanan, melihat pesanan milik sendiri, melaporkan pembayaran, membatalkan pesanan sendiri sesuai ketentuan pada Bab 5, dan memantau status pesanan. Administrator dapat mengelola kategori dan menu, melihat daftar pelanggan, melihat seluruh pesanan, mengonfirmasi atau menolak pesanan, memperbarui status pesanan, memverifikasi pembayaran, serta melihat dashboard dan laporan transaksi. Administrator tidak membuat pesanan dan tidak melaporkan pembayaran, sedangkan pelanggan tidak mengelola kategori dan menu, tidak melihat daftar pelanggan, tidak melihat seluruh pesanan, tidak mengonfirmasi atau menolak pesanan, tidak memperbarui status pesanan, dan tidak memverifikasi pembayaran.

Bab 4. Ruang Lingkup Fitur
4.1 Fitur Pelanggan
Pelanggan memiliki fitur beranda yang menampilkan identitas usaha, navigasi, informasi singkat layanan, menu unggulan, tombol menuju katalog, dan kontak. Pelanggan dapat melihat katalog dan detail menu yang memuat nama, foto bila ada, deskripsi, kategori, harga, dan ketersediaan, di mana menu nonaktif atau tidak tersedia tidak dapat dipesan. Pelanggan dapat melakukan registrasi dan login dengan data nama, email, nomor telepon, serta kata sandi dan konfirmasinya yang disimpan dalam bentuk hash, dan pelanggan harus login sebelum memesan. Pelanggan dapat membuat pesanan dengan memilih satu atau beberapa menu beserta jumlahnya, mengisi nama dan telepon penerima, alamat, jadwal, catatan, dan metode pembayaran, kemudian memeriksa ringkasan dan total biaya sebelum pesanan disimpan. Pelanggan dapat melihat riwayat dan detail pesanan yang memuat nomor pesanan, tanggal pemesanan dan jadwal, rincian menu, total biaya, status pesanan dan pembayaran, serta riwayat status, namun hanya untuk pesanan miliknya sendiri. Pelanggan dapat melaporkan pembayaran dengan metode, nominal, dan catatan, di mana status baru berubah setelah administrator memeriksa. Pelanggan juga dapat membatalkan pesanan, tetapi hanya untuk pesanan berstatus Menunggu Konfirmasi, dan riwayat pesanan tidak dihapus.

4.2 Fitur Administrator
Administrator memiliki dashboard yang menampilkan jumlah pesanan menurut status, transaksi belum lunas, total pembayaran terverifikasi, dan pesanan terbaru, di mana semua nilai dihitung dari basis data. Administrator dapat menambah, melihat, mengubah, dan menonaktifkan kategori, serta kategori yang dipakai menu tidak dihapus permanen. Administrator dapat melakukan CRUD menu yang mencakup nama, kategori, deskripsi, harga, foto, dan ketersediaan, di mana menu yang sudah dipakai transaksi dinonaktifkan dan bukan dihapus. Administrator dapat melihat daftar, detail, mengonfirmasi, menolak dengan alasan, memperbarui status, dan melihat riwayat status pesanan. Administrator dapat melihat pembayaran yang dilaporkan, memverifikasi atau menolaknya dengan alasan, dan melihat riwayat pembayaran. Administrator dapat melihat daftar pelanggan yang memuat nama, email, telepon, dan tanggal registrasi, di mana kata sandi tidak pernah ditampilkan. Administrator dapat mengakses laporan transaksi dengan filter tanggal awal, tanggal akhir, dan status yang menampilkan nilai pesanan, pembayaran terverifikasi, dan sisa pembayaran, serta dapat dicetak melalui browser.


Bab 5. Alur Bisnis Sistem
5.1 Registrasi dan Login
1.	Pengguna membuka website dan, bila belum memiliki akun, mengisi formulir registrasi.
2.	Sistem memvalidasi data dan menyimpan akun dengan kata sandi ter-hash.
3.	Pengguna login dimana sistem memeriksa kredensial dan memberi akses sesuai peran.
4.	Bila kredensial tidak valid, sistem menampilkan pesan umum tanpa membocorkan informasi sensitif.

5.2 Pemesanan
1.	Pelanggan memilih menu yang tersedia dan menentukan jumlahnya, lalu login bila belum.
2.	Pelanggan mengisi data penerima, alamat, dan jadwal pesanan.
3.	Sistem memeriksa ketersediaan menu dan validitas jumlah, lalu menghitung subtotal dan total.
4.	Pelanggan memeriksa ringkasan dan mengonfirmasi pesanan.
5.	Sistem menyimpan pesanan dan rincian menu dalam satu transaksi basis data, membuat nomor pesanan unik, dan menetapkan dengan format ORD-YYYYMMDD-XXXX (contoh: ORD-20231025-0001, di mana XXXX adalah nomor urut harian) status awal Menunggu Konfirmasi.
6.	Administrator memeriksa pesanan lalu mengonfirmasi atau menolaknya dan pelanggan melihat hasilnya pada detail pesanan.

5.3 Pembayaran
1.	Pelanggan membuka detail pesanan, melihat total dan metode pembayaran, lalu membayar sesuai petunjuk.
2.	Pelanggan melaporkan pembayaran, sistem menyimpannya dengan status Menunggu Verifikasi.
3.	Administrator memeriksa pembayaran bila sesuai, pembayaran diverifikasi, bila tidak, ditolak beserta alasan.
4.	Sistem memperbarui status pembayaran pesanan berdasarkan jumlah pembayaran terverifikasi.

5.4 Status Pesanan
Alur utama status pesanan adalah Menunggu Konfirmasi, Dikonfirmasi, Diproses, Siap Dikirim, dan Selesai, dengan status tambahan Ditolak dan Dibatalkan. Status Menunggu Konfirmasi berarti pesanan diterima sistem dan menunggu pemeriksaan administrator, dan dapat berubah menjadi Dikonfirmasi, Ditolak, atau Dibatalkan. Status Dikonfirmasi berarti pesanan disetujui administrator dan dapat berubah menjadi Diproses. Status Diproses berarti pesanan sedang disiapkan dan dapat berubah menjadi Siap Dikirim. Status Siap Dikirim berarti pesanan siap diserahkan atau dikirim dan dapat berubah menjadi Selesai. Status Selesai berarti pesanan telah diterima pelanggan dan merupakan status akhir. Status Ditolak berarti pesanan tidak dapat dipenuhi dan merupakan status akhir. Status Dibatalkan berarti pesanan dibatalkan pelanggan sebelum dikonfirmasi dan merupakan status akhir. Setiap perubahan status dicatat dalam riwayat yang memuat status lama, status baru, waktu, dan pengguna, dan status pesanan tidak menunjukkan bahwa pembayaran lunas.

5.5 Laporan Transaksi
1.	Administrator memilih tanggal awal, tanggal akhir, dan filter status.
2.	Sistem memvalidasi rentang tanggal, mengambil data sesuai filter, dan menghitung ringkasan.
3.	Sistem menampilkan daftar transaksi dan ringkasan pihak administrator dapat mencetaknya melalui browser.

Bab 6. Kebutuhan Fungsional
Prioritas: Must = wajib, Should = dikerjakan bila waktu memungkinkan.
ID	Kebutuhan	Bagian	Prioritas
FR-01	Menampilkan halaman beranda	Umum	Must
FR-02	Menampilkan katalog menu aktif	Umum	Must
FR-03	Menampilkan detail menu	Umum	Must
FR-04	Registrasi pelanggan	Pelanggan	Must
FR-05	Login dan logout	Pengguna terdaftar	Must
FR-06	Pembatasan akses berdasarkan peran	Sistem	Must
FR-07	Mengelola kategori menu	Administrator	Must
FR-08	Mengelola data menu	Administrator	Must
FR-09	Membuat pesanan	Pelanggan	Must
FR-10	Menghitung subtotal dan total otomatis	Sistem	Must
FR-11	Membuat nomor pesanan unik	Sistem	Must
FR-12	Melihat detail dan riwayat pesanan sendiri	Pelanggan	Must
FR-13	Mencegah akses ke pesanan pelanggan lain	Sistem	Must
FR-14	Melihat dan memeriksa seluruh pesanan	Administrator	Must
FR-15	Mengonfirmasi atau menolak pesanan	Administrator	Must
FR-16	Melaporkan pembayaran	Pelanggan	Must
FR-17	Memverifikasi atau menolak pembayaran	Administrator	Must
FR-18	Memisahkan status pesanan dan status pembayaran	Sistem	Must
FR-19	Memperbarui status pesanan sesuai alur	Administrator	Must
FR-20	Menyimpan riwayat perubahan status	Sistem	Must
FR-21	Memantau status pesanan	Pelanggan	Must
FR-22	Laporan transaksi dengan filter periode	Administrator	Must
FR-23	Dashboard ringkasan	Administrator	Should
FR-24	Pembatalan pesanan oleh pelanggan	Pelanggan	Should
FR-25	Cetak laporan melalui browser	Administrator	Should
FR-26	Melihat daftar pelanggan	Administrator	Should
FR-27	Melampirkan bukti pembayaran berupa gambar	Pelanggan	Should
FR-28	Pencarian menu dan filter pesanan	Umum, Administrator	Should


Bab 7. Kebutuhan Nonfungsional
Dari aspek keamanan, sistem harus menyediakan autentikasi untuk halaman yang memerlukan akun, menyimpan kata sandi dalam bentuk hash dengan fasilitas Laravel, menerapkan otorisasi di sisi server, memproteksi formulir dengan CSRF, dan memvalidasi masukan di sisi server (NFR-01). Query harus memakai mekanisme aman framework, pelanggan tidak dapat mengakses data pelanggan lain, pesan kesalahan tidak menampilkan kredensial atau detail internal, dan berkas .env tidak masuk repositori publik (NFR-02). Gambar yang diunggah harus divalidasi jenis dan ukurannya, dan akun administrator tidak dapat dibuat melalui registrasi publik (NFR-03). Dari aspek kemudahan penggunaan, antarmuka harus berbahasa Indonesia, navigasi jelas, formulir berlabel, pesan sukses dan galat mudah dipahami, serta ringkasan pesanan menampilkan harga satuan, jumlah, subtotal, biaya pengiriman, dan total (NFR-04). Sistem harus responsif sehingga dapat digunakan pada komputer, tablet, dan ponsel, dengan tabel data yang dapat digulir horizontal pada layar kecil (NFR-05). Dari aspek kinerja, daftar menu, pesanan, dan pelanggan memakai pagination, gambar menu dibatasi ukurannya, total dihitung di server, dan sasaran awal halaman utama dimuat sekitar 3 detik pada lingkungan pengembangan lokal sebagai hasil yang dicatat dan bukan jaminan (NFR-06). Dari aspek keandalan data, pesanan wajib memiliki rincian menu valid, harga dan jumlah disimpan pada rincian pesanan sehingga perubahan harga menu tidak mengubah transaksi lama, dan pembayaran tidak boleh negatif atau melebihi sisa tagihan (NFR-07). Sistem harus berjalan pada browser modern dan diuji minimal pada Google Chrome atau Microsoft Edge (NFR-08). Dari aspek pemeliharaan, kode harus terstruktur mengikuti pola MVC Laravel, struktur tabel dikelola dengan migration, dan dokumentasi instalasi serta penggunaan disertakan (NFR-09).

Bab 8. Aturan Bisnis
ID	Aturan Bisnis
BR-01	Pelanggan harus memiliki akun dan login untuk membuat pesanan memakai email akun unik
BR-02	Setiap pengguna memiliki satu peran, dan hanya dapat menjalankan fitur sesuai perannya
BR-03	Menu harus memiliki nama, kategori, harga tidak negatif, dan status ketersediaan menu tidak tersedia tidak dapat dipesan
BR-04	Perubahan harga menu hanya dapat berlaku untuk pesanan baru pesanan lama menyimpan harga saat transaksi
BR-05	Pesanan memiliki minimal satu rincian menu, dengan jumlah berupa bilangan bulat positif
BR-06	Ketersediaan menu diperiksa ulang saat pesanan dikirim. Nomor pesanan harus unik dengan format ORD-YYYYMMDD-XXXX (contoh: ORD-20231025-0001).
BR-07	Total dihitung di sisi server harga dari browser tidak dipercaya
BR-08	Pesanan baru berstatus Menunggu Konfirmasi
BR-09	Perubahan status hanya mengikuti transisi pada Bab 5.4, dan setiap perubahan tercatat
BR-10	Ditolak, Dibatalkan, dan Selesai adalah status akhir
BR-11	Pelanggan hanya dapat membatalkan pesanan berstatus Menunggu Konfirmasi
BR-12	Pembayaran yang dilaporkan belum terverifikasi sampai diperiksa administrator
BR-13	Nominal pembayaran harus lebih dari nol dan pembayaran terverifikasi tidak melebihi sisa tagihan
BR-14	Status pembayaran: Belum Dibayar (belum ada pembayaran terverifikasi), Dibayar Sebagian (kurang dari total), Lunas (sama dengan total)

Perhitungan biaya: Biaya pengiriman bersifat tetap. Nilai biaya pengiriman ini disimpan dalam konfigurasi sistem (misalnya tabel settings atau variabel .env) sehingga administrator dapat mengubahnya di kedepannya tanpa perlu mengubah kode inti website.
Rumus perhitungan:
Subtotal = Σ(Harga Satuan x Jumlah)
Total pesanan = Subtotal + Biaya Pengiriman
Sisa Tagihan = Total pesanan – Σpembayaran terverifikasi
Sebagai contoh, Nasi Ayam berharga Rp20.000 dengan jumlah 10 menghasilkan subtotal Rp200.000, dan Nasi Ikan berharga Rp22.000 dengan jumlah 5 menghasilkan subtotal Rp110.000, sehingga subtotal keseluruhan Rp310.000; dengan biaya pengiriman Rp10.000, total pesanan menjadi Rp320.000.

Bab 9. Rancangan Basis Data
Basis data MySQL memakai relasi antartabel untuk menjaga konsistensi, dan setiap tabel memiliki kolom created_at dan updated_at bertipe TIMESTAMP. Tabel inti terdiri atas users, categories, menus, orders, order_items, payments, dan order_status_histories.

Tabel users memiliki kolom id sebagai primary key bertipe BIGINT UNSIGNED, name bertipe VARCHAR(255) untuk nama pengguna, email bertipe VARCHAR(255) yang unik, phone bertipe VARCHAR(20) untuk nomor telepon, password bertipe VARCHAR(255) untuk kata sandi ter-hash, dan role bertipe VARCHAR(20) yang bernilai admin atau customer.

Tabel categories memiliki kolom id sebagai primary key, name bertipe VARCHAR(100) untuk nama kategori, description bertipe TEXT yang boleh kosong, dan is_active bertipe BOOLEAN untuk status kategori.

Tabel menus memiliki kolom id sebagai primary key, category_id bertipe BIGINT UNSIGNED sebagai foreign key ke categories, name bertipe VARCHAR(150) untuk nama menu, description bertipe TEXT yang boleh kosong, price bertipe DECIMAL(12,2) untuk harga satuan, image bertipe VARCHAR(255) yang boleh kosong untuk lokasi gambar, dan is_available bertipe BOOLEAN untuk status ketersediaan.

Tabel orders memiliki kolom id sebagai primary key, order_number bertipe VARCHAR(30) yang unik untuk nomor pesanan, user_id bertipe BIGINT UNSIGNED sebagai foreign key ke users, recipient_name bertipe VARCHAR(150) untuk nama penerima, recipient_phone bertipe VARCHAR(20) untuk telepon penerima, delivery_address bertipe TEXT untuk alamat pengiriman, requested_delivery_at bertipe DATETIME untuk jadwal yang diminta, subtotal bertipe DECIMAL(12,2) untuk subtotal menu, delivery_fee bertipe DECIMAL(12,2) untuk biaya pengiriman, total_amount bertipe DECIMAL(12,2) untuk total pesanan, order_status bertipe VARCHAR(30) untuk status pesanan, notes bertipe TEXT yang boleh kosong untuk catatan pelanggan, dan rejection_reason bertipe TEXT yang boleh kosong untuk alasan penolakan.

Tabel order_items menyimpan menu_name dan unit_price sebagai snapshot agar transaksi lama tidak berubah ketika menu diperbarui. Tabel ini memiliki kolom id sebagai primary key, order_id sebagai foreign key ke orders, menu_id sebagai foreign key ke menus, menu_name bertipe VARCHAR(150) untuk nama menu saat dipesan, unit_price bertipe DECIMAL(12,2) untuk harga satuan saat dipesan, quantity bertipe INT UNSIGNED untuk jumlah, dan subtotal bertipe DECIMAL(12,2) yang merupakan hasil kali unit_price dengan quantity.

Tabel payments memungkinkan satu pesanan memiliki beberapa pembayaran, dengan status per catatan berupa Menunggu Verifikasi, Terverifikasi, atau Ditolak, sedangkan status keseluruhan pesanan (Belum Dibayar, Dibayar Sebagian, Lunas) dihitung dari total pembayaran terverifikasi. Tabel ini memiliki kolom id sebagai primary key, order_id sebagai foreign key ke orders, payment_method bertipe VARCHAR(30) untuk transfer bank atau tunai, amount bertipe DECIMAL(12,2) untuk jumlah pembayaran, proof_path bertipe VARCHAR(255) yang boleh kosong untuk lokasi bukti, payment_status bertipe VARCHAR(30) untuk status catatan pembayaran, verified_by bertipe BIGINT UNSIGNED yang boleh kosong sebagai foreign key ke users (administrator), verified_at bertipe DATETIME yang boleh kosong untuk waktu verifikasi, dan notes bertipe TEXT yang boleh kosong untuk catatan atau alasan penolakan.

Tabel order_status_histories memiliki kolom id sebagai primary key, order_id sebagai foreign key ke orders, changed_by bertipe BIGINT UNSIGNED yang boleh kosong sebagai foreign key ke users, old_status bertipe VARCHAR(30) yang boleh kosong untuk status sebelumnya, new_status bertipe VARCHAR(30) untuk status baru, dan notes bertipe TEXT yang boleh kosong untuk catatan perubahan.

Relasi antartabel mencakup users ke orders dengan kardinalitas 1:N, categories ke menus 1:N, orders ke order_items 1:N, menus ke order_items 1:N, orders ke payments 1:N, orders ke order_status_histories 1:N, users ke order_status_histories melalui changed_by 1:N, dan users ke payments melalui verified_by 1:N. Prinsip integritas data mencakup penerapan primary key dan foreign key pada setiap relasi, unique constraint pada email dan nomor pesanan, transaksi basis data saat menyimpan pesanan beserta rinciannya, penggunaan tipe DECIMAL untuk nilai uang, validasi agar jumlah menu dan nominal pembayaran tidak negatif, indeks pada nomor pesanan, pengguna, status, dan tanggal, serta penonaktifan (bukan penghapusan) data yang sudah dipakai transaksi.


Bab 10. Rancangan Antarmuka
Antarmuka SIPKAT dirancang sederhana, konsisten, responsif, berbahasa Indonesia, menonjolkan harga, jumlah, total, dan status, serta memisahkan tampilan pelanggan dan administrator. Pada area pelanggan, halaman beranda memuat navbar, pengenalan layanan, menu unggulan, tombol Lihat Menu, kontak, dan footer; halaman katalog dan detail menu memuat kartu menu dengan foto, nama, harga, dan ketersediaan, filter kategori, serta detail dengan deskripsi dan tombol Pesan; halaman registrasi dan login memuat formulir dengan pesan validasi dan tautan antarhalaman; halaman formulir pesanan memuat menu terpilih, jumlah, data penerima, alamat, jadwal, catatan, metode pembayaran, subtotal, biaya pengiriman, dan total; halaman riwayat dan detail pesanan memuat daftar pesanan, rincian menu, status pesanan dan pembayaran, riwayat status, formulir pembayaran, dan tombol pembatalan bila memenuhi ketentuan. Pada area administrator, halaman login dan dashboard memuat kartu ringkasan statistik dan pesanan terbaru; halaman kategori dan menu memuat tabel dengan tombol tambah, ubah, dan nonaktifkan; halaman pesanan dan detail pesanan memuat daftar dengan filter tanggal dan status serta detail berisi pelanggan, rincian menu, jadwal, alamat, status, dan riwayat; halaman pembayaran memuat catatan pembayaran, metode, jumlah, bukti bila ada, status, dan tombol verifikasi atau tolak; halaman laporan memuat filter periode, tabel transaksi, ringkasan, dan tombol cetak.



11.2 Arsitektur MVC
Dari sisi teknologi, backend menggunakan Laravel dan PHP untuk logika website, routing, autentikasi, dan pengelolaan data; basis data menggunakan MySQL untuk menyimpan akun, menu, pesanan, dan pembayaran; frontend menggunakan HTML, CSS, JavaScript, dan Bootstrap untuk struktur, tampilan, interaksi, dan antarmuka responsif; template menggunakan Blade untuk tampilan berbasis Laravel; dependensi dan versi dikelola dengan Composer dan Git untuk pengelolaan paket PHP dan riwayat kode; serta pengujian menggunakan PHPUnit atau Pest sesuai konfigurasi dan pengujian manual untuk menguji fungsi website.
Dari sisi arsitektur MVC, lapisan Model terdiri atas User, Category, Menu, Order, OrderItem, Payment, dan OrderStatusHistory; lapisan View berupa template Blade untuk antarmuka pelanggan dan administrator; dan lapisan Controller mencakup autentikasi, HomeController, MenuController, CategoryController, OrderController, PaymentController, DashboardController, dan ReportController, dengan nama yang dapat disesuaikan dengan konvensi implementasi. Routing dikelompokkan menjadi rute publik (beranda, katalog, detail menu, registrasi, login), rute pelanggan (pembuatan pesanan, riwayat, detail, pembayaran, pembatalan) yang memerlukan autentikasi, dan rute administrator yang dilindungi middleware autentikasi dan pemeriksaan peran.

Bab 12. Rencana Pengujian dan Kriteria Penerimaan
Pengujian meliputi aspek fungsional, validasi, hak akses, integrasi, dan konsistensi data, dengan kolom hasil aktual diisi berdasarkan pengujian nyata saat sistem dijalankan, dan sistem dinyatakan diterima bila seluruh skenario Must lulus. Pengujian TC-01 memastikan bahwa membuka beranda dan katalog menampilkan halaman dengan hanya menu aktif yang muncul (FR-01, FR-02). TC-02 memastikan registrasi dengan data valid menghasilkan akun pelanggan yang dibuat, sedangkan TC-03 memastikan registrasi dengan email yang sudah terdaftar ditolak dengan pesan sesuai (FR-04). TC-04 memastikan login dengan kredensial valid masuk sesuai peran, sedangkan TC-05 memastikan login dengan kata sandi salah ditolak dengan pesan umum (FR-05). TC-06 memastikan pelanggan yang membuka URL halaman administrator ditolak aksesnya (FR-06). TC-07 memastikan administrator yang menambah kategori menghasilkan kategori tersimpan dan tampil (FR-07). TC-08 memastikan administrator yang menambah menu valid menghasilkan menu tersimpan dan tampil di katalog, sedangkan TC-09 memastikan administrator yang memasukkan harga negatif ditolak (FR-08). TC-10 memastikan pelanggan yang memesan dua menu menghasilkan pesanan dan rincian tersimpan, total sesuai rumus, nomor unik, dan status Menunggu Konfirmasi (FR-09, FR-10, FR-11). TC-11 memastikan pemesanan dengan jumlah nol ditolak, dan TC-12 memastikan pemesanan menu yang tidak tersedia ditolak (FR-09). TC-13 memastikan bahwa harga menu yang diubah setelah pesanan dibuat tidak mengubah total pesanan lama (FR-10). TC-14 memastikan pelanggan yang membuka pesanan milik pelanggan lain ditolak aksesnya (FR-13). TC-15 memastikan administrator yang mengonfirmasi pesanan menghasilkan status Dikonfirmasi, riwayat tersimpan, dan terlihat oleh pelanggan (FR-15, FR-20, FR-21). TC-16 memastikan perubahan status dari Menunggu Konfirmasi ke Selesai ditolak (FR-19). TC-17 memastikan pelanggan yang melaporkan pembayaran lalu administrator memverifikasi menghasilkan status Menunggu Verifikasi yang kemudian berubah sesuai total terverifikasi (FR-16, FR-17, FR-18). TC-18 memastikan verifikasi pembayaran yang melebihi sisa tagihan ditolak (FR-17). TC-19 memastikan laporan dengan filter periode menampilkan data sesuai rentang dan rentang tanggal yang tidak valid ditolak (FR-22). TC-20 memastikan bahwa bila penyimpanan rincian gagal saat membuat pesanan, tidak ada pesanan tanpa rincian yang tersisa (FR-09, FR-10). TC-21 memastikan bahwa membuka website pada layar kecil tetap membuat antarmuka dapat digunakan (NFR-05).

Bab 13. Rencana Pengembangan
Jadwal pengembangan diperkirakan empat minggu, dengan fitur Must dikerjakan lebih dahulu sebelum fitur Should. Pada minggu pertama dilakukan analisis kebutuhan, perancangan basis data, alur sistem, dan antarmuka yang menghasilkan PRD dan rancangan antarmuka. Pada minggu kedua dilakukan inisialisasi Laravel, konfigurasi basis data, migration, autentikasi, hak akses, CRUD kategori dan menu, serta katalog yang menghasilkan modul dasar. Pada minggu ketiga dilakukan pengembangan pemesanan, perhitungan total, pembayaran, status pesanan, dan riwayat status yang menghasilkan modul transaksi. Pada minggu keempat dilakukan pengembangan laporan, fitur Should bila memungkinkan, pengujian, perbaikan, dokumentasi, dan persiapan demonstrasi sehingga website siap didemonstrasikan.

Bab 14. Risiko dan Mitigasi
RRisiko ruang lingkup yang terlalu luas dimitigasi dengan memprioritaskan fitur Must. Risiko kesalahan relasi basis data dimitigasi dengan merancang ERD dan migration sebelum implementasi. Risiko perhitungan total yang tidak sesuai dimitigasi dengan menghitung di server dan menguji skenario perhitungan. Risiko akses tanpa izin dimitigasi dengan autentikasi dan otorisasi di sisi server. Risiko perubahan harga yang mengubah transaksi lama dimitigasi dengan menyimpan harga snapshot pada rincian pesanan. Risiko pesanan tersimpan tanpa rincian dimitigasi dengan memakai transaksi basis data. Risiko status yang tidak sesuai alur dimitigasi dengan memvalidasi transisi status. Risiko perbedaan versi PHP dan Laravel dimitigasi dengan memastikan kompatibilitas sebelum instalasi.


