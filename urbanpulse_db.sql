-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2026 at 04:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `urbanpulse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `article_submissions`
--

CREATE TABLE `article_submissions` (
  `id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('technology','sports','entertainment','worldnews') NOT NULL,
  `summary` text NOT NULL,
  `body` longtext NOT NULL,
  `image_url` varchar(500) DEFAULT '',
  `status` enum('pending','approved','declined') DEFAULT 'pending',
  `decline_reason` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `reviewed_at` datetime DEFAULT NULL,
  `reviewed_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `article_submissions`
--

INSERT INTO `article_submissions` (`id`, `author_id`, `title`, `category`, `summary`, `body`, `image_url`, `status`, `decline_reason`, `submitted_at`, `reviewed_at`, `reviewed_by`) VALUES
(1, 3, 'Test', 'technology', 'Test', 'test', '', 'declined', NULL, '2026-03-22 16:02:57', '2026-03-22 17:18:10', 3),
(2, 3, 'KayoBahala eliminates Kira Seira', 'sports', 'KayoBahala delivered a massive upset as the wildcard squad eliminated tournament favorites Kira Seira, completing a stunning run to secure a spot in the Grand Finals and shaking the entire competition.', 'In one of the most unexpected and electrifying runs of the tournament, KayoBahala, a team that entered through the wildcard stage, has officially eliminated tournament favorites Kira Seira, punching their ticket straight into the Grand Finals. What started as a low-expectation underdog story has now evolved into a full-blown statement: KayoBahala is not here to participate—they are here to win.\r\n\r\nFrom the very beginning of the series, KayoBahala showed zero signs of hesitation. Despite Kira Seira’s reputation for consistency, discipline, and mechanical dominance, the wildcard squad came in with a completely different energy—aggressive, unpredictable, and fearless. It was clear early on that KayoBahala wasn’t intimidated by names or past achievements.\r\n\r\nThe opening moments of the match already hinted at an upset. KayoBahala dictated the tempo, forcing Kira Seira into uncomfortable situations. Instead of playing reactively, they took control—winning early engagements, capitalizing on small mistakes, and snowballing their advantages with precision. Their coordination looked far from a wildcard team; it resembled a roster that had been preparing for this exact moment.\r\n\r\nKira Seira, known for their ability to adapt mid-series, tried to stabilize. There were flashes of brilliance—well-timed plays, clutch moments, and attempts to regain momentum—but every time they inched closer, KayoBahala shut them down. The wildcard team’s composure under pressure became the defining factor. No panic, no overextensions—just calculated aggression and confidence.\r\n\r\nOne of the most striking aspects of KayoBahala’s performance was their synergy. Every player stepped up exactly when needed. Whether it was securing crucial picks, anchoring defenses, or leading decisive pushes, their teamwork remained consistent throughout the series. This wasn’t a one-man carry—it was a full team effort, and it showed.\r\n\r\nAs the final moments approached, the pressure was at its peak. Kira Seira had one last chance to turn things around, but KayoBahala didn’t give them that opportunity. With a clean and decisive finish, they closed out the series, eliminating one of the strongest teams in the tournament and completing one of the biggest upsets so far.\r\n\r\nThe arena—or even just the viewers online—felt the shift. A wildcard team had just taken down a giant.\r\n\r\nNow, all eyes are on KayoBahala as they head into the Grand Finals. What makes their run even more dangerous is momentum. They’ve already proven they can beat top-tier opponents, and with their confidence at an all-time high, they’re entering the finals as more than just underdogs—they’re legitimate contenders.\r\n\r\nFor Kira Seira, the loss is a tough one. A team with championship expectations now exits earlier than anticipated. Still, their performance throughout the tournament cannot be overlooked, and this defeat will likely serve as fuel for future comebacks.\r\n\r\nBut for now, the spotlight belongs to KayoBahala.\r\n\r\nFrom wildcard entry to Grand Finals—this is the kind of storyline that defines tournaments.\r\n\r\nAnd if this run has proven anything, it’s this: never underestimate a team with nothing to lose.', '', 'approved', NULL, '2026-03-22 16:52:59', '2026-03-22 16:57:03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `article_id`, `body`, `likes`, `created_at`) VALUES
(1, 1, 'article-gpt6-beta', 'test', 2, '2026-03-22 08:41:31'),
(2, 2, 'article-gpt6-beta', 'test', 0, '2026-03-22 08:42:51'),
(3, 1, 'view-article', 'this is so cool', 1, '2026-03-22 17:12:13');

-- --------------------------------------------------------

--
-- Table structure for table `comment_likes`
--

CREATE TABLE `comment_likes` (
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment_likes`
--

INSERT INTO `comment_likes` (`user_id`, `comment_id`) VALUES
(1, 1),
(1, 3),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reactions`
--

CREATE TABLE `reactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `article_id` varchar(100) NOT NULL,
  `reaction` enum('happy','sad','surprised','angry') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reactions`
--

INSERT INTO `reactions` (`id`, `user_id`, `article_id`, `reaction`, `created_at`) VALUES
(2, 2, 'article-ai-agentic-revolution', 'angry', '2026-03-22 16:35:23'),
(3, 1, 'article-ai-agentic-revolution', 'sad', '2026-03-22 16:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('reader','author','admin') DEFAULT 'reader',
  `avatar_color` varchar(7) DEFAULT '#c8102e',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `role`, `avatar_color`, `created_at`) VALUES
(1, 'matmat', 'matmatperez29@gmail.com', '$2y$10$gbmySswF7OcqbDFtKSN8C.aIftt8tTTwSY3AW22AemHFegq8.rm4G', 'Matthew Asiao Perez', 'reader', '#9b59b6', '2026-03-20 18:55:01'),
(2, 'akosinimo', 'findingnimo@gmail.com', '$2y$10$xbksnfxTwm2pYOipvtcQHushQK4ikLte1fHF58uIdfjw5YVP6PZ9a', 'Cristel Ann Nimo', 'reader', '#e67e22', '2026-03-22 08:42:14'),
(3, 'author1', 'author1@urbanpulse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sample Author', 'admin', '#0066cc', '2026-03-22 16:01:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article_submissions`
--
ALTER TABLE `article_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `reviewed_by` (`reviewed_by`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD PRIMARY KEY (`user_id`,`comment_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reaction` (`user_id`,`article_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article_submissions`
--
ALTER TABLE `article_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article_submissions`
--
ALTER TABLE `article_submissions`
  ADD CONSTRAINT `article_submissions_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_submissions_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comment_likes`
--
ALTER TABLE `comment_likes`
  ADD CONSTRAINT `comment_likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_likes_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
