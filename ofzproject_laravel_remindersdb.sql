-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 08:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ofzproject_laravel_remindersdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(19, '2024_07_26_102840_create_system_menus_table', 2),
(20, '2024_07_31_054127_create_routes_permissions_table', 2),
(27, '2024_08_02_031929_remove_columns_from_routes_permissions', 3),
(28, '2024_08_02_032118_add_permission_type_to_routes_permissions', 3),
(29, '2024_08_02_034710_create_permissionsTypes_table', 4),
(30, '2024_08_02_040347_create_system_users_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions_types`
--

CREATE TABLE `permissions_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_type` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions_types`
--

INSERT INTO `permissions_types` (`id`, `permission_type`, `created_at`, `updated_at`) VALUES
(1, 'read', '2024-08-02 04:00:05', '2024-08-02 04:00:05'),
(2, 'create', '2024-08-02 04:00:05', '2024-08-02 04:00:05'),
(3, 'update', '2024-08-02 04:00:05', '2024-08-02 04:00:05'),
(4, 'delete', '2024-08-02 04:00:05', '2024-08-02 04:00:05'),
(5, 'post', '2024-08-02 04:00:05', '2024-08-02 04:00:05'),
(6, 'print', '2024-08-02 04:00:05', '2024-08-02 04:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes_permissions`
--

CREATE TABLE `routes_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `main_route` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `userType` varchar(255) NOT NULL,
  `permission_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_menus`
--

CREATE TABLE `system_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `route` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_menus`
--

INSERT INTO `system_menus` (`id`, `name`, `route`, `parent_id`, `order`, `created_at`, `updated_at`) VALUES
(1, 'REMINDERS', 'index.reminders', NULL, 1, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(2, 'PREPAID SERVICES', 'index.prepaid', NULL, 2, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(3, 'CUSTOMERS', 'index.customers', NULL, 2, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(4, 'DOCUMENTS', 'index.documents', NULL, 3, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(5, 'PAY ONLINE', 'index.payonline', NULL, 4, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(6, 'TASK', 'index.tasks', NULL, 4, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(7, 'REPORTS', 'index.reports', NULL, 5, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(8, 'ACCOUNTING', 'index.accounting', NULL, 6, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(9, 'SETTINGS', 'index.settings', NULL, 8, '2024-07-26 00:33:58', '2024-07-26 00:33:58'),
(10, 'PRE REMINDERS', 'index.prepreminders', 1, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(11, 'RECURRING AMMENDMENTS', 'index.recurringammendments', 1, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(12, 'RECURRING REMINDERS', 'index.recurringreminders', 1, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(13, 'GENERATED REMINDERS', 'index.generatedreminders', 1, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(14, 'REMINDER DELIVERY', 'index.reminderdelivery', 1, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(15, 'ARCHIVE CATEGORIES', 'index.archivecategories', 1, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(16, 'ALLOCATE CUSTOMER RECEIPT', 'index.allocatecustomer', 1, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(17, 'FISCAL RECEIPTS', 'index.fiscalreceipts', 1, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(18, 'COMMUNICATIONS', 'index.communications', 1, 9, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(19, 'SUSPENDED LIST', 'index.suspendedlist', 1, 10, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(20, 'TERMINATED LIST', 'index.terminatedlist', 1, 11, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(21, 'Customers', 'index.prepaidcustomers', 2, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(22, 'Followups', 'index.prepaidfollowups', 2, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(23, '4G Active Customers', 'index.prepaidactivecustomer', 2, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(24, 'Customers', 'index.cuscustomers', 3, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(25, 'Add Customer Groups', 'index.cusaddcustomergroups', 3, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(26, 'Attachements', 'index.cusattachements', 3, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(27, 'Debtors', 'index.cusdebtors', 3, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(28, 'Customer Receipts', 'index.cuscustomerreceipts', 3, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(29, 'Credit Notes', 'index.cuscreditnotes', 3, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(30, 'Allocate Customer Receipt', 'index.cusallocatecustomerreceipt', 3, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(31, 'Corrections', 'index.cuscorrections', 3, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(32, 'Debt Management', 'index.cusdebtmanagement', 3, 9, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(33, 'VAS', 'index.cusvas', 3, 10, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(34, 'WHT Cetificates', 'index.cuswhtcetificates', 3, 11, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(35, 'Quotation Formats', 'index.quotationformats', 4, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(36, 'Quotation Inclusions', 'index.quotationinclusions', 4, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(37, 'Add Quotation', 'index.addquotation', 4, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(38, 'View Quotation', 'index.viewquotation', 4, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(39, 'Approve Quotation', 'index.approvequotation', 4, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(40, 'Archive Categories', 'index.docarchivecategories', 4, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(41, 'Add Archive', 'index.addarchive', 4, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(42, 'Add Email Formats', 'index.addemailformats', 4, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(43, 'Send Emails', 'index.sendemails', 4, 9, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(44, 'Add Online Payment', 'index.addonlinepayment', 5, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(45, 'Credit Card Swipe Details', 'index.creditcardswipedetails', 5, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(46, 'Swiped Cards', 'index.swipedcards', 5, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(47, 'OTA Settlements Report', 'index.otasettlementsreport', 5, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(48, 'Credit Card Swipe Details Report', 'index.creditcardswipedetailsreport', 5, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(49, 'Add Bank Deposits', 'index.addbankdeposit', 5, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(50, 'Approve Bank Deposits', 'index.approvebankdeposits', 5, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(51, 'Credit Card Reconciliation', 'index.creditcardreconciliation', 5, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(52, 'Approval Requests', 'index.approvalrequests', 6, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(53, 'Tasks for the Day', 'index.thanksfortheday', 6, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(54, 'Tasks Responses', 'index.thanksresponses', 6, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(55, 'Recurring Connections by Next Date', 'index.recurringconnectionsbynextdate', 7, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(56, 'Receipt Details - REOD-REC-04', 'index.receiptdetailsreodrec', 7, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(57, 'Receipt Allocation', 'index.receiptallocation', 7, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(58, 'Credit Notes', 'index.creditnotes', 7, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(59, 'Creditnote Allocation', 'index.creditnoteallocation', 7, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(60, 'Reminders Report', 'index.remindersreport', 7, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(61, 'DEBT Allocation Report', 'index.debtallocationreport', 7, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(62, 'BAD Payers', 'index.badpayers', 7, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(63, 'Debtors Summary', 'index.debtorssummary', 7, 9, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(64, 'Revenue Report', 'index.revenuereport', 7, 10, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(65, 'Bank Reconciliation Report', 'index.bankreconciliationreport', 7, 11, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(66, 'Settlement Report', 'index.settlementreport', 7, 12, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(67, 'Deposits Reconciliation Report', 'index.depositsreconciliationreport', 7, 13, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(68, 'Receipt Refunds', 'index.receiptrefunds', 7, 14, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(69, 'Fiscal Receipts', 'index.reportfiscalreceipts', 7, 15, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(70, 'Nominal Categories', 'index.nominalcategories', 8, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(71, 'Nominal Sub Categories', 'index.nominalsubcategories', 8, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(72, 'Nominal Accounts', 'index.nominalaccounts', 8, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(73, 'Banks', 'index.banks', 8, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(74, 'Bank Accounts', 'index.bankaccounts', 8, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(75, 'Bank Transfer', 'index.banktransfer', 8, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(76, 'Bank Reconciliations', 'index.bankreconciliations', 8, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(77, 'Bank Deposit Types', 'index.bankdeposittypes', 8, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(78, 'System', 'index.system', 9, 1, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(79, 'Departments', 'index.departments', 9, 2, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(80, 'OTA Operators', 'index.otaoperators', 9, 3, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(81, 'Credit Card Types', 'index.creditcardtypes', 9, 4, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(82, 'Product Categories', 'index.productcategories', 9, 5, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(83, 'Products', 'index.products', 9, 6, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(84, 'Tax', 'index.tax', 9, 7, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(85, 'Default Payment Banks', 'index.defaultpaymentbanks', 9, 8, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(86, 'Currency exchange settings', 'index.currencyexchangesettings', 9, 9, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(87, 'Message Formats', 'index.messageformats', 9, 10, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(88, 'Currencies', 'index.currencies', 9, 11, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(89, 'Price Types', 'index.pricetypes', 9, 12, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(90, 'Users', 'index.users', 9, 13, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(91, 'Collection Bureaus', 'index.collectionbureaus', 9, 14, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(92, 'Territories', 'index.territories', 9, 15, '2024-07-26 00:39:52', '2024-07-26 00:39:52'),
(93, 'Set Employee OT Factor', 'index.setemployeeotfactor', 9, 16, '2024-07-26 00:39:52', '2024-07-26 00:39:52');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

CREATE TABLE `system_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `privilege` int(11) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `receipt_printer_id` varchar(75) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `group_id` varchar(20) NOT NULL DEFAULT 'OFFICE',
  `is_debt_collect` int(11) NOT NULL DEFAULT 0,
  `collection_bureau_id` int(11) NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `last_login_user_agent` varchar(255) DEFAULT NULL,
  `last_online` datetime DEFAULT NULL,
  `session_timeout` int(11) NOT NULL DEFAULT 3600,
  `tfa_phone` tinyint(4) NOT NULL DEFAULT 0,
  `tfa_email` tinyint(4) NOT NULL DEFAULT 0,
  `otp_code` varchar(25) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`id`, `branch_id`, `username`, `password`, `privilege`, `full_name`, `email`, `phone`, `receipt_printer_id`, `employee_id`, `group_id`, `is_debt_collect`, `collection_bureau_id`, `last_login_time`, `last_login_ip`, `last_login_user_agent`, `last_online`, `session_timeout`, `tfa_phone`, `tfa_email`, `otp_code`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '$2a$04$fmgWBv7iQ7Aw2RtzILmXeu6VH0j4.Qbxq/2sN30.tV0XG473iVCs.', 1, 'System Administrator', 'admin@globemw.net', '0999535555', '4-69a725f0-3636-11e9-8155-e0db55cbd564', 0, 'OFFICE', 1, 3, '2024-08-02 08:21:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2019-12-28 14:58:48', '2024-08-01 21:21:49'),
(2, 1, 'systemuser001', '21232f297a57a5a743894a0e4a801fc3', 4, 'SYSTEM USER', 'billing@globemw.net', '01841044', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2019-12-28 14:58:48', '2020-04-21 20:37:03'),
(1005, 1, 'mercyk', '471f41abd45a4e591d01bcaf163bcd3b', 4, 'MERCY MKUPU', 'salesbt6@globemw.net', '0883841469', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2019-12-28 14:58:48', '2020-04-22 21:19:16'),
(1017, 1, 'creditcontrol3@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Likson', 'creditcontrol3@globemw.net', '088', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 13, '2019-12-28 14:58:48', '2021-07-07 18:28:42'),
(1019, 1, 'hardley@yellowpagesmw.com', 'fde8a239b483fe71a2875d4294ff2425', 4, 'hardley', 'hardley@yellowpagesmw.com', '088255', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2019-12-28 14:58:48', '2022-09-15 20:18:11'),
(1025, 1, 'mani', 'f911b946447a82f83f2a7c7a3577ce97', 3, 'Manuel Fernandes', 'mani@globemw.net', '0888841257', '', 0, 'HEAD_OFFICE', 1, 0, '2024-07-22 06:32:31', '41.77.12.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 13, '2019-12-28 14:58:48', '2024-07-21 12:02:31'),
(1028, 1, 'mervism', '471f41abd45a4e591d01bcaf163bcd3b', 4, 'Mervis Masumba', 'mervis.masumba@yellowpagesmw.com', '0880', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2019-12-28 14:58:48', '2020-04-22 21:19:16'),
(1029, 1, 'billingofficer@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 4, 'Chimangu Chirwa', 'billingofficer@globemw.net', '0887016509', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:10:29', '2021-08-02 21:56:43'),
(1030, 1, 'creditcontrol2@globemw.net', '5d1f7b045ca3b4509746f51e8bf44b82', 5, 'Lickson Mayankho Mkona', 'creditcontrol2@globemw.net', '0880004661', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:11:51', '2021-07-07 18:27:58'),
(1031, 2, 'llwdesk@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Raphael Kuyesa', 'llwdesk@globemw.net', '0885978537', '', 0, 'OFFICE', 1, 4, '2024-05-17 10:41:42', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:12:49', '2024-05-16 19:22:37'),
(1032, 1, 'kmalida@globemw.net', '911d52b5243d608e1c76064b1b3cf5dd', 5, 'Kausar Malida', 'kmalida@globemw.net', '0999409449', '', 0, 'HEAD_OFFICE', 1, 2, '2024-07-19 16:39:41', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-04-22 21:13:38', '2024-07-18 22:09:41'),
(1033, 1, 'accounts.clerk@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 4, 'Esther Mhango', 'accounts.clerk@globemw.net', '0999475021', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:15:11', '2021-08-02 21:56:27'),
(1034, 1, 'del--gildebtors@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 5, 'Peter Silungwe', 'del--gildebtors@globemw.net', '0999089107', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:16:35', '2022-05-10 15:23:29'),
(1035, 2, 'linda@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Linda Kaunga', 'linda@globemw.net', '0882211', '', 0, 'OFFICE', 1, 4, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:17:27', '2021-08-02 21:57:15'),
(1036, 1, 'madhawa@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 8, 'Madhawa Vimukthi', 'madhawa@globemw.net', '0888246756', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:41:19', '2021-06-09 15:03:28'),
(1037, 1, 'techsales@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 8, 'Mercy Linje', 'techsales@globemw.net', '0993319395', '', 0, 'OFFICE', 1, 0, '2024-07-19 14:53:05', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-04-22 21:45:08', '2024-07-18 20:23:05'),
(1038, 1, 'psa@globemw.net', 'e117415ee47c41a6c6e20075642fb546', 8, 'Emmanuel Nangwale', 'psa@globemw.net', '0880834148', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-04-22 21:49:02', '2023-08-30 10:48:51'),
(1039, 1, 'gilaccounts@globemw.net', 'f7e55584f754b234060b3140e60a548e', 7, 'Willy', 'gilaccounts@globemw.net', '08822543', '', 0, 'OFFICE', 0, 0, '2024-07-22 07:35:07', '41.77.12.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-05-03 19:46:47', '2024-07-21 13:05:07'),
(1040, 1, 'maimba@globemw.net', '01a1b141d0c9e655775d59c1883572ea', 6, 'Alpha Maimba', 'maimba@globemw.net', '0885545', '', 0, 'OFFICE', 1, 0, '2024-07-19 16:37:13', '41.77.12.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-05-04 12:39:10', '2024-07-18 22:07:13'),
(1041, 1, 'gilcreditors@globemw.net', 'f7e55584f754b234060b3140e60a548e', 7, 'MC DONALD GALLION', 'gilcreditors@globemw.net', '08454555', '', 0, 'OFFICE', 0, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-05-04 12:40:46', '2023-08-30 10:46:54'),
(1042, 1, 'customerrelations@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 9, 'Dorothy', 'customerrelations@globemw.net', '08811322', '', 0, 'OFFICE', 1, 0, '2024-07-19 14:24:10', '41.77.12.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-08 22:57:35', '2024-07-18 19:54:10'),
(1043, 5, 'osbeleman@gmail.com', 'f7e55584f754b234060b3140e60a548e', 5, 'OSBORN LEMANI', 'osbeleman@gmail.com', '088215', '', 0, 'OFFICE', 1, 1, '2024-07-20 09:33:06', '154.66.124.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-09 15:18:18', '2024-07-19 15:03:06'),
(1044, 5, 'happy@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Happy', 'happy@globemw.net', '0881126', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-09 15:19:20', '2021-03-17 22:29:56'),
(1045, 3, 'del-salesbt7@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Alexander Chingoli', 'del-salesbt7@globemw.net', '08811232', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-09 16:25:08', '2022-07-17 21:55:45'),
(1046, 2, 'tamara@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Tamara Mulaga', 'tamara@globemw.net', '08822515', '', 0, 'OFFICE', 0, 0, '2024-07-19 09:23:43', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-09 16:34:50', '2024-07-18 14:53:43'),
(1047, 2, 'prisca@globemw.net', 'c1b9ad80d1ea8fe99d64a6755dd3f225', 5, 'Prisca Kapindula', 'prisca@globemw.net', '0882215', '', 0, 'OFFICE', 1, 0, '2024-07-20 10:20:26', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-09 16:36:29', '2024-07-19 15:50:26'),
(1048, 18, 'kennedy@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Kennedy Jumbe', 'kennedy@globemw.net', '022888', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-09 16:37:11', '2021-02-12 21:58:58'),
(1049, 3, 'delete_saleszomba@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Prisca Kagwale Phiri', 'delete_saleszomba@globemw.net', '08882514', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-09 16:38:46', '2022-08-03 15:13:53'),
(1050, 1, 'saman@globemw.net', '1fbd27bf945f31ee4792f5e540ef4014', 2, 'Saman Dissanayake', 'saman@globemw.net', '0882545', '', 0, 'OFFICE', 1, 0, '2024-07-19 08:20:53', '41.77.14.12', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-09 21:45:15', '2024-07-18 13:50:53'),
(1051, 1, 'samitha@globemw.net', '05d20ef19e6b1992b69d73489320016a', 4, 'Samitha', 'samitha@globemw.net', '0884109378', '', 0, 'OFFICE', 1, 0, '2024-07-10 14:27:23', '41.216.229.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-09 21:47:13', '2024-07-09 19:57:23'),
(1052, 1, 'gilsales@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Chifundo Kandani', 'gilsales@globemw.net', '0888114314', '', 0, 'OFFICE', 1, 2, '2024-07-22 07:49:27', '41.77.12.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:124.0) Gecko/20100101 Firefox/124.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-15 15:00:09', '2024-07-21 13:19:27'),
(1053, 1, 'mnkhuntha@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 10, 'Mike Mnkhuntha', 'mnkhuntha@globemw.net', '0888508408', '', 0, 'OFFICE', 1, 2, '2024-07-17 16:40:31', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-15 15:01:04', '2024-07-16 22:10:31'),
(1054, 1, 'salesbt4-del@globemw.net', 'c902f8718438520cb2c1b614444dd0c7', 5, 'Edward Chipofya', 'salesbt4-del@globemw.net', '0888917141', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-15 15:01:46', '2021-10-10 15:04:00'),
(1055, 2, 'gpsllw@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Timothy Kenani', 'gpsllw@globemw.net', '0884545454', '', 0, 'OFFICE', 1, 0, '2024-05-27 12:54:26', '41.77.13.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-15 15:02:44', '2024-05-26 18:24:26'),
(1056, 2, 'salesll4g@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Omar Jimmy', 'salesll4g@globemw.net', '088225155', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-15 15:03:23', '2021-10-31 17:28:44'),
(1057, 2, 'mervis@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 5, 'Mervis Nkhoma', 'mervis@globemw.net', '088255545', '', 0, 'OFFICE', 1, 0, '2024-07-13 11:16:11', '41.77.13.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-06-15 15:04:00', '2024-07-12 16:46:11'),
(1058, 1, 'salesbt8@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Daniel Cholomali', 'salesbt8@globemw.net', '0881412220', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2020-06-16 14:11:57', '2021-08-30 15:38:03'),
(1059, 2, 'mangala@globemw.net', '195907674d12d4260c489c2f28102070', 9, 'Mangala Pranama', 'mangala@globemw.net', '0888503982', '', 0, 'OFFICE', 1, 0, '2024-07-16 14:40:07', '212.104.231.240', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-11-19 13:41:13', '2024-07-15 20:10:07'),
(1060, 1, 'kondwani@globemw.net', '11411e54eafa00c41db2981f79d4cb47', 5, 'Kondwani Kacheche', 'kondwani@globemw.net', '0882949609', '', 0, 'OFFICE', 1, 0, '2024-07-22 07:16:59', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1, '2020-11-22 18:58:04', '2024-07-21 12:46:59'),
(1061, 2, 'davis@globemw.net', 'f7e55584f754b234060b3140e60a548e', 5, 'Davis Makiyoni', 'davis@globemw.net', '0995676553', '', 0, 'OFFICE', 1, 0, '2024-07-22 07:36:45', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2020-11-22 19:50:58', '2024-07-21 13:06:45'),
(1062, 1, 'lahirutm', '4d5b56966dd2bcf0d5e812a9bddeb513', 1, 'Lahiru Maduranga', 'lahirutm@globemw.net', '0094712284096', '', 0, 'OFFICE', 1, 0, '2024-06-14 10:37:37', '41.77.12.79', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:126.0) Gecko/20100101 Firefox/126.0', NULL, 3600, 0, 0, NULL, 1, 1, '2021-01-28 14:21:38', '2024-06-13 16:07:37'),
(1063, 18, 'globellw@globemw.net', '0922c0030870d036f7afae693fdd76eb', 7, 'Timothy', 'globellw@globemw.net', '0881111', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2021-02-22 15:38:29', '2023-07-10 21:43:08'),
(1064, 1, 'methga@globemw.net', 'a86a64593fa91d74e3c8c8cf5ee28f7e', 9, 'Methga Perera', 'methga@globemw.net', '0884577584', '', 0, 'HEAD_OFFICE', 1, 0, '2024-07-18 07:44:28', '41.77.12.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2021-02-23 16:33:18', '2024-07-17 13:14:28'),
(1065, 1, 'revenueacc@serendibhotel.com', '01361cdfcc808a2a436d956ae1632d22', 7, 'Suranga', 'revenueacc@serendibhotel.com', '071555555', '', 0, 'OFFICE', 1, 0, '2024-07-19 14:18:51', '124.43.71.166', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:128.0) Gecko/20100101 Firefox/128.0', NULL, 3600, 0, 0, NULL, 1, 1, '2021-03-14 13:08:33', '2024-07-18 19:48:51'),
(1066, 1, 'amila', '37309883a0b762bd9939fb547d88618e', 9, 'Amila Madushanka', 'amila@globemw.net', '088123456', '', 0, 'OFFICE', 1, 2, '2024-07-03 16:48:50', '41.77.8.66', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2021-06-02 14:23:32', '2024-07-02 22:18:50'),
(1067, 1, 'gilcreditcontrol-del@globemw.net', '01361cdfcc808a2a436d956ae1632d22', 5, 'Mathews GUNDE', 'gilcreditcontrol-del@globemw.net', '008811211421', '', 0, 'HEAD_OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-07-07 18:28:45', '2024-01-31 20:21:28'),
(1068, 1, 'lindatasi@globemw.net', 'fc636792eb398e4594568b4155c35cf0', 10, 'Linda Mwagomba', 'lindatasi@globemw.net', '08811111112', '', 0, 'OFFICE', 1, 0, '2024-04-12 09:01:54', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1, '2021-08-23 21:05:27', '2024-04-11 14:31:54'),
(1069, 1, 'salesbt1@globemw.net', 'fc636792eb398e4594568b4155c35cf0', 5, 'Charity Chiundiza', 'salesbt1@globemw.net', '0995159543', '', 0, 'OFFICE', 1, 0, '2024-07-20 10:29:50', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2021-08-23 21:12:11', '2024-07-19 15:59:50'),
(1070, 2, 'lakmal@globemw.net', 'be06ba5070cc2fe8e2b6dc06365a8f99', 10, 'Lakmal Arunashantha', 'lakmal@globemw.net', '088800', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-08-25 02:13:32', '2022-06-11 15:57:55'),
(1071, 1, 'elias@globemw.net', '29a2b2e1849474d94d12051309c7b4d7', 3, 'Elias Imaan', 'elias@globemw.net', '0882108651', '', 0, 'OFFICE', 1, 0, '2024-07-19 10:28:41', '41.77.12.106', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2021-08-30 13:31:31', '2024-07-18 15:58:41'),
(1072, 18, 'sujan@globemw.net', 'fc636792eb398e4594568b4155c35cf0', 10, 'Sujan Dharmarathna', 'sujan@globemw.net', '0885976431', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-08-31 22:45:08', '2023-09-20 14:17:38'),
(1073, 1, 'sanjeewa@globemw.net', '08464cd16c4f65f03de4e41e17e982f9', 1, 'Sanjeewa Vithanage', 'sanjeewa@globemw.net', '0888272544', '', 0, 'OFFICE', 1, 0, '2024-06-13 15:27:28', '41.77.12.85', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2021-09-08 20:07:07', '2024-06-12 20:57:28'),
(1074, 1, 'ramesh@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 10, 'Ramesh De Silva', 'ramesh@globemw.net', '0885514403', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-10-05 16:21:13', '2023-02-12 14:30:18'),
(1075, 2, 'customerrelatonsllw@globemw.net', 'e14762479cad06435618653977ed2fbf', 10, 'Tadala Kandoje', 'customerrelatonsllw@globemw.net', '0880850257', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-10-06 21:07:04', '2021-10-25 13:30:04'),
(1076, 41, 'salesbt444@globemw.net', 'fc636792eb398e4594568b4155c35cf0', 10, 'Sheena Litta', 'salesbt444@globemw.net', '0998123088', '', 0, 'OFFICE', 1, 2, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1025, '2021-10-10 15:05:32', '2022-02-28 15:34:13'),
(1077, 5, 'salesmz@globemw.net', 'fc636792eb398e4594568b4155c35cf0', 10, 'Ishmael MA Phiri', 'salesmz@globemw.net', '0883860168', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1, '2021-11-02 15:42:04', '2022-11-03 13:49:24'),
(1078, 1, 'docstore@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 9, 'Sophia', 'docstore@globemw.net', '0997101000', '', 0, 'OFFICE', 1, 0, '2024-07-17 16:19:20', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1, '2022-01-24 16:50:45', '2024-07-16 21:49:20'),
(1079, 1, 'user', '380a2d1d010c495497188fa9e5f996b5', 9, 'User', 'user@globemw.net', '081221233', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1, '2022-01-26 20:51:58', '2022-01-26 20:51:58'),
(1080, 1, 'salesbt4@globemw.net', '3d0ca4b02246ae9def1f8917ae3dc617', 10, 'Mbacha Chirambo', 'salesbt4@globemw.net', '0885286277', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-02-28 15:33:52', '2022-03-01 20:52:33'),
(1081, 5, 'danushka@globemw.net', '3c6ae63bcda8d31def43d5a435d1fcad', 9, 'Danushka Thilan', 'danushka@globemw.net', '0881169961', '', 0, 'OFFICE', 1, 0, '2024-06-26 07:29:11', '154.66.124.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-03-22 19:04:25', '2024-06-25 12:59:11'),
(1082, 1, 'del2-gildebtors@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 5, 'Joseph Minandi', 'del2-gildebtors@globemw.net', '0881111112', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1073, '2022-05-10 15:24:55', '2022-08-03 17:48:49'),
(1083, 2, 'techsupportllw@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Abdul Injesi', 'techsupportllw@globemw.net', '0888700254', '', 0, 'OFFICE', 1, 0, '2024-05-21 10:41:10', '102.70.2.165', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-05-20 18:36:06', '2024-05-20 16:11:10'),
(1084, 2, 'sheshan@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 10, 'Sheshan tharaka', 'sheshan@globemw.net', '0888416426', '', 0, 'OFFICE', 1, 0, '2024-04-20 10:41:01', '41.77.13.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-06-11 15:58:56', '2024-04-19 16:11:01'),
(1085, 2, 'ruhiru@globemw.net', 'cd7599f4f262316e2cfe2910898423d5', 10, 'Ruhiru Sanjay', 'ruhiru@globemw.net', '0884920540', '', 0, 'OFFICE', 1, 4, '2024-04-04 08:01:23', '41.216.230.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-06-21 21:48:30', '2024-04-03 13:31:23'),
(1086, 2, 'sampath@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 10, 'Udara Sampath', 'sampath@globemw.net', '0886506524', '', 0, 'OFFICE', 1, 0, '2024-07-11 18:54:23', '41.216.230.195', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36 OPR/111.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-06-21 21:49:31', '2024-07-11 00:24:23'),
(1087, 2, 'customerrelationsllw@globemw.net', '79384c3dad75c05139c4bd85fe5fd549', 10, 'Tariro MOYO', 'customerrelationsllw@globemw.net', '0888736527', '', 0, 'OFFICE', 1, 0, '2024-07-18 11:29:36', '41.216.228.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-07-10 19:57:02', '2024-07-17 16:59:36'),
(1088, 18, 'salesllw1@globemw.net', 'e38952e887b544f6f48c4891077846d8', 9, 'Innocent MASAPULA', 'salesllw1@globemw.net', '0881818987', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-07-10 19:58:08', '2022-11-01 13:44:46'),
(1089, 1, 'salesbt7@globemw.net', 'e807f1fcf82d132f9bb018ca6738a19f', 10, 'Chikondi Iweni', 'salesbt7@globemw.net', '01111111111', '', 0, 'OFFICE', 1, 0, '2024-04-26 15:47:31', '41.77.12.67', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-07-17 21:56:45', '2024-04-25 22:00:09'),
(1090, 3, 'cashierzomba@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 4, 'Joice Chirwa', 'cashierzomba@globemw.net', '0888033521', '', 0, 'OFFICE', 1, 0, '2024-07-19 10:29:03', '154.66.122.87', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-08-03 15:15:36', '2024-07-18 15:59:03'),
(1091, 1, 'gildebtors--3@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 10, 'Mercy Kapito', 'gildebtors--3@globemw.net', '0884804855', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 0, 1073, '2022-08-03 17:49:39', '2023-02-14 19:13:43'),
(1092, 18, 'sandaruwan@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 10, 'Sandaruwan Jayathunga', 'sandaruwan@globemw.net', '0887312699', '', 0, 'OFFICE', 1, 0, '2024-02-28 14:31:27', '41.77.13.253', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-08-05 15:56:28', '2024-02-27 20:01:27'),
(1093, 1, 'it@serendibhotel.com', '4b55a05e08a71224bd68d222cb12a508', 2, 'Sanjeewa Wijewardhana', 'it.pms@globemw.net', '088004667', '', 0, 'HEAD_OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-08-21 19:56:33', '2024-06-13 16:10:44'),
(1094, 1, 'nishan@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 8, 'Nishan', 'nishan@globemw.net', '0881598575', '', 0, 'OFFICE', 1, 0, '2024-07-19 10:46:56', '41.216.229.131', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-09 14:53:21', '2024-07-18 16:16:56'),
(1095, 1, 'noc247@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Gift Tembo', 'noc247@globemw.net', '0888879488', '', 0, 'OFFICE', 1, 0, '2024-07-19 15:49:14', '41.216.229.34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0', NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-11 13:42:59', '2024-07-18 21:19:14'),
(1096, 1, 'mbumba@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Mbumba Mdeza', 'mbumba@globemw.net', '0888051266', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-22 14:49:30', '2022-09-22 14:49:30'),
(1097, 1, 'bethia@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Bethia Banda', 'bethia@globemw.net', '0997217478', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-22 14:51:17', '2022-09-22 14:51:17'),
(1098, 1, 'tamandani@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Tamandani Mwagomba', 'tamandani@globemw.net', '0999984104', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-22 14:52:17', '2022-09-22 14:52:17'),
(1099, 1, 'dalirani@globemw.net', 'fde8a239b483fe71a2875d4294ff2425', 8, 'Dalirani Musonje', 'dalirani@globemw.net', '0888497767', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-09-22 14:53:04', '2022-09-22 14:53:04'),
(1100, 1, 'roshantha@globemw.net', '4b55a05e08a71224bd68d222cb12a508', 10, 'Roshantha Peiris', 'roshantha@globemw.net', '0888464444', '', 0, 'OFFICE', 1, 0, NULL, NULL, NULL, NULL, 3600, 0, 0, NULL, 1, 1073, '2022-10-30 22:26:14', '2022-10-30 22:26:14'),
(1101, 1, 'gildebtors@globemw.net', '1933586b806eb334126c1735fc1c4a21', 4, 'Tiyamike Nhlema', 'gildebtors@globemw.net', '0888111112', '', 0, 'OFFICE', 1, 0, '2024-07-20 09:22:29', '41.77.12.67', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', NULL, 3600, 0, 0, NULL, 1, 1073, '2023-02-14 19:14:47', '2024-07-19 14:52:29'),
(1102, 2, 'kingsley@globemw.net', 'f4b1dc573340ee3a12e68875ae966e6d', 9, 'Kingsley Gadama', 'kingsley@globemw.net', '0887786402', '', 0, 'OFFICE', 1, 0, '2023-10-24 11:02:41', '41.216.228.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 0, 1025, '2023-04-17 15:14:54', '2023-11-16 14:00:31'),
(1103, 1, 'gilcreditcontrol@globemw.net', '6709bec7aacf27e9256ac829b2fbcea4', 5, 'Herbert Malizani', 'gilcreditcontrol@globemw.net', '08800046611', '', 0, 'HEAD_OFFICE', 1, 2, '2024-07-19 13:22:24', '41.77.14.21', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2024-01-31 20:20:50', '2024-07-18 18:52:24'),
(1104, 1, 'nishantha@globemw.net', '7acc05835e45bde840a8df28f72fd1d3', 9, 'Nishantha Thennakon', 'nishantha@globemw.net', '0888888888', '', 0, 'HEAD_OFFICE', 1, 0, '2024-07-17 07:48:01', '41.77.12.73', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2024-02-21 19:54:21', '2024-07-16 13:18:01'),
(1105, 1, 'keisha@globemw.net', '8c988912a61d671b802c944ab5a033bc', 8, 'Keisha Callcentre', 'keisha@globemw.net', '0888888881', '', 0, 'HEAD_OFFICE', 1, 0, '2024-07-16 10:10:52', '41.77.8.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2024-04-21 21:12:27', '2024-07-15 15:40:52'),
(1106, 1, 'kelvin@globemw.net', '8c988912a61d671b802c944ab5a033bc', 8, 'Kelvin Callcentre', 'kelvin@globemw.net', '0888888831', '', 0, 'HEAD_OFFICE', 1, 0, '2024-07-22 07:36:09', '41.77.8.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2024-04-21 21:13:16', '2024-07-21 13:06:09'),
(1107, 2, 'thusitha@globemw.net', '7135dd3a03516ec51c8af60602cca368', 9, 'Thusitha Perera', 'thusitha@globemw.net', '888416426', '', 0, 'LILONGWE', 1, 0, '2024-05-24 12:20:26', '41.77.13.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', NULL, 3600, 0, 0, NULL, 1, 1073, '2024-05-05 21:40:09', '2024-05-23 17:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` varchar(25) NOT NULL DEFAULT 'user',
  `extensions` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `email_verified_at`, `password`, `privilege`, `extensions`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'LahiruTM', 'lahirutm@gmail.com', NULL, '$2y$10$cMZMR54ie.i8PMse8bbbPeMI3d4RPPccPuEgM2RMlkOkW/O/VrOTe', 'admin', '200123', 1, NULL, '2024-03-22 19:42:05', '2024-07-11 23:05:55'),
(8, 'kasun', 'kasun@gmail.com', NULL, '$2y$10$bHFG/Z/W0ePDfpIB8reOd.AU1iWzfBkBHEeJkqrCOtMy14U4s.HW2', 'user', '1000, 2000', 1, NULL, '2024-05-15 22:56:13', '2024-07-14 17:59:14'),
(9, '0117673402', '0117673402@gmail.com', NULL, '$2y$10$TzEHcqGl5R6GQU7Gv8pgeeQSjOGWgnF1UHHxFmpduaa1JlbLhebli', 'user', '0117673402', 1, NULL, '2024-07-04 03:06:40', NULL),
(10, 'Makaranda', 'makarandapathirana@gmail.com', NULL, '$2a$04$FdkmlLZFB6LKVsAfA3.0ueT1c71UQVtdS3oh6XfjFQz80ioQU.HHu', 'admin', '200343', 1, NULL, '2024-03-22 19:42:05', '2024-07-14 17:58:24'),
(12, 'Makara', 'makaranda@gmail.com', NULL, '$2a$04$fmgWBv7iQ7Aw2RtzILmXeu6VH0j4.Qbxq/2sN30.tV0XG473iVCs.', 'user', '356', 1, NULL, '2024-07-11 22:52:13', '2024-07-14 17:21:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions_types`
--
ALTER TABLE `permissions_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `routes_permissions`
--
ALTER TABLE `routes_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_menus`
--
ALTER TABLE `system_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `system_menus_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `system_users`
--
ALTER TABLE `system_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `permissions_types`
--
ALTER TABLE `permissions_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes_permissions`
--
ALTER TABLE `routes_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_menus`
--
ALTER TABLE `system_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `system_users`
--
ALTER TABLE `system_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1108;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `system_menus`
--
ALTER TABLE `system_menus`
  ADD CONSTRAINT `system_menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `system_menus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
