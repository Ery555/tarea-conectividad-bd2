CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0
);
INSERT INTO productos (nombre, precio, stock) VALUES 
('Teclado Mecánico', 45.50, 10),
('Mouse Inalámbrico', 22.00, 25),
('Monitor 24 Pulgadas', 180.00, 8);