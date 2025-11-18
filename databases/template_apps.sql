/*
SQLyog Ultimate
MySQL - 8.0.30 : Database - dms_laravel
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

insert  into `menu_roles`(`id_menus`,`id_roles`) values (1,1),(2,1),(3,1),(4,1),(5,3),(5,1),(4,3),(6,1),(6,2),(6,3),(6,4),(7,1),(7,2),(4,2),(1,2),(2,2),(8,1),(10,3),(11,3),(10,1),(11,1),(12,1),(13,1),(13,2),(11,2),(10,2),(14,1),(16,1);

/*Table structure for table `menus` */

CREATE TABLE `menus` (
  `id_menus` int NOT NULL AUTO_INCREMENT,
  `id_menu_kategori` int DEFAULT NULL,
  `nama_menu` varchar(50) DEFAULT NULL,
  `class` varchar(50) DEFAULT NULL,
  `url_link` varchar(50) DEFAULT NULL,
  `id_modules` int DEFAULT NULL,
  `posisi` varchar(50) DEFAULT NULL,
  `id_parent` int DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `urutan` int DEFAULT NULL,
  PRIMARY KEY (`id_menus`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus` */

insert  into `menus`(`id_menus`,`id_menu_kategori`,`nama_menu`,`class`,`url_link`,`id_modules`,`posisi`,`id_parent`,`is_active`,`urutan`) values (1,1,'Master Settings','bi bi-gear-fill','#',1,'sidebar',0,1,1),(2,1,'User Settings','bi bi-person-circle','user-settings',1,'sidebar',1,1,3),(3,1,'Master User Roles','bi bi-people-fill','user-roles',1,'sidebar',1,1,2),(4,0,'Profiles','bi bi-person','profile',2,'navbar',0,1,1),(5,1,'Dashboard','bi bi-grid','dashboard',1,'sidebar',0,1,0),(6,1,'Master Module','bi bi-journal-plus','master-module',3,'sidebar',1,1,4),(7,1,'Menu Setup','bi bi-menu-button-wide','menu-management',4,'sidebar',1,1,6),(10,2,'Document Menu','bi bi-folder-fill','#',6,'sidebar',0,1,2),(11,2,'Reimbursement','bi bi-cash','reimburse-menu',6,'sidebar',10,0,1),(12,1,'Email Menu','bi bi-envelope-at-fill','email-menu',7,'sidebar',1,0,6),(13,1,'Reimbursement Category','bi bi-wallet2','reimburse-category',8,'sidebar',1,0,7),(14,1,'Menu Category','bi bi-menu-button-wide','menu-categories-setup',9,'sidebar',1,1,5),(15,1,'Dashboard Document','bi bi-folder','dashboard-document',10,'sidebar',10,1,1),(16,1,'Dashboard Document','bi bi-folder','dashboard-document',10,'sidebar',10,1,1);

/*Table structure for table `menus_kategori` */

CREATE TABLE `menus_kategori` (
  `id_menu_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) DEFAULT NULL,
  `deskripsi_menu` varchar(50) DEFAULT NULL,
  `is_active` int DEFAULT NULL,
  `urutan` int DEFAULT NULL,
  PRIMARY KEY (`id_menu_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `menus_kategori` */

insert  into `menus_kategori`(`id_menu_kategori`,`nama_kategori`,`deskripsi_menu`,`is_active`,`urutan`) values (1,'Master Settings','',1,1),(2,'Document','',1,2),(3,'Recruitment',NULL,0,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `module_roles` */

insert  into `module_roles`(`id_module_roles`,`id_module`,`id_role`,`can_read`,`can_create`,`can_update`,`can_delete`) values (1,1,1,1,1,1,1),(2,2,1,1,1,1,1),(3,1,3,1,1,1,1),(4,3,1,1,1,1,1),(5,1,2,1,1,1,1),(8,6,3,1,1,1,1),(9,6,1,1,1,1,1),(10,7,1,1,1,1,1),(11,8,1,1,1,1,1),(12,8,2,1,1,1,1),(13,6,2,1,1,1,1),(14,9,1,1,1,1,1),(16,10,1,1,0,0,0);

/*Table structure for table `modules` */

CREATE TABLE `modules` (
  `id_modules` int NOT NULL AUTO_INCREMENT,
  `nama_modules` varchar(50) DEFAULT NULL,
  `judul_modules` varchar(50) DEFAULT NULL,
  `login` int DEFAULT '0',
  `deskripsi` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `modules` */

insert  into `modules`(`id_modules`,`nama_modules`,`judul_modules`,`login`,`deskripsi`) values (1,'AuthController/UserController','User Controller',1,'User Control'),(2,'AuthController/ProfileController','Profile Controller',1,'Profile Controller'),(3,'ModuleController/Module','Module Controller',1,'Adding Module Controller'),(4,'MenuController/Menu','Menu Controller',1,'Menu Setup'),(6,'ReimbursementController/Reimbursement','Reimburse',1,'Reimburse for All Staff'),(7,'EmailController/Email','Email Controller',1,'Email Notification'),(9,'MenuController/MenuCategory','Adding Menu Category',1,'Adding menu category before add menu'),(10,'DocumentController/Document','Document Controller',1,'Document Controller for all employee and integrate using NAS Synology');

/*Table structure for table `password_reset_tokens` */

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `reimburse_category` */

CREATE TABLE `reimburse_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `limit_per_month` decimal(10,0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

/*Data for the table `reimburse_category` */

insert  into `reimburse_category`(`id`,`category_name`,`limit_per_month`,`created_at`,`is_deleted`,`created_by`,`updated_at`,`updated_by`) values (1,'Transportasi',500000,'2025-06-17 19:09:21',0,1,NULL,NULL),(2,'Makan',500000,'2025-06-17 19:09:52',0,1,NULL,NULL),(3,'Kesehatan',1000000,'2025-06-17 19:10:10',0,1,NULL,NULL);

/*Table structure for table `reimburse_employee` */

CREATE TABLE `reimburse_employee` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `description` mediumtext CHARACTER SET armscii8 COLLATE armscii8_bin,
  `id_approval_user` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `id_category_reimburse` int DEFAULT NULL,
  `status_reimburse` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `bukti_transaksi` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `is_deleted` smallint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

/*Data for the table `reimburse_employee` */

/*Table structure for table `reimbursement_logs` */

CREATE TABLE `reimbursement_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reimbursement_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `reimbursement_logs` */

/*Table structure for table `role_access` */

CREATE TABLE `role_access` (
  `id_role_access` int NOT NULL AUTO_INCREMENT,
  `nama_role_access` varchar(50) DEFAULT NULL,
  `ket_role_access` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_role_access`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `role_access` */

insert  into `role_access`(`id_role_access`,`nama_role_access`,`ket_role_access`) values (1,'all','Boleh Akses Semua Data'),(2,'no','Tidak Boleh Akses Semua Data'),(3,'own','Hanya Data Miliknya Sendiri');

/*Table structure for table `roles` */

CREATE TABLE `roles` (
  `id_roles` int NOT NULL AUTO_INCREMENT,
  `nama_roles` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `is_deleted` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_roles`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

/*Data for the table `roles` */

insert  into `roles`(`id_roles`,`nama_roles`,`is_deleted`,`updated_at`,`created_at`) values (1,'Superadmin',0,'2025-06-17 02:00:50',NULL),(2,'Manager',0,NULL,NULL),(3,'Employee/Staff',0,NULL,NULL),(5,'User',0,'2025-06-17 02:13:17','2025-06-16 14:24:46');

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

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values ('A7smlyljB1IGk2Z2ltVbgRyfOuOQmBjIkPWGaHFZ',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUlqcXFnb3hXWHEzVTh2UWJwUndWdlF0VjNEb1dmMW1xYnVDYUJHNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9kbXNfcHJvZ3JhbS50ZXN0L21lbnUtbWFuYWdlbWVudCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1763450410);

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

insert  into `user_roles`(`id_user`,`id_role`) values (1,1),(2,2),(3,3),(4,4);

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

insert  into `users`(`id`,`role_id`,`email`,`username`,`full_name`,`email_verified_at`,`password`,`remember_token`,`photo_profile`,`is_login`,`gender`,`is_verified`,`last_login`,`created_at`,`updated_at`) values (1,1,'superadmin@example','admin','Superadmin',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,1,NULL,'verified','2025-02-25 07:31:01','2025-02-24 02:01:15','2025-10-01 13:09:21'),(2,3,'employee@example.com','staff','Staff',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,NULL,0,NULL,'verified',NULL,'2025-02-24 02:57:08','2025-06-18 08:12:55'),(3,2,'manager@example.com','manager','Manager',NULL,'$2y$12$21fKKnRjj5MFKUsjellMg.UGpKkTuZeYnojzQxTEyonJJGfH6qTRq',NULL,'default.svg',0,NULL,NULL,NULL,NULL,'2025-06-18 08:10:02');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
