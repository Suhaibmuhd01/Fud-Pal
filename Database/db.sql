-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 12:14 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 
-- Database Fud-Pal
-- 
CREATE TABLE `Student` (
   ` Id` int(10) AUTO_INCREMENT Not Null,
    `Name` VARCHAR(25) NOT NULL Null,
    `Email` VARCHAR(30) NOT NULL Null,
   ` Reg_no `VARCHAR(17) NOT NULL Null,
    Password VARCHAR(16) NOT NULL Null,
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ADMIN TABLE
CREATE TABLE `Admin` (
  `Id` int(11) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Reg_no` varchar(200) NOT NULL,
  `type` enum('admin','member') NOT NULL,
  `Password`varchar(16) NOT NULL,
  `Password`varchar(16) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `Student`
  ADD PRIMARY KEY (`UID`);

ALTER TABLE `Admin`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;