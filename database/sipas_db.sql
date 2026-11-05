CREATE DATABASE IF NOT EXISTS sipas_db;
USE sipas_db;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'warga',
  PRIMARY KEY (`id`)
);

-- Password '123456' dienkripsi menggunakan MD5
INSERT INTO `users` (`nama`, `username`, `password`, `role`) VALUES
('Bpk. Ahmad (Warga RT 01)', 'warga', 'e10adc3949ba59abbe56e057f20f883e', 'warga'),
('Admin RT', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin');
