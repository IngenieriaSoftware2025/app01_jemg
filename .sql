CREATE DATABASE montes


-- Tabla: categorias
CREATE TABLE categorias (
    cat_id SERIAL PRIMARY KEY,
    cat_nombre VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla: prioridades
CREATE TABLE prioridades (
    pri_id SERIAL PRIMARY KEY,
    pri_nivel VARCHAR(20) NOT NULL UNIQUE
);

--Tabla: productos
CREATE TABLE productos (
    pro_id SERIAL PRIMARY KEY,
    pro_nombre VARCHAR(100) NOT NULL,
    pro_cantidad INT NOT NULL,
    cat_id INT NOT NULL,
    pri_id INT NOT NULL,
    pro_comprado SMALLINT DEFAULT 1,
    UNIQUE (pro_nombre, cat_id), -- evita duplicados en la misma categoría
    FOREIGN KEY (cat_id) REFERENCES categorias(cat_id),
    FOREIGN KEY (pri_id) REFERENCES prioridades(pri_id)
);

---inserts de prioridades
INSERT INTO prioridades (pri_nivel) VALUES ('Alta');
INSERT INTO prioridades (pri_nivel) VALUES ('Media');
INSERT INTO prioridades (pri_nivel) VALUES ('Baja');



---inserts de categorias
INSERT INTO categorias (cat_nombre) VALUES ('Alimentos');
INSERT INTO categorias (cat_nombre) VALUES ('Higiene');
INSERT INTO categorias (cat_nombre) VALUES ('Hogar');
INSERT INTO categorias (cat_nombre) VALUES ('Bebidas');
INSERT INTO categorias (cat_nombre) VALUES ('Lácteos');
INSERT INTO categorias (cat_nombre) VALUES ('Panadería');
INSERT INTO categorias (cat_nombre) VALUES ('Carnes');
INSERT INTO categorias (cat_nombre) VALUES ('Frutas');
INSERT INTO categorias (cat_nombre) VALUES ('Verduras');
INSERT INTO categorias (cat_nombre) VALUES ('Limpieza');
INSERT INTO categorias (cat_nombre) VALUES ('Cuidado personal');
INSERT INTO categorias (cat_nombre) VALUES ('Mascotas');
INSERT INTO categorias (cat_nombre) VALUES ('Papelería');
INSERT INTO categorias (cat_nombre) VALUES ('Electrónica');
INSERT INTO categorias (cat_nombre) VALUES ('Ropa');
INSERT INTO categorias (cat_nombre) VALUES ('Calzado');
INSERT INTO categorias (cat_nombre) VALUES ('Accesorios de cocina');
INSERT INTO categorias (cat_nombre) VALUES ('Ferretería');
INSERT INTO categorias (cat_nombre) VALUES ('Juguetería');
INSERT INTO categorias (cat_nombre) VALUES ('Plásticos y utensilios');
--------------------------------------------------------------------------------