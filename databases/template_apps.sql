/*
SQLyog Ultimate
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

/*Table structure for table `cache` */

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

/*Table structure for table `cache_locks` */

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `calon_tamu` */

CREATE TABLE `calon_tamu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `nama_tamu` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(255) DEFAULT NULL,
  `hubungan_kerabat` int DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_by` varchar(10) DEFAULT NULL,
  `updated_by` varchar(10) DEFAULT NULL,
  `deleted_by` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `calon_tamu` */

/*Table structure for table `failed_jobs` */

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

/*Table structure for table `job_batches` */

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

/*Table structure for table `menu_roles` */

CREATE TABLE `menu_roles` (
  `id_menus` int DEFAULT NULL,
  `id_roles` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menu_roles` */

insert  into `menu_roles`(`id_menus`,`id_roles`) values (1,2),(2,2),(4,2),(5,2),(3,2),(13,2),(12,2),(14,2),(15,3),(15,2),(1,3),(13,3),(12,3);

/*Table structure for table `menus` */

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus` */

insert  into `menus`(`id_menus`,`id_menu_kategori`,`id_modules`,`id_parent`,`nama_menu`,`class`,`url_link`,`posisi`,`is_active`,`urutan`) values (1,1,1,0,'Dashboard','bi bi-house','/dashboard','sidebar',1,0),(2,2,2,0,'Master Settings','bi bi-gear-fill','#','sidebar',1,1),(3,3,3,2,'User Settings','bi bi-person-fill','#','sidebar',1,1),(4,3,3,3,'User List','bi bi-person-lines-fill','/users','sidebar',1,2),(5,3,3,3,'User Roles','bi bi-person-gear','/user-roles','sidebar',1,3),(6,4,4,2,'Module Master','bi bi-journal-check','#','sidebar',1,4),(7,4,4,6,'Module Settings','bi bi-journal-plus','/master-module','sidebar',1,1),(8,5,5,2,'Menu Management','bi bi-universal-access-circle','#','sidebar',1,5),(9,5,5,8,'Menu Settings','bi bi-universal-access','/menu-management','sidebar',1,1),(10,5,5,8,'Menu Assignment','bi bi-person-video2','/menu-assignment','sidebar',1,2),(11,4,4,6,'Module Assignment','bi bi-journal-check','/module-assign','sidebar',1,2),(12,6,7,0,'Undangan Digital','bi bi-envelope-paper-heart','#','sidebar',1,1),(13,6,7,12,'Order List','bi bi-cart4','/undangan-digital-order','sidebar',1,3),(14,6,7,12,'Settings Layout','bi bi-layout-wtf','/layout/settings/undangan-digital','sidebar',1,1),(15,6,7,12,'Daftar Undangan','bi bi-person-vcard-fill','/cita/undangan-digital/tamu-undangan','sidebar',1,2);

/*Table structure for table `menus_kategori` */

CREATE TABLE `menus_kategori` (
  `id_menu_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `deskripsi_menu` varchar(50) DEFAULT NULL,
  `is_active` int DEFAULT '0',
  `urutan` int DEFAULT NULL,
  PRIMARY KEY (`id_menu_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus_kategori` */

insert  into `menus_kategori`(`id_menu_kategori`,`nama_kategori`,`deskripsi_menu`,`is_active`,`urutan`) values (1,'Dashboard','',1,0),(2,'Master Settings',NULL,1,1),(3,'User Settings','',1,2),(4,'Module Settings',NULL,1,3),(5,'Menu Settings',NULL,1,4),(6,'Undangan Digital',NULL,1,5);

/*Table structure for table `migrations` */

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_06_18_073727_create_reimbursement_logs_table',2);

/*Table structure for table `module_roles` */

CREATE TABLE `module_roles` (
  `id_module_roles` int NOT NULL AUTO_INCREMENT,
  `id_module` int NOT NULL,
  `id_role` int DEFAULT NULL,
  `can_read` int DEFAULT '0',
  `can_create` int DEFAULT '0',
  `can_update` int DEFAULT '0',
  `can_delete` int DEFAULT '0',
  PRIMARY KEY (`id_module_roles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `module_roles` */

insert  into `module_roles`(`id_module_roles`,`id_module`,`id_role`,`can_read`,`can_create`,`can_update`,`can_delete`) values (1,1,2,1,0,0,0),(2,2,2,1,0,0,0),(3,3,2,1,0,0,0),(4,4,2,0,0,0,0),(5,7,2,1,1,1,1),(6,7,3,1,1,1,0),(7,1,3,1,0,0,0);

/*Table structure for table `modules` */

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `modules` */

insert  into `modules`(`id_modules`,`nama_modules`,`judul_modules`,`is_deleted`,`login`,`deskripsi`,`created_at`,`created_by`,`updated_at`,`updated_by`,`deleted_at`,`deleted_by`) values (1,'Dashboard','Dashboard',0,1,'Dashboard','2025-11-20 15:15:59','Superadmin',NULL,NULL,NULL,NULL),(2,'Master Settings','Master Settings',0,1,'Master Settings','2025-11-20 15:24:51','Superadmin',NULL,NULL,NULL,NULL),(3,'User Settings','User Settings',0,1,'User List','2025-11-20 15:38:15','Superadmin',NULL,NULL,NULL,NULL),(4,'Module Settings','Module Settings',0,1,'Module Settings','2025-11-21 10:09:32','Superadmin',NULL,NULL,NULL,NULL),(5,'Menu Settings','Menu Settings',0,1,'Setting Menu','2025-11-21 11:21:12','Superadmin',NULL,NULL,'2025-11-21 04:21:46','Superadmin'),(6,'Menu Assign','Menu Assign',0,1,'Menu Assign','2025-11-21 14:34:47','Superadmin',NULL,NULL,NULL,NULL),(7,'Undangan Digital','Undangan Digital',0,1,'Undangan Digital','2025-11-22 04:48:19','Superadmin',NULL,NULL,NULL,NULL);

/*Table structure for table `password_reset_tokens` */

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `roles` */

CREATE TABLE `roles` (
  `id_roles` int NOT NULL AUTO_INCREMENT,
  `nama_roles` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `is_deleted` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_roles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

/*Data for the table `roles` */

insert  into `roles`(`id_roles`,`nama_roles`,`is_deleted`,`created_at`,`updated_at`) values (1,'Superadmin',0,'2025-11-20 09:19:57',NULL),(2,'Admin',0,'2025-11-21 16:34:20',NULL),(3,'User',0,'2025-11-21 16:34:22',NULL),(4,'Finance',1,NULL,NULL);

/*Table structure for table `sessions` */

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

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values ('9Iq2NXr88vPUBzgNToZoU1OZUX7uyumPOlunQE1i',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoibVFXQUN1bW5MUTRpejlOUTduVFhTTlRYWWowT2JmaGtMSDdXMnIwcSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cHM6Ly9jaXRhLnRlc3QvbWFzdGVyLW1vZHVsZSI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwczovL2NpdGEudGVzdC9tZW51LWFzc2lnbm1lbnQiO3M6NToicm91dGUiO3M6MTU6Im1lbnUtYXNzaWdubWVudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1763787886),('usP4ASd2dsodTUxcYo1Kw2Cs01etHns8q25O6aDS',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSWs1bGlBc0d2OGIwcWZXUnJhMjY2SFVYZDJSeVhibnU4T1MwNDJNbyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyNzoiaHR0cHM6Ly9jaXRhLnRlc3QvZGFzaGJvYXJkIjt9czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHBzOi8vY2l0YS50ZXN0L2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=',1763787888);

/*Table structure for table `tokenize` */

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

CREATE TABLE `user_log_activity` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `activity_user` varchar(300) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `user_log_activity` */

/*Table structure for table `user_roles` */

CREATE TABLE `user_roles` (
  `id_user` int DEFAULT NULL,
  `id_role` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `user_roles` */

insert  into `user_roles`(`id_user`,`id_role`) values (1,1),(2,2),(3,3);

/*Table structure for table `users` */

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

insert  into `users`(`id`,`role_id`,`email`,`username`,`full_name`,`email_verified_at`,`password`,`remember_token`,`photo_profile`,`is_login`,`gender`,`is_verified`,`last_login`,`created_at`,`updated_at`) values (1,1,'superadmin@example','superadmin','Superadmin',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,1,NULL,'verified','2025-02-25 07:31:01','2025-02-24 02:01:15','2025-11-20 08:27:12'),(2,2,'employee@example.com','admin','admin',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,0,NULL,'verified',NULL,'2025-02-24 02:57:08','2025-11-22 05:04:10'),(3,3,'manager@example.com','user','Idham Mansyah',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,'default.svg',1,NULL,NULL,NULL,NULL,'2025-11-20 09:00:54');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
