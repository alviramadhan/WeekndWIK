-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 12:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weekndwik`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_year` int(11) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `cover_image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `title`, `release_year`, `genre`, `cover_image_url`, `description`) VALUES
(1, 'Kiss Land', 2013, 'Alternative R&B', 'https://www.theweeknd.com/files/2016/08/artwork-440x440-2.jpg', 'Debut studio album featuring a dark, atmospheric sound.'),
(2, 'Beauty Behind the Madness', 2015, 'Pop', 'https://www.theweeknd.com/files/2016/08/Beauty-Behind-The-Madness.jpg', 'Breakthrough album with hits like \"Can’t Feel My Face\" and \"The Hills\".'),
(3, 'Starboy', 2016, 'R&B', 'https://www.theweeknd.com/files/2023/03/TW-STARBOY-DELUXE-COVER-EXPLICIT.jpg', 'Features collaborations with Daft Punk and a more upbeat tone.'),
(4, 'After Hours', 2020, 'Synthwave', 'https://www.theweeknd.com/files/2020/02/release_202002_ab67616d0000b27380e1e80874a5b25317c380c5.jpg', 'Critically acclaimed album with the hit single \"Blinding Lights\".'),
(5, 'Dawn FM', 2022, 'Synth-pop', 'https://www.theweeknd.com/files/2022/01/release_202201_DFM-COVER-EXPLICIT-768x768.jpg', 'Concept album with a radio station theme, featuring \"Take My Breath\".'),
(6, 'Trilogy', 2012, 'Alternative R&B', 'https://www.theweeknd.com/files/2016/08/artwork-440x440-1.jpg', 'Compilation of The Weeknd\'s first three mixtapes: House of Balloons, Thursday, and Echoes of Silence.'),
(7, 'My Dear Melancholy,', 2018, 'Alternative R&B', 'https://www.theweeknd.com/files/2018/03/release_201803_239a6b510014280a88f1ee8fcae44c6f7978bb39.jpg', 'An EP reflecting on heartbreak and emotional turmoil.');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Alternative R&B'),
(2, 'Pop'),
(3, 'R&B'),
(4, 'Synthwave'),
(5, 'Synth-pop');

-- --------------------------------------------------------

--
-- Table structure for table `liked_songs`
--

CREATE TABLE `liked_songs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `liked_songs`
--

INSERT INTO `liked_songs` (`id`, `user_id`, `song_id`) VALUES
(5, 20, 28),
(8, 20, 30),
(7, 20, 41);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `album_id`, `song_id`, `user_id`, `rating`, `review_text`, `review_date`) VALUES
(1, NULL, 25, 20, 2, 'test1', '2024-12-01 09:44:27'),
(2, NULL, 25, 20, 4, 'test2', '2024-12-01 09:45:05'),
(6, NULL, 25, 20, 4, 'test4', '2024-12-01 09:56:47'),
(7, NULL, 25, 20, 4, 'test5', '2024-12-01 00:51:22'),
(8, NULL, 25, 20, 5, 'testing61', '2024-12-01 00:52:52'),
(9, NULL, 25, 20, 4, 'testing its good', '2024-12-01 00:56:16'),
(10, NULL, 25, 20, 3, 'test5555', '2024-12-01 01:23:08'),
(11, NULL, 25, 20, 3, 'test666', '2024-12-01 01:23:22'),
(12, NULL, 30, 20, 2, 'test 4', '2024-12-01 01:33:29'),
(13, NULL, 30, 20, 3, 'test3', '2024-12-01 01:34:45'),
(14, NULL, 30, 20, 2, '4test', '2024-12-01 01:36:38'),
(15, NULL, 30, 20, 4, 'estreal4', '2024-12-01 01:37:31'),
(16, NULL, 30, 20, 5, 'estreal5', '2024-12-01 01:37:39'),
(17, NULL, 25, 21, 4, 'its for real good', '2024-12-01 01:39:03');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `duration` time DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `album_id`, `title`, `duration`, `audio_url`, `description`) VALUES
(25, 1, 'Professional', '00:06:08', 'https://youtu.be/tcLr-GIJQfI?si=3JN-s5hbbWAx46Hz', 'A smooth, introspective track about navigating the complexities of fame.'),
(26, 1, 'The Town', '00:05:07', 'https://youtu.be/zlMzSnlN5cw?si=qwnC1_xasPW8ANpz', 'A moody song that reflects on past relationships and regrets.'),
(27, 1, 'Tears in the Rain', '00:07:24', 'https://youtu.be/LceUbSZD_vk?si=IOJ2NUmGX5ut6_2f', 'A haunting track exploring themes of love lost and self-reflection.'),
(28, 2, 'Losers', '00:04:41', 'https://youtu.be/xNKOrBA9Sp0?si=fgeAMkZkpc_N8zz-', 'A bold statement on success and confidence, featuring Labrinth.'),
(29, 2, 'The Hills', '00:04:02', 'https://youtu.be/G5XpJP7f_SE?si=pQaHl0tHnGiBhyt5', 'A dark, intense track delving into the Weeknd\'s hidden life and emotions.'),
(30, 2, 'Can’t Feel My Face', '00:03:35', 'https://youtu.be/dqt8Z1k0oWQ?si=jWUHNCbZkzI8MMe9', 'A catchy, upbeat hit about passion and dangerous relationships.'),
(31, 2, 'Shameless', '00:04:13', 'https://youtu.be/polycpBREYA?si=7G2EHAfd0Ku4p3q3', 'A raw confession of desire and self-doubt in love.'),
(32, 2, 'Earned It', '00:04:37', 'https://youtu.be/OZ3YLkPuk-U?si=6WHwPwKqo5S1Ock8', 'A slow-paced track from the Fifty Shades of Grey soundtrack.'),
(33, 2, 'In the Night', '00:03:55', 'https://youtu.be/9CbQl98JEbE?si=eVErJ64_b9Y9vQ2v', 'A powerful song about a woman escaping a traumatic past.'),
(34, 3, 'Starboy', '00:03:50', 'https://youtu.be/plnfIj7dkJE?si=BaWeqVRg2sQ-79HD', 'An iconic collaboration with Daft Punk, showcasing a new, sleek persona.'),
(35, 3, 'Reminder', '00:03:38', 'https://youtu.be/h_VCgsWLmY4?si=fAM3nXZzdrICQNFR', 'A confident track that addresses fame and the pressures of success.'),
(36, 3, 'Stargirl Interlude', '00:01:51', 'https://youtu.be/Ir1tMjvMAWI?si=2yDVoReSZE05jiNg', 'A mesmerizing interlude featuring Lana Del Rey.'),
(37, 3, 'Die for You', '00:04:20', 'https://youtu.be/QLCpqdqeoII?si=yKxdecBQJv4GxnMK', 'A heartfelt song about the sacrifices one makes for love.'),
(38, 3, 'I Feel It Coming', '00:04:29', 'https://youtu.be/iIWoYaJRryw?si=IqAbAS06XsFXK7cd', 'A smooth, retro-inspired love song with Daft Punk.'),
(39, 4, 'Alone Again', '00:04:10', 'https://youtu.be/JH398xAYpZA?si=Dyi86Arvl0DMdgCj', 'A melancholic opening to the After Hours album, touching on isolation.'),
(40, 4, 'Heartless', '00:03:18', 'https://youtu.be/-uj9b9JCIJM?si=K72GRl9e8HBu18qK', 'An aggressive track about embracing a reckless lifestyle.'),
(41, 4, 'Blinding Lights', '00:03:20', 'https://youtu.be/fHI8X4OXluQ?si=GPElLTjRoPYl9yCJ', 'A massive hit with 80s-inspired beats and a story of longing.'),
(42, 4, 'In Your Eyes', '00:03:57', 'https://youtu.be/E3QiD99jPAg?si=dKBUcPiX2jGpVqHd', 'A song that captures love and vulnerability amidst a retro beat.'),
(43, 4, 'Save Your Tears', '00:03:35', 'https://youtu.be/u6lihZAcy4s?si=g2skWbudAfvBZk2l', 'A synth-heavy track about heartbreak and moving on.'),
(44, 4, 'After Hours', '00:06:01', 'https://youtu.be/ygTZZpVkmKg?si=RATsstjOitVfn9oO', 'A deeply emotional track that dives into loss and redemption.'),
(45, 5, 'Gasoline', '00:03:32', 'https://youtu.be/0T4UykXuJnI?si=xVp_B5CemeMHgwj7', 'A dark, moody track with a distinct electronic beat.'),
(46, 5, 'Take My Breath', '00:05:39', 'https://youtu.be/eT1E3gmST9U?si=GuP5IoVnrtqvgWhR', 'An energetic song with disco influences about intense passion.'),
(47, 5, 'Out of Time', '00:03:34', 'https://youtu.be/kxgj5af8zg4?si=B51_PzHqTZrIlj7g', 'A track about regret and missed opportunities in love.'),
(48, 5, 'Is There Someone Else?', '00:03:19', 'https://youtu.be/i4ZuseKFBF0?si=sJ0MY7rL42nkqJvB', 'A reflective song exploring themes of jealousy and insecurity.'),
(49, 5, 'Starry Eyes', '00:02:28', 'https://youtu.be/kDGyiXAMJAk?si=q-V9hlHP6xaW8WaM', 'A short, introspective track with a haunting melody.'),
(50, 5, 'Don’t Break My Heart', '00:03:25', 'https://youtu.be/PHFWp5s-KNQ?si=6zGgw_JrNbg2q5bK', 'A song about the fear of heartbreak and vulnerability.'),
(51, 5, 'Moth to A Flame', '00:03:54', 'https://youtu.be/u9n7Cw-4_HQ?si=up_g6NUa_RJR1Efy', 'A collaboration with Swedish House Mafia, blending R&B and electronic elements.'),
(52, 5, 'Less Than Zero', '00:03:32', 'https://youtu.be/LKsgDcckur0?si=TDlcAmAO3pU1SBOb', 'A melancholic track about feeling inadequate in a relationship.'),
(53, 6, 'Wicked Games', '00:05:25', 'https://youtu.be/o9PuAm7d0PA?si=29xg9hovMbUB5ZAd', 'A soulful track about a toxic relationship and the struggle to let go.'),
(54, 6, 'Coming Down', '00:04:55', 'https://youtu.be/WVg1mbxTkFo?si=b0NJhgevcQMUURv_', 'A song exploring the consequences of a hedonistic lifestyle.'),
(55, 7, 'Call Out My Name', '00:03:48', 'https://youtu.be/rsEne1ZiQrk?si=khMD31XwsXeeDQca', 'A heartfelt plea to a past lover, expressing regret and longing.'),
(56, 7, 'Try Me', '00:03:41', 'https://youtu.be/y08R20KflNM?si=tNof25WhwmWVwGbk', 'A track about temptation and the complexities of love.'),
(57, 7, 'Wasted Times', '00:03:40', 'https://youtu.be/R0rKB_bsUNg?si=dAoOnz5t1ewyLcJN', 'A song reflecting on past mistakes and the desire to make amends.'),
(58, 7, 'I Was Never There', '00:04:01', 'https://youtu.be/OlStmta0Vh4?si=6LARzmSgDkoYLV_9', 'A collaboration with Gesaffelstein, delving into themes of emptiness and loss.'),
(59, 7, 'Hurt You', '00:03:50', 'https://youtu.be/wKDU5pXhf5o?si=LtYzUjEPZLW5hF8y', 'A track about the pain of hurting someone you care about.');

-- --------------------------------------------------------

--
-- Table structure for table `song_genres`
--

CREATE TABLE `song_genres` (
  `song_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `song_genres`
--

INSERT INTO `song_genres` (`song_id`, `genre_id`) VALUES
(25, 1),
(26, 1),
(27, 1),
(28, 3),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 2),
(35, 2),
(36, 1),
(37, 1),
(38, 5),
(39, 4),
(40, 4),
(41, 4),
(42, 4),
(43, 5),
(44, 1),
(45, 4),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 1),
(51, 5),
(52, 5),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `created_at`) VALUES
(20, 'alvi123', 'alvi123@gmail.com', '$2y$10$tCWHTGzakAd.b3G547NdZeZWmb6ulQ7biIpStzu4YT4ibKD/tUgku', '2024-11-10 18:10:32'),
(21, 'alvi456', 'alvi456@gmail.com', '$2y$10$VBAn5TqXOGM3W0SJ/5A1Oe0k7SSt/wPE5fSCyAfDYvu.dGUfPd7bq', '2024-11-12 06:52:15'),
(22, 'alvitest', 'alvitest@gmail.com', '$2y$10$bonwICKAt9ZcrcU2o3Lh0OkRdEMCuyGLZVpZCSMRIgGDSzQ15elNO', '2024-11-13 08:57:50'),
(23, 'alvitest', 'alvitest@gmail.com', '$2y$10$e5gJcrnc.M6w5.Ya7jiMo.gFrr83XmufM3.fbS0tVOTlLqWhLWgxa', '2024-11-13 08:59:01'),
(24, 'alvi', 'alvi@gmail.com', '$2y$10$5EOgSqA26qXLkAIeJQi9wOnkS0RceuPF7.d8KS4C5Sn/qrgEhMpWy', '2024-11-13 09:01:48'),
(25, 'alvi', 'alvi@gmail.com', '$2y$10$tWIybsFNB1ay68R8viqbtumvvaFsnbbgxB4z2Mprqo.ZuFQRlvIou', '2024-11-13 09:17:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorite` (`user_id`,`song_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indexes for table `song_genres`
--
ALTER TABLE `song_genres`
  ADD PRIMARY KEY (`song_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `liked_songs`
--
ALTER TABLE `liked_songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD CONSTRAINT `liked_songs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `liked_songs_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`);

--
-- Constraints for table `song_genres`
--
ALTER TABLE `song_genres`
  ADD CONSTRAINT `song_genres_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`song_id`),
  ADD CONSTRAINT `song_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
