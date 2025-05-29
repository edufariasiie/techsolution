-- SQL schema for the users table
-- Atualizado para suportar membros da comunidade com campos extras

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único
    username VARCHAR(50) NOT NULL UNIQUE, -- Nome do usuário
    email VARCHAR(100) NOT NULL UNIQUE, -- Email do usuário
    password VARCHAR(255) NOT NULL, -- Hash da senha
    role VARCHAR(30) NOT NULL, -- Tipo de usuário (ex: membro_comunidade)
    business_name VARCHAR(100), -- Nome do negócio (apenas para membros da comunidade)
    business_type VARCHAR(30), -- Tipo de negócio (Ong, projeto social, MEI, pequeno negócio)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação
);

-- Tabela de projetos para cadastro de novos projetos pela comunidade
CREATE TABLE projetos (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identificador único do projeto
    nome VARCHAR(100) NOT NULL, -- Nome do projeto
    descricao TEXT NOT NULL, -- Descrição básica
    data_limite DATE NOT NULL, -- Data limite para entrega
    tipo_incentivo ENUM('financeiro', 'permuta') NOT NULL, -- Tipo de incentivo
    valor_financeiro DECIMAL(10,2) DEFAULT NULL, -- Valor do incentivo financeiro (se aplicável)
    descricao_permuta VARCHAR(255) DEFAULT NULL, -- Descrição da permuta (se aplicável)
    user_id INT DEFAULT NULL, -- ID do usuário criador (FK para users.id)
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data de criação do projeto
); 