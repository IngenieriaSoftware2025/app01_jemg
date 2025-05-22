CREATE DATABASE montes


-- Tabla: categorias
CREATE TABLE categorias (
    cat_id SERIAL PRIMARY KEY,
    cat_nombre VARCHAR(50) NOT NULL UNIQUE
);

--Tabla: productos
CREATE TABLE productos ( 
    pro_id SERIAL PRIMARY KEY,
    pro_nombre VARCHAR(100) NOT NULL,
    cat_id INT NOT NULL,
    pro_cantidad INT NOT NULL,
    pro_prioridad VARCHAR(15) NOT NULL,
    pro_comprado SMALLINT DEFAULT 0,
    UNIQUE (pro_nombre, cat_id),
    FOREIGN KEY (cat_id) REFERENCES categorias(cat_id)
);