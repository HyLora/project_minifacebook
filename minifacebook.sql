-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 22, 2024 alle 11:12
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minifacebook`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `amicizia`
--

CREATE TABLE `amicizia` (
  `Mittente` varchar(30) NOT NULL,
  `Destinatario` varchar(30) NOT NULL,
  `dataAccettazione` datetime DEFAULT NULL,
  `dataRichiesta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `amicizia`
--

INSERT INTO `amicizia` (`Mittente`, `Destinatario`, `dataAccettazione`, `dataRichiesta`) VALUES
('badgirl@mail.it', 'agata@mail.it', '0000-00-00 00:00:00', '2024-02-10 17:22:05'),
('badgirl@mail.it', 'badguy@mail.it', '2024-02-10 17:23:00', '2024-02-10 17:22:15'),
('badgirl@mail.it', 'fabolouslady@mail.it', '2024-02-10 17:23:32', '2024-02-10 17:22:37'),
('badguy@mail.it', 'fabolouslady@mail.it', '2023-10-10 16:27:03', '2023-10-10 12:27:03'),
('badguy@mail.it', 'ilikechocolate@mail.it', '2023-10-11 16:13:50', '2023-10-10 15:27:03'),
('chiara.mascetti@mail.it', 'angelica.milanesi@mail.it', '0000-00-00 00:00:00', '2023-12-02 19:04:36'),
('chiara.mascetti@mail.it', 'fabolouslady@mail.it', '2020-02-10 15:08:12', '2020-02-10 07:11:07'),
('chiara.mascetti@mail.it', 'ilikechocolate@mail.it', '2020-01-03 10:08:12', '2020-01-02 12:12:55'),
('chiara.mascetti@mail.it', 'laura.capella@mail.it', '2023-12-05 16:48:49', '2023-12-05 16:48:33'),
('elisaamaicani@mail.it', 'chiara.mascetti@mail.it', '2020-01-19 10:08:12', '2020-01-18 12:00:12'),
('fabolouslady@mail.it', 'elisaamaicani@mail.it', '2019-11-27 13:00:10', '2019-11-27 12:18:10'),
('fabolouslady@mail.it', 'riccardo.rossi@mail.it', '2019-01-20 10:08:12', '2019-01-19 16:12:12'),
('ilikechocolate@mail.it', 'laura.capella@mail.it', '2020-01-03 19:30:02', '2020-01-02 14:37:50'),
('laura.capella@mail.it', 'angelica.milanesi@mail.it', '0000-00-00 00:00:00', '2023-12-02 19:01:28'),
('laura.capella@mail.it', 'fabolouslady@mail.it', '2020-01-01 19:30:02', '2020-01-01 19:10:02'),
('laura.capella@mail.it', 'gaia.prussy@mail.it', '0000-00-00 00:00:00', '2023-12-12 17:22:57'),
('riccardo.rossi@mail.it', 'elisaamaicani@mail.it', NULL, '2022-10-19 12:16:20');

-- --------------------------------------------------------

--
-- Struttura della tabella `citta`
--

CREATE TABLE `citta` (
  `Nome` varchar(20) NOT NULL,
  `Provincia` varchar(20) NOT NULL,
  `Stato` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `citta`
--

INSERT INTO `citta` (`Nome`, `Provincia`, `Stato`) VALUES
('Agrigento', 'AG', 'Italia'),
('Alessandria', 'AL', 'Italia'),
('Ancona', 'AN', 'Italia'),
('Aosta', 'AO', 'Italia'),
('Arezzo', 'AR', 'Italia'),
('Ascoli Piceno', 'AP', 'Italia'),
('Asti', 'AT', 'Italia'),
('Avellino', 'AV', 'Italia'),
('Bari', 'BA', 'Italia'),
('Barletta-Andria-Tran', 'BT', 'Italia'),
('Belluno', 'BL', 'Italia'),
('Benevento', 'BN', 'Italia'),
('Bergamo', 'BG', 'Italia'),
('Biella', 'BI', 'Italia'),
('Bologna', 'BO', 'Italia'),
('Bolzano', 'BZ', 'Italia'),
('Brescia', 'BS', 'Italia'),
('Brindisi', 'BR', 'Italia'),
('Cagliari', 'CA', 'Italia'),
('Caltanissetta', 'CL', 'Italia'),
('Campobasso', 'CB', 'Italia'),
('Carbonia-Iglesias', 'CI', 'Italia'),
('Caserta', 'CE', 'Italia'),
('Catania', 'CT', 'Italia'),
('Catanzaro', 'CZ', 'Italia'),
('Chieti', 'CH', 'Italia'),
('Colverde', 'CO', 'Italia'),
('Como', 'CO', 'Italia'),
('Cosenza', 'CS', 'Italia'),
('Cremona', 'CR', 'Italia'),
('Crotone', 'KR', 'Italia'),
('Cuneo', 'CN', 'Italia'),
('Enna', 'EN', 'Italia'),
('Fermo', 'FM', 'Italia'),
('Ferrara', 'FE', 'Italia'),
('Firenze', 'FI', 'Italia'),
('Foggia', 'FG', 'Italia'),
('Forl?-Cesena', 'FC', 'Italia'),
('Frosinone', 'FR', 'Italia'),
('Genova', 'GE', 'Italia'),
('Gorizia', 'GO', 'Italia'),
('Grosseto', 'GR', 'Italia'),
('Imperia', 'IM', 'Italia'),
('Isernia', 'IS', 'Italia'),
('L\'Aquila', 'AQ', 'Italia'),
('La Spezia', 'SP', 'Italia'),
('Latina', 'LT', 'Italia'),
('Lecce', 'LE', 'Italia'),
('Lecco', 'LC', 'Italia'),
('Livorno', 'LI', 'Italia'),
('Lodi', 'LO', 'Italia'),
('Lucca', 'LU', 'Italia'),
('Macerata', 'MC', 'Italia'),
('Mantova', 'MN', 'Italia'),
('Massa-Carrara', 'MS', 'Italia'),
('Matera', 'MT', 'Italia'),
('Medio Campidano', 'VS', 'Italia'),
('Messina', 'ME', 'Italia'),
('Milano', 'MI', 'Italia'),
('Modena', 'MO', 'Italia'),
('Monza e della Brianz', 'MB', 'Italia'),
('Napoli', 'NA', 'Italia'),
('Nembro', 'BG', 'Italia'),
('Novara', 'NO', 'Italia'),
('Nuoro', 'NU', 'Italia'),
('Ogliastra', 'OG', 'Italia'),
('Olbia-Tempio', 'OT', 'Italia'),
('Oristano', 'OR', 'Italia'),
('Padova', 'PD', 'Italia'),
('Palermo', 'PA', 'Italia'),
('Parma', 'PR', 'Italia'),
('Pavia', 'PV', 'Italia'),
('Perugia', 'PG', 'Italia'),
('Pesaro e Urbino', 'PU', 'Italia'),
('Pescara', 'PE', 'Italia'),
('Piacenza', 'PC', 'Italia'),
('Pisa', 'PI', 'Italia'),
('Pistoia', 'PT', 'Italia'),
('Pordenone', 'PN', 'Italia'),
('Potenza', 'PZ', 'Italia'),
('Prato', 'PO', 'Italia'),
('Ragusa', 'RG', 'Italia'),
('Ravenna', 'RA', 'Italia'),
('Reggio Calabria', 'RC', 'Italia'),
('Reggio Emilia', 'RE', 'Italia'),
('Rieti', 'RI', 'Italia'),
('Rimini', 'RN', 'Italia'),
('Roma', 'RM', 'Italia'),
('Rovigo', 'RO', 'Italia'),
('Salerno', 'SA', 'Italia'),
('Sassari', 'SS', 'Italia'),
('Savona', 'SV', 'Italia'),
('Siena', 'SI', 'Italia'),
('Siracusa', 'SR', 'Italia'),
('Sondrio', 'SO', 'Italia'),
('Taranto', 'TA', 'Italia'),
('Teramo', 'TE', 'Italia'),
('Terni', 'TR', 'Italia'),
('Torino', 'TO', 'Italia'),
('Trapani', 'TP', 'Italia'),
('Trento', 'TN', 'Italia'),
('Treviso', 'TV', 'Italia'),
('Trieste', 'TS', 'Italia'),
('Udine', 'UD', 'Italia'),
('Varese', 'VA', 'Italia'),
('Venezia', 'VE', 'Italia'),
('Verbano-Cusio-Ossola', 'VB', 'Italia'),
('Vercelli', 'VC', 'Italia'),
('Verona', 'VR', 'Italia'),
('Vibo Valentia', 'VV', 'Italia'),
('Vicenza', 'VI', 'Italia'),
('Viterbo', 'VT', 'Italia');

-- --------------------------------------------------------

--
-- Struttura della tabella `commento`
--

CREATE TABLE `commento` (
  `UtenteCommento` varchar(30) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Testo` varchar(50) NOT NULL,
  `EmailMessaggio` varchar(30) NOT NULL,
  `DataMessaggio` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `popup` varchar(30) DEFAULT NULL,
  `datapopup` timestamp NULL DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `commento`
--

INSERT INTO `commento` (`UtenteCommento`, `Data`, `Testo`, `EmailMessaggio`, `DataMessaggio`, `popup`, `datapopup`, `id`) VALUES
('angelica.milanesi@mail.it', '2022-12-25 10:54:24', 'Buon Natale :D', 'elisaamaicani@mail.it', '2023-12-12 17:03:21', NULL, NULL, 1),
('badguy@mail.it', '2023-10-19 12:59:35', 'Sembrate molto stupidi', 'elisaamaicani@mail.it', '2023-12-12 17:03:21', NULL, NULL, 2),
('badguy@mail.it', '2023-10-19 14:25:33', 'Mangia di meno, ciccione!', 'ilikechocolate@mail.it', '2023-12-12 17:04:09', NULL, NULL, 3),
('badguy@mail.it', '2023-10-19 14:30:58', 'Sembri una zoccola!!!', 'fabolouslady@mail.it', '2023-12-12 17:04:04', NULL, NULL, 4),
('chiara.mascetti@mail.it', '2022-02-14 20:00:41', 'Adoro anch\'io la cioccolata!', 'ilikechocolate@mail.it', '2023-12-12 17:04:09', NULL, NULL, 5),
('chiara.mascetti@mail.it', '2022-12-25 09:54:24', 'Buon Natale anche a voi!!', 'elisaamaicani@mail.it', '2023-12-12 17:03:21', NULL, NULL, 6),
('chiara.mascetti@mail.it', '2023-03-28 18:50:33', 'Mentre tu bevi, Elisa si fa una sana passeggiata ', 'fabolouslady@mail.it', '2023-12-12 17:03:56', 'elisaamaicani@mail.it', '2023-12-12 17:03:56', 7),
('chiara.mascetti@mail.it', '2023-06-11 22:00:17', 'Divertiti anche per me che sto studiando :(', 'fabolouslady@mail.it', '2023-12-12 17:04:04', NULL, NULL, 8),
('chiara.mascetti@mail.it', '2024-01-20 14:44:33', 'Hai ragione, che tristezza :C', 'laura.capella@mail.it', '2020-04-15 07:08:21', NULL, NULL, 9),
('elisaamaicani@mail.it', '2023-06-12 18:00:00', 'Non bere troppo!!!', 'fabolouslady@mail.it', '2023-12-12 17:04:04', NULL, NULL, 13),
('fabolouslady@mail.it', '2022-12-31 23:56:11', 'Buon anno anche a te caro ;)', 'riccardo.rossi@mail.it', '2022-12-31 22:09:09', NULL, NULL, 14),
('fabolouslady@mail.it', '2023-10-21 12:20:39', 'Tu e Chiara mangiate troppa pizza!', 'laura.capella@mail.it', '2023-10-21 10:15:41', 'chiara.mascetti@mail.it', '2021-10-11 14:59:19', 15),
('laura.capella@mail.it', '2022-02-14 20:48:21', 'Ne ho mangiata tantissima! :D', 'ilikechocolate@mail.it', '2023-12-12 17:04:09', NULL, NULL, 16),
('laura.capella@mail.it', '2023-06-12 17:52:17', 'Divertitiiiii', 'fabolouslady@mail.it', '2023-12-12 17:04:04', NULL, NULL, 17),
('laura.capella@mail.it', '2024-02-21 14:58:28', 'sempre a bere e fare tardi!', 'fabolouslady@mail.it', '2023-12-12 17:04:09', NULL, NULL, 27),
('laura.capella@mail.it', '2024-02-21 14:59:15', 'non mangiare troppa cioccolata che fa male!', 'ilikechocolate@mail.it', '2023-12-12 17:04:09', NULL, NULL, 28),
('laura.capella@mail.it', '2024-02-21 15:00:14', 'io mangio pizza', 'fabolouslady@mail.it', '2023-12-12 17:03:56', 'laura.capella@mail.it', '2020-04-15 07:08:21', 30),
('laura.capella@mail.it', '2024-02-21 16:18:45', 'fai troppa festa tuuuu', 'fabolouslady@mail.it', '2023-12-12 17:04:09', NULL, NULL, 31),
('laura.capella@mail.it', '2024-02-21 16:22:38', 'che bel vestito', 'fabolouslady@mail.it', '2023-12-12 17:03:56', NULL, NULL, 32),
('laura.capella@mail.it', '2024-02-21 16:23:52', 'Io adoro la pizza', 'chiara.mascetti@mail.it', '2023-11-21 17:03:51', NULL, NULL, 33),
('laura.capella@mail.it', '2024-02-21 16:26:37', 'Dovremmo mangiarla insieme!', 'chiara.mascetti@mail.it', '2023-11-21 17:03:51', NULL, NULL, 34),
('laura.capella@mail.it', '2024-02-21 16:47:53', 'guarda cosa fa mentre studiamo :C', 'fabolouslady@mail.it', '2023-12-12 17:04:09', 'chiara.mascetti@mail.it', '2021-10-11 14:59:19', 35);

-- --------------------------------------------------------

--
-- Struttura della tabella `hobby`
--

CREATE TABLE `hobby` (
  `Tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `hobby`
--

INSERT INTO `hobby` (`Tipo`) VALUES
('Ascoltare Musica'),
('Cucinare'),
('Danza'),
('Giardinaggio'),
('Guardare Serie Tv'),
('Mangiare'),
('Sport');

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggio`
--

CREATE TABLE `messaggio` (
  `UtenteMessaggio` varchar(30) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Tipo` varchar(10) NOT NULL,
  `Contenuto` varchar(100) DEFAULT NULL,
  `Descrizione` varchar(50) DEFAULT NULL,
  `NomeFile` varchar(30) DEFAULT NULL,
  `Posizione` varchar(60) DEFAULT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `messaggio`
--

INSERT INTO `messaggio` (`UtenteMessaggio`, `Data`, `Tipo`, `Contenuto`, `Descrizione`, `NomeFile`, `Posizione`, `ID`) VALUES
('chiara.mascetti@mail.it', '2021-10-11 14:59:19', 'testo', 'Stanca morta, torno a casa a mangiare la pizza.', NULL, NULL, NULL, 1),
('chiara.mascetti@mail.it', '2023-09-28 05:40:07', 'testo', 'Buongiorno!!! :D \r\nColazione al bar super buona, segna l\'inizio di una buona giornata (:', NULL, NULL, NULL, 2),
('chiara.mascetti@mail.it', '2023-11-21 17:03:51', 'testo', 'Oggi ho mangiato un sacco di pizza! (:', NULL, NULL, NULL, 3),
('elisaamaicani@mail.it', '2023-12-12 17:03:21', 'foto', NULL, 'Buon Natale a tutti da Fluffy e me!!', 'elisaamaicani.jpeg', '../images/images_elisaamaicani/elisaamaicani.jpeg', 4),
('elisaamaicani@mail.it', '2023-12-12 17:03:56', 'foto', NULL, 'Bellissima passeggiata con Fluffy e Rufus!', 'elisaamaicani2.jpeg', '../images/images_elisaamaicani/elisaamaicani2.jpeg', 5),
('fabolouslady@mail.it', '2023-12-12 17:03:56', 'foto', NULL, 'anche stasera si beve un botto! ', 'fabolouslady3.jpeg', '../images/images_fabolouslady/fabolouslady3.jpeg', 6),
('fabolouslady@mail.it', '2023-12-12 17:04:04', 'foto', NULL, 'Stasera esco, mi divertirò un sacco B)', 'fabolouslady.jpeg', '../images/images_fabolouslady/fabolouslady.jpeg', 7),
('fabolouslady@mail.it', '2023-12-12 17:04:09', 'foto', NULL, 'Stasera discoteca, si torna all\'alba!!', 'fabolouslady2.jpeg', '../images/images_fabolouslady/fabolouslady2.jpeg', 8),
('ilikechocolate@mail.it', '2021-10-16 07:08:51', 'testo', 'Ciao a tutti, mangiate un po\' di cioccolato, vi renderà felici! (mamma io ne mangio poco)', NULL, NULL, NULL, 9),
('ilikechocolate@mail.it', '2023-12-12 17:04:09', 'foto', NULL, 'Buon San Valentino! Mangiate tanto cioccolato', 'ilikechocolate.jpeg', '../images/images_ilikechocolate/ilikechocolate.jpeg', 10),
('laura.capella@mail.it', '2020-04-15 07:08:21', 'testo', 'Ancora in pandemia, non vedo l\'ora di poter uscire di nuovo :(\r\nResistiamo B)', NULL, NULL, NULL, 11),
('laura.capella@mail.it', '2023-10-21 10:15:41', 'testo', 'Oggi ho mangiato un sacco di pizza! (:', NULL, NULL, NULL, 12),
('laura.capella@mail.it', '2024-01-11 10:50:58', 'foto', NULL, 'cute cat', 'laura.capella29.jpeg', '../images/images_laura.capella/laura.capella29.jpeg', 29),
('laura.capella@mail.it', '2024-02-21 13:21:17', 'foto', NULL, 'night sky', 'laura.capella32.jpeg', '../images/images_laura.capella/laura.capella32.jpeg', 32),
('laura.capella@mail.it', '2024-02-21 14:00:38', 'foto', NULL, 'New journey', 'laura.capella33.jpeg', '../images/images_laura.capella/laura.capella33.jpeg', 33),
('laura.capella@mail.it', '2024-02-21 16:32:27', 'foto', NULL, 'I love nature', 'laura.capella34.jpeg', '../images/images_laura.capella/laura.capella34.jpeg', 34),
('riccardo.rossi@mail.it', '2022-12-31 22:09:09', 'testo', 'Buon anno a tutti, vi auguro tanta felicità!!! (:', NULL, NULL, NULL, 13);

-- --------------------------------------------------------

--
-- Struttura della tabella `possiede`
--

CREATE TABLE `possiede` (
  `HobbyUtente` varchar(30) NOT NULL,
  `TipoHobby` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `possiede`
--

INSERT INTO `possiede` (`HobbyUtente`, `TipoHobby`) VALUES
('agata@mail.it', 'Ascoltare Musica'),
('agata@mail.it', 'Mangiare'),
('caracalla.terme@asdrubale.com', 'Ascoltare Musica'),
('caracalla.terme@asdrubale.com', 'Cucinare'),
('caracalla.terme@asdrubale.com', 'Guardare Serie Tv'),
('caracalla.terme@asdrubale.com', 'Mangiare'),
('chiara.mascetti@mail.it', 'Ascoltare Musica'),
('chiara.mascetti@mail.it', 'Mangiare'),
('chiara.mascetti@mail.it', 'Sport'),
('elisaamaicani@mail.it', 'Giardinaggio'),
('fabolouslady@mail.it', 'Danza'),
('gaia.prussy@mail.it', 'Mangiare'),
('ilikechocolate@mail.it', 'Mangiare'),
('laura.capella@mail.it', 'Ascoltare Musica'),
('laura.capella@mail.it', 'Mangiare'),
('laura.capella@mail.it', 'Sport'),
('riccardo.rossi@mail.it', 'Cucinare');

-- --------------------------------------------------------

--
-- Struttura della tabella `scattata`
--

CREATE TABLE `scattata` (
  `EmailFoto` varchar(30) NOT NULL,
  `DataScatto` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Nome` varchar(20) NOT NULL,
  `Provincia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `scattata`
--

INSERT INTO `scattata` (`EmailFoto`, `DataScatto`, `Nome`, `Provincia`) VALUES
('elisaamaicani@mail.it', '2023-12-12 17:03:21', 'Colverde', 'CO'),
('elisaamaicani@mail.it', '2023-12-12 17:03:56', 'Colverde', 'CO'),
('fabolouslady@mail.it', '2023-12-12 17:03:56', 'Milano', 'MI'),
('fabolouslady@mail.it', '2023-12-12 17:04:04', 'Milano', 'MI'),
('fabolouslady@mail.it', '2023-12-12 17:04:09', 'Milano', 'MI'),
('laura.capella@mail.it', '2024-02-13 23:00:00', 'Milano', 'MI'),
('laura.capella@mail.it', '2024-02-14 16:33:36', 'Milano', 'MI'),
('ilikechocolate@mail.it', '2023-12-12 17:04:09', 'Nembro', 'BG');

-- --------------------------------------------------------

--
-- Struttura della tabella `utente`
--

CREATE TABLE `utente` (
  `Email` varchar(30) NOT NULL,
  `Nome` varchar(20) DEFAULT NULL,
  `Cognome` varchar(20) DEFAULT NULL,
  `Compleanno` date DEFAULT NULL,
  `LuogoDiNascita` varchar(20) DEFAULT NULL,
  `OrientamentoSessuale` enum('gay','binary','trans','etero') DEFAULT NULL,
  `Cellulare` varchar(20) DEFAULT NULL,
  `LivelloDiRispettabilita` decimal(2,0) NOT NULL,
  `Tipo` varchar(20) NOT NULL,
  `NomeCitta` varchar(20) DEFAULT NULL,
  `ProvinciaCitta` varchar(20) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `utente_bloccante` varchar(30) DEFAULT NULL,
  `Stato` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO `utente` (`Email`, `Nome`, `Cognome`, `Compleanno`, `LuogoDiNascita`, `OrientamentoSessuale`, `Cellulare`, `LivelloDiRispettabilita`, `Tipo`, `NomeCitta`, `ProvinciaCitta`, `password`, `utente_bloccante`, `Stato`) VALUES
('agata@mail.it', 'Agata', 'Cavallo', '2001-09-11', 'Milano', 'etero', '3922538118', 5, 'registrato', 'Colverde', 'CO', 'agata', NULL, 'Italia'),
('angelica.milanesi@mail.it', 'Angelica', 'Milanesi', '1993-09-20', NULL, NULL, NULL, 5, 'registrato', 'Genova', 'GE', 'angelica', NULL, 'Italia'),
('badgirl@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 5, 'registrato', 'nessuna', 'nessuna', 'badgirl', NULL, 'nessuna'),
('badguy@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, -2, 'registrato', NULL, NULL, 'badguy', 'laura.capella@mail.it', 'Italia'),
('cape.96@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'cape', NULL, 'nessuna'),
('caracalla.terme@asdrubale.com', 'Caracalla', 'Cavallo', '2023-05-01', 'LaTerraDiMordor', 'etero', '4206969', 5, 'registrato', 'Canicatti', 'GR', 'LetermediCaracalla1!', NULL, 'Italia'),
('chiara.mascetti@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 10, 'amministratore', 'Colverde', 'CO', 'chiara', NULL, 'Italia'),
('cicciobelloìlo@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'ciccio', NULL, 'nessuna'),
('elisaamaicani@mail.it', 'Elisa', NULL, '1999-07-13', 'Bergamo', 'etero', '1122334455', 10, 'registrato', 'Colverde', 'CO', 'elisa', NULL, 'Italia'),
('elisabetta.travelli@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'elisa', NULL, 'nessuna'),
('erminia.martino@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 5, 'registrato', NULL, NULL, 'erminia', NULL, 'Italia'),
('fabolouslady@mail.it', NULL, NULL, NULL, NULL, 'etero', NULL, 5, 'registrato', 'Milano', 'MI', 'fabolous', NULL, 'Italia'),
('federica.spina@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 5, 'registrato', NULL, NULL, 'federica', NULL, 'Italia'),
('gaia.prussy@mail.it', 'Gaia', NULL, '2001-08-30', 'Bergamo', NULL, NULL, 5, 'registrato', 'Bergamo', 'BG', 'gaia', NULL, 'Italia'),
('gloria.campo@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'gloria', NULL, 'nessuna'),
('ilikechocolate@mail.it', 'Carlino', NULL, '2010-12-15', NULL, NULL, NULL, 5, 'registrato', NULL, NULL, 'chocolate', NULL, 'Italia'),
('kathe.balde@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'kathe', NULL, 'nessuna'),
('ku@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 5, 'registrato', NULL, NULL, 'kuku', NULL, 'Italia'),
('laura.capella@mail.it', NULL, NULL, NULL, NULL, NULL, NULL, 10, 'amministratore', 'Milano', 'MI', 'laura', NULL, 'Italia'),
('masha.orso@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'masha', NULL, 'nessuna'),
('piery.toma@mail.it', NULL, NULL, NULL, NULL, '', NULL, 5, 'registrato', 'nessuna', 'nessuna', 'piery', NULL, 'nessuna'),
('riccardo.rossi@mail.it', 'Riccardo', 'Rossi', '1986-05-15', 'Roma', 'gay', '0011223344', 5, 'registrato', NULL, NULL, 'riccardo', NULL, 'Italia');

--
-- Trigger `utente`
--
DELIMITER $$
CREATE TRIGGER `check_livello` BEFORE INSERT ON `utente` FOR EACH ROW BEGIN
  IF NEW.LivelloDiRispettabilita < 1 OR NEW.LivelloDiRispettabilita > 10 THEN
    SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Il valore di LivelloDiRispettabilita deve essere compreso tra 1 e 10';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `vota`
--

CREATE TABLE `vota` (
  `UtenteVotato` varchar(30) NOT NULL,
  `DataVoto` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `UtenteVotante` varchar(30) NOT NULL,
  `DataVotante` timestamp NOT NULL DEFAULT current_timestamp(),
  `Indice` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `vota`
--

INSERT INTO `vota` (`UtenteVotato`, `DataVoto`, `UtenteVotante`, `DataVotante`, `Indice`) VALUES
('badguy@mail.it', '2023-10-19 12:59:35', 'badgirl@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 12:59:35', 'chiara.mascetti@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 12:59:35', 'laura.capella@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 14:25:33', 'chiara.mascetti@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 14:25:33', 'laura.capella@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 14:30:58', 'badgirl@mail.it', '2024-02-10 16:32:01', -3),
('badguy@mail.it', '2023-10-19 14:30:58', 'chiara.mascetti@mail.it', '2024-02-10 16:31:08', -3),
('badguy@mail.it', '2023-10-19 14:30:58', 'laura.capella@mail.it', '2024-02-10 16:31:08', -3),
('chiara.mascetti@mail.it', '2022-02-14 20:00:41', 'ilikechocolate@mail.it', '2024-02-10 16:31:08', 3),
('chiara.mascetti@mail.it', '2022-02-14 20:00:41', 'laura.capella@mail.it', '2024-02-10 16:31:08', 3),
('chiara.mascetti@mail.it', '2023-03-28 18:50:33', 'laura.capella@mail.it', '2024-02-21 09:15:31', 3),
('chiara.mascetti@mail.it', '2023-06-11 22:00:17', 'laura.capella@mail.it', '2024-02-10 16:31:08', 3),
('elisaamaicani@mail.it', '2023-06-12 18:00:00', 'laura.capella@mail.it', '2024-02-10 16:31:08', 3),
('laura.capella@mail.it', '2022-02-14 20:48:21', 'chiara.mascetti@mail.it', '2024-02-10 16:31:08', 3),
('laura.capella@mail.it', '2022-02-14 20:48:21', 'ilikechocolate@mail.it', '2024-02-10 16:31:08', 3),
('laura.capella@mail.it', '2024-02-21 14:58:28', 'laura.capella@mail.it', '2024-02-21 16:16:16', 3),
('laura.capella@mail.it', '2024-02-21 16:23:52', 'laura.capella@mail.it', '2024-02-22 10:07:57', 3),
('laura.capella@mail.it', '2024-02-21 16:26:37', 'laura.capella@mail.it', '2024-02-22 10:07:53', 3);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `amicizia`
--
ALTER TABLE `amicizia`
  ADD PRIMARY KEY (`Mittente`,`Destinatario`),
  ADD KEY `Destinatario` (`Destinatario`),
  ADD KEY `Mittente` (`Mittente`);

--
-- Indici per le tabelle `citta`
--
ALTER TABLE `citta`
  ADD PRIMARY KEY (`Nome`,`Provincia`);

--
-- Indici per le tabelle `commento`
--
ALTER TABLE `commento`
  ADD PRIMARY KEY (`UtenteCommento`,`Data`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `UtenteCommento` (`UtenteCommento`),
  ADD KEY `EmailMessaggio` (`EmailMessaggio`,`DataMessaggio`),
  ADD KEY `commento_ibfk_2` (`popup`,`datapopup`);

--
-- Indici per le tabelle `hobby`
--
ALTER TABLE `hobby`
  ADD PRIMARY KEY (`Tipo`);

--
-- Indici per le tabelle `messaggio`
--
ALTER TABLE `messaggio`
  ADD PRIMARY KEY (`UtenteMessaggio`,`Data`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `EmailMessaggio` (`UtenteMessaggio`);

--
-- Indici per le tabelle `possiede`
--
ALTER TABLE `possiede`
  ADD PRIMARY KEY (`HobbyUtente`,`TipoHobby`),
  ADD KEY `TipoHobby` (`TipoHobby`),
  ADD KEY `HobbyUtente` (`HobbyUtente`,`TipoHobby`);

--
-- Indici per le tabelle `scattata`
--
ALTER TABLE `scattata`
  ADD PRIMARY KEY (`EmailFoto`,`DataScatto`),
  ADD KEY `EmailFoto` (`EmailFoto`,`DataScatto`),
  ADD KEY `Nome` (`Nome`,`Provincia`);

--
-- Indici per le tabelle `utente`
--
ALTER TABLE `utente`
  ADD PRIMARY KEY (`Email`),
  ADD KEY `LivelloDiRispettabilita` (`LivelloDiRispettabilita`),
  ADD KEY `utente_bloccante` (`utente_bloccante`);

--
-- Indici per le tabelle `vota`
--
ALTER TABLE `vota`
  ADD PRIMARY KEY (`UtenteVotato`,`DataVoto`,`UtenteVotante`),
  ADD KEY `UtenteVotato` (`UtenteVotato`,`DataVoto`),
  ADD KEY `vota_ibfk_2` (`UtenteVotante`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `commento`
--
ALTER TABLE `commento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `amicizia`
--
ALTER TABLE `amicizia`
  ADD CONSTRAINT `amicizia_ibfk_1` FOREIGN KEY (`Destinatario`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `amicizia_ibfk_2` FOREIGN KEY (`Mittente`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `commento`
--
ALTER TABLE `commento`
  ADD CONSTRAINT `commento_ibfk_1` FOREIGN KEY (`UtenteCommento`) REFERENCES `utente` (`Email`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `commento_ibfk_2` FOREIGN KEY (`popup`,`datapopup`) REFERENCES `messaggio` (`UtenteMessaggio`, `Data`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `commento_ibfk_3` FOREIGN KEY (`EmailMessaggio`,`DataMessaggio`) REFERENCES `messaggio` (`UtenteMessaggio`, `Data`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `messaggio`
--
ALTER TABLE `messaggio`
  ADD CONSTRAINT `messaggio_ibfk_1` FOREIGN KEY (`UtenteMessaggio`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Limiti per la tabella `possiede`
--
ALTER TABLE `possiede`
  ADD CONSTRAINT `possiede_ibfk_1` FOREIGN KEY (`HobbyUtente`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `possiede_ibfk_2` FOREIGN KEY (`TipoHobby`) REFERENCES `hobby` (`Tipo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `scattata`
--
ALTER TABLE `scattata`
  ADD CONSTRAINT `scattata_ibfk_2` FOREIGN KEY (`Nome`,`Provincia`) REFERENCES `citta` (`Nome`, `Provincia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `utente`
--
ALTER TABLE `utente`
  ADD CONSTRAINT `utente_ibfk_1` FOREIGN KEY (`utente_bloccante`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limiti per la tabella `vota`
--
ALTER TABLE `vota`
  ADD CONSTRAINT `vota_ibfk_2` FOREIGN KEY (`UtenteVotante`) REFERENCES `utente` (`Email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vota_ibfk_3` FOREIGN KEY (`UtenteVotato`,`DataVoto`) REFERENCES `commento` (`UtenteCommento`, `Data`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
