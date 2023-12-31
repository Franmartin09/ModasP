-- USUARIOS PARA LOGIN --
-- CREATE TABLE Usuarios
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id_user SERIAL PRIMARY KEY, 
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pass VARCHAR(100) NOT NULL
);


-- CLIENTES PARA LISTAR --
-- CREATE TABLE Clients
DROP TABLE IF EXISTS clientes;
CREATE TABLE clientes (
    id_cliente SERIAL PRIMARY KEY, 
    name_surname VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    phone INT, -- CHECK (phone>=100000000 AND phone<=999999999) --
    addres VARCHAR(150) NOT NULL,
    cif INT UNIQUE, --  CHECK (phone>=100000000 AND phone<=999999999) --
    fecha_alta TIMESTAMP NOT NULL,
    fecha_baja TIMESTAMP,
    estado CHAR(1) NOT NULL
);


-- FACTURAS DE CADA CLIENTE PARA LISTAR --
-- CREATE TABLE Invoices
 DROP TABLE IF EXISTS facturas;
 CREATE TABLE facturas (
     id_factura SERIAL PRIMARY KEY, 
     fecha TIMESTAMP NOT NULL,
     reference Varchar(50) NOT NULL, 
     importe_neto double precision NOT NULL,
     iva double precision NOT NULL,
     importe_total double precision NOT NULL, 
     numero_factura INT NOT NULL,
     id_cliente SERIAL REFERENCES clientes(id_cliente) ON DELETE CASCADE
 );


-- ITEMS DE CADA FACTURA PARA LISTAR --
-- CREATE TABLE Items
 DROP TABLE IF EXISTS items;
 CREATE TABLE items (
     id_iteam SERIAL PRIMARY KEY,
     overview VARCHAR(50) NOT NULL,
     price FLOAT NOT NULL,
     quantity INT NOT NULL,
     id_factura SERIAL REFERENCES facturas(id_factura) ON DELETE CASCADE
 );

-- LOAD DATA Usuarios
-- INSERT INTO usuarios(id_user, username, email, pass)
-- VALUES
--     (1, 'fmartin','fmartin@stp.es','fmartin'),
--     (2, 'aman', 'aman@stp.es','aman'),
--     (3, 'fbig', 'fbig@stp.es','fbig'),
--     (4, 'admin', 'admin@stp.es','admin');


-- LOAD DATAS Clients
-- INSERT INTO clientes(id_cliente, name_surname, email_cliente, phone, addres, cif, fecha_alta, fecha_baja, estado)
-- VALUES
--     (1, 'Fran Martin','fmartin@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (2, 'Ant Man', 'aman@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (3, 'Fallen Big', 'fbig@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (4, 'The barbershop', 'tbarbershop@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (5, 'Javier Garcia', 'jgarcia@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL,'A'),
--     (6, 'Peter Pan', 'ppan@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (7, 'Fast & Furious 7', 'ffsiete@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (8, 'Harry Potter', 'hpotter@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (9, 'Jungle book', 'jbook@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (10, 'Fran Martin','fmartin@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (11, 'Ant Man', 'aman@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (12, 'Fallen Big', 'fbig@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (13, 'The barbershop', 'tbarbershop@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (14, 'The barbershop', 'tbarbershop@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (15, 'Javier Garcia', 'jgarcia@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (16, 'Peter Pan', 'ppan@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (17, 'Fast & Furious 7', 'ffsiete@stp.es',777777777, 'C/ Les Moreres', 999999999,'2020-06-22 19:10:25-07', NULL, 'A'),
--     (18, 'Harry Potter', 'hpotter@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A'),
--     (19, 'Jungle book', 'jbook@stp.es',777777777, 'C/ Les Moreres', 999999999, '2020-06-22 19:10:25-07', NULL,'A');


-- LOAD DATAS Invoices
--  INSERT INTO facturas(id_factura, fecha, reference, importe_neto, iva, importe_total, numero_factura, id_cliente)
--  VALUES
--      (1, '2020-06-22 19:10:25-07','REF1234567','100','21','121','1','1'),
--      (2, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','2','1'),
--      (3, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','3','1'),
--      (4, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','4','1'),
--      (5, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','1','2'),
--      (6, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','2','2'),
--      (7, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','3','2'),
--      (8, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','1','3'),
--      (9, '2020-06-22 19:10:25-07', 'REF1234567','100','21','121','1','4');


-- LOAD DATAS ITEMS
--  INSERT INTO items(id_iteam, overview, price, quantity, id_factura)
--  VALUES
--      (1, 'Patatas','20.0','1','2'),
--      (2, 'Programa Excel', '20.0','1','2'),
--      (3, 'Programa Excel', '20.0','1','2'),
--      (4, 'Programa Word', '20.0','1','2'),
--      (5, 'Programa Java', '20.0','1','2'),
--      (6, 'Peter Pan', '20.0','1','2'),
--      (7, 'Fast & Furious 7', '20.0','1','1'),
--      (8, 'Harry Potter','20.0','1','1'),
--      (10, 'Patatas','20.0','1','8'),
--      (11, 'Patatas','20.0','1','3'),
--      (12, 'Programa Excel', '20.0','1','3'),
--      (13, 'Programa Excel', '20.0','1','4'),
--      (14, 'Programa Word', '20.0','1','4'),
--      (15, 'Programa Java', '20.0','1','4'),
--      (16, 'Peter Pan', '20.0','1','4'),
--      (17, 'Fast & Furious 7', '20.0','1','7'),
--      (18, 'Harry Potter','20.0','1','7'),
--      (19, 'Programa PHP', '20.0','1','6'),
--      (20, 'Programa Excel', '20.0','1','8'),
--      (21, 'Fast & Furious 7', '20.0','1','5'),
--      (22, 'Harry Potter','20.0','1','6'),
--      (23, 'Programa Excel', '20.0','1','8'),
--      (24, 'Programa Word', '20.0','1','9'),
--      (25, 'Programa Java', '20.0','1','5'),
--      (26, 'Peter Pan', '20.0','1','5');

