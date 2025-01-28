-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2025 at 04:01 PM
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
-- Database: `ddu_clerance`
--

-- --------------------------------------------------------

--
-- Table structure for table `clearedstudentslist`
--

CREATE TABLE `clearedstudentslist` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `full_Name` varchar(255) NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clearedstudentslist`
--

INSERT INTO `clearedstudentslist` (`id`, `student_id`, `full_Name`, `is_completed`) VALUES
(0, 'ddu1402311', 'Biniyam ayele wondosen', 1),
(0, 'DDU1403261', 'Meron Getachew Abebe', 1),
(0, 'ddu1402312', 'Mikael Biruk Asfaw', 1),
(0, 'ddu1402349', 'Zara Musa Khalil', 1),
(0, 'ddu1402342', 'Fatima Mariam Zeyad', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ddustudentdata`
--

CREATE TABLE `ddustudentdata` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `father_name` varchar(255) NOT NULL,
  `gfather_name` varchar(255) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `enrolment_date` date NOT NULL,
  `year` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `marital_status` enum('single','married','divorced','widowed') NOT NULL,
  `nationality` enum('ethiopian','other') NOT NULL,
  `school` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `amharic_first_name` varchar(255) NOT NULL,
  `amharic_middle_name` varchar(255) NOT NULL,
  `amharic_last_name` varchar(255) NOT NULL,
  `mother_first_name` varchar(255) NOT NULL,
  `mother_last_name` varchar(255) NOT NULL,
  `father_occupation` varchar(255) NOT NULL,
  `mother_occupation` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `dob2` date NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `religion` enum('muslim','christian','other') NOT NULL,
  `ethnic` enum('oromo','amhara','tigray','other') NOT NULL,
  `photo` longblob DEFAULT NULL,
  `Student_Legistlation_Type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ddustudentdata`
--

INSERT INTO `ddustudentdata` (`id`, `student_id`, `first_name`, `father_name`, `gfather_name`, `gender`, `enrolment_date`, `year`, `semester`, `marital_status`, `nationality`, `school`, `department`, `amharic_first_name`, `amharic_middle_name`, `amharic_last_name`, `mother_first_name`, `mother_last_name`, `father_occupation`, `mother_occupation`, `email`, `phone_number`, `dob2`, `birth_place`, `religion`, `ethnic`, `photo`, `Student_Legistlation_Type`) VALUES
(13, 'DDU1403261', 'Me', 'Getachew', 'Abebe', 'female', '2021-01-06', 3, 2, '', 'other', 'Electrical and computer engineering', 'Electrical and computer engineering', 'meron', 'getachew', 'abebe', 'melat', 'wereku', 'accountant', 'manager', 'meri@gmail.com', '0704122856', '2009-12-17', 'Adama', 'other', 'amhara', NULL, 'Harmonized Modular'),
(14, 'DDU1402311', 'Samuel', 'Zewdu', 'Mulu', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'School of Computing', 'Accounting and Finance', 'ሉኤል', 'ሐይሉ', 'ተስፋዬ', 'alem', 'sisay', 'POLICE', 'house wife', 'luel@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(15, 'DDU1402311', 'Samuel', 'Zewdu', 'Mulu', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Accounting and Finance', 'ሳሙኤል', 'ዝድድ', 'ሙሉ', 'alem', 'sisay', 'POLICE', 'house wife', 'samuel@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(16, 'ddu1402312', 'Mikael', 'Biruk', 'Asfaw', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Banking and Finance', 'ሚካኤል', 'ብሩክ', 'አስፋው', 'alem', 'sisay', 'POLICE', 'house wife', 'mikael@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(19, 'ddu1402315', 'Mulugeta', 'Abeje', 'Hagos', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Marketing Management', 'ሙሉጌታ', 'አቤጅ', 'ሐጎስ', 'alem', 'sisay', 'POLICE', 'house wife', 'mulugeta@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(20, 'ddu1402316', 'Kebede', 'Meles', 'Asher', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Public Administration and Development Management', 'ከበደ', 'መለስ', 'አሸር', 'alem', 'sisay', 'POLICE', 'house wife', 'kebede@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(21, 'ddu1402317', 'Abel', 'Teshome', 'Yared', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Land and Real Property Valuation', 'አበል', 'ተሾም', 'ያረድ', 'alem', 'sisay', 'POLICE', 'house wife', 'abel@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(22, 'ddu1402318', 'Daniel', 'Biruk', 'Kassa', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Business and Economics', 'Business Administration', 'ዳንኤል', 'ብሩክ', 'ካሳ', 'alem', 'sisay', 'POLICE', 'house wife', 'daniel@gmail.com', '0915234322', '2007-01-31', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(23, 'ddu1402319', 'Ethan', 'Morris', 'Andersen', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Mathematics', 'Mathematics', 'ኢትሰን', 'ሞሪስ', 'አንደርሰን', 'ben', 'bethel', 'POLICE', 'house wife', 'ethan@gmail.com', '0915234339', '2008-05-10', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(39, 'ddu1402335', 'Mia', 'Allen', 'Young', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Statistics', 'Statistics', 'ሚያ', 'አሌን', 'ዮንግ', 'benyam', 'bethel', 'POLICE', 'house wife', 'mia@gmail.com', '0915234340', '2008-06-15', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(40, 'ddu1402336', 'Jacob', 'Hernandez', 'King', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Sport Science', 'Sport Science', 'ጄኮብ', 'ሐርናንዳዝ', 'ኪንግ', 'mihret', 'teddy', 'POLICE', 'house wife', 'jacob@gmail.com', '0915234341', '2008-07-15', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(41, 'ddu1402337', 'Mia', 'Allen', 'Young', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Statistics', 'Statistics', 'ሚያ', 'አሌን', 'ዮንግ', 'benyam', 'bethel', 'POLICE', 'house wife', 'mia@gmail.com', '0915234342', '2008-08-25', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(42, 'ddu1402338', 'Jacob', 'Hernandez', 'King', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Sport Science', 'Sport Science', 'ጄኮብ', 'ሐርናንዳዝ', 'ኪንግ', 'mihret', 'teddy', 'POLICE', 'house wife', 'jacob@gmail.com', '0915234343', '2008-09-30', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(43, 'ddu1402339', 'Elias', 'Ibrahim', 'Abdul', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'AfSomali and Literature', 'AfSomali and Literature', 'ኢላይስ', 'ኢብራሂም', 'አብዱል', 'abiy', 'alem', 'POLICE', 'house wife', 'elias@gmail.com', '0915234344', '2008-10-10', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(44, 'ddu1402340', 'Hana', 'Nuri', 'Tesfaye', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Afan Oromo and Literature', 'Afan Oromo and Literature', 'ሃና', 'ኑሪ', 'ተስፋዬ', 'seblewongel', 'yohannes', 'POLICE', 'house wife', 'hana@gmail.com', '0915234345', '2008-11-05', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(45, 'ddu1402341', 'Moses', 'Ketema', 'Belay', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Amharic Language and Literature', 'Amharic Language and Literature', 'ሞሴስ', 'ከተማ', 'በላይ', 'tadesse', 'yohannes', 'POLICE', 'house wife', 'moses@gmail.com', '0915234346', '2008-12-20', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(46, 'ddu1402342', 'Fatima', 'Mariam', 'Zeyad', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'English Language and Literature', 'English Language and Literature', 'ፋቲማ', 'ማሪያም', 'ዛያድ', 'nuru', 'biruk', 'POLICE', 'house wife', 'fatima@gmail.com', '0915234347', '2009-01-15', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(47, 'ddu1402343', 'Daniel', 'Ahmed', 'Abdallah', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Journalism and Communication', 'Journalism and Communication', 'ዳንኤል', 'አህመድ', 'አብዳላህ', 'abraham', 'sara', 'POLICE', 'house wife', 'daniel@gmail.com', '0915234348', '2009-02-25', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(48, 'ddu1402344', 'Ayesha', 'Ibrahim', 'Suleiman', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Geography and Environmental Studies', 'Geography and Environmental Studies', 'አይሸን', 'ኢብራህም', 'ሱሌማን', 'halima', 'amin', 'POLICE', 'house wife', 'ayesha@gmail.com', '0915234349', '2009-03-15', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(49, 'ddu1402345', 'Omer', 'Mohammed', 'Fareed', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'History and Heritage Management', 'History and Heritage Management', 'ኦመር', 'ሞሐመድ', 'ፋሪድ', 'faris', 'helen', 'POLICE', 'house wife', 'omer@gmail.com', '0915234350', '2009-04-20', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(50, 'ddu1402346', 'Layla', 'Mohammed', 'Ibrahim', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Sociology and Social Anthropology', 'Sociology and Social Anthropology', 'ላይላ', 'ሞሐመድ', 'ኢብራህም', 'seif', 'leila', 'POLICE', 'house wife', 'layla@gmail.com', '0915234351', '2009-05-25', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(51, 'ddu1402347', 'Adam', 'Yusuf', 'Khalid', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Political Science', 'Political Science', 'አዳም', 'ዩሱፍ', 'ክላሊድ', 'nashit', 'dina', 'POLICE', 'house wife', 'adam@gmail.com', '0915234352', '2009-06-15', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(52, 'ddu1402348', 'Sarah', 'Mohammed', 'Faisal', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Economics', 'Economics', 'ሳራ', 'ሞሐመድ', 'ፋይሳል', 'nashit', 'dina', 'POLICE', 'house wife', 'sarah@gmail.com', '0915234353', '2009-07-20', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(53, 'ddu1402349', 'Zara', 'Musa', 'Khalil', 'female', '2023-01-06', 2, 2, '', 'ethiopian', 'Art and Design', 'Art and Design', 'ዛራ', 'ሙሳ', 'ካሊል', 'ibrahim', 'selam', 'POLICE', 'house wife', 'zara@gmail.com', '0915234354', '2009-08-20', 'jima', 'other', 'other', NULL, 'Harmonized Modular'),
(54, 'ddu1402350', 'Ali', 'Hussein', 'Mohamed', 'male', '2023-01-06', 2, 2, '', 'ethiopian', 'Law', 'Law', 'አሊ', 'ሁሴን', 'ሞሐመድ', 'ibrahim', 'selam', 'POLICE', 'house wife', 'ali@gmail.com', '0915234355', '2009-09-10', 'jima', 'other', 'other', NULL, 'Harmonized Modular');

-- --------------------------------------------------------

--
-- Table structure for table `ddu_admin`
--

CREATE TABLE `ddu_admin` (
  `id` int(10) NOT NULL,
  `fName` varchar(64) NOT NULL,
  `mName` varchar(64) NOT NULL,
  `lName` varchar(64) NOT NULL,
  `role` varchar(64) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ddu_admin`
--

INSERT INTO `ddu_admin` (`id`, `fName`, `mName`, `lName`, `role`, `phone`, `email`, `password`) VALUES
(1, 'admin', 'admin', 'ADMIN', 'admin', '0785858585', 'admin@email.com', '$2y$10$FcmtqgrMkzyWYpPWG7YXEOypZgAuyrcvakwdCEjaETaH8v.r79Rsm');

-- --------------------------------------------------------

--
-- Table structure for table `ddu_staff`
--

CREATE TABLE `ddu_staff` (
  `staff_id` int(10) NOT NULL,
  `fName` varchar(64) NOT NULL,
  `mName` varchar(64) NOT NULL,
  `lName` varchar(64) NOT NULL,
  `staff` varchar(64) NOT NULL,
  `schoolName` varchar(64) DEFAULT NULL,
  `position` varchar(64) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ddu_staff`
--

INSERT INTO `ddu_staff` (`staff_id`, `fName`, `mName`, `lName`, `staff`, `schoolName`, `position`, `phone`, `email`, `password`, `date`) VALUES
(17, 'SARA', 'YOHANESS', 'GEBRE', 'StudentLoan', NULL, 'officer', '0942689385', 'sara@gmail.com', '$2y$10$AFpK6Vx2cSe7.OIvCfX5ce6n6gjFWyDv6cIcHbTuHbL7pt7n6lQSS', '2024-08-05'),
(18, 'ABEBA', 'MESFIN', 'TESFAYE', 'Dormitory', NULL, 'officer', '0942689385', 'abeb@gmail.com', '$2y$10$iorMVg4hoPq7KLOVOxyPLu2rZzRSroLIzoovQDlx2vbnmdbjgZquC', '2024-08-05'),
(19, 'GEZE', 'GETACHEW', 'TESFAYE', 'StudentService', NULL, 'officer', '0942689385', 'geze@gmail.com', '$2y$10$DDschiA7XvqV/QwJ72to..cKUseOuctUVmvyXgwWzEac90UWbwXaS', '2024-08-05'),
(20, 'KB', 'YOHANES', 'GEBRE', 'Store', NULL, 'officer', '0942689385', 'kb@gmail.com', '$2y$10$.9z681axS5UmVrRILh2zwu5Kc3Ma.B4H0sEgDXiXOVv6LyH./8/ti', '2024-08-05'),
(21, 'BUTA', 'GEZE', 'GETACHEW', 'AcademicEnrollment', NULL, 'officer', '0942689385', 'bu@gmail.com', '$2y$10$pzqxnXQMqwoK3laV27OEdOwOXf8JMfj9wy6ARN05hdXl6oy2MEPYG', '2024-08-05'),
(23, 'ANA', 'GETACHEW', 'TESFAYE', 'SchoolDean', 'Electrical and computer engineering', 'advisor', '0942689385', 'da@gmail.com', '$2y$10$JANQaFLCV0.E9zEmWmH7hejsNuFy7C1i5aTa19CvI9KGcJ4Uj48wi', '2024-08-05'),
(24, 'FF', 'MM', 'LL', 'SchoolDean', 'School of Chemical and BioEngineering', 'admin', '0942689385', '11@gmail.com', '$2y$10$29.3nGc63jcRvquAdLn6ie4DHGiqWR6tzV7xKJe7/ZBxfZ6yrjhEm', '2024-08-11'),
(25, 'FM', 'FM', 'FM', 'SchoolDean', 'School of Textile and Fashion Design', 'admin', '0942689385', '22@gmail.com', '$2y$10$StlqYe/5KQDda4U73iMBru4nOG9NhtQLxA93NZkbGAP9d2GCR1BjS', '2024-08-11'),
(26, 'LM', 'LM', 'LM', 'SchoolDean', 'School of Civil Eng and Architecture', 'admin', '0942689385', '33@gmail.com', '$2y$10$ftBB2RlW3rgQJBkqI8HZkuRD70UMpWBf.kGVCV.4PIgR8h.i0.r52', '2024-08-11'),
(27, 'DM', 'DM', 'DM', 'SchoolDean', 'School of Mechanical and Industrial Engineering', 'officer', '0942689385', '44@gmail.com', '$2y$10$YIqRVFK3RmH4mQoeZe13W.dOIAFXQQoXH14DVrPyOa.4NRNTvD49O', '2024-08-11'),
(28, 'SS', 'SS', 'SS', 'SchoolDean', 'School of Computing', 'officer', '0942689385', '55@gmail.com', '$2y$10$OvjVbCZeyD51Y/YrNMesFeb5mpeWiA5Pz1abE/tBAqRCpF3.CS6AC', '2024-08-11'),
(29, 'PP', 'PP', 'PP', 'SchoolDean', 'College of Medicine and health science', 'officer', '0942689385', '66@gmail.com', '63a9f0ea7bb98050796b649e85481845', '2024-08-11'),
(30, 'QQ', 'QQ', 'QQ', 'SchoolDean', 'College of Law', 'officer', '0942689385', '77@gmail.com', '$2y$10$te9XaHcFx7gwvKOgzQ7F3eYTkgkKABhzRxyK.2zCXes1gtDxWsWgi', '2024-08-11'),
(31, 'RRR', 'RR', 'RR', 'SchoolDean', 'College of Natural and Computational Science', 'officer', '0942689385', '88@gmail.com', '$2y$10$SBwJ4bCaPDxeXrwiXTdusOqajCUXJ/aVrziBucOUXYm76blSscZE.', '2024-08-11'),
(32, 'VV', 'VV', 'VV', 'SchoolDean', 'College of Social Science and Humanity', 'officer', '0942689385', '99@gmail.com', '$2y$10$LuEdg4F5fwZk0FHrOIiZSe/WlRdVsXw7L8krbZ0Y2GVZJRNmHZK3e', '2024-08-11'),
(33, 'CAFE', 'CAFE', 'CAFE', 'Cafeteria', NULL, 'officer', '0942689385', 'cafe@gmail.com', '$2y$10$VPOVjIsm2Ck5YXCfD5vM3OP/Plz9/VWUlvL2EAdM9azIDvqAhUMzC', '2024-08-15'),
(38, 'DSDSD', 'SSD', 'DSS', 'BookStore', NULL, 'admin', '0942689385', 'anaii@gmail.com', '$2y$10$HOWPBE2aUtZpfZIzNI0qTuQnjsMQnyVNdtyOFTjtiNFQEccerr1yy', '2024-08-22'),
(50, 'KLKL', 'KLKLL', 'KLKKL', 'Library', '', 'officer', '0942689385', 'kl@gmail.com', '$2y$10$wssRgW2WjNFry0YJgDUZQO12DUZtXRAMPmS4qhdeHuJcE7xtYDZwW', '2024-09-02'),
(51, 'SLSLSL', 'SLSLSLS', 'SLSLS', 'SchoolDean', 'Business and Economics', 'officer', '0942689385', 'sl@gmail.com', '$2y$10$0Qpoak9Cyjybnpx.V8r4d.uH9vBZ5s7IvucmLgEpb7YUui51Rvsaq', '2024-09-02'),
(52, 'ABEBE', 'JEMAL', 'KEBED', 'Registrar', '', 'instructor', '0942689385', 'abebejemal@email.com', '$2y$10$Ngkd.fbsUykuv4g4.SCjBOjJ4EMsHvrUqYMz6Hpabhi5fGUshFrfi', '2024-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `ddu_substaff`
--

CREATE TABLE `ddu_substaff` (
  `subStaff_id` int(11) NOT NULL,
  `fName` varchar(64) NOT NULL,
  `mName` varchar(64) NOT NULL,
  `lName` varchar(64) NOT NULL,
  `collegeName` varchar(64) DEFAULT NULL,
  `department` varchar(64) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `staff` varchar(64) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ddu_substaff`
--

INSERT INTO `ddu_substaff` (`subStaff_id`, `fName`, `mName`, `lName`, `collegeName`, `department`, `year`, `semester`, `staff`, `phone`, `email`, `password`, `date`) VALUES
(46, 'CCC', 'CCC', 'CCC', 'Business and Economics', 'Marketing Management', NULL, NULL, 'DepartmentHead', '0942689385', 'ccc@gmail.com', '$2y$10$aoMSonmFcFRGFcvOOIpBAuwp7sD1K0CLjQRQB1WHlGcWc9.rCiLeS', '2024-08-12'),
(47, 'DDD', 'DDD', 'DDD', 'Business and Economics', 'Banking and Finance', NULL, NULL, 'DepartmentHead', '0942689385', 'ddd@gmail.com', '$2y$10$x54OYYr2WJe2jaJHXta8guKR.xkObFdgE1RYZ8xnW9HhfTkVjxyPC', '2024-08-12'),
(48, 'EEE', 'EEE', 'EEE', 'Business and Economics', 'Public Administration and Development Management', NULL, NULL, 'DepartmentHead', '0942689385', 'eee@gmail.com', '$2y$10$ugCQIiw3xpV1qdl1ISrdW.uF15vQAN8HYIDm3ZUen6E874ORx0Q8K', '2024-08-12'),
(49, 'FFF', 'FFF', 'FFF', 'Business and Economics', 'Economics', NULL, NULL, 'DepartmentHead', '0942689385', 'fff@gmail.com', '$2y$10$lmgxEqS6gq9WSMmsGDhhyuV0412cFBwpTMLIVnneZptDho2vkdgSy', '2024-08-12'),
(50, 'GGG', 'GGG', 'GGG', 'Business and Economics', 'Land and Real Property Valuation', NULL, NULL, 'DepartmentHead', '0942689385', 'ggg@gmail.com', '$2y$10$g2c1nebP0rW1Lw9QAdz8uOPQU1XbTzpgKCPzgPPtA.C3hP3Dk6G3u', '2024-08-12'),
(51, 'HHH', 'HHH', 'HHH', 'Electrical and computer engineering', 'Electrical and computer engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'hhh@gmail.com', '$2y$10$HRFiQin/I1KzMAjcVZ4EZ.lwdRXz2b0tFfhW/xDvFcxhbB97k.pRa', '2024-08-12'),
(52, 'III', 'III', 'III', 'School of Chemical and BioEngineering', 'Food Processing engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'iii@gmail.com', '$2y$10$1grRFVnL.0vAWPVUEn1IkuR9Dq49hKHt6W2ULnc5xdMSRmHmkD8Pu', '2024-08-12'),
(53, 'JJJ', 'JJJ', 'JJJ', 'School of Chemical and BioEngineering', 'Chemical engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'jjj@gmail.com', '$2y$10$R8QAJjJ1F/6vVHzpcfWeguSnys5XCo53a/aqyAfUCSzN16wM07T0O', '2024-08-12'),
(54, 'KKK', 'KKK', 'KKK', 'School of Textile and Fashion Design', 'Textile engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'kkk@gmail.com', '$2y$10$ekXKoDPeQMLwXI4W9LuFRuQ/iMqLExj8XZmnqwMpbAimT772kk5ou', '2024-08-12'),
(55, 'LLL', 'LLL', 'LLL', 'School of Textile and Fashion Design', 'Apparel and fashion design', NULL, NULL, 'DepartmentHead', '0942689385', 'lll@gmail.com', '$2y$10$HwYdmB4Y.A7VnAuUh5x7L.c.XpmhHdpXdrsAz.Tt3kjIMO.xLUBfS', '2024-08-12'),
(56, 'MMM', 'MMM', 'MMM', 'School of Civil Eng and Architecture', 'Architecture', NULL, NULL, 'DepartmentHead', '0942689385', 'mmm@gmail.com', '$2y$10$HobSrSgQ4L60ujWu6HIYy.IqSfm8zWjOg9DV9XJuafEc/zid6eO.e', '2024-08-12'),
(57, 'NNN', 'NNN', 'NNN', 'School of Civil Eng and Architecture', 'Civil engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'nnn@gmail.com', '$2y$10$mGp8dVReHze8k3q/iRoB0u72NXhKIBNST08ixa3N6aoDV7UWcWyP6', '2024-08-12'),
(58, 'OOO', 'OOO', 'OOO', 'School of Civil Eng and Architecture', 'Construction technology and management', NULL, NULL, 'DepartmentHead', '0942689385', 'ooo@gmail.com', '$2y$10$S8Ij/K3J1qlxs8/b2o9M/uGmdVw/gca7QhNWf0.woIv2SD.GMCo26', '2024-08-12'),
(59, 'PPP', 'PPP', 'PPP', 'School of Civil Eng and Architecture', 'Surveying engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'ppp@gmail.com', '$2y$10$xG0.hDYsxmp5x5V1UwYq2eLFdR0LfbOC84TBQGqHCG8DSshsIeOA.', '2024-08-12'),
(60, 'QQQ', 'QQQ', 'QQQ', 'School of Mechanical and Industrial Engineering', 'Industrial engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'qqq@gmail.com', '$2y$10$6gG.NV/72Nzw.yi0oxvmyOBLiTo.JmatYNlH8ywj6omHCmrG8dlYK', '2024-08-12'),
(61, 'RRR', 'RRR', 'RRR', 'School of Mechanical and Industrial Engineering', 'Mechanical engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'rrr@gmail.com', '$2y$10$OOQ0WS9nw6jebDofsXcbcebWm8SO4Gr51ibzWb/.G8.dL4EebWzHa', '2024-08-12'),
(62, 'SSS', 'SSS', 'SSS', 'School of Computing', 'Software Engineering', NULL, NULL, 'DepartmentHead', '0942689385', 'sss@gmail.com', '$2y$10$hopqIDB0fyn9hS2h9QTfX.CXYSvIVQOAz9oox.eOQZWkBMq2eStvi', '2024-08-12'),
(63, 'TTT', 'TTT', 'TTT', 'School of Computing', 'Information technology', NULL, NULL, 'DepartmentHead', '0942689385', 'ttt@gmail.com', '$2y$10$t4QNIuJR89Addx9sRQLkQun4838ggdtvZCIy2uDd7DMKbfNVhlabS', '2024-08-12'),
(64, 'UUU', 'UUU', 'UUU', 'School of Computing', 'Computer Science', NULL, NULL, 'DepartmentHead', '0942689385', 'uuu@gmail.com', '$2y$10$pG1uy9plvovOn5ddgaFgj.6.rlYm7bejbbLQsAVx3iswG/GO1fRCe', '2024-08-12'),
(69, 'ZZZ', 'ZZZ', 'ZZZ', 'College of medicine and health science', 'Psychiatry', NULL, NULL, 'DepartmentHead', '0942689385', 'zzz@gmail.com', '$2y$10$QKWSjacX8X/HwcESuJP7MOXG9s78p.WHWka7k3WKGdvSYOuDZZxeC', '2024-08-12'),
(72, 'AAAA', 'AAAA', 'AAAA', 'College of medicine and health science', 'Public Health', NULL, NULL, 'DepartmentHead', '0942689385', 'aaaa@gmail.com', '$2y$10$p9FFFCV1vJbvJO4OVsk6.OpIw8bT/uGJsr4ParUlU4lIkcJD0SmAe', '2024-08-12'),
(73, 'BBBB', 'BBBB', 'BBBB', 'College of Law', 'Law', NULL, NULL, 'DepartmentHead', '0942689385', 'bbbb@gmail.com', '$2y$10$tewoO6HaMFJWFtiLP35Wq.fKNeAjuInv3VKAt.Fegq2KJbOheY80.', '2024-08-12'),
(74, 'CCCC', 'CCCC', 'CCCC', 'College of Natural and Computational Science', 'Biology', NULL, NULL, 'DepartmentHead', '0942689385', 'cccc@gmail.com', '$2y$10$UTw2657xteI2Ki80lwxlkOYeXvR4pzSWTVeJamTC3BYYR6b6QjrHC', '2024-08-12'),
(75, 'DDDD', 'DDDD', 'DDD', 'College of Natural and Computational Science', 'Chemistry', NULL, NULL, 'DepartmentHead', '0942689385', 'dddd@gmail.com', '$2y$10$zeKp27uACJJB/mtWhGKPs.5Ov7eMgFNH6Tmlw6P8WnUT7z8l2PCQK', '2024-08-12'),
(76, 'EEEE', 'EEEE', 'EEEE', 'College of Natural and Computational Science', 'Geology', NULL, NULL, 'DepartmentHead', '0942689385', 'eeee@gmail.com', '$2y$10$IT7K9Oa8VfcnQZXOMXOGBeb2wGFcg0Nk7P4Gap0V2cpIks4S0TH.i', '2024-08-12'),
(77, 'FFFF', 'FFFF', 'FFFF', 'College of Natural and Computational Science', 'Physics', NULL, NULL, 'DepartmentHead', '0942689385', 'ffff@gmail.com', '$2y$10$6Nt86Jb/LZqT181MPfZ3jeTaCDDQB6m7xbphLj2qzOAA/fwH1vphK', '2024-08-12'),
(78, 'GGGG', 'GGGG', 'GGGG', 'College of Natural and Computational Science', 'Mathematics', NULL, NULL, 'DepartmentHead', '0942689385', 'gggg@gmail.com', '$2y$10$hnGhg7ehwzOnwKM9m0gf1uwEqTZZkGUq.Jint/5o60B0bpRmmjsEq', '2024-08-12'),
(79, 'HHHH', 'HHHH', 'HHHH', 'College of Natural and Computational Science', 'Statistics', NULL, NULL, 'DepartmentHead', '0942689385', 'hhhh@gmail.com', '$2y$10$mb8A5xqzOfVoEc.3q3bTSe2W1XuAZFtslkx2AkQMJ/EujvCWm9HDO', '2024-08-12'),
(80, 'IIII', 'IIII', 'IIII', 'College of Natural and Computational Science', 'Sport Science', NULL, NULL, 'DepartmentHead', '0942689385', 'iiii@gmail.com', '$2y$10$yJbNkf6DNds08FyOJZKOCOWNtTEFs0wbXN7vjd.L7u/98NOfSOcFG', '2024-08-12'),
(81, 'JJJJ', 'JJJJ', 'JJJJ', 'College of Social Science and Humanity', 'AfSomali and Literature', NULL, NULL, 'DepartmentHead', '0942689385', 'jjjj@gmail.com', '$2y$10$Js32bpfHjZlETT8JRdddbOscOl9aSrWWpxO8f37wCEFcyo5DmfM5W', '2024-08-12'),
(82, 'KKKK', 'KKKK', 'KKKK', 'College of Social Science and Humanity', 'AfanOromo and Literature', NULL, NULL, 'DepartmentHead', '0942689385', 'kkkk@gmail.com', '$2y$10$336Kfm9O2PfilbTRHFCzI..eq5iqrpKsEctWg7ji6PRZSlJ5aM3mG', '2024-08-12'),
(83, 'LLLL', 'LLLL', 'LLLL', 'College of Social Science and Humanity', 'Amharic Language and Literature', NULL, NULL, 'DepartmentHead', '0942689385', 'llll@gmail.com', '$2y$10$9JBq9Uz85LnucHnrj3X7wO9xKcwSEV4VGMXMNLpvgOoItbJSnYaHa', '2024-08-12'),
(84, 'MMMM', 'MMMM', 'MMMM', 'College of Social Science and Humanity', 'English Language and Literature', NULL, NULL, 'DepartmentHead', '0942689385', 'mmmm@gmail.com', '$2y$10$OZZ2whbr/ue74yApZFglP.c/TM0LU1kXeMiFe8SNP7WrA8WSH1oXu', '2024-08-12'),
(85, 'NNNN', 'NNNN', 'NNNN', 'College of Social Science and Humanity', 'Journalism and Communication', NULL, NULL, 'DepartmentHead', '0942689385', 'nnnn@gmail.com', '$2y$10$pQz98hZ9/ZC67IXC23REfeqxk/01T4gjDSejuQqK4/i3cyqvAJiHu', '2024-08-12'),
(86, 'OOOO', 'OOOO', 'OOOO', 'College of Social Science and Humanity', 'Geography and Enviromental Studies', NULL, NULL, 'DepartmentHead', '0942689385', 'oooo@gmail.com', '$2y$10$TMjt5Q97gmGdpnCjTrgOku2inYWrHQLiPR0KJHWGeyOlPSfzCaYJO', '2024-08-12'),
(87, 'PPPP', 'PPPP', 'PPPP', 'College of Social Science and Humanity', 'History and Heritage Management', NULL, NULL, 'DepartmentHead', '0942689385', 'pppp@gmail.com', '$2y$10$HxcDr02VWou13514QBBNhOb3Neourw8yoxU8DqvfmurFEqsj/Gkau', '2024-08-12'),
(88, 'QQQQ', 'QQQQ', 'QQQQ', 'College of Social Science and Humanity', 'Sociology and Social Anthropology', NULL, NULL, 'DepartmentHead', '0942689385', 'qqqq@gmail.com', '$2y$10$oMfWobtsJlj0Z6qw.heDhuCcRNj.W0K/7xjQ0vYcudOE2tH/63DDq', '2024-08-12'),
(89, 'RRRR', 'RRRR', 'RRRR', 'College of Social Science and Humanity', 'Political Science and International Relation', NULL, NULL, 'DepartmentHead', '0942689385', 'rrrr@gmail.com', '$2y$10$9k8MONfcQ7TquJhojkIAyusBqKdwbOH0uqt9kdVGuMyZ2vyDcxU02', '2024-08-12'),
(90, 'SSSS', 'SSSS', 'SSSS', 'College of Social Science and Humanity', 'Civics and Ethical Studies', NULL, NULL, 'DepartmentHead', '0942689385', 'ssss@gmail.com', '$2y$10$xnAOYhq4xQTHkkaVlgVuaOAt1/8AmKo4Rp4tOLq07ZXG1cs459V6i', '2024-08-12'),
(91, 'TTTT', 'TTTT', 'TTTT', 'College of Social Science and Humanity', 'Psychology', NULL, NULL, 'DepartmentHead', '0942689385', 'tttt@gmail.com', '$2y$10$QH1S5nV/LHoXNsfoO4KfgeymSS0Nb1M8tGWHcNTIhxKG8nGJZCtyC', '2024-08-12'),
(100, 'FF', 'FF', 'FF', 'Business and Economics', 'Management', NULL, NULL, 'DepartmentHead', '0942689385', 'ff@gmail.com', '$2y$10$wBqVzm7lj2l4jDQoj8FfQukctV9tAvKbSluCVRhrMCkhLTMd61Im2', '2024-08-22'),
(108, 'DHJDDS', 'ASASAS', 'CBNZ', 'College of Medicine and health science', 'Anesthesia', NULL, NULL, 'DepartmentHead', '0942689385', 'FDFD@gmail.com', '$2y$10$NgSls.aErYNh8nis4hCrleBGDMP9HMoKLhYYPdzQHEw/FGxZCxW9G', '2024-09-02'),
(112, 'JHDJJS', 'SDSSD', 'DSSD', 'Business and Economics', 'Management', 1, 2, 'Advisor', '0942689385', 'ana@gmail.com', '63a9f0ea7bb98050796b649e85481845', '2024-09-02'),
(116, 'DCSD', 'DDC', 'DC', 'Business and Economics', 'Accounting and Finance', NULL, NULL, 'DepartmentHead', '0942689385', 'DC@gmail.com', '$2y$10$WRKQls2odhTlseSZVBxgJOvlobP3ep6G6rXX4J4yCYpGAlvEvAVO.', '2024-09-02'),
(117, 'CDCD', 'CDCDCD', 'CDCDCD', 'Business and Economics', 'Logistics and Supplies Chain Management', NULL, NULL, 'DepartmentHead', '0942689385', 'cd@gmail.com', '$2y$10$IWNwRsN7vjXLbfh6k0THHuc5J5vOYtsN8d/2164x6/1syYzeRJS2q', '2024-09-02'),
(118, 'DFDFDF', 'DFDFDF', 'DFDFDF', 'Business and Economics', 'Logistics and Supplies Chain Management', 1, 1, 'Advisor', '0942689385', 'df@gmail.com', '$2y$10$jabzIMePrjbAlOgM0UljCe2KQvC7KcrSL/7K.pM3iIfyFkd16Bv0a', '2024-09-02'),
(120, 'FDFDFD', 'FDFDFD', 'FDFDFD', 'Business and Economics', 'Logistics and Supplies Chain Management', 2, 2, 'LabAssistant', '0942689385', 'FD@gmail.com', '$2y$10$A3LCQnnk2xwWETFYLS93ZuvK.bmOiG4iKJ0fNeBf6TyVnEjC2PP9e', '2024-09-02'),
(121, 'OLOL', 'OLOLO', 'OLOLO', 'Business and Economics', 'Logistics and Supplies Chain Management', 4, 1, 'Advisor', '0942689385', 'ol@gmail.com', '$2y$10$8ybIR0WPxB6SjOI2XacloOVcGIofA5NHzq5chaaWM5HE3dyM8VPc.', '2024-09-02'),
(124, 'FGFG', 'FGFG', 'FFGG', 'Business and Economics', 'Logistics and Supplies Chain Management', 5, 1, 'Advisor', '0942689385', 'fg@gmail.com', '$2y$10$HLgeD2N808fzi9Zq5kfLouWYs6rlbexap3Przdu2GRtYOFAgcaTDO', '2024-09-02'),
(125, 'GFGFGFGF', 'GFGFGF', 'GFGFGF', 'Business and Economics', 'Logistics and Supplies Chain Management', 3, 1, 'Advisor', '0942689385', 'gf@gmail.com', '$2y$10$5xyvzAAAuqAsab7u4yNL.OT9WgpmU/miebQadIUmppSjVp2Z8tRkm', '2024-09-02'),
(139, 'MNMNNM', 'MNNMN', 'MNNMN', 'College of Medicine and health science', 'Medicine', NULL, NULL, 'DepartmentHead', '0942689385', 'mn@gmail.com', '$2y$10$sJXKjHkPC/eGI91GBLCRw.R7FyW1arVXwx04JMp68rFAZwCei9vYe', '2024-09-02'),
(150, 'VBVB', 'VBVB', 'VBVB', 'Business and Economics', 'Logistics and Supplies Chain Management', 3, 1, 'LabAssistant', '0942689385', 'vb@gmail.com', '$2y$10$4Y75Kru/0mzxixodlPGx6OKLu0T9iMkOBXX54ElyHxJE0orYBpXVi', '2024-09-03'),
(151, 'FIRA', 'ALL', 'ALL', 'College of Law', 'Law', 2, 2, 'LabAssistant', '0942689385', 'fira@gmail.com', '$2y$10$HF772Ei7yhnX89VJJ8q9XO9cqSWuf8DuLlLAmmJ.vJrvkeF7ZZD7C', '2024-09-13'),
(152, 'CDCDCD', 'CDCD', 'CDCD', 'College of Law', 'Law', 2, 2, 'Advisor', '0942689385', 'cdd@gmail.com', '$2y$10$/a71FLkrLxrxmEDIEvYND.ZKp4wcYbmR6zBL5.BVq/7zxAGZWHH..', '2024-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `forget_password`
--

CREATE TABLE `forget_password` (
  `id` int(10) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `status` enum('PENDING','COMPLETED') NOT NULL DEFAULT 'PENDING',
  `password_changed` tinyint(1) DEFAULT 0,
  `default_password` varchar(255) DEFAULT NULL,
  `date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forget_password`
--

INSERT INTO `forget_password` (`id`, `user_email`, `status`, `password_changed`, `default_password`, `date`) VALUES
(1, 'abel@email.com', 'COMPLETED', 0, NULL, '2024-08-15 09:15:16.236364'),
(4, 'biruk@email.com', 'COMPLETED', 0, NULL, '2024-08-15 15:03:22.084715'),
(5, 'abebe@email.com', 'COMPLETED', 0, NULL, '2024-08-15 15:03:27.070374'),
(6, 'teshome@gmail.com', 'COMPLETED', 0, NULL, '2024-08-15 15:03:30.131417'),
(7, 'teshome@gmail.com', 'COMPLETED', 0, NULL, '2024-08-15 15:03:33.460910'),
(9, 'ana@gmail.com', 'COMPLETED', 0, NULL, '2024-08-15 15:04:30.094876'),
(10, '66@gmail.com', 'COMPLETED', 0, NULL, '2024-08-24 06:31:50.693300'),
(11, 'ana@gmail.com', 'COMPLETED', 0, NULL, '2024-09-13 13:15:54.669808'),
(12, 'ana@gmail.com', 'COMPLETED', 0, NULL, '2024-12-19 07:03:27.789886');

-- --------------------------------------------------------

--
-- Table structure for table `reason`
--

CREATE TABLE `reason` (
  `reason_id` int(10) NOT NULL,
  `request_id` int(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `reason` text NOT NULL,
  `date` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reason`
--

INSERT INTO `reason` (`reason_id`, `request_id`, `user_email`, `reason`, `date`) VALUES
(25, 15, 'ana@gmail.com', 'A', '2024-08-30 19:40:50.000000'),
(26, 16, 'cdd@gmail.com', 'first advisor should approve', '2024-09-13 22:42:07.000000');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `RequestId` int(10) NOT NULL,
  `StudentId` varchar(64) NOT NULL,
  `AcademicYear` int(10) NOT NULL,
  `Semester` varchar(64) NOT NULL,
  `Reason` varchar(64) NOT NULL,
  `RequestDate` date NOT NULL DEFAULT current_timestamp(),
  `Advisor` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `LabAssistant` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `DepartmentHead` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `SchoolDean` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `BookStore` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Library` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Cafeteria` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `StudentLoan` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Dormitory` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `StudentService` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Store` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `AcademicEnrollment` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`RequestId`, `StudentId`, `AcademicYear`, `Semester`, `Reason`, `RequestDate`, `Advisor`, `LabAssistant`, `DepartmentHead`, `SchoolDean`, `BookStore`, `Library`, `Cafeteria`, `StudentLoan`, `Dormitory`, `StudentService`, `Store`, `AcademicEnrollment`) VALUES
(8, 'DDU1502313', 3, 'II', 'Semester End', '2024-07-29', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(10, 'ddu1402345', 2, '2', 'Semester End', '2024-08-13', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(11, 'ddu1402347', 2, '2', 'Semester End', '2024-08-13', 'PENDING', 'PENDING', 'APPROVED', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(12, 'ddu1402346', 2, '2', 'Semester End', '2024-08-13', 'PENDING', 'PENDING', 'APPROVED', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(13, 'ddu1402344', 2, '2', 'Withdraw', '2024-08-13', 'PENDING', 'PENDING', 'APPROVED', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(15, 'ddu1402311', 2, '2', 'Graduation', '2024-08-15', 'APPROVED', 'APPROVED', 'APPROVED', 'REJECT', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(16, 'ddu1402350', 2, '2', 'Semester End', '2024-09-13', 'REJECT', 'APPROVED', 'APPROVED', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(17, 'DDU1403261', 3, '2', 'Withdraw', '2024-09-13', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(18, 'ddu1402318', 2, '2', 'Semester End', '2024-09-29', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(19, 'ddu1402315', 2, '2', 'Semester End', '2024-12-18', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(20, 'ddu1402312', 2, '2', 'Semester End', '2024-12-18', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(21, 'ddu1402349', 2, '2', 'Semester End', '2024-12-18', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED'),
(22, 'ddu1402342', 2, '2', 'Semester End', '2024-12-20', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `request_processed`
--

CREATE TABLE `request_processed` (
  `RequestId` int(10) NOT NULL,
  `StudentId` varchar(64) NOT NULL,
  `AcademicYear` int(10) NOT NULL,
  `Semester` varchar(64) NOT NULL,
  `Reason` varchar(64) NOT NULL,
  `RequestDate` date NOT NULL DEFAULT current_timestamp(),
  `Advisor` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `LabAssistant` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `DepartmentHead` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `SchoolDean` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `BookStore` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Library` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Cafeteria` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `StudentLoan` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Dormitory` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `StudentService` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `Store` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING',
  `AcademicEnrollment` enum('PENDING','REJECT','APPROVED','') DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_processed`
--

INSERT INTO `request_processed` (`RequestId`, `StudentId`, `AcademicYear`, `Semester`, `Reason`, `RequestDate`, `Advisor`, `LabAssistant`, `DepartmentHead`, `SchoolDean`, `BookStore`, `Library`, `Cafeteria`, `StudentLoan`, `Dormitory`, `StudentService`, `Store`, `AcademicEnrollment`) VALUES
(14, 'DDU1403261', 5, '2', 'Semester End', '2024-09-21', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(15, 'ddu1402312', 2, '2', 'Withdraw', '2024-09-21', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(16, 'ddu1402315', 2, '2', 'Withdraw', '2024-08-29', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING'),
(18, 'ddu1402316', 2, '2', 'Semester End', '2024-09-21', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING', 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `studentdata`
--

CREATE TABLE `studentdata` (
  `id` int(64) NOT NULL,
  `StudentID` varchar(255) DEFAULT NULL,
  `First Name` varchar(255) DEFAULT NULL,
  `Father Name` varchar(255) DEFAULT NULL,
  `Gender` varchar(6) DEFAULT NULL,
  `Leg. Type` varchar(64) DEFAULT NULL,
  `Registration Date` date DEFAULT NULL,
  `Course Load` varchar(255) DEFAULT NULL,
  `Reg. Remark` varchar(255) DEFAULT NULL,
  `Permitted By` varchar(255) DEFAULT NULL,
  `Date` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentdata`
--

INSERT INTO `studentdata` (`id`, `StudentID`, `First Name`, `Father Name`, `Gender`, `Leg. Type`, `Registration Date`, `Course Load`, `Reg. Remark`, `Permitted By`, `Date`) VALUES
(26, 'DDU1601914', 'Raqia', 'Ali', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.490865'),
(27, 'DDU1601916', 'Shukri', 'Yusuf', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.491316'),
(28, 'DDU1601918', 'Suid', 'Yusuf', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.491775'),
(29, 'DDU1601919', 'Tamrat', 'Mulgeta', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.492228'),
(30, 'DDU1601921', 'Wadiho', 'Ahmed', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.492656'),
(31, 'DDU1601922', 'Yassin', 'Seid', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.493022'),
(32, 'DDU1601920', 'Tegene', 'Haile', 'M', 'HM', '2024-06-18', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.493336'),
(33, 'DDU1601894', 'Farahan', 'Hassen', 'M', 'HM', '2024-06-18', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.493790'),
(34, 'DDU1601917', 'Suad', 'Abdulahi', 'F', 'HM', '2024-06-18', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.494240'),
(35, 'DDU1601887', 'Biruk', 'Yasin', 'M', 'HM', '2024-06-20', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:46:35.494538'),
(36, 'DDU1601881', 'Abdulkadir', 'Dahir', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.635933'),
(37, 'DDU1601882', 'Abdusemed', 'Yimam', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.650515'),
(38, 'DDU1601883', 'Ahmed', 'Ali', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.651020'),
(39, 'DDU1601884', 'Amanuel', 'Melsew', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.751115'),
(40, 'DDU1601886', 'Asmira', 'Tesfa', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.751906'),
(41, 'DDU1601888', 'Bisrat', 'Meaza', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.752373'),
(42, 'DDU1601889', 'Daniel', 'Yimam', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.752910'),
(43, 'DDU1601890', 'Deqa', 'Abdilahi', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.753421'),
(44, 'DDU1601891', 'Desta', 'Assefa', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.753856'),
(45, 'DDU1601892', 'Ermiyas', 'Abebaw', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.754287'),
(46, 'DDU1601893', 'Faduma', 'Abdiqani', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.754848'),
(47, 'DDU1601895', 'Fufa', 'Gerbi', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.755321'),
(48, 'DDU1601898', 'Hamza', 'Matan', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.755827'),
(49, 'DDU1601899', 'Haregeweyne', 'Mebratu', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.756374'),
(50, 'DDU1601900', 'Henok', 'Wagayew', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.756825'),
(51, 'DDU1601901', 'Hunde', 'Shebo', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.757565'),
(52, 'DDU1601902', 'Kalkidan', 'Solomon', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.758647'),
(53, 'DDU1601903', 'Mahlet', 'Alemu', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.762872'),
(54, 'DDU1601904', 'Mastur', 'Ali', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.764656'),
(55, 'DDU1601905', 'Melaku', 'Tarekage', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.765363'),
(56, 'DDU1601907', 'Mesay', 'Ayalew', 'F', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.765907'),
(57, 'DDU1601908', 'Mohamed', 'Abdukadir', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.766294'),
(58, 'DDU1601909', 'Mohamed', 'Aliyyi', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.766591'),
(59, 'DDU1601910', 'Mulat', 'Azanaw', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.766860'),
(60, 'DDU1601911', 'Mustaf', 'Abdirahman', 'M', 'HM', '2024-06-14', 'Normal Load', '', 'Abdulmejid Tuni', '2025-01-28 13:49:47.767148');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ddustudentdata`
--
ALTER TABLE `ddustudentdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ddu_admin`
--
ALTER TABLE `ddu_admin`
  ADD PRIMARY KEY (`id`,`email`);

--
-- Indexes for table `ddu_staff`
--
ALTER TABLE `ddu_staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `ddu_substaff`
--
ALTER TABLE `ddu_substaff`
  ADD PRIMARY KEY (`subStaff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `forget_password`
--
ALTER TABLE `forget_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reason`
--
ALTER TABLE `reason`
  ADD PRIMARY KEY (`reason_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`RequestId`);

--
-- Indexes for table `request_processed`
--
ALTER TABLE `request_processed`
  ADD PRIMARY KEY (`RequestId`);

--
-- Indexes for table `studentdata`
--
ALTER TABLE `studentdata`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ddustudentdata`
--
ALTER TABLE `ddustudentdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `ddu_staff`
--
ALTER TABLE `ddu_staff`
  MODIFY `staff_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `ddu_substaff`
--
ALTER TABLE `ddu_substaff`
  MODIFY `subStaff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `forget_password`
--
ALTER TABLE `forget_password`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reason`
--
ALTER TABLE `reason`
  MODIFY `reason_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `RequestId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `request_processed`
--
ALTER TABLE `request_processed`
  MODIFY `RequestId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `studentdata`
--
ALTER TABLE `studentdata`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
