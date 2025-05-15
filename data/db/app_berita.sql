-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 06, 2025 at 01:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_berita`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `aksi` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `aksi`, `waktu`) VALUES
(1, 2, 'User logged in', '2025-05-04 23:55:18'),
(2, 2, 'User logged in', '2025-05-04 23:56:28'),
(3, 2, 'Menambah berita - {\"id\":10,\"judul\":\"zxcqwezaxcdasd\",\"status\":\"draft\"}', '2025-05-05 10:07:13'),
(4, 2, 'Mengubah berita - {\"id\":\"10\",\"judul\":\"asdasdasd\",\"status\":\"draft\"}', '2025-05-05 10:08:34'),
(5, 2, 'Menghapus berita - {\"id\":\"10\",\"judul\":\"asdasdasd\"}', '2025-05-05 10:09:20'),
(6, 2, 'Menambah kas - {\"nama\":\"eafafasdf\",\"jumlah\":\"213\",\"untuk_bulan\":\"Januari\"}', '2025-05-05 10:34:49'),
(7, 2, 'Mengubah kas - {\"id\":\"7\",\"nama\":\"eafafasdf\",\"jumlah\":\"2113.00\",\"untuk_bulan\":\"Januari\"}', '2025-05-05 10:35:23'),
(8, 2, 'Menghapus kas - {\"id\":\"7\",\"nama\":{\"nama\":\"eafafasdf\"},\"jumlah\":{\"jumlah\":\"2113.00\"},\"untuk_bulan\":null}', '2025-05-05 10:36:24'),
(9, 2, 'Menambah kas - {\"nama\":\"agaddfasda\",\"jumlah\":\"123123\",\"untuk_bulan\":\"Januari\"}', '2025-05-05 10:43:40'),
(10, 2, 'Menambah kas_pembayaran - {\"kas_id\":\"8\",\"user_id\":2,\"file_url\":\"\\/uploads\\/pembayaran\\/1746441828_2_7.png\",\"status\":\"pending\"}', '2025-05-05 10:43:48'),
(11, 2, 'Mengubah kas_pembayaran - {\"id\":\"7\",\"kas_id\":\"8\",\"user_id\":null,\"file_url\":\"\\/uploads\\/pembayaran\\/1746441850_2_6.png\",\"status\":\"pending\"}', '2025-05-05 10:44:10'),
(12, 2, 'Update status kas_pembayaran - {\"output\":{\"id\":\"7\",\"kas_id\":\"8\",\"user_id\":\"2\",\"file_url\":\"\\/uploads\\/pembayaran\\/1746441850_2_6.png\",\"status\":\"pending\",\"uploaded_at\":\"2025-05-05 17:43:48\"}}', '2025-05-05 10:46:12'),
(13, 2, 'Menghapuskas_pembayaran - {\"id\":\"7\",\"kas_id\":{\"kas_id\":\"8\"},\"user_id\":{\"user_id\":\"2\"},\"file_url\":{\"file_url\":\"\\/uploads\\/pembayaran\\/1746441850_2_6.png\"},\"status\":{\"status\":\"approved\"}}', '2025-05-05 10:47:09'),
(14, 2, 'Mengubah komentar - {\"output\":{\"id\":\"3\",\"berita_id\":\"7\",\"nama\":\"qweqwe\",\"email\":\"asdasd@asd.com\",\"isi\":\"asdasd\",\"status\":\"pending\",\"created_at\":\"2025-05-05 17:53:02\"}}', '2025-05-05 10:53:33'),
(15, 2, 'Update Status komentar - {\"output\":{\"id\":\"3\",\"berita_id\":\"7\",\"nama\":\"qweqwe\",\"email\":\"asdasd@asd.com\",\"isi\":\"asdasd\",\"status\":\"approved\",\"created_at\":\"2025-05-05 17:53:02\"}}', '2025-05-05 10:53:49'),
(16, 2, 'Menghapus komentar - {\"output\":{\"id\":\"3\",\"berita_id\":\"7\",\"nama\":\"qweqwe\",\"email\":\"asdasd@asd.com\",\"isi\":\"asdasd\",\"status\":\"approved\",\"created_at\":\"2025-05-05 17:53:02\"}}', '2025-05-05 10:54:02'),
(17, 2, 'Menambah LPJ - {\"judul\":\"ghdfgdfg\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746442726_jgfhjfghfgh.pdf\"}', '2025-05-05 10:58:46'),
(18, 2, 'Mengubah LPJ - {\"output\":{\"id\":\"5\",\"judul\":\"ghdfgdfg\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746442726_jgfhjfghfgh.pdf\",\"status\":\"pending\",\"uploaded_by\":\"2\",\"verified_by\":null,\"uploaded_at\":\"2025-05-05 17:58:46\",\"verified_at\":null}}', '2025-05-05 10:59:00'),
(19, 2, 'Update Status LPJ - {\"output\":{\"id\":\"5\",\"judul\":\"jyjtjytjtyjtyj\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746442726_jgfhjfghfgh.pdf\",\"status\":\"pending\",\"uploaded_by\":\"2\",\"verified_by\":null,\"uploaded_at\":\"2025-05-05 17:58:46\",\"verified_at\":null}}', '2025-05-05 10:59:04'),
(20, 2, 'Menambah LPJ - {\"judul\":\"jfhgjghjghj\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746442860_jgfhjfghfgh.pdf\"}', '2025-05-05 11:01:00'),
(21, 2, 'Menambah LPJ - {\"judul\":\"ayh34tqwe\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746443090_jgfhjfghfgh.pdf\"}', '2025-05-05 11:04:50'),
(22, 2, 'Mengubah LPJ - {\"output\":{\"id\":\"7\",\"judul\":\"ayh34tqwe\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746443090_jgfhjfghfgh.pdf\",\"status\":\"pending\",\"uploaded_by\":\"2\",\"verified_by\":null,\"uploaded_at\":\"2025-05-05 18:04:50\",\"verified_at\":null}}', '2025-05-05 11:05:02'),
(23, 2, 'Update Status LPJ - {\"output\":{\"id\":\"7\",\"judul\":\"jhgfd\",\"divisi_id\":\"3\",\"file_url\":\"\\/uploads\\/lpj\\/1746443090_jgfhjfghfgh.pdf\",\"status\":\"pending\",\"uploaded_by\":\"2\",\"verified_by\":null,\"uploaded_at\":\"2025-05-05 18:04:50\",\"verified_at\":null}}', '2025-05-05 11:05:07'),
(24, 2, 'Menghapus LPJ - {\"output\":{\"id\":\"4\",\"judul\":\"asdaszczxc\",\"file_url\":\"zxcadasd\"}}', '2025-05-05 11:07:42'),
(25, 2, 'Menambah pengguna - {\"username\":\"admin1xcvxcv\",\"nama\":\"xcvxcv\",\"role_id\":\"6\"}', '2025-05-05 11:10:22'),
(26, 2, 'Mengubah data pengguna - {\"id\":\"18\",\"before\":{\"username\":\"admin1xcvxcv\",\"name\":\"xcvxcv\",\"role_id\":\"6\"},\"after\":{\"username\":\"asdasdasdads\",\"name\":\"xcvxcv\",\"role_id\":\"6\"},\"password_changed\":false}', '2025-05-05 11:10:30'),
(27, 2, 'Menghapus pengguna - {\"id\":\"18\",\"nama\":\"\",\"username\":\"asdasdasdads\"}', '2025-05-05 11:10:35'),
(28, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 11:13:26'),
(29, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 11:13:37'),
(30, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 11:13:44'),
(31, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 11:13:52'),
(32, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 11:26:54'),
(33, 12, 'Login berhasil - {\"user_id\":12,\"username\":\"humas1\",\"role_id\":10,\"role_desc\":\"Koordinator Humas\"}', '2025-05-05 11:27:06'),
(34, 12, 'Logout - {\"user_id\":12,\"username\":\"humas1\",\"name\":\"Humas User\",\"role_id\":10}', '2025-05-05 11:55:20'),
(35, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 11:55:22'),
(36, 2, 'Update Status komentar - {\"output\":{\"id\":\"4\",\"berita_id\":\"7\",\"nama\":\"tes\",\"email\":\"tes@email.com\",\"isi\":\"test\",\"status\":\"approved\",\"created_at\":\"2025-05-05 18:55:07\"}}', '2025-05-05 11:55:37'),
(37, 2, 'Mengubah berita - {\"id\":\"8\",\"judul\":\"Mengenal Sejarah dan Fungsi Placeholder Text\",\"status\":\"published\"}', '2025-05-05 12:31:38'),
(38, 2, 'Mengubah berita - {\"id\":\"9\",\"judul\":\"Pentingnya Konsistensi Visual dalam Desain Antarmuka\",\"status\":\"published\"}', '2025-05-05 12:32:04'),
(39, 2, 'Mengubah berita - {\"id\":\"10\",\"judul\":\"Peran Warna dalam Meningkatkan Pengalaman Pengguna\",\"status\":\"published\"}', '2025-05-05 12:35:44'),
(40, 2, 'Mengubah berita - {\"id\":\"11\",\"judul\":\"Manfaat Olahraga Teratur untuk Kesehatan Fisik dan Mental\",\"status\":\"published\"}', '2025-05-05 12:41:27'),
(41, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 13:30:15'),
(42, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 13:31:19'),
(43, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 13:31:21'),
(44, 5, 'Login berhasil - {\"user_id\":5,\"username\":\"bendahara1\",\"role_id\":3,\"role_desc\":\"Bendahara\"}', '2025-05-05 13:33:29'),
(45, 5, 'Logout - {\"user_id\":5,\"username\":\"bendahara1\",\"name\":\"Bendahara User\",\"role_id\":3}', '2025-05-05 13:33:32'),
(46, 10, 'Login berhasil - {\"user_id\":10,\"username\":\"desain1\",\"role_id\":8,\"role_desc\":\"Koordinator Desain\"}', '2025-05-05 13:33:36'),
(47, 10, 'Logout - {\"user_id\":10,\"username\":\"desain1\",\"name\":\"Desain User\",\"role_id\":8}', '2025-05-05 13:33:39'),
(48, 9, 'Login berhasil - {\"user_id\":9,\"username\":\"dokum1\",\"role_id\":7,\"role_desc\":\"Koordinator Dokumentasi\"}', '2025-05-05 13:33:45'),
(49, 9, 'Logout - {\"user_id\":9,\"username\":\"dokum1\",\"name\":\"Dokumentasi User\",\"role_id\":7}', '2025-05-05 13:36:05'),
(50, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 13:36:06'),
(51, 2, 'Logout - {\"user_id\":2,\"username\":\"admin1\",\"name\":\"Admin Utama\",\"role_id\":1}', '2025-05-05 13:36:13'),
(52, 5, 'Login berhasil - {\"user_id\":5,\"username\":\"bendahara1\",\"role_id\":3,\"role_desc\":\"Bendahara\"}', '2025-05-05 13:36:35'),
(53, 5, 'Logout - {\"user_id\":5,\"username\":\"bendahara1\",\"name\":\"Bendahara User\",\"role_id\":3}', '2025-05-05 13:36:39'),
(54, 10, 'Login berhasil - {\"user_id\":10,\"username\":\"desain1\",\"role_id\":8,\"role_desc\":\"Koordinator Desain\"}', '2025-05-05 13:36:42'),
(55, 10, 'Logout - {\"user_id\":10,\"username\":\"desain1\",\"name\":\"Desain User\",\"role_id\":8}', '2025-05-05 13:36:46'),
(56, 9, 'Login berhasil - {\"user_id\":9,\"username\":\"dokum1\",\"role_id\":7,\"role_desc\":\"Koordinator Dokumentasi\"}', '2025-05-05 13:36:49'),
(57, 9, 'Logout - {\"user_id\":9,\"username\":\"dokum1\",\"name\":\"Dokumentasi User\",\"role_id\":7}', '2025-05-05 13:36:51'),
(58, NULL, 'Login gagal - {\"username\":\"HouseMD\",\"reason\":\"Password salah atau username tidak ditemukan\"}', '2025-05-05 13:36:54'),
(59, 11, 'Login berhasil - {\"user_id\":11,\"username\":\"hr1\",\"role_id\":9,\"role_desc\":\"Koordinator HRD\"}', '2025-05-05 13:37:01'),
(60, 11, 'Logout - {\"user_id\":11,\"username\":\"hr1\",\"name\":\"HRD User\",\"role_id\":9}', '2025-05-05 13:37:04'),
(61, 12, 'Login berhasil - {\"user_id\":12,\"username\":\"humas1\",\"role_id\":10,\"role_desc\":\"Koordinator Humas\"}', '2025-05-05 13:37:07'),
(62, 12, 'Logout - {\"user_id\":12,\"username\":\"humas1\",\"name\":\"Humas User\",\"role_id\":10}', '2025-05-05 13:37:09'),
(63, 7, 'Login berhasil - {\"user_id\":7,\"username\":\"info1\",\"role_id\":5,\"role_desc\":\"Koordinator Informasi\"}', '2025-05-05 13:37:14'),
(64, 7, 'Logout - {\"user_id\":7,\"username\":\"info1\",\"name\":\"Informasi User\",\"role_id\":5}', '2025-05-05 13:37:16'),
(65, 4, 'Login berhasil - {\"user_id\":4,\"username\":\"redpel1\",\"role_id\":2,\"role_desc\":\"Redaktur Pelaksana\"}', '2025-05-05 13:37:21'),
(66, 4, 'Logout - {\"user_id\":4,\"username\":\"redpel1\",\"name\":\"Redpel User\",\"role_id\":2}', '2025-05-05 13:37:23'),
(67, 6, 'Login berhasil - {\"user_id\":6,\"username\":\"sekre1\",\"role_id\":4,\"role_desc\":\"Sekretaris\"}', '2025-05-05 13:37:26'),
(68, 6, 'Logout - {\"user_id\":6,\"username\":\"sekre1\",\"name\":\"Sekretaris User\",\"role_id\":4}', '2025-05-05 13:37:29'),
(69, 8, 'Login berhasil - {\"user_id\":8,\"username\":\"umum1\",\"role_id\":6,\"role_desc\":\"Koordinator Umum\"}', '2025-05-05 13:37:31'),
(70, 8, 'Logout - {\"user_id\":8,\"username\":\"umum1\",\"name\":\"Umum User\",\"role_id\":6}', '2025-05-05 13:37:36'),
(71, 2, 'Login berhasil - {\"user_id\":2,\"username\":\"admin1\",\"role_id\":1,\"role_desc\":\"Pemimpin Redaksi\"}', '2025-05-05 22:18:11'),
(72, 2, 'Menambah kategori - {\"id\":6,\"nama\":\"1\"}', '2025-05-05 22:24:46'),
(73, 2, 'Menambah kategori - {\"id\":7,\"nama\":\"2\"}', '2025-05-05 22:24:48'),
(74, 2, 'Menambah kategori - {\"id\":8,\"nama\":\"3\"}', '2025-05-05 22:24:50'),
(75, 2, 'Menambah kategori - {\"id\":9,\"nama\":\"4\"}', '2025-05-05 22:24:52'),
(76, 2, 'Menambah kategori - {\"id\":10,\"nama\":\"5\"}', '2025-05-05 22:24:54'),
(77, 2, 'Menghapus kategori - {\"id\":\"10\",\"nama\":\"5\",\"affected_news\":\"0\"}', '2025-05-05 22:31:22'),
(78, 2, 'Menghapus kategori - {\"id\":\"9\",\"nama\":\"4\",\"affected_news\":\"0\"}', '2025-05-05 22:31:28'),
(79, 2, 'Menghapus kategori - {\"id\":\"8\",\"nama\":\"3\",\"affected_news\":\"0\"}', '2025-05-05 22:31:31'),
(80, 2, 'Menghapus kategori - {\"id\":\"7\",\"nama\":\"2\",\"affected_news\":\"0\"}', '2025-05-05 22:31:39'),
(81, 2, 'Mengubah kategori - {\"id\":\"6\",\"nama\":\"Gosip\"}', '2025-05-05 22:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `penulis_id` int(11) NOT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `gambar_url` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `excerpt` varchar(500) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id`, `judul`, `isi`, `penulis_id`, `kategori_id`, `status`, `featured`, `gambar_url`, `slug`, `view_count`, `excerpt`, `created_at`, `updated_at`) VALUES
(6, 'Lorem Ipsum: Sebuah Panduan Dummy', '<h4>Pengantar</h4><br>Lorem Ipsum adalah teks dummy yang sering digunakan dalam dunia percetakan dan desain grafis. Teks ini digunakan untuk mengisi ruang pada desain dan memberikan gambaran bagaimana sebuah halaman akan terlihat setelah diisi dengan teks yang sesungguhnya.<br><br><h4>Apa Itu Lorem Ipsum?</h4><br>Lorem Ipsum berasal dari teks Latin yang diambil dari karya Cicero, seorang orator dan filsuf Romawi. Meskipun terlihat seperti bahasa Latin yang sebenarnya, sebagian besar teks Lorem Ipsum tidak memiliki arti yang jelas, sehingga sering digunakan untuk tujuan pengisian teks sementara.<br><br><h4>Sejarah Singkat Lorem Ipsum</h4><br>Teks Lorem Ipsum sudah digunakan sejak abad ke-16, dimulai oleh seorang pencetak yang tidak dikenal yang membuat jenis huruf baru dan mengisi halaman-halaman tersebut dengan teks ini. Sejak saat itu, penggunaan Lorem Ipsum telah menyebar luas di dunia percetakan dan desain grafis.<br><br><h4>Mengapa Menggunakan Lorem Ipsum?</h4><br><ol><li><b>Menghindari Gangguan: </b>Menggunakan teks nyata bisa mengalihkan \r\nperhatian dari desain itu sendiri. Lorem Ipsum menjaga fokus pada elemen\r\n visual tanpa gangguan dari isi teks.</li><li><b>Tampilan Seimbang: </b>Lorem Ipsum memberi gambaran yang lebih akurat\r\n tentang bagaimana sebuah desain akan terlihat ketika sudah diisi dengan\r\n teks asli.</li></ol><h4>Cara Menggunakan Lorem Ipsum dalam Desain</h4><br>Lorem Ipsum sering digunakan di berbagai aplikasi desain, termasuk layout majalah, brosur, dan situs web. Berikut adalah contoh bagaimana teks ini dapat diterapkan dalam desain.<br><br><h4>Contoh Teks Lorem Ipsum</h4><br><blockquote class=\"blockquote\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</blockquote><br>', 2, 1, 'published', 1, 'uploads/berita/1746420482_lorem-ipsum.webp', 'lorem-ipsum-sebuah-panduan-dummy', 8, 'Lorem Ipsum tetap menjadi pilihan utama dalam dunia desain grafis dan percetakan. Meskipun tidak memiliki makna yang jelas, fungsinya sebagai pengisi teks sementara sangat membantu dalam memvisualisasikan desain tanpa gangguan dari teks asli.', '2025-05-05 11:48:02', '2025-05-05 19:01:05'),
(7, 'Kingdom Hearts: Chain of Memories', '<p align=\"justify\"></p><div align=\"justify\"><b>Kingdom Hearts: Chain of Memories </b>is an action role-playing game developed by <i>Jupiter </i>and published by <i>Square Enix </i>in collaboration with <i>Disney Interactive</i>. It was released for the Game Boy Advance in 2004 as the second installment in the Kingdom Hearts series. The game acts as a direct sequel to the original Kingdom Hearts and a bridge to Kingdom Hearts II.<br><br></div><h4 align=\"justify\">Gameplay</h4><div align=\"justify\"><br>Unlike its predecessor, Chain of Memories introduces a unique card-based battle system. Players form decks using attack, magic, and item cards to perform actions in real-time combat. Movement and dodging remain action-oriented, but each move is tied to a card. Strategy is key, as card values determine priority in battles.<br><br> World Navigation: Players progress through a mysterious place called Castle Oblivion, creating rooms using \"Map Cards.\"<br> Deck Building: Customizable decks are essential for battle effectiveness and vary depending on acquired cards.<br><br></div><h4 align=\"justify\">Plot</h4><div align=\"justify\"><br>The story follows Sora, accompanied by Donald Duck and Goofy, as they search for their missing friends. Upon entering Castle Oblivion, they begin to lose their memories while gaining new ones. As Sora climbs each floor, he battles Organization XIII members and confronts a girl named Naminé, who manipulates his memories.<br><br>Meanwhile, a parallel story featuring Riku, Sora\'s rival, unfolds in the basement of the castle, where he battles his inner darkness and the Organization.<br><br></div><h4 align=\"justify\">Development</h4><ul><li> Developer: Jupiter</li><li>Publisher: Square Enix</li><li> Director: Tetsuya Nomura </li><li>The game was announced in 2003, developed to maintain fan interest between the two mainline games.</li><li> A 3D remake, titled Kingdom Hearts Re\\:Chain of Memories, was released for the PlayStation 2 in 2007.</li></ul><h4 align=\"justify\">Reception</h4><div align=\"justify\"><br>Chain of Memories received generally positive reviews, praised for its story depth and innovative mechanics but criticized for its steep learning curve due to the card system.<br><br></div><ul><li> IGN: 8.5/10</li><li>GameSpot: 8.2/10</li><li>Metacritic: 76/100</li></ul><div align=\"justify\"><blockquote class=\"blockquote\">\"An ambitious spin-off that surprisingly carries major narrative weight for the series.\" – IGN</blockquote><h4>Legacy</h4><br>Despite being a handheld title, Chain of Memories holds a significant place in the Kingdom Hearts timeline. Key characters, themes, and plotlines introduced here become central in future entries. The game also marked the first appearance of Organization XIII, a group pivotal to the overarching narrative.<br><br><br><h4>References</h4><br></div><ol><li><a href=\"https://kingdomhearts.fandom.com/wiki/Kingdom_Hearts:_Chain_of_Memories\" target=\"_blank\">Kingdom Hearts Wiki</a></li><li>Official Square Enix Site</li><li>IGN Review (2004)</li><li>GameSpot Review (2004)<br><br></li></ol><p align=\"justify\"></p>', 2, 2, 'published', 1, 'uploads/berita/1746420833_kingdom-hearts-chain-of-memories.jpg', 'kingdom-hearts-chain-of-memories', 47, 'Kingdom Hearts: Chain of Memories is a 2004 Game Boy Advance action RPG that bridges Kingdom Hearts and Kingdom Hearts II. Featuring a card-based combat system and set in Castle Oblivion, it follows Sora and Riku as they face memory loss and Organization XIII. Despite its learning curve, it’s praised for narrative depth and remains key to the series\' storyline.', '2025-05-05 11:53:53', '2025-05-05 20:27:01'),
(8, 'Mengenal Sejarah dan Fungsi Placeholder Text', '<h4>Pendahuluan</h4><br>Placeholder text seperti Lorem Ipsum telah menjadi bagian penting dalam dunia desain dan pengembangan konten. Penggunaannya membantu visualisasi tata letak tanpa harus menunggu isi konten asli.<br><br><h4>Apa Itu Placeholder Text?</h4><br>Placeholder text adalah teks sementara yang digunakan untuk mengisi ruang dalam desain atau dokumen. Teks ini tidak memiliki arti yang relevan, namun berfungsi untuk menampilkan simulasi bentuk akhir suatu karya.<br><br><h4>Sejarah Penggunaan</h4><br>Penggunaan teks semu ini berakar sejak era percetakan manual. Lorem Ipsum sendiri mulai digunakan pada abad ke-16 oleh seorang pencetak anonim yang ingin mendemonstrasikan berbagai jenis huruf dan layout halaman.<br><br><h4>Fungsi Utama</h4><br><ol><li><b>Simulasi Visual: </b>Memberikan gambaran nyata seperti apa tampilan akhir dari halaman atau dokumen.</li><li><b>Fokus pada Desain: </b>Menghindari gangguan dari isi teks asli yang bisa memengaruhi penilaian desain visual.</li></ol><br><h4>Contoh Penerapan</h4><br>Placeholder text sangat berguna dalam pengembangan website, mockup aplikasi, dan materi promosi. Desainer dapat menilai keseimbangan antar elemen tanpa terganggu isi.<br><br><h4>Contoh Kutipan</h4><br><blockquote class=\"blockquote\">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</blockquote>', 2, 3, 'published', 1, 'uploads/berita/1746420590_placeholder-text.jpg', 'mengenal-sejarah-dan-fungsi-placeholder-text', 1, 'Placeholder text membantu visualisasi desain sebelum konten akhir tersedia, menjadikannya alat penting dalam desain modern.', '2025-05-05 14:45:00', '2025-05-05 19:31:38'),
(9, 'Pentingnya Konsistensi Visual dalam Desain Antarmuka', '<h4>Pendahuluan</h4><br>Konsistensi visual merupakan salah satu prinsip fundamental dalam desain antarmuka yang baik. Hal ini menciptakan pengalaman pengguna yang lebih intuitif dan nyaman.<br><br><h4>Apa Itu Konsistensi Visual?</h4><br>Konsistensi visual adalah penerapan elemen desain yang seragam di seluruh bagian antarmuka, seperti warna, tipografi, ikon, dan tata letak.<br><br><h4>Manfaat Konsistensi</h4><br><ol><li><b>Meningkatkan Keterbacaan: </b>Pengguna lebih mudah memahami informasi yang disajikan.</li><li><b>Mempercepat Interaksi: </b>Elemen yang konsisten membantu pengguna mengenali pola dan navigasi dengan cepat.</li><li><b>Memperkuat Identitas Merek: </b>Desain yang konsisten membangun citra yang kuat dan profesional.</li></ol><br><h4>Penerapan dalam UI/UX</h4><br>Desainer UI/UX menerapkan konsistensi visual dengan membuat sistem desain (design system) yang mencakup panduan elemen visual, seperti palet warna, komponen UI, dan gaya tipografi.<br><br><h4>Kutipan Penting</h4><br><blockquote class=\"blockquote\">Desain bukan hanya bagaimana sesuatu terlihat dan terasa. Desain adalah bagaimana sesuatu bekerja. – Steve Jobs</blockquote>', 2, 4, 'published', 1, 'uploads/berita/1746420900_konsistensi-visual.jpg', 'pentingnya-konsistensi-visual-dalam-desain-antarmuka', 2, 'Konsistensi visual memperkuat pengalaman pengguna dan identitas merek dalam desain antarmuka.', '2025-05-05 15:00:00', '2025-05-05 20:27:10'),
(10, 'Peran Warna dalam Meningkatkan Pengalaman Pengguna', '<h4>Pendahuluan</h4><br>Warna memainkan peran penting dalam menciptakan pengalaman pengguna yang efektif dan emosional. Pemilihan warna yang tepat dapat memengaruhi persepsi, emosi, dan tindakan pengguna.<br><br><h4>Psikologi Warna</h4><br>Setiap warna memiliki asosiasi psikologis. Misalnya, biru sering dikaitkan dengan kepercayaan dan profesionalisme, sementara merah dapat memicu urgensi dan perhatian.<br><br><h4>Strategi Penggunaan Warna</h4><br><ol><li><b>Menarik Perhatian: </b>Gunakan warna kontras untuk elemen penting seperti tombol aksi (CTA).</li><li><b>Mengatur Hirarki Visual: </b>Warna membantu membedakan elemen utama dari elemen pendukung.</li><li><b>Membangun Branding: </b>Skema warna yang konsisten memperkuat identitas visual merek.</li></ol><br><h4>Contoh Implementasi</h4><br>Pada antarmuka aplikasi, warna digunakan untuk memberi umpan balik visual, seperti perubahan warna saat hover atau klik. Ini meningkatkan kejelasan interaksi.<br><br><h4>Kutipan Inspiratif</h4><br><blockquote class=\"blockquote\">Warna adalah kunci, bukan hanya untuk estetika, tetapi juga untuk komunikasi. – Paul Rand</blockquote>', 2, 5, 'published', 1, 'uploads/berita/1746448544_peran-warna-dalam-meningkatkan-pengalaman-pengguna.png', 'peran-warna-dalam-meningkatkan-pengalaman-pengguna', 4, 'Warna tidak hanya mempercantik tampilan, tetapi juga memengaruhi persepsi, emosi, dan efektivitas desain pengguna.', '2025-05-05 15:15:00', '2025-05-05 20:26:54'),
(11, 'Manfaat Olahraga Teratur untuk Kesehatan Fisik dan Mental', '<h4>Pendahuluan</h4><br>Olahraga bukan hanya kegiatan fisik, tetapi juga investasi jangka panjang untuk kesehatan tubuh dan pikiran. Aktivitas ini terbukti secara ilmiah membawa banyak manfaat bagi kualitas hidup.<br><br><h4>Manfaat Fisik</h4><br><ol><li><b>Meningkatkan Kesehatan Jantung: </b>Aktivitas fisik memperkuat otot jantung dan memperlancar aliran darah.</li><li><b>Menurunkan Risiko Penyakit Kronis: </b>Olahraga membantu mencegah diabetes tipe 2, hipertensi, dan obesitas.</li><li><b>Meningkatkan Stamina dan Kekuatan Otot: </b>Latihan rutin membentuk daya tahan tubuh dan fungsi otot.</li></ol><br><h4>Manfaat Mental</h4><br><ol><li><b>Mengurangi Stres dan Kecemasan: </b>Olahraga merangsang pelepasan endorfin yang membuat perasaan lebih positif.</li><li><b>Meningkatkan Kualitas Tidur: </b>Aktivitas fisik teratur membantu tidur lebih nyenyak dan pulas.</li><li><b>Meningkatkan Konsentrasi dan Suasana Hati: </b>Olahraga membantu kejernihan mental dan kestabilan emosi.</li></ol><br><h4>Jenis Olahraga yang Disarankan</h4><br>Beberapa olahraga ringan seperti jalan cepat, bersepeda, yoga, dan berenang sudah cukup efektif jika dilakukan secara konsisten minimal 30 menit per hari.<br><br><h4>Kutipan Motivasi</h4><br><blockquote class=\"blockquote\">Mens sana in corpore sano – Di dalam tubuh yang sehat terdapat jiwa yang kuat.</blockquote>', 2, 1, 'published', 1, 'uploads/berita/1746448887_manfaat-olahraga-teratur-untuk-kesehatan-fisik-dan-mental.jpg', 'manfaat-olahraga-teratur-untuk-kesehatan-fisik-dan-mental', 9, 'Olahraga teratur membantu menjaga kebugaran fisik sekaligus meningkatkan kesehatan mental dan kualitas hidup.', '2025-05-05 15:30:00', '2025-05-05 20:21:23');

-- --------------------------------------------------------

--
-- Table structure for table `berita_tag`
--

CREATE TABLE `berita_tag` (
  `berita_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita_tag`
--

INSERT INTO `berita_tag` (`berita_id`, `tag_id`) VALUES
(6, 1),
(6, 2),
(6, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 7),
(8, 12),
(8, 13),
(8, 14),
(8, 15),
(9, 16),
(9, 17),
(9, 18),
(9, 19),
(9, 20),
(10, 21),
(10, 22),
(10, 23);

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `untuk_bulan` varchar(20) DEFAULT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas`
--

INSERT INTO `kas` (`id`, `nama`, `jumlah`, `untuk_bulan`, `dibuat_oleh`, `created_at`) VALUES
(4, 'asdasdasd', 123.00, 'Januari', 2, '2025-05-05 08:02:51'),
(5, 'zxczxczxc', 12321321.00, 'April', 2, '2025-05-05 08:22:02'),
(6, 'qweqwe', 2323.00, 'Oktober', 2, '2025-05-05 08:23:37'),
(8, 'agaddfasda', 123123.00, 'Januari', 2, '2025-05-05 10:43:40');

-- --------------------------------------------------------

--
-- Table structure for table `kas_pembayaran`
--

CREATE TABLE `kas_pembayaran` (
  `id` int(11) NOT NULL,
  `kas_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kas_pembayaran`
--

INSERT INTO `kas_pembayaran` (`id`, `kas_id`, `user_id`, `file_url`, `status`, `uploaded_at`) VALUES
(4, 4, 2, '/uploads/pembayaran/1746432396_2_8azvn0uac3id1.png', 'rejected', '2025-05-05 08:06:36'),
(5, 5, 2, '/uploads/pembayaran/1746433342_2_1_-_Mensa_Test.pdf', 'approved', '2025-05-05 08:22:22'),
(6, 6, 2, '/uploads/pembayaran/1746433458_2_vlcsnap-2024-09-24-13h06m26s232.png', 'pending', '2025-05-05 08:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `slug`, `created_at`) VALUES
(1, 'Berita Kampus', 'berita-kampus', '2025-05-05 06:07:29'),
(2, 'Opini', 'opini', '2025-05-05 06:07:29'),
(3, 'Teknologi', 'teknologi', '2025-05-05 06:07:29'),
(4, 'Budaya', 'budaya', '2025-05-05 06:07:29'),
(5, 'Olahraga', 'olahraga', '2025-05-05 06:07:29'),
(6, 'Gosip', 'gosip', '2025-05-06 05:24:46');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id` int(11) NOT NULL,
  `berita_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id`, `berita_id`, `nama`, `email`, `isi`, `status`, `created_at`) VALUES
(1, 7, 'aku troll awokwokwok', 'troll@troll.com', 'ARTIKELMU BUSUKKKK', 'approved', '2025-05-05 16:38:16'),
(2, 6, 'seorang fan', 'fan@onlyfans.com', 'aku sukaaaa \'\'\'\'asd\'asd', 'pending', '2025-05-05 16:51:11'),
(4, 7, 'tes', 'tes@email.com', 'test', 'approved', '2025-05-05 18:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `lpj`
--

CREATE TABLE `lpj` (
  `id` int(11) NOT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `divisi_id` int(11) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `status` enum('pending','verified','rejected') DEFAULT 'pending',
  `uploaded_by` int(11) DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lpj`
--

INSERT INTO `lpj` (`id`, `judul`, `divisi_id`, `file_url`, `status`, `uploaded_by`, `verified_by`, `uploaded_at`, `verified_at`) VALUES
(1, 'Laporan Pertanggung Jawaban', 1, '/uploads/lpj/1746438569_qweqweqwe.pdf', 'rejected', 2, NULL, '2025-05-04 06:16:48', NULL),
(2, 'zxczxczxc', 10, '/uploads/lpj/1746434538_anu.pdf', 'verified', 2, 2, '2025-05-05 08:42:18', '2025-05-05 08:44:06'),
(3, 'sfdhfxbvxcvx', 4, '/uploads/lpj/1746438580_zxczxcxzc.pdf', 'pending', 2, NULL, '2025-05-05 08:44:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `deskripsi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `deskripsi`) VALUES
(1, 'pemred', 'Pemimpin Redaksi'),
(2, 'redpel', 'Redaktur Pelaksana'),
(3, 'bendahara', 'Bendahara'),
(4, 'sekre', 'Sekretaris'),
(5, 'info', 'Koordinator Informasi'),
(6, 'umum', 'Koordinator Umum'),
(7, 'dokum', 'Koordinator Dokumentasi'),
(8, 'desain', 'Koordinator Desain'),
(9, 'hr', 'Koordinator HRD'),
(10, 'humas', 'Koordinator Humas');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `nama`, `slug`) VALUES
(1, 'lorem', 'lorem'),
(2, 'ipsum', 'ipsum'),
(3, 'edited', 'edited'),
(4, 'game', 'game'),
(5, 'kingdom_hearts', 'kingdom-hearts'),
(6, 'kingdom', 'kingdom'),
(7, 'hearts', 'hearts'),
(8, 'asd', 'asd'),
(9, 'rew', 'rew'),
(10, 'zxc', 'zxc'),
(11, '123', '123'),
(12, 'placeholder', 'placeholder'),
(13, 'text', 'text'),
(14, 'sejarah', 'sejarah'),
(15, 'fungsi', 'fungsi'),
(16, 'budaya', 'budaya'),
(17, 'visual', 'visual'),
(18, 'konsisten', 'konsisten'),
(19, 'desain', 'desain'),
(20, 'antarmuka', 'antarmuka'),
(21, 'warna', 'warna'),
(22, 'olahraga', 'olahraga'),
(23, 'pengalaman', 'pengalaman');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `role_id`) VALUES
(2, 'admin1', '$2b$12$3xZjUHpWd5auK2xtj3PDA.YVXz8DRUKp71iFpOjM7RZ5oqYqwBSzy', 'Admin Utama', 1),
(4, 'redpel1', '$2b$12$ywl3TCySGX9e/4kVeS9C2O1D4BWLoz/pTGISEAbDecn4RxkBk0Y.u', 'Redpel User', 2),
(5, 'bendahara1', '$2b$12$vzC9hCkievk7DzqYB7iiDeq5TMwXFD36.q00vVMoX8G9AfZWGE35i', 'Bendahara User', 3),
(6, 'sekre1', '$2b$12$MzsPX8LCNAvg5/k/KWiUB.tYWzpus4.ZWOz8SlIBZwOvZ456IKbPm', 'Sekretaris User', 4),
(7, 'info1', '$2b$12$Gxw2ZRiMWxrT2fE5l26VzO/9aJEGGlM4YGoQoRqcieTundHQr4Bey', 'Informasi User', 5),
(8, 'umum1', '$2b$12$1bToXyWHljsZ0klCOSL25.EhfGO9dExyT0yJYWXINJ3MGpu8JCyEG', 'Umum User', 6),
(9, 'dokum1', '$2b$12$RO5JCMSOH.Gh4S1ZP7qnqe4.kb8jBkyyPez0E8igDvPZLALRNHkY2', 'Dokumentasi User', 7),
(10, 'desain1', '$2b$12$L9jfxF4JYtRO6W9Rb3HnG.VWZtZMUHjJ8S0mKQA/llipN47yliXIC', 'Desain User', 8),
(11, 'hr1', '$2b$12$BH.Hgcwga3TyurZ6PRBqL.CEK3n29klLRX5njAy/HV9k3yk7F0lhK', 'HRD User', 9),
(12, 'humas1', '$2b$12$twHmYP81uwD7UbbY726ewORGcaIC/ZzNkIZvpav47oBtoXOahRenW', 'Humas User', 10),
(13, 'HouseMD', '$2y$10$7hw4JnQJL9B6SOolhnwy1ObanJW90eb31m6E/Q39rLgWErHeHyf3y', 'Gergory House', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penulis_id` (`penulis_id`),
  ADD KEY `berita_ibfk_2` (`kategori_id`);

--
-- Indexes for table `berita_tag`
--
ALTER TABLE `berita_tag`
  ADD PRIMARY KEY (`berita_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indexes for table `kas_pembayaran`
--
ALTER TABLE `kas_pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_id` (`kas_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `berita_id` (`berita_id`);

--
-- Indexes for table `lpj`
--
ALTER TABLE `lpj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `divisi_id` (`divisi_id`),
  ADD KEY `uploaded_by` (`uploaded_by`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kas_pembayaran`
--
ALTER TABLE `kas_pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lpj`
--
ALTER TABLE `lpj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `berita_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `berita_tag`
--
ALTER TABLE `berita_tag`
  ADD CONSTRAINT `berita_tag_ibfk_1` FOREIGN KEY (`berita_id`) REFERENCES `berita` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `berita_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas`
--
ALTER TABLE `kas`
  ADD CONSTRAINT `kas_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`);

--
-- Constraints for table `kas_pembayaran`
--
ALTER TABLE `kas_pembayaran`
  ADD CONSTRAINT `kas_pembayaran_ibfk_1` FOREIGN KEY (`kas_id`) REFERENCES `kas` (`id`),
  ADD CONSTRAINT `kas_pembayaran_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`berita_id`) REFERENCES `berita` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lpj`
--
ALTER TABLE `lpj`
  ADD CONSTRAINT `lpj_ibfk_1` FOREIGN KEY (`divisi_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `lpj_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lpj_ibfk_3` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
