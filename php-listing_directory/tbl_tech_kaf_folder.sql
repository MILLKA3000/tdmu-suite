-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Час створення: Вер 20 2013 р., 17:00
-- Версія сервера: 5.1.52-community
-- Версія PHP: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `tdmu`
--

-- --------------------------------------------------------

--
-- Структура таблиці `tbl_tech_kaf_folder`
--

CREATE TABLE IF NOT EXISTS `tbl_tech_kaf_folder` (
  `kaf_id` int(11) NOT NULL AUTO_INCREMENT,
  `kaf_name` varchar(100) CHARACTER SET cp1251 DEFAULT NULL,
  `kaf_name_engl` varchar(30) NOT NULL DEFAULT '',
  `kaf_type` varchar(10) DEFAULT NULL,
  KEY `kaf_id` (`kaf_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Дамп даних таблиці `tbl_tech_kaf_folder`
--

INSERT INTO `tbl_tech_kaf_folder` (`kaf_id`, `kaf_name`, `kaf_name_engl`, `kaf_type`) VALUES
(4, 'Кафедра фармакологiї з клiнiчними фармакологiєю, фармацiєю та фармакотерапiєю', 'pharmakologia', '1'),
(3, 'Кафедра соцiальної медицин', 'socmedic', '1'),
(5, 'Кафедра медичної біології', 'med_biologia', '1'),
(6, 'Кафедра педіатрії ФПО', 'pediatria_fpo', '2'),
(7, 'Кафедра медичної iнформатики', 'informatika', '1'),
(9, 'Кафедра загальної гiгiєни та екологiї', 'hihiena', '1'),
(10, 'Кафедра педiатрiї', 'pediatria', '2'),
(11, 'Кафедра aкушерства та гiнекологiї', 'obsretr_fpo', '2'),
(12, 'Кафедра гiстологiї та ембрiологiї', 'histolog', '1'),
(13, 'Кафедра медичної бiохiмiї ', 'chemistry', '1'),
(14, 'Кафедра анатомiї людини', 'anatomy', '1'),
(15, 'Кафедра патологiчної анатомiї з секцiйним курсом та судовою медициною', 'patologanatom', '1'),
(17, 'Кафедра нормальної фiзiологiї', 'fisiol', '1'),
(18, 'Кафедра хiрургiї №1', 'hospital_surgery', '2'),
(19, 'Кафедра медичної реабiлiтацiї та спортивної медицини', 'sport_medic', '2'),
(20, 'Кафедра пропедевтики внутрiшньої медицини та фтизiатрiї', 'propedeutic_vn_des', '2'),
(21, 'Кафедра внутрiшньої медицини №1', 'vn_med_alerg', '2'),
(23, 'Кафедра iнфекцiйних хвороб з епiдемiологiєю, шкiрними та венеричними хворобами', 'infect_desease', '2'),
(24, 'Кафедра неврологiї, психiатрiї, наркологiї та медичної психологiї', 'nervous_desease', '2'),
(25, 'Кафедра oперативної хірургії та топографічної анатомії ', 'xirtop', '2'),
(26, 'Кафедра патологiчної фiзiологiї', 'patolog_phis', '1'),
(27, 'Кафедра медицини катастроф та військової медицини ', 'med_catastrof', '1'),
(28, 'Кафедра клiнiчної iмунологiї, алергологiї та загального догляду за хворими ', 'meds', '2'),
(29, 'Кафедра первинної медико-санітарної допомоги та сімейної медицини ', 'policlin', '2'),
(30, 'Кафедра оториноларингологiї, офтальмологiї та нейрохiрургiї', 'lor', '2'),
(31, 'Кафедра акушерства та гiнекологiї', 'obsretr_fpo', '2'),
(32, 'Кафедра oнкологiї, променевої дiагностики i терапiї та радiацiйної медицини', 'onkologia', '2'),
(33, 'Кафедра xiрургiї', 'hir_fpo', '2'),
(34, 'Кафедра фармацевтичних дисциплiн', 'farmdysc', '1'),
(35, 'Кафедра фармацевтичної хiмiї', 'pharma_2', '1'),
(36, 'Кафедра фармакогнозiї з медичною ботанiкою', 'pharma_1', '1'),
(37, 'Кафедра ортопедичної стоматологiї', 'stomat_ortop', '2'),
(38, 'Кафедра дитячої стоматологiї', 'stomat_ter_dit', '2'),
(39, 'Кафедра хiрургічної стоматологiї', 'stomat_hir', '2'),
(40, 'Кафедра терапiї i сiмейної медицини', 'therapy_fpo', '2'),
(41, 'Кафедра медицини невiдкладних станiв', 'nevidkl', '2'),
(42, 'Кафедра дiагностики та медичної iнформатики', 'diahn', '2'),
(44, 'Кафедра клінічної фармації', 'klinpharm', '1'),
(45, 'Кафедра філософії та суспільних дисциплін ', 'philosophy', '1'),
(46, 'Кафедра хiрургiї з анестезiологiєю №2', 'surgery2', '2'),
(47, 'Кафедра педiатрiї №2', 'pediatria2', '2'),
(48, 'Кафедра акушерства та гінекології №2', 'ginecology2', '2'),
(49, 'Кафедра внутрішньої медицини №2', 'vnutrmed2', '2'),
(52, 'Кафедра ендоскопії з малоінвазивною хірургією, урологією, ортопедією та травматологією', 'endoscop_fpo', '2'),
(53, 'Кафедра терапевтичної стоматологiї', 'stomat_ter', '2'),
(55, 'Кафедра мікробіології, вірусології та імунології', 'micbio', '1'),
(56, 'Кафедра клiнiко-лабораторної дiагностики', 'clinlab', '1'),
(57, 'Кафедра внутрiшньої медицини №3', 'vn_med_al', '2'),
(59, 'Кафедра українознавства ', 'sus_dusct', '1'),
(61, 'Кафедра іноземних мов з медичної термінологією', 'in_mow', '1'),
(63, 'Кафедра медичної фізики та медичного обладнання', 'biofiz', '1'),
(62, 'Кафедра медичної біоетики та деонтології', 'deontologi', '1'),
(64, 'Кафедра функціональної діагностики та клінічної патофізіології ', 'klinpat', '1'),
(65, 'Кафедра невідкладної та екстреної медичної допомоги ', 'nev_stan', '1'),
(66, 'Кафедра управління та економіки у фармації', 'upr_ekon', '1'),
(67, 'Кафедра технології ліків', 'tex_lik', '1'),
(70, 'Кафедра загальної хімії', 'zag_him', '1'),
(69, 'Кафедра медичного права', 'medprav', '1'),
(72, 'Кафедра фізичної реабілітації, здоровя людини та фізичного виховання', 'fiz_reabil', '1'),
(73, 'Кафедра фармації', 'pharm_new', '2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
