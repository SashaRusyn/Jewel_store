-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Трв 23 2023 р., 00:04
-- Версія сервера: 10.4.25-MariaDB
-- Версія PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `jewel_shop_db`
--

-- --------------------------------------------------------

--
-- Структура таблиці `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `name`, `price`, `quantity`, `image`) VALUES
(57, 5, 'Darknet', 50, 1, 'darknet.jpg'),
(58, 5, 'Clever Lands', 35, 1, 'clever_lands.jpg'),
(103, 6, 'Срібний хрестик без вставки. Артикул PTGXX000013-P/12', 2030, 1, '3.png');

-- --------------------------------------------------------

--
-- Структура таблиці `decorations`
--

CREATE TABLE `decorations` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `decorations`
--

INSERT INTO `decorations` (`id`, `name`, `price`, `image`, `type`) VALUES
(1, 'Золоті пусети з раухтопазом і фіанітами. Артикул 50283/01/0/5126 (50283/раух кп)', 7100, '1.png', 'Сережки'),
(2, 'Золота каблучка з діамантами і сапфіром. Артикул UG553539/02/1/10257', 19002, '2.png', 'Каблучки'),
(3, 'Срібний хрестик без вставки. Артикул PTGXX000013-P/12', 2030, '3.png', 'Хрестики'),
(4, 'Золоте кольє. Артикул 6080/66024-3/01/0', 8023, '4.png', 'Колье'),
(5, 'Золоте кольє. Артикул UG54/21/180/1', 5388, '5.png', 'Колье'),
(6, 'Срібна каблучка «Квітка» з фіанітами. Артикул ML13981A-R/12/1', 1909, '6.png', 'Каблучки'),
(7, 'Срібний браслет на ногу. Артикул UG51BR66103', 1242, '7.png', 'Ланцюжки');

-- --------------------------------------------------------

--
-- Структура таблиці `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Очікується'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(15, 6, 'Русин Олександр Іванович', '+38066211594', 'sasharusyn11@gmail.com', 'GooglePay', 'Область: Закарпатська, Район: Хустський, Населений пункт:  Пилипець', 'Золотий годинник кварцевий. Артикул 9112-2/01/0 (9112/ч рч) (1) ', 48363, '21-May-2023', 'Очікується'),
(16, 6, 'Русин Олександр Іванович', '+38066211594', 'sasharusyn11@gmail.com', 'Готівниковий платіж', 'Область: Закарпатська, Район: Хустський, Населений пункт:  Пилипець', 'Золотий годинник кварцевий. Артикул 9112-2/01/0 (9112/ч рч) (1) ', 48363, '21-May-2023', 'Виконано'),
(17, 6, 'Русин Олександр Іванович', '+38066211594', 'sasharusyn11@gmail.com', 'Готівниковий платіж', 'Область: Закарпатська, Район: Хустський, Населений пункт:  Пилипець', 'Золоті пусети з раухтопазом і фіанітами. Артикул 50283/01/0/5126 (50283/раух кп) (2) ', 14200, '21-May-2023', 'Очікується'),
(18, 6, 'Русин Олександр Іванович', '+38066211594', 'sasharusyn11@gmail.com', 'Готівниковий платіж', 'Область: Закарпатська, Район: Хустський, Населений пункт:  Пилипець', 'Золоте кольє. Артикул UG54/21/180/1 (2) ', 10776, '22-May-2023', 'Очікується');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(3, 'sasharusyn', 'sasharusyn11@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'),
(4, 'Veronika', 'veronikarusyn17@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'),
(6, 'sasharusyn1', 'sasharusyn111@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'),
(7, 'admin', 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'admin');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `decorations`
--
ALTER TABLE `decorations`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT для таблиці `decorations`
--
ALTER TABLE `decorations`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблиці `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблиці `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
