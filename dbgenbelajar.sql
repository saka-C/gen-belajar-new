-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2026 pada 11.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbgenbelajar`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetCampaignActive` ()   BEGIN
    SELECT *
    FROM CAMPAIGNS
    WHERE status='active';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_GetDonasiUser` (IN `p_user_id` INT)   BEGIN
    SELECT *
    FROM DONATIONS
    WHERE user_id=p_user_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ProcessDonation` (IN `p_user_id` INT, IN `p_campaign_id` INT, IN `p_amount` DECIMAL(15,2), IN `p_is_anonymous` BOOLEAN, IN `p_guest_name` VARCHAR(100), IN `p_transaction_id` VARCHAR(255))   BEGIN

    INSERT INTO DONATIONS(
        user_id,
        campaign_id,
        amount,
        is_anonymous,
        guest_name,
        payment_method,
        transaction_id,
        payment_status
    )
    VALUES(
        p_user_id,
        p_campaign_id,
        p_amount,
        p_is_anonymous,
        p_guest_name,
        'qris',
        p_transaction_id,
        'pending'
    );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_TotalAllocationCampaign` (IN `p_campaign_id` INT)   BEGIN
    SELECT
    campaign_id,
    SUM(amount_used)
    FROM ALLOCATIONS
    WHERE campaign_id=p_campaign_id
    GROUP BY campaign_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `allocations`
--

CREATE TABLE `allocations` (
  `allocation_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `category` enum('pohon','pendidikan','operasional') NOT NULL,
  `amount_used` decimal(15,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `allocations`
--

INSERT INTO `allocations` (`allocation_id`, `campaign_id`, `category`, `amount_used`, `description`, `created_at`) VALUES
(1, 1, 'operasional', 500000.00, 'Pengiriman bantuan kemanusiaan ke Gaza', '2026-06-09 07:20:04'),
(2, 2, 'operasional', 300000.00, 'Distribusi bantuan korban gempa Cianjur', '2026-06-09 07:20:04'),
(3, 3, 'operasional', 250000.00, 'Logistik bantuan banjir Bekasi', '2026-06-09 07:20:04'),
(4, 4, 'pendidikan', 200000.00, 'Perlengkapan sekolah panti asuhan', '2026-06-09 07:20:04'),
(5, 5, 'pendidikan', 400000.00, 'Penyaluran beasiswa siswa kurang mampu', '2026-06-09 07:20:04'),
(6, 6, 'pendidikan', 350000.00, 'Pembelian buku sekolah daerah terpencil', '2026-06-09 07:20:04'),
(7, 7, 'operasional', 300000.00, 'Program makan gratis anak yatim', '2026-06-09 07:20:04'),
(8, 8, 'pendidikan', 500000.00, 'Renovasi ruang kelas sekolah', '2026-06-09 07:20:04'),
(9, 9, 'operasional', 450000.00, 'Pembangunan sumur air bersih', '2026-06-09 07:20:04'),
(10, 10, 'operasional', 600000.00, 'Pengadaan obat-obatan pasien', '2026-06-09 07:20:04'),
(11, 11, 'operasional', 250000.00, 'Kebutuhan harian panti jompo', '2026-06-09 07:20:04'),
(12, 12, 'operasional', 300000.00, 'Bantuan korban kebakaran', '2026-06-09 07:20:04'),
(13, 13, 'operasional', 200000.00, 'Pembelian kursi roda difabel', '2026-06-09 07:20:04'),
(14, 14, 'pohon', 350000.00, 'Pembelian bibit pohon', '2026-06-09 07:20:04'),
(15, 15, 'operasional', 400000.00, 'Bantuan modal UMKM', '2026-06-09 07:20:04'),
(16, 16, 'operasional', 250000.00, 'Renovasi masjid desa', '2026-06-09 07:20:04'),
(17, 17, 'operasional', 500000.00, 'Bantuan korban tsunami Aceh', '2026-06-09 07:20:04'),
(18, 18, 'pendidikan', 300000.00, 'Pengadaan laptop pelajar', '2026-06-09 07:20:04'),
(19, 19, 'pendidikan', 350000.00, 'Pembangunan perpustakaan desa', '2026-06-09 07:20:04'),
(20, 20, 'operasional', 400000.00, 'Pemeriksaan kesehatan lansia', '2026-06-09 07:20:04');

--
-- Trigger `allocations`
--
DELIMITER $$
CREATE TRIGGER `trg_PreventOverSpending` BEFORE INSERT ON `allocations` FOR EACH ROW BEGIN
    DECLARE v_limit DECIMAL(15,2);
    DECLARE v_used DECIMAL(15,2);
    
    SELECT (current_amount * 0.8) INTO v_limit FROM CAMPAIGNS WHERE campaign_id = NEW.campaign_id;
    SELECT COALESCE(SUM(amount_used), 0) INTO v_used FROM ALLOCATIONS WHERE campaign_id = NEW.campaign_id;
    
    IF (v_used + NEW.amount_used) > v_limit THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Gagal: Pengeluaran melebihi batas 80% dana terkumpul!';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `campaigns`
--

CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `target_amount` decimal(15,2) NOT NULL,
  `current_amount` decimal(15,2) DEFAULT 0.00,
  `status` enum('draft','active','completed') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `campaigns`
--

INSERT INTO `campaigns` (`campaign_id`, `title`, `target_amount`, `current_amount`, `status`) VALUES
(1, 'Bantuan Kemanusiaan untuk Gaza', 50000000.00, 220000000.00, 'completed'),
(2, 'Bantuan Korban Gempa Cianjur', 30000000.00, 12000000.00, 'active'),
(3, 'Bantuan Korban Banjir Bekasi', 25000000.00, 8000000.00, 'active'),
(4, 'Donasi untuk Panti Asuhan Harapan Bangsa', 15000000.00, 5000000.00, 'active'),
(5, 'Beasiswa Anak Kurang Mampu', 20000000.00, 7000000.00, 'active'),
(6, 'Pengadaan Buku Sekolah Daerah Terpencil', 18000000.00, 4000000.00, 'active'),
(7, 'Program Makan Gratis untuk Anak Yatim', 22000000.00, 9000000.00, 'active'),
(8, 'Renovasi Sekolah Rusak di NTT', 35000000.00, 10000000.00, 'active'),
(9, 'Pembangunan Sumur Air Bersih di Lombok', 28000000.00, 6000000.00, 'active'),
(10, 'Bantuan Medis untuk Pasien Tidak Mampu', 40000000.00, 15000000.00, 'active'),
(11, 'Donasi Operasional Panti Jompo', 12000000.00, 3000000.00, 'active'),
(12, 'Bantuan Korban Kebakaran Bandung', 17000000.00, 4000000.00, 'active'),
(13, 'Pengadaan Kursi Roda untuk Difabel', 10000000.00, 2500000.00, 'active'),
(14, 'Program Penanaman 10.000 Pohon', 16000000.00, 5000000.00, 'active'),
(15, 'Bantuan UMKM Pasca Bencana', 25000000.00, 7000000.00, 'active'),
(16, 'Renovasi Masjid Desa Terpencil', 14000000.00, 2000000.00, 'draft'),
(17, 'Bantuan Korban Tsunami Aceh', 45000000.00, 18000000.00, 'active'),
(18, 'Donasi Laptop untuk Pelajar', 19000000.00, 5000000.00, 'draft'),
(19, 'Pembangunan Perpustakaan Desa', 23000000.00, 6000000.00, 'active'),
(20, 'Program Kesehatan Gratis untuk Lansia', 27000000.00, 8000000.00, 'active');

--
-- Trigger `campaigns`
--
DELIMITER $$
CREATE TRIGGER `trg_CompleteCampaign` BEFORE UPDATE ON `campaigns` FOR EACH ROW BEGIN
    IF NEW.current_amount >= NEW.target_amount THEN
        SET NEW.status = 'completed';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `is_anonymous` tinyint(1) DEFAULT 0,
  `guest_name` varchar(100) DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT 'qris',
  `transaction_id` varchar(255) NOT NULL,
  `payment_status` enum('pending','success','failed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donations`
--

INSERT INTO `donations` (`donation_id`, `user_id`, `campaign_id`, `amount`, `is_anonymous`, `guest_name`, `payment_method`, `transaction_id`, `payment_status`) VALUES
(1, 8, 4, 150000.00, 0, NULL, 'qris', 'TRX005', 'success'),
(2, 9, 5, 200000.00, 0, NULL, 'qris', 'TRX006', 'success'),
(3, 10, 6, 250000.00, 0, NULL, 'qris', 'TRX007', 'success'),
(4, 11, 7, 100000.00, 0, NULL, 'qris', 'TRX008', 'success'),
(5, 12, 8, 300000.00, 0, NULL, 'qris', 'TRX009', 'success'),
(6, 13, 9, 250000.00, 0, NULL, 'qris', 'TRX010', 'success'),
(7, 14, 10, 500000.00, 0, NULL, 'qris', 'TRX011', 'success'),
(8, 15, 11, 100000.00, 0, NULL, 'qris', 'TRX012', 'success'),
(9, 16, 12, 150000.00, 0, NULL, 'qris', 'TRX013', 'success'),
(10, 17, 13, 200000.00, 0, NULL, 'qris', 'TRX014', 'success'),
(11, 18, 14, 250000.00, 0, NULL, 'qris', 'TRX015', 'success'),
(12, 19, 15, 300000.00, 0, NULL, 'qris', 'TRX016', 'success'),
(13, 20, 16, 100000.00, 0, NULL, 'qris', 'TRX017', 'success'),
(14, 4, 17, 400000.00, 0, NULL, 'qris', 'TRX018', 'success'),
(15, 5, 18, 200000.00, 0, NULL, 'qris', 'TRX019', 'success'),
(16, 6, 19, 250000.00, 0, NULL, 'qris', 'TRX020', 'success'),
(17, 7, 20, 300000.00, 0, NULL, 'qris', 'TRX021', 'success'),
(18, 8, 1, 150000.00, 0, NULL, 'qris', 'TRX022', 'success'),
(19, 9, 2, 200000.00, 0, NULL, 'qris', 'TRX023', 'success'),
(20, 10, 3, 250000.00, 0, NULL, 'qris', 'TRX024', 'success'),
(21, 11, 4, 300000.00, 0, NULL, 'qris', 'TRX025', 'success'),
(22, 12, 5, 100000.00, 0, NULL, 'qris', 'TRX026', 'success'),
(23, 13, 6, 200000.00, 0, NULL, 'qris', 'TRX027', 'success'),
(24, 14, 7, 250000.00, 0, NULL, 'qris', 'TRX028', 'success'),
(25, 15, 8, 300000.00, 0, NULL, 'qris', 'TRX029', 'success'),
(26, 16, 9, 150000.00, 0, NULL, 'qris', 'TRX030', 'success'),
(27, 17, 10, 400000.00, 0, NULL, 'qris', 'TRX031', 'success'),
(28, 18, 11, 200000.00, 0, NULL, 'qris', 'TRX032', 'success'),
(29, 19, 12, 250000.00, 0, NULL, 'qris', 'TRX033', 'success'),
(30, 20, 13, 300000.00, 0, NULL, 'qris', 'TRX034', 'success'),
(31, 4, 14, 150000.00, 0, NULL, 'qris', 'TRX035', 'success'),
(32, 5, 15, 200000.00, 0, NULL, 'qris', 'TRX036', 'success'),
(33, 6, 16, 250000.00, 0, NULL, 'qris', 'TRX037', 'success'),
(34, 7, 17, 300000.00, 0, NULL, 'qris', 'TRX038', 'success'),
(35, 8, 18, 100000.00, 0, NULL, 'qris', 'TRX039', 'success'),
(36, 9, 19, 350000.00, 0, NULL, 'qris', 'TRX040', 'success'),
(37, 1, 2, 500000.00, 0, NULL, 'qris', 'TRX099', 'pending'),
(38, NULL, 1, 50000.00, 0, 'Khijib', 'qris', 'TRX-1781372900', 'pending'),
(41, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781413372', 'pending'),
(42, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781414009', 'pending'),
(43, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781414079', 'pending'),
(44, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781414404', 'pending'),
(45, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781416567', 'pending'),
(46, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781416724', 'pending'),
(47, NULL, 1, 200000.00, 0, 'Khijib', 'qris', 'TRX-1781416865', 'pending'),
(48, NULL, 1, 300000.00, 0, 'Khijib', 'qris', 'TRX-1781416929', 'pending'),
(49, NULL, 1, 2000000.00, 0, 'Shaka', 'qris', 'TRX-1781423546', 'pending'),
(50, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781426750', 'pending'),
(51, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781427242', 'pending'),
(52, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781427846', 'pending'),
(53, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781428568', 'pending'),
(54, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781428610', 'pending'),
(55, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781428829', 'pending'),
(56, NULL, 1, 3000000.00, 0, 'Inayah', 'qris', 'TRX-1781429752', 'pending'),
(57, NULL, 1, 5000000.00, 0, 'Cabil', 'qris', 'TRX-1781429771', 'success'),
(58, NULL, 1, 9000.00, 0, 'jokowo', 'qris', 'TRX-1781429902', 'pending'),
(59, NULL, 1, 9000.00, 0, 'jokowo', 'qris', 'TRX-1781430297', 'pending'),
(60, NULL, 1, 9000.00, 0, 'jokowo', 'qris', 'TRX-1781430310', 'pending'),
(61, NULL, 1, 9000.00, 0, 'jokowo', 'qris', 'TRX-1781430320', 'pending'),
(62, NULL, 1, 12000.00, 0, 'Prabodo', 'qris', 'TRX-1781430334', 'pending'),
(63, NULL, 1, 12000.00, 0, 'Prabodo', 'qris', 'TRX-1781430388', 'pending'),
(64, NULL, 1, 15000.00, 0, 'Sugeng', 'qris', 'TRX-1781431320', 'pending'),
(65, NULL, 1, 5000000.00, 0, 'JUAN', 'qris', 'TRX-1781431724', 'pending'),
(68, NULL, 1, 600000.00, 0, 'udin', 'qris', 'TRX-1781432090', 'pending'),
(69, NULL, 1, 1000000.00, 0, 'udin', 'qris', 'TRX-1781432142', 'pending'),
(70, NULL, 1, 2000000.00, 0, 'Asep', 'qris', 'TRX-1781432269', 'pending'),
(71, NULL, 1, 3000000.00, 0, 'UJANG', 'qris', 'TRX-1781432386', 'pending'),
(72, NULL, 1, 1000000.00, 0, 'Ugut', 'qris', 'TRX-1781432534', 'pending'),
(74, NULL, 1, 2000000.00, 0, 'Yuyun', 'qris', 'TRX-1781447288', 'pending'),
(75, NULL, 1, 4500000.00, 0, 'Khabib', 'qris', 'TRX-1781508782', 'pending'),
(76, NULL, 1, 7000.00, 0, 'Jack', 'qris', 'TRX-1781509639', 'pending'),
(77, NULL, 1, 5000.00, 0, 'jejeje', 'qris', 'TRX-1781512369', 'pending'),
(78, NULL, 1, 5000.00, 0, 'jejeje', 'qris', 'TRX-1781512370', 'pending');

--
-- Trigger `donations`
--
DELIMITER $$
CREATE TRIGGER `trg_AfterPaymentSuccess` AFTER UPDATE ON `donations` FOR EACH ROW BEGIN
    IF OLD.payment_status = 'pending' AND NEW.payment_status = 'success' THEN
        UPDATE CAMPAIGNS 
        SET current_amount = current_amount + NEW.amount
        WHERE campaign_id = NEW.campaign_id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_DeleteDonation` AFTER DELETE ON `donations` FOR EACH ROW BEGIN
    INSERT INTO DONATION_LOG (
        donation_id
    )
    VALUES (
        OLD.donation_id
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `donation_log`
--

CREATE TABLE `donation_log` (
  `log_id` int(11) NOT NULL,
  `donation_id` int(11) NOT NULL,
  `deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `donation_log`
--

INSERT INTO `donation_log` (`log_id`, `donation_id`, `deleted_at`) VALUES
(1, 39, '2026-06-13 17:56:01'),
(2, 40, '2026-06-14 03:26:03'),
(3, 73, '2026-06-15 07:18:22'),
(4, 67, '2026-06-15 07:18:35'),
(5, 66, '2026-06-15 07:18:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_06_11_025107_create_allocations_table', 0),
(2, '2026_06_11_025107_create_campaigns_table', 0),
(3, '2026_06_11_025107_create_donation_log_table', 0),
(4, '2026_06_11_025107_create_donations_table', 0),
(5, '2026_06_11_025107_create_profiles_table', 0),
(6, '2026_06_11_025107_create_users_table', 0),
(7, '2026_06_11_025108_create_vw_donasi_sukses_view', 0),
(8, '2026_06_11_025108_create_vw_globalfinancialsummary_view', 0),
(9, '2026_06_11_025108_create_vw_progress_campaign_view', 0),
(10, '2026_06_11_025109_create_sp_GetCampaignActive_proc', 0),
(11, '2026_06_11_025109_create_sp_GetDonasiUser_proc', 0),
(12, '2026_06_11_025109_create_sp_ProcessDonation_proc', 0),
(13, '2026_06_11_025109_create_sp_TotalAllocationCampaign_proc', 0),
(14, '2026_06_11_025110_add_foreign_keys_to_allocations_table', 0),
(15, '2026_06_11_025110_add_foreign_keys_to_donations_table', 0),
(16, '2026_06_11_025110_add_foreign_keys_to_profiles_table', 0),
(17, '2026_06_11_025425_create_personal_access_tokens_table', 1),
(18, '2026_06_11_025442_add_database_logic_features', 2),
(19, '2026_06_11_025451_create_sessions_table', 2),
(20, '2026_06_11_025716_create_allocations_table', 0),
(21, '2026_06_11_025716_create_campaigns_table', 0),
(22, '2026_06_11_025716_create_donation_log_table', 0),
(23, '2026_06_11_025716_create_donations_table', 0),
(24, '2026_06_11_025716_create_personal_access_tokens_table', 0),
(25, '2026_06_11_025716_create_profiles_table', 0),
(26, '2026_06_11_025716_create_sessions_table', 0),
(27, '2026_06_11_025716_create_users_table', 0),
(28, '2026_06_11_025717_create_vw_donasi_sukses_view', 0),
(29, '2026_06_11_025717_create_vw_globalfinancialsummary_view', 0),
(30, '2026_06_11_025717_create_vw_progress_campaign_view', 0),
(31, '2026_06_11_025718_create_sp_GetCampaignActive_proc', 0),
(32, '2026_06_11_025718_create_sp_GetDonasiUser_proc', 0),
(33, '2026_06_11_025718_create_sp_ProcessDonation_proc', 0),
(34, '2026_06_11_025718_create_sp_TotalAllocationCampaign_proc', 0),
(35, '2026_06_11_025719_add_foreign_keys_to_allocations_table', 0),
(36, '2026_06_11_025719_add_foreign_keys_to_donations_table', 0),
(37, '2026_06_11_025719_add_foreign_keys_to_profiles_table', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profiles`
--

CREATE TABLE `profiles` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture_url` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profiles`
--

INSERT INTO `profiles` (`profile_id`, `user_id`, `full_name`, `phone_number`, `profile_picture_url`, `address`) VALUES
(1, 1, 'Inayah', '0811111111', NULL, 'Bogor'),
(2, 2, 'Shaka', '0811111112', NULL, 'Citayem'),
(3, 3, 'Khijib', '0811111113', NULL, 'depok'),
(4, 4, 'Sabilah', '0811111114', NULL, 'Bogor'),
(5, 5, 'User 1', '0811111115', NULL, 'Bogor'),
(6, 6, 'User 2', '0811111116', NULL, 'Bekasi'),
(7, 7, 'User 3', '0811111117', NULL, 'Depok'),
(8, 8, 'User 4', '0811111118', NULL, 'Bandung'),
(9, 9, 'User 5', '0811111119', NULL, 'Bandung'),
(10, 10, 'User 6', '0811111120', NULL, 'Jakarta'),
(11, 11, 'User 7', '0811111121', NULL, 'Jakarta'),
(12, 12, 'User 8', '0811111122', NULL, 'Bogor'),
(13, 13, 'User 9', '0811111123', NULL, 'Bogor'),
(14, 14, 'User 10', '0811111124', NULL, 'Bekasi'),
(15, 15, 'User 11', '0811111125', NULL, 'Bekasi'),
(16, 16, 'User 12', '0811111126', NULL, 'Depok'),
(17, 17, 'User 13', '0811111127', NULL, 'Bandung'),
(18, 18, 'User 14', '0811111128', NULL, 'Bandung'),
(19, 19, 'User 15', '0811111129', NULL, 'Jakarta'),
(20, 20, 'User 16', '0811111130', NULL, 'Bogor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jrWRAQ8B563poHN24F8Oqi3E3OscSx8MjDrfXoEX', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaW9VdnZUc1BkelBzb3VyVWN6SWZGTlI4cE5vZ1lCWnpxVUoyMlZVTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9ncmFtIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1781516540);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `auth_provider` enum('local','google') DEFAULT 'local',
  `role` enum('donatur','admin','volunteer') DEFAULT 'donatur'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `google_id`, `auth_provider`, `role`) VALUES
(1, 'inayah', 'inayahsafitri6@mail.com', 'hash1', NULL, 'local', 'admin'),
(2, 'shaka', 'shakaaufa@mail.com', 'hash2', NULL, 'local', 'admin'),
(3, 'khijib', 'mkhijib@mail.com', 'hash3', NULL, 'local', 'volunteer'),
(4, 'sabilah', 'cabil@mail.com', 'hash4', NULL, 'local', 'volunteer'),
(5, 'user1', 'user2@mail.com', 'hash5', NULL, 'local', 'donatur'),
(6, 'user2', 'user3@mail.com', 'hash6', NULL, 'local', 'donatur'),
(7, 'user3', 'user4@mail.com', 'hash7', NULL, 'local', 'donatur'),
(8, 'user4', 'user5@mail.com', 'hash8', NULL, 'local', 'donatur'),
(9, 'user5', 'user6@mail.com', 'hash9', NULL, 'local', 'donatur'),
(10, 'user6', 'user7@mail.com', 'hash10', NULL, 'local', 'donatur'),
(11, 'user7', 'user8@mail.com', 'hash11', NULL, 'local', 'donatur'),
(12, 'user8', 'user9@mail.com', 'hash12', NULL, 'local', 'donatur'),
(13, 'user9', 'user10@mail.com', 'hash13', NULL, 'local', 'donatur'),
(14, 'user10', 'user11@mail.com', 'hash14', NULL, 'local', 'donatur'),
(15, 'user11', 'user12@mail.com', 'hash15', NULL, 'local', 'donatur'),
(16, 'user12', 'user13@mail.com', 'hash16', NULL, 'local', 'donatur'),
(17, 'user13', 'user14@mail.com', 'hash17', NULL, 'local', 'donatur'),
(18, 'user14', 'user15@mail.com', 'hash18', NULL, 'local', 'donatur'),
(19, 'user15', 'user16@mail.com', 'hash19', NULL, 'local', 'donatur'),
(20, 'user16', 'user17@mail.com', 'hash20', NULL, 'local', 'donatur');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vw_donasi_sukses`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vw_donasi_sukses` (
`donation_id` int(11)
,`username` varchar(50)
,`title` varchar(255)
,`amount` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vw_globalfinancialsummary`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vw_globalfinancialsummary` (
`total_transaksi_sukses` bigint(21)
,`total_dana_masuk_global` decimal(37,2)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vw_progress_campaign`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vw_progress_campaign` (
`campaign_id` int(11)
,`title` varchar(255)
,`target_amount` decimal(15,2)
,`current_amount` decimal(15,2)
,`progress_percentage` decimal(21,2)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `vw_donasi_sukses`
--
DROP TABLE IF EXISTS `vw_donasi_sukses`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_donasi_sukses`  AS SELECT `d`.`donation_id` AS `donation_id`, `u`.`username` AS `username`, `c`.`title` AS `title`, `d`.`amount` AS `amount` FROM ((`donations` `d` join `users` `u` on(`d`.`user_id` = `u`.`user_id`)) join `campaigns` `c` on(`d`.`campaign_id` = `c`.`campaign_id`)) WHERE `d`.`payment_status` = 'success' ;

-- --------------------------------------------------------

--
-- Struktur untuk view `vw_globalfinancialsummary`
--
DROP TABLE IF EXISTS `vw_globalfinancialsummary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_globalfinancialsummary`  AS SELECT count(`donations`.`donation_id`) AS `total_transaksi_sukses`, sum(`donations`.`amount`) AS `total_dana_masuk_global` FROM `donations` WHERE `donations`.`payment_status` = 'success' ;

-- --------------------------------------------------------

--
-- Struktur untuk view `vw_progress_campaign`
--
DROP TABLE IF EXISTS `vw_progress_campaign`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_progress_campaign`  AS SELECT `campaigns`.`campaign_id` AS `campaign_id`, `campaigns`.`title` AS `title`, `campaigns`.`target_amount` AS `target_amount`, `campaigns`.`current_amount` AS `current_amount`, round(`campaigns`.`current_amount` / `campaigns`.`target_amount` * 100,2) AS `progress_percentage` FROM `campaigns` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `allocations`
--
ALTER TABLE `allocations`
  ADD PRIMARY KEY (`allocation_id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `idx_allocation_category` (`category`);

--
-- Indeks untuk tabel `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`campaign_id`),
  ADD KEY `idx_campaign_status` (`status`);

--
-- Indeks untuk tabel `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `campaign_id` (`campaign_id`),
  ADD KEY `idx_payment_status` (`payment_status`),
  ADD KEY `idx_user_campaign` (`user_id`,`campaign_id`);

--
-- Indeks untuk tabel `donation_log`
--
ALTER TABLE `donation_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `google_id` (`google_id`),
  ADD KEY `idx_user_role` (`role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `allocations`
--
ALTER TABLE `allocations`
  MODIFY `allocation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `campaign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `donation_log`
--
ALTER TABLE `donation_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `profiles`
--
ALTER TABLE `profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `allocations`
--
ALTER TABLE `allocations`
  ADD CONSTRAINT `allocations_ibfk_1` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Ketidakleluasaan untuk tabel `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`campaign_id`);

--
-- Ketidakleluasaan untuk tabel `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
