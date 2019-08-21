-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 11 Wrz 2017, 17:14
-- Wersja serwera: 10.1.22-MariaDB
-- Wersja PHP: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `lva`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `foreign_words`
--

CREATE TABLE `foreign_words` (
  `id` int(10) UNSIGNED NOT NULL,
  `vocabulary_list_id` int(10) UNSIGNED NOT NULL,
  `word` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_to_foreign_status` tinyint(1) NOT NULL,
  `word_repeating_counter` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `foreign_word_native_word`
--

CREATE TABLE `foreign_word_native_word` (
  `foreign_word_id` int(10) UNSIGNED NOT NULL,
  `native_word_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag_link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `languages`
--

INSERT INTO `languages` (`id`, `name`, `iso`, `flag_link`) VALUES
(1, '', '', ''),
(2, 'angielski', 'EN', 'angielski'),
(3, 'belgijski', 'BE', 'belgijski'),
(4, 'białoruski', 'BY', 'bialoruski'),
(5, 'bułgarski', 'BG', 'bulgarski'),
(6, 'chiński', 'CN', 'chinski'),
(7, 'chorwacki', 'HR', 'chorwacki'),
(8, 'czeski', 'CZ', 'czeski'),
(9, 'duński', 'DK', 'dunski'),
(10, 'estoński', 'EE', 'estonski'),
(11, 'fiński', 'FI', 'finski'),
(12, 'francuski', 'FR', 'francuski'),
(13, 'grecki', 'GR', 'grecki'),
(14, 'hiszpański', 'ES', 'hiszpanski'),
(15, 'holenderski', 'NL', 'holenderski'),
(16, 'inny', '--', 'inny'),
(17, 'irlandzki', 'IE', 'irlandzki'),
(18, 'islandzki', 'IS', 'islandzki'),
(19, 'japoński', 'JP', 'japonski'),
(20, 'koreański', 'KR', 'koreanski'),
(21, 'litewski', 'LT', 'litewski'),
(22, 'łotewski', 'LV', 'lotewski'),
(23, 'niemiecki', 'DE', 'niemiecki'),
(24, 'norweski', 'NO', 'norweski'),
(25, 'portugalski', 'PT', 'portugalski'),
(26, 'rosyjski', 'RU', 'rosyjski'),
(27, 'rumuński', 'RO', 'rumunski'),
(28, 'serbski', 'RS', 'serbski'),
(29, 'słowacki', 'SK', 'slowacki'),
(30, 'słoweński', 'SI', 'sloweński'),
(31, 'szwedzki', 'SE', 'szwedzki'),
(32, 'tajski', 'TH', 'tajski'),
(33, 'turecki', 'TR', 'turecki'),
(34, 'ukraiński', 'UA', 'ukrainski'),
(35, 'węgierski', 'HU', 'wegierski'),
(36, 'włoski', 'IT', 'wloski');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `native_words`
--

CREATE TABLE `native_words` (
  `id` int(10) UNSIGNED NOT NULL,
  `vocabulary_list_id` int(10) UNSIGNED NOT NULL,
  `word` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pattern` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `native_to_foreign_status` tinyint(1) NOT NULL,
  `word_repeating_counter` int(11) NOT NULL,
  `success` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `privileged_accounts`
--

CREATE TABLE `privileged_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_modified_by_account_id` int(11) NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `privileged_accounts`
--

INSERT INTO `privileged_accounts` (`id`, `email`, `last_modified_by_account_id`, `admin_status`, `created_at`, `updated_at`) VALUES
(1, 'admin@admin.pl', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `repetition_dates`
--

CREATE TABLE `repetition_dates` (
  `id` int(10) UNSIGNED NOT NULL,
  `vocabulary_list_id` int(10) UNSIGNED NOT NULL,
  `success_or_fail` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.pl', '$2y$10$l/NkEgk.YtG4T8gcN32QQ.dBYlnMo7eR8/eloHtSMowA3b4mM5TBa', '4BPKFjxCjNxtNTUv27P4iF58E0gfuFIRekA4ebdYZpxM7GQqANYQyjM9O9aq', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vocabulary_lists`
--

CREATE TABLE `vocabulary_lists` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `general_repeating_counter` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `foreign_words`
--
ALTER TABLE `foreign_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `foreign_words_vocabulary_list_id_foreign` (`vocabulary_list_id`);

--
-- Indexes for table `foreign_word_native_word`
--
ALTER TABLE `foreign_word_native_word`
  ADD KEY `foreign_word_native_word_foreign_word_id_foreign` (`foreign_word_id`),
  ADD KEY `foreign_word_native_word_native_word_id_foreign` (`native_word_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_iso_unique` (`iso`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `native_words`
--
ALTER TABLE `native_words`
  ADD PRIMARY KEY (`id`),
  ADD KEY `native_words_vocabulary_list_id_foreign` (`vocabulary_list_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `privileged_accounts`
--
ALTER TABLE `privileged_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `repetition_dates`
--
ALTER TABLE `repetition_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repetition_dates_vocabulary_list_id_foreign` (`vocabulary_list_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vocabulary_lists`
--
ALTER TABLE `vocabulary_lists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vocabulary_lists_name_unique` (`name`),
  ADD KEY `vocabulary_lists_language_id_foreign` (`language_id`),
  ADD KEY `vocabulary_lists_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `foreign_words`
--
ALTER TABLE `foreign_words`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT dla tabeli `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `native_words`
--
ALTER TABLE `native_words`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `privileged_accounts`
--
ALTER TABLE `privileged_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `repetition_dates`
--
ALTER TABLE `repetition_dates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT dla tabeli `vocabulary_lists`
--
ALTER TABLE `vocabulary_lists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `foreign_words`
--
ALTER TABLE `foreign_words`
  ADD CONSTRAINT `foreign_words_vocabulary_list_id_foreign` FOREIGN KEY (`vocabulary_list_id`) REFERENCES `vocabulary_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `foreign_word_native_word`
--
ALTER TABLE `foreign_word_native_word`
  ADD CONSTRAINT `foreign_word_native_word_foreign_word_id_foreign` FOREIGN KEY (`foreign_word_id`) REFERENCES `foreign_words` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign_word_native_word_native_word_id_foreign` FOREIGN KEY (`native_word_id`) REFERENCES `native_words` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `native_words`
--
ALTER TABLE `native_words`
  ADD CONSTRAINT `native_words_vocabulary_list_id_foreign` FOREIGN KEY (`vocabulary_list_id`) REFERENCES `vocabulary_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `repetition_dates`
--
ALTER TABLE `repetition_dates`
  ADD CONSTRAINT `repetition_dates_vocabulary_list_id_foreign` FOREIGN KEY (`vocabulary_list_id`) REFERENCES `vocabulary_lists` (`id`);

--
-- Ograniczenia dla tabeli `vocabulary_lists`
--
ALTER TABLE `vocabulary_lists`
  ADD CONSTRAINT `vocabulary_lists_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  ADD CONSTRAINT `vocabulary_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
