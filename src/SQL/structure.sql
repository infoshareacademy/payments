CREATE TABLE `contract` (
  `id` int(11) NOT NULL,
  `companyName` varchar(200) NOT NULL,
  `Signature` varchar(45) NOT NULL,
  `fileName` varchar(45) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL
);

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `id_contract` int(11) DEFAULT NULL,
  `Signature` varchar(255) NOT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `Issue_date` date NOT NULL,
  `Maturity_date` date NOT NULL,
  `Payment_date` datetime DEFAULT NULL
);

CREATE VIEW `payment_report` AS select `invoices`.`Signature` AS `Signature`,`invoices`.`Amount` AS `Amount`,`invoices`.`Maturity_date` AS `Maturity_date`,`invoices`.`Payment_date` AS `Payment_date`,`contract`.`companyName` AS `companyName` from (`invoices` join `contract`) where (`invoices`.`id_contract` = `contract`.`id`) order by `invoices`.`Maturity_date` desc;

CREATE VIEW `exceeded_payment` AS select `payment_report`.`companyName` AS `companyName`,`payment_report`.`Signature` AS `Signature`,`payment_report`.`Amount` AS `Amount`,`payment_report`.`Maturity_date` AS `Maturity_date`,`payment_report`.`Payment_date` AS `Payment_date` from `payment_report` where (`payment_report`.`Payment_date` > `payment_report`.`Maturity_date`) order by `payment_report`.`Payment_date` desc;

