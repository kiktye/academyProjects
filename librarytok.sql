-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2024 at 09:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarytok`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `short_bio` varchar(255) NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `first_name`, `last_name`, `short_bio`, `deleted_at`) VALUES
(1, 'Colleen', 'Hoover', 'Colleen Hoover is an American author who primarily writes novels in the romance and young adult fiction genres. She is best known for her 2016 romance novel It Ends with Us. Many of her works were self-published before being picked up by a publishing hous', '0000-00-00 00:00:00'),
(2, 'Mark', 'Manson', 'Mark Manson is an American self-help author and blogger. As of 2024, he has authored or co-authored four books, three of which, The Subtle Art of Not Giving a F*ck, Everything Is F*cked: A Book About Hope, and Will, were New York Times bestsellers.', '0000-00-00 00:00:00'),
(3, 'James', 'Clear', 'James Clear is an American writer. He is best known for his book Atomic Habits.', '0000-00-00 00:00:00'),
(4, ' Kiko ', ' Stojanov ', ' Is the author of this project! :D', '2024-06-18 18:20:59'),
(5, 'Brianna', 'Wiest', 'Brianna Wiest is the international bestselling author of \'101 Essays That Will Change The Way You Think, \' \'The Mountain Is You, \' \'This Is How You Heal, \' two poetry collections, and more..', '0000-00-00 00:00:00'),
(6, 'J. R. R. ', 'Tolkien', 'John Ronald Reuel Tolkien CBE FRSL was an English writer and philologist. He was the author of the high fantasy works The Hobbit and The Lord of the Rings. From 1925 to 1945, Tolkien was the Rawlinson and Bosworth Professor of Anglo-Saxon and a Fellow of ', '0000-00-00 00:00:00'),
(7, 'Bram', 'Stoker', 'Abraham \"Bram\" Stoker was an Irish author who is best known for writing the 1897 Gothic horror novel Dracula. During his lifetime, he was better known as the personal assistant of actor Sir Henry Irving and business manager of the West End\'s Lyceum Theatr', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` bigint(20) NOT NULL,
  `book_title` varchar(255) NOT NULL,
  `book_publish_year` varchar(255) NOT NULL,
  `book_pages` varchar(255) NOT NULL,
  `book_image` varchar(255) NOT NULL,
  `author_id` bigint(20) NOT NULL,
  `category_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `book_title`, `book_publish_year`, `book_pages`, `book_image`, `author_id`, `category_id`) VALUES
(1, 'Dracula', '1897', '448', 'https://m.media-amazon.com/images/I/61w70l39W9L._AC_UF894,1000_QL80_.jpg', 7, 2),
(2, 'Atomic Habits', '2018', '320', 'https://m.media-amazon.com/images/I/81YkqyaFVEL._AC_UF894,1000_QL80_.jpg', 3, 7),
(3, 'THE SUBTLE ART OF NOT GIVING A F*CK', '2016', '272', 'https://m.media-amazon.com/images/I/71t4GuxLCuL._AC_UF894,1000_QL80_.jpg', 2, 7),
(4, 'It Starts with Us', '2022', '376', 'https://m.media-amazon.com/images/I/71PNGYHykrL._AC_UF894,1000_QL80_.jpg', 1, 8),
(5, 'The Lord of The Rings', ' 1954 ', '1759', 'https://m.media-amazon.com/images/I/81nV6x2ey4L._AC_UF894,1000_QL80_.jpg', 6, 4),
(6, 'The Mountain Is You', '2020', '248', 'https://m.media-amazon.com/images/I/71AHFDEpkdL._AC_UF894,1000_QL80_.jpg', 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `category_type` varchar(255) NOT NULL,
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_type`, `deleted_at`) VALUES
(1, 'Thriller', '0000-00-00 00:00:00'),
(2, '  Horror', '0000-00-00 00:00:00'),
(3, 'Drama', '0000-00-00 00:00:00'),
(4, 'Fantasy', '0000-00-00 00:00:00'),
(5, 'Mystery', '0000-00-00 00:00:00'),
(6, 'Adventure', '0000-00-00 00:00:00'),
(7, 'Self-help', '0000-00-00 00:00:00'),
(8, 'Romance', '0000-00-00 00:00:00'),
(9, 'History', '2024-06-21 11:57:03');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `book_id` bigint(20) NOT NULL,
  `admin_verified` int(11) NOT NULL,
  `in_queue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `text`, `user_id`, `book_id`, `admin_verified`, `in_queue`) VALUES
(2, 'The author is so creative and cool!', 2, 3, 1, 0),
(3, 'It took me 4 years to read all 1700 pages...', 2, 5, 0, 0),
(4, 'So scary!', 2, 1, 0, 0),
(6, 'It\'s a good summer book to read on the beach.', 3, 4, 1, 0),
(7, 'Super!', 3, 6, 1, 0),
(8, 'Admin\'s favorite!', 1, 3, 1, 0),
(9, 'Book is amazing!', 4, 2, 1, 0),
(10, 'Helped me push the mountain..', 4, 6, 1, 0),
(11, 'The vocabulay is hard', 4, 5, 0, 1),
(12, 'Admin can comment too', 1, 1, 0, 1),
(13, 'good book about awareness of love', 2, 4, 0, 1),
(14, 'This book made me more disciplined!', 3, 2, 0, 1),
(15, 'This is my favorite Book..', 2, 2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `book_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `title`, `text`, `user_id`, `book_id`) VALUES
(2, 'Page 100', 'I have read till page 100.. Continue soon.', 1, 3),
(3, 'I got scared!', 'Page 223 was so scary..', 4, 1),
(4, 'Hard to read', 'The vocabulay is too extensive', 4, 5),
(6, 'page', 'i\'ve read till page 210', 2, 2),
(7, 'Dracula', 'Drakulesta', 1, 1),
(8, 'The book is scary', 'I think this book is Scary!', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `registered_users`
--

CREATE TABLE `registered_users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_users`
--

INSERT INTO `registered_users` (`id`, `username`, `email`, `password`, `user_type_id`) VALUES
(1, 'admin', 'admin', '$2y$10$6EjBHyA6bIt67TcIonqef.6L6Q1Aay8rNOieW7JJIXlMWDzPfp5ei', 1),
(2, 'kiktye', 'kiktye@gmail.com', '$2y$10$KY6CL6734nochroyDTyrXep2eBVZTZyBjscreDaa5Kx7u5DriAWqy', 2),
(3, 'milena', 'milena@gmail.com', '$2y$10$e6/Bq60Oh.51BUJzml/WUeAyKvPa0Gkek.0aBQra9QlyGAJBWvuki', 2),
(4, 'testUser', 'testuser@gmail.com', '$2y$10$tUp4hAxg0IzRS7wtUB3pVei/Y3JntkXNSFAAmuRUDi2yHVVukyo0W', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id` bigint(20) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `type`) VALUES
(1, 'admin'),
(2, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_users`
--
ALTER TABLE `registered_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registered_users`
--
ALTER TABLE `registered_users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
