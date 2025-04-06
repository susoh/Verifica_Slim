-- Creazione tabella classi
CREATE TABLE `classi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `sezione` VARCHAR(10) NOT NULL,
  `anno` INT(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Creazione tabella alunni
CREATE TABLE `alunni` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20) NOT NULL,
  `cognome` VARCHAR(20) NOT NULL,
  `classe_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`classe_id`) REFERENCES `classi`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserimento dati di esempio
INSERT INTO `classi` (`sezione`, `anno`) VALUES
('5A', 2024),
('5B', 2024);

INSERT INTO `alunni` (`nome`, `cognome`, `classe_id`) VALUES
('Claudio', 'Benve', 1),
('Ivan', 'Bruno', 1),
('Francesco', 'Bertoli', 2);
