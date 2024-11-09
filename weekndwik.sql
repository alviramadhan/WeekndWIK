-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 05:36 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `duration` time DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `album_id`, `title`, `duration`, `audio_url`) VALUES
(25, 1, 'Professional', '00:06:08', 'https://youtu.be/tcLr-GIJQfI?si=3JN-s5hbbWAx46Hz'),
(26, 1, 'The Town', '00:05:07', 'https://youtu.be/zlMzSnlN5cw?si=qwnC1_xasPW8ANpz'),
(27, 1, 'Tears in the Rain', '00:07:24', 'https://youtu.be/LceUbSZD_vk?si=IOJ2NUmGX5ut6_2f'),
(28, 2, 'Losers', '00:04:41', 'https://youtu.be/xNKOrBA9Sp0?si=fgeAMkZkpc_N8zz-'),
(29, 2, 'The Hills', '00:04:02', 'https://youtu.be/G5XpJP7f_SE?si=pQaHl0tHnGiBhyt5'),
(30, 2, 'Can’t Feel My Face', '00:03:35', 'https://youtu.be/dqt8Z1k0oWQ?si=jWUHNCbZkzI8MMe9'),
(31, 2, 'Shameless', '00:04:13', 'https://youtu.be/polycpBREYA?si=7G2EHAfd0Ku4p3q3'),
(32, 2, 'Earned It', '00:04:37', 'https://youtu.be/OZ3YLkPuk-U?si=6WHwPwKqo5S1Ock8'),
(33, 2, 'In the Night', '00:03:55', 'https://youtu.be/9CbQl98JEbE?si=eVErJ64_b9Y9vQ2v'),
(34, 3, 'Starboy', '00:03:50', 'https://youtu.be/plnfIj7dkJE?si=BaWeqVRg2sQ-79HD'),
(35, 3, 'Reminder', '00:03:38', 'https://youtu.be/h_VCgsWLmY4?si=fAM3nXZzdrICQNFR'),
(36, 3, 'Stargirl Interlude', '00:01:51', 'https://youtu.be/Ir1tMjvMAWI?si=2yDVoReSZE05jiNg'),
(37, 3, 'Die for You', '00:04:20', 'https://youtu.be/QLCpqdqeoII?si=yKxdecBQJv4GxnMK'),
(38, 3, 'I Feel It Coming', '00:04:29', 'https://youtu.be/iIWoYaJRryw?si=IqAbAS06XsFXK7cd'),
(39, 4, 'Alone Again', '00:04:10', 'https://youtu.be/JH398xAYpZA?si=Dyi86Arvl0DMdgCj'),
(40, 4, 'Heartless', '00:03:18', 'https://youtu.be/-uj9b9JCIJM?si=K72GRl9e8HBu18qK'),
(41, 4, 'Blinding Lights', '00:03:20', 'https://youtu.be/fHI8X4OXluQ?si=GPElLTjRoPYl9yCJ'),
(42, 4, 'In Your Eyes', '00:03:57', 'https://youtu.be/E3QiD99jPAg?si=dKBUcPiX2jGpVqHd'),
(43, 4, 'Save Your Tears', '00:03:35', 'https://youtu.be/u6lihZAcy4s?si=g2skWbudAfvBZk2l'),
(44, 4, 'After Hours', '00:06:01', 'https://youtu.be/ygTZZpVkmKg?si=RATsstjOitVfn9oO'),
(45, 5, 'Gasoline', '00:03:32', 'https://youtu.be/0T4UykXuJnI?si=xVp_B5CemeMHgwj7'),
(46, 5, 'Take My Breath', '00:05:39', 'https://youtu.be/eT1E3gmST9U?si=GuP5IoVnrtqvgWhR'),
(47, 5, 'Out of Time', '00:03:34', 'https://youtu.be/kxgj5af8zg4?si=B51_PzHqTZrIlj7g'),
(48, 5, 'Is There Someone Else?', '00:03:19', 'https://youtu.be/i4ZuseKFBF0?si=sJ0MY7rL42nkqJvB'),
(49, 5, 'Starry Eyes', '00:02:28', 'https://youtu.be/kDGyiXAMJAk?si=q-V9hlHP6xaW8WaM'),
(50, 5, 'Don’t Break My Heart', '00:03:25', 'https://youtu.be/PHFWp5s-KNQ?si=6zGgw_JrNbg2q5bK'),
(51, 5, 'Moth to A Flame', '00:03:54', 'https://youtu.be/u9n7Cw-4_HQ?si=up_g6NUa_RJR1Efy'),
(52, 5, 'Less Than Zero', '00:03:32', 'https://youtu.be/LKsgDcckur0?si=TDlcAmAO3pU1SBOb'),
(53, 6, 'Wicked Games', '00:05:25', 'https://youtu.be/o9PuAm7d0PA?si=29xg9hovMbUB5ZAd'),
(54, 6, 'Coming Down', '00:04:55', 'https://youtu.be/WVg1mbxTkFo?si=b0NJhgevcQMUURv_'),
(55, 7, 'Call Out My Name', '00:03:48', 'https://youtu.be/rsEne1ZiQrk?si=khMD31XwsXeeDQca'),
(56, 7, 'Try Me', '00:03:41', 'https://youtu.be/y08R20KflNM?si=tNof25WhwmWVwGbk'),
(57, 7, 'Wasted Times', '00:03:40', 'https://youtu.be/R0rKB_bsUNg?si=dAoOnz5t1ewyLcJN'),
(58, 7, 'I Was Never There', '00:04:01', 'https://youtu.be/OlStmta0Vh4?si=6LARzmSgDkoYLV_9'),
(59, 7, 'Hurt You', '00:03:50', 'https://youtu.be/wKDU5pXhf5o?si=LtYzUjEPZLW5hF8y');

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
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
