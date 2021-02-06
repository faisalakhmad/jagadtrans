/*
SQLyog Ultimate v11.21 (64 bit)
MySQL - 10.1.25-MariaDB : Database - me_cv_pengiriman
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`me_cv_pengiriman` /*!40100 DEFAULT CHARACTER SET latin1 */;

/*Table structure for table `informasi` */

DROP TABLE IF EXISTS `informasi`;

CREATE TABLE `informasi` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
  `info_judul` varchar(255) NOT NULL,
  `info_isi` text NOT NULL,
  `info_tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `informasi` */

insert  into `informasi`(`info_id`,`info_judul`,`info_isi`,`info_tanggal`) values (1,'Cuti Bersama','Cuti Bersama Tgl 5, hubungi hrd','2021-02-05 22:13:00');

/*Table structure for table `kategori_user` */

DROP TABLE IF EXISTS `kategori_user`;

CREATE TABLE `kategori_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_user` varchar(100) NOT NULL,
  `beranda` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_user` (`kategori_user`),
  KEY `beranda` (`beranda`),
  CONSTRAINT `kategori_user_ibfk_1` FOREIGN KEY (`beranda`) REFERENCES `modul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

/*Data for the table `kategori_user` */

insert  into `kategori_user`(`id`,`kategori_user`,`beranda`) values (35,'Administrator',1);
insert  into `kategori_user`(`id`,`kategori_user`,`beranda`) values (36,'Driver',1);

/*Table structure for table `kategori_user_modul` */

DROP TABLE IF EXISTS `kategori_user_modul`;

CREATE TABLE `kategori_user_modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_user` int(11) NOT NULL,
  `modul` int(11) NOT NULL,
  `akses` enum('read','add','edit','delete') NOT NULL DEFAULT 'read',
  PRIMARY KEY (`id`),
  KEY `kategori_user` (`kategori_user`),
  KEY `modul` (`modul`),
  CONSTRAINT `kategori_user_modul_ibfk_1` FOREIGN KEY (`kategori_user`) REFERENCES `kategori_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `kategori_user_modul_ibfk_2` FOREIGN KEY (`modul`) REFERENCES `modul` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12067 DEFAULT CHARSET=latin1;

/*Data for the table `kategori_user_modul` */

insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11956,35,1,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11957,35,2,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11958,35,3,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11959,35,4,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11960,35,5,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11961,35,6,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11962,35,7,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11963,35,8,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11964,35,9,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (11999,35,3,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12000,35,4,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12001,35,5,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12002,35,6,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12003,35,7,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12004,35,8,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12005,35,9,'add');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12022,35,3,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12023,35,4,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12024,35,5,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12025,35,6,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12026,35,7,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12027,35,8,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12028,35,9,'edit');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12040,35,3,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12041,35,4,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12042,35,5,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12043,35,6,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12044,35,7,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12045,35,8,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12046,35,9,'delete');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12065,36,1,'read');
insert  into `kategori_user_modul`(`id`,`kategori_user`,`modul`,`akses`) values (12066,36,8,'read');

/*Table structure for table `master_admin` */

DROP TABLE IF EXISTS `master_admin`;

CREATE TABLE `master_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `nama_admin` varchar(200) NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL DEFAULT 'laki-laki',
  `alamat` varchar(200) NOT NULL,
  `telepon` varchar(30) NOT NULL,
  `handphone` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '1',
  `waktu_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `kategori` (`kategori`),
  CONSTRAINT `master_admin_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori_user` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `master_admin` */

insert  into `master_admin`(`id`,`kategori`,`username`,`password`,`nama_admin`,`jenis_kelamin`,`alamat`,`telepon`,`handphone`,`email`,`aktif`,`waktu_update`) values (1,35,'user_manager','$2y$10$lDNtuIsEwlg0hVHpFb1qZuluKxVDfMzh7opYZp0AutqnJYSH8ze/6','Faisal','laki-laki','Jln pepaya no 12 Bali','082139221343','082139221343','faisal@gmail.com','1','2021-02-06 01:36:04');

/*Table structure for table `master_desa` */

DROP TABLE IF EXISTS `master_desa`;

CREATE TABLE `master_desa` (
  `desa_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `desa_nama` varchar(50) NOT NULL,
  `desa_kec_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`desa_id`),
  UNIQUE KEY `uniq` (`desa_nama`,`desa_kec_id`),
  KEY `fk-kec` (`desa_kec_id`),
  CONSTRAINT `fk-kec` FOREIGN KEY (`desa_kec_id`) REFERENCES `master_kecamatan` (`kec_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `master_desa` */

insert  into `master_desa`(`desa_id`,`desa_nama`,`desa_kec_id`) values (4,'Jangkang',3);
insert  into `master_desa`(`desa_id`,`desa_nama`,`desa_kec_id`) values (1,'Wedomartani',2);

/*Table structure for table `master_instansi` */

DROP TABLE IF EXISTS `master_instansi`;

CREATE TABLE `master_instansi` (
  `instansi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `instansi_nama` varchar(255) NOT NULL,
  `instansi_keterangan` text,
  `instansi_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`instansi_id`),
  UNIQUE KEY `uniq` (`instansi_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `master_instansi` */

insert  into `master_instansi`(`instansi_id`,`instansi_nama`,`instansi_keterangan`,`instansi_last_update`) values (4,'PT Maju','','2021-02-01 20:21:40');
insert  into `master_instansi`(`instansi_id`,`instansi_nama`,`instansi_keterangan`,`instansi_last_update`) values (5,'PT Abc','','2021-02-02 22:56:51');

/*Table structure for table `master_jenis_dokumen` */

DROP TABLE IF EXISTS `master_jenis_dokumen`;

CREATE TABLE `master_jenis_dokumen` (
  `jdok_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jdok_nama` varchar(100) NOT NULL,
  `jdok_keterangan` text,
  PRIMARY KEY (`jdok_id`),
  UNIQUE KEY `uniq` (`jdok_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `master_jenis_dokumen` */

insert  into `master_jenis_dokumen`(`jdok_id`,`jdok_nama`,`jdok_keterangan`) values (1,'Wasiats','');
insert  into `master_jenis_dokumen`(`jdok_id`,`jdok_nama`,`jdok_keterangan`) values (8,'Surat Izin','');

/*Table structure for table `master_kecamatan` */

DROP TABLE IF EXISTS `master_kecamatan`;

CREATE TABLE `master_kecamatan` (
  `kec_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kec_nama` varchar(50) NOT NULL,
  PRIMARY KEY (`kec_id`),
  UNIQUE KEY `uniq` (`kec_nama`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `master_kecamatan` */

insert  into `master_kecamatan`(`kec_id`,`kec_nama`) values (3,'Ngagliks');
insert  into `master_kecamatan`(`kec_id`,`kec_nama`) values (2,'Ngemplak');

/*Table structure for table `modul` */

DROP TABLE IF EXISTS `modul`;

CREATE TABLE `modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `label` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `nama_function` varchar(100) NOT NULL,
  `icon` varchar(30) DEFAULT NULL,
  `aksi_edit` enum('0','1') NOT NULL DEFAULT '1',
  `aksi_hapus` enum('0','1') NOT NULL DEFAULT '1',
  `aksi_tambah` enum('0','1') NOT NULL DEFAULT '1',
  `menu_order` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `modul` */

insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (1,0,'Dashboard','dashboard','index',NULL,'0','0','0',0);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (2,0,'Master Data','master','#','fa fa-gear','0','0','0',0);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (3,2,'Data Instansi','master','instansi',NULL,'1','1','1',1);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (4,2,'Jenis Dokumen','master','jenis_dokumen',NULL,'1','1','1',2);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (5,2,'Kecamatan','master','kecamatan',NULL,'1','1','1',3);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (6,2,'Desa','master','desa',NULL,'1','1','1',4);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (7,0,'Transaksi Pengiriman','transaksi','index',NULL,'1','1','1',1);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (8,0,'Informasi','informasi','index',NULL,'1','1','1',2);
insert  into `modul`(`id`,`parent_id`,`label`,`controller`,`nama_function`,`icon`,`aksi_edit`,`aksi_hapus`,`aksi_tambah`,`menu_order`) values (9,0,'Daftar User','user','index','fa fa-group','1','1','1',3);

/*Table structure for table `trans_pengiriman` */

DROP TABLE IF EXISTS `trans_pengiriman`;

CREATE TABLE `trans_pengiriman` (
  `trans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trans_instansi_id` int(10) unsigned NOT NULL,
  `trans_jdok_id` int(10) unsigned NOT NULL,
  `trans_penerima` varchar(100) NOT NULL,
  `trans_desa_id` int(10) unsigned NOT NULL,
  `trans_alamat` varchar(255) DEFAULT NULL,
  `trans_keterangan` text,
  `trans_lokasi` varchar(255) DEFAULT NULL,
  `trans_foto` varchar(50) DEFAULT NULL,
  `trans_tanggal` date NOT NULL,
  `trans_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_status` enum('0','1','2') DEFAULT '0' COMMENT '0 belum dikirim, 1 sudah terkirim, 2 gagal terkirim',
  `trans_user` int(11) NOT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `fk-1` (`trans_instansi_id`),
  KEY `fk-2` (`trans_jdok_id`),
  KEY `fk-3` (`trans_desa_id`),
  KEY `fk-4` (`trans_user`),
  CONSTRAINT `fk-1` FOREIGN KEY (`trans_instansi_id`) REFERENCES `master_instansi` (`instansi_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-2` FOREIGN KEY (`trans_jdok_id`) REFERENCES `master_jenis_dokumen` (`jdok_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-3` FOREIGN KEY (`trans_desa_id`) REFERENCES `master_desa` (`desa_id`) ON UPDATE CASCADE,
  CONSTRAINT `fk-4` FOREIGN KEY (`trans_user`) REFERENCES `master_admin` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `trans_pengiriman` */

insert  into `trans_pengiriman`(`trans_id`,`trans_instansi_id`,`trans_jdok_id`,`trans_penerima`,`trans_desa_id`,`trans_alamat`,`trans_keterangan`,`trans_lokasi`,`trans_foto`,`trans_tanggal`,`trans_update`,`trans_status`,`trans_user`) values (1,4,1,'Wanto',1,'Alamat','Keterangan','Lapangan','foto.jpg','2021-02-02','2021-02-03 22:09:31','0',1);
insert  into `trans_pengiriman`(`trans_id`,`trans_instansi_id`,`trans_jdok_id`,`trans_penerima`,`trans_desa_id`,`trans_alamat`,`trans_keterangan`,`trans_lokasi`,`trans_foto`,`trans_tanggal`,`trans_update`,`trans_status`,`trans_user`) values (3,5,8,'PT Majusss',1,'Jln Rayasss','Keterangansss','Lokasisss',NULL,'2021-02-02','2021-02-06 01:42:08','0',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
