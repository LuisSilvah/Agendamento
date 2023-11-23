-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/06/2023 às 19:17
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `salas`
--

CREATE TABLE `salas` (
  `id` int(11) NOT NULL,
  `sol_name` varchar(45) NOT NULL,
  `sol_email` varchar(45) NOT NULL,
  `hora_ini` time NOT NULL,
  `hora_fim` time NOT NULL,
  `sala` varchar(45) NOT NULL,
  `obs_cafe` varchar(45) NOT NULL,
  `data` date NOT NULL,
  `usuarioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `salas`
--

INSERT INTO `salas` (`id`, `sol_name`, `sol_email`, `hora_ini`, `hora_fim`, `sala`, `obs_cafe`, `data`, `usuarioId`) VALUES
(111, 'Diego', 'diegobezerra@selmi.com.br', '10:00:00', '12:00:00', 'vinho', 'Queremos Vinho', '2023-06-26', 424),
(141, 'Luis', 'Luisgustavo@selmi.com.br', '10:00:00', '11:00:00', 'selmi', '', '2023-06-26', 401),
(142, 'Luis', 'Luisgustavo@selmi.com.br', '09:00:00', '12:00:00', 'selmi', '', '2023-06-26', 401),
(145, 'Luis', 'Luisgustavo@selmi.com.br', '16:00:00', '17:00:00', 'selmi', '', '2023-06-26', 401);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `status`) VALUES
(401, 'luisgustavo', 'Luis Gustavo', 'luisgustavo@selmi.com.br', '$2y$10$Hmt49SsxJaqukoB2FYdEV.LhMwwLYETHridbTS32YmSkQvzDW//ji', 'user'),
(424, 'diegomoura', 'Diego Moura', 'diegomoura@selmi.com.br', '$2y$10$IIpskr2j4MdwKKtLGhZvmeI3TfJGdADj.43uSEDozHz6MSwTfTe16', 'admin'),
(425, 'rogerzinho', 'Roger Santos', 'rogersantos@selmi.com.br', '$2y$10$HhjjgdwlDTGm88xjctTzVOX.nskUCs/HR/zcNb5N1Ohhut0Dccf0K', 'user');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `salas`
--
ALTER TABLE `salas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
