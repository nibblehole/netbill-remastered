-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Agu 2020 pada 18.34
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `netbill`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_login`
--

CREATE TABLE `t_login` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `level` enum('admin','operator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_login`
--

INSERT INTO `t_login` (`id`, `username`, `password`, `nama_lengkap`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Royhan', 'admin'),
(2, 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'Operator', 'operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_paket`
--

CREATE TABLE `t_paket` (
  `id_paket` varchar(16) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `harga` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_paket`
--

INSERT INTO `t_paket` (`id_paket`, `nama`, `harga`) VALUES
('P01', '1 Mbps', '100000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pelanggan`
--

CREATE TABLE `t_pelanggan` (
  `id_pelanggan` varchar(25) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `email` varchar(64) NOT NULL,
  `id_paket` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_pelanggan`
--

INSERT INTO `t_pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_hp`, `email`, `id_paket`) VALUES
('5F3D4B630B076', 'Royhan', 'Nglajo, Cepu', '082314597239', 'royhanabdurrohim@gmail.com', 'P01'),
('5F3D50191E51E', 'Dimas', 'Sambeng', '081262712932', 'dims@wiuw.co', 'P01'),
('5F3D5235DE07F', 'Admin', 'Nglajo', '081234567890', 'hi@admin.co', 'P01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_setting`
--

CREATE TABLE `t_setting` (
  `id` int(1) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `alamat` text NOT NULL,
  `pemilik` varchar(64) NOT NULL,
  `logo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_setting`
--

INSERT INTO `t_setting` (`id`, `nama`, `alamat`, `pemilik`, `logo`) VALUES
(1, 'TeamX Project', 'Nglajo', 'Royhan Abdurrohim', 'logo.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_transaksi`
--

CREATE TABLE `t_transaksi` (
  `id_transaksi` varchar(64) NOT NULL,
  `id_pelanggan` varchar(64) NOT NULL,
  `nominal` int(7) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_validasi` date NOT NULL,
  `status` enum('pending','lunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_transaksi`
--

INSERT INTO `t_transaksi` (`id_transaksi`, `id_pelanggan`, `nominal`, `bukti`, `tgl_bayar`, `tgl_validasi`, `status`) VALUES
('INV01-5F3D528D00537', '5F3D4B630B076', 100000, 'upload/ex-2020-08-19-master-img.png', '2020-08-01', '2020-08-02', 'lunas'),
('INV02-5F3D541017F35', '5F3D50191E51E', 100000, 'upload/ex-2020-08-19-master-img2.png', '2020-08-10', '2020-08-11', 'lunas'),
('INV03-5F3D544A25862', '5F3D5235DE07F', 100000, 'upload/ex-2020-08-19-master-img3.png', '2020-08-12', '2020-08-12', 'lunas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id_pelanggan` varchar(25) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','pelanggan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id_pelanggan`, `username`, `password`, `level`) VALUES
('5F3D50191E51E', 'dimas', 'e10adc3949ba59abbe56e057f20f883e', 'pelanggan'),
('5F3D5235DE07F', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_login`
--
ALTER TABLE `t_login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_paket`
--
ALTER TABLE `t_paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indeks untuk tabel `t_pelanggan`
--
ALTER TABLE `t_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `t_setting`
--
ALTER TABLE `t_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD UNIQUE KEY `id_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_login`
--
ALTER TABLE `t_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `t_setting`
--
ALTER TABLE `t_setting`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD CONSTRAINT `t_user_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `t_pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
