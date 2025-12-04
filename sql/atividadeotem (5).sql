-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/12/2025 às 04:22
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `atividadeotem`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alimentacao`
--

CREATE TABLE `alimentacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `funcionamento` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `foto` mediumtext DEFAULT NULL,
  `lugar` varchar(200) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `abertura` time DEFAULT '11:00:00',
  `fechamento` time DEFAULT '14:30:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alimentacao`
--

INSERT INTO `alimentacao` (`id`, `nome`, `endereco`, `horario`, `funcionamento`, `telefone`, `foto`, `lugar`, `lat`, `lng`, `abertura`, `fechamento`) VALUES
(1, 'Restaurante Popular de Porto Alegre - Centro', 'Centro - rua Garibaldi, 461, Bom Fim - Porto Alegre', '11h às 14h30', 'segunda a domingo', '(51)99724-3043', 'mapaBomFim.png', 'alimentacaoBomFim.png', -30.029612, -51.213756, '11:00:00', '14:30:00'),
(2, 'Restaurante Popular de Porto Alegre - Vila Cruzeiro', 'VILA CRUZEIRO - rua Dona Otília, 210 - Porto Alegre', '11h às 14h30', 'segunda a sexta', NULL, 'imagem.png', '', -30.071543, -51.21859, '11:00:00', '14:30:00'),
(3, 'Restaurante Popular de Porto Alegre - Lomba do Pinheiro', 'Lomba do Pinheiro - rua Cacimbas, 159 - Porto Alegre', '11h às 14h30', 'segunda a sexta', NULL, 'mapaLombaPin.png', 'alimentacaoLombaPin.png', -30.134021, -51.127088, '11:00:00', '14:30:00'),
(4, 'Restaurante Popular de Porto Alegre - Restinga', 'Restinga - Estrada do Barro Vermelho, 51 - Porto Alegre', '11h às 14h30', 'segunda a sexta', '(51)3361-7672', 'imagem.png', '', -30.154578, -51.144012, '11:00:00', '14:30:00'),
(5, 'Restaurante Popular de Porto Alegre - Rubem Berta', 'Rubem Berta - rua Caetano Fulginiti, 95 - Porto Alegre', '11h às 14h30', 'segunda a sexta', NULL, 'imagem.png', '', -30.007534, -51.109567, '11:00:00', '14:30:00'),
(6, 'Restaurante Popular de Porto Alegre - Ilhas', 'Rua Oscar Schmitt, 67, Ilha da Pintada - Porto Alegre', '11h às 14h30', 'segunda a sexta', NULL, 'mapaIlhas.png', 'alimentacaoIlha.png', -30.02609, -51.240045, '11:00:00', '14:30:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `centropop`
--

CREATE TABLE `centropop` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `funcionamento` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `foto` mediumtext DEFAULT NULL,
  `lugar` varchar(200) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `abertura` time DEFAULT '08:00:00',
  `fechamento` time DEFAULT '17:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `centropop`
--

INSERT INTO `centropop` (`id`, `nome`, `endereco`, `horario`, `funcionamento`, `telefone`, `foto`, `lugar`, `lat`, `lng`, `abertura`, `fechamento`) VALUES
(1, 'Centro Pop 1 - Santana', 'Av. João Pessoa, 2384, Farroupilha - Porto Alegre', '8h às 17h', NULL, NULL, 'mapaPopUm.png', 'PopUm.jpeg', -30.041692, -51.211756, '08:00:00', '17:00:00'),
(2, 'Centro Pop 2 - Floresta', 'Rua Gaspar Martins, 114 / 120, Floresta - Porto Alegre', '8h às 17h', NULL, NULL, 'mapaPopDois.png', 'PopDois.png', -30.026131, -51.205739, '08:00:00', '17:00:00'),
(3, 'Centro Pop 3 - Navegantes', 'Av. França, 496, Navegantes - Porto Alegre', '8h às 17h', NULL, NULL, 'mapaPopTres.png', 'PopTres.png\r\n', -30.012354, -51.196321, '08:00:00', '17:00:00'),
(4, 'SCFV - Adultos Pop Rua', 'Rua Santo Antônio, 64, Floresta - Porto Alegre', NULL, NULL, NULL, 'mapaSCFV.png', 'S.C.F.V-ADULTOS POP RUA.png', -30.02878, -51.20163, '08:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `imagensbuton`
--

CREATE TABLE `imagensbuton` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `caminho` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `imagensbuton`
--

INSERT INTO `imagensbuton` (`id`, `nome`, `caminho`) VALUES
(1, 'Bicicleta', 'imgs/bicicleta.png'),
(2, 'Carro', 'imgs/carro.png'),
(3, 'Casa', 'imgs/casa.icon'),
(4, 'Alimentação', 'imgs/imgAlimentacao.png'),
(5, 'Centro Pop', 'imgs/imgCentroPop.png'),
(6, 'Ônibus', 'imgs/imgOnibus.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `moradia`
--

CREATE TABLE `moradia` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `funcionamento` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `foto` mediumtext DEFAULT NULL,
  `lugar` varchar(200) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `abertura` time DEFAULT '08:00:00',
  `fechamento` time DEFAULT '20:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `moradia`
--

INSERT INTO `moradia` (`id`, `nome`, `endereco`, `horario`, `funcionamento`, `telefone`, `foto`, `lugar`, `lat`, `lng`, `abertura`, `fechamento`) VALUES
(1, 'Albergue Dias da Cruz', 'Albergue Dias da Cruz - avenida Azenha, 366 - Azenha', '8h às 21:30', NULL, '(51)3223-1938', 'mapaDiasDaCruz.png', 'moradiaDiasDaCruz.jpg', -30.046115, -51.218557, '08:00:00', '20:00:00'),
(2, 'Albergue Acolher II', 'Albergue Acolher II - rua Morretes, 345 - Santa Maria Goretti', '19h às 00:00', NULL, '(51)3737-2118', 'mapaAcolherII.png', 'moradiaAcolherII.png', -30.00768, -51.196328, '08:00:00', '20:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `postosaude`
--

CREATE TABLE `postosaude` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `horario` varchar(50) DEFAULT NULL,
  `funcionamento` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `foto` mediumtext DEFAULT NULL,
  `lugar` varchar(200) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `abertura` time DEFAULT '07:00:00',
  `fechamento` time DEFAULT '18:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `postosaude`
--

INSERT INTO `postosaude` (`id`, `nome`, `endereco`, `horario`, `funcionamento`, `telefone`, `foto`, `lugar`, `lat`, `lng`, `abertura`, `fechamento`) VALUES
(1, 'Centro de Saúde Navegantes', 'Av. Pres. Franklin Roosevelt, 5 - Navegantes, Porto Alegre\n\n', '07 às 22:00', 'segunda a sexta', '(51) 3289-8214', 'mapaNavegantes.png', 'clinicaNavegantes.png', -30.038435, -51.189569, '07:00:00', '18:00:00'),
(2, 'Centro de Saúde IAPI', 'R. Três de Abril, 90 - Passo d\'Areia, Porto Alegre', '07 às 22:00', 'segunda a sexta', '(51) 3289-3445', 'mapaIAPI.png', 'clinicaIAPI.png', -30.000612, -51.200304, '07:00:00', '18:00:00'),
(3, 'Clínica da Família Restinga', 'Rua Álvaro Difini, 520 - Restinga, Porto Alegre', '07:00 às 22:00', 'segunda a sexta', '(51) 4076-5011', 'mapaRestinga.png', 'clinicaRestinga.png', -30.149499, -51.141465, '07:00:00', '18:00:00'),
(4, 'Clínica da Família Campo da Tuca', 'José Rodrigues Sobral, 958 - Partenon, Porto Alegre', '07:00 às 22:00', 'segunda a sexta', '(51) 3319-4706', 'mapaCampodaTuca.png', 'clinicaCampodatuca.jpg', -30.063717, -51.155457, '07:00:00', '18:00:00'),
(5, 'CF José Mauro Ceratti Lopes', 'Estrada João Antônio da Silveira, 3330 - Restinga, Porto Alegre', '07:00 às 22:00', 'segunda a sexta', '(51) 3289-5201', 'mapaCeratti.png', 'clinicaCeratti.jpg', -30.13745, -51.13968, '07:00:00', '18:00:00'),
(6, 'Clínica da Família Moab Caldas', 'Avenida Moab Caldas, 400 - Santa Tereza, Porto Alegre', '07:00 às 22:00', 'segunda a sexta', '(51) 3289-4070', 'mapaMoab.png', 'clinicaMoab.jpg', -30.0697, -51.217448, '07:00:00', '18:00:00'),
(7, 'Centro de Saúde Modelo', 'Av. Jerônimo de Ornelas, 55 - Santana, Porto Alegre', '07:00 às 22:00', 'segunda a sexta', '(51) 3289-2555', 'mapaModelo.png', 'clinicaModelo.jpg', -30.03923, -51.20913, '07:00:00', '18:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alimentacao`
--
ALTER TABLE `alimentacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `centropop`
--
ALTER TABLE `centropop`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `imagensbuton`
--
ALTER TABLE `imagensbuton`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `moradia`
--
ALTER TABLE `moradia`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `postosaude`
--
ALTER TABLE `postosaude`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alimentacao`
--
ALTER TABLE `alimentacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `centropop`
--
ALTER TABLE `centropop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `imagensbuton`
--
ALTER TABLE `imagensbuton`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `moradia`
--
ALTER TABLE `moradia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `postosaude`
--
ALTER TABLE `postosaude`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
