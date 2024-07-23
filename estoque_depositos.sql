-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           11.4.2-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando dados para a tabela estoque_depositos.exclusoes: ~2 rows (aproximadamente)
REPLACE INTO `exclusoes` (`id`, `material_id`, `motivo`, `data_exclusao`) VALUES
	(7, 6, 'tst', '2024-07-19 20:29:27'),
	(8, 6, 'teste', '2024-07-20 11:40:18'),
	(9, 6, 'teste', '2024-07-20 11:52:00'),
	(10, 6, 'tst', '2024-07-20 12:25:58'),
	(11, 6, 'tst', '2024-07-20 17:27:02'),
	(12, 6, 'tst', '2024-07-20 17:27:06'),
	(13, 6, 'teste', '2024-07-20 17:27:35'),
	(14, 6, 'teste', '2024-07-20 17:28:31'),
	(15, 7, 'teste', '2024-07-20 17:36:45'),
	(16, 8, 'te', '2024-07-20 17:47:09'),
	(17, 9, 'et', '2024-07-20 17:47:12'),
	(18, 11, 'teste', '2024-07-23 01:35:26'),
	(19, 16, 'teste', '2024-07-23 02:11:15'),
	(20, 17, 'teste', '2024-07-23 15:40:07');

-- Copiando dados para a tabela estoque_depositos.materiais: ~6 rows (aproximadamente)
REPLACE INTO `materiais` (`id`, `nome`, `descricao`, `foto`, `disponivel`) VALUES
	(10, 'pia', 'pia', 'Captura de tela 2024-07-19 164054.png', 1),
	(12, 'mesa ', 'branca 120,60', 'Captura de tela 2024-07-22 165806.png', 1),
	(13, 'picareta', 'teste', 'Captura de tela 2024-07-20 093208.png', 0),
	(14, 'mesa ', 'branca', 'Captura de tela 2024-07-22 165806.png', 1),
	(15, 'pia', 'pia', 'Captura de tela 2024-07-19 164054.png', 1),
	(18, 'escada', 'escada de alumÃ­nio', 'Captura de tela 2024-07-23 095733.png', 0),
	(19, 'porta', 'porta 90cm', 'Captura de tela 2024-07-23 095827.png', 1),
	(20, 'tinta de textura', 'bege', 'Captura de tela 2024-07-23 100109.png', 1),
	(21, 'pneu', 'aro 14', 'Captura de tela 2024-07-23 100144.png', 1);

-- Copiando dados para a tabela estoque_depositos.movimentacoes: ~0 rows (aproximadamente)
REPLACE INTO `movimentacoes` (`id`, `material_id`, `data_retirada`, `data_devolucao`, `retirado_por`, `destino`) VALUES
	(5, 7, '2024-07-20', '2024-07-20', 'eduardo', 'toca'),
	(6, 12, '2024-07-22', '2024-07-22', 'eduardo', 'toca'),
	(7, 11, '2024-07-22', '2024-07-22', 'eduardo', 'toca'),
	(8, 10, '2024-07-22', '2024-07-23', 'eduardo', 'toca'),
	(9, 12, '2024-07-22', '2024-07-23', 'eduardo', 'toca'),
	(10, 12, '2024-07-22', '2024-07-23', 'eduardo', 'toca'),
	(11, 18, '2024-07-23', '2024-07-23', 'eduardo', 'toca'),
	(12, 13, '2024-07-23', NULL, 'eduardo', 'toca'),
	(13, 18, '2024-07-23', NULL, 'eduardo', 'toca');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
