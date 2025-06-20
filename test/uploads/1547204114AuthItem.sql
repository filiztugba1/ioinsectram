-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 05 Kas 2018, 11:44:13
-- Sunucu sürümü: 5.7.24
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ioinsect_one`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `AuthItem`
--

CREATE TABLE `AuthItem` (
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 grup 1 paket 3 izinler',
  `description` text,
  `bizrule` text,
  `data` text,
  `superadmin` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`, `superadmin`) VALUES
('auth.superadmin', 3, NULL, NULL, NULL, 1),
('authorization.create', 3, NULL, NULL, NULL, 1),
('authorization.delete', 3, NULL, NULL, NULL, 1),
('authorization.update', 3, NULL, NULL, NULL, 1),
('authorization.view', 3, NULL, NULL, NULL, 1),
('certificate.create', 3, NULL, NULL, NULL, 1),
('certificate.delete', 3, NULL, NULL, NULL, 1),
('certificate.list', 3, NULL, NULL, NULL, 1),
('certificate.list.view', 3, NULL, NULL, NULL, 1),
('certificate.update', 3, NULL, NULL, NULL, 1),
('client.branch.create', 3, NULL, NULL, NULL, 1),
('client.branch.delete', 3, NULL, NULL, NULL, 1),
('client.branch.department.create', 3, NULL, NULL, NULL, 1),
('client.branch.department.delete', 3, NULL, NULL, NULL, 1),
('client.branch.department.update', 3, NULL, NULL, NULL, 1),
('client.branch.filemanagement.create', 3, NULL, NULL, NULL, 1),
('client.branch.filemanagement.delete', 3, NULL, NULL, NULL, 1),
('client.branch.filemanagement.update', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.create', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.delete', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.location.create', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.location.delete', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.location.update', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.type.create', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.type.delete', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.type.update', 3, NULL, NULL, NULL, 1),
('client.branch.monitoringpoints.update', 3, NULL, NULL, NULL, 1),
('client.branch.offers.create', 3, NULL, NULL, NULL, 1),
('client.branch.offers.delete', 3, NULL, NULL, NULL, 1),
('client.branch.offers.update', 3, NULL, NULL, NULL, 1),
('client.branch.reports.create', 3, NULL, NULL, NULL, 1),
('client.branch.reports.delete', 3, NULL, NULL, NULL, 1),
('client.branch.reports.update', 3, NULL, NULL, NULL, 1),
('client.branch.staff.create', 3, NULL, NULL, NULL, 1),
('client.branch.staff.delete', 3, NULL, NULL, NULL, 1),
('client.branch.staff.update', 3, NULL, NULL, NULL, 1),
('client.branch.update', 3, NULL, NULL, NULL, 1),
('client.child.child.list.view', 3, NULL, NULL, NULL, 0),
('client.child.create', 3, NULL, NULL, NULL, 0),
('client.child.delete', 3, NULL, NULL, NULL, 0),
('client.child.list', 3, NULL, NULL, NULL, 0),
('client.child.list.active', 3, NULL, NULL, NULL, 0),
('client.child.list.view', 3, NULL, NULL, NULL, 0),
('client.child.update', 3, NULL, NULL, NULL, 0),
('client.create', 3, NULL, NULL, NULL, 0),
('client.delete', 3, NULL, NULL, NULL, 0),
('client.list', 3, NULL, NULL, NULL, 0),
('client.list.active', 3, NULL, NULL, NULL, 0),
('client.list.view', 3, NULL, NULL, NULL, 0),
('client.update', 3, NULL, NULL, NULL, 0),
('client.view', 3, NULL, NULL, NULL, 0),
('clientmanagement.create', 3, NULL, NULL, NULL, 1),
('clientmanagement.delete', 3, NULL, NULL, NULL, 1),
('clientmanagement.update', 3, NULL, NULL, NULL, 1),
('clientmanagement.view', 3, NULL, NULL, NULL, 0),
('clients.client.management.view', 3, NULL, NULL, NULL, 0),
('clients.route.identification.view', 3, NULL, NULL, NULL, 0),
('clients.shared.client.management.view', 3, NULL, NULL, NULL, 0),
('Default', 1, NULL, NULL, NULL, 0),
('Default.Admin', 0, NULL, NULL, NULL, 0),
('Default.Branch', 0, NULL, NULL, NULL, 0),
('Default.Branch.Admin', 0, NULL, NULL, NULL, 0),
('Default.Branch.BAdmin', 0, NULL, NULL, NULL, 0),
('Default.Branch.BStaff', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer.CAdmin', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer.CBranch', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer.CBranch.CBAdmin', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer.CBranch.CBStaff', 0, NULL, NULL, NULL, 0),
('Default.Branch.Customer.CStaff', 0, NULL, NULL, NULL, 0),
('Default.Staff', 0, NULL, NULL, NULL, 0),
('documentation.view', 3, NULL, NULL, NULL, 0),
('documentation2.view', 3, NULL, NULL, NULL, 0),
('documentcategory.crete', 3, NULL, NULL, NULL, 1),
('documentcategory.delete', 3, NULL, NULL, NULL, 1),
('documentcategory.update', 3, NULL, NULL, NULL, 1),
('documentcategory.view', 3, NULL, NULL, NULL, 1),
('documents.create', 3, NULL, NULL, NULL, 1),
('documents.delete', 3, NULL, NULL, NULL, 1),
('documents.update', 3, NULL, NULL, NULL, 1),
('documents.view', 3, NULL, NULL, NULL, 1),
('education.create', 3, NULL, NULL, NULL, 1),
('education.delete', 3, NULL, NULL, NULL, 1),
('education.list', 3, NULL, NULL, NULL, 1),
('education.list.view', 3, NULL, NULL, NULL, 1),
('education.update', 3, NULL, NULL, NULL, 1),
('education.view', 3, NULL, NULL, NULL, 1),
('firm.branch.create', 3, NULL, NULL, NULL, 1),
('firm.branch.delete', 3, NULL, NULL, NULL, 1),
('firm.branch.update', 3, NULL, NULL, NULL, 1),
('firm.branch.view', 3, NULL, NULL, NULL, 1),
('firm.create', 3, NULL, NULL, NULL, 1),
('firm.delete', 3, NULL, NULL, NULL, 1),
('firm.list', 3, NULL, NULL, NULL, 1),
('firm.list.active', 3, NULL, NULL, NULL, 1),
('firm.list.view', 3, NULL, NULL, NULL, 1),
('firm.staff.create', 3, NULL, NULL, NULL, 1),
('firm.staff.delete', 3, NULL, NULL, NULL, 1),
('firm.staff.update', 3, NULL, NULL, NULL, 1),
('firm.staff.view', 3, NULL, NULL, NULL, 1),
('firm.update', 3, NULL, NULL, NULL, 1),
('firm.view', 3, NULL, NULL, NULL, 1),
('generalsettings.create', 3, NULL, NULL, NULL, 1),
('generalsettings.delete', 3, NULL, NULL, NULL, 1),
('generalsettings.update', 3, NULL, NULL, NULL, 1),
('generalsettings.view', 3, NULL, NULL, NULL, 0),
('Homepage', 3, NULL, NULL, NULL, 1),
('Homepage.create', 3, NULL, NULL, NULL, 1),
('Homepage.delete', 3, NULL, NULL, NULL, 1),
('homepage.permission', 3, NULL, NULL, NULL, 1),
('homepage.update', 3, NULL, NULL, NULL, 1),
('homepage.view', 3, NULL, NULL, NULL, 0),
('languages.create', 3, NULL, NULL, NULL, 1),
('languages.delete', 3, NULL, NULL, NULL, 1),
('languages.list', 3, NULL, NULL, NULL, 1),
('languages.list.view', 3, NULL, NULL, NULL, 1),
('languages.update', 3, NULL, NULL, NULL, 1),
('languages.view', 3, NULL, NULL, NULL, 1),
('location.create', 3, NULL, NULL, NULL, 1),
('location.delete', 3, NULL, NULL, NULL, 1),
('location.list', 3, NULL, NULL, NULL, 1),
('location.list.view', 3, NULL, NULL, NULL, 1),
('location.update', 3, NULL, NULL, NULL, 1),
('location.view', 3, NULL, NULL, NULL, 1),
('logs.list.view', 3, NULL, NULL, NULL, 1),
('managalanguages.create', 3, NULL, NULL, NULL, 1),
('managalanguages.delete', 3, NULL, NULL, NULL, 1),
('managalanguages.update', 3, NULL, NULL, NULL, 1),
('managalanguages.view', 3, NULL, NULL, NULL, 1),
('newsupport.create', 3, NULL, NULL, NULL, 1),
('newsupport.delete', 3, NULL, NULL, NULL, 1),
('newsupport.update', 3, NULL, NULL, NULL, 1),
('newsupport.view', 3, NULL, NULL, NULL, 1),
('nonconformitymanagement.create', 3, NULL, NULL, NULL, 1),
('nonconformitymanagement.delete', 3, NULL, NULL, NULL, 1),
('nonconformitymanagement.update', 3, NULL, NULL, NULL, 1),
('nonconformitymanagement.view', 3, NULL, NULL, NULL, 1),
('nonconformitystatus.create', 3, NULL, NULL, NULL, 1),
('nonconformitystatus.delete', 3, NULL, NULL, NULL, 1),
('nonconformitystatus.update', 3, NULL, NULL, NULL, 1),
('nonconformitystatus.view', 3, NULL, NULL, NULL, 1),
('nonconformitytype.create', 3, NULL, NULL, NULL, 1),
('nonconformitytype.delete', 3, NULL, NULL, NULL, 1),
('nonconformitytype.update', 3, NULL, NULL, NULL, 1),
('nonconformitytype.view', 3, NULL, NULL, NULL, 1),
('Package1', 1, NULL, NULL, NULL, 0),
('Package1.Default', 0, NULL, NULL, NULL, 0),
('Package1.Default.Admin', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Admin', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.BAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.BStaff', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer.CAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer.CBranch', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer.CBranch.CBAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer.CBranch.CBStaff', 0, NULL, NULL, NULL, 0),
('Package1.Default.Branch.Customer.CStaff', 0, NULL, NULL, NULL, 0),
('Package1.Default.Staff', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Admin', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Admin', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.BAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.BStaff', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer.CAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer.CBranch', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer.CBranch.CBAdmin', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer.CBranch.CBStaff', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Branch.Customer.CStaff', 0, NULL, NULL, NULL, 0),
('Package1.Safrangroup.Staff', 0, NULL, NULL, NULL, 0),
('packages.create', 3, NULL, NULL, NULL, 1),
('packages.delele', 3, NULL, NULL, NULL, 1),
('packages.update', 3, NULL, NULL, NULL, 1),
('packages.view', 3, NULL, NULL, NULL, 1),
('qality.create', 3, NULL, NULL, NULL, 1),
('qality.delete', 3, NULL, NULL, NULL, 1),
('qality.update', 3, NULL, NULL, NULL, 1),
('qality.view', 3, NULL, NULL, NULL, 1),
('quality.nonconformity.management.view', 3, NULL, NULL, NULL, 0),
('reports.create', 3, NULL, NULL, NULL, 1),
('reports.delete', 3, NULL, NULL, NULL, 1),
('reports.update', 3, NULL, NULL, NULL, 1),
('reports.view', 3, NULL, NULL, NULL, 1),
('reports.workorderlist.view', 3, NULL, NULL, NULL, 0),
('sector.create', 3, NULL, NULL, NULL, 1),
('sector.delete', 3, NULL, NULL, NULL, 1),
('sector.list', 3, NULL, NULL, NULL, 1),
('sector.list.active', 3, NULL, NULL, NULL, 1),
('sector.list.view', 3, NULL, NULL, NULL, 1),
('sector.update', 3, NULL, NULL, NULL, 1),
('sector.view', 3, NULL, NULL, NULL, 1),
('settings.authorization.view', 3, NULL, NULL, NULL, 0),
('settings.create', 3, NULL, NULL, NULL, 1),
('settings.delete', 3, NULL, NULL, NULL, 1),
('settings.update', 3, NULL, NULL, NULL, 1),
('settings.view', 3, NULL, NULL, NULL, 1),
('staff.create', 3, NULL, NULL, NULL, 1),
('staff.delete', 3, NULL, NULL, NULL, 1),
('staff.staff.registration.view', 3, NULL, NULL, NULL, 0),
('staff.team.registration.view', 3, NULL, NULL, NULL, 0),
('staff.update', 3, NULL, NULL, NULL, 1),
('staff.view', 3, NULL, NULL, NULL, 1),
('Superadmin', 0, NULL, NULL, NULL, 0),
('support.allsupports.view', 3, NULL, NULL, NULL, 0),
('support.create', 3, NULL, NULL, NULL, 1),
('support.delete', 3, NULL, NULL, NULL, 1),
('support.newsupports.view', 3, NULL, NULL, NULL, 0),
('support.update', 3, NULL, NULL, NULL, 1),
('support.view', 3, NULL, NULL, NULL, 1),
('transfer.staff', 3, NULL, NULL, NULL, 0),
('transferlink.create', 3, NULL, NULL, NULL, 1),
('transferlink.delete', 3, NULL, NULL, NULL, 1),
('transferlink.update', 3, NULL, NULL, NULL, 1),
('transferlink.view', 3, NULL, NULL, NULL, 0),
('translate.create', 3, NULL, NULL, NULL, 1),
('translate.delete', 3, NULL, NULL, NULL, 1),
('translate.language.list.view', 3, NULL, NULL, NULL, 0),
('translate.list.view', 3, NULL, NULL, NULL, 0),
('translate.update', 3, NULL, NULL, NULL, 1),
('translate.view', 3, NULL, NULL, NULL, 1),
('user.create', 3, NULL, NULL, NULL, 0),
('user.delete', 3, NULL, NULL, NULL, 0),
('user.detail', 3, NULL, NULL, NULL, 0),
('user.list', 3, NULL, NULL, NULL, 0),
('user.list.active', 3, NULL, NULL, NULL, 0),
('user.list.view', 3, NULL, NULL, NULL, 0),
('user.update', 3, NULL, NULL, NULL, 0),
('userinfo.create', 3, NULL, NULL, NULL, 0),
('userinfo.update', 3, NULL, NULL, NULL, 0),
('workorder.create', 3, NULL, NULL, NULL, 1),
('workorder.delete', 3, NULL, NULL, NULL, 1),
('workorder.list.view', 3, NULL, NULL, NULL, 0),
('workorder.update', 3, NULL, NULL, NULL, 1),
('workorderlist.create', 3, NULL, NULL, NULL, 1),
('workorderlist.delete', 3, NULL, NULL, NULL, 1),
('workorderlist.update', 3, NULL, NULL, NULL, 1),
('workorderlist.view', 3, NULL, NULL, NULL, 1);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `AuthItem`
--
ALTER TABLE `AuthItem`
  ADD PRIMARY KEY (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
