-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2025 at 11:28 AM
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
(1, 'K.G.F', 'action', '2018', 'KGF (Kolar Gold Fields) follows Rocky, a ruthless and ambitious young man who rises from poverty to become a powerful underworld leader. Driven by a promise to his dying mother, he fights his way into the dangerous gold mines of KGF, where he challenges a brutal empire and inspires fear and loyalty with his unstoppable determination.', '1764312601_6929461918396.jpg', 4.00, 2, '2025-11-21 07:11:35'),
(2, 'K.G.F 2', 'action', '2022', 'The story continues with Rocky as the new overlord of the Kolar Gold Fields. He establishes a new system and improves the lives of the workers, but his rise to power attracts new, dangerous adversaries, including Adheera (Garuda\'s ruthless uncle, who was presumed dead )and the powerful Indian Prime Minister, Ramika Sen. Rocky must battle these formidable threats from all sides to maintain his supremacy and protect his empire. The film culminates in an epic showdown, with a post-credits scene hinting at a future third chapter detailing Rocky\'s international crimes. ', '1763965472_6923fa20c4b9a.jpeg', 5.00, 3, '2025-11-21 07:14:31'),
(3, 'Phir Hera Pheri', 'comedy', '2006', 'Raju, Shyam, and Baburao get caught in a hilarious mess after investing in a fake quick-rich scheme. Their desperate attempts to recover the money lead to nonstop chaos, confusion, and comedy.', '1763709981_6920141ddcba3.jpeg', 5.00, 1, '2025-11-21 07:26:21'),
(4, 'Archer', 'adventure', '2024', 'Archer is a Tamil action thriller where a skilled marksman seeks revenge after being dragged into a deadly conflict driven by corruption, betrayal, and power. The film follows his intense journey as he uses his precision and bravery to fight back against those who wronged him.', '1763710606_6920168e56e18.jpeg', 4.00, 1, '2025-11-21 07:36:46'),
(5, 'Jumanji', 'adventure', '2017', 'Jumanji is an adventure-fantasy film where a magical game brings wild jungle creatures into the real world. The players must finish the game to survive and restore everything back to normal. It’s a thrilling mix of danger, humor, and mystery.', '1763710954_692017ead539b.jpeg', 5.00, 1, '2025-11-21 07:42:34'),
(7, 'WAR', 'action', '2019', 'War  is an Indian action-thriller where a top RAW agent, Kabir (Hrithik Roshan), mysteriously goes rogue. His former student Khalid (Tiger Shroff) is assigned to track him down, leading to intense action, twists, and a mentor-vs-protégé showdown. Produced by Yash Raj Films and directed by Siddharth Anand.', '1764312765_692946bd186d4.jpg', 4.30, 3, '2025-11-24 07:42:05'),
(8, 'URI: THE SURGICAL STRIKE', 'action', '2019', 'URI: The Surgical Strike (2019) is an Indian military action film based on the real 2016 surgical strikes carried out by the Indian Army. It follows Major Vihaan Singh Shergill (played by Vicky Kaushal) as he leads a covert mission to take down terrorist launch pads across the border, in retaliation for the Uri army base attack. The film is known for its intense action, realism, and the famous line “How’s the josh?”', '1763970244_69240cc4792ea.jpg', 4.70, 3, '2025-11-24 07:44:04'),
(9, 'RA.ONE', 'action', '2011', 'RA.One (2011) is an Indian science-fiction action film starring Shah Rukh Khan. The story follows a video-game designer whose creation — an AI-powered villain named RA.One — comes to life and begins causing destruction. To stop him, the game’s hero G.One (also played by SRK) enters the real world and protects the designer’s son. The film is known for its VFX, action, and futuristic theme.', '1763970311_69240d07c990b.jpg', 4.70, 3, '2025-11-24 07:45:11'),
(10, 'BEAST', 'action', '2022', 'Beast (2022) is a Tamil action film starring Vijay and directed by Nelson Dilipkumar. The story follows Veeraraghavan, an ex-RAW agent who gets trapped inside a shopping mall taken over by terrorists. Using his skills, he fights to rescue the hostages and stop the terrorist attack. The movie is known for its stylish action and the hit song “Arabic Kuthu.”', '1763970388_69240d546affc.jpg', 4.00, 3, '2025-11-24 07:46:28'),
(11, 'KAHAANI', 'action', '2012', 'Kahaani is a suspenseful thriller about a pregnant woman who travels to Kolkata in search of her missing husband. As she investigates, she uncovers a complex web of secrets, conspiracies, and unexpected twists, testing her courage and determination.', '1763981500_692438bc8c098.jpg', 3.70, 3, '2025-11-24 10:51:40'),
(12, ' I am Legend', 'science-fiction', '2007', 'I Am Legend is a post-apocalyptic science fiction horror film starring Will Smith as Dr. Robert Neville, a brilliant U.S. Army virologist and the seemingly last human survivor in New York City, and potentially the world, after a genetically engineered virus (originally created as a cure for cancer) wipes out most of humanity and mutates the rest into vampiric, light-sensitive creatures known as \"Darkseekers\". \r\nFor three years, Neville lives a solitary, methodical existence with his loyal German Shepherd, Sam. By day, he scavenges for supplies among the desolate, overgrown ruins of New York, runs scientific experiments in his fortified home laboratory to find a cure using his own immune blood, and broadcasts daily radio messages in a desperate plea for other survivors. By night, he barricades himself inside his home, constantly on edge, as the infected lurk in the shadows, waiting for him to make a fatal mistake. The film is a gripping portrayal of isolation, grief, and the enduring human will to find hope and save what is left of humanity', '1763987566_6924506ea0d64.jpeg', 4.00, 1, '2025-11-24 12:32:46'),
(13, 'ROBOTS', 'animation', '2005', 'The film, produced by Blue Sky Studios, is set in a world populated entirely by mechanical beings. It follows the story of Rodney Copperbottom, an idealistic young robot and aspiring inventor from a small town who travels to the sprawling metropolis of Robot City to meet his childhood idol, the master inventor Bigweld. \r\nUpon arrival, Rodney discovers that Bigweld has been ousted and the company is now run by the nefarious corporate tyrant, Phineas T. Ratchet, and his mother, Madame Gasket. Ratchet\'s new business model involves ending the production of spare parts to force older, \"outmoded\" robots to buy expensive upgrades or be sent to a scrap yard for destruction. \r\nRodney befriends a group of misfit old robots, known as the \"Rusties,\" led by the constantly-falling-apart Fender (voiced by Robin Williams). Together, they must rally the outmodes and find Bigweld to reclaim the company and ensure that \"everyone can be safe as an old bot\". The film carries themes of following your dreams, classism, and corporate malfeasance, all wrapped in a visually creative, steampunk-inspired world.', '1763987689_692450e910607.jpg', 5.00, 1, '2025-11-24 12:34:49'),
(14, 'GRAVITY', 'science-fiction', '1999', 'The Matrix is a 1999 science fiction action film about a computer hacker named Neo who discovers that his reality is a simulated world created by intelligent machines. The movie, released in 1999, follows Neo as he is recruited by a rebel group to fight the machines that have enslaved humanity.', '1763988205_692452ed4a2a3.jpeg', 4.00, 1, '2025-11-24 12:43:25'),
(15, 'The Jungle Book', 'adventure', '1967', 'This is the classic Disney animated musical. It follows Mowgli, an orphaned human boy raised in the jungle by wolves, who is forced to leave his home when the fearsome tiger Shere Khan returns. Mowgli is guided by the stern panther Bagheera and the carefree bear Baloo, who teaches him about the \"Bare Necessities\" of life, as they make their way to the \"man-village.', '1764159878_6926f18627c03.jpeg', 0.00, 0, '2025-11-26 12:24:38'),
(16, 'South Sea Adventures', 'adventure', '1958', 'This is a famous American travelogue and documentary film, notable for being the fifth and final in the original documentary series filmed in the immersive Cinerama three-panel format. The film takes the viewer on a cinematic journey across the Pacific Ocean, exploring various locations including Hawaii, Australia, New Zealand, Fiji, Tonga, and Tahiti, showcasing the diverse cultures, landscapes, and traditional ceremonies of the South Seas.', '1764160645_6926f485db776.jpeg', 0.00, 0, '2025-11-26 12:37:25'),
(17, 'Raya and the Last Dragon', 'adventure', '2021', 'Set in the magical land of Kumandra — where humans and dragons once lived in harmony — the world was saved when dragons sacrificed themselves to drive away evil spirits called the Druun. Five centuries later, the Druun return, threatening to destroy everything. Raya, a brave young warrior, must journey across the land to find the legendary last dragon, Sisu, hoping that together they can restore peace and unity to a fractured world. Along the way, Raya learns that healing the land will take more than magic — it will take trust, courage, and coming together.', '1764311954_6929439288358.jpeg', 5.00, 1, '2025-11-28 06:39:14'),
(18, 'Amazon Adventure', 'adventure', '2017', '“Amazon Adventure” follows the true story of 19th‑century naturalist Henry Walter Bates and his epic, 11‑year exploration of the Amazon rainforest. \r\nSmithsonian Institution\r\n+1\r\n The film showcases the breathtaking biodiversity of the Amazon — from insects using camouflage to extraordinary wildlife — and highlights Bates’s groundbreaking scientific discovery of “mimicry,” a phenomenon that supported ideas about evolution. \r\ngiantscreencinema.com\r\n+2\r\ntangledbankstudios.org\r\n+2\r\n\r\nMore than just a nature documentary, the film mixes adventure and biographical storytelling, depicting Bates’s struggles, discoveries, and passion for the natural world — making it both educational and inspiring.', '1764312018_692943d208b81.jpeg', 0.00, 0, '2025-11-28 06:40:18'),
(19, 'Journey 2: The Mysterious Island', 'adventure', '2012', 'Sean Anderson teams up with his stepfather and pilot Hank to find his missing grandfather on a mysterious island in the Pacific. The island is full of gigantic creatures, hidden dangers, and spectacular landscapes, turning the quest into a thrilling adventure full of puzzles, action, and family bonding.', '1764313201_69294871d4287.png', 0.00, 0, '2025-11-28 07:00:01'),
(20, 'Planet 51', 'animation', '2009', 'Astronaut Chuck Baker lands on Planet 51, only to find it inhabited by little green aliens who fear an invasion from “space invaders.” Chuck must navigate this unfamiliar world while trying to return safely to Earth, all while evading the paranoid alien army. The film mixes humor, adventure, and a playful take on sci-fi tropes.', '1764313265_692948b11a2c0.jpg', 0.00, 0, '2025-11-28 07:01:05'),
(21, 'The Smurfs', 'animation', '2011', 'The Smurfs are transported from their magical village to modern-day New York City, where they must find a way to return home while avoiding the evil wizard Gargamel. The film blends comedy, adventure, and colorful animation for a family-friendly experience.', '1764313321_692948e968a48.jpg', 4.00, 1, '2025-11-28 07:02:01'),
(22, 'Rise of the Guardians', 'animation', '2012', 'When the world’s children start losing their belief in magic, a group of legendary heroes—Santa Claus, the Easter Bunny, the Tooth Fairy, and others—join forces with the new Guardian, Jack Frost, to protect the children from the evil Pitch Black. It’s a thrilling adventure full of magic, teamwork, and heroism.', '1764313371_6929491b0029c.jpg', 0.00, 0, '2025-11-28 07:02:51'),
(23, 'Tangled', 'animation', '2010', 'The film follows Rapunzel, a young princess with magical long hair, who has been locked away in a tower for years. When a charming thief, Flynn Rider, stumbles upon her tower, they embark on a thrilling adventure filled with laughter, romance, and self-discovery.', '1764313423_6929494f89308.jpg', 0.00, 0, '2025-11-28 07:03:43'),
(24, 'The Lion King', 'animation', '2019', 'The Lion King tells the story of Simba, a young lion prince who flees his kingdom after the tragic death of his father, Mufasa. Guided by friends and wise mentors, Simba must reclaim his rightful place as king and bring balance back to the Pride Lands.', '1764313469_6929497d58b66.jpeg', 5.00, 1, '2025-11-28 07:04:29'),
(25, 'Shinchan (Crayon Shin-chan)', 'animation', '1990', 'Shinchan follows the mischievous adventures of 5-year-old Shinnosuke Nohara (Shinchan) and his family. Known for his cheeky antics and hilarious situations, Shinchan’s curiosity and troublemaking often lead to comedic chaos in everyday life.', '1764313618_69294a121955f.jpg', 0.00, 0, '2025-11-28 07:06:58'),
(26, 'Dhamaal', 'comedy', '2007', 'Dhamaal is a fun-filled comedy about four lazy friends who discover a hidden treasure and embark on a chaotic and hilarious chase to find it. Full of slapstick humor, crazy stunts, and comic situations, it’s a classic Bollywood laugh-riot adventure.', '1764313689_69294a594e17a.jpeg', 0.00, 0, '2025-11-28 07:08:09'),
(27, 'Bol Bachchan', 'comedy', '2012', 'Bol Bachchan is a light-hearted comedy about a man who pretends to be someone else to escape trouble, leading to a series of hilarious misunderstandings and chaotic situations. Packed with slapstick humor, funny dialogues, and colorful characters, it’s an entertaining Bollywood entertainer', '1764313723_69294a7b4dd05.jpeg', 0.00, 0, '2025-11-28 07:08:43'),
(28, 'Fukrey', 'comedy', '2013', 'Fukrey is a fun Bollywood comedy about four young men trying to make easy money through a series of ridiculous schemes, which lead them into hilarious and unexpected situations. Full of quirky characters, slapstick humor, and witty dialogues, it’s a lighthearted entertainer.', '1764313763_69294aa311473.jpeg', 0.00, 0, '2025-11-28 07:09:23'),
(29, 'Poster Boys', 'comedy', '2017', 'Poster Boys is a Bollywood comedy that follows the story of three men whose lives turn upside down after their faces accidentally appear on a government poster promoting vasectomy. The film explores the hilarious consequences they face while trying to clear their names.', '1764313794_69294ac24e263.jpeg', 0.00, 0, '2025-11-28 07:09:54'),
(30, 'Dhol', 'comedy', '2007', 'Dhol is a Bollywood comedy about four friends who are constantly looking for easy ways to make money. Their lives take a chaotic turn when they come across a shady deal, leading to a series of hilarious and unexpected situations.', '1764313861_69294b05d7d07.jpeg', 0.00, 0, '2025-11-28 07:11:01'),
(31, '3 Idiots', 'comedy', '2009', '3 Idiots follows the journey of three engineering students and their unique approach to life and education. Through humor, friendship, and life lessons, the film challenges the pressure-filled education system while exploring dreams, creativity, and the value of true friendship', '1764313941_69294b55630ec.jpg', 0.00, 0, '2025-11-28 07:12:21'),
(32, 'Alien', 'science-fiction', '1979', 'A commercial spaceship crew encounters a deadly extraterrestrial creature after investigating a distress signal on a remote planet. Tension, survival, and suspense escalate as the crew fights for their lives against the relentless alien.', '1764314253_69294c8d45158.jpeg', 4.00, 1, '2025-11-28 07:17:33'),
(33, 'Sector 7', 'science-fiction', '2011', 'A deep-sea oil rig crew discovers a deadly creature lurking in the depths. As they try to contain it, the situation escalates into a battle for survival, testing their courage and teamwork', '1764314320_69294cd0acea5.jpeg', 4.00, 1, '2025-11-28 07:18:40'),
(34, 'Hypothetic', 'science-fiction', '2025', 'In a world where every choice spawns a parallel universe, a scientist discovers a way to navigate alternate realities—but meddling with fate comes at a deadly cost.', '1764314393_69294d19bf80f.jpeg', 0.00, 0, '2025-11-28 07:19:53'),
(35, 'Avatar', 'science-fiction', '2009', 'On the alien world of Pandora, a paraplegic Marine is sent to interact with the native Na’vi people and discovers a deeper connection with their land while facing the conflict between corporate interests and nature.', '1764314433_69294d4181d9e.jpeg', 5.00, 1, '2025-11-28 07:20:33'),
(37, 'Total Recall', 'science-fiction', '1990', 'A construction worker discovers that his memories of being on Mars may not be real, leading him on a dangerous journey to uncover his true identity and a conspiracy that could change the fate of the colony.', '1764314556_69294dbcccc5a.jpg', 5.00, 1, '2025-11-28 07:22:36');

-- --------------------------------------------------------

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
(5, 9, 6, 5, 'osm', '2025-11-27 17:21:03'),
(6, 8, 6, 4, 'Explosions galore, pure adrenaline!', '2025-11-24 15:51:58'),
(7, 7, 6, 4, 'Good action Movie', '2025-11-24 15:52:19'),
(8, 11, 6, 4, 'osm', '2025-11-25 11:33:15'),
(9, 11, 5, 4, 'great', '2025-11-25 13:23:36'),
(10, 7, 5, 5, 'highly recommended', '2025-11-25 13:24:20'),
(11, 8, 5, 5, 'great movie', '2025-11-25 13:24:32'),
(12, 1, 5, 4, 'great', '2025-11-25 13:24:42'),
(13, 2, 5, 5, 'great', '2025-11-25 13:24:54'),
(14, 11, 7, 3, 'ok-ok', '2025-11-25 13:26:15'),
(15, 10, 7, 4, 'great', '2025-11-25 13:26:53'),
(16, 9, 7, 4, 'best movie', '2025-11-25 13:27:09'),
(17, 8, 7, 5, 'great movie', '2025-11-25 13:27:21'),
(18, 7, 7, 4, 'beat movie', '2025-11-25 13:27:32'),
(19, 2, 7, 5, 'great', '2025-12-04 16:54:45'),
(20, 1, 7, 4, 'osm', '2025-11-25 13:28:19'),
(21, 5, 7, 5, 'osm', '2025-11-25 13:28:49'),
(22, 4, 7, 4, 'best movie', '2025-11-25 13:29:01'),
(23, 13, 7, 5, 'best movie for children', '2025-11-25 13:29:34'),
(24, 3, 7, 5, 'best comedy movie', '2025-11-25 13:29:51'),
(26, 14, 7, 4, 'nyc movie', '2025-12-03 11:42:27'),
(27, 24, 7, 5, 'best annimation movie', '2025-12-03 15:14:17'),
(28, 37, 7, 5, 'osm', '2025-12-03 15:18:51'),
(29, 17, 7, 5, 'awesome', '2025-12-03 15:45:27'),
(30, 21, 7, 4, 'beautiful', '2025-12-03 15:45:50'),
(31, 12, 7, 4, 'Creativity', '2025-12-03 18:13:09'),
(32, 33, 7, 4, 'Technology, science concepts', '2025-12-03 18:13:47'),
(33, 35, 7, 5, 'Technology, science concepts', '2025-12-03 18:14:01'),
(34, 32, 7, 4, 'World-building and futuristic ideas', '2025-12-03 18:14:31');

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
(6, 'Mohit', 'mohit@gmail.com', '$2y$10$F/2jWZg7oEgLbbfFogkAc.d4MfEOkfJZCCdC6lOz5yWN3.B9.yVlO', 'user', '2025-11-20 07:34:36'),
(7, 'Ankit', 'ankit@gmail.com', '$2y$10$1KKLVK5MZGavhvTPNbc9aOJ.4IisgkudsLBSfsguv6QqWXpPSCTBC', 'user', '2025-11-25 07:55:48'),
(8, 'Yash', 'yash@gmail.com', '$2y$10$opveVQrgHRVnXChNK5TBXeuA/ZPjCwYduiDh16kBDbvfySV9BDsS.', 'user', '2025-11-26 06:32:53'),
(10, 'Garima', 'garima@gmail.com', '$2y$10$bkqYli4vgWHUjucBSSvEC.qADLaIYcrREEhz2BSCYTpsLGXlQAwpS', 'user', '2025-11-26 06:34:36'),
(12, 'Chandan', 'chandan@gmail.com', '$2y$10$Y8.x/QdAPygw/V8yEMDk1.xWTB0fizGYzmYkQVUXNKy/7.4GWHTU6', 'user', '2025-11-26 06:36:10'),
(14, 'Raghav', 'raghav@gmail.com', '$2y$10$FPUtGWAe6wxJ9IiIQ4GJI.A7TOB.WlLyOSdzD4QKVsO.h6FS/QKA2', 'user', '2025-11-26 06:38:44');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
