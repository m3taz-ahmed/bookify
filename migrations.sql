
   INFO  Running migrations.  

  0001_01_01_000000_create_users_table .............................................................................................................  
  ⇂ create table `users` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `role_id` bigint unsigned null, `is_active` tinyint(1) not null default '1', `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `users` add constraint `users_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete set null  
  ⇂ alter table `users` add unique `users_email_unique`(`email`)  
  ⇂ create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, primary key (`email`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ create table `sessions` (`id` varchar(255) not null, `user_id` bigint unsigned null, `ip_address` varchar(45) null, `user_agent` text null, `payload` longtext not null, `last_activity` int not null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `sessions` add index `sessions_user_id_index`(`user_id`)  
  ⇂ alter table `sessions` add index `sessions_last_activity_index`(`last_activity`)  
  0001_01_01_000001_create_cache_table .............................................................................................................  
  ⇂ create table `cache` (`key` varchar(255) not null, `value` mediumtext not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ create table `cache_locks` (`key` varchar(255) not null, `owner` varchar(255) not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  0001_01_01_000002_create_jobs_table ..............................................................................................................  
  ⇂ create table `jobs` (`id` bigint unsigned not null auto_increment primary key, `queue` varchar(255) not null, `payload` longtext not null, `attempts` tinyint unsigned not null, `reserved_at` int unsigned null, `available_at` int unsigned not null, `created_at` int unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `jobs` add index `jobs_queue_index`(`queue`)  
  ⇂ create table `job_batches` (`id` varchar(255) not null, `name` varchar(255) not null, `total_jobs` int not null, `pending_jobs` int not null, `failed_jobs` int not null, `failed_job_ids` longtext not null, `options` mediumtext null, `cancelled_at` int null, `created_at` int not null, `finished_at` int null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`)  
  2025_11_24_135222_create_services_table ..........................................................................................................  
  ⇂ create table `services` (`id` bigint unsigned not null auto_increment primary key, `name_en` varchar(255) not null, `name_ar` varchar(255) not null, `description` text null, `duration_minutes` int not null, `price` decimal(10, 2) not null, `is_active` tinyint(1) not null default '1', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  2025_11_24_135316_create_shifts_table ............................................................................................................  
  ⇂ create table `shifts` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `day_of_week` tinyint not null comment '0-6 (Sunday-Saturday)', `start_time` time not null, `end_time` time not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `shifts` add constraint `shifts_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade  
  2025_11_24_135344_create_bookings_table ..........................................................................................................  
  ⇂ create table `bookings` (`id` bigint unsigned not null auto_increment primary key, `reference_code` varchar(255) not null, `customer_name` varchar(255) not null, `customer_phone` varchar(255) not null, `service_id` bigint unsigned not null, `employee_id` bigint unsigned not null, `booking_date` date not null, `start_time` time not null, `end_time` time not null, `status` enum('pending', 'confirmed', 'completed', 'cancelled') not null default 'pending', `payment_status` varchar(255) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `bookings` add constraint `bookings_service_id_foreign` foreign key (`service_id`) references `services` (`id`) on delete cascade  
  ⇂ alter table `bookings` add constraint `bookings_employee_id_foreign` foreign key (`employee_id`) references `users` (`id`) on delete cascade  
  ⇂ alter table `bookings` add index `bookings_booking_date_start_time_index`(`booking_date`, `start_time`)  
  ⇂ alter table `bookings` add index `bookings_reference_code_index`(`reference_code`)  
  ⇂ alter table `bookings` add unique `bookings_reference_code_unique`(`reference_code`)  
  2025_11_24_172529_add_checked_in_at_to_bookings_table ............................................................................................  
  ⇂ alter table `bookings` add `checked_in_at` timestamp null after `payment_status`  
  2025_11_24_181454_create_sessions_table ..........................................................................................................  
  ⇂ create table `sessions` (`id` varchar(255) not null, `user_id` bigint unsigned null, `ip_address` varchar(45) null, `user_agent` text null, `payload` longtext not null, `last_activity` int not null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `sessions` add index `sessions_user_id_index`(`user_id`)  
  ⇂ alter table `sessions` add index `sessions_last_activity_index`(`last_activity`)  
  2025_11_24_182240_create_permission_tables .......................................................................................................  
  ⇂ create table `permissions` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `guard_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `permissions` add unique `permissions_name_guard_name_unique`(`name`, `guard_name`)  
  ⇂ create table `roles` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `guard_name` varchar(255) not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `roles` add unique `roles_name_guard_name_unique`(`name`, `guard_name`)  
  ⇂ create table `model_has_permissions` (`permission_id` bigint unsigned not null, `model_type` varchar(255) not null, `model_id` bigint unsigned not null, primary key (`permission_id`, `model_id`, `model_type`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `model_has_permissions` add index `model_has_permissions_model_id_model_type_index`(`model_id`, `model_type`)  
  ⇂ alter table `model_has_permissions` add constraint `model_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade  
  ⇂ create table `model_has_roles` (`role_id` bigint unsigned not null, `model_type` varchar(255) not null, `model_id` bigint unsigned not null, primary key (`role_id`, `model_id`, `model_type`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `model_has_roles` add index `model_has_roles_model_id_model_type_index`(`model_id`, `model_type`)  
  ⇂ alter table `model_has_roles` add constraint `model_has_roles_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade  
  ⇂ create table `role_has_permissions` (`permission_id` bigint unsigned not null, `role_id` bigint unsigned not null, primary key (`permission_id`, `role_id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `role_has_permissions` add constraint `role_has_permissions_permission_id_foreign` foreign key (`permission_id`) references `permissions` (`id`) on delete cascade  
  ⇂ alter table `role_has_permissions` add constraint `role_has_permissions_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade  
  ⇂ delete from `cache` where `key` in ('bookify-cache-spatie.permission.cache', 'bookify-cache-illuminate:cache:flexible:created:spatie.permission.cache')  
  2025_11_24_183003_remove_role_id_from_users_table ................................................................................................  
  ⇂ alter table `users` drop foreign key `users_role_id_foreign`  
  ⇂ alter table `users` drop `role_id`  
  2025_11_24_203435_add_sort_order_to_services_table ...............................................................................................  
  ⇂ alter table `services` add `sort_order` int not null default '0' after `is_active`  
  CreateActivityLogTable ...........................................................................................................................  
  ⇂ create table `activity_log` (`id` bigint unsigned not null auto_increment primary key, `log_name` varchar(255) null, `description` text not null, `subject_type` varchar(255) null, `subject_id` bigint unsigned null, `causer_type` varchar(255) null, `causer_id` bigint unsigned null, `properties` json null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `activity_log` add index `subject`(`subject_type`, `subject_id`)  
  ⇂ alter table `activity_log` add index `causer`(`causer_type`, `causer_id`)  
  ⇂ alter table `activity_log` add index `activity_log_log_name_index`(`log_name`)  
  AddEventColumnToActivityLogTable .................................................................................................................  
  ⇂ alter table `activity_log` add `event` varchar(255) null after `subject_type`  
  AddBatchUuidColumnToActivityLogTable .............................................................................................................  
  ⇂ alter table `activity_log` add `batch_uuid` char(36) null after `properties`  
  2025_11_24_213256_create_personal_access_tokens_table ............................................................................................  
  ⇂ create table `personal_access_tokens` (`id` bigint unsigned not null auto_increment primary key, `tokenable_type` varchar(255) not null, `tokenable_id` bigint unsigned not null, `name` text not null, `token` varchar(64) not null, `abilities` text null, `last_used_at` timestamp null, `expires_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `personal_access_tokens` add index `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)  
  ⇂ alter table `personal_access_tokens` add unique `personal_access_tokens_token_unique`(`token`)  
  ⇂ alter table `personal_access_tokens` add index `personal_access_tokens_expires_at_index`(`expires_at`)  
  2025_11_24_221652_create_employee_service_durations_table ........................................................................................  
  ⇂ create table `employee_service_durations` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `service_id` bigint unsigned not null, `duration` int not null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `employee_service_durations` add constraint `employee_service_durations_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade  
  ⇂ alter table `employee_service_durations` add constraint `employee_service_durations_service_id_foreign` foreign key (`service_id`) references `services` (`id`) on delete cascade  
  ⇂ alter table `employee_service_durations` add unique `employee_service_durations_user_id_service_id_unique`(`user_id`, `service_id`)  
  2025_11_24_223544_create_customers_table .........................................................................................................  
  ⇂ create table `customers` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `phone` varchar(255) null, `email_verified_at` timestamp null, `password` varchar(255) not null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `customers` add unique `customers_email_unique`(`email`)  
  2025_11_24_224115_add_customer_id_to_bookings_table ..............................................................................................  
  ⇂ alter table `bookings` add `customer_id` bigint unsigned null  
  ⇂ alter table `bookings` add constraint `bookings_customer_id_foreign` foreign key (`customer_id`) references `customers` (`id`) on delete set null  
  2025_11_24_224934_create_customer_password_reset_tokens_table ....................................................................................  
  ⇂ create table `customer_password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci'  
  ⇂ alter table `customer_password_reset_tokens` add index `customer_password_reset_tokens_email_index`(`email`)  

