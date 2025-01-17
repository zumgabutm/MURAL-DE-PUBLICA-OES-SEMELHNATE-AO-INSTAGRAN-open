-- Selecionar o banco de dados
USE mural;

-- Criar a tabela 'fotos' apenas se ela não existir
CREATE TABLE IF NOT EXISTS fotos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    caminho VARCHAR(255) NOT NULL,
    data_postagem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
