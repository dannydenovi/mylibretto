-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 03, 2023 alle 23:02
-- Versione del server: 8.0.26
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_mylibrettoprogetto`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `classes`
--

CREATE TABLE `classes` (
  `class_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `professor` varchar(256) NOT NULL,
  `day` varchar(256) NOT NULL,
  `timeStart` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `timeEnd` varchar(256) NOT NULL,
  `place` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `classes`
--

INSERT INTO `classes` (`class_id`, `user_id`, `name`, `professor`, `day`, `timeStart`, `timeEnd`, `place`) VALUES
(8, 5, 'Sicurezza dei Sistemi', 'Antonino Galletta', 'Tuesday', '09:00', '11:00', 'SBA LAB 2-2'),
(9, 5, 'Sicurezza dei Sistemi', 'Antonino Galletta', 'Tuesday', '11:00', '13:00', 'MIFT A-S-1'),
(12, 5, 'Laboratorio di Intelligenza Artificiale', 'Mario Grasso', 'Monday', '09:00', '12:00', 'MIFT A-S-1'),
(13, 5, 'Sicurezza dei Sistemi', 'Antonino Galletta', 'Monday', '12:00', '14:00', 'SBA LAB 2-2'),
(14, 5, 'Programmazione Web e Mobile', 'Andrea Nucita', 'Wednesday', '09:00', '13:00', 'MIFT A-S-1'),
(15, 5, 'Laboratorio di Intelligenza Artificiale', 'Mario Grasso', 'Thursday', '09:00', '12:00', 'MIFT A-S-1'),
(16, 5, 'Sicurezza dei Sistemi', 'Antonino Galletta', 'Thursday', '12:00', '14:00', 'MIFT A-S-1'),
(17, 5, 'Programmazione Web e Mobile', 'Andrea Nucita', 'Friday', '09:00', '13:00', 'SBA LAB T-3'),
(23, 11, 'Istituzioni di Diritto Privato II', 'Prof.re Gian Antonio Benacchio', 'Saturday', '09:00', '11:00', '2');

-- --------------------------------------------------------

--
-- Struttura della tabella `exams`
--

CREATE TABLE `exams` (
  `exam_id` int NOT NULL,
  `user_id` int NOT NULL,
  `subject` varchar(256) NOT NULL,
  `mark` int NOT NULL,
  `cfu` double NOT NULL,
  `professor` varchar(256) NOT NULL,
  `exam_date` date NOT NULL,
  `eligibility` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `exams`
--

INSERT INTO `exams` (`exam_id`, `user_id`, `subject`, `mark`, `cfu`, `professor`, `exam_date`, `eligibility`) VALUES
(1, 5, 'Programmazione Ad Oggetti', 31, 9, 'Antonino Galletta', '2022-09-30', 0),
(2, 5, 'Sistemi Operativi', 31, 12, 'Marco Lucio Scarpa', '2022-09-29', 0),
(3, 5, 'Database', 31, 12, 'Massimo Villari', '2022-09-09', 0),
(4, 5, 'Logica per Informatica', 31, 6, 'Marilena Crupi', '2022-01-25', 0),
(5, 5, 'Architettura degli Elaboratori', 30, 6, 'Dario Bruneo', '2022-07-12', 0),
(6, 5, 'Fisica', 24, 12, 'Mauro Federico', '2022-05-13', 0),
(9, 5, 'Statistical Methods And Models', 26, 6, 'David Barilla', '2022-06-13', 0),
(10, 5, 'Reti di Calcolatori', 28, 6, 'Antonio Puliafito', '2022-01-18', 0),
(11, 5, 'Programmazione', 26, 9, 'Maria Fazio', '2021-09-06', 0),
(12, 5, 'Calcolo', 23, 12, 'Maria Paola Speciale', '2021-07-20', 0),
(13, 5, 'Matematica Discreta', 24, 6, 'Luisa Carini', '2021-01-28', 0),
(37, 5, 'Corso LaTeX A.A 2020/2021', 0, 2, '-', '2021-06-23', 1),
(38, 5, 'Debito OFA', 0, 0, '-', '2021-01-28', 1),
(39, 5, 'Partecipazione a videoconferenza \"Il sistema politico Statunitense: elezioni presidenziali 2020\"', 0, 0.25, '-', '2020-11-03', 1),
(40, 5, 'PES: \"D.L.81/08 e sicurezza nei laboratori\"', 0, 2, '-', '2021-02-24', 1),
(41, 5, 'Seminario \"Referendum costituzionale: il valore della rappresentanza\"', 0, 0.25, '-', '2020-09-17', 1),
(42, 5, 'Fondamenti Linux e cloud per sistemi aziendali', 0, 2, '-', '2022-05-14', 1),
(43, 5, 'Digital Day IEEE-CCGRID 2022', 0, 0.5, '-', '2022-05-16', 1),
(49, 11, 'Istituzione di Diritto Europeo', 30, 9, 'Prof.re Jeans Woelk', '2022-07-14', 0),
(50, 11, 'Introduzione all\'Economia', 28, 6, 'Prof.re Massimiliano Vatiero', '2022-04-26', 0),
(52, 11, 'Chimica Molecolare ', 0, 29, '-', '2022-11-20', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `infos`
--

CREATE TABLE `infos` (
  `user_id` int NOT NULL,
  `total_credits` int NOT NULL,
  `laude_value` int NOT NULL,
  `faculty` varchar(256) NOT NULL,
  `university` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `infos`
--

INSERT INTO `infos` (`user_id`, `total_credits`, `laude_value`, `faculty`, `university`) VALUES
(5, 180, 31, 'Scienze e Tecnologie Informatiche', 'University of Messina'),
(11, 300, 31, 'Giurisprudenza', 'University of Trento');

-- --------------------------------------------------------

--
-- Struttura della tabella `taxes`
--

CREATE TABLE `taxes` (
  `tax_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `date` date NOT NULL,
  `amount` varchar(256) NOT NULL,
  `paid` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `taxes`
--

INSERT INTO `taxes` (`tax_id`, `user_id`, `name`, `date`, `amount`, `paid`) VALUES
(5, 5, 'Tassa Regionale A.A 2022/2023', '2022-10-25', '154.51', 1),
(6, 5, 'Abbonamento ATM 2022/23', '2022-10-25', '30', 1),
(14, 11, 'Immatricolazione', '2022-09-29', '450', 1),
(15, 11, 'Diritto allo studio', '2022-12-16', '1300', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(256) NOT NULL,
  `surname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`) VALUES
(5, 'Danny', 'De Novi', 'dannydenovi@gmail.com', '$2y$10$BG8VDn5sCvpbyDDyHOY2Huzede/5nzXQp4X6x0mWpvKhcpsT/17dC'),
(11, 'Maria Pia', 'Milazzo', 'milazzomariapia12@gmail.com', '$2y$10$LnX3D7Qpnh3QEQ9Rg3ccAOxjsAxEeh/UpGA0WBuZWeZgFIEZjCYua');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `user-classes` (`user_id`);

--
-- Indici per le tabelle `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `user-exams` (`user_id`);

--
-- Indici per le tabelle `infos`
--
ALTER TABLE `infos`
  ADD KEY `user` (`user_id`);

--
-- Indici per le tabelle `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`tax_id`),
  ADD KEY `user-fees` (`user_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT per la tabella `taxes`
--
ALTER TABLE `taxes`
  MODIFY `tax_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `user-classes` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `user-exams` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `infos`
--
ALTER TABLE `infos`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `taxes`
--
ALTER TABLE `taxes`
  ADD CONSTRAINT `user-fees` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
