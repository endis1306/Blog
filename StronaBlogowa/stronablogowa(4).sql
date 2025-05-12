-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 20, 2023 at 10:46 PM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stronablogowa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `ID` int(11) NOT NULL,
  `Content` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `PostID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Author` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ID`, `Content`, `date`, `PostID`, `UserID`, `Author`, `rating`) VALUES
(94, 'cześć', '2023-06-08 13:28:58', 28, 1, 'mieszkobu', 0),
(95, 'xcvbxcv', '2023-06-08 13:36:16', 28, 1, 'mieszkobu', 0),
(96, 'hej\r\n', '2023-06-08 13:36:24', 28, 1, 'mieszkobu', 0),
(97, 'czesc\r\nsda', '2023-06-08 13:36:47', 28, 1, 'mieszkobu', 0),
(98, 'dsfdfs', '2023-06-10 13:03:21', 28, 0, 'fsddfs*', 0),
(99, 'cdgfbvgfddgf', '2023-06-17 20:42:52', 28, 1, 'mieszkobu', 0),
(100, 'dsfdfd', '2023-06-18 15:27:44', 33, 0, 'sdfsdf*', 0),
(101, 'wqerqwe', '2023-06-20 19:54:34', 32, 8, 'mieszko', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `images`
--

CREATE TABLE `images` (
  `ImageID` int(11) NOT NULL,
  `PostID` int(11) DEFAULT NULL,
  `FilePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`ImageID`, `PostID`, `FilePath`) VALUES
(6, 28, 'uploads/6481bb1d12789.png'),
(7, 28, 'uploads/6481bb1d128f9.png'),
(8, 28, 'uploads/6481bb1d12a39.png'),
(9, 28, 'uploads/6481bb1d12b91.png'),
(10, 29, 'uploads/64846838a7369.'),
(13, 32, 'uploads/6485984edb7d1.'),
(14, 33, 'uploads/648dfee87fc3b.'),
(15, 34, 'uploads/648f462e4d475.'),
(16, 35, 'uploads/648f463126538.'),
(17, 36, 'uploads/6491eb7ec3e0c.');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `message` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `author_id`, `message`, `timestamp`) VALUES
(1, 1, 7, 'Hej', '2023-06-17 18:47:37'),
(3, 7, 1, 'Hej', '2023-06-18 14:18:53'),
(4, 7, 1, 'a', '2023-06-18 14:19:44'),
(5, 7, 1, 'a', '2023-06-18 14:20:29'),
(6, 7, 1, 'yh', '2023-06-18 14:20:31'),
(7, 7, 1, 'yh', '2023-06-18 14:28:54'),
(8, 7, 1, 'uu', '2023-06-18 14:29:01'),
(9, 1, 7, 'hej', '2023-06-18 14:29:18'),
(10, 8, 7, 'Hej', '2023-06-18 18:11:42');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posts`
--

CREATE TABLE `posts` (
  `ID` int(11) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Content` text NOT NULL,
  `Date` datetime NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) DEFAULT NULL,
  `view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `Title`, `Content`, `Date`, `UserID`, `view`) VALUES
(28, 'Cześć2', '\r\naaaLorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ultrices maximus lorem feugiat maximus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque fermentum eget dui nec feugiat. Etiam faucibus magna finibus ante sagittis sagittis. Duis hendrerit interdum lorem, vitae fermentum odio eleifend vel. Morbi tincidunt orci vitae neque iaculis fringilla. Ut eget arcu tempus, pharetra purus vel, varius turpis. Curabitur pellentesque purus quis est suscipit, eu ultrices elit varius. Mauris ultricies magna tellus, id ullamcorper augue facilisis auctor. Nunc egestas odio in neque feugiat, at sollicitudin metus volutpat. Vivamus vulputate leo non leo rutrum, id lobortis neque mollis. Quisque a varius nisl. Sed pretium ut purus sed porta. Vestibulum a sem elit.\r\n\r\nDonec quis sodales justo, eget dignissim enim. Donec fermentum arcu in lectus scelerisque ornare. Donec aliquam elementum pharetra. Morbi cursus venenatis commodo. Donec viverra egestas nunc, nec fermentum elit euismod sit amet. Proin ac metus non lectus varius varius eget eget purus. Sed nec urna id libero congue iaculis quis ut enim. Nullam non velit viverra, faucibus diam eget, dictum magna. Nulla sit amet auctor sem. Nunc finibus iaculis eros, venenatis elementum lorem euismod commodo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean blandit tortor interdum vulputate consectetur. Praesent ut efficitur nisl. Aenean et cursus velit.\r\n\r\nNulla facilisi. Etiam efficitur elit hendrerit, dapibus dolor nec, iaculis neque. Quisque elementum, ex quis lobortis hendrerit, arcu ligula luctus mi, sed posuere erat augue et tellus. Nunc non tincidunt eros. Donec purus arcu, rutrum at nulla eu, laoreet mollis lacus. Praesent rutrum velit at finibus egestas. Phasellus eu convallis neque, vel tristique odio. Proin venenatis lacus vel neque vulputate euismod.\r\n\r\nIn lectus diam, tristique sed accumsan sit amet, ultricies in orci. In pellentesque aliquet diam, ut elementum orci venenatis sit amet. Donec non nisl bibendum, facilisis ante quis, dignissim est. Phasellus convallis augue elit, eu condimentum velit semper eget. Aenean semper porttitor enim, nec condimentum turpis gravida nec. Nullam pretium semper leo, a bibendum risus posuere scelerisque. Nam scelerisque porttitor magna, sed maximus augue cursus quis. Donec ligula felis, imperdiet non nulla et, faucibus rhoncus quam. Vivamus sollicitudin in neque at eleifend.\r\n\r\nFusce eget enim vitae eros imperdiet tempus. In in lobortis nulla. Suspendisse varius in tellus rhoncus varius. Aenean porta velit in nisl posuere, vel commodo metus dapibus. Quisque dictum a eros et ullamcorper. Morbi leo elit, placerat ac rutrum non, commodo vel nisl. Sed posuere ante ac quam maximus feugiat. Curabitur tincidunt libero eget est faucibus, nec ultrices est finibus. Vivamus ultricies bibendum cursus. Etiam non leo lacus. Suspendisse nibh metus, dignissim ut arcu vitae, pretium consequat velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse potenti. Interdum et malesuada fames ac ante ipsum primis in faucibus. Curabitur sit amet hendrerit eros, vel vulputate tellus.\r\n\r\nDuis vitae malesuada purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus at faucibus neque, non accumsan quam. Etiam bibendum ut ante vitae maximus. Proin quis diam suscipit, rutrum quam ut, elementum dui. Etiam ac lobortis nulla. Vivamus mattis semper finibus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec fermentum lacus sit amet nisl gravida eleifend. Nunc condimentum enim id enim dapibus, sed ullamcorper mi rhoncus. Sed ornare tincidunt dui, sed gravida mauris.\r\n\r\nNam viverra auctor diam, mollis sodales neque tristique placerat. Proin commodo viverra odio fermentum rutrum. Nulla placerat vitae turpis at auctor. Quisque sed consequat quam, a pulvinar metus. Quisque mattis ac ligula sed fringilla. Nam dictum dignissim lobortis. Praesent ac lorem vitae nibh cursus tincidunt.\r\n\r\nDonec iaculis eleifend euismod. Aenean ultrices vestibulum quam, sit amet egestas magna ornare vitae. Curabitur ac ipsum non odio placerat porta et ac dui. Mauris elementum vel quam sed commodo. Mauris gravida elementum vulputate. Donec ut nulla vel libero tincidunt ullamcorper. Sed ac auctor est.\r\n\r\nAenean commodo tincidunt turpis et ultrices. Nunc porttitor ac tortor in sagittis. Maecenas lobortis et odio sed ullamcorper. Mauris at posuere nunc, eget dictum justo. Cras condimentum, lorem sed bibendum volutpat, nunc lorem placerat mi, quis faucibus enim magna in mi. Sed tortor ante, consequat sit amet enim at, vulputate dictum dui. Vivamus sed placerat purus. Nulla facilisi. Praesent sit amet felis vitae orci scelerisque semper sit amet ut enim. Nullam quis volutpat lorem, eget aliquet sem. Curabitur pretium rutrum sollicitudin. Cras sit amet diam neque. Duis nunc massa, molestie a finibus tincidunt, facilisis non massa. In eleifend blandit tortor, ultrices tincidunt eros auctor vitae.\r\n\r\nNunc ex nisi, ultrices eu nibh sed, congue blandit justo. Fusce tellus dui, interdum ut tortor in, ornare fringilla urna. Ut pulvinar sapien aliquet ipsum mollis iaculis. Nulla molestie facilisis lorem vitae efficitur. Suspendisse lorem est, facilisis vitae neque interdum, malesuada sagittis neque. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut id interdum neque.\r\n\r\nVivamus sed velit suscipit, ornare libero id, mattis dolor. Sed ullamcorper placerat vehicula. Phasellus sagittis vestibulum nisi, vitae fringilla neque. Aliquam eget nulla eu nunc gravida egestas sed sit amet mi. Nullam euismod magna nec sodales lacinia. Donec non cursus diam. Aenean placerat consequat lacus at cursus. In lacinia venenatis nisi. Proin nec accumsan risus. Donec dictum quam finibus nulla sagittis pretium.\r\n\r\nSuspendisse lorem tortor, rhoncus eu pulvinar eu, tincidunt eget est. Nam imperdiet ante scelerisque turpis efficitur iaculis. Etiam sodales purus ac suscipit sodales. Integer tempor dolor eu placerat blandit. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla pharetra ultrices orci sit amet consectetur. Sed semper laoreet tristique. Nam auctor mauris sit amet mi pharetra lacinia. Integer malesuada est eleifend turpis euismod hendrerit.\r\n\r\nNullam et dui in erat eleifend vestibulum at et nunc. Cras ullamcorper vitae velit at congue. Aenean at posuere ante. Nulla non dolor in ante semper sollicitudin at a metus. Mauris ac ligula nisi. Nullam quis diam hendrerit, auctor orci at, blandit diam. Praesent facilisis eu odio a hendrerit. Phasellus fermentum in dolor nec egestas. Vivamus tempor nisl ut ultricies ultricies. Sed tristique dignissim felis eget aliquam. Pellentesque eu convallis sem. Fusce ullamcorper porttitor felis sit amet vehicula. Mauris sit amet condimentum nunc, sollicitudin varius magna.\r\n\r\nInteger aliquam purus massa, eu venenatis nisi pharetra vitae. Aliquam rutrum congue justo ut suscipit. Donec in fringilla dui, id pretium libero. Sed laoreet nunc eu nibh ultricies, eu varius lacus commodo. Suspendisse non sapien eu purus rutrum commodo. Mauris blandit molestie purus quis faucibus. Nam at sodales ante, quis suscipit nisi. Integer mi elit, condimentum sit amet cursus mollis, porta ut velit. Proin tempor consectetur orci id dapibus. Aenean ut mauris volutpat tortor vehicula dignissim sed in dui. Nulla ac leo ut elit gravida aliquet. Cras elit nunc, feugiat et venenatis vel, pulvinar eu arcu. Etiam placerat erat nec nisl sodales dapibus.\r\n\r\nDuis dignissim mi nec malesuada laoreet. Ut eget iaculis quam. Proin tristique dapibus tellus, eu vulputate risus aliquet nec. Phasellus maximus faucibus massa, vitae tincidunt orci tincidunt vel. Aenean id diam in neque sagittis lacinia vel fringilla nibh. Sed imperdiet fermentum lorem. Aenean odio diam, congue vel lacus id, dictum dignissim tortor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec dictum quis lorem id hendrerit. Ut porta est lacus. In eu arcu nisi.\r\n\r\nCras urna risus, placerat sit amet libero et, laoreet lacinia nibh. Curabitur eros nisl, lobortis ut faucibus a, hendrerit nec sapien. Vivamus quis placerat ante, vel aliquam arcu. Morbi at tortor pulvinar neque scelerisque rhoncus at sit amet arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut auctor sapien a tincidunt vehicula. Donec quis auctor lorem, et vestibulum quam. Pellentesque felis eros, rhoncus sed erat vitae, luctus tincidunt orci. Vivamus in purus at lacus hendrerit euismod ut in risus. Vivamus varius enim sit amet tincidunt faucibus. Sed at nunc vitae nibh malesuada ullamcorper fermentum quis diam. Duis fermentum elit eget tempus ultricies. Nullam dignissim laoreet ex vel pellentesque. Quisque tristique augue at nulla euismod, vitae pulvinar ipsum scelerisque.\r\n\r\nProin eu dolor vulputate, mattis ante a, ultrices mauris. Praesent bibendum fringilla mi non cursus. Duis facilisis sagittis convallis. Proin feugiat nec ante sit amet scelerisque. Ut mattis dignissim orci, vitae consequat felis eleifend at. In sit amet felis aliquet, dapibus elit quis, ornare quam. Donec ultrices tellus a nunc lacinia, et condimentum augue varius. Aenean quis dolor vel ligula blandit bibendum. Ut tempor tortor sed elit luctus, at hendrerit sem ultrices. Mauris nec magna ac orci pretium convallis. Ut nisl est, dapibus in malesuada eu, tincidunt sed metus. Donec et tortor eu ipsum faucibus laoreet. Proin bibendum quam nisi, pellentesque efficitur lectus malesuada eget. Sed at finibus dolor. Etiam sed arcu accumsan, lacinia orci id, suscipit ipsum. Sed vel volutpat purus.\r\n\r\nPhasellus feugiat, metus et interdum mattis, urna turpis dignissim tellus, in pretium mi libero malesuada eros. Nulla vestibulum elit lacus, et lobortis velit lobortis vitae. Ut malesuada porttitor turpis, sit amet interdum lacus pharetra at. Etiam quis tincidunt libero, in ultrices justo. Pellentesque sodales est vel suscipit varius. In facilisis cursus eleifend. Donec at elementum orci. Vestibulum felis dolor, facilisis quis facilisis eu, cursus vel mauris.\r\n\r\nAliquam ut nunc eu arcu eleifend tempus. Maecenas ornare, tortor elementum molestie sodales, sem felis ornare nibh, quis accumsan nunc nisi tincidunt nibh. Duis posuere ipsum id velit facilisis, consequat suscipit dui aliquam. Integer id enim vitae leo condimentum consectetur nec a velit. Nullam posuere tempus faucibus. Suspendisse libero ligula, vestibulum lacinia fringilla at, commodo sed neque. Aenean luctus odio neque, at molestie mauris elementum et. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed consectetur mauris tortor, id vulputate nibh cursus vel. Maecenas consectetur, lacus eu fringilla cursus, diam ipsum vehicula urna, vel efficitur magna purus ut leo. Etiam a vulputate metus, eu pharetra arcu.\r\n\r\nVestibulum lectus mauris, aliquam sit amet blandit a, dapibus quis nulla. Phasellus luctus, lectus vitae volutpat pharetra, odio urna euismod ipsum, nec varius felis sem ac velit. In varius sem ac eros facilisis, a blandit leo convallis. Pellentesque in urna urna. Nullam nec mollis felis, at bibendum diam. Pellentesque eget urna vitae felis maximus tincidunt. Donec blandit purus at sagittis dictum. Quisque vel imperdiet dolor. ', '2023-06-08 13:27:25', 1, 40),
(29, 'Aasddasdasdasadasdas', 'Mieszko jest królem', '2023-06-10 14:10:32', 1, 25),
(32, 'sbfdbgdf', 'bdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdfbdf', '2023-06-11 11:47:58', 7, 70),
(33, 'fafasdgfa', 'afssssssssssssssssssssssssssssssssssssssssss', '2023-06-17 20:43:52', 1, 52),
(34, 'Hej', 'dassssssss', '2023-06-18 20:00:14', 8, 7),
(35, 'a', 'fasddfs', '2023-06-18 20:00:17', 8, 10),
(36, 'hej', 'dasssssssssss', '2023-06-20 20:10:06', 10, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `replies`
--

CREATE TABLE `replies` (
  `ID` int(11) NOT NULL,
  `CommentID` int(11) DEFAULT NULL,
  `Content` text DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Author` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`ID`, `CommentID`, `Content`, `Date`, `UserID`, `Author`, `rating`) VALUES
(19, 94, 'dasdasdas', '2023-06-08 13:32:54', 1, 'mieszkobu', 0),
(20, 94, 'dsadsadas', '2023-06-08 13:35:19', 1, 'mieszkobu', 0),
(21, 94, 'dasdasdas', '2023-06-08 13:36:06', 1, 'mieszkobu', 0),
(22, 96, 'hej', '2023-06-08 13:36:32', 1, 'mieszkobu', 0),
(23, 97, 'czesc\r\n', '2023-06-08 13:37:03', 1, 'mieszkobu', 0),
(24, 98, 'xcvxcvxcv', '2023-06-10 13:03:27', 0, 'xcvxcv*', 0),
(25, 99, 'asdasdas', '2023-06-17 20:42:58', 1, 'mieszkobu', 0),
(26, 101, 'dfsdfs', '2023-06-20 19:54:37', 8, 'mieszko', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` varchar(255) NOT NULL DEFAULT 'user',
  `Popularnosc` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Login`, `Email`, `Password`, `Role`, `Popularnosc`) VALUES
(-1, 'admin', 'admin@admin.pl', '$2y$10$VU69K1QRHdkA3gic.2ppiODdV2U8gPUTBAMOqdM022jyYmliniP2m', 'admin', 0),
(0, 'gosc', '', '', 'guest', 0),
(1, 'mieszkobu', 'mieszkobu@wp.pl', '542316be488053098bdcb61ba998b748a78467931682b71795b725f763587a2f', 'user', 0),
(7, 'z', 'z@wp.pl', '594e519ae499312b29433b7dd8a97ff068defcba9755b6d5d00e84c524d67b06', 'user', 0),
(8, 'mieszko', 'mieszko@wp.pl', '$2y$10$JQ2v7l56gmJTf7v8i.jYwOCum/wYwQK.fthf4RjDql5JM3Wjn8MtS', 'user', 0),
(9, 'h', 'h@wp.pl', '$2y$10$zIe2YDaJ9WpewNq.uAogBeTtom7Hm7eRjwToa7knryy9BPYYCsGdO', 'user', 0),
(10, 'dupa', 'dupa@wp.pl', '$2y$10$jnNzLCiTNC4U1I8Up7cp2e5s1HCZgoTfbUwZjLgZS/WZ07l6iHzVi', 'user', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PostID` (`PostID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indeksy dla tabeli `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`ImageID`),
  ADD KEY `PostID` (`PostID`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indeksy dla tabeli `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CommentID` (`CommentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `ImageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`PostID`) REFERENCES `posts` (`ID`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`CommentID`) REFERENCES `comments` (`ID`),
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
