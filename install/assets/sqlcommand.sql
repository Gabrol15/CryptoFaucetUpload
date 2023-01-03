-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2022 at 11:34 AM
-- Server version: 10.3.35-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` int(32) UNSIGNED NOT NULL,
  `type` int(11) UNSIGNED NOT NULL,
  `condition` int(32) UNSIGNED NOT NULL,
  `reward_energy` int(32) UNSIGNED NOT NULL,
  `reward_usd` decimal(10,6) DEFAULT 0.000000
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `achievement_history`
--

CREATE TABLE `achievement_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `achievement_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offerwall_history`
--
CREATE TABLE `offerwall_history` (
 `id` int(32) unsigned NOT NULL,
 `user_id` int(32) unsigned NOT NULL,
 `offerwall` varchar(50) NOT NULL,
 `ip_address` varchar(75) NOT NULL,
 `amount` decimal(10,6) DEFAULT 0.000000,
 `trans_id` varchar(40) NOT NULL,
 `status` int(10) DEFAULT 0,
 `available_at` int(32) NOT NULL,
 `claim_time` int(32) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cheat_logs`
--

CREATE TABLE `cheat_logs` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `log` varchar(150) DEFAULT NULL,
  `create_time` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `relate_id` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(32) UNSIGNED NOT NULL,
  `currency_name` varchar(75) NOT NULL,
  `name` varchar(75) NOT NULL,
  `code` varchar(75) NOT NULL,
  `api` varchar(75) NOT NULL,
  `reward` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `energy_reward` int(32) UNSIGNED NOT NULL,
  `timer` int(32) DEFAULT 0,
  `limit_claim` int(32) NOT NULL DEFAULT 0,
  `min_claim` int(32) NOT NULL DEFAULT 0,
  `token` varchar(75) NOT NULL,
  `price` decimal(20,6) NOT NULL,
  `last_price` decimal(20,6) NOT NULL,
  `wallet` varchar(20) NOT NULL,
  `minimum_withdrawal` decimal(30,6) DEFAULT 0.000001
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deposit`
--

CREATE TABLE `deposit` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `code` varchar(75) NOT NULL,
  `status` varchar(75) NOT NULL,
  `create_time` int(32) UNSIGNED NOT NULL,
  `type` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faucet_history`
--

CREATE TABLE `faucet_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(16,8) DEFAULT 0.00000000,
  `method` varchar(75) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `faucet_stats`
--

CREATE TABLE `faucet_stats` (
  `id` int(32) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `new_users` int(32) UNSIGNED DEFAULT 0,
  `active_users` int(32) UNSIGNED DEFAULT 0,
  `autofaucet_count` int(32) UNSIGNED DEFAULT 0,
  `faucet_count` int(32) UNSIGNED DEFAULT 0,
  `shortlink_count` int(32) UNSIGNED DEFAULT 0,
  `ptc_count` int(32) UNSIGNED DEFAULT 0,
  `dice_count` int(32) UNSIGNED DEFAULT 0,
  `offerwall_count` int(32) UNSIGNED DEFAULT 0,
  `deposit_count` int(32) UNSIGNED DEFAULT 0,
  `autofaucet_amount` decimal(30,6) DEFAULT 0.000000,
  `faucet_amount` decimal(30,6) DEFAULT 0.000000,
  `shortlink_amount` decimal(30,6) DEFAULT 0.000000,
  `ptc_amount` decimal(30,6) DEFAULT 0.000000,
  `dice_amount` decimal(30,6) DEFAULT 0.000000,
  `offerwall_amount` decimal(30,6) DEFAULT 0.000000,
  `deposit_amount` decimal(30,6) DEFAULT 0.000000,
  `withdraw_amount` decimal(30,6) DEFAULT 0.000000,
  `is_done` int(11) UNSIGNED DEFAULT 0,
  `coinflip_count` int(32) UNSIGNED DEFAULT 0,
  `coinflip_amount` decimal(30,6) DEFAULT 0.000000,
  `achievement_count` int(32) UNSIGNED DEFAULT 0,
  `achievement_amount` decimal(30,6) DEFAULT 0.000000
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `status` enum('1','0') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1=Active, 0=Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `file_name`, `type`, `uploaded_on`, `status`) VALUES
(1, '7612a0569ce10b54200a070e4ef06334.png', 'logo', '2022-07-02 15:15:24', '1'),
(2, 'd662e81746550880028ddd2048973353.jpg', 'hero_image', '2022-07-02 16:25:16', '1'),
(3, '54bbe5094f91ee205ce24276d4636dce.png', 'favicon', '2022-07-02 16:34:18', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `last_use` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `reward` decimal(30,6) DEFAULT 0.000000,
  `energy_reward` int(32) UNSIGNED NOT NULL,
  `url` longtext NOT NULL,
  `view_per_day` int(11) UNSIGNED DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `link_history`
--

CREATE TABLE `link_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(30,6) DEFAULT 0.000000,
  `link_id` int(10) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_ads`
--

CREATE TABLE `ptc_ads` (
  `id` int(32) UNSIGNED NOT NULL,
  `owner` int(32) UNSIGNED NOT NULL,
  `name` varchar(75) NOT NULL,
  `description` varchar(75) NOT NULL,
  `reward` decimal(10,6) DEFAULT 0.000000,
  `timer` int(32) UNSIGNED NOT NULL,
  `url` longtext NOT NULL,
  `total_view` int(32) NOT NULL,
  `views` int(32) NOT NULL,
  `status` varchar(10) NOT NULL,
  `option_id` int(32) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_history`
--

CREATE TABLE `ptc_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `ad_id` int(32) UNSIGNED NOT NULL,
  `amount` decimal(10,6) DEFAULT 0.000000,
  `ip_address` varchar(75) NOT NULL,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ptc_option`
--

CREATE TABLE `ptc_option` (
  `id` int(32) UNSIGNED NOT NULL,
  `timer` int(32) UNSIGNED NOT NULL,
  `price` decimal(10,6) DEFAULT 0.000000,
  `reward` decimal(10,6) DEFAULT 0.000000,
  `min_view` int(32) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'status', 'off'),
(2, 'name', 'Cryptocoins'),
(3, 'description', 'Claim faucet and complete shortlinks to earn free cryptocurrencies'),
(4, 'referral', '30'),
(5, 'antibotlinks', 'on'),
(6, 'username', 'admin'),
(7, 'password', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5'),
(8, 'login_captcha', 'recaptchav3|recaptchav2'),
(9, 'faucet_captcha', 'recaptchav3'),
(10, 'recaptcha_v3_site_key', ''),
(11, 'recaptcha_v3_secret_key', ''),
(12, 'recaptcha_v2_site_key', ''),
(13, 'recaptcha_v2_secret_key', ''),
(14, 'c_key', ''),
(15, 'v_key', ''),
(16, 'h_key', ''),
(17, 'hcaptcha_site_key', ''),
(18, 'hcaptcha_secret_key', ''),
(19, 'top_ad', '<img src=\"https://via.placeholder.com/300x250\"><img src=\"https://via.placeholder.com/300x250\">'),
(20, 'smtp_host', ''),
(21, 'smtp_port', ''),
(22, 'left_ad', '<img src=\"https://via.placeholder.com/160x600\">'),
(23, 'right_ad', '<img src=\"https://via.placeholder.com/160x600\">'),
(24, 'autofaucet_status', 'off'),
(25, 'footer_ad', '<img src=\"https://via.placeholder.com/300x250\"><img src=\"https://via.placeholder.com/300x250\">'),
(26, 'faucet_status', 'off'),
(27, 'firewall', 'off'),
(28, 'captcha_fail_limit', '8'),
(29, 'admin_username', 'Cryptocoins'),
(30, 'shortlink_status', 'off'),
(31, 'reward_to', 'FaucetPay'),
(32, 'autofaucet_cost', '10'),
(33, 'autofaucet_timer', '30'),
(34, 'autofaucet_reward', '0.0001'),
(35, 'ptc_status', 'off'),
(36, 'site_email', ''),
(37, 'mail_service', 'mail'),
(38, 'achievement_status', 'off'),
(39, 'faucetpay_deposit_status', 'on'),
(40, 'faucetpay_username', ''),
(41, 'faucetpay_min_deposit', ''),
(42, 'payeer_status', 'on'),
(43, 'payeer_id', ''),
(44, 'payeer_secret', ''),
(45, 'payeer_min_deposit', '0.1'),
(46, 'smtp_username', ''),
(47, 'smtp_password', ''),
(48, 'admin_email', ''),
(49, 'proxy_detection', 'off'),
(50, 'min_wd', ''),
(51, 'email_confirmation', 'off'),
(52, 'offerwall_status', 'off'),
(53, 'leaderboard_date', '0'),
(54, 'wannads_status', 'off'),
(55, 'offertoro_status', 'off'),
(56, 'cpx_status', 'off'),
(59, 'wannads_api_key', ''),
(60, 'wannads_secret_key', ''),
(61, 'pollfish_api', ''),
(62, 'offertoro_pub_id', ''),
(63, 'offertoro_app_id', ''),
(64, 'offertoro_app_secret', ''),
(66, 'cpx_app_id', ''),
(67, 'cpx_hash', ''),
(68, 'pollfish_status', 'off'),
(69, 'ayetstudios_status', 'off'),
(70, 'ayetstudios_id', ''),
(71, 'ayetstudios_api', ''),
(72, 'bitswall_secret', ''),
(73, 'offerdaddy_status', 'off'),
(74, 'bitswall_api', ''),
(75, 'offerdaddy_app_key', ''),
(76, 'offerdaddy_app_token', ''),
(77, 'bitswall_status', 'off'),
(78, 'pollfish_secret', ''),
(79, 'offeroc_status', 'off'),
(80, 'offeroc_api', ''),
(81, 'offeroc_secret', '');
-- --------------------------------------------------------

--
-- Table structure for table `type_dokumen`
--

CREATE TABLE `type_dokumen` (
  `id` int(32) UNSIGNED NOT NULL,
  `type` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_dokumen`
--

INSERT INTO `type_dokumen` (`id`, `type`) VALUES
(1, 'favicon'),
(2, 'hero_image'),
(3, 'logo');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(32) UNSIGNED NOT NULL,
  `email` varchar(75) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(75) NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `balance` decimal(10,6) DEFAULT 0.000000,
  `dep_balance` decimal(10,6) DEFAULT 0.000000,
  `energy` int(32) UNSIGNED DEFAULT 0,
  `ip_address` varchar(75) NOT NULL,
  `referred_by` int(32) UNSIGNED DEFAULT 0,
  `last_claim` int(32) UNSIGNED DEFAULT 0,
  `last_active` int(32) UNSIGNED DEFAULT 0,
  `secret` varchar(30) NOT NULL,
  `token` varchar(30) NOT NULL,
  `claims` int(32) UNSIGNED DEFAULT 0,
  `verified` int(32) UNSIGNED DEFAULT 0,
  `isocode` varchar(10) DEFAULT 'N/A',
  `country` varchar(30) DEFAULT 'N/A',
  `joined` int(32) UNSIGNED DEFAULT 0,
  `total_earned` decimal(10,6) DEFAULT 0.000000,
  `ref_count` int(32) UNSIGNED DEFAULT 0,
  `claim_count_tmp` int(32) DEFAULT 0,
  `claim_count` int(32) DEFAULT 0,
  `shortlink_count_tmp` int(32) DEFAULT 0,
  `shortlink_count` int(32) DEFAULT 0,
  `offerwall_count_tmp` int(32) DEFAULT 0,
  `offerwall_count` int(32) DEFAULT 0,
  `status` char(10) DEFAULT '0',
  `last_firewall` int(32) DEFAULT 0,
  `referral_source` varchar(75) NOT NULL,
  `fail` int(11) DEFAULT 0,
  `last_auto` int(32) UNSIGNED DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `user_id` int(32) UNSIGNED NOT NULL,
  `link_id` int(32) UNSIGNED NOT NULL,
  `url` longtext NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `secret_keys` varchar(20) NOT NULL,
  `create_time` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_history`
--

CREATE TABLE `withdraw_history` (
  `id` int(32) UNSIGNED NOT NULL,
  `user_id` int(32) UNSIGNED NOT NULL,
  `type` int(10) UNSIGNED NOT NULL,
  `method` varchar(50) NOT NULL,
  `wallet` varchar(50) NOT NULL,
  `ip_address` varchar(75) NOT NULL,
  `amount` decimal(20,8) DEFAULT 0.00000000,
  `amountusd` decimal(30,6) DEFAULT 0.000000,
  `claim_time` int(32) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `achievement_history`
--
ALTER TABLE `achievement_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheat_logs`
--
ALTER TABLE `cheat_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faucet_history`
--
ALTER TABLE `faucet_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faucet_stats`
--
ALTER TABLE `faucet_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `link_history`
--
ALTER TABLE `link_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_ads`
--
ALTER TABLE `ptc_ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_history`
--
ALTER TABLE `ptc_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ptc_option`
--
ALTER TABLE `ptc_option`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_dokumen`
--
ALTER TABLE `type_dokumen`
  ADD PRIMARY KEY (`id`);
  
--
-- Indexes for table `offerwall_history`
--
ALTER TABLE `offerwall_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `withdraw_history`
--
ALTER TABLE `withdraw_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `achievement_history`
--
ALTER TABLE `achievement_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheat_logs`
--
ALTER TABLE `cheat_logs`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faucet_history`
--
ALTER TABLE `faucet_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faucet_stats`
--
ALTER TABLE `faucet_stats`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `link_history`
--
ALTER TABLE `link_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_ads`
--
ALTER TABLE `ptc_ads`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_history`
--
ALTER TABLE `ptc_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ptc_option`
--
ALTER TABLE `ptc_option`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `type_dokumen`
--
ALTER TABLE `type_dokumen`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `offerwall_history`
--
ALTER TABLE `offerwall_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_history`
--
ALTER TABLE `withdraw_history`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
