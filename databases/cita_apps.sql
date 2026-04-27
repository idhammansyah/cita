/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - cita_apps
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cita_apps` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `cita_apps`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id_contact` bigint unsigned NOT NULL,
  `name_contact` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_alias` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `info_contact` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `id_group` bigint unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `contacts` */

insert  into `contacts`(`id_contact`,`name_contact`,`name_alias`,`phone`,`email`,`address`,`info_contact`,`id_group`,`created_at`,`updated_at`,`deleted_at`) values 
(2,'Paramita Rahayu',NULL,'0773 7436 9177','darman.budiman@gmail.co.id','Ds. Cikutra Timur No. 914, Lubuklinggau 38881, Jambi',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(3,'Fitria Usamah',NULL,'0551 2425 7805','andriani.nadine@gmail.com','Ds. Bakau Griya Utama No. 992, Pekanbaru 86545, Jabar',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(4,'Uchita Kusmawati',NULL,'0832 292 515','santoso.luis@gmail.co.id','Jln. Moch. Toha No. 740, Palangka Raya 26854, Malut',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(5,'Novi Juli Agustina',NULL,'(+62) 997 2221 355','dewi33@gmail.co.id','Ki. Ters. Buah Batu No. 480, Jayapura 84941, Sumut',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(6,'Asirwanda Simbolon',NULL,'0236 1928 4694','dinda.handayani@gmail.com','Jr. Qrisdoren No. 437, Surabaya 37065, Riau',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(7,'Irnanto Firmansyah',NULL,'020 9390 505','eka85@yahoo.com','Ds. K.H. Wahid Hasyim (Kopo) No. 661, Palopo 31679, Sulsel',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(8,'Ayu Wastuti',NULL,'027 6348 081','prakasa.zaenab@yahoo.com','Kpg. Yogyakarta No. 960, Bengkulu 59720, Aceh',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(9,'Aslijan Thamrin',NULL,'(+62) 594 3771 9788','bastuti@yahoo.com','Psr. Dago No. 253, Kupang 94136, Jambi',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(10,'Hardana Maheswara',NULL,'0395 4365 4396','swulandari@gmail.co.id','Ki. Babadak No. 648, Depok 86584, Kalsel',NULL,1,'2024-05-02 17:38:41',NULL,NULL),
(12,'Agus','','','','','',1,'2024-05-02 17:40:19','2024-05-02 17:40:19',NULL),
(14,'Miss Gerry Oberbrunner',NULL,'1-267-559-4240','jamir.haley@ratke.net','149 Vesta Route\nPort Roslyn, WI 57441-4989',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(15,'Olga Hutagalung',NULL,'(+62) 658 6902 152','nadia.pradana@gmail.co.id','Ki. Suryo No. 750, Pontianak 20106, Kepri',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(16,'Bancar Agus Mustofa',NULL,'0260 6484 5708','putu39@gmail.co.id','Dk. Basoka No. 227, Lubuklinggau 55592, Jambi',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(17,'Bala Permadi',NULL,'0874 2694 257','melani.daru@yahoo.com','Psr. Lada No. 929, Semarang 71004, DIY',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(18,'Timbul Langgeng Kuswoyo S.Farm',NULL,'(+62) 352 1034 4852','narpati.asmadi@gmail.com','Jr. Babakan No. 141, Ambon 12512, Sulteng',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(19,'Maimunah Hasanah',NULL,'(+62) 817 356 291','lsaragih@gmail.co.id','Ds. Wahidin Sudirohusodo No. 757, Yogyakarta 56513, Lampung',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(20,'Bakda Prayoga S.Psi',NULL,'0376 1122 4002','hakim.widya@yahoo.com','Psr. Bambu No. 47, Tasikmalaya 87560, Jambi',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(21,'Tasnim Jarwadi Tamba M.Pd',NULL,'0870 0470 728','widiastuti.gara@yahoo.com','Psr. Rajawali No. 254, Probolinggo 36165, Jambi',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(22,'Cindy Jamalia Suryatmi S.Farm',NULL,'(+62) 691 9730 0400','rrahayu@gmail.co.id','Gg. Raya Ujungberung No. 141, Manado 44667, Aceh',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(23,'Tirta Gandi Irawan S.Pt',NULL,'(+62) 760 9271 0983','rahimah.belinda@yahoo.co.id','Psr. Abdul Muis No. 619, Administrasi Jakarta Timur 69423, Malut',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(24,'Qori Susanti',NULL,'(+62) 607 0212 0064','safitri.farhunnisa@gmail.com','Ds. Baik No. 685, Administrasi Jakarta Pusat 61199, Jateng',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(25,'Koko Bagus Gunarto',NULL,'(+62) 585 0898 3590','oyolanda@yahoo.co.id','Ds. Jamika No. 517, Banda Aceh 96176, Riau',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(26,'Lili Haryanti',NULL,'0895 0915 1402','bhakim@yahoo.com','Jln. Suryo No. 406, Sorong 63322, Sumbar',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(27,'Elisa Rahimah',NULL,NULL,'prayogo72@gmail.co.id','Ds. Raden Saleh No. 957, Tebing Tinggi 53294, Pabar',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL),
(28,'Tukijo',NULL,NULL,NULL,'5 langkah dari rumah',NULL,1,'2024-05-02 17:41:49','2024-05-02 17:41:49',NULL);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `galleries` */

DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wedding_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `wedding_id` (`wedding_id`),
  CONSTRAINT `galleries_ibfk_1` FOREIGN KEY (`wedding_id`) REFERENCES `weddings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `galleries` */

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id_group` bigint unsigned NOT NULL,
  `name_group` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `info_group` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `groups` */

insert  into `groups`(`id_group`,`name_group`,`info_group`,`created_at`,`updated_at`,`deleted_at`) values 
(1,'Teman Kerja','','2024-05-02 17:38:24','2024-05-02 19:11:38',NULL),
(2,'Teman Kuliah','','2024-05-02 17:38:33','2024-05-02 19:11:42',NULL),
(3,'Teman Sekolah','','2024-05-02 19:11:50','2024-05-02 19:11:50',NULL);

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `love_stories` */

DROP TABLE IF EXISTS `love_stories`;

CREATE TABLE `love_stories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wedding_id` bigint unsigned NOT NULL,
  `year` varchar(10) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `wedding_id` (`wedding_id`),
  CONSTRAINT `love_stories_ibfk_1` FOREIGN KEY (`wedding_id`) REFERENCES `weddings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `love_stories` */

/*Table structure for table `master_jenis_undangan` */

DROP TABLE IF EXISTS `master_jenis_undangan`;

CREATE TABLE `master_jenis_undangan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_undangan` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `master_jenis_undangan` */

insert  into `master_jenis_undangan`(`id`,`jenis_undangan`,`slug`,`is_deleted`) values 
(1,'Pernikahan','pernikahan',0),
(2,'Tunangan','tunangan',0),
(3,'Aqiqah','aqiqah',0),
(4,'Khitan','khitan',0),
(5,'Ulang Tahun','ulang-tahun',0),
(6,'Syukuran','syukuran',0),
(7,'Lamaran','lamaran',0),
(8,'Gathering','gathering',0),
(9,'Acara Perusahaan','acara-perusahaan',0),
(10,'Reuni','reuni',0),
(11,'Lainnya','lainnya',0);

/*Table structure for table `menu_roles` */

DROP TABLE IF EXISTS `menu_roles`;

CREATE TABLE `menu_roles` (
  `id_menus` int DEFAULT NULL,
  `id_roles` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menu_roles` */

insert  into `menu_roles`(`id_menus`,`id_roles`) values 
(1,2),
(4,2),
(5,2),
(3,2),
(13,2),
(12,2),
(14,2),
(15,3),
(15,2),
(1,3),
(13,3),
(12,3),
(16,2),
(16,3),
(19,2),
(2,2),
(21,2),
(18,2),
(17,2);

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id_menus` int NOT NULL AUTO_INCREMENT,
  `id_menu_kategori` int DEFAULT NULL,
  `id_modules` int DEFAULT NULL,
  `id_parent` int DEFAULT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url_link` varchar(50) DEFAULT NULL,
  `posisi` enum('sidebar','navbar') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `is_active` int DEFAULT '0',
  `urutan` int DEFAULT NULL,
  PRIMARY KEY (`id_menus`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus` */

insert  into `menus`(`id_menus`,`id_menu_kategori`,`id_modules`,`id_parent`,`nama_menu`,`class`,`url_link`,`posisi`,`is_active`,`urutan`) values 
(1,1,1,0,'Dashboard','bi bi-house','/dashboard','sidebar',1,0),
(2,2,2,0,'Master Settings','bi bi-gear-fill','#','sidebar',1,1),
(3,3,3,2,'User Settings','bi bi-person-fill','#','sidebar',1,1),
(4,3,3,3,'User List','bi bi-person-lines-fill','/users','sidebar',1,2),
(5,3,3,3,'User Roles','bi bi-person-gear','/user-roles','sidebar',1,3),
(6,4,4,2,'Module Master','bi bi-journal-check','#','sidebar',1,4),
(7,4,4,6,'Module Settings','bi bi-journal-plus','/master-module','sidebar',1,1),
(8,5,5,2,'Menu Management','bi bi-universal-access-circle','#','sidebar',1,5),
(9,5,5,8,'Menu Settings','bi bi-universal-access','/menu-management','sidebar',1,1),
(10,5,5,8,'Menu Assignment','bi bi-person-video2','/menu-assignment','sidebar',1,2),
(11,4,4,6,'Module Assignment','bi bi-journal-check','/module-assign','sidebar',1,2),
(12,6,7,0,'Undangan Digital','bi bi-envelope-paper-heart','#','sidebar',1,1),
(13,6,7,12,'Order List','bi bi-cart4','/undangan-digital-order','sidebar',1,2),
(14,6,7,12,'Settings Layout','bi bi-layout-wtf','/layout/settings/undangan-digital','sidebar',1,1),
(15,6,7,12,'Daftar Tamu','bi bi-person-vcard-fill','/cita/undangan-digital/tamu-undangan','sidebar',1,3),
(16,6,7,12,'Review Us','bi bi-stars','/review-cita/undangan','sidebar',1,4),
(17,7,8,0,'My Wedding','bi bi-flower3','#','sidebar',1,1),
(18,7,8,17,'My Wedding Dreams','bi bi-flower3','/edit/invitation/wedding-of-idham-and-riska','sidebar',1,1),
(19,7,8,21,'List Tamu','bi bi-person-vcard-fill','/list-undangan','sidebar',1,2),
(20,7,8,21,'List Group Undangan','bi bi-list','/list-group-undangan','sidebar',1,3),
(21,7,8,17,'Tamu','bi bi-people','#','sidebar',1,4);

/*Table structure for table `menus_kategori` */

DROP TABLE IF EXISTS `menus_kategori`;

CREATE TABLE `menus_kategori` (
  `id_menu_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `deskripsi_menu` varchar(50) DEFAULT NULL,
  `is_active` int DEFAULT '0',
  `urutan` int DEFAULT NULL,
  PRIMARY KEY (`id_menu_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus_kategori` */

insert  into `menus_kategori`(`id_menu_kategori`,`nama_kategori`,`deskripsi_menu`,`is_active`,`urutan`) values 
(1,'Dashboard','',1,0),
(2,'Master Settings',NULL,1,1),
(3,'User Settings','',1,2),
(4,'Module Settings',NULL,1,3),
(5,'Menu Settings',NULL,1,4),
(6,'Undangan Digital',NULL,1,5),
(7,'Invitation',NULL,1,6);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_06_18_073727_create_reimbursement_logs_table',2);

/*Table structure for table `module_roles` */

DROP TABLE IF EXISTS `module_roles`;

CREATE TABLE `module_roles` (
  `id_module_roles` int NOT NULL AUTO_INCREMENT,
  `id_module` int NOT NULL,
  `id_role` int DEFAULT NULL,
  `can_read` int DEFAULT '0',
  `can_create` int DEFAULT '0',
  `can_update` int DEFAULT '0',
  `can_delete` int DEFAULT '0',
  PRIMARY KEY (`id_module_roles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `module_roles` */

insert  into `module_roles`(`id_module_roles`,`id_module`,`id_role`,`can_read`,`can_create`,`can_update`,`can_delete`) values 
(1,1,2,1,1,1,1),
(2,2,2,1,0,0,0),
(3,3,2,1,0,0,0),
(4,4,2,0,0,0,0),
(5,7,2,1,1,1,1),
(6,7,3,1,1,1,0),
(7,1,3,1,1,1,1),
(8,8,2,1,1,1,1),
(9,8,3,1,0,0,0);

/*Table structure for table `modules` */

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id_modules` int NOT NULL AUTO_INCREMENT,
  `nama_modules` varchar(50) DEFAULT NULL,
  `judul_modules` varchar(50) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `login` int DEFAULT '0',
  `deskripsi` varchar(300) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `modules` */

insert  into `modules`(`id_modules`,`nama_modules`,`judul_modules`,`is_deleted`,`login`,`deskripsi`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,'Dashboard','Dashboard',0,1,'Dashboard','2025-11-20 15:15:59','Superadmin',NULL,NULL,NULL,NULL),
(2,'Master Settings','Master Settings',0,1,'Master Settings','2025-11-20 15:24:51','Superadmin',NULL,NULL,NULL,NULL),
(3,'User Settings','User Settings',0,1,'User List','2025-11-20 15:38:15','Superadmin',NULL,NULL,NULL,NULL),
(4,'Module Settings','Module Settings',0,1,'Module Settings','2025-11-21 10:09:32','Superadmin',NULL,NULL,NULL,NULL),
(5,'Menu Settings','Menu Settings',0,1,'Setting Menu','2025-11-21 11:21:12','Superadmin',NULL,NULL,'2025-11-21 04:21:46','Superadmin'),
(6,'Menu Assign','Menu Assign',0,1,'Menu Assign','2025-11-21 14:34:47','Superadmin',NULL,NULL,NULL,NULL),
(7,'Undangan Digital','Undangan Digital',0,1,'Undangan Digital','2025-11-22 04:48:19','Superadmin',NULL,NULL,NULL,NULL),
(8,'My Invitation Wedding','Wedding For Idham & Riska',0,1,NULL,'2025-12-08 06:31:15','Superadmin',NULL,NULL,NULL,NULL);

/*Table structure for table `notification_recipients` */

DROP TABLE IF EXISTS `notification_recipients`;

CREATE TABLE `notification_recipients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `notification_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notif_recipient_idx` (`notification_id`),
  KEY `notif_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `notification_recipients` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT 'info',
  `module` varchar(100) DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `notifications` */

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id_roles` int NOT NULL AUTO_INCREMENT,
  `nama_roles` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_roles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

/*Data for the table `roles` */

insert  into `roles`(`id_roles`,`nama_roles`,`is_deleted`,`created_at`,`updated_at`) values 
(1,'Superadmin',0,'2025-11-20 09:19:57',NULL),
(2,'Admin',0,'2025-11-21 16:34:20',NULL),
(3,'User',0,'2025-11-21 16:34:22',NULL),
(4,'Finance',1,NULL,NULL);

/*Table structure for table `rsvps` */

DROP TABLE IF EXISTS `rsvps`;

CREATE TABLE `rsvps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wedding_id` bigint unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `kehadiran` enum('Hadir','Tidak Hadir') DEFAULT 'Hadir',
  `ucapan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wedding_id` (`wedding_id`),
  CONSTRAINT `rsvps_ibfk_1` FOREIGN KEY (`wedding_id`) REFERENCES `weddings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `rsvps` */

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('6OmX3l3K1DCDySB9IlFD7vOeqfdzCaK1FqzvUL4S',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0','YToyOntzOjY6Il90b2tlbiI7czo0MDoiVEdTa1Z0S2VNb2dXV3RNTmhYdDY3SUdzdFZmUWJ3bWpPbGRJRlE0SCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1772087224),
('BsSeOvSm62gu823ILIgRDZMFtLqB8Sxja254H8XZ',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiQVkzNFU5eXF1TVRuS3VjWjA2dlNJck1vZ0ZMWjc2MGlSaHY5eWJ1WSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cHM6Ly9jaXRhLnRlc3QvbGlzdC11bmRhbmdhbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2NpdGEudGVzdC9saXN0LXVuZGFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJsaXN0X3VuZGFuZ2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1772176173),
('fxovfv7ddgbN0ssCmN7N5FBPkLMZAQUGw3W1XtdL',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUzNRRWRlTE1EMnk2Qmp3YVhIUEpWcDJyWWh0ZnhXVFdVZHdpZWhaZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cHM6Ly9jaXRhLnRlc3QvbGlzdC11bmRhbmdhbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2NpdGEudGVzdC9saXN0LXVuZGFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJsaXN0X3VuZGFuZ2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1772096825),
('ketNqSbrcdkfQ6rU02DCKBWYRFYRkbjjVg9ZtlUI',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRm5KdUFldVhmMmE3blo5RncwUUFKdUxGdkVFWnFGUmV3V3B3bGxRTCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cHM6Ly9jaXRhLnRlc3QvbGlzdC11bmRhbmdhbiI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMxOiJodHRwczovL2NpdGEudGVzdC9saXN0LXVuZGFuZ2FuIjtzOjU6InJvdXRlIjtzOjEzOiJsaXN0X3VuZGFuZ2FuIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1772162159),
('sWxNYSnmh2ALnxOkT5k24Gms6kPiA5dPmgqgCG2w',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRTQzaFJEaGs1c3VIcmZuT2VOSFRiZnEyTzQ0M1hDUWdkT3FZRjNpRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9lZGl0L2ludml0YXRpb24vd2VkZGluZy1vZi1pZGhhbS1hbmQtcmlza2EiO3M6NToicm91dGUiO3M6Nzoid2VkZGluZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1776498641),
('t4g4ZkbnTTcXPR9RKzkmDLm1NELPMqojr7Iw2nVa',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoibTBkdmJ4RXdQM25YV3VjeHZNaGtnNkgxaE04UEdiam1oTXN1ZERzNiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2VkaXQvaW52aXRhdGlvbi93ZWRkaW5nLW9mLWlkaGFtLWFuZC1yaXNrYSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjY0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZWRpdC9pbnZpdGF0aW9uL3dlZGRpbmctb2YtaWRoYW0tYW5kLXJpc2thIjtzOjU6InJvdXRlIjtzOjc6IndlZGRpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1776521522),
('W3nN4xbX7gDexqp7Enrv1AOSNTlBZHo4ZjPTWXDJ',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:149.0) Gecko/20100101 Firefox/149.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWWFzeWM5SnljWDlabk9HaVFuUDlZanhsQVl1d0pRcU1UOW5DUUc1ZCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo2NDoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2VkaXQvaW52aXRhdGlvbi93ZWRkaW5nLW9mLWlkaGFtLWFuZC1yaXNrYSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjY0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZWRpdC9pbnZpdGF0aW9uL3dlZGRpbmctb2YtaWRoYW0tYW5kLXJpc2thIjtzOjU6InJvdXRlIjtzOjc6IndlZGRpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1776516162);

/*Table structure for table `tamu` */

DROP TABLE IF EXISTS `tamu`;

CREATE TABLE `tamu` (
  `id_tamu` int NOT NULL AUTO_INCREMENT,
  `id_groups` int DEFAULT NULL,
  `tamu_dari` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama_tamu` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_sent` int DEFAULT '0',
  `info_tamu` varchar(255) DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tamu`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tamu` */

insert  into `tamu`(`id_tamu`,`id_groups`,`tamu_dari`,`email`,`nama_tamu`,`address`,`phone`,`is_sent`,`info_tamu`,`is_deleted`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,3,'Idham',NULL,'Pak Jangga & Istri','Abhati Group','+6281272521287',0,NULL,0,'2026-02-25 07:06:45','Superadmin','2026-04-18 06:56:35',NULL,'2026-02-25 08:05:46','Superadmin'),
(2,3,'Idham',NULL,'Pak Alex & Istri','Abhati Group','+628568091320',0,NULL,0,'2026-02-25 07:06:45','Superadmin','2026-04-18 06:56:56',NULL,'2026-02-25 08:07:38','Superadmin'),
(3,2,'Idham',NULL,'Alliffian Ihza & Partner','Swasembada','+62 812-9280-6397',0,NULL,0,'2026-02-26 04:20:30','Superadmin','2026-04-18 07:33:41',NULL,NULL,NULL),
(4,3,'Idham',NULL,'Gilbert Dear & Partner','Abhati Group','+62851-5609-2540',0,NULL,0,'2026-04-18 06:56:00','Superadmin','2026-04-18 06:56:00',NULL,NULL,NULL),
(5,3,'Idham',NULL,'Abdul Faqih & Istri','Abhati Group','+62898-9981-792',0,NULL,0,'2026-04-18 06:56:00','Superadmin','2026-04-18 06:56:00',NULL,NULL,NULL),
(6,3,'Idham',NULL,'Mba Imas & Suami','Abhati Group','+62878-7753-0428',0,NULL,0,'2026-04-18 06:56:00','Superadmin','2026-04-18 06:56:00',NULL,NULL,NULL),
(7,3,'Idham',NULL,'Mas Elvan & Istri','Abhati Group','+62878-7988-8287',0,NULL,0,'2026-04-18 06:56:00','Superadmin','2026-04-18 12:46:42',NULL,NULL,NULL),
(8,3,'Idham',NULL,'Desi & Partner','Abhati Group','+62859-5952-2571',0,NULL,0,'2026-04-18 06:56:00','Superadmin','2026-04-18 06:56:00',NULL,NULL,NULL),
(9,3,'Idham',NULL,'Gaby & Partner','Abhati Group','+62851-7337-0308',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(10,3,'Idham',NULL,'Yohana & Partner','Abhati Group','+62 812-5589-8059',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(11,3,'Idham',NULL,'Sebastian & Partner','Abhati Group','+62811-855-749',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(12,3,'Idham',NULL,'Pak Luth & Istri','Abhati Group','+62812-8850-032',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(13,3,'Idham',NULL,'Ka Amanda & Partner','Abhati Group','+62811-150-371',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(14,3,'Idham',NULL,'Pak Deny & Istri','Abhati Group','+62878-7680-4072',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(15,3,'Idham',NULL,'Anang & Partner','Abhati Group','+62857-7035-9969',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(16,3,'Idham',NULL,'Lurry & Partner','Abhati Group','+62857-7792-9036',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(17,3,'Idham',NULL,'Pak Depin & Istri','Abhati Group','+62857-1559-9227',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(18,3,'Idham',NULL,'Bu Milka & Suami','Abhati Group','+62858-9320-2862',0,NULL,0,'2026-04-18 07:07:09','Superadmin','2026-04-18 07:07:09',NULL,NULL,NULL),
(19,3,'Idham',NULL,'Abner & Partner','Abhati Group','+62851-5724-7336',0,NULL,0,'2026-04-18 12:46:21','Superadmin','2026-04-18 12:46:21',NULL,NULL,NULL),
(20,3,'Idham',NULL,'Mas Leo & Partner','Abhati Group','+62819-0863-1313',0,NULL,0,'2026-04-18 12:46:21','Superadmin','2026-04-18 12:46:21',NULL,NULL,NULL);

/*Table structure for table `tamu_groups` */

DROP TABLE IF EXISTS `tamu_groups`;

CREATE TABLE `tamu_groups` (
  `id_group_tamu` int NOT NULL AUTO_INCREMENT,
  `nama_group_tamu` varchar(255) DEFAULT NULL,
  `info_tamu` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_group_tamu`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tamu_groups` */

insert  into `tamu_groups`(`id_group_tamu`,`nama_group_tamu`,`info_tamu`,`is_deleted`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values 
(1,'Keluarga',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),
(2,'Teman',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),
(3,'Rekan Kerja',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `tokenize` */

DROP TABLE IF EXISTS `tokenize`;

CREATE TABLE `tokenize` (
  `id_tokenize` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `status` int DEFAULT NULL,
  `informasi` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `expired_at` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_tokenize`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tokenize` */

/*Table structure for table `user_log_activity` */

DROP TABLE IF EXISTS `user_log_activity`;

CREATE TABLE `user_log_activity` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `activity_user` varchar(300) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `user_log_activity` */

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id_user` int DEFAULT NULL,
  `id_role` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id_user`,`id_role`) values 
(1,1),
(2,2),
(3,3);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_profile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'default.svg',
  `is_login` int DEFAULT NULL,
  `gender` int DEFAULT NULL,
  `is_verified` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `Index 3` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role_id`,`email`,`username`,`full_name`,`email_verified_at`,`password`,`remember_token`,`photo_profile`,`is_login`,`gender`,`is_verified`,`last_login`,`created_at`,`updated_at`) values 
(1,1,'superadmin@example','superadmin','Superadmin',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,1,NULL,'verified','2025-02-25 07:31:01','2025-02-24 02:01:15','2026-02-24 08:18:10'),
(2,2,'employee@example.com','admin','admin',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,0,NULL,'verified',NULL,'2025-02-24 02:57:08','2026-01-20 07:47:50'),
(3,3,'manager@example.com','user','Idham Mansyah',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,'default.svg',0,NULL,NULL,NULL,NULL,'2026-02-24 08:26:28');

/*Table structure for table `weddings` */

DROP TABLE IF EXISTS `weddings`;

CREATE TABLE `weddings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `m_pria` varchar(255) NOT NULL,
  `m_pria_panggilan` varchar(100) DEFAULT NULL,
  `m_pria_ayah` varchar(255) DEFAULT NULL,
  `m_pria_ibu` varchar(255) DEFAULT NULL,
  `m_wanita` varchar(255) NOT NULL,
  `m_wanita_panggilan` varchar(100) DEFAULT NULL,
  `m_wanita_ayah` varchar(255) DEFAULT NULL,
  `m_wanita_ibu` varchar(255) DEFAULT NULL,
  `tgl_akad` datetime NOT NULL,
  `tgl_resepsi` datetime NOT NULL,
  `lokasi_nama` varchar(255) DEFAULT NULL,
  `lokasi_address` text,
  `Maps_url` text,
  `music_url` varchar(255) DEFAULT NULL,
  `quote_quran` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `weddings` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
