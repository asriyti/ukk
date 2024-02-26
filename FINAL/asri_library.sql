-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2024 at 07:36 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asri_library`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int(12) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `penerbit` varchar(255) DEFAULT NULL,
  `tahun_terbit` int(12) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `sinopsis` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `penerbit`, `tahun_terbit`, `gambar`, `sinopsis`) VALUES
(15, 'Filosofi Teras', 'jamal', 'joko', 1978, 'filosofi_teras_65bd1409f28b0.png', 'Filosofi Teras adalah sebuah buku pengantar filsafat Stoa yang dibuat khusus sebagai panduan moral anak muda. Buku ini ditulis untuk menjawab permasalahan tentang tingkat kekhawatiran yang cukup tinggi dalam skala nasional, terutama yang dialami oleh anak muda.'),
(16, 'Book Of Eli', 'puan', 'dxd', 2023, 'book_of_eli_65bd1465b984d.jpg', 'In a post-apocalyptic state, Eli comes across a ramshackle town on his journey westward. There, he meets Carnegie, a power-hungry man searching for a sacred book that Eli is tasked to protect.'),
(24, 'Ragasea', 'Devitnask', 'PT Kawah Media Pustaka', 2023, 'ragasea_65d5a2e79c88b.jpg', '\"Gue harus masuk ke tubuh itu! Please, Samu! Inget mantra yang pernah lo baca! Avodius! Ck, bukan lagi! Evenite? Salah! Intrare!\" - Samudra Osaka. Raga Alvarez adalah penguasa Rothy, si penyandang posisi pertama dari segala bidang akademis maupun nonakademis di sekolahnya. Tidak ada yang boleh mengalahkan ataupun menyainginya. Sebab, jika ada murid yang bisa mengungguli nilainya meski hanya sebesar 0,1, pemuda itu akan langsung menghabisi dan melenyapkan murid itu. Sampai suatu ketika, suatu peristiwa terjadi.'),
(30, 'Kamus Lengkap Bahasa Mandarin', 'Mandarin Club Jogja', 'Dunia Cerdas', 2023, 'k,hjnm_65d62b8c10f29.jpg', 'Bahasa Mandarin sendiri berasal dari bahasa suku Han, suku mayoritas di China (Republik Rakyat China). Aksara yang digunakan dalam bahasa ini disebut Hanzi. Usianya ribuan tahun. Tidak hanya itu, jumlahnya juga sangat banyak. Cara pengucapannya juga sangat menarik. Ada beberapa nada yang harus diperhatikan.Seiring dengan perkembangan pendidikan,'),
(32, 'Antariksa', 'Tresia', 'Coconut Books', 2022, 'antariksa_65d6b4d0cd5dd.jpg', '—Ketika senyumanmu menjadi tujuanku— Antariksa Sanjaya. Terkenal kejam dan tidak punya hati sudah menjadi makanan sehari-hari untuknya. Sebagai ketua geng di sekolah. Antariksa termasuk salah satu orang yang paling ditakuti. Antariksa bisa dijadikan sebagai tumpuan jika kalian bersikap baik kepadanya. Sebaliknya, ia bisa berubah menjadi.......'),
(33, 'Fisika Dasar', 'Tri Kuntoro P', 'Andi Yogyakarta', 2023, 'fisika_dasar_65d6b6017d537.jpg', 'Fisika dasar adalah mata kuliah yang termasuk ke dalam cabang ilmu pengetahuan alam, mata kuliah ini adalah salah satu mata kuliah dasar teknik. Materi mata kuliah fisika dasar terdiri dari besaran dan satuan, gerak relatif, dinamika benda titik, gerak rotasi, elastisitas dan osilasi, gravitasi, mekanika fluida, kalor, gelombang mekanik'),
(34, 'Kamus Bahasa Inggris-Indonesia', 'John & Hassan Sadily', 'Gramedia Pustaka Umum', 2022, 'kamus_bahasa_inggris-indonesia_65d6b6441d802.jpeg', 'Beberapa pembaharuan dalam Edisi yang Diperbarui (Updated Edition) ini antara lain adalah: - Label kelas kata diganti dengan singkatan umum dalam bahasa Inggris: kb (kata benda) n (noun), ks (kata sifat) adj (adjective), - Entri dan subentri dalam paparan dan pemakaian ditulis lengkap. - Jumlah entri dan subentri lebih dari 28.000.'),
(35, 'Timun Mas', 'Happy Holy Kids', 'Happy Holy Kids', 2024, 'timun_mas_65d6b68467dfe.jpg', 'Perjanjian yang terjalin antara Mbok Randa dan raksasa mengenai impian Mbok Randa yang menginginkan seorang anak. Atas perjanjian tersebut, lahirlah Timun Mas. Namun Mbok Randa mengingkari perjanjian tersebut karena tidak tega jika harus menyerahkan Timun Mas kepada raksasa.'),
(36, 'Kamus Besar Bahasa Indonesia', 'DRS.Suharso', 'Widya Karya', 2022, 'kamus_besar_bahasa_indonesia_65d6b6cd54acc.jpg', 'Disusun secara alfabetis atau sesuai abjad, sehingga pembaca dapat dengan mudah mencari kata atau istilah tertentu. Di dalamnya terdapat petunjuk pemakaian kamus sehingga dapat memudahkan pembaca memahami isi kamus dengan baik. Selain itu, terdapat pedoman umum mengenai ejaan bahasa Indonesia dan pembentukan istilah yang sangat bermanfaat bagi pembaca.'),
(37, 'Argantara', 'Falistiyana	', 'Galaxy', 2023, 'argantara_65d6b71c46a57.jpg', 'Perjodohan anak SMA. Arga yang masih berusia 18 tahun mau tidak mau harus memenuhi wasiat ayahnya untuk menikahi anak sahabatnya bernama Syera. Awalnya hubungan mereka didasari keterpaksaan. Namun, lama kelamaan Arga dan Syera mulai membuka hati satu sama lain dan mulai menerima perjodohan tersebut dengan senang hati.	'),
(38, 'Senang Sekolah', 'Raira Intanmanik', 'Muffin Graphics', 2024, 'senang_sekolah_65d6b7572d6b6.jpg', '	Akhir-akhir ini, Kaira malas banget pergi ke sekolah. Kaira bosan dengan rutinitas yang sama setiap harinya. Sampai-sampai, ia ingin cepat libur sekolah. Anehnya, saat libur semester, Kaira malah bersemangat untuk cepat-cepat masuk sekolah. Kenapa ya, Kaira berubah pikiran?'),
(40, 'Keong Mas', 'Solikhatul Fatonah K', 'Bhuana Ilmu Populer', 23, 'keong_mas_65d6b7c507e0a.jpg', 'Cerita rakyat Jawa Timur ini menceritakan tentang dua saudara perempuan dengan nasib yang berbeda, salah satunya memiliki mata hitam dan melakukan perbuatan jahat. Dalam cerita rakyat ini, akan mengajarkan anak untuk bersikap baik dan berbudi luhur. Dengan membacakan cerita rakyat ini, orang tua dapat memberitahukan nilai-nilai positif kepada anak.'),
(41, 'Dasar Logika Informatika', 'Maxrizal	', 'Mediacom', 2023, 'dasar_logika_informatika_65d6b8a183237.jpg', 'Informatika merupakan ilmu mengenai pemanfaatan teknologi komputer dalam permasalahan transformasi atau pengolahan data dengan proses alogika. Dasar ilmu informasi tentunya berada pada pemanfaatan teknologi komputasi seperti algoritma pemrograman, jaringan komputer, memahami struktur data, blockchain, dan lainnya. Keterlibatan data dalam informatika'),
(42, 'Suri Ikan Dan 2 Ekor Burung', 'Dian Kristiana', 'Bhuana Ilmu Populer', 2014, 'suri_ikan_dan_2_ekor_burung_65d6b8ffa9590.jpg', 'Suri Ikun anak yang baik. Suatu hari, dia tersesat di hutan dan diculik para hantu! Suri Ikun tak bisa berbuat apa-apa. Namun, dia tetap berbuat baik pada sesama. Termasuk pada dua ekor burung, yang terluka sayapnya, yang masuk ke gua tempatnya disekap. Bagaimana nasib Suri Ikun berikutnya? Apakah dia mampu melepaskan diri dari para hantu?'),
(43, 'Angkot Tua', 'Sausan Apsarini', 'Muffin Graphics', 2014, 'angkot_tua_65d6b93051bb5.jpg', '	Syifa dan Nadya mendengar cerita seram tentang angkot tua yang muncul tiba-tiba pada malam hari. Konon, angkot itu suka menakut-nakuti penumpangnya. Mereka bahkan diperingatkan untuk tidak menaiki angkot itu. Tapi, mereka enggak percaya dan tetap naik angkot itu. Lalu, apa yang akan terjadi pada mereka?'),
(44, 'Malin Kundang', 'Solikhatul Fatonah K', 'Solikhatul Fatonah K', 2020, 'malin_kundang_65d6b9682e9cc.jpg', '	Malin Kundang adalah cerita rakyat dari Sumatera Barat, Indonesia. Legenda Malin Kundang menceritakan bahwa anak-anak yang durhaka kepada ibu mereka dikutuk menjadi batu. Malin Kundang dikatakan sebagai anak tunggal yang tinggal bersama ibunya. Sebagai seorang remaja, ia memutuskan untuk pergi merantau dengan menumpang kapal saudagar.'),
(45, 'Tips & Trik Jaringan Wireless ', 'Vyctoria.com', 'Elex Media Komputindo', 2021, 'tips_&_trik_jaringan_wireless__65d6b9af2fa64.jpg', 'Saat ini, belum ada buku khusus yang membahas tentang berbagai tips dan trik dalam jaringan wireless. Buku ini akan mengupas berbagai tips dan trik yang jarang diulas dalam kebanyakan buku yang hanya menjelaskan cara membuat jaringan wireless. Di dalamnya, Anda akan menemukan berbagai trik luar biasa. Mulai dari cara meningkatkan kinerja '),
(46, 'Kamus Bahasa Arab', 'Tim Redaksi Cemerlang', 'Cemerlang', 2019, 'kamus_bahasa_arab_65d6b9e56b59e.png', '	Kamus merupakan referensi yang wajib dimiliki siapa saja yang sedang belajar bahasa. Dengan menggunakan kamus, kita bisa mengetahui padanan (persamaan) kata asing dalam bahasa. Hal ini tentunya akan memudahkan kita dalam memahami bahasa tersebut. Kamus ini kami susun berdasarkan kebutuhan pelajar akan sebuah kamus yang dapat dibawa ke mana pun.'),
(48, 'Ragam Desain Grafis Photoshop', 'Jubilee Enterprise', 'Elex Media Komputindo', 2023, 'ragam_desain_grafis_photoshop_65d6ba5b35ef4.jpg', '	Desain grafis menggunakan Photoshop merupakan aktivitas yang seru dan menyenangkan. Anda bisa membuat efek-efek khusus hanya dengan memanfaatkan fitur-fitur standar. Oleh karena itu, ada banyak sekali orang yang rela berlama-lama di depan komputer untuk membuat efek-efek rupawan memakai Photoshop. Daya imajinasi Anda pun akan berke...'),
(51, 'Perpustakaan Misterius', 'Ayashadanica	', 'Dar Minzan	', 2019, 'perpustakaan_misterius_65d6bb662d6c5.jpg', 'Sila, Ririn, Rara, Sisi, dan Ranti hobi membaca buku. Mereka sering membaca di perpustakaan sekolah saat istirahat. Kali ini, mereka memilih buku cerita yang beragam untuk dibaca. Sila membaca buku cerita yang berjudul Perpustakaan Misterius, Ririn membaca Si Citah yang Cepat, Rara membaca Rumah Hantu, Ranti membaca Singa Sang Raja Rimba, dan Sisi mem..'),
(53, 'Dikta & Hukum', 'Dhian Farah', 'Asoka Aksara', 2020, 'dikta_&_hukum_65d6bbe8d2808.jpg', 'Kisah cinta antara Dikta, seorang mahasiswa hukum yang dingin dan Nadhira, seorang mahasiswi hukum yang ceria. Dikta adalah mahasiswa hukum yang pintar dan populer di kampus. Ia memiliki banyak teman dan selalu menjadi pusat perhatian. Dikta dan Nadhira bertemu di kampus dan mereka langsung tidak menyukai satu sama lain. Namun, seiring ....');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(12) NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(27, 'Dongeng'),
(26, 'Ilmu Pengetahuan'),
(28, 'Kamus'),
(29, 'Komik'),
(30, 'Novel');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buku_relasi`
--

CREATE TABLE `kategori_buku_relasi` (
  `id` int(12) NOT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `kategori_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_buku_relasi`
--

INSERT INTO `kategori_buku_relasi` (`id`, `buku_id`, `kategori_id`) VALUES
(16, 24, 30),
(22, 30, 28),
(24, 32, 30),
(25, 33, 26),
(26, 34, 28),
(27, 35, 27),
(28, 36, 28),
(29, 37, 30),
(30, 38, 29),
(32, 40, 27),
(33, 41, 26),
(34, 42, 27),
(35, 43, 29),
(36, 44, 27),
(37, 45, 26),
(38, 46, 28),
(40, 48, 26),
(43, 51, 29),
(45, 53, 30);

-- --------------------------------------------------------

--
-- Table structure for table `koleksi`
--

CREATE TABLE `koleksi` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `koleksi`
--

INSERT INTO `koleksi` (`id`, `user_id`, `buku_id`) VALUES
(2, 1, 15),
(8, 15, 32),
(10, 14, 33),
(11, 14, 24);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `tanggal_peminjaman` date DEFAULT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `status_peminjaman` enum('sudah dikembalikan','belum dikembalikan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `user_id`, `buku_id`, `tanggal_peminjaman`, `tanggal_pengembalian`, `status_peminjaman`) VALUES
(4, 14, 16, '2024-02-21', '2024-07-11', 'sudah dikembalikan'),
(6, 14, 35, '2024-02-22', '2024-03-20', ''),
(7, 14, 34, '2024-02-22', '2024-03-09', 'sudah dikembalikan'),
(8, 14, 37, '2024-02-23', '2024-03-11', 'sudah dikembalikan'),
(9, 14, 36, '2024-02-23', '2023-02-22', 'sudah dikembalikan'),
(10, 14, 34, '2024-02-23', '2222-09-11', 'belum dikembalikan'),
(11, 14, 35, '2024-02-23', '2024-09-08', 'sudah dikembalikan'),
(12, 14, 35, '2024-02-23', '2999-04-03', 'sudah dikembalikan'),
(13, 15, 40, '2024-02-23', '2024-02-10', 'sudah dikembalikan'),
(14, 15, 32, '2024-02-23', '2023-09-11', 'belum dikembalikan'),
(15, 15, 41, '2024-02-23', '8888-08-11', 'belum dikembalikan'),
(16, 15, 45, '2024-02-23', '0007-08-11', 'belum dikembalikan'),
(17, 15, 43, '2024-02-23', '0000-00-00', 'belum dikembalikan'),
(18, 15, 38, '2024-02-23', '2222-02-11', 'belum dikembalikan'),
(19, 15, 24, '2024-02-23', '0022-02-12', 'sudah dikembalikan'),
(20, 15, 53, '2024-02-23', '0022-02-22', 'sudah dikembalikan'),
(21, 15, 46, '2024-02-23', '0022-02-22', 'belum dikembalikan'),
(22, 14, 30, '2024-02-25', '0024-09-11', 'sudah dikembalikan'),
(23, 14, 48, '2024-02-25', '2024-08-12', 'sudah dikembalikan'),
(24, 14, 43, '2024-02-26', '0000-00-00', 'belum dikembalikan');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_buku`
--

CREATE TABLE `ulasan_buku` (
  `id` int(12) NOT NULL,
  `user_id` int(12) DEFAULT NULL,
  `buku_id` int(12) DEFAULT NULL,
  `ulasan` longtext DEFAULT NULL,
  `rating` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan_buku`
--

INSERT INTO `ulasan_buku` (`id`, `user_id`, `buku_id`, `ulasan`, `rating`) VALUES
(9, 1, 16, '', 9),
(40, 14, 24, 'bagus bngt ceritanya', 10),
(43, 14, 32, 'kerenn', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','petugas','peminjam') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama_lengkap`, `username`, `email`, `alamat`, `password`, `role`) VALUES
(1, 'zelion', 'zelion', 'zelion869@gmail.com', 'zelion', '$2y$10$d8nLB60dUI8J8ANLxqAcWewC2rPyyAeAimfHr.VaqP8vIFYhqqGZ.', 'peminjam'),
(3, 'nicole', 'nicole', 'nicole@mail.com', 'jakarta', '$2y$10$fQgyFT/sRSqzmNvFK/p9F.ry3ejDsyZQ7l9QxI78N8ABYZQYmNbyS', 'admin'),
(4, 'keren', 'keren', 'keren@mail.com', 'keren', '$2y$10$HYhv333Kl.IzhW1HCXcMLevJJQUlSg6RYJCM0O5AJqvmZo9s0KJYi', 'petugas'),
(5, 'darwin', 'darwin', 'darwin@mail.com', 'keren', '$2y$10$m31b6uY35DUudmQ0Mv.qgOt58cHS06Tz08jtT1aP3mmqe4YT86jL2', 'petugas'),
(6, 'iza', 'iza', 'iza@mail.com', 'medan', 'iza', 'petugas'),
(7, 'jeki', 'jeki', 'jeki@mail.com', 'jeki', '$2y$10$TbuMYeS1VOhkWQyyJuCwQu8i4sREbXO9qLoWzMH52Xcwe9bMUh8Ri', 'petugas'),
(12, 'asri', 'asri', 'asri@mail.com', 'medan', '$2y$10$JCmd7tYPa2vyJ2QpvU8ol.llomHXRPU42foVQSzNUnID9p8rtwFzW', 'peminjam'),
(13, 'asriyati', 'asriyati', 'asriyati1107@gmail.com', 'jalan bunga terompet', '$2y$10$nT93iAKxK3XZPWkYDTXzNOtxrPL46QOMJfP41D95OQxleoPU4Quka', 'petugas'),
(14, 'dipatima', 'dipa', 'dipa@djik.com', 'aa', '$2y$10$vD6kLWmFZ5hA2wel.EnX0elGA2t9zzuqzjLq6TO2NaVPzEcqeSjBO', 'peminjam'),
(15, 'nalar ratih', 'ratih', 'ratih@gmail.com', 'jalan bunga terompet', '$2y$10$itnBFAHICBTTiPbvTTuWtOSUPwvf4snFdGKSck2CgjhHTGTVzptv2', 'peminjam'),
(16, 'asriyti', 'asriyti', '545211151@smktelkommedan.sch.id', 'jalan bunga terompet', '$2y$10$hDCwmoUrqQto/SOD03QNZevMrJNuQHVFE6yFivd2DpvgM50M8668i', 'admin'),
(24, 'rara', 'rara', 'rara@gmail.com', 'aa', '$2y$10$mXeB.jz5ZPrHqIeSuSfGKOfBlghu0cYT65T1j6orQULRD2tuTQKK2', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `judul` (`judul`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `koleksi`
--
ALTER TABLE `koleksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indexes for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `koleksi`
--
ALTER TABLE `koleksi`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kategori_buku_relasi`
--
ALTER TABLE `kategori_buku_relasi`
  ADD CONSTRAINT `kategori_buku_relasi_ibfk_1` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`),
  ADD CONSTRAINT `kategori_buku_relasi_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `koleksi`
--
ALTER TABLE `koleksi`
  ADD CONSTRAINT `koleksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `koleksi_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);

--
-- Constraints for table `ulasan_buku`
--
ALTER TABLE `ulasan_buku`
  ADD CONSTRAINT `ulasan_buku_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `ulasan_buku_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
