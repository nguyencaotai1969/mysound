-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th6 25, 2022 lúc 04:08 AM
-- Phiên bản máy phục vụ: 5.7.24
-- Phiên bản PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mymuzik`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_blocked_ips`
--

CREATE TABLE `_blocked_ips` (
  `ID` int(11) NOT NULL,
  `IP` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `until` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reason` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_curl_cache`
--

CREATE TABLE `_curl_cache` (
  `ID` int(11) NOT NULL,
  `hashID` varchar(64) COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(400) COLLATE utf8mb4_bin NOT NULL,
  `options` mediumtext COLLATE utf8mb4_bin,
  `request_body` mediumtext COLLATE utf8mb4_bin,
  `request_header` text COLLATE utf8mb4_bin,
  `response_body` longtext COLLATE utf8mb4_bin,
  `response_header` text COLLATE utf8mb4_bin,
  `time_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_debug`
--

CREATE TABLE `_debug` (
  `ID` int(11) NOT NULL,
  `table` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `type` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `query` longtext COLLATE utf8mb4_bin,
  `safe` int(1) DEFAULT '0',
  `generic` int(1) DEFAULT '0',
  `time_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_emails`
--

CREATE TABLE `_emails` (
  `ID` int(6) NOT NULL,
  `user_id` int(7) DEFAULT NULL,
  `type_id` int(3) DEFAULT NULL,
  `to` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `subject` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `content` text COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_emails`
--

INSERT INTO `_emails` (`ID`, `user_id`, `type_id`, `to`, `subject`, `content`, `time_add`) VALUES
(1, 1, 67, 'admnin', 'New user', NULL, '2022-06-25 02:24:55'),
(2, 4, 17, 'wifoho6246@serosin.com', 'Welcome message', NULL, '2022-06-25 02:24:55'),
(3, 1, 74, 'admnin', 'New upload', NULL, '2022-06-25 02:57:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_hits`
--

CREATE TABLE `_hits` (
  `ID` int(11) NOT NULL,
  `page_type` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `page_hook` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `request_url` text COLLATE utf8mb4_bin,
  `request_sessid` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `request_cookies` mediumtext COLLATE utf8mb4_bin,
  `request_posts` mediumtext COLLATE utf8mb4_bin,
  `request_params` mediumtext COLLATE utf8mb4_bin,
  `ip` varchar(15) COLLATE utf8mb4_bin DEFAULT NULL,
  `ip_country` varchar(2) COLLATE utf8mb4_bin DEFAULT NULL,
  `agent` tinytext COLLATE utf8mb4_bin,
  `agent_model` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `agent_type` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `agent_os` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `agent_browser` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `agent_engine` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `referer` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `referer_full` mediumtext COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_hits`
--

INSERT INTO `_hits` (`ID`, `page_type`, `page_hook`, `user_id`, `request_url`, `request_sessid`, `request_cookies`, `request_posts`, `request_params`, `ip`, `ip_country`, `agent`, `agent_model`, `agent_type`, `agent_os`, `agent_browser`, `agent_engine`, `referer`, `referer_full`, `time_add`) VALUES
(5, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'm0ocvei0hsufibefdh8rnfq0q9', '{\"PHPSESSID\":\"m0ocvei0hsufibefdh8rnfq0q9\",\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:09:29'),
(6, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'm0ocvei0hsufibefdh8rnfq0q9', '{\"PHPSESSID\":\"m0ocvei0hsufibefdh8rnfq0q9\",\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:09:38'),
(7, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'm0ocvei0hsufibefdh8rnfq0q9', '{\"PHPSESSID\":\"m0ocvei0hsufibefdh8rnfq0q9\",\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:09:38'),
(8, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'm0ocvei0hsufibefdh8rnfq0q9', '{\"PHPSESSID\":\"m0ocvei0hsufibefdh8rnfq0q9\",\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:09:44'),
(9, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'm0ocvei0hsufibefdh8rnfq0q9', '{\"PHPSESSID\":\"m0ocvei0hsufibefdh8rnfq0q9\",\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:09:44'),
(10, 'page', 1, 2, 'http://dev.mymuzik.com/', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:10:03'),
(11, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:10:10'),
(12, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"ID\":\"235b6148ce8a64ca9740\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-24 11:10:24'),
(13, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"ID\":\"235b6148ce8a64ca9740\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=235b6148ce8a64ca9740', '2022-06-24 11:13:05'),
(14, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"ID\":\"235b6148ce8a64ca9740\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=235b6148ce8a64ca9740', '2022-06-24 11:13:07'),
(15, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"ID\":\"235b6148ce8a64ca9740\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=235b6148ce8a64ca9740', '2022-06-24 11:13:11'),
(16, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"ID\":\"235b6148ce8a64ca9740\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=235b6148ce8a64ca9740', '2022-06-24 11:13:36'),
(17, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=235b6148ce8a64ca9740', '2022-06-24 11:13:46'),
(18, '404', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:14:09'),
(19, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:14:12'),
(20, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai/uploads', '2022-06-24 11:14:27'),
(21, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-24 11:14:41'),
(22, '404', 1, 2, 'http://dev.mymuzik.com/track/wavesurfer.js.map', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:14:49'),
(23, 'user_setting', NULL, 2, 'http://dev.mymuzik.com/user_setting', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-24 11:20:02'),
(24, 'user_setting', NULL, 2, 'http://dev.mymuzik.com/user_setting', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '{\"n\":\"feed_setting\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_setting', '2022-06-24 11:20:04'),
(25, '404', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:20:19'),
(26, '404', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:21:15'),
(27, 'page', 1, 2, 'http://dev.mymuzik.com/', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:22:19'),
(28, 'user_reposts', NULL, 2, 'http://dev.mymuzik.com/user_reposts', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZ1dWlkPTE2NTYwNjQwNjQuMDQ5NzMyMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMDk6NDc6NDQiLDMsIjE2NTYwNjQwNjQuMDQ5NzMyOTQyOCIsMzI5LG51bGwsbnVsbF0:1o4ghR:VXKIP9b4OTxE3zCUajqVbYtA4wQ\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:23:21'),
(29, 'user_reposts', NULL, 2, 'http://dev.mymuzik.com/user_reposts', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:23:55'),
(30, 'user_logout', NULL, 2, 'http://dev.mymuzik.com/user_logout', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_reposts', '2022-06-24 11:24:04'),
(31, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_logout', '2022-06-24 11:24:05'),
(32, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:24:07'),
(33, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:24:08'),
(34, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:24:11'),
(35, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:24:12'),
(36, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:27:57'),
(37, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'g1psjid7nf4u3jco7cc6ih3ekg', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"g1psjid7nf4u3jco7cc6ih3ekg\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:27:57'),
(38, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:30:05'),
(39, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:30:24'),
(40, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:30:30'),
(41, 'no_access', NULL, 2, 'http://dev.mymuzik.com/user_login', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:34:57'),
(42, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:34:59'),
(43, '404', 1, 2, 'http://dev.mymuzik.com/admin-cp', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"__stripe_mid\":\"6bc592b4-d55a-4381-880f-1e837670979d51462b\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:35:02'),
(44, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:35:05'),
(45, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-24 11:35:11'),
(46, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:36:02'),
(47, 'admin_theme_setting', NULL, 2, 'http://dev.mymuzik.com/admin_theme_setting', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-24 11:36:17'),
(48, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:37:22'),
(49, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:44:33'),
(50, 'user_likes', NULL, 2, 'http://dev.mymuzik.com/user_likes', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:44:50'),
(51, 'user_feed', NULL, 2, 'http://dev.mymuzik.com/user_feed', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_likes', '2022-06-24 11:44:56'),
(52, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_feed', '2022-06-24 11:45:01'),
(53, 'admin_page_editor', NULL, 2, 'http://dev.mymuzik.com/admin_page_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_theme_setting', '2022-06-24 11:47:12'),
(54, 'admin_menu_editor', NULL, 2, 'http://dev.mymuzik.com/admin_menu_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_page_editor', '2022-06-24 11:47:18'),
(55, 'admin_language_editor', NULL, 2, 'http://dev.mymuzik.com/admin_language_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_menu_editor', '2022-06-24 11:47:22');
INSERT INTO `_hits` (`ID`, `page_type`, `page_hook`, `user_id`, `request_url`, `request_sessid`, `request_cookies`, `request_posts`, `request_params`, `ip`, `ip_country`, `agent`, `agent_model`, `agent_type`, `agent_os`, `agent_browser`, `agent_engine`, `referer`, `referer_full`, `time_add`) VALUES
(56, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:47:35'),
(57, 'admin_theme_setting', NULL, 2, 'http://dev.mymuzik.com/admin_theme_setting', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_language_editor', '2022-06-24 11:50:12'),
(58, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:50:40'),
(59, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-24 11:50:47'),
(60, 'artist', 1, 2, 'http://dev.mymuzik.com/artist/miu_lê', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:50:50'),
(61, 'admin_content_genres', NULL, 2, 'http://dev.mymuzik.com/admin_content_genres', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_theme_setting', '2022-06-24 11:51:02'),
(62, 'admin_user_artist_reqs', NULL, 2, 'http://dev.mymuzik.com/admin_user_artist_reqs', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_content_genres', '2022-06-24 11:51:09'),
(63, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_artist_reqs', '2022-06-24 11:51:12'),
(64, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"GID\":\"1\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups', '2022-06-24 11:51:15'),
(65, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups?gid=1', '2022-06-24 11:51:34'),
(66, 'admin_user_artist_reqs', NULL, 2, 'http://dev.mymuzik.com/admin_user_artist_reqs', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups', '2022-06-24 11:51:39'),
(67, 'admin_users', NULL, 2, 'http://dev.mymuzik.com/admin_users', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_artist_reqs', '2022-06-24 11:51:41'),
(68, '404', 1, 2, 'http://dev.mymuzik.com/admnin', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_users', '2022-06-24 11:51:42'),
(69, 'admin_users', NULL, 2, 'http://dev.mymuzik.com/admin_users', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_users', '2022-06-24 11:52:16'),
(70, '404', 1, 2, 'http://dev.mymuzik.com/admnin', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_users', '2022-06-24 11:52:17'),
(71, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/artist/miu_l%c3%aa', '2022-06-24 11:52:37'),
(72, 'user_feed', NULL, 2, 'http://dev.mymuzik.com/user_feed', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:52:43'),
(73, 'user', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_feed', '2022-06-24 11:52:46'),
(74, 'user_feed', NULL, 2, 'http://dev.mymuzik.com/user_feed', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai', '2022-06-24 11:52:48'),
(75, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_feed', '2022-06-24 11:52:50'),
(76, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-24 11:52:53'),
(77, 'page', 6, 2, 'http://dev.mymuzik.com/trending', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-24 11:52:58'),
(78, 'page', 3, 2, 'http://dev.mymuzik.com/albums', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-24 11:53:00'),
(79, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/albums', '2022-06-24 11:53:04'),
(80, 'page', 5, 2, 'http://dev.mymuzik.com/artists', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-24 11:53:06'),
(81, 'genre', NULL, 2, 'http://dev.mymuzik.com/genres', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/artists', '2022-06-24 11:53:07'),
(82, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_users', '2022-06-24 11:53:12'),
(83, 'admin_setting_api', NULL, 2, 'http://dev.mymuzik.com/admin_setting_api', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-24 11:53:15'),
(84, 'admin_setting_sessions', NULL, 2, 'http://dev.mymuzik.com/admin_setting_sessions', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_api', '2022-06-24 11:53:36'),
(85, 'admin_setting_email', NULL, 2, 'http://dev.mymuzik.com/admin_setting_email', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_sessions', '2022-06-24 11:53:42'),
(86, 'genre', NULL, NULL, 'http://dev.mymuzik.com/genres', 'ib6d0vf61a7gralgc30aedh5vc', '[]', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-24 11:55:29'),
(87, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'ib6d0vf61a7gralgc30aedh5vc', '{\"PHPSESSID\":\"ib6d0vf61a7gralgc30aedh5vc\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/genres', '2022-06-24 11:55:42'),
(88, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'ib6d0vf61a7gralgc30aedh5vc', '{\"PHPSESSID\":\"ib6d0vf61a7gralgc30aedh5vc\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/genres', '2022-06-24 11:55:43'),
(89, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'ib6d0vf61a7gralgc30aedh5vc', '{\"PHPSESSID\":\"ib6d0vf61a7gralgc30aedh5vc\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:55:47'),
(90, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'ib6d0vf61a7gralgc30aedh5vc', '{\"PHPSESSID\":\"ib6d0vf61a7gralgc30aedh5vc\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-24 11:55:47'),
(91, 'page', 1, 3, 'http://dev.mymuzik.com/', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-24 11:56:05'),
(92, 'admin_setting_api', NULL, 2, 'http://dev.mymuzik.com/admin_setting_api', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_email', '2022-06-24 11:56:54'),
(93, 'admin_setting_email', NULL, 2, 'http://dev.mymuzik.com/admin_setting_email', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_api', '2022-06-24 11:56:58'),
(94, 'admin_setting_social_login', NULL, 2, 'http://dev.mymuzik.com/admin_setting_social_login', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_email', '2022-06-24 11:57:04'),
(95, 'admin_tools_auto_translate', NULL, 2, 'http://dev.mymuzik.com/admin_tools_auto_translate', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_social_login', '2022-06-24 11:57:14'),
(96, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.com/admin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"mtm_delivered\":\"WyJteW11emlrLmNvbSIsImh0dHA6Ly93d3c2Lm15bXV6aWsuY29tLz90ZW1wbGF0ZT1BUlJPV18zJnRkZnM9MSZzX3Rva2VuPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZ1dWlkPTE2NTYwNjk4MjYuMDIxMDkwMDAwMCZzZWFyY2hib3g9MSZzaG93RG9tYWluPTEiLDEsIjIwMjItMDYtMjQgMTE6MjM6NDYiLDEsIjE2NTYwNjk4MjYuMDIxMDkwMDAwMCIsMzI5LG51bGwsbnVsbF0:1o4hPe:PlboLoKKKQWBEnNYdKBFXEDyNOY\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_tools_auto_translate', '2022-06-24 11:57:34'),
(97, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.com/admin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_tools_auto_translate', '2022-06-25 01:39:52'),
(98, '404', 1, 2, 'http://dev.mymuzik.com/favicon.ico', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_download', '2022-06-25 01:39:52'),
(99, 'genre', NULL, 2, 'http://dev.mymuzik.com/genres', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:39:56'),
(100, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/genres', '2022-06-25 01:39:58'),
(101, 'page', 6, 2, 'http://dev.mymuzik.com/trending', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 01:40:29'),
(102, 'page', 3, 2, 'http://dev.mymuzik.com/albums', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-25 01:40:31'),
(103, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/albums', '2022-06-25 01:40:33'),
(104, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 01:40:35'),
(105, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 01:40:42'),
(106, 'user_followers', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/followers', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai/uploads', '2022-06-25 01:46:19'),
(107, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai/followers', '2022-06-25 01:46:24'),
(108, '404', 1, 2, 'http://dev.mymuzik.com/favicon.ico', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"__stripe_mid\":\"6bc592b4-d55a-4381-880f-1e837670979d51462b\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'https://dev.mymuzik.com/themes/__default/assets/icons/artist.png', '2022-06-25 01:48:12'),
(109, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.comadmin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:50:22'),
(110, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.comadmin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:51:57'),
(111, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.com/admin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:52:12'),
(112, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.com/admin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:52:32'),
(113, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:52:35'),
(114, 'page', 6, 2, 'http://dev.mymuzik.com/trending', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 01:52:42'),
(115, 'artist', 1, 2, 'http://dev.mymuzik.com/artist/miu_lê', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-25 01:52:56'),
(116, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/artist/miu_l%c3%aa', '2022-06-25 01:53:09'),
(117, 'artist', 1, 2, 'http://dev.mymuzik.com/artist/miu_lê', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/artist/miu_l%c3%aa', '2022-06-25 01:53:19'),
(118, 'page', 6, 2, 'http://dev.mymuzik.com/trending', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-25 01:53:20');
INSERT INTO `_hits` (`ID`, `page_type`, `page_hook`, `user_id`, `request_url`, `request_sessid`, `request_cookies`, `request_posts`, `request_params`, `ip`, `ip_country`, `agent`, `agent_model`, `agent_type`, `agent_os`, `agent_browser`, `agent_engine`, `referer`, `referer_full`, `time_add`) VALUES
(119, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 01:53:20'),
(120, 'admin_setting_download', NULL, 2, 'http://dev.mymuzik.com/admin_setting_download', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 01:53:21'),
(121, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_download', '2022-06-25 01:57:24'),
(122, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 01:57:35'),
(123, 'admin_user_artist_reqs', NULL, 2, 'http://dev.mymuzik.com/admin_user_artist_reqs', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups', '2022-06-25 01:57:39'),
(124, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 01:57:42'),
(125, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"GID\":\"1\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups', '2022-06-25 01:57:44'),
(126, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups?gid=1', '2022-06-25 01:57:58'),
(127, 'admin_page_editor', NULL, 2, 'http://dev.mymuzik.com/admin_page_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 01:58:07'),
(128, 'admin_page_editor', NULL, 2, 'http://dev.mymuzik.com/admin_page_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"name\":\"store\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_page_editor', '2022-06-25 01:58:13'),
(129, 'admin_theme_setting', NULL, 2, 'http://dev.mymuzik.com/admin_theme_setting', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_page_editor?name=store', '2022-06-25 01:58:28'),
(130, 'admin_menu_editor', NULL, 2, 'http://dev.mymuzik.com/admin_menu_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_theme_setting', '2022-06-25 01:58:40'),
(131, 'admin_language_editor', NULL, 2, 'http://dev.mymuzik.com/admin_language_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_menu_editor', '2022-06-25 01:58:42'),
(132, 'admin_theme_setting', NULL, 2, 'http://dev.mymuzik.com/admin_theme_setting', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_language_editor', '2022-06-25 01:58:48'),
(133, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_theme_setting', '2022-06-25 01:58:54'),
(134, 'admin_setting_email', NULL, 2, 'http://dev.mymuzik.com/admin_setting_email', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-25 01:59:04'),
(135, 'admin_setting_notifications', NULL, 2, 'http://dev.mymuzik.com/admin_setting_notifications', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_email', '2022-06-25 01:59:12'),
(136, 'admin_setting_programs', NULL, 2, 'http://dev.mymuzik.com/admin_setting_programs', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_notifications', '2022-06-25 01:59:26'),
(137, 'admin_tools_cleaner', NULL, 2, 'http://dev.mymuzik.com/admin_tools_cleaner', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_programs', '2022-06-25 01:59:47'),
(138, 'page', 1, 3, 'http://dev.mymuzik.com/', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:04:50'),
(139, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_tools_cleaner', '2022-06-25 02:06:52'),
(140, 'admin_user_payments', NULL, 2, 'http://dev.mymuzik.com/admin_user_payments', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:06:56'),
(141, 'admin_user_transactions', NULL, 2, 'http://dev.mymuzik.com/admin_user_transactions', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_payments', '2022-06-25 02:07:01'),
(142, 'admin_user_withdraws', NULL, 2, 'http://dev.mymuzik.com/admin_user_withdraws', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_transactions', '2022-06-25 02:07:04'),
(143, 'admin_language_editor', NULL, 2, 'http://dev.mymuzik.com/admin_language_editor', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_withdraws', '2022-06-25 02:07:07'),
(144, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_language_editor', '2022-06-25 02:07:09'),
(145, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:07:21'),
(146, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:07:37'),
(147, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"62b74fd0dec79b8cbc13\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:07:50'),
(148, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"62b74fd0dec79b8cbc13\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=62b74fd0dec79b8cbc13', '2022-06-25 02:07:53'),
(149, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:09:31'),
(150, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:09:31'),
(151, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_language_editor', '2022-06-25 02:09:32'),
(152, 'admin_user_payments', NULL, 2, 'http://dev.mymuzik.com/admin_user_payments', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:09:38'),
(153, 'admin_user_withdraws', NULL, 2, 'http://dev.mymuzik.com/admin_user_withdraws', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_payments', '2022-06-25 02:09:41'),
(154, 'admin_user_withdraws', NULL, 2, 'http://dev.mymuzik.com/admin_user_withdraws', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_withdraws', '2022-06-25 02:09:42'),
(155, 'admin_user_ads', NULL, 2, 'http://dev.mymuzik.com/admin_user_ads', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_withdraws', '2022-06-25 02:09:44'),
(156, 'admin_setting_pay', NULL, 2, 'http://dev.mymuzik.com/admin_setting_pay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_ads', '2022-06-25 02:10:40'),
(157, 'admin_setting_upload', NULL, 2, 'http://dev.mymuzik.com/admin_setting_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_pay', '2022-06-25 02:11:11'),
(158, 'admin_setting_upload_aws', NULL, 2, 'http://dev.mymuzik.com/admin_setting_upload_aws', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_upload', '2022-06-25 02:11:50'),
(159, 'admin_tools_bot_runner', NULL, 2, 'http://dev.mymuzik.com/admin_tools_bot_runner', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_upload_aws', '2022-06-25 02:12:02'),
(160, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_tools_bot_runner', '2022-06-25 02:12:05'),
(161, 'admin_content_genres', NULL, 2, 'http://dev.mymuzik.com/admin_content_genres', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:12:09'),
(162, 'admin_content_artists', NULL, 2, 'http://dev.mymuzik.com/admin_content_artists', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_content_genres', '2022-06-25 02:12:17'),
(163, 'admin_user_groups', NULL, 2, 'http://dev.mymuzik.com/admin_user_groups', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_content_artists', '2022-06-25 02:12:30'),
(164, 'admin_user_payments', NULL, 2, 'http://dev.mymuzik.com/admin_user_payments', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_groups', '2022-06-25 02:12:34'),
(165, 'admin_theme_setting', NULL, 2, 'http://dev.mymuzik.com/admin_theme_setting', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_user_payments', '2022-06-25 02:12:38'),
(166, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_theme_setting', '2022-06-25 02:12:42'),
(167, 'admin_setting_social_login', NULL, 2, 'http://dev.mymuzik.com/admin_setting_social_login', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-25 02:12:55'),
(168, 'admin_setting_notifications', NULL, 2, 'http://dev.mymuzik.com/admin_setting_notifications', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_social_login', '2022-06-25 02:13:05'),
(169, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_notifications', '2022-06-25 02:13:22'),
(170, 'admin_setting_programs', NULL, 2, 'http://dev.mymuzik.com/admin_setting_programs', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:13:38'),
(171, 'admin_tools_bot_runner', NULL, 2, 'http://dev.mymuzik.com/admin_tools_bot_runner', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_programs', '2022-06-25 02:13:45'),
(172, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_tools_bot_runner', '2022-06-25 02:13:49'),
(173, 'admin_content_tracks', NULL, 2, 'http://dev.mymuzik.com/admin_content_tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:13:53'),
(174, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_content_tracks', '2022-06-25 02:14:14'),
(175, 'admin_setting_upload', NULL, 2, 'http://dev.mymuzik.com/admin_setting_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-25 02:14:47'),
(176, 'admin_setting_general', NULL, 2, 'http://dev.mymuzik.com/admin_setting_general', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_upload', '2022-06-25 02:14:54'),
(177, 'admin_setting_upload_aws', NULL, 2, 'http://dev.mymuzik.com/admin_setting_upload_aws', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_general', '2022-06-25 02:15:01'),
(178, 'admin_setting_social_login', NULL, 2, 'http://dev.mymuzik.com/admin_setting_social_login', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_upload_aws', '2022-06-25 02:15:05'),
(179, 'admin_dashboard', NULL, 2, 'http://dev.mymuzik.com/admin_dashboard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_setting_social_login', '2022-06-25 02:15:17'),
(180, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:15:28'),
(181, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:15:48'),
(182, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:15:59'),
(183, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:16:03'),
(184, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:16:26'),
(185, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:23:15'),
(186, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:23:31'),
(187, 'no_access', NULL, NULL, 'http://dev.mymuzik.com/user_upload_edit', '009tlsof4lah2pqedok6hhepbm', '[]', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:23:53'),
(188, 'no_access', NULL, NULL, 'http://dev.mymuzik.com/user_upload_edit', 'uql566075a7p6jp6uavjd7ivcn', '[]', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:23:54'),
(189, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:23:57'),
(190, 'track', 1, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:24:02'),
(191, 'user_uploads', 2, NULL, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 02:24:09'),
(192, 'track', 1, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 02:24:13'),
(193, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 02:24:22'),
(194, 'user_login', NULL, NULL, 'http://dev.mymuzik.com/user_login', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 02:24:23'),
(195, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-25 02:24:43'),
(196, 'user_signup', NULL, NULL, 'http://dev.mymuzik.com/user_signup', 'uql566075a7p6jp6uavjd7ivcn', '{\"PHPSESSID\":\"uql566075a7p6jp6uavjd7ivcn\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_login', '2022-06-25 02:24:44'),
(197, 'page', 1, 4, 'http://dev.mymuzik.com/', 'k1ke1v0ugfh3gsc55qk7mnck1b', '{\"PHPSESSID\":\"k1ke1v0ugfh3gsc55qk7mnck1b\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-25 02:25:00'),
(198, 'user_upload', NULL, 4, 'http://dev.mymuzik.com/user_upload', 'k1ke1v0ugfh3gsc55qk7mnck1b', '{\"PHPSESSID\":\"k1ke1v0ugfh3gsc55qk7mnck1b\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:25:04'),
(199, 'user_upload_edit', NULL, 4, 'http://dev.mymuzik.com/user_upload_edit', 'k1ke1v0ugfh3gsc55qk7mnck1b', '{\"PHPSESSID\":\"k1ke1v0ugfh3gsc55qk7mnck1b\"}', '[]', '{\"ID\":\"18881fe77be79d786619\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:25:22');
INSERT INTO `_hits` (`ID`, `page_type`, `page_hook`, `user_id`, `request_url`, `request_sessid`, `request_cookies`, `request_posts`, `request_params`, `ip`, `ip_country`, `agent`, `agent_model`, `agent_type`, `agent_os`, `agent_browser`, `agent_engine`, `referer`, `referer_full`, `time_add`) VALUES
(200, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:26:43'),
(201, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:26:52'),
(202, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:27:18'),
(203, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:27:39'),
(204, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:28:09'),
(205, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:28:42'),
(206, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:28:53'),
(207, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:29:10'),
(208, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:29:35'),
(209, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:29:58'),
(210, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:30:34'),
(211, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:30:57'),
(212, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:31:09'),
(213, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:31:26'),
(214, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:31:46'),
(215, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:32:07'),
(216, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:32:22'),
(217, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:33:09'),
(218, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:33:56'),
(219, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:35:03'),
(220, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:36:40'),
(221, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:36:42'),
(222, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:38:09'),
(223, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:38:36'),
(224, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:39:12'),
(225, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:41:02'),
(226, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:41:20'),
(227, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:42:50'),
(228, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:43:00'),
(229, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:43:24'),
(230, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"d8d5ab35e802e713ac44\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:43:42'),
(231, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=d8d5ab35e802e713ac44', '2022-06-25 02:43:49'),
(232, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"7420511143e0d656e065\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:44:03'),
(233, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"7420511143e0d656e065\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:44:50'),
(234, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"7420511143e0d656e065\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:45:10'),
(235, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"7420511143e0d656e065\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/admin_dashboard', '2022-06-25 02:45:23'),
(236, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:49:03'),
(237, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:49:10'),
(238, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:49:33'),
(239, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:49:37'),
(240, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:53:10'),
(241, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:53:22'),
(242, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 02:53:34'),
(243, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:54:23'),
(244, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:55:00'),
(245, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:55:12'),
(246, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:56:10'),
(247, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:56:42'),
(248, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:56:53'),
(249, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:56:57'),
(250, 'user_upload_edit', NULL, 2, 'http://dev.mymuzik.com/user_upload_edit', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"ID\":\"bd7862910f1906cda999\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:57:13'),
(251, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload_edit?id=bd7862910f1906cda999', '2022-06-25 02:57:20'),
(252, '404', 1, 2, 'http://dev.mymuzik.com/favicon.ico', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/themes/__default/assets/icons/avatar.png', '2022-06-25 02:57:58'),
(253, 'page', 1, 3, 'http://dev.mymuzik.com/', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 02:58:55'),
(254, 'page', 1, 3, 'http://dev.mymuzik.com/', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-25 02:59:06'),
(255, 'artist', 1, 3, 'http://dev.mymuzik.com/artist/miu_lê', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 02:59:11'),
(256, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:01:07'),
(257, 'user_uploads', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/uploads', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:01:11'),
(258, 'user_heard', 2, 2, 'http://dev.mymuzik.com/user/nguyencaotai/heard', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai/uploads', '2022-06-25 03:01:21'),
(259, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user/nguyencaotai/heard', '2022-06-25 03:01:42'),
(260, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:01:46'),
(261, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:01:50'),
(262, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:01:51'),
(263, '404', 1, 2, 'http://dev.mymuzik.com/user/nguyencaotai/wavesurfer.js.map', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:01:52'),
(264, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:02:00'),
(265, '404', 1, 2, 'http://dev.mymuzik.com/track/wavesurfer.js.map', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:02:02'),
(266, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:02:14'),
(267, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:03:06'),
(268, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:03:14'),
(269, 'page', 4, NULL, 'http://dev.mymuzik.com/tracks', 'ufpgofr9ejgp9fa9n1trjpm1g2', '[]', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:03:43'),
(270, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:03:51'),
(271, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:06:09'),
(272, '404', 1, NULL, 'http://dev.mymuzik.com/favicon.ico', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 03:06:11'),
(273, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:06:24'),
(274, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:06:26'),
(275, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:06:59'),
(276, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:07:02'),
(277, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:07:06'),
(278, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:07:08'),
(279, 'page', 1, NULL, 'http://dev.mymuzik.com/', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:07:17'),
(280, 'page', 6, NULL, 'http://dev.mymuzik.com/trending', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 03:07:27'),
(281, 'track', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-25 03:07:29'),
(282, 'track', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:07:35'),
(283, 'track_embed', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666/embed', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:09:06');
INSERT INTO `_hits` (`ID`, `page_type`, `page_hook`, `user_id`, `request_url`, `request_sessid`, `request_cookies`, `request_posts`, `request_params`, `ip`, `ip_country`, `agent`, `agent_model`, `agent_type`, `agent_os`, `agent_browser`, `agent_engine`, `referer`, `referer_full`, `time_add`) VALUES
(284, 'track', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:10:13'),
(285, '404', 1, NULL, 'http://dev.mymuzik.com/uploads/images/220625/waves/62b67ab524809.png', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:10:13'),
(286, 'track', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:10:22'),
(287, '404', 1, NULL, 'http://dev.mymuzik.com/uploads/images/220625/waves/62b67ab524809.png', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:10:24'),
(288, '404', 1, NULL, 'http://dev.mymuzik.com/uploads/images/220625/waves/62b67ab524809.png', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:10:33'),
(289, 'track', 2, NULL, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'ufpgofr9ejgp9fa9n1trjpm1g2', '{\"PHPSESSID\":\"ufpgofr9ejgp9fa9n1trjpm1g2\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:11:04'),
(290, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:11:45'),
(291, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:11:55'),
(292, 'artist', 1, 3, 'http://dev.mymuzik.com/artist/miu_lê', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_signup', '2022-06-25 03:13:00'),
(293, 'page', 1, 3, 'http://dev.mymuzik.com/', 'aomf0pod1rin164krgocpngciv', '{\"PHPSESSID\":\"aomf0pod1rin164krgocpngciv\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:15:01'),
(294, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 03:15:12'),
(295, 'page', 3, 2, 'http://dev.mymuzik.com/albums', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 03:15:15'),
(296, 'page', 2, 2, 'http://dev.mymuzik.com/store', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/albums', '2022-06-25 03:15:20'),
(297, 'user_purchased', NULL, 2, 'http://dev.mymuzik.com/user_purchased', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/store', '2022-06-25 03:15:24'),
(298, 'page', 4, 2, 'http://dev.mymuzik.com/tracks', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_purchased', '2022-06-25 03:17:15'),
(299, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'iphone', 'mobile', 'ios', 'safari', 'webkit', 'dev.mymuzik.com', 'http://dev.mymuzik.com/tracks', '2022-06-25 03:17:22'),
(300, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'iphone', 'mobile', 'ios', 'safari', 'webkit', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 03:17:28'),
(301, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'iphone', 'mobile', 'ios', 'safari', 'webkit', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:17:30'),
(302, 'search', NULL, 2, 'http://dev.mymuzik.com/search', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"qn\":\"hay\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 03:19:02'),
(303, 'search', NULL, 2, 'http://dev.mymuzik.com/search', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '{\"qn\":\"chia\"}', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/search?qn=hay', '2022-06-25 03:19:10'),
(304, 'user_upload', NULL, 2, 'http://dev.mymuzik.com/user_upload', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/search?qn=chia', '2022-06-25 03:25:23'),
(305, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/user_upload', '2022-06-25 03:25:25'),
(306, 'track', 1, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:25:30'),
(307, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay', '2022-06-25 03:42:31'),
(308, 'track', 2, 2, 'http://dev.mymuzik.com/track/miu_lê-vì_mẹ_anh_bắt_chia_tay666', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 03:42:34'),
(309, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/track/miu_l%c3%aa-v%c3%ac_m%e1%ba%b9_anh_b%e1%ba%aft_chia_tay666', '2022-06-25 03:42:44'),
(310, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:42:46'),
(311, 'page', 6, 2, 'http://dev.mymuzik.com/trending', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/', '2022-06-25 03:42:56'),
(312, 'page', 3, 2, 'http://dev.mymuzik.com/albums', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/trending', '2022-06-25 03:42:59'),
(313, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', 'dev.mymuzik.com', 'http://dev.mymuzik.com/albums', '2022-06-25 03:43:01'),
(314, 'page', 1, 2, 'http://dev.mymuzik.com/', 'amhpvckadk8ll5nravu2jouv03', '{\"_uads\":\"a:2:{s:4:&quot;date&quot;;i:1656132499;s:5:&quot;uaid_&quot;;a:0:{}}\",\"mode\":\"night\",\"user_id\":\"effca14b644ac986303d9b37b0242ff8f26299e016560642446d6cf3cf72be449ef39b9e2bef71b56f\",\"PHPSESSID\":\"amhpvckadk8ll5nravu2jouv03\"}', '[]', '[]', '127.0.0.1', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36', NULL, 'desktop', 'windows', 'chrome', 'blink', NULL, NULL, '2022-06-25 03:47:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_langs`
--

CREATE TABLE `_langs` (
  `ID` int(6) NOT NULL,
  `hook` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_bin NOT NULL DEFAULT 'en',
  `text` tinytext COLLATE utf8mb4_bin NOT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_langs`
--

INSERT INTO `_langs` (`ID`, `hook`, `lang`, `text`, `time_add`) VALUES
(1, 'dir', 'en', 'ltr', '2021-03-22 07:47:43'),
(2, 'signup_h1', 'en', 'Register', '2021-03-22 07:47:43'),
(3, 'email', 'en', 'email', '2021-03-22 07:47:43'),
(4, 'password', 'en', 'password', '2021-03-22 07:47:43'),
(5, 'password_verify', 'en', 'Password Again', '2021-03-22 07:47:43'),
(6, 'signup_term_agree', 'en', 'Check this box to agree with our terms and continue', '2021-03-22 07:47:43'),
(7, 'continue', 'en', 'continue', '2021-03-22 07:47:43'),
(8, 'cancel', 'en', 'cancel', '2021-03-22 07:47:43'),
(9, 'signup_closed', 'en', 'We don\'t accept new members', '2021-03-22 07:47:43'),
(10, 'terms_agreed_missing', 'en', 'You have to agree to our terms in order to register. If you can\'t, Please consider using another service', '2021-03-22 07:47:43'),
(11, 'pws_no_match', 'en', 'Password and password-repeat don\'t match!', '2021-03-22 07:47:43'),
(12, 'invalid_email', 'en', 'Email is not valid', '2021-03-22 07:47:43'),
(13, 'invalid_password', 'en', 'Password is invalid', '2021-03-22 07:47:43'),
(14, 'invalid_password2', 'en', 'Password-repeat is invalid', '2021-03-22 07:47:43'),
(15, 'username', 'en', 'username', '2021-03-22 07:47:43'),
(16, 'invalid_username', 'en', 'Username is invalid', '2021-03-22 07:47:43'),
(17, 'email_exists', 'en', 'This email exists. Try recovering the password', '2021-03-22 07:47:43'),
(18, 'username_exists', 'en', 'This username is taken. Choose another one', '2021-03-22 07:47:43'),
(19, 'verify_now', 'en', 'Sign up was successful. Please check your email for verification link and click on it', '2021-03-22 07:47:43'),
(20, 'created', 'en', 'Sign up was successful. Log in to start!', '2021-03-22 07:47:43'),
(21, 'login_h1', 'en', 'Login', '2021-03-22 07:47:43'),
(22, 'welcome', 'en', 'Login successful. Welcome', '2021-03-22 07:47:43'),
(23, 'wrong_auth', 'en', 'Email and/or password is wrong', '2021-03-22 07:47:43'),
(24, 'unverified_user', 'en', 'This email has not been verified yet. Please check your inbox/spam and click on verification link', '2021-03-22 07:47:43'),
(25, 'signup', 'en', 'signup', '2021-03-22 07:47:43'),
(26, 'login', 'en', 'login', '2021-03-22 07:47:43'),
(27, 'forget_pass_txt', 'en', 'Forgot your password?', '2021-03-22 07:47:43'),
(28, 'm_home', 'en', 'home', '2021-03-22 07:47:43'),
(29, 'm_account', 'en', 'account', '2021-03-22 07:47:43'),
(30, 'm_login', 'en', 'login', '2021-03-22 07:47:43'),
(31, 'm_register', 'en', 'become a member', '2021-03-22 07:47:43'),
(32, 'm_search', 'en', 'search', '2021-03-22 07:47:43'),
(33, 'done', 'en', 'Successfully done', '2021-03-22 07:47:43'),
(34, 'm_upload', 'en', 'upload', '2021-03-22 07:47:43'),
(35, 'type_1', 'en', 'liked', '2021-03-22 07:47:43'),
(36, 'type_2', 'en', 'reposted', '2021-03-22 07:47:43'),
(37, 'type_3', 'en', 'uploaded', '2021-03-22 07:47:43'),
(38, 'type_4', 'en', 'playlisted', '2021-03-22 07:47:43'),
(39, 'm_admin', 'en', 'Admin', '2021-03-22 07:47:43'),
(40, 'type_5', 'en', 'commented', '2021-03-22 07:47:43'),
(41, 'type_6', 'en', 'followed', '2021-03-22 07:47:43'),
(42, 'feed', 'en', 'feed', '2021-03-22 07:47:43'),
(43, 'activities', 'en', 'activities', '2021-03-22 07:47:43'),
(44, 'tracks', 'en', 'tracks', '2021-03-22 07:47:43'),
(45, 'albums', 'en', 'albums', '2021-03-22 07:47:43'),
(46, 'purchased', 'en', 'purchased', '2021-03-22 07:47:43'),
(47, 'uploads', 'en', 'uploads', '2021-03-22 07:47:43'),
(48, 'likes', 'en', 'likes', '2021-03-22 07:47:43'),
(49, 'reposts', 'en', 'reposts', '2021-03-22 07:47:43'),
(50, 'playlists', 'en', 'playlists', '2021-03-22 07:47:43'),
(51, 'followers', 'en', 'followers', '2021-03-22 07:47:43'),
(52, 'followings', 'en', 'followings', '2021-03-22 07:47:43'),
(53, 'setting', 'en', 'setting', '2021-03-22 07:47:43'),
(54, 'search_placeholder', 'en', 'Search query ...', '2021-03-22 07:47:43'),
(55, 'upload', 'en', 'upload', '2021-03-22 07:47:43'),
(56, 'logout', 'en', 'logout', '2021-03-22 07:47:43'),
(57, 'upgrade', 'en', 'upgrade', '2021-03-22 07:47:43'),
(58, 'all', 'en', 'all', '2021-03-22 07:47:43'),
(59, 'artists', 'en', 'artists', '2021-03-22 07:47:43'),
(60, 'featuring', 'en', 'featuring', '2021-03-22 07:47:43'),
(61, 'second', 'en', 'second', '2021-03-22 07:47:43'),
(62, 'seconds', 'en', 'seconds', '2021-03-22 07:47:43'),
(63, 'minute', 'en', 'minute', '2021-03-22 07:47:43'),
(64, 'minutes', 'en', 'minutes', '2021-03-22 07:47:43'),
(65, 'hour', 'en', 'hour', '2021-03-22 07:47:43'),
(66, 'hours', 'en', 'hours', '2021-03-22 07:47:43'),
(67, 'day', 'en', 'day', '2021-03-22 07:47:43'),
(68, 'days', 'en', 'days', '2021-03-22 07:47:43'),
(69, 'month', 'en', 'month', '2021-03-22 07:47:43'),
(70, 'months', 'en', 'months', '2021-03-22 07:47:43'),
(71, 'year', 'en', 'year', '2021-03-22 07:47:43'),
(72, 'years', 'en', 'years', '2021-03-22 07:47:43'),
(73, 'ago', 'en', 'ago', '2021-03-22 07:47:43'),
(74, 'play', 'en', 'play', '2021-03-22 07:47:43'),
(75, 'buy_for', 'en', 'buy for $price$', '2021-03-22 07:47:43'),
(76, 'add_to_playlist', 'en', 'add to playlist', '2021-03-22 07:47:43'),
(77, 'perform', 'en', 'perform', '2021-03-22 07:47:43'),
(78, 'create_new_playlist', 'en', 'create new playlist', '2021-03-22 07:47:43'),
(79, 'add_to_playlist_tip', 'en', 'select a playlist or create a new one', '2021-03-22 07:47:43'),
(80, 'purchase_song', 'en', 'purchase a song', '2021-03-22 07:47:43'),
(81, 'item_name', 'en', 'item name', '2021-03-22 07:47:43'),
(82, 'item_price', 'en', 'item price', '2021-03-22 07:47:43'),
(83, 'account_funt', 'en', 'account fund', '2021-03-22 07:47:43'),
(84, 'add_funds', 'en', 'add more funds', '2021-03-22 07:47:43'),
(85, 'confirm', 'en', 'confirm', '2021-03-22 07:47:43'),
(86, 'purchase_premium', 'en', 'purchase premium', '2021-03-22 07:47:43'),
(87, 'purchase_premium_tip', 'en', 'premium account for a month', '2021-03-22 07:47:43'),
(88, 'members_only', 'en', 'members only!', '2021-03-22 07:47:43'),
(89, 'members_only_tip', 'en', 'sign up to access a lot of amazing features', '2021-03-22 07:47:43'),
(90, 'wait', 'en', 'Wait ...', '2021-03-22 07:47:43'),
(91, 'bought_song', 'en', 'bought $song$', '2021-03-22 07:47:43'),
(92, 'bought_pro', 'en', 'upgraded to `Paid`', '2021-03-22 07:47:43'),
(93, 'added_fund', 'en', 'Added funds $order_id$', '2021-03-22 07:47:43'),
(94, 'sold_song', 'en', 'sold $song$', '2021-03-22 07:47:43'),
(95, 'album_tracks_data', 'en', '$count$ tracks, $duration$ minutes', '2021-03-22 07:47:43'),
(96, 'playlist_track_data', 'en', '$count$ tracks', '2021-03-22 07:47:43'),
(97, 'bought_album', 'en', 'bought $album$', '2021-03-22 07:47:43'),
(98, 'sold_album', 'en', 'sold $album$', '2021-03-22 07:47:43'),
(99, 'withdrew', 'en', 'Withdrew', '2021-03-22 07:47:43'),
(100, 'p_index_title', 'en', 'Feel the music', '2021-03-22 07:47:43'),
(101, 'p_index_desc', 'en', 'Discover best music in world for free', '2021-03-22 07:47:43'),
(102, '404_title', 'en', 'Not Found', '2021-03-22 07:47:43'),
(103, '404_tip', 'en', 'Sorry. We failed to find this page', '2021-03-22 07:47:43'),
(104, '404_goback', 'en', 'Go back to home', '2021-03-22 07:47:43'),
(105, 'popular_tracks', 'en', 'Popular Tracks', '2021-03-22 07:47:43'),
(106, 'studio_albums', 'en', 'Studio Albums', '2021-03-22 07:47:43'),
(107, 'single_albums', 'en', 'Single Albums', '2021-03-22 07:47:43'),
(108, 'albums_as_guest', 'en', 'Featured in', '2021-03-22 07:47:43'),
(109, 'related_artists', 'en', 'Related Artists', '2021-03-22 07:47:43'),
(110, 'next_page', 'en', 'Next page', '2021-03-22 07:47:43'),
(111, 'genre_no_res', 'en', 'No results. Try browsing other genres from the list below', '2021-03-22 07:47:43'),
(112, 'no_access_title', 'en', 'No Access', '2021-03-22 07:47:43'),
(113, 'no_access_tip', 'en', 'You can\'t access this page', '2021-03-22 07:47:43'),
(114, 'add_to', 'en', 'Add to', '2021-03-22 07:47:43'),
(115, 'repost', 'en', 'repost', '2021-03-22 07:47:43'),
(116, 'share', 'en', 'share', '2021-03-22 07:47:43'),
(117, 'unrepost', 'en', 'Un-Repost', '2021-03-22 07:47:43'),
(118, 'unlike', 'en', 'unlike', '2021-03-22 07:47:43'),
(119, 'like', 'en', 'like', '2021-03-22 07:47:43'),
(120, 'no_result', 'en', 'No results were found', '2021-03-22 07:47:43'),
(121, 'playlist_comment', 'en', 'This playlist was created by $user$ $time_add$ ago. Last update was done $time_up$ ago', '2021-03-22 07:47:43'),
(122, 'created_by', 'en', 'Created by', '2021-03-22 07:47:43'),
(123, 'add_to_pl', 'en', 'Add to playlist', '2021-03-22 07:47:43'),
(124, 'remove_from_pl', 'en', 'remove from playlist', '2021-03-22 07:47:43'),
(125, 'add_to_qu', 'en', 'add to queue', '2021-03-22 07:47:43'),
(126, 'removed', 'en', 'removed', '2021-03-22 07:47:43'),
(127, 'confirm_action', 'en', 'Confirm your action', '2021-03-22 07:47:43'),
(128, 'remove_playlist', 'en', 'Remove a playlist', '2021-03-22 07:47:43'),
(129, 'download', 'en', 'download', '2021-03-22 07:47:43'),
(130, 'delete', 'en', 'delete', '2021-03-22 07:47:43'),
(131, 'remove', 'en', 'remove', '2021-03-22 07:47:43'),
(132, 'comments_title', 'en', '$count$ comments', '2021-03-22 07:47:43'),
(133, 'comment_placeholder', 'en', 'Write a comment', '2021-03-22 07:47:43'),
(134, 'ts_advertisement', 'en', 'Advertisement', '2021-03-22 07:47:43'),
(135, 'ts_more_track', 'en', 'More Tracks', '2021-03-22 07:47:43'),
(136, 'ts_in_playlists', 'en', 'In Playlists', '2021-03-22 07:47:43'),
(137, 'ts_likes', 'en', 'Liked by', '2021-03-22 07:47:43'),
(138, 'ts_reposts', 'en', 'Reposted by', '2021-03-22 07:47:43'),
(139, 'user_act_text', 'en', '$user$ <b>$act_name$</b> a track <b>$artist$</b>', '2021-03-22 07:47:43'),
(140, 'time_ago', 'en', '$time$ ago', '2021-03-22 07:47:43'),
(141, 'load_more', 'en', 'load more', '2021-03-22 07:47:43'),
(142, 'user_act_empty', 'en', 'This user has been in-active so far', '2021-03-22 07:47:43'),
(143, 'user_feed_empty', 'en', 'Your feed is empty. Try following some active users', '2021-03-22 07:47:43'),
(144, 'payment', 'en', 'payment', '2021-03-22 07:47:43'),
(145, 'successful', 'en', 'Successful', '2021-03-22 07:47:43'),
(146, 'failed', 'en', 'failed', '2021-03-22 07:47:43'),
(147, 'pay_done', 'en', 'Your payment was successful and $amount$ has been added to your walltet', '2021-03-22 07:47:43'),
(148, 'pay_pending', 'en', 'Your payment was successful and $amount$ will be added to your walltet after an admin verifies the payment', '2021-03-22 07:47:43'),
(149, 'pay_fail', 'en', 'Please contatct supports or try again', '2021-03-22 07:47:43'),
(150, 'user_no_playlist', 'en', 'User has not created any playlist yet', '2021-03-22 07:47:43'),
(151, 'user_empty_playlist', 'en', 'No tracks added yet', '2021-03-22 07:47:43'),
(152, 'edit', 'en', 'edit', '2021-03-22 07:47:43'),
(153, 'updated', 'en', 'updated', '2021-03-22 07:47:43'),
(154, 'free', 'en', 'free', '2021-03-22 07:47:43'),
(155, 'pro_name', 'en', 'Paid', '2021-03-22 07:47:43'),
(156, 'mo', 'en', 'MO', '2021-03-22 07:47:43'),
(157, 'normal_name', 'en', 'starter plan', '2021-03-22 07:47:43'),
(158, 'normal_text', 'en', 'Listen to free songs\r\nCreate playlists', '2021-03-22 07:47:43'),
(159, 'pro_text', 'en', 'Listen to premium songs\r\nDownload songs\r\nUpload songs\r\nGet verified badge', '2021-03-22 07:47:43'),
(160, 'upload_drop_text', 'en', 'Drop audios here to start upload', '2021-03-22 07:47:43'),
(161, 'upload_drop_text2', 'en', 'or click to select files', '2021-03-22 07:47:43'),
(162, 'upload_progress', 'en', 'tracks uploaded', '2021-03-22 07:47:43'),
(163, 'upload_edit_tip', 'en', 'The uploaded tracks are here! You can edit each of them individualy or you can edit a bunch of them as an album', '2021-03-22 07:47:43'),
(164, 'name', 'en', 'name', '2021-03-22 07:47:43'),
(165, 'artist', 'en', 'artist', '2021-03-22 07:47:43'),
(166, 'genre', 'en', 'genre', '2021-03-22 07:47:43'),
(167, 'duration', 'en', 'duration', '2021-03-22 07:47:43'),
(168, 'bitrate', 'en', 'bitrate', '2021-03-22 07:47:43'),
(169, 'price', 'en', 'price', '2021-03-22 07:47:43'),
(170, 'upload_edit_t_title', 'en', 'Edit a track', '2021-03-22 07:47:43'),
(171, 'title', 'en', 'title', '2021-03-22 07:47:43'),
(172, 'featured_artists', 'en', 'Featured Artists', '2021-03-22 07:47:43'),
(173, 'album_type', 'en', 'Album Type', '2021-03-22 07:47:43'),
(174, 'album_title', 'en', 'Album Title', '2021-03-22 07:47:43'),
(175, 'album_artist', 'en', 'Album Artist', '2021-03-22 07:47:43'),
(176, 'album_order', 'en', 'Album Order', '2021-03-22 07:47:43'),
(177, 'description', 'en', 'description', '2021-03-22 07:47:43'),
(178, 'file', 'en', 'file', '2021-03-22 07:47:43'),
(179, 'lyrics', 'en', 'lyrics', '2021-03-22 07:47:43'),
(180, 'spotify_id', 'en', 'Spotify ID', '2021-03-22 07:47:43'),
(181, 'detail', 'en', 'detail', '2021-03-22 07:47:43'),
(182, 'sources', 'en', 'sources', '2021-03-22 07:47:43'),
(183, 'featured_artists_tip', 'en', 'Seperate artists by semicolons ;', '2021-03-22 07:47:43'),
(184, 'save', 'en', 'save', '2021-03-22 07:47:43'),
(185, 'upload_edit_a_title', 'en', 'Edit an Album', '2021-03-22 07:47:43'),
(186, 'release', 'en', 'Release date', '2021-03-22 07:47:43'),
(187, 'prev_page', 'en', 'Previous page', '2021-03-22 07:47:43'),
(188, 'new_playlist', 'en', 'new playlist', '2021-03-22 07:47:43'),
(189, 'edit_profile', 'en', 'Edit Profile', '2021-03-22 07:47:43'),
(190, 'create_pl_name_tip', 'en', 'Choose a name for your new playlist', '2021-03-22 07:47:43'),
(191, 'real_name', 'en', 'real name', '2021-03-22 07:47:43'),
(192, 'stage_name', 'en', 'stage name', '2021-03-22 07:47:43'),
(193, 'up_photo_doc', 'en', 'upload photo document', '2021-03-22 07:47:43'),
(194, 'more_data', 'en', 'Additional data', '2021-03-22 07:47:43'),
(195, 'more_data_ph', 'en', 'Additional information about you', '2021-03-22 07:47:43'),
(196, 'artist_verify_wait', 'en', 'Your request is being processed', '2021-03-22 07:47:43'),
(197, 'click_to_select', 'en', 'Click to select files', '2021-03-22 07:47:43'),
(198, 'artist_verify_note', 'en', 'Send your real-name, stage-name and a photo of your ID to verify your account', '2021-03-22 07:47:43'),
(199, 'send', 'en', 'send', '2021-03-22 07:47:43'),
(200, 'amount', 'en', 'amount', '2021-03-22 07:47:43'),
(201, 'artist_pay_note', 'en', 'Submit your bank account number', '2021-03-22 07:47:43'),
(202, 'more_data_ph2', 'en', 'Additional information about payment or bank account', '2021-03-22 07:47:43'),
(203, 'new_password', 'en', 'new password', '2021-03-22 07:47:43'),
(204, 'profile_picture', 'en', 'profile picture', '2021-03-22 07:47:43'),
(205, 'comments', 'en', 'comments', '2021-03-22 07:47:43'),
(206, 'no_transactions_yet', 'en', 'No transactions yet', '2021-03-22 07:47:43'),
(207, 'balance', 'en', 'balance', '2021-03-22 07:47:43'),
(208, 'time', 'en', 'time', '2021-03-22 07:47:43'),
(209, 'status', 'en', 'status', '2021-03-22 07:47:43'),
(210, 'pending', 'en', 'pending', '2021-03-22 07:47:43'),
(211, 'last_activity', 'en', 'last activity', '2021-03-22 07:47:43'),
(212, 'right_now', 'en', 'right now', '2021-03-22 07:47:43'),
(213, 'create', 'en', 'create', '2021-03-22 07:47:43'),
(214, 'us_general_setting', 'en', 'General Settings', '2021-03-22 07:47:43'),
(215, 'us_profile_setting', 'en', 'Profile Settings', '2021-03-22 07:47:43'),
(216, 'us_feed_setting', 'en', 'Notification & Feed Settings', '2021-03-22 07:47:43'),
(217, 'us_change_password', 'en', 'Change Password', '2021-03-22 07:47:43'),
(218, 'us_manage_sessions', 'en', 'Manage Sessions', '2021-03-22 07:47:43'),
(219, 'us_transactions', 'en', 'Transactions', '2021-03-22 07:47:43'),
(220, 'us_verification', 'en', 'Artist Verification', '2021-03-22 07:47:43'),
(221, 'add_fund_title', 'en', 'Add funds', '2021-03-22 07:47:43'),
(222, 'dep_amount', 'en', 'Deposit amount', '2021-03-22 07:47:43'),
(223, 'dep_amount_tip', 'en', 'Enter amount', '2021-03-22 07:47:43'),
(224, 'pay_method', 'en', 'Payment Method', '2021-03-22 07:47:43'),
(225, 'paypal', 'en', 'Paypal', '2021-03-22 07:47:43'),
(226, 'bank_tf', 'en', 'Bank Transfer', '2021-03-22 07:47:43'),
(227, 'open', 'en', 'open', '2021-03-22 07:47:43'),
(228, 'move', 'en', 'move', '2021-03-22 07:47:43'),
(229, 'fullscreen', 'en', 'fullscreen', '2021-03-22 07:47:43'),
(230, 'fund', 'en', 'funds', '2021-03-22 07:47:43'),
(231, 'loading', 'en', 'loading', '2021-03-22 07:47:43'),
(232, 'pause', 'en', 'pause', '2021-03-22 07:47:43'),
(233, 'download_tip', 'en', 'How would you like your file(s)?', '2021-03-22 07:47:43'),
(234, 'get_links', 'en', 'Get Link(s)', '2021-03-22 07:47:43'),
(235, 'download_links', 'en', 'Download Links', '2021-03-22 07:47:43'),
(236, 'download_links_tip', 'en', 'Copy and use download link(s)', '2021-03-22 07:47:43'),
(237, 'pt_user_purchased', 'en', 'Your purchased songs', '2021-03-22 07:47:43'),
(238, 'pt_user_reposts', 'en', '$users$\'s reposts', '2021-03-22 07:47:43'),
(239, 'pt_user_setting', 'en', 'User Settings', '2021-03-22 07:47:43'),
(240, 'pt_user_upgrade', 'en', 'Upgrade your account', '2021-03-22 07:47:43'),
(241, 'pt_user_upload_edi', 'en', 'Review & Submit upload', '2021-03-22 07:47:43'),
(242, 'pt_user_uploads', 'en', '$user$\'s uploads', '2021-03-22 07:47:43'),
(243, 'pt_user', 'en', '$user$\'s activities', '2021-03-22 07:47:43'),
(244, 'pt_user_feed', 'en', 'Your feed', '2021-03-22 07:47:43'),
(245, 'pt_user_followers', 'en', '$user$\'s followers', '2021-03-22 07:47:43'),
(246, 'pt_user_followings', 'en', '$user$\'s followings', '2021-03-22 07:47:43'),
(247, 'pt_user_likes', 'en', '$user$\'s likes', '2021-03-22 07:47:43'),
(248, 'pt_user_pay_result', 'en', 'Payment Results', '2021-03-22 07:47:43'),
(249, 'pt_user_playlists', 'en', '$user$\'s playlists', '2021-03-22 07:47:43'),
(250, 'pt_playlist', 'en', 'Playlist $playlist$ by $user$', '2021-03-22 07:47:43'),
(251, 'pt_genre', 'en', 'Genres', '2021-03-22 07:47:43'),
(252, 'posted', 'en', 'Your comment was posted on the website', '2021-03-22 07:47:43'),
(253, 'waiting_4_approve', 'en', 'Your comment will be posted on the website after being confirmed by an admin', '2021-03-22 07:47:43'),
(254, 'liked', 'en', 'liked', '2021-03-22 07:47:43'),
(255, 'unliked', 'en', 'unliked', '2021-03-22 07:47:43'),
(256, 'reposted', 'en', 'reposted', '2021-03-22 07:47:43'),
(257, 'unreposted', 'en', 'Repost removed', '2021-03-22 07:47:43'),
(258, 'artist_name', 'en', 'Artist name', '2021-03-22 07:47:43'),
(259, 'album_artist_name', 'en', 'album artist name', '2021-03-22 07:47:43'),
(260, 'album_time', 'en', 'album release date', '2021-03-22 07:47:43'),
(261, 'album_cover', 'en', 'album cover', '2021-03-22 07:47:43'),
(262, 'album_genre', 'en', 'album genre', '2021-03-22 07:47:43'),
(263, 'error', 'en', 'error', '2021-03-22 07:47:43'),
(264, 'album', 'en', 'album', '2021-03-22 07:47:43'),
(265, 'time_release', 'en', 'Release time', '2021-03-22 07:47:43'),
(266, 'tracks_uploaded', 'en', '$tracks$ uploaded', '2021-03-22 07:47:43'),
(267, 'fund_shortage', 'en', 'You don\'t have enough funds. Add some more', '2021-03-22 07:47:43'),
(268, 'invalid_time', 'en', 'invalid time', '2021-03-22 07:47:43'),
(269, 'incorrect_password', 'en', 'incorrect password', '2021-03-22 07:47:43'),
(270, 'need_at_least_one', 'en', 'need at least one ', '2021-03-22 07:47:43'),
(271, 'invalid_image', 'en', 'invalid image', '2021-03-22 07:47:43'),
(272, 'amount_is_too_low', 'en', 'amount is too low', '2021-03-22 07:47:43'),
(273, 'long_comment', 'en', 'long comment', '2021-03-22 07:47:43'),
(274, 'uploader', 'en', 'uploader', '2021-03-22 07:47:43'),
(275, 'share_this', 'en', 'Share this $target$', '2021-03-22 07:47:43'),
(276, 'track', 'en', 'track', '2021-03-22 07:47:43'),
(277, 'playlist', 'en', 'playlist', '2021-03-22 07:47:43'),
(278, 'admin', 'en', 'admin', '2021-03-22 07:47:43'),
(279, 'us_artist_withdrawal', 'en', 'Artist Withdraw', '2021-03-22 07:47:43'),
(280, 'no_source', 'en', 'There is a problem with this track. Play another one', '2021-03-22 07:47:43'),
(281, 'rec_type_72', 'en', '$user$ submitted new payment with amount of $amount$', '2021-03-22 07:47:43'),
(282, 'rec_type_73', 'en', '$user$ made a new purchase', '2021-03-22 07:47:43'),
(283, 'rec_type_69', 'en', '$user$ created a new advertisement campaign', '2021-03-22 07:47:43'),
(284, 'dont_talk_back', 'en', 'This is an automatic message. Please don\'t reply to it', '2021-03-22 07:47:43'),
(285, 'not_new_upload', 'en', 'New upload', '2021-03-22 07:47:43'),
(286, 'not_new_purchase', 'en', 'New purchase', '2021-03-22 07:47:43'),
(287, 'not_new_comment', 'en', 'New comment', '2021-03-22 07:47:43'),
(288, 'not_new_user', 'en', 'New user', '2021-03-22 07:47:43'),
(289, 'not_new_report', 'en', 'New Track Report', '2021-03-22 07:47:43'),
(290, 'not_new_advertisement', 'en', 'New Advertisement Campaign', '2021-03-22 07:47:43'),
(291, 'not_new_artist_request', 'en', 'New artist verification request', '2021-03-22 07:47:43'),
(292, 'not_new_artist_withdrawal', 'en', 'New artist withdrawal request', '2021-03-22 07:47:43'),
(293, 'not_new_payment', 'en', 'New payment', '2021-03-22 07:47:43'),
(294, 'rec_type_66', 'en', '$user$ made a new comment', '2021-03-22 07:47:43'),
(295, 'rec_type_67', 'en', '$user$ signed up', '2021-03-22 07:47:43'),
(296, 'rec_type_68', 'en', '$user$ reported a track', '2021-03-22 07:47:43'),
(297, 'rec_type_74', 'en', '$user$ uploaded a new track', '2021-03-22 07:47:43'),
(298, 'recover_h1', 'en', 'Account Recovery', '2021-03-22 07:47:43'),
(299, 'forget_pass_tip', 'en', 'Submit your email then check it for recovery link', '2021-03-22 07:47:43'),
(300, 'recovery_m_sent', 'en', 'We sent an email containing a recovery link to your email. Click on that link to recover your password', '2021-03-22 07:47:43'),
(301, 'rec_type_70', 'en', '$user$ requested artist verification', '2021-03-22 07:47:43'),
(302, 'rec_type_71', 'en', '$user$ request fund withdrawal', '2021-03-22 07:47:43'),
(303, 'recover_failed', 'en', 'This link is expired or invalid. Try again', '2021-03-22 07:47:43'),
(304, 'purchase_to_hear', 'en', 'Purchase this item to support the artist and hear the full version', '2021-03-22 07:47:43'),
(305, 'not_purchased', 'en', 'Not Purchased', '2021-03-22 07:47:43'),
(306, 'start_station', 'en', 'Start Station', '2021-03-22 07:47:43'),
(307, 'que_up_next', 'en', 'Up Next:', '2021-03-22 07:47:43'),
(308, 'm_discover', 'en', 'discover', '2021-03-22 07:47:43'),
(309, 'm_trending', 'en', 'trending', '2021-03-22 07:47:43'),
(310, 'm_albums', 'en', 'albums', '2021-03-22 07:47:43'),
(311, 'm_tracks', 'en', 'tracks', '2021-03-22 07:47:43'),
(312, 'm_artists', 'en', 'artists', '2021-03-22 07:47:43'),
(313, 'm_genres', 'en', 'genres', '2021-03-22 07:47:43'),
(314, 'm_store', 'en', 'store', '2021-03-22 07:47:43'),
(315, 'm_browse', 'en', 'browse', '2021-03-22 07:47:43'),
(316, 'm_purchased', 'en', 'purchased', '2021-03-22 07:47:43'),
(317, 'm_your_music', 'en', 'your music', '2021-03-22 07:47:43'),
(318, 'm_user_likes', 'en', 'likes', '2021-03-22 07:47:43'),
(319, 'm_user_reposts', 'en', 'reposts', '2021-03-22 07:47:43'),
(320, 'm_user_playlists', 'en', 'playlists', '2021-03-22 07:47:43'),
(321, 'p_home_title', 'en', 'Feel the music', '2021-03-22 07:47:43'),
(322, 'p_w_new_albums', 'en', 'New Albums', '2021-03-22 07:47:43'),
(323, 'p_w_new_tracks', 'en', 'New Tracks', '2021-03-22 07:47:43'),
(324, 'p_home_desc', 'en', 'Listen to free music', '2021-03-22 07:47:43'),
(325, 'p_w_top_artists', 'en', 'Top Artists', '2021-03-22 07:47:43'),
(326, 'p_w_premium_tracks', 'en', 'Priced Tracks', '2021-03-22 07:47:43'),
(327, 'p_store_title', 'en', 'Store', '2021-03-22 07:47:43'),
(328, 'p_store_desc', 'en', 'Browse our premium content', '2021-03-22 07:47:43'),
(329, 'p_w_premium_albums', 'en', 'Premium Albums', '2021-03-22 07:47:43'),
(330, 'p_w_top_sellers', 'en', 'Top Sellers', '2021-03-22 07:47:43'),
(331, 'p_albums_title', 'en', 'Albums', '2021-03-22 07:47:43'),
(332, 'p_albums_desc', 'en', 'Browse our albums', '2021-03-22 07:47:43'),
(333, 'p_w_trending_albums', 'en', 'Trending Albums', '2021-03-22 07:47:43'),
(334, 'p_w_top_albums', 'en', 'Top Albums', '2021-03-22 07:47:43'),
(335, 'p_w_recently_heard', 'en', 'Recently Heard', '2021-03-22 07:47:43'),
(336, 'p_tracks_title', 'en', 'Tracks', '2021-03-22 07:47:43'),
(337, 'p_tracks_desc', 'en', 'Browse our tracks', '2021-03-22 07:47:43'),
(338, 'p_w_trending_tracks', 'en', 'Trending Tracks', '2021-03-22 07:47:43'),
(339, 'p_w_top_tracks', 'en', 'Top Tracks', '2021-03-22 07:47:43'),
(340, 'p_w_most_liked', 'en', 'Most Liked', '2021-03-22 07:47:43'),
(341, 'p_w_most_viewed', 'en', 'Most Viewed', '2021-03-22 07:47:43'),
(342, 'p_w_local_tracks', 'en', 'Uploaded Tracks', '2021-03-22 07:47:43'),
(343, 'p_w_top_downloaded', 'en', 'Top Downloaded', '2021-03-22 07:47:43'),
(344, 'p_artists_title', 'en', 'Artists', '2021-03-22 07:47:43'),
(345, 'p_artists_desc', 'en', 'Browse thro our arists', '2021-03-22 07:47:43'),
(346, 'p_w_trending_artists', 'en', 'Trending Artists', '2021-03-22 07:47:43'),
(347, 'p_w_verified_artists', 'en', 'Verified Artists', '2021-03-22 07:47:43'),
(348, 'p_trending_title', 'en', 'Trending', '2021-03-22 07:47:43'),
(349, 'p_trending_desc', 'en', 'Browse hottest songs on web right now', '2021-03-22 07:47:43'),
(350, 'p_w_trending_single_', 'en', 'Trending Single Albums', '2021-03-22 07:47:43'),
(351, 'background_picture', 'en', 'Background Picture', '2021-03-22 07:47:43'),
(352, 'shuffle', 'en', 'shuffle', '2021-03-22 07:47:43'),
(353, 'clear', 'en', 'clear', '2021-03-22 07:47:43'),
(354, 'song_by', 'en', 'Song by:', '2021-03-22 07:47:43'),
(355, 'heard', 'en', 'heard', '2021-03-22 07:47:43'),
(356, 'no_playlist', 'en', 'No playlist created yet', '2021-03-22 07:47:43'),
(357, 'already_done', 'en', 'Already done', '2021-03-22 07:47:43'),
(358, 'cant_like_own_cm', 'en', 'You can\'t like your own comments!', '2021-03-22 07:47:43'),
(359, 'act_type_1', 'en', '$user$ liked track $track$ from $artist$', '2021-03-22 07:47:43'),
(360, 'act_type_2', 'en', '$user$ reposted track $track$ from $artist$', '2021-03-22 07:47:43'),
(361, 'subscribe', 'en', 'subscribe', '2021-03-22 07:47:43'),
(362, 'act_type_3', 'en', '$user$ uploaded track $track$ from $artist$', '2021-03-22 07:47:43'),
(363, 'act_type_5', 'en', '$user$ commented on track $track$ from $artist$', '2021-03-22 07:47:43'),
(364, 'act_type_8', 'en', '$user$ liked $target$\'s comment on $track$', '2021-03-22 07:47:43'),
(365, 'act_type_6', 'en', '$user$ started following user $target$', '2021-03-22 07:47:43'),
(366, 'unsubscribe', 'en', 'unsubscribe', '2021-03-22 07:47:43'),
(367, 'act_type_10', 'en', '$user$ subscribed to artist $artist$', '2021-03-22 07:47:43'),
(368, 'act_type_12', 'en', '$user$ subscribed to playlist $playlist$ created by user $target$', '2021-03-22 07:47:43'),
(369, 'act_type_13', 'en', '$user$ liked playlist $playlist$ created by user $target$', '2021-03-22 07:47:43'),
(370, 'act_type_14', 'en', '$user$ liked album $album$ from $artist$', '2021-03-22 07:47:43'),
(371, 'rec_type_1', 'en', '$user$ liked $track$', '2021-03-22 07:47:43'),
(372, 'rec_type_8', 'en', '$user$ liked your comment on $track$', '2021-03-22 07:47:43'),
(373, 'rec_type_13', 'en', '$user$ liked your playlist $playlist$', '2021-03-22 07:47:43'),
(374, 'rec_type_14', 'en', '$user$ liked $album$', '2021-03-22 07:47:43'),
(375, 'rec_type_6', 'en', '$user$ started following you', '2021-03-22 07:47:43'),
(376, 'rec_type_12', 'en', '$user$ subscribed to playlist $playlist$', '2021-03-22 07:47:43'),
(377, 'rec_type_2', 'en', '$user$ reposted $track$', '2021-03-22 07:47:43'),
(378, 'subscribers', 'en', 'subscribers', '2021-03-22 07:47:43'),
(379, 'act_type_15', 'en', '$user$ updated playlist $playlist$', '2021-03-22 07:47:43'),
(380, 'rec_type_11', 'en', 'playlist $playlist$ just got updated', '2021-03-22 07:47:43'),
(381, 'rec_type_4', 'en', '$user$ made a comment on $track$', '2021-03-22 07:47:43'),
(382, 'rec_type_7', 'en', '$user$ replied to your comment on $track$', '2021-03-22 07:47:43'),
(383, 'rec_type_9', 'en', '$user$ mentioned you in a comment on $track$', '2021-03-22 07:47:43'),
(384, 'no_nots_yet', 'en', 'Nothing to see', '2021-03-22 07:47:43'),
(385, 'rec_type_16', 'en', '$artist$ has a new release', '2021-03-22 07:47:43'),
(386, 'rec_type_18', 'en', 'Your payment was successful and $amount$$currency$ was added to your wallet', '2021-03-22 07:47:43'),
(387, 'rec_type_19', 'en', '$user$ purchased track $track$', '2021-03-22 07:47:43'),
(388, 'act_type_19', 'en', '$user$ purchased track $track$ from $artist$', '2021-03-22 07:47:43'),
(389, 'rec_type_20', 'en', '$user$ purchased album $album$', '2021-03-22 07:47:43'),
(390, 'act_type_20', 'en', '$user$ purchased album $album$ from $artist$', '2021-03-22 07:47:43'),
(391, 'rec_type_21', 'en', 'You are VIP now!', '2021-03-22 07:47:43'),
(392, 'username_no_exists', 'en', 'username:$username$ doesn\'t exists', '2021-03-22 07:47:43'),
(393, 'rec_type_24', 'en', '$user$ got collabed in playlist $playlist$', '2021-03-22 07:47:43'),
(394, 'act_type_24', 'en', '$user$ is now collabing in playlist $playlist$', '2021-03-22 07:47:43'),
(395, 'rec_type_25', 'en', 'You are now a collab of playlist $playlist$', '2021-03-22 07:47:43'),
(396, 'sls_separator', 'en', 'or use your account', '2021-03-22 07:47:43'),
(397, 'us_change_username', 'en', 'Change Username', '2021-03-22 07:47:43'),
(398, 'us_advertising', 'en', 'Advertising', '2021-03-22 07:47:43'),
(399, 'rec_type_26', 'en', 'Your advertisement is now active', '2021-03-22 07:47:43'),
(400, 'bought_ads', 'en', 'Advertising', '2021-03-22 07:47:43'),
(401, 'no_ads_yet', 'en', 'No ads yet', '2021-03-22 07:47:43'),
(402, 'banner_c', 'en', 'Banner - PayPerClick', '2021-03-22 07:47:43'),
(403, 'banner_v', 'en', 'Banner - PayPerView', '2021-03-22 07:47:43'),
(404, 'audio_v', 'en', 'Audio - PayPerImpression', '2021-03-22 07:47:43'),
(405, 'pl_track_page', 'en', '`Track` page', '2021-03-22 07:47:43'),
(406, 'not_like_track', 'en', 'New track like', '2021-03-22 07:47:43'),
(407, 'not_repost_track', 'en', 'New track repost', '2021-03-22 07:47:43'),
(408, 'not_follow_user', 'en', 'New follower', '2021-03-22 07:47:43'),
(409, 'not_like_comment', 'en', 'Comment got liked', '2021-03-22 07:47:43'),
(410, 'not_follow_playlist', 'en', 'New playlist follower', '2021-03-22 07:47:43'),
(411, 'not_like_playlist', 'en', 'New playlist like', '2021-03-22 07:47:43'),
(412, 'not_like_album', 'en', 'New album like', '2021-03-22 07:47:43'),
(413, 'not_purchased_track', 'en', 'New track purchase', '2021-03-22 07:47:43'),
(414, 'not_purchased_album', 'en', 'New album purchase', '2021-03-22 07:47:43'),
(415, 'not_collab_playlist', 'en', 'New playlist collaborator', '2021-03-22 07:47:43'),
(416, 'not_collabed_playlist', 'en', 'New playlist as collaborator', '2021-03-22 07:47:43'),
(417, 'not_purchased_ads', 'en', 'New active advertisement', '2021-03-22 07:47:43'),
(418, 'not_commented_track', 'en', 'New track comment', '2021-03-22 07:47:43'),
(419, 'not_commented_comment', 'en', 'New comment reply', '2021-03-22 07:47:43'),
(420, 'not_mentioned_comment', 'en', 'New comment mention', '2021-03-22 07:47:43'),
(421, 'not_updated_playlist', 'en', 'New subscribed playlist update', '2021-03-22 07:47:43'),
(422, 'not_updated_artist', 'en', 'New subscribed artist update', '2021-03-22 07:47:43'),
(423, 'not_purchased_receipt', 'en', 'New approved payment', '2021-03-22 07:47:43'),
(424, 'not_purchased_vip', 'en', 'New panel upgrade', '2021-03-22 07:47:43'),
(425, 'feed_like_track', 'en', 'User liked a track', '2021-03-22 07:47:43'),
(426, 'feed_repost_track', 'en', 'User reposted a track', '2021-03-22 07:47:43'),
(427, 'feed_upload_track', 'en', 'User uploaded a track', '2021-03-22 07:47:43'),
(428, 'feed_comment_track', 'en', 'User commented a track', '2021-03-22 07:47:43'),
(429, 'feed_follow_user', 'en', 'User followed user', '2021-03-22 07:47:43'),
(430, 'feed_like_comment', 'en', 'User liked a comment', '2021-03-22 07:47:43'),
(431, 'feed_follow_artist', 'en', 'User subscribed to artist', '2021-03-22 07:47:43'),
(432, 'feed_follow_playlist', 'en', 'User subscribed to playlist', '2021-03-22 07:47:43'),
(433, 'feed_like_playlist', 'en', 'Usesr liked a playlist', '2021-03-22 07:47:43'),
(434, 'feed_like_album', 'en', 'User liked an album', '2021-03-22 07:47:43'),
(435, 'feed_update_playlist', 'en', 'User updated a playlist', '2021-03-22 07:47:43'),
(436, 'feed_purchased_track', 'en', 'User purchased a track', '2021-03-22 07:47:43'),
(437, 'feed_purchased_album', 'en', 'User purchased an album', '2021-03-22 07:47:43'),
(438, 'feed_collab_playlist', 'en', 'User collaborating in playlist', '2021-03-22 07:47:43'),
(439, 'ml_verify', 'en', 'Hi there. Please click on this link to complete your registration <br><a href=\'$link$\'>$link$</a>', '2021-03-22 07:47:43'),
(440, 'mls_verify', 'en', 'Verification Link', '2021-03-22 07:47:43'),
(441, 'ml_recover', 'en', 'Hi there. Click on this link or copy paste it into your browser to recover your account <br><a href=\'$link$\'>$link$</a>', '2021-03-22 07:47:43'),
(442, 'mls_recover', 'en', 'Recover your account', '2021-03-22 07:47:43'),
(443, 'rec_type_17', 'en', 'Hi there! Welcome. You are now officially a member and can enjoy our features', '2021-03-22 07:47:43'),
(444, 'not_welcome_user', 'en', 'Welcome message', '2022-06-24 11:01:33'),
(445, 'stripe', 'en', 'Stripe', '2022-06-24 11:01:33'),
(446, 'no_pay_method', 'en', 'Payment is disabled', '2022-06-24 11:01:33'),
(447, 'pl_artist_page', 'en', '`Artist` page', '2022-06-24 11:01:33'),
(448, 'pl_album_page', 'en', '`Album` page', '2022-06-24 11:01:33'),
(449, 'pl_playlist_page', 'en', '`Playlist` page', '2022-06-24 11:01:33'),
(450, 'collabs', 'en', 'collabs', '2022-06-24 11:01:33'),
(451, 'cover_image', 'en', 'Cover image', '2022-06-24 11:01:33'),
(452, 'collab_tip', 'en', 'You can allow other users to add or remove tracks from this playlist. Enter username(s) comma separated. Example: admin,user1,user2', '2022-06-24 11:01:33'),
(453, 'edit_playlist', 'en', 'Edit playlist', '2022-06-24 11:01:33'),
(454, 'ts_random_track', 'en', 'Random Tracks', '2022-06-24 11:01:33'),
(455, 'pt_user_heard', 'en', 'User listened to', '2022-06-24 11:01:33'),
(456, 'new_ad', 'en', 'new campaign', '2022-06-24 11:01:33'),
(457, 'type', 'en', 'type', '2022-06-24 11:01:33'),
(458, 'target', 'en', 'target', '2022-06-24 11:01:33'),
(459, 'fund_total', 'en', 'Total Funds', '2022-06-24 11:01:33'),
(460, 'fund_remain', 'en', 'Remaining Funds', '2022-06-24 11:01:33'),
(461, 'clicks', 'en', 'clicks', '2022-06-24 11:01:33'),
(462, 'views', 'en', 'views', '2022-06-24 11:01:33'),
(463, 'paused', 'en', 'paused', '2022-06-24 11:01:33'),
(464, 'finished', 'en', 'finished', '2022-06-24 11:01:33'),
(465, 'rejected', 'en', 'rejected', '2022-06-24 11:01:33'),
(466, 'content', 'en', 'content', '2022-06-24 11:01:33'),
(467, 'ad_name', 'en', 'Campaign Name', '2022-06-24 11:01:33'),
(468, 'ad_tip13', 'en', 'Banner image. Might hide some part in order to fit into size', '2022-06-24 11:01:33'),
(469, 'ad_tip12', 'en', 'Banner Image', '2022-06-24 11:01:33'),
(470, 'ad_tip11', 'en', 'Small , click-able banner image that will be displayed when audio is playing', '2022-06-24 11:01:33'),
(471, 'ad_tip10', 'en', 'Banner Image', '2022-06-24 11:01:33'),
(472, 'ad_tip9', 'en', 'Maximum 30 seconds. Must be high quality in low size', '2022-06-24 11:01:33'),
(473, 'ad_tip8', 'en', 'Where should we display this ad?', '2022-06-24 11:01:33'),
(474, 'ad_tip7', 'en', 'Audio File', '2022-06-24 11:01:33'),
(475, 'ad_tip6', 'en', 'Placement', '2022-06-24 11:01:33'),
(476, 'ad_tip5', 'en', 'Choose ad type', '2022-06-24 11:01:33'),
(477, 'ad_tip4', 'en', 'Destination URL Address', '2022-06-24 11:01:33'),
(478, 'ad_tip3', 'en', 'Maximum fund per day', '2022-06-24 11:01:33'),
(479, 'ad_tip2', 'en', 'Will be taken from your account fund', '2022-06-24 11:01:33'),
(480, 'ad_tip14', 'en', 'Banner - Pay per view', '2022-06-24 11:01:33'),
(481, 'ad_tip16', 'en', 'Audio - Pay per impression', '2022-06-24 11:01:33'),
(482, 'ad_tip15', 'en', 'Banner - Pay per click', '2022-06-24 11:01:33');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_albums`
--

CREATE TABLE `_m_albums` (
  `ID` int(11) NOT NULL,
  `code` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `hash` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `cover` tinytext COLLATE utf8mb4_bin,
  `url` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `local` int(1) DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_bin,
  `user_id` int(7) DEFAULT NULL,
  `genre_id` int(2) DEFAULT NULL,
  `artist_id` int(6) DEFAULT NULL,
  `artist_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `artist_url` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `spotify_id` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `spotify_hits` int(3) DEFAULT NULL,
  `spotify_completed` int(1) DEFAULT NULL,
  `tracks_count` int(3) DEFAULT NULL,
  `tracks_duration` float DEFAULT NULL,
  `play_full` int(9) DEFAULT '0',
  `play_skip` int(9) DEFAULT '0',
  `play_full_m` int(6) DEFAULT '0',
  `play_skip_m` int(6) DEFAULT '0',
  `play_m` int(4) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `likes` int(7) DEFAULT '0',
  `price` float DEFAULT NULL,
  `purchased` int(7) DEFAULT '0',
  `time_release` datetime DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_play` timestamp NULL DEFAULT NULL,
  `time_spotify_check` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_m_albums`
--

INSERT INTO `_m_albums` (`ID`, `code`, `hash`, `title`, `type`, `cover`, `url`, `local`, `comment`, `user_id`, `genre_id`, `artist_id`, `artist_name`, `artist_url`, `spotify_id`, `spotify_hits`, `spotify_completed`, `tracks_count`, `tracks_duration`, `play_full`, `play_skip`, `play_full_m`, `play_skip_m`, `play_m`, `views`, `likes`, `price`, `purchased`, `time_release`, `time_add`, `time_play`, `time_spotify_check`) VALUES
(1, 'miulênhaccuatuicom', '14edf691df8919397d406d5b01ee82f9', 'NhacCuaTui.com', 'studio', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\uploaded_covers\\62b59c66a0c9c.jpg', 'miu_lê-nhaccuatuicom', 1, NULL, 2, 1, 1, 'Miu Lê', 'miu_lê', NULL, NULL, NULL, 2, 526, 34, 61, 34, 61, 2206, 0, 0, NULL, 0, '2022-04-06 00:00:00', '2022-06-24 11:13:42', '2022-06-25 04:06:58', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_artists`
--

CREATE TABLE `_m_artists` (
  `ID` int(11) NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_bin DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `spotify_id` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `spotify_hits` int(3) DEFAULT NULL,
  `image` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `user_id` int(7) DEFAULT NULL,
  `play_full` int(11) DEFAULT '0',
  `play_skip` int(11) DEFAULT '0',
  `play_full_m` int(7) DEFAULT '0',
  `play_skip_m` int(7) DEFAULT '0',
  `play_m` int(4) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `followers` int(7) DEFAULT '0',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_spotify_search` timestamp NULL DEFAULT NULL,
  `time_play` timestamp NULL DEFAULT NULL,
  `time_release_check` timestamp NULL DEFAULT NULL,
  `time_release` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `_m_artists`
--

INSERT INTO `_m_artists` (`ID`, `code`, `type`, `name`, `url`, `spotify_id`, `spotify_hits`, `image`, `user_id`, `play_full`, `play_skip`, `play_full_m`, `play_skip_m`, `play_m`, `views`, `followers`, `time_add`, `time_spotify_search`, `time_play`, `time_release_check`, `time_release`) VALUES
(1, 'miulê', NULL, 'Miu Lê', 'miu_lê', NULL, NULL, NULL, NULL, 34, 61, 34, 61, 2206, 5, 0, '2022-06-24 11:13:42', NULL, '2022-06-25 04:06:58', NULL, '2022-06-24 11:13:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_genres`
--

CREATE TABLE `_m_genres` (
  `ID` int(4) NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(5) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_m_genres`
--

INSERT INTO `_m_genres` (`ID`, `code`, `name`, `image`, `url`, `time_add`, `deleted`) VALUES
(1, 'nogenre', 'No-Genre', NULL, NULL, '2021-03-22 07:44:55', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_relations`
--

CREATE TABLE `_m_relations` (
  `ID1` int(6) NOT NULL,
  `ID2` int(6) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_sources`
--

CREATE TABLE `_m_sources` (
  `ID` int(6) NOT NULL,
  `hash` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `track_id` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `data` varchar(300) COLLATE utf8mb4_bin NOT NULL,
  `duration` float DEFAULT NULL,
  `wave_bg` tinytext COLLATE utf8mb4_bin,
  `wave_pr` tinytext COLLATE utf8mb4_bin,
  `bitrate` int(6) DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_m_sources`
--

INSERT INTO `_m_sources` (`ID`, `hash`, `track_id`, `type`, `data`, `duration`, `wave_bg`, `wave_pr`, `bitrate`, `time_add`) VALUES
(1, '96323445bcee7f6e1605f860ba43e52a', 1, 'file', 'D:\\laragon\\www\\mymuzik\\uploads\\protected\\220624\\audio\\62b59b9c1f142.mp3', 263, 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\waves\\62b59ca077b6b.png', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\waves\\62b59ca0acf77.png', 128, '2022-06-24 11:13:43'),
(2, '6ddd611f70c780e6dbd2bad22e58463e', 2, 'file', 'D:\\laragon\\www\\mymuzik\\uploads\\protected\\220625\\audio\\62b678ab11636.mp3', 263, 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220625\\waves\\62b67ab524809.png', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220625\\waves\\62b67ab540058.png', 128, '2022-06-25 02:57:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_tracks`
--

CREATE TABLE `_m_tracks` (
  `ID` int(11) NOT NULL,
  `hash` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `code` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `cover` tinytext COLLATE utf8mb4_bin,
  `url` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `local` int(1) DEFAULT NULL,
  `has_source` int(1) DEFAULT NULL,
  `user_id` int(7) DEFAULT NULL,
  `genre_id` int(2) DEFAULT NULL,
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `artist_url` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `artists_featured` text COLLATE utf8mb4_bin,
  `album_id` int(6) DEFAULT NULL,
  `album_order` int(2) DEFAULT NULL,
  `album_artist_id` int(11) DEFAULT NULL,
  `album_title` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `album_url` varchar(250) COLLATE utf8mb4_bin NOT NULL,
  `album_artist_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `album_artist_url` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `sitelink` text COLLATE utf8mb4_bin,
  `soundcloud_url` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `itunes_url` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `youtube_id` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `bandcamp_id` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `spotify_id` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `spotify_hits` int(3) DEFAULT NULL,
  `dl_link` text COLLATE utf8mb4_bin,
  `explicit` int(1) DEFAULT NULL,
  `duration` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `play_full` int(9) DEFAULT '0',
  `play_skip` int(9) DEFAULT '0',
  `play_full_m` int(6) DEFAULT '0',
  `play_skip_m` int(6) DEFAULT '0',
  `play_m` int(4) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `likes` int(7) DEFAULT '0',
  `reposts` int(6) DEFAULT '0',
  `comments` int(6) DEFAULT '0',
  `playlisteds` int(6) DEFAULT '0',
  `downloads` int(11) DEFAULT '0',
  `purchased` int(7) DEFAULT '0',
  `time_release` datetime DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_play` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `_m_tracks`
--

INSERT INTO `_m_tracks` (`ID`, `hash`, `code`, `title`, `cover`, `url`, `local`, `has_source`, `user_id`, `genre_id`, `artist_id`, `artist_name`, `artist_url`, `artists_featured`, `album_id`, `album_order`, `album_artist_id`, `album_title`, `album_url`, `album_artist_name`, `album_artist_url`, `sitelink`, `soundcloud_url`, `itunes_url`, `youtube_id`, `bandcamp_id`, `spotify_id`, `spotify_hits`, `dl_link`, `explicit`, `duration`, `price`, `play_full`, `play_skip`, `play_full_m`, `play_skip_m`, `play_m`, `views`, `likes`, `reposts`, `comments`, `playlisteds`, `downloads`, `purchased`, `time_release`, `time_add`, `time_play`) VALUES
(1, '9e871659f555dbada68fc64d3d9ecd09', 'miulênhaccuatuicomvìmẹanhbắtchiatay', 'Vì Mẹ Anh Bắt Chia Tay', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\uploaded_covers\\62b59c66a0c9c.jpg', 'miu_lê-vì_mẹ_anh_bắt_chia_tay', 1, 1, 2, 1, 1, 'Miu Lê', 'miu_lê', '[]', 1, NULL, 1, 'NhacCuaTui.com', 'miu_lê-nhaccuatuicom', 'Miu Lê', 'miu_lê', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 263, 0, 18, 56, 18, 56, 2206, 13, 0, 1, 0, 0, 0, 0, '2022-04-06 00:00:00', '2022-06-24 11:13:42', '2022-06-25 03:42:47'),
(2, '4f25e85acaf8c796526ba8114721d695', 'miulênhaccuatuicomvìmẹanhbắtchiatay666', 'Vì Mẹ Anh Bắt Chia Tay666', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220625\\uploaded_covers\\62b6798f01cae.jpg', 'miu_lê-vì_mẹ_anh_bắt_chia_tay666', 1, 1, 2, 1, 1, 'Miu Lê', 'miu_lê', '[]', 1, NULL, 1, 'NhacCuaTui.com', 'miu_lê-nhaccuatuicom', 'Miu Lê', 'miu_lê', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 263, NULL, 16, 5, 16, 5, 2206, 12, 0, 0, 0, 0, 0, 0, '2022-05-06 00:00:00', '2022-06-25 02:57:19', '2022-06-25 04:06:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_m_tracks_data`
--

CREATE TABLE `_m_tracks_data` (
  `track_id` int(11) NOT NULL,
  `comment` text COLLATE utf8mb4_bin,
  `lyrics` text COLLATE utf8mb4_bin
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_admin`
--

CREATE TABLE `_setting_admin` (
  `var` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `val` longtext COLLATE utf8mb4_bin NOT NULL,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_setting_admin`
--

INSERT INTO `_setting_admin` (`var`, `val`, `time_update`) VALUES
('ad_audio_iv', '3', '2021-03-14 05:30:45'),
('admin_ids', '1', '2021-03-22 07:52:36'),
('ads_approved', '0', '2021-03-12 21:03:59'),
('ads_hide_bot', '1', '2021-03-14 02:08:53'),
('audio_v_cost', '0.06', '2021-03-14 05:30:35'),
('aws', '0', '2021-03-07 14:36:59'),
('aws_bucket', '', '2021-03-22 07:51:50'),
('aws_endpoint', '', '2021-03-22 07:51:50'),
('aws_key', '', '2021-03-22 07:51:50'),
('aws_protect', '1', '2021-03-18 03:01:36'),
('aws_region', '', '2021-03-22 07:51:50'),
('aws_secret', '', '2021-03-22 07:51:50'),
('bank_data', 'Bank name, Location\r\nAccount number 0000-11-22-33\r\nBusyowl DigiMuse 4:20', '2021-03-22 07:49:53'),
('banner_c_cost', '0.05', '2021-03-14 05:30:35'),
('banner_v_cost', '0.01', '2021-03-14 05:30:35'),
('chunk', '1', '2020-08-13 07:16:51'),
('chunk_size', '1', '2020-08-21 15:23:47'),
('currency', '$', '2020-08-13 11:39:40'),
('currency_code', 'usd', '2020-08-13 07:14:19'),
('currency_format', '%CURRENCY%%.1f', '2021-03-18 05:25:16'),
('default_gid', '4', '2020-08-13 07:01:26'),
('domain', '', '2020-08-13 06:30:12'),
('download_limit', '0', '2020-08-17 18:52:44'),
('download_lock', '0', '2021-03-22 07:52:02'),
('download_range', '120', '2020-08-18 13:51:25'),
('email_s_encrypt', 'tls', '2020-08-13 09:56:13'),
('email_s_host', 'smtp.gmail.com', '2022-06-24 11:54:59'),
('email_s_pass', 'vcroifnxxeklzzhq', '2022-06-24 11:54:59'),
('email_s_port', '587', '2022-06-24 11:54:59'),
('email_s_type', 'smtp', '2022-06-24 11:55:09'),
('email_s_user', 'binno1969.vn@gmail.com', '2022-06-24 11:54:59'),
('ffmpeg', '0', '2021-03-22 07:52:41'),
('ffmpeg_convert', '128', '2021-03-14 03:23:51'),
('ffmpeg_path', '', '2021-03-22 07:52:41'),
('ffmpeg_wave', '0', '2021-03-17 03:11:20'),
('ftp', '0', '2021-03-18 03:10:55'),
('ftp_address', '', '2021-03-22 07:51:50'),
('ftp_password', '', '2021-03-22 07:51:50'),
('ftp_path', '', '2021-03-22 07:51:50'),
('ftp_port', '21', '2021-03-06 13:33:15'),
('ftp_ssl', '0', '2021-03-06 17:03:20'),
('ftp_username', '', '2021-03-22 07:51:50'),
('ftp_web_address', '', '2021-03-22 07:51:50'),
('get_visitor_ip_data', '0', '2020-10-31 04:43:22'),
('heard_ratio', '40', '2020-10-18 00:42:24'),
('landing_page', '1', '2020-07-19 09:33:48'),
('lang', 'en', '2020-08-17 18:50:20'),
('langs', '{\"en\":\"English\"}', '2021-03-17 00:09:33'),
('max_par_ups', '1', '2020-08-17 18:52:32'),
('max_size', '10', '2022-06-25 02:11:48'),
('pay_bank', '0', '2020-10-31 04:43:45'),
('pay_pp', '0', '2020-10-31 04:43:44'),
('pg_op', '1', '2021-03-14 05:30:51'),
('pg_pp', '0', '2021-03-14 05:31:06'),
('pg_pp_k1', '', '2021-03-14 05:31:38'),
('pg_pp_k2', '', '2021-03-14 05:31:38'),
('pg_pp_sb', 'sandbox', '2021-03-22 07:49:44'),
('pg_st', '0', '2021-03-14 05:31:41'),
('pg_st_k1', '', '2021-03-14 05:12:58'),
('pg_st_k2', '', '2021-03-14 05:31:39'),
('popularity_source', 'play_full', '2020-04-12 13:25:45'),
('pp_approved', '0', '2020-08-17 18:52:18'),
('pp_email', '', '2020-08-21 15:24:57'),
('prefer_localfile', '1', '2021-03-10 00:05:36'),
('redirect_single_album', '1', '2020-08-18 13:50:45'),
('req_proxy', '', '2020-08-17 18:50:45'),
('req_proxy_a', '', '2020-08-17 18:50:45'),
('sell_music_prices', '1,2.5,5,7,9.9,15,25,50', '2020-08-17 18:51:59'),
('session_i_lock', '0', '2020-06-26 17:58:18'),
('session_lifetime', '720', '2020-07-20 08:06:23'),
('session_max', '3', '2020-10-26 00:53:22'),
('session_p_lock', '0', '2020-07-20 13:40:04'),
('signup_verified', '1', '2020-08-21 15:23:36'),
('sitename', 'Mysound', '2022-06-24 11:35:37'),
('sl_fb', '0', '2021-03-22 07:52:22'),
('sl_fb_k1', '', '2021-03-22 07:52:22'),
('sl_fb_k2', '', '2021-03-22 07:52:22'),
('sl_ggl', '0', '2021-03-22 07:52:22'),
('sl_ggl_k1', '', '2021-03-09 19:05:47'),
('sl_ggl_k2', '', '2021-03-09 19:05:47'),
('sl_ig', '0', '2021-03-22 07:52:22'),
('sl_ig_k1', '', '2021-03-09 19:05:47'),
('sl_ig_k2', '', '2021-03-09 19:05:47'),
('sl_tw', '0', '2021-03-22 07:52:22'),
('sl_tw_k1', '', '2021-03-22 07:52:22'),
('sl_tw_k2', '', '2021-03-22 07:52:22'),
('spotify_access', '', '2020-10-31 04:43:38'),
('spotify_d_a', '0', '2020-10-31 04:44:11'),
('spotify_d_a_ts', '0', '2020-10-31 04:44:12'),
('spotify_d_ar', '0', '2020-10-31 04:44:37'),
('spotify_d_la_ts', '0', '2020-10-31 04:44:16'),
('spotify_g_c', '0', '2020-10-31 04:44:19'),
('spotify_id', '', '2020-10-31 04:43:35'),
('spotify_key', '', '2020-10-31 04:43:36'),
('spotify_search', '0', '2020-10-31 04:44:38'),
('spotify_upload', '0', '2020-10-31 04:43:47'),
('spotify_upload_d', '0', '2020-06-20 13:41:25'),
('spotify_upload_e', '0', '2020-10-31 04:43:50'),
('spotify_w_u_i', '24', '2020-08-17 18:50:45'),
('station', '0', '2021-03-22 07:48:55'),
('theme_name', 'shady', '2020-10-18 00:42:24'),
('twitter_username', '', '2020-08-17 18:50:07'),
('ua_act', '1,2,24,20,19,14,13,12,8,6,15,10,5,3', '2021-03-22 07:52:36'),
('ua_email', '67,68,69,70,71,72,73,66,74,4,17,11,26,25,16,18,21,7,9,1,2,24,20,19,14,13,12,8,6', '2021-03-22 07:52:36'),
('ua_feed', '1,2,24,20,19,14,13,12,8,6,15,10,5,3', '2021-03-22 07:52:36'),
('ua_not', '67,68,69,70,71,72,73,66,74,4,17,11,26,25,16,18,21,7,9,1,2,24,20,19,14,13,12,8,6', '2021-03-22 07:52:36'),
('up_timeout', '30', '2021-03-22 07:48:55'),
('upgrade_price', '17', '2020-08-17 18:51:59'),
('upload_min_bitrate', '64', '2022-06-25 02:11:48'),
('upload_min_cover', '400', '2022-06-25 02:11:48'),
('upload_write_id3', '1', '2020-08-13 07:16:40'),
('utube_api', '0', '2020-10-31 04:44:09'),
('video_display', '1', '2022-06-24 11:35:37'),
('withdrawal_min', '5', '2020-08-17 18:51:59'),
('youtube_d_t', '0', '2020-10-31 04:44:07'),
('youtube_dl', '1', '2022-06-25 01:59:41'),
('youtube_dl_path', '', '2020-10-31 04:44:42'),
('yt_key', '', '2020-08-13 11:46:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_ads`
--

CREATE TABLE `_setting_ads` (
  `ID` int(6) NOT NULL,
  `user_id` int(7) NOT NULL,
  `order_no` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `type` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `name` tinytext COLLATE utf8mb4_bin NOT NULL,
  `files` text COLLATE utf8mb4_bin,
  `url` tinytext COLLATE utf8mb4_bin,
  `code` mediumtext COLLATE utf8mb4_bin,
  `placements` mediumtext COLLATE utf8mb4_bin,
  `fund_total` float DEFAULT NULL,
  `fund_spent` float DEFAULT '0',
  `fund_remain` float DEFAULT NULL,
  `fund_limit` float DEFAULT NULL,
  `fund_spent_day` float DEFAULT '0',
  `fund_spent_day_code` int(6) DEFAULT NULL,
  `act_clicks` int(11) DEFAULT '0',
  `act_views` int(11) DEFAULT '0',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_update` timestamp NULL DEFAULT NULL,
  `active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_ads_placements`
--

CREATE TABLE `_setting_ads_placements` (
  `ad_id` int(6) NOT NULL,
  `placement_code` varchar(14) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_menu`
--

CREATE TABLE `_setting_menu` (
  `ID` int(3) NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_bin NOT NULL,
  `data` longtext COLLATE utf8mb4_bin NOT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_setting_menu`
--

INSERT INTO `_setting_menu` (`ID`, `name`, `data`, `time_add`) VALUES
(1, 'sidebar', '[{\"title\":\"#discover\",\"page\":\"\",\"icon\":\"home\",\"items\":[{\"title\":\"#home\",\"page\":\"\",\"icon\":\"home-variant-outline\"},{\"title\":\"#trending\",\"page\":\"trending\",\"icon\":\"trending-up\"},{\"title\":\"#albums\",\"page\":\"albums\",\"icon\":\"album\"},{\"title\":\"#tracks\",\"page\":\"tracks\",\"icon\":\"music\"},{\"title\":\"#artists\",\"page\":\"artists\",\"icon\":\"star\"},{\"title\":\"#genres\",\"page\":\"genres\",\"icon\":\"tag\"}]},{\"title\":\"#store\",\"page\":\"store\",\"icon\":\"cart\",\"items\":[{\"title\":\"#browse\",\"page\":\"store\",\"icon\":\"shopping-search\"},{\"title\":\"#purchased\",\"page\":\"user_purchased\",\"icon\":\"basket-outline\"}]},{\"title\":\"#your_music\",\"page\":\"\",\"icon\":\"face-profile\",\"items\":[{\"title\":\"#user_likes\",\"page\":\"user_likes\",\"icon\":\"cards-heart\"},{\"title\":\"#user_reposts\",\"page\":\"user_reposts\",\"icon\":\"repeat\"},{\"title\":\"#user_playlists\",\"page\":\"user_playlists\",\"icon\":\"playlist-music\"}]}]', '2020-10-31 06:32:02'),
(2, 'sidebar_mobile', '[{\"title\":\"#home\",\"page\":\"\",\"icon\":\"home-outline\",\"items\":[]},{\"title\":\"#discover\",\"page\":\"\",\"icon\":\"format-list-bulleted-square\",\"items\":[{\"title\":\"#home\",\"page\":\"\",\"icon\":\"home-variant-outline\"},{\"title\":\"#trending\",\"page\":\"trending\",\"icon\":\"trending-up\"},{\"title\":\"#albums\",\"page\":\"albums\",\"icon\":\"album\"},{\"title\":\"#tracks\",\"page\":\"tracks\",\"icon\":\"music\"},{\"title\":\"#artists\",\"page\":\"artists\",\"icon\":\"star\"},{\"title\":\"#genres\",\"page\":\"genres\",\"icon\":\"tag\"},{\"title\":\"#store\",\"page\":\"store\",\"icon\":\"shopping-search\"},{\"title\":\"#purchased\",\"page\":\"user_purchased\",\"icon\":\"basket-outline\"}]},{\"title\":\"title\",\"page\":\"page\",\"icon\":\"heart\",\"items\":[]}]', '2020-10-31 06:39:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_page`
--

CREATE TABLE `_setting_page` (
  `ID` int(4) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_setting_page`
--

INSERT INTO `_setting_page` (`ID`, `name`, `url`, `active`, `time_add`, `time_update`) VALUES
(1, 'home', '', 1, '2020-10-31 06:01:01', '2020-10-31 06:01:01'),
(2, 'store', 'store', 1, '2020-10-31 06:08:26', '2020-10-31 06:08:26'),
(3, 'albums', 'albums', 1, '2020-10-31 06:16:58', '2020-10-31 06:16:58'),
(4, 'tracks', 'tracks', 1, '2020-10-31 06:21:27', '2020-10-31 06:21:27'),
(5, 'artists', 'artists', 1, '2020-10-31 06:23:02', '2020-10-31 06:23:02'),
(6, 'trending', 'trending', 1, '2020-10-31 06:25:30', '2020-10-31 06:25:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_page_widgets`
--

CREATE TABLE `_setting_page_widgets` (
  `ID` int(3) NOT NULL,
  `page_id` int(5) NOT NULL,
  `widget_order` int(3) DEFAULT NULL,
  `widget_type` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `widget_title` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `widget_setting` mediumtext COLLATE utf8mb4_bin,
  `widget_cache` mediumtext COLLATE utf8mb4_bin,
  `time_update` timestamp NULL DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_setting_page_widgets`
--

INSERT INTO `_setting_page_widgets` (`ID`, `page_id`, `widget_order`, `widget_type`, `widget_title`, `widget_setting`, `widget_cache`, `time_update`, `time_add`) VALUES
(1, 1, 1, 'artist_slider', '#top_artists', '{\"title\":\"#top_artists\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"artist_verified\":\"all\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"play_full\",\"limit\":\"10\",\"wid\":\"c6a7f8a9\"}', NULL, NULL, '2021-03-22 07:38:51'),
(2, 1, 2, 'track_slider', '#new_tracks', '{\"title\":\"#new_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"10\",\"wid\":\"f1550216\"}', NULL, NULL, '2021-03-22 07:38:51'),
(3, 1, 3, 'album_slider', '#new_albums', '{\"title\":\"#new_albums\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"album_type\":\"mixtape,compilation,studio\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"10\",\"wid\":\"276f4e68\"}', NULL, NULL, '2021-03-22 07:38:51'),
(4, 1, 4, 'track_slider', '#premium_tracks', '{\"title\":\"#premium_tracks\",\"linked\":\"store\",\"width\":\"12\",\"pagination\":\"0\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"10\",\"wid\":\"ada17c5a\"}', NULL, NULL, '2021-03-22 07:38:51'),
(5, 2, 1, 'album_slider', '#premium_albums', '{\"title\":\"#premium_albums\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"album_type\":\"mixtape,compilation,studio\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"large\",\"rows\":\"1\",\"sort\":\"time_add\",\"limit\":\"8\",\"wid\":\"08df6388\"}', NULL, NULL, '2021-03-22 07:38:51'),
(6, 2, 2, 'track_slider', '#premium_tracks', '{\"title\":\"#premium_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_add\",\"limit\":\"10\",\"wid\":\"338f73a5\"}', NULL, NULL, '2021-03-22 07:38:51'),
(7, 2, 3, 'track_table', '#top_sellers', '{\"title\":\"#top_sellers\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"sort\":\"purchased\",\"limit\":\"10\",\"wid\":\"1395ebb1\"}', NULL, NULL, '2021-03-22 07:38:51'),
(8, 3, 1, 'album_slider', '#new_albums', '{\"title\":\"#new_albums\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"album_type\":\"mixtape,compilation,studio\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"large\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"8\",\"wid\":\"485a1a89\"}', NULL, NULL, '2021-03-22 07:38:51'),
(9, 3, 2, 'album_slider', '#trending_albums', '{\"title\":\"#trending_albums\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"album_type\":\"mixtape,compilation,studio\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"2\",\"sort\":\"play_full_m\",\"limit\":\"8\",\"wid\":\"0063bfa6\"}', NULL, NULL, '2021-03-22 07:38:51'),
(10, 3, 3, 'album_slider', '#top_albums', '{\"title\":\"#top_albums\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"album_type\":\"mixtape,compilation,studio\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"2\",\"sort\":\"play_full\",\"limit\":\"8\",\"wid\":\"1effde48\"}', NULL, NULL, '2021-03-22 07:38:51'),
(11, 3, 4, 'album_slider', '#premium_albums', '{\"title\":\"#premium_albums\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"album_type\":\"all\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"large\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"8\",\"wid\":\"6b41aa31\"}', NULL, NULL, '2021-03-22 07:38:51'),
(12, 3, 5, 'album_list', '#recently_heard', '{\"title\":\"#recently_heard\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"0\",\"album_type\":\"all\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"columns\":\"3\",\"sort\":\"time_play\",\"limit\":\"12\",\"wid\":\"49907d95\"}', NULL, NULL, '2021-03-22 07:38:51'),
(13, 4, 1, 'track_slider', '#local_tracks', '{\"title\":\"#local_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"local\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"views\",\"limit\":\"10\",\"wid\":\"75371043\"}', NULL, NULL, '2021-03-22 07:38:51'),
(14, 4, 2, 'track_slider', '#new_tracks', '{\"title\":\"#new_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"10\",\"wid\":\"848f6812\"}', NULL, NULL, '2021-03-22 07:38:51'),
(15, 4, 3, 'track_slider', '#trending_tracks', '{\"title\":\"#trending_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"play_full_m\",\"limit\":\"10\",\"wid\":\"9ad4b2ea\"}', NULL, NULL, '2021-03-22 07:38:51'),
(16, 4, 4, 'track_slider', '#top_tracks', '{\"title\":\"#top_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"play_full\",\"limit\":\"10\",\"wid\":\"47c1a127\"}', NULL, NULL, '2021-03-22 07:38:51'),
(17, 4, 5, 'track_slider', '#premium_tracks', '{\"title\":\"#premium_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"time_release\",\"limit\":\"10\",\"wid\":\"7cc05820\"}', NULL, NULL, '2021-03-22 07:38:51'),
(18, 4, 6, 'track_slider', '#most_liked', '{\"title\":\"#most_liked\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"likes\",\"limit\":\"10\",\"wid\":\"c0d35971\"}', NULL, NULL, '2021-03-22 07:38:51'),
(19, 4, 7, 'track_slider', '#most_viewed', '{\"title\":\"#most_viewed\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"priced\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"views\",\"limit\":\"10\",\"wid\":\"049e3898\"}', NULL, NULL, '2021-03-22 07:38:51'),
(20, 4, 8, 'track_table', '#top_sellers', '{\"title\":\"#top_sellers\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"sort\":\"purchased\",\"limit\":\"10\",\"wid\":\"a1b8151a\"}', NULL, NULL, '2021-03-22 07:38:51'),
(21, 4, 9, 'track_table', '#top_downloaded', '{\"title\":\"#top_downloaded\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"sort\":\"downloads\",\"limit\":\"10\",\"wid\":\"ed18cf1c\"}', NULL, NULL, '2021-03-22 07:38:51'),
(22, 5, 1, 'artist_slider', '#top_artists', '{\"title\":\"#top_artists\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"artist_verified\":\"all\",\"size\":\"small\",\"rows\":\"1\",\"sort\":\"play_full\",\"limit\":\"10\",\"wid\":\"11920782\"}', NULL, NULL, '2021-03-22 07:38:51'),
(23, 5, 2, 'artist_slider', '#trending_artists', '{\"title\":\"#trending_artists\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"artist_verified\":\"all\",\"size\":\"small\",\"rows\":\"1\",\"sort\":\"play_skip_m\",\"limit\":\"10\",\"wid\":\"58a5f00b\"}', NULL, NULL, '2021-03-22 07:38:51'),
(24, 5, 3, 'artist_slider', '#verified_artists', '{\"title\":\"#verified_artists\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"artist_verified\":\"yes\",\"size\":\"small\",\"rows\":\"1\",\"sort\":\"play_full\",\"limit\":\"10\",\"wid\":\"d6edbe61\"}', NULL, NULL, '2021-03-22 07:38:51'),
(25, 5, 4, 'artist_slider', '#most_viewed', '{\"title\":\"#most_viewed\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"artist_verified\":\"yes\",\"size\":\"small\",\"rows\":\"1\",\"sort\":\"views\",\"limit\":\"10\",\"wid\":\"9533fb1a\"}', NULL, NULL, '2021-03-22 07:38:51'),
(26, 6, 1, 'track_slider', '#trending_tracks', '{\"title\":\"#trending_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"2\",\"sort\":\"play_full_m\",\"limit\":\"20\",\"wid\":\"5bbb52e9\"}', NULL, NULL, '2021-03-22 07:38:51'),
(27, 6, 2, 'artist_slider', '#trending_artists', '{\"title\":\"#trending_artists\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"artist_verified\":\"all\",\"size\":\"small\",\"rows\":\"1\",\"sort\":\"play_full_m\",\"limit\":\"10\",\"wid\":\"0d0d1374\"}', NULL, NULL, '2021-03-22 07:38:51'),
(28, 6, 3, 'album_slider', '#top_albums', '{\"title\":\"#top_albums\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"album_type\":\"all\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"play_full\",\"limit\":\"8\",\"wid\":\"6f738919\"}', NULL, NULL, '2021-03-22 07:38:51'),
(29, 6, 4, 'album_slider', '#trending_single_albums', '{\"title\":\"#trending_single_albums\",\"linked\":\"\",\"width\":\"6\",\"pagination\":\"1\",\"album_type\":\"single\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"medium\",\"rows\":\"1\",\"sort\":\"play_full_m\",\"limit\":\"8\",\"wid\":\"1fcfc291\"}', NULL, NULL, '2021-03-22 07:38:51'),
(30, 6, 5, 'album_slider', '#trending_albums', '{\"title\":\"#trending_albums\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"album_type\":\"studio\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"size\":\"large\",\"rows\":\"1\",\"sort\":\"play_full_m\",\"limit\":\"8\",\"wid\":\"489cf327\"}', NULL, NULL, '2021-03-22 07:38:51'),
(31, 6, 6, 'track_list', '#top_tracks', '{\"title\":\"#top_tracks\",\"linked\":\"\",\"width\":\"12\",\"pagination\":\"1\",\"source\":\"all\",\"price\":\"all\",\"genre\":\"all\",\"user_id\":\"\",\"columns\":\"2\",\"sort\":\"play_full\",\"limit\":\"8\",\"wid\":\"979c4def\"}', NULL, NULL, '2021-03-22 07:38:51');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_setting_theme`
--

CREATE TABLE `_setting_theme` (
  `ID` int(4) NOT NULL,
  `theme` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `var` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `val` text COLLATE utf8mb4_bin NOT NULL,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_setting_theme`
--

INSERT INTO `_setting_theme` (`ID`, `theme`, `var`, `val`, `time_update`) VALUES
(1, 'shady', 'color', '18ead0', '2022-06-24 11:44:31'),
(2, 'shady', 'navbar_color', '18ead0', '2022-06-24 11:44:31'),
(3, 'shady', 'm_s', '1', '2021-03-22 07:44:20'),
(4, 'shady', 'm_sm', '2', '2021-03-22 07:44:20'),
(5, 'shady', 'logo', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\admin\\62b5a50ed8069.png', '2022-06-24 11:50:38'),
(6, 'shady', 'favicon', 'D:\\laragon\\www\\mymuzik\\uploads\\images\\220624\\admin\\62b5a39f74fa0.png', '2022-06-24 11:44:31'),
(7, 'shady', 'font-family', 'Montserrat', '2021-03-22 07:44:20'),
(8, 'shady', 'term-link', '', '2021-03-22 07:44:20'),
(9, 'shady', 'm_f', '0', '2022-06-24 11:37:16'),
(10, 'shady', 'sl_twitter', '', '2021-03-22 07:44:20'),
(11, 'shady', 'sl_facebook', '', '2021-03-22 07:44:20'),
(12, 'shady', 'sl_instagram', '', '2021-03-22 07:44:20'),
(13, 'shady', 'sl_soundcloud', '', '2021-03-22 07:44:20'),
(14, 'shady', 'sl_spotify', '', '2021-03-22 07:44:20'),
(15, 'shady', 'sl_linkedin', '', '2021-03-22 07:44:20'),
(16, 'shady', 'sl_google', '', '2021-03-22 07:44:20'),
(17, 'shady', 'sign_url', '', '2021-03-22 07:44:20'),
(18, 'shady', 'signature', '© 2021 Mysound', '2022-06-24 11:37:16'),
(19, 'shady', 'java', '', '2021-03-22 07:44:20');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_users`
--

CREATE TABLE `_users` (
  `ID` int(7) NOT NULL,
  `GID` int(2) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_bin DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_bin NOT NULL,
  `external_addresses` text COLLATE utf8mb4_bin,
  `avatar` tinytext COLLATE utf8mb4_bin,
  `bg_img` tinytext COLLATE utf8mb4_bin,
  `artist` int(9) DEFAULT NULL,
  `artist_code` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `verified` int(1) DEFAULT '0',
  `verify_code` varchar(9) COLLATE utf8mb4_bin DEFAULT NULL,
  `fund` float DEFAULT '0',
  `fund_total` float DEFAULT '0',
  `fund_revenue` float DEFAULT '0',
  `followers` int(11) DEFAULT '0',
  `followings` int(5) DEFAULT '0',
  `likes` int(7) DEFAULT '0',
  `reposts` int(7) DEFAULT '0',
  `comments` int(6) DEFAULT '0',
  `comments_likes` int(6) DEFAULT '0',
  `comments_replied` int(6) DEFAULT '0',
  `media_comments` int(7) DEFAULT '0',
  `media_likes` int(7) DEFAULT '0',
  `media_uploads` int(6) DEFAULT '0',
  `playlists` int(5) DEFAULT '0',
  `playlists_likes` int(7) DEFAULT '0',
  `playlists_followers` int(7) DEFAULT '0',
  `feed_setting` tinytext COLLATE utf8mb4_bin,
  `not_setting` tinytext COLLATE utf8mb4_bin,
  `email_setting` tinytext COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_verify` timestamp NULL DEFAULT NULL,
  `time_verify_try` timestamp NULL DEFAULT NULL,
  `time_paid_expire` timestamp NULL DEFAULT NULL,
  `time_notified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_users`
--

INSERT INTO `_users` (`ID`, `GID`, `username`, `name`, `password`, `email`, `external_addresses`, `avatar`, `bg_img`, `artist`, `artist_code`, `verified`, `verify_code`, `fund`, `fund_total`, `fund_revenue`, `followers`, `followings`, `likes`, `reposts`, `comments`, `comments_likes`, `comments_replied`, `media_comments`, `media_likes`, `media_uploads`, `playlists`, `playlists_likes`, `playlists_followers`, `feed_setting`, `not_setting`, `email_setting`, `time_add`, `time_verify`, `time_verify_try`, `time_paid_expire`, `time_notified`) VALUES
(1, 1, 'admin', 'admin', '1', 'admnin', 'admnin', 'admnin', 'admnin', NULL, '1', 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2022-06-24 11:03:35', '2022-06-24 11:52:16', NULL, NULL, NULL),
(2, 1, 'nguyencaotai', NULL, '$2y$10$jw.cChEpOi7qQ8EkT1sGDOybzYeWNr/FxcXox/.bjhlPiL5V2ywLy', 'admintq@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 2, 0, 0, 0, NULL, NULL, NULL, '2022-06-24 11:09:58', NULL, NULL, NULL, '2022-06-25 03:42:43'),
(3, 4, 'nguyencaotaitq', NULL, '$2y$10$ar/PubbjzATTUp8P53bb1OyCfdf.PCm4cASBW0KGaclxN6ADUpPEC', 'nguyencaotai2000@gmail.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2022-06-24 11:56:02', NULL, NULL, NULL, '2022-06-25 03:14:58'),
(4, 4, 'weeeeee', NULL, '$2y$10$rFUOXWkwW0c7VLHtYYCL9u/QkbfnjYgGVlUdSQRNd/RnH8AIjVc7W', 'wifoho6246@serosin.com', NULL, NULL, NULL, NULL, NULL, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, '2022-06-25 02:24:55', NULL, NULL, NULL, '2022-06-25 02:25:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_actions`
--

CREATE TABLE `_user_actions` (
  `ID` int(11) NOT NULL,
  `user_id` int(7) DEFAULT NULL,
  `user_id_2` int(7) DEFAULT NULL,
  `type` int(2) NOT NULL,
  `hook` int(9) NOT NULL,
  `AID` int(11) DEFAULT NULL,
  `extraData` tinytext COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_user_actions`
--

INSERT INTO `_user_actions` (`ID`, `user_id`, `user_id_2`, `type`, `hook`, `AID`, `extraData`, `time_add`) VALUES
(1, NULL, 1, 67, 2, NULL, '{\"country\":\"unkown\"}', '2022-06-24 11:09:58'),
(2, NULL, 2, 17, 2, NULL, NULL, '2022-06-24 11:10:00'),
(3, 2, NULL, 3, 1, NULL, NULL, '2022-06-24 11:13:42'),
(4, NULL, 1, 74, 2, NULL, '{\"track_count\":1}', '2022-06-24 11:13:43'),
(6, NULL, 1, 67, 3, NULL, '{\"country\":\"unkown\"}', '2022-06-24 11:56:02'),
(7, NULL, 3, 17, 3, NULL, NULL, '2022-06-24 11:56:02'),
(8, NULL, 1, 67, 4, NULL, '{\"country\":\"unkown\"}', '2022-06-25 02:24:55'),
(9, NULL, 4, 17, 4, NULL, NULL, '2022-06-25 02:24:55'),
(10, 2, NULL, 3, 2, NULL, NULL, '2022-06-25 02:57:19'),
(11, NULL, 1, 74, 2, NULL, '{\"track_count\":1}', '2022-06-25 02:57:20'),
(12, 2, NULL, 2, 1, NULL, NULL, '2022-06-25 03:12:37');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_artist_reqs`
--

CREATE TABLE `_user_artist_reqs` (
  `ID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `real_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `stage_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `files` text COLLATE utf8mb4_bin,
  `data` text COLLATE utf8mb4_bin,
  `approved` int(1) DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_approve` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_comments`
--

CREATE TABLE `_user_comments` (
  `ID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `user_id` int(7) NOT NULL,
  `target_type` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `target_id` int(11) NOT NULL,
  `target_seek` float DEFAULT NULL,
  `text` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `likes` int(6) DEFAULT '0',
  `approved` int(1) NOT NULL,
  `depth` int(1) DEFAULT '1',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_downloads`
--

CREATE TABLE `_user_downloads` (
  `ID` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `track_name` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `source_id` int(11) NOT NULL,
  `source_file` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `source_file_size` int(11) NOT NULL,
  `user_sess_id` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_ip` varchar(15) COLLATE utf8mb4_bin NOT NULL,
  `user_agent` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `key1` varchar(12) COLLATE utf8mb4_bin NOT NULL,
  `key2` varchar(12) COLLATE utf8mb4_bin NOT NULL,
  `key3` varchar(12) COLLATE utf8mb4_bin NOT NULL,
  `key4` varchar(12) COLLATE utf8mb4_bin NOT NULL,
  `uses` int(3) DEFAULT '0',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_expire` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_groups`
--

CREATE TABLE `_user_groups` (
  `ID` int(2) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `ui_access` mediumtext COLLATE utf8mb4_bin,
  `be_access` mediumtext COLLATE utf8mb4_bin,
  `muse_access` int(1) DEFAULT '0',
  `premium_access` int(1) DEFAULT '0',
  `upload_access` int(1) DEFAULT '0',
  `download_access` int(1) DEFAULT '0',
  `sell_access` int(1) DEFAULT '0',
  `sell_share` int(3) DEFAULT '75',
  `upgrade_access` int(1) DEFAULT '0',
  `signup_access` int(1) DEFAULT '0',
  `artist_req_access` int(1) DEFAULT '0',
  `report_access` int(1) DEFAULT '0',
  `admin_access` int(1) DEFAULT '0',
  `comment_access` int(1) DEFAULT '0',
  `language_access` int(1) DEFAULT '0',
  `notification_access` int(1) DEFAULT '0',
  `advertisement_access` int(1) DEFAULT '0',
  `hide_advertisement_access` int(1) DEFAULT NULL,
  `hq_audio_access` int(1) DEFAULT '0',
  `verified` int(1) DEFAULT '0',
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_user_groups`
--

INSERT INTO `_user_groups` (`ID`, `name`, `ui_access`, `be_access`, `muse_access`, `premium_access`, `upload_access`, `download_access`, `sell_access`, `sell_share`, `upgrade_access`, `signup_access`, `artist_req_access`, `report_access`, `admin_access`, `comment_access`, `language_access`, `notification_access`, `advertisement_access`, `hide_advertisement_access`, `hq_audio_access`, `verified`, `time_add`, `time_update`) VALUES
(1, 'admin', '[\"*\"]', '[\"*\"]', 1, 1, 1, 1, 1, 100, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, '2020-04-29 00:06:58', '2021-03-22 07:53:04'),
(2, 'artist', NULL, NULL, 1, 0, 1, 1, 1, 75, 1, 0, 0, 1, 0, 1, 1, 1, 1, 0, 1, 1, '2020-04-29 00:07:14', '2021-03-13 07:32:25'),
(3, 'paid', NULL, NULL, 1, 1, 0, 1, 0, 75, 0, 0, 1, 1, 0, 0, 1, 1, 1, 1, 1, 0, '2020-04-29 00:07:17', '2021-03-22 07:53:32'),
(4, 'user', NULL, NULL, 1, 0, 1, 1, 0, 75, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 1, 0, '2020-04-29 00:07:27', '2021-03-22 07:54:26'),
(5, 'guest', NULL, NULL, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2020-08-08 03:38:09', '2021-03-14 03:04:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_heard`
--

CREATE TABLE `_user_heard` (
  `ID` int(11) NOT NULL,
  `user_id` int(7) NOT NULL,
  `track_id` int(11) NOT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_user_heard`
--

INSERT INTO `_user_heard` (`ID`, `user_id`, `track_id`, `time_add`) VALUES
(1, 2, 1, '2022-06-24 11:18:23'),
(2, 2, 1, '2022-06-24 11:41:49'),
(3, 2, 1, '2022-06-25 01:42:10'),
(4, 2, 1, '2022-06-25 01:46:34'),
(5, 2, 1, '2022-06-25 01:50:57'),
(6, 2, 1, '2022-06-25 01:55:21'),
(7, 2, 1, '2022-06-25 01:59:44'),
(8, 2, 1, '2022-06-25 02:04:08'),
(9, 2, 1, '2022-06-25 02:08:31'),
(10, 2, 1, '2022-06-25 02:12:54'),
(11, 2, 1, '2022-06-25 02:17:17'),
(12, 2, 1, '2022-06-25 02:21:40'),
(13, 2, 1, '2022-06-25 02:26:03'),
(14, 2, 1, '2022-06-25 02:30:26'),
(15, 2, 1, '2022-06-25 02:34:50'),
(16, 2, 2, '2022-06-25 03:07:33'),
(17, 2, 1, '2022-06-25 03:17:33'),
(18, 2, 2, '2022-06-25 03:21:57'),
(19, 2, 1, '2022-06-25 03:29:57'),
(20, 2, 2, '2022-06-25 03:34:20'),
(21, 2, 1, '2022-06-25 03:38:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_playlists`
--

CREATE TABLE `_user_playlists` (
  `ID` int(6) NOT NULL,
  `user_id` int(7) NOT NULL,
  `hash` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `url` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `cover` tinytext COLLATE utf8mb4_bin,
  `track_count` int(3) DEFAULT '0',
  `likes` int(7) DEFAULT '0',
  `followers` int(7) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `collabs` text COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_playlists_relations`
--

CREATE TABLE `_user_playlists_relations` (
  `playlist_id` int(6) NOT NULL,
  `track_id` int(9) NOT NULL,
  `sort` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_purchases`
--

CREATE TABLE `_user_purchases` (
  `ID` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `item_type` varchar(10) COLLATE utf8mb4_bin NOT NULL,
  `item_id` int(9) NOT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_relations`
--

CREATE TABLE `_user_relations` (
  `user_id` int(7) NOT NULL,
  `rel_type` int(2) NOT NULL,
  `target_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_reports`
--

CREATE TABLE `_user_reports` (
  `ID` int(11) NOT NULL,
  `user_id` int(7) NOT NULL,
  `type` int(2) NOT NULL,
  `hook` int(9) NOT NULL,
  `reason` mediumtext COLLATE utf8mb4_bin,
  `dismissed` int(1) DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_sessions`
--

CREATE TABLE `_user_sessions` (
  `ID` int(11) NOT NULL,
  `session_extra_id` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `session_id` varchar(60) COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(7) NOT NULL,
  `ip` varchar(18) COLLATE utf8mb4_bin NOT NULL,
  `ip_country` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `platform_type` varchar(30) COLLATE utf8mb4_bin NOT NULL,
  `platform_os` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `platform_browser` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `time_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_user_sessions`
--

INSERT INTO `_user_sessions` (`ID`, `session_extra_id`, `session_id`, `user_id`, `ip`, `ip_country`, `platform_type`, `platform_os`, `platform_browser`, `time_update`, `time_add`, `active`) VALUES
(2, 'bcde91f8cbc01', 'amhpvckadk8ll5nravu2jouv03', 2, '127.0.0.1', NULL, 'desktop', 'windows', 'chrome', '2022-06-25 04:07:28', '2022-06-24 11:30:05', 1),
(3, 'e8e3829197a209e00', 'aomf0pod1rin164krgocpngciv', 3, '127.0.0.1', NULL, 'desktop', 'windows', 'chrome', '2022-06-25 04:08:48', '2022-06-24 11:56:02', 1),
(4, '62b7363d5853672304c', 'k1ke1v0ugfh3gsc55qk7mnck1b', 4, '127.0.0.1', NULL, 'desktop', 'windows', 'chrome', '2022-06-25 02:25:40', '2022-06-25 02:24:55', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_transaction`
--

CREATE TABLE `_user_transaction` (
  `ID` int(7) NOT NULL,
  `order_no` varchar(10) COLLATE utf8mb4_bin DEFAULT NULL,
  `user_id` int(7) NOT NULL,
  `user_fund` float DEFAULT NULL,
  `type` varchar(3) COLLATE utf8mb4_bin NOT NULL,
  `amount` float NOT NULL,
  `data` text COLLATE utf8mb4_bin,
  `data_txn_id` varchar(30) COLLATE utf8mb4_bin DEFAULT NULL,
  `completed` int(1) DEFAULT NULL,
  `paid` int(1) DEFAULT NULL,
  `funding` int(1) DEFAULT '0',
  `withdrawing` int(1) DEFAULT NULL,
  `image` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL,
  `revenue` float DEFAULT NULL,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_completed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `_user_uploads`
--

CREATE TABLE `_user_uploads` (
  `ID` int(11) NOT NULL,
  `userID` int(7) NOT NULL,
  `rID` varchar(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `uploadID` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `originalName` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `fileName` tinytext COLLATE utf8mb4_bin NOT NULL,
  `waveData` text COLLATE utf8mb4_bin,
  `tagData` longtext COLLATE utf8mb4_bin,
  `spotifyData` longtext COLLATE utf8mb4_bin,
  `youtubeData` longtext COLLATE utf8mb4_bin,
  `finalData` longtext COLLATE utf8mb4_bin,
  `time_add` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `time_removed` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `_user_uploads`
--

INSERT INTO `_user_uploads` (`ID`, `userID`, `rID`, `uploadID`, `originalName`, `fileName`, `waveData`, `tagData`, `spotifyData`, `youtubeData`, `finalData`, `time_add`, `time_removed`) VALUES
(1, 2, 'd880a5d39a734e95560e3a98b9e4b146', '235b6148ce8a64ca9740', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220624\\raw\\62b59b9c1f142.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220624\\\\\\\\attached_covers_edited\\\\\\\\62b59b9e061a5.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":null,\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":[\"2022-04-06 00:00:00\",6],\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220624\\\\\\\\attached_covers_edited\\\\\\\\62b59b9e061a5.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":0,\"rID\":\"d880a5d39a734e95560e3a98b9e4b146\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220624\\\\\\\\attached_covers_edited\\\\\\\\62b59b9e061a5.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_ID\":null,\"album_price\":null}', '2022-06-24 11:10:22', '2022-06-24 11:13:43'),
(2, 2, '1479a3a20869d2bfb836f85e85e6cfb2', '62b74fd0dec79b8cbc13', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220625\\raw\\62b66df35aa6f.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66df3bd14e.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":null,\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":null,\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66df3bd14e.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":0,\"rID\":\"1479a3a20869d2bfb836f85e85e6cfb2\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66df3bd14e.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay\"}', '2022-06-25 02:07:48', NULL),
(3, 2, '4b3fae4547b43954bd32d463c47607a3', 'd8d5ab35e802e713ac44', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220625\\raw\\62b66fdc58bea.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66fdca73ba.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":null,\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":\"2022-05-06\",\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66fdca73ba.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":null,\"rID\":\"4b3fae4547b43954bd32d463c47607a3\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b66fdca73ba.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"code\":\"miulênhaccuatuicomvìmẹanhbắtchiatay\",\"album_code\":\"miulênhaccuatuicom\",\"album_spotify_ID\":null,\"album_spotify_cover\":null,\"artists_featured\":null,\"originalName\":\"ViMeAnhBatChiaTay-MiuLe-7503053.mp3\",\"fileName\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\aw\\\\\\\\62b66fdc58bea.mp3\",\"waveData\":null,\"ID\":\"3\",\"lyrics\":null,\"spotify_album_ID\":null,\"album_price\":null}', '2022-06-25 02:15:56', NULL),
(4, 4, '7a9aa15cb44ca0835379f8ada1fc3af2', '18881fe77be79d786619', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220625\\raw\\62b672095bbd5.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b67209971cb.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":null,\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":null,\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b67209971cb.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":0,\"rID\":\"7a9aa15cb44ca0835379f8ada1fc3af2\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b67209971cb.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay\"}', '2022-06-25 02:25:13', NULL),
(5, 2, 'cb4b8b4d1f8deb67b3db4666a2ecdc9e', '7420511143e0d656e065', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220625\\raw\\62b6766e38f20.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b6766eac43d.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":null,\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":null,\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b6766eac43d.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":0,\"rID\":\"cb4b8b4d1f8deb67b3db4666a2ecdc9e\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b6766eac43d.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay\"}', '2022-06-25 02:43:58', NULL),
(6, 2, '8793417c3abd399a2d0519361fa573f0', 'bd7862910f1906cda999', 'ViMeAnhBatChiaTay-MiuLe-7503053.mp3', 'D:\\laragon\\www\\mymuzik\\uploads\\uploading\\220625\\raw\\62b678ab11636.mp3', NULL, '{\"title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"artist_name\":\"Miu Lê\",\"album_order\":null,\"album_title\":\"NhacCuaTui.com\",\"album_artist_name\":\"Miu Lê\",\"album_time\":null,\"genre\":null,\"duration\":\"262.00816330892\",\"bitrate\":128,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b678ab8031d.jpg\"}', NULL, NULL, '{\"album_artist_name\":\"Miu Lê\",\"album_comment\":null,\"album_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\uploaded_covers\\\\\\\\62b6797503ea0.jpg\",\"album_genre\":\"nogenre\",\"album_order\":null,\"album_time\":\"2022-05-06\",\"album_title\":\"NhacCuaTui.com\",\"album_type\":\"studio\",\"artist_name\":\"Miu Lê\",\"bitrate\":128,\"comment\":null,\"cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\uploaded_covers\\\\\\\\62b6797503ea0.jpg\",\"duration\":263,\"genre\":\"nogenre\",\"price\":null,\"rID\":\"8793417c3abd399a2d0519361fa573f0\",\"source_album_artist_name\":\"Miu Lê\",\"source_album_comment\":null,\"source_album_cover\":null,\"source_album_order\":null,\"source_album_time\":null,\"source_album_title\":\"NhacCuaTui.com\",\"source_album_type\":null,\"source_artist_name\":\"Miu Lê\",\"source_bitrate\":128,\"source_comment\":null,\"source_cover\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\\\\\\\attached_covers_edited\\\\\\\\62b678ab8031d.jpg\",\"source_duration\":263,\"source_genre\":null,\"source_title\":\"Vì Mẹ Anh Bắt Chia Tay\",\"spotify_album_artist_name\":null,\"spotify_album_comment\":null,\"spotify_album_cover\":null,\"spotify_album_order\":null,\"spotify_album_time\":null,\"spotify_album_title\":null,\"spotify_album_type\":null,\"spotify_artist_name\":null,\"spotify_artists_featured\":null,\"spotify_comment\":null,\"spotify_cover\":null,\"spotify_duration\":null,\"spotify_explicit\":null,\"spotify_genre\":null,\"spotify_hits\":null,\"spotify_title\":null,\"title\":\"Vì Mẹ Anh Bắt Chia Tay666\",\"spotify_album_ID\":null,\"album_price\":null,\"code\":\"miulênhaccuatuicomvìmẹanhbắtchiatay\",\"album_code\":\"miulênhaccuatuicom\",\"album_spotify_ID\":null,\"album_spotify_cover\":null,\"artists_featured\":null,\"originalName\":\"ViMeAnhBatChiaTay-MiuLe-7503053.mp3\",\"fileName\":\"D:\\\\\\\\laragon\\\\\\\\www\\\\\\\\mymuzik\\\\\\\\uploads\\\\\\\\uploading\\\\\\\\220625\\aw\\\\\\\\62b678ab11636.mp3\",\"waveData\":null,\"ID\":\"6\",\"lyrics\":null}', '2022-06-25 02:53:32', '2022-06-25 02:57:20');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `_blocked_ips`
--
ALTER TABLE `_blocked_ips`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IP` (`IP`,`until`),
  ADD KEY `IP_2` (`IP`);

--
-- Chỉ mục cho bảng `_curl_cache`
--
ALTER TABLE `_curl_cache`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `hashID` (`hashID`,`time_start`);

--
-- Chỉ mục cho bảng `_debug`
--
ALTER TABLE `_debug`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `_emails`
--
ALTER TABLE `_emails`
  ADD PRIMARY KEY (`ID`);

--
-- Chỉ mục cho bảng `_hits`
--
ALTER TABLE `_hits`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ip` (`ip`),
  ADD KEY `time_add` (`time_add`),
  ADD KEY `page_type` (`page_type`),
  ADD KEY `request_sessid` (`request_sessid`),
  ADD KEY `agent_type` (`agent_type`),
  ADD KEY `agent_os` (`agent_os`),
  ADD KEY `agent_browser` (`agent_browser`);

--
-- Chỉ mục cho bảng `_langs`
--
ALTER TABLE `_langs`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `hook` (`hook`,`lang`);

--
-- Chỉ mục cho bảng `_m_albums`
--
ALTER TABLE `_m_albums`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `type` (`type`),
  ADD KEY `play_m` (`play_m`),
  ADD KEY `local` (`local`),
  ADD KEY `price` (`price`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `spotify_id` (`spotify_id`),
  ADD KEY `hash` (`hash`);

--
-- Chỉ mục cho bảng `_m_artists`
--
ALTER TABLE `_m_artists`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `spotify_id` (`spotify_id`),
  ADD KEY `play_m` (`play_m`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `_m_genres`
--
ALTER TABLE `_m_genres`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `code` (`code`);

--
-- Chỉ mục cho bảng `_m_relations`
--
ALTER TABLE `_m_relations`
  ADD PRIMARY KEY (`ID1`,`ID2`,`type`),
  ADD KEY `ID1` (`ID1`,`type`),
  ADD KEY `ID2` (`ID2`,`type`);

--
-- Chỉ mục cho bảng `_m_sources`
--
ALTER TABLE `_m_sources`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `track_id` (`track_id`,`type`),
  ADD KEY `track_id_2` (`track_id`);

--
-- Chỉ mục cho bảng `_m_tracks`
--
ALTER TABLE `_m_tracks`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `play_m` (`play_m`),
  ADD KEY `price` (`price`),
  ADD KEY `spotify_id` (`spotify_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `local` (`local`),
  ADD KEY `album_id` (`album_id`);

--
-- Chỉ mục cho bảng `_m_tracks_data`
--
ALTER TABLE `_m_tracks_data`
  ADD PRIMARY KEY (`track_id`);

--
-- Chỉ mục cho bảng `_setting_admin`
--
ALTER TABLE `_setting_admin`
  ADD PRIMARY KEY (`var`);

--
-- Chỉ mục cho bảng `_setting_ads`
--
ALTER TABLE `_setting_ads`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `get_4_display` (`type`,`fund_remain`,`fund_limit`,`fund_spent_day`,`fund_spent_day_code`,`active`) USING BTREE,
  ADD KEY `type` (`type`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_no` (`order_no`),
  ADD KEY `order_no_2` (`order_no`,`active`),
  ADD KEY `active` (`active`);

--
-- Chỉ mục cho bảng `_setting_ads_placements`
--
ALTER TABLE `_setting_ads_placements`
  ADD PRIMARY KEY (`ad_id`,`placement_code`);

--
-- Chỉ mục cho bảng `_setting_menu`
--
ALTER TABLE `_setting_menu`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `_setting_page`
--
ALTER TABLE `_setting_page`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `active` (`active`);

--
-- Chỉ mục cho bảng `_setting_page_widgets`
--
ALTER TABLE `_setting_page_widgets`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `page_name` (`page_id`),
  ADD KEY `widget_type` (`widget_type`,`time_update`),
  ADD KEY `widget_type_2` (`widget_type`);

--
-- Chỉ mục cho bảng `_setting_theme`
--
ALTER TABLE `_setting_theme`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `theme` (`theme`,`var`);

--
-- Chỉ mục cho bảng `_users`
--
ALTER TABLE `_users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `verified` (`verified`,`verify_code`,`time_verify_try`),
  ADD KEY `GID` (`GID`);

--
-- Chỉ mục cho bảng `_user_actions`
--
ALTER TABLE `_user_actions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_type_hook` (`user_id`,`type`,`hook`) USING BTREE,
  ADD KEY `type_hook` (`type`,`hook`) USING BTREE;

--
-- Chỉ mục cho bảng `_user_artist_reqs`
--
ALTER TABLE `_user_artist_reqs`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `approved` (`approved`);

--
-- Chỉ mục cho bảng `_user_comments`
--
ALTER TABLE `_user_comments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `target_type` (`target_type`,`target_id`,`approved`),
  ADD KEY `PID` (`PID`);

--
-- Chỉ mục cho bảng `_user_downloads`
--
ALTER TABLE `_user_downloads`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `key1` (`key1`,`time_add`),
  ADD KEY `track_id` (`track_id`,`user_id`,`uses`);

--
-- Chỉ mục cho bảng `_user_groups`
--
ALTER TABLE `_user_groups`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `_user_heard`
--
ALTER TABLE `_user_heard`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_type_hook` (`user_id`,`track_id`) USING BTREE,
  ADD KEY `type_hook` (`track_id`) USING BTREE;

--
-- Chỉ mục cho bảng `_user_playlists`
--
ALTER TABLE `_user_playlists`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `hash` (`hash`);

--
-- Chỉ mục cho bảng `_user_playlists_relations`
--
ALTER TABLE `_user_playlists_relations`
  ADD PRIMARY KEY (`playlist_id`,`track_id`);

--
-- Chỉ mục cho bảng `_user_purchases`
--
ALTER TABLE `_user_purchases`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `type` (`item_type`,`user_id`,`item_id`);

--
-- Chỉ mục cho bảng `_user_relations`
--
ALTER TABLE `_user_relations`
  ADD PRIMARY KEY (`user_id`,`rel_type`,`target_id`);

--
-- Chỉ mục cho bảng `_user_reports`
--
ALTER TABLE `_user_reports`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id_type_hook` (`user_id`,`type`,`hook`) USING BTREE,
  ADD KEY `type_hook` (`type`,`hook`) USING BTREE;

--
-- Chỉ mục cho bảng `_user_sessions`
--
ALTER TABLE `_user_sessions`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `session_extra_id` (`session_extra_id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `active` (`active`);

--
-- Chỉ mục cho bảng `_user_transaction`
--
ALTER TABLE `_user_transaction`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `data_txn_id` (`data_txn_id`),
  ADD KEY `order_no` (`order_no`),
  ADD KEY `completed` (`completed`),
  ADD KEY `time_add` (`time_add`),
  ADD KEY `time_completed` (`time_completed`),
  ADD KEY `paid` (`paid`);

--
-- Chỉ mục cho bảng `_user_uploads`
--
ALTER TABLE `_user_uploads`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`,`uploadID`),
  ADD KEY `time_add` (`time_add`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `_blocked_ips`
--
ALTER TABLE `_blocked_ips`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_curl_cache`
--
ALTER TABLE `_curl_cache`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_debug`
--
ALTER TABLE `_debug`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_emails`
--
ALTER TABLE `_emails`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `_hits`
--
ALTER TABLE `_hits`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=315;

--
-- AUTO_INCREMENT cho bảng `_langs`
--
ALTER TABLE `_langs`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT cho bảng `_m_albums`
--
ALTER TABLE `_m_albums`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `_m_artists`
--
ALTER TABLE `_m_artists`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `_m_genres`
--
ALTER TABLE `_m_genres`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `_m_sources`
--
ALTER TABLE `_m_sources`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `_m_tracks`
--
ALTER TABLE `_m_tracks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `_setting_ads`
--
ALTER TABLE `_setting_ads`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_setting_menu`
--
ALTER TABLE `_setting_menu`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `_setting_page`
--
ALTER TABLE `_setting_page`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `_setting_page_widgets`
--
ALTER TABLE `_setting_page_widgets`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `_setting_theme`
--
ALTER TABLE `_setting_theme`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `_users`
--
ALTER TABLE `_users`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `_user_actions`
--
ALTER TABLE `_user_actions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `_user_artist_reqs`
--
ALTER TABLE `_user_artist_reqs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_comments`
--
ALTER TABLE `_user_comments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_downloads`
--
ALTER TABLE `_user_downloads`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_groups`
--
ALTER TABLE `_user_groups`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `_user_heard`
--
ALTER TABLE `_user_heard`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `_user_playlists`
--
ALTER TABLE `_user_playlists`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_purchases`
--
ALTER TABLE `_user_purchases`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_reports`
--
ALTER TABLE `_user_reports`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_sessions`
--
ALTER TABLE `_user_sessions`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `_user_transaction`
--
ALTER TABLE `_user_transaction`
  MODIFY `ID` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `_user_uploads`
--
ALTER TABLE `_user_uploads`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
