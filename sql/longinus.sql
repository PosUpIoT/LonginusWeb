-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 16, 2016 at 09:30 PM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `longinusapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `create_date`, `update_date`, `delete_date`) VALUES
(1, 'Pessoa', '2016-07-16 00:00:00', NULL, NULL),
(2, 'Carro', '2016-07-16 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_properties`
--

CREATE TABLE `category_properties` (
  `id` bigint(20) NOT NULL,
  `id_category` bigint(20) NOT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_value` text NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` bigint(20) NOT NULL,
  `id_post` bigint(20) NOT NULL,
  `path` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `delete_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `id_category` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `type`, `status`, `latitude`, `longitude`, `id_category`, `id_user`, `create_date`, `update_date`, `delete_date`) VALUES
(2, 'Teste', 'Teste', 1, 1, -25.4456, -48.4456, 1, 1, '2016-07-16 14:58:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_category_data`
--

CREATE TABLE `post_category_data` (
  `id` bigint(20) NOT NULL,
  `id_category_properties` bigint(20) NOT NULL,
  `id_post` bigint(20) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `role` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `google` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime DEFAULT NULL,
  `delete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `facebook`, `google`, `twitter`, `password`, `phone`, `create_date`, `update_date`, `delete_date`) VALUES
(1, 2, 'admin', 'admin@admin.com', NULL, NULL, NULL, 'dccd96c256bc7dd39bae41a405f25e43', '4199999999', '2016-07-16 00:00:00', NULL, NULL),
(2, 1, 'João', 'joao@outlook.com', '', '', '', '72b302bf297a228a75730123efef7c41', '4188888888', '2016-07-16 14:23:33', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_properties`
--
ALTER TABLE `category_properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `post_category_data`
--
ALTER TABLE `post_category_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category_properties` (`id_category_properties`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category_properties`
--
ALTER TABLE `category_properties`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `post_category_data`
--
ALTER TABLE `post_category_data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `category_properties`
--
ALTER TABLE `category_properties`
  ADD CONSTRAINT `fk_properties_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `fk_picture_post` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_post_category` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `fk_post_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `post_category_data`
--
ALTER TABLE `post_category_data`
  ADD CONSTRAINT `fk_post_category_data` FOREIGN KEY (`id_category_properties`) REFERENCES `category_properties` (`id`),
  ADD CONSTRAINT `fk_post_data` FOREIGN KEY (`id_post`) REFERENCES `posts` (`id`);
