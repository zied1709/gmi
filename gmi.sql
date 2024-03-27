-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 27 mars 2024 à 00:59
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gmi`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`code`, `name`, `is_deleted`) VALUES
(1, 'Pc', 0),
(2, 'Smart phone', 0),
(3, 'Drone', 0),
(4, 'Tablette', 0),
(5, 'Réseaux', 0),
(6, 'Multimédia1', 0),
(7, 'Tv', 0),
(8, 'Turntable', 1),
(9, 'Camera', 0),
(10, 'test test', 1),
(11, 'Gaming', 0),
(12, 'Impression', 0),
(13, 'Testt', 1),
(14, 'Test', 0);

-- --------------------------------------------------------

--
-- Structure de la table `order_history`
--

CREATE TABLE `order_history` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `purchasedate` datetime DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `order_history`
--

INSERT INTO `order_history` (`id`, `uid`, `productid`, `quantity`, `purchasedate`, `status`, `is_deleted`) VALUES
(256, 39, 39, 1, '2022-12-15 01:02:36', 'Processing', 0),
(257, 39, 26, 1, '2022-12-15 01:02:36', 'Pending', 1),
(258, 24, 21, 1, '2022-12-15 01:07:25', 'Completed', 0),
(259, 40, 30, 1, '2022-12-15 01:11:05', 'Canceled', 0),
(260, 40, 27, 1, '2022-12-15 01:11:43', 'Pending', 0),
(261, 39, 22, 1, '2022-12-15 01:12:13', 'Processing', 0),
(262, 24, 10, 1, '2022-12-15 01:12:52', 'On Hold', 0),
(263, 24, 39, 1, '2022-12-15 15:01:47', 'Pending', 0),
(264, 47, 29, 4, '2022-12-15 15:05:59', 'Pending', 0),
(265, 47, 39, 1, '2022-12-15 15:06:12', 'Pending', 0),
(266, 47, 32, 1, '2022-12-15 15:06:28', 'Pending', 0),
(267, 47, 34, 1, '2022-12-15 15:06:28', 'Pending', 0),
(268, 47, 36, 2, '2022-12-15 15:09:02', 'Completed', 0),
(269, 24, 23, 1, '2023-01-08 05:53:39', 'Pending', 0);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `code` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `code_categorie` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `image2` varchar(50) DEFAULT NULL,
  `image3` varchar(50) DEFAULT NULL,
  `image4` varchar(50) DEFAULT NULL,
  `name2` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`code`, `name`, `price`, `image`, `code_categorie`, `description`, `image2`, `image3`, `image4`, `name2`, `is_deleted`) VALUES
(1, 'Black Tablet', 950, '638420bd01aeb6.52065860.png', 4, 'Tablet to watch your favorite movies or use for work.\r\n\r\n', '638420bd01af12.91772194.png', '638420bd01af24.63461452.png', '638420bd01af49.31248916.png', 'Black Tablet', 0),
(2, 'Assorted Cables', 20, '638420fa400067.82003870.png', 6, 'Cables to charge or connect your devices.\r\n', '638420fa4000d8.11123998.png', '638420fa4000f1.02959326.png', '638420fa400105.85717104.png', 'Assorted Cables', 0),
(3, 'Camera', 1250, '63842132e6a3d3.87763918.png', 9, 'Camera to take pictures of nature, family or anything you desire.', '63842132e6a439.04204329.png', '63842132e6a455.56734638.png', '63842132e6a473.42873010.png', 'Camera', 0),
(4, 'Cellphone', 650, '6384217063d6b1.09797308.png', 2, 'Cellphone to talk, text or browse the web.', '6384217063d730.46800543.png', '6384217063d767.78946594.png', '6384217063d786.63429207.png', 'Cellphone', 0),
(5, 'Black Earbuds', 150, '638421b9ab1867.14974143.png', 6, 'Earbuds for listening to your favorite music while on the go.\r\n\r\n', '638421b9ab18e4.54172468.png', '638421b9ab1916.91921083.png', '638421b9ab1931.75821449.png', 'Black Earbuds', 0),
(6, 'Turntable', 150, '63950fef09a242.90082403.png', 6, 'Turntable for listening to your favorite vinyls.', '63950fef09fff6.72678376.png', '63950fef0a2961.76905173.png', '63950fef0a5243.73659989.png', 'Turntable', 0),
(7, 'Modem', 100, '638422365b00c1.45148526.png', 5, 'Modem to hack neighbor\'s Wi-Fi.\r\n\r\n', '638422365b0126.32934455.png', '638422365b0140.51819796.png', '638422365b0153.91515598.png', 'Modem', 0),
(8, 'Smartwatch', 100, '638422b7b3c8c8.16736699.png', 6, 'This smart watch features new and improved software for a better user experience.\r\n\r\n', '638422b7b3c958.50140503.png', '638422b7b3c987.51579917.png', '638422b7b3c9a0.88342790.png', 'Smartwatch', 0),
(9, 'Black Headphones', 300, '638422ed84dc39.17737503.png', 6, 'Headphones for listening to your favorite music or playing your favorite games.\r\n\r\n', '638422ed84dcb0.94272695.png', '638422ed84dce3.06472928.png', '638422ed84dd02.77746541.png', 'Black Headphones', 0),
(10, 'Drone', 2000, '6384232c54b661.51313270.png', 3, 'Drone to talk images or videos from the sky.\r\n\r\n', '6384232c54b708.86994541.png', '6384232c54b734.22373548.png', '6384232c54b764.77156641.png', 'Drone', 0),
(11, 'Television', 3000, '6384235a238613.00514741.png', 7, 'Television to watch movies or shows, even surf the internet!\r\n\r\n', '6384235a238672.28220943.png', '6384235a238699.31466164.png', '6384235a2386a2.09922483.png', 'Television', 0),
(12, 'Laptop', 1000, '6384238b6259a6.87741294.png', 1, 'Laptop computer for all your business needs.\r\n\r\n', '6384238b625a06.27352135.png', '6384238b625a32.61092421.png', '6384238b625a46.81897953.png', 'Laptop', 0),
(13, 'test1', 1500, '63964021442bf3.82274531.png', 11, 'test test', '63964021445299.06891059.png', '63964021449e63.95430576.png', '6396402144c882.05592433.png', 'test1', 1),
(14, 'tayaroooooo', 1111, '638e86cceecd72.41079296.jpeg', 1, 'tayaro', '638e86935d2c78.11277590.jpg', '638e86935d2ca0.66424071.png', '638e86fe32cdc7.22068546.jpg', 'tayaroooooo', 1),
(15, 'Clavier', 300, '63963bd04f1a74.22672073.png', 11, 'Le confort des claviers gaming passe au niveau supérieur ! Grâce à une hauteur de touche plus basse et à des contrôles multimédias plus accessibles, la nouvelle conception à petit profil du clavier permet aux paumes de vos mains d’adopter une position par', '63963bd04f1ae7.96868816.png', '63963bd04f1b00.02210556.png', '63963bd04f1b28.59640184.png', 'Clavier', 0),
(16, 'Souris', 280, '63963c89d0b843.85492729.png', 11, 'Cette souris sans fil est conçue spécialement pour vous mener à la victoire. Disposant de technologies avancées comme la technologie sans fil Razer HyperSpeed ou encore les switches optiques Razer, la Viper Ultimate vous aide à frapper avec une rapidité m', '63963c89d0b8d6.28781634.png', '63963c89d0b904.71025196.png', '63963c89d0b938.84062118.png', 'Souris', 0),
(17, 'Playstation5 ', 3200, '63963edf86ffb9.27279249.png', 11, 'La PS5 succède logiquement à la PS4 et introduit avec elle une nouvelle architecture matériel avec un CPU Octa-Core AMD cadencé à 3,5 GHz épaulé par 16 Go de RAM GDDR6 et d\'un GPU AMD RDNA 2.', '63963e867a53f5.70709220.png', '63963e867a71c8.83576146.png', '63963e867aa376.02544203.png', 'Playstation5 ', 1),
(18, 'Playstation5 ', 3400, '639641d45400f0.74762625.png', 11, 'La PS5 succède logiquement à la PS4 et introduit avec elle une nouvelle architecture matériel avec un CPU Octa-Core AMD cadencé à 3,5 GHz épaulé par 16 Go de RAM GDDR6 et d\'un GPU AMD RDNA 2.', '639641d45421c4.42308120.png', '639641d45441b7.86627152.png', '639641d4546128.66271086.png', 'Playstation5 ', 1),
(19, 'Playstation ', 4000, '63964216895490.81635404.png', 11, 'La PS5 succède logiquement à la PS4 et introduit avec elle une nouvelle architecture matériel avec un CPU Octa-Core AMD cadencé à 3,5 GHz épaulé par 16 Go de RAM GDDR6 et d\'un GPU AMD RDNA 2.', '63964216895509.85181038.png', '63964216895525.83128774.png', '63964216895541.69195124.png', 'Playstation ', 1),
(20, 'play', 4000, '63964238c23836.36207165.png', 11, 'aaa', '63964238c238e8.22878202.png', '63964238c23915.06841043.png', '63964238c23930.14298415.png', 'play', 1),
(21, 'Playstation', 4000, '63964278d25a89.23369621.png', 11, 'La PS5 succède logiquement à la PS4 et introduit avec elle une nouvelle architecture matériel avec un CPU Octa-Core AMD cadencé à 3,5 GHz épaulé par 16 Go de RAM GDDR6 et d\'un GPU AMD RDNA 2.', '63964278d25af1.60584820.png', '63964278d25b10.12367742.png', '63964278d25b34.56855111.png', 'Playstation', 0),
(22, 'Micro Casque', 480, '6396449eae96b5.46570016.png', 6, 'Micro Casque JBL Live 400 Bluetooth – Noir', '6396449eae9738.23403181.png', '6396449eae9758.99881469.png', '6396449eae9778.48202125.png', 'Micro Casque', 0),
(23, 'Imprimante', 700, '639645e85df6d9.49113758.png', 12, 'Imprimante conçue pour les volumes d’impression élevés, profitez immédiatement de 5 000 pages de toner après déballage.\r\nBénéficiez de vitesses d’impression allant jusqu’à 20 ppm.\r\nEffectuez facilement toutes vos tâches grâce aux performances polyvalentes', '639645e85df846.95496180.png', '639645e85df890.76685294.png', '639645e85df8c1.79842916.png', 'Imprimante', 0),
(24, 'Cartouche', 80, '639646f0396c80.18407783.png', 12, 'Cartouche Jet d’encre Original HP. Nombre Total de Pages(Noir & Blanc): 120 pages.', '639646f0396d13.79533446.png', '639646f0396d40.52059272.png', '639646f0396d71.66031200.png', 'Cartouche', 0),
(25, 'Imprimante Jet d’Encre', 579, '639648780c2863.36004235.png', 12, 'Imprimante à Réservoir Intégré EPSON ECOTANK L3210', '639648780c28d9.83853127.png', '639648780c28f0.91286710.png', '639648780c2919.00051455.png', 'Imprimante Jet d’Encre', 0),
(26, 'Legion 5 PRO', 4100, '63964a54444239.26693540.png', 1, 'Pc portable lenovo legion 5 PRO RYZEN 5 5600H 16 Go RTX 3060 6GB Noir – 82JQ00DYFG', '63964a544442b8.39305682.png', '63964a544442d8.25365552.png', '63964a544442f5.39900162.png', 'Legion 5 PRO', 0),
(27, 'Asus TUF', 3400, '63964b41704235.68543950.png', 11, 'PC Portable Gamer Asus TUF 706HCB I5 11GÉN 8GO 512GO SSD NOIR', '63964b417043d9.43102324.png', '63964b41704437.01696689.png', '63964b41704479.66925929.png', 'Asus TUF', 0),
(28, 'Msi GF63', 3500, '63964fa7e9b5e9.99999510.png', 11, 'Pc Portable Gamer Msi GF63 Thin11SC-612XFR i7 11é Gén 8 Go 512 Go SSD GTX1650 4Go Noir', '63964fa7e9b669.13507476.png', '63964fa7e9b690.89625766.png', '63964fa7e9b6a5.24524836.png', 'Msi GF63', 0),
(29, 'Instax Mini 11', 329, '639651b9638b51.04418141.png', 9, 'Appareil photo Instantané FUJIFILM Instax mini 11\r\n', '639651b9638bd0.26810773.png', '639651b9638bf3.43191519.png', '639651b9638c13.30474445.png', 'Instax Mini 11', 0),
(30, 'Vidéo Projecteur', 1650, '6396548d034ae8.53571792.png', 6, 'Vidéo Projecteur Epson EB-W06 WXGA -V11H973040', '6396548d034ba6.39991379.png', '6396548d034bd1.77907690.png', '6396548d034c11.80287371.png', 'Vidéo Projecteur', 0),
(31, 'Vidéo Projecteur', 1680, '6396563690aec5.74651447.png', 6, 'Vidéo Projecteur Xiaomi Mi Smart Projector 2 EU', '6396563690af43.15062226.png', '6396563690af67.24848201.png', '6396563690af87.46733203.png', 'Vidéo Projecteur', 0),
(32, 'Switch', 39, '639656ddefd0e6.00714121.png', 5, 'Switch TP-LINK 8 Ports 10/100Mbps ( TL-SF1008D )\r\n', '639656ddefd179.55070829.png', '639656ddefd187.48122332.png', '639656ddefd1a6.26317594.png', 'Switch', 0),
(33, 'Répéteur', 99, '63965af27312e5.61907768.png', 5, 'Répéteur sans fil D-Link N300 DAP-1325 Blanc', '639657f353f654.76001041.png', '639657f353f677.32402679.png', '639657f353f686.65074325.png', 'Répéteur', 0),
(34, 'Téléviseur', 3429, '63965a2ec87606.53751654.png', 7, 'Téléviseur Samsung 55″BU7000 Crystal UHD 4K Smart', '63965a2ec87660.19616657.png', '63965a2ec87683.58670215.png', '63965a2ec87691.78213560.png', 'Téléviseur', 0),
(35, 'iPhone 12 Pro Max', 3800, '63965c7937ef33.00953663.png', 2, 'Apple iPhone 12 Pro Max 6,7\" 256 Go Double SIM 5G Graphite\r\n', '63965c7937f113.89519301.png', '63965c7937f130.88944515.png', '63965c7937f157.16758844.png', 'iPhone 12 Pro Max', 1),
(36, 'Tablette', 459, '63965dc23de369.76470952.png', 4, 'Tablette Huawei Mediapad T3 10″ 2Go – 16Go – Gris\r\n', '63965dc23de3d2.69282628.png', '63965dc23de3f8.71039051.png', '63965dc23de412.74366446.png', 'Tablette', 0),
(37, 'S22 Ultra ', 5999, '63965f69d28b77.12285177.png', 2, 'Smartphone Samsung Galaxy S22 Ultra 12 Go – 256 Go – Noir\r\n', '63965f69d28bd4.89904236.png', '63965f69d28bf6.90643621.png', '63965f69d28c14.32399059.png', 'S22 Ultra ', 1),
(38, 'S22 Ultra ', 3000, '63966048a64528.48736463.png', 2, 'ss', '63966048a666e6.20751921.png', '63966048a68bb2.39685665.png', '63966048a6b6f0.87754597.png', 'S22 Ultra ', 1),
(39, 'S22', 5999, '63965ff76eabc1.65802899.png', 2, 'Smartphone Samsung Galaxy S22 Ultra 12 Go – 256 Go – Noir', '63965ff76eac39.25078801.png', '63965ff76eac55.73017617.png', '63966073768f03.56707647.png', 'S22', 0),
(40, 'Drone', 4000, '6396649188b3b9.73927515.png', 3, 'dronee', '6396649188b441.38733721.png', '6396649188b468.67718089.png', '6396649188b483.90571351.png', 'Drone', 1),
(41, 'test', 4000, '639695a49b54d4.01784251.png', 9, 'test', '639695a49b55c0.00165414.png', '639695a49b55e7.73765258.png', '639695a49b55f7.42771684.png', 'test', 1),
(42, 'test', 4000, '639a5368015ed6.75791791.png', 14, 'test', '639a57b7effcb7.65369407.png', '639a5368015fb5.88890292.png', '639a5368015fd0.99536644.png', 'test', 1),
(43, 'test', 4000, '639a54d4279fc8.60822800.png', 1, 'test', '639a5405a30402.42850905.png', '639a5405a30429.80387336.png', '639a5405a30441.40638552.png', 'test', 1),
(44, 'test', 4000, '639a5426f0cff8.44568448.png', 6, 'test', '639a5426f0d058.22753437.png', '639a5426f0d062.99694891.png', '639a5426f0d085.81167873.png', 'test', 1),
(45, 'puzzle', 33, '64024d6a096b99.78612936.jpg', 1, 'puzzzle', NULL, NULL, NULL, 'puzzle', 1),
(46, 'zied', 100, '64024e0a292da5.14368269.jpg', 12, 'cc', NULL, NULL, NULL, 'zied', 1),
(47, 'zied', 500, '640254b0c5a382.04939475.jpg', 1, 'hjguyg', '640254b0c5a403.88600329.jpg', '640254b0c5a415.23787513.jpg', '640254b0c5a432.19177415.jpg', 'zied', 1),
(48, 'tayari yheb yetaaacha', 333, '64025e9617c9a7.72819983.jpg', 1, 'aaaa', '64025e9617ca35.10563670.jpg', '64025e9617ca57.17833810.jpg', '64025e9617ca82.96891449.jpg', 'tayari yheb yetaaacha', 1),
(49, 'puzzlee test', 33, 'car.jpg', 1, 'jjjss', 'avion.jpg', 'moto.jpg', 'bike.jpg', 'puzzlee test', 1),
(50, 'treed', 444, '6423d36eae3764.24235809.jpg', 1, 'test', '6423d36eae3a24.60865642.jpg', NULL, NULL, 'treed', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `submit_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `name`, `content`, `rating`, `submit_date`) VALUES
(1, 1, 'zieed', 'top !', 4, '2022-12-06 01:16:18'),
(2, 1, 'enis', 'Nice ', 2, '2022-12-06 01:29:59'),
(3, 12, 'Oussema', 'Behy ', 5, '2022-12-06 01:49:38'),
(4, 1, 'zieed', 'Mchoum', 5, '2022-12-08 01:28:31'),
(5, 12, 'zied', 'Tayaraa !', 1, '2022-12-06 03:28:55'),
(8, 12, 'Zied Dammak', 'Ooh !', 3, '2022-12-06 21:59:03'),
(9, 12, 'Zied Dammak', 'Nice', 4, '2022-12-06 23:35:17'),
(10, 2, 'Oussema Tayari', 'Super', 3, '2022-12-07 15:44:03'),
(11, 9, 'Zied Dammak', 'Epic !!!!!', 2, '2022-12-11 20:44:49'),
(12, 3, 'Zied Dammak', 'Extraordinaire ', 3, '2022-12-11 20:45:09'),
(13, 3, 'Zied Dammak', 'Legendary', 2, '2022-12-11 20:45:35'),
(14, 12, 'Zied Dammak', 'ayayaya', 4, '2022-12-11 20:48:06'),
(15, 12, 'Zied Dammak', 'Cavaaaa', 1, '2022-12-11 20:48:36'),
(16, 24, 'Zied Dammak', 'semha\r\n', 5, '2022-12-12 01:06:02'),
(17, 39, 'Oussema Tayari', 'Exelent ! Mais trop cher xD', 5, '2022-12-15 01:00:56'),
(18, 39, 'Zied Dammak', 'Nokia is better !', 3, '2022-12-15 01:20:41'),
(19, 39, 'Ayoub Dammak', 'J\'ai pas aimé le design ', 1, '2022-12-15 01:26:50'),
(20, 39, 'Zied Dammak', '20', 2, '2022-12-15 14:56:58');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `image`, `telephone`, `admin`, `is_deleted`) VALUES
(24, 'zied.dammak@enis.tn', '$2y$10$pYBJzdNPtej/4t.5hnlv9.AchRHkg0Aw.lqbYJs0EpWoInSpCARBO', 'Zied', 'Dammak', '6384570541a2a1.45578475.jpeg', '26 875 198', 1, 0),
(39, 'oussema.tayari@enis.tn', '$2y$10$E2mJr/P6E8UxGacirUzYYe6C9bDNxT75scBb1lHRFEMiQDQbhzZBS', 'Oussema', 'Tayari', '639a5d677b8f41.66462240.png', '44 999 060', 1, 0),
(40, 'ayoub.dammak@iit.tn', '$2y$10$Kn1VqB/35.pVx9O9NYGcceqwCxQ1gOCa82ezF42qP5t6/D5sYZR8q', 'Ayoubb', 'Dammak', '639a5d940ad0f5.13523261.png', '22 075 303', 1, 0),
(41, 'test@admin.tn', '$2y$10$9sJRl06SgpYJ3MlXQPiNG.OR.SopkuqhljrcCEhEVyRdyFbM61yHa', 'Test', 'Test', '639a5e040f6143.83780068.png', 'test', 1, 0),
(42, 'test@user.tn', '$2y$10$5bPD68/adI9xWkAY2tTdROb9m.BgsEbeWne31iSMHCXKNIC6psB5a', 'Test', 'Test', '639a5e22de4117.31875155.png', 'test', 0, 0),
(45, 'senpai@senpai.tn', '$2y$10$X3Wg0uvZW/hUHo949Uv9M.ymaR5QEtKuHk.kS/geBmOJxTthSNYO2', 'Senpai', 'Senpai', '639a6122e31754.74508405.png', '44 999 060', 0, 0),
(46, 'projet@pro.tn', '$2y$10$c3h7mFEc9Poov569cwrmTObrzqrM2wCmUwsc1l5Qzb7o2RAGJfta2', 'projet', 'projet', '639b285e0809b0.43947306.png', '222222', 1, 0),
(47, 'zied@dkFFsoft.com', '$2y$10$rgBYDzKSKj4eiEA5w.qJGuS3.YwOBEKVbKNUFzaBSikB.vz87SZSu', 'Zied', 'test', '639e14212aea46.73138997.png', '222222', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `dateadded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `wishlist`
--

INSERT INTO `wishlist` (`id`, `uid`, `productid`, `dateadded`) VALUES
(1, 14, 11, '2022-12-07 15:06:12'),
(2, 14, 12, '2022-12-07 15:12:11'),
(3, 14, 12, '2022-12-07 15:18:32'),
(9, 32, 6, '2022-12-07 15:38:41'),
(10, 32, 12, '2022-12-07 15:39:20'),
(19, 32, 11, '2022-12-08 16:54:49'),
(23, NULL, NULL, '2022-12-12 01:36:30'),
(24, NULL, NULL, '2022-12-12 01:36:35'),
(25, 39, 24, '2022-12-12 01:37:53'),
(30, 39, 39, '2022-12-15 01:01:59'),
(31, 40, 34, '2022-12-15 01:31:45'),
(32, 24, 26, '2022-12-15 01:32:17'),
(34, 24, 22, '2022-12-15 01:32:37'),
(35, 47, 22, '2022-12-15 15:08:39'),
(36, 24, 29, '2023-01-08 05:54:08');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `order_history`
--
ALTER TABLE `order_history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`code`),
  ADD KEY `code_categorie` (`code_categorie`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `order_history`
--
ALTER TABLE `order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk` FOREIGN KEY (`code_categorie`) REFERENCES `categorie` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
