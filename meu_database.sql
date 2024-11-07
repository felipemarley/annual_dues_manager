CREATE TABLE associados (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    cpf CHAR(11) NOT NULL UNIQUE,
    data_filiacao DATE NOT NULL
);

CREATE TABLE anuidades (
    id SERIAL PRIMARY KEY,
    ano CHAR(4) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);

CREATE TABLE pagamentos (
    id SERIAL PRIMARY KEY,
    associado_id INT NOT NULL,
    anuidade_id INT NOT NULL,
    pago BOOLEAN DEFAULT FALSE,
    data_pagamento DATE,
    FOREIGN KEY (associado_id) REFERENCES associados(id) ON DELETE CASCADE, --se um associado ou uma anuidade for excluído, todos os   
    FOREIGN KEY (anuidade_id) REFERENCES anuidades(id) ON DELETE CASCADE    --pagamentos relacionados a eles também serão 
);                                                                          --removidos automaticamente