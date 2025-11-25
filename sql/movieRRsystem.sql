-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2025 at 06:47 AM
-- Server version: 8.0.44-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieRRsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `release_year` year DEFAULT NULL,
  `description` text,
  `poster` varchar(255) DEFAULT NULL,
  `avg_rating` decimal(3,2) DEFAULT '0.00',
  `total_ratings` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `title`, `genre`, `release_year`, `description`, `poster`, `avg_rating`, `total_ratings`, `created_at`) VALUES
(1, 'K.G.F', 'action', '2018', 'KGF (Kolar Gold Fields) follows Rocky, a ruthless and ambitious young man who rises from poverty to become a powerful underworld leader. Driven by a promise to his dying mother, he fights his way into the dangerous gold mines of KGF, where he challenges a brutal empire and inspires fear and loyalty with his unstoppable determination.', '1763709095_692010a72ed53.jpg', 0.00, 0, '2025-11-21 07:11:35'),
(2, 'K.G.F 2', 'action', '2022', 'The story continues with Rocky as the new overlord of the Kolar Gold Fields. He establishes a new system and improves the lives of the workers, but his rise to power attracts new, dangerous adversaries, including Adheera (Garuda\'s ruthless uncle, who was presumed dead) and the powerful Indian Prime Minister, Ramika Sen. Rocky must battle these formidable threats from all sides to maintain his supremacy and protect his empire. The film culminates in an epic showdown, with a post-credits scene hinting at a future third chapter detailing Rocky\'s international crimes. ', '1763965472_6923fa20c4b9a.jpeg', 5.00, 1, '2025-11-21 07:14:31'),
(3, 'Phir Hera Pheri', 'comedy', '2006', 'Raju, Shyam, and Baburao get caught in a hilarious mess after investing in a fake quick-rich scheme. Their desperate attempts to recover the money lead to nonstop chaos, confusion, and comedy.', '1763709981_6920141ddcba3.jpeg', 0.00, 0, '2025-11-21 07:26:21'),
(4, 'Archer', 'adventure', '2024', 'Archer is a Tamil action thriller where a skilled marksman seeks revenge after being dragged into a deadly conflict driven by corruption, betrayal, and power. The film follows his intense journey as he uses his precision and bravery to fight back against those who wronged him.', '1763710606_6920168e56e18.jpeg', 0.00, 0, '2025-11-21 07:36:46'),
(5, 'Jumanji', 'adventure', '2017', 'Jumanji is an adventure-fantasy film where a magical game brings wild jungle creatures into the real world. The players must finish the game to survive and restore everything back to normal. It’s a thrilling mix of danger, humor, and mystery.', '1763710954_692017ead539b.jpeg', 0.00, 0, '2025-11-21 07:42:34'),
(7, 'WAR', 'action', '2019', 'War  is an Indian action-thriller where a top RAW agent, Kabir (Hrithik Roshan), mysteriously goes rogue. His former student Khalid (Tiger Shroff) is assigned to track him down, leading to intense action, twists, and a mentor-vs-protégé showdown. Produced by Yash Raj Films and directed by Siddharth Anand.', '1763970125_69240c4d7c0ba.jpg', 4.00, 1, '2025-11-24 07:42:05'),
(8, 'URI: THE SURGICAL STRIKE', 'action', '2019', 'URI: The Surgical Strike (2019) is an Indian military action film based on the real 2016 surgical strikes carried out by the Indian Army. It follows Major Vihaan Singh Shergill (played by Vicky Kaushal) as he leads a covert mission to take down terrorist launch pads across the border, in retaliation for the Uri army base attack. The film is known for its intense action, realism, and the famous line “How’s the josh?”', '1763970244_69240cc4792ea.jpg', 5.00, 1, '2025-11-24 07:44:04'),
(9, 'RA.ONE', 'action', '2011', 'RA.One (2011) is an Indian science-fiction action film starring Shah Rukh Khan. The story follows a video-game designer whose creation — an AI-powered villain named RA.One — comes to life and begins causing destruction. To stop him, the game’s hero G.One (also played by SRK) enters the real world and protects the designer’s son. The film is known for its VFX, action, and futuristic theme.', '1763970311_69240d07c990b.jpg', 4.50, 2, '2025-11-24 07:45:11'),
(10, 'BEAST', 'action', '2022', 'Beast (2022) is a Tamil action film starring Vijay and directed by Nelson Dilipkumar. The story follows Veeraraghavan, an ex-RAW agent who gets trapped inside a shopping mall taken over by terrorists. Using his skills, he fights to rescue the hostages and stop the terrorist attack. The movie is known for its stylish action and the hit song “Arabic Kuthu.”', '1763970388_69240d546affc.jpg', 4.00, 2, '2025-11-24 07:46:28'),
(11, 'KAHAANI', 'action', '2012', 'Kahaani is a suspenseful thriller about a pregnant woman who travels to Kolkata in search of her missing husband. As she investigates, she uncovers a complex web of secrets, conspiracies, and unexpected twists, testing her courage and determination.', '1763981500_692438bc8c098.jpg', 0.00, 0, '2025-11-24 10:51:40'),
(12, ' I am Legend', 'science-fiction', '2007', 'I Am Legend is a post-apocalyptic science fiction horror film starring Will Smith as Dr. Robert Neville, a brilliant U.S. Army virologist and the seemingly last human survivor in New York City, and potentially the world, after a genetically engineered virus (originally created as a cure for cancer) wipes out most of humanity and mutates the rest into vampiric, light-sensitive creatures known as \"Darkseekers\". \r\nFor three years, Neville lives a solitary, methodical existence with his loyal German Shepherd, Sam. By day, he scavenges for supplies among the desolate, overgrown ruins of New York, runs scientific experiments in his fortified home laboratory to find a cure using his own immune blood, and broadcasts daily radio messages in a desperate plea for other survivors. By night, he barricades himself inside his home, constantly on edge, as the infected lurk in the shadows, waiting for him to make a fatal mistake. The film is a gripping portrayal of isolation, grief, and the enduring human will to find hope and save what is left of humanity', '1763987566_6924506ea0d64.jpeg', 0.00, 0, '2025-11-24 12:32:46'),
(13, 'ROBOTS', 'animation', '2005', 'The film, produced by Blue Sky Studios, is set in a world populated entirely by mechanical beings. It follows the story of Rodney Copperbottom, an idealistic young robot and aspiring inventor from a small town who travels to the sprawling metropolis of Robot City to meet his childhood idol, the master inventor Bigweld. \r\nUpon arrival, Rodney discovers that Bigweld has been ousted and the company is now run by the nefarious corporate tyrant, Phineas T. Ratchet, and his mother, Madame Gasket. Ratchet\'s new business model involves ending the production of spare parts to force older, \"outmoded\" robots to buy expensive upgrades or be sent to a scrap yard for destruction. \r\nRodney befriends a group of misfit old robots, known as the \"Rusties,\" led by the constantly-falling-apart Fender (voiced by Robin Williams). Together, they must rally the outmodes and find Bigweld to reclaim the company and ensure that \"everyone can be safe as an old bot\". The film carries themes of following your dreams, classism, and corporate malfeasance, all wrapped in a visually creative, steampunk-inspired world.', '1763987689_692450e910607.jpg', 0.00, 0, '2025-11-24 12:34:49'),
(14, 'GRAVITY', 'science-fiction', '1999', 'The Matrix is a 1999 science fiction action film about a computer hacker named Neo who discovers that his reality is a simulated world created by intelligent machines. The movie, released in 1999, follows Neo as he is recruited by a rebel group to fight the machines that have enslaved humanity.', '1763988205_692452ed4a2a3.jpeg', 0.00, 0, '2025-11-24 12:43:25');



--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `movie_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` int NOT NULL,
  `review_text` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `movie_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 2, 6, 5, 'osm movie', '2025-11-24 10:56:07'),
(2, 10, 5, 3, 'osm movie', '2025-11-24 15:02:34'),
(3, 9, 5, 5, 'Grate film', '2025-11-24 15:09:55'),
(4, 10, 6, 5, 'Non-stop thrills and epic fight scenes', '2025-11-24 15:51:19'),
(5, 9, 6, 4, 'Explosions galore, pure adrenaline!', '2025-11-24 15:51:46'),
(6, 8, 6, 5, 'Explosions galore, pure adrenaline!', '2025-11-24 15:51:58'),
(7, 7, 6, 4, 'Good action Movie', '2025-11-24 15:52:19'),
(8, 11, 6, 4, 'osm', '2025-11-25 11:33:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Kashish Mittal', 'kashish@gmail.com', '$2y$10$Ca0j.T1.S/uXfwzvMp1jXeCCx2tZiH3Z0DzHaStEHS857dQ81E7be', 'user', '2025-11-19 05:25:40'),
(2, 'vansh', 'vansh@gmail.com', '$2y$10$W4lZtypYhogTZHHD1AvUUOk.0zZIKYRpyhL8xnvlzM1nkb1j9BrF6', 'user', '2025-11-19 05:54:17'),
(4, 'Rajesh', 'rajesh@gmail.com', '$2y$10$JmdJ.2D/SRGyQC4O/WmZ2OlxQq4WpyG7rgICPeS3IrPIUmGzSiOsW', 'admin', '2025-11-19 07:07:18'),
(5, 'Sanjna', 'sanjna@gmail.com', '$2y$10$SgblvVGRxn2qzVCQt8d07u6Fi344/Ys9fEOmy8tv9uN3PmxEK42O6', 'user', '2025-11-19 12:25:59'),
(6, 'Mohit', 'mohit@gmail.com', '$2y$10$F/2jWZg7oEgLbbfFogkAc.d4MfEOkfJZCCdC6lOz5yWN3.B9.yVlO', 'user', '2025-11-20 07:34:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
