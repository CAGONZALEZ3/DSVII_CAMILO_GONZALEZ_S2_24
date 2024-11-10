-- 1
CREATE VIEW vista_bajo_stock AS
SELECT 
    p.id AS producto_id,
    p.nombre AS producto,
    p.stock,
    COALESCE(SUM(dv.cantidad), 0) AS cantidad_vendida,
    COALESCE(SUM(dv.subtotal), 0) AS ingresos_totales
FROM productos p
LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
WHERE p.stock < 5
GROUP BY p.id;


-- 2
CREATE OR REPLACE VIEW vista_historial_clientes AS
SELECT 
    c.id AS cliente_id,
    c.nombre AS cliente,
    p.nombre AS producto,
    SUM(dv.cantidad) AS cantidad_total,  -- Sumar cantidad para evitar conflicto
    AVG(dv.precio_unitario) AS precio_unitario_promedio,  -- Promedio de precio unitario
    SUM(dv.subtotal) AS subtotal,  -- Sumar subtotal
    v.fecha_venta,
    COALESCE(SUM(dv.subtotal), 0) AS total_gastado
FROM clientes c
JOIN ventas v ON c.id = v.cliente_id
JOIN detalles_venta dv ON v.id = dv.venta_id
JOIN productos p ON dv.producto_id = p.id
GROUP BY c.id, c.nombre, p.nombre, v.fecha_venta;


-- 3
CREATE VIEW vista_rendimiento_categoria AS
SELECT 
    c.nombre AS categoria,
    COUNT(p.id) AS total_productos,
    COALESCE(SUM(dv.subtotal), 0) AS ventas_totales,
    (SELECT p2.nombre 
     FROM productos p2 
     JOIN detalles_venta dv2 ON p2.id = dv2.producto_id 
     WHERE p2.categoria_id = c.id 
     GROUP BY p2.id 
     ORDER BY SUM(dv2.cantidad) DESC 
     LIMIT 1) AS producto_mas_vendido
FROM categorias c
LEFT JOIN productos p ON c.id = p.categoria_id
LEFT JOIN detalles_venta dv ON p.id = dv.producto_id
GROUP BY c.id;


-- 4
CREATE VIEW vista_tendencias_ventas AS
SELECT 
    DATE_FORMAT(v.fecha_venta, '%Y-%m') AS mes,
    SUM(dv.subtotal) AS ventas_totales,
    LAG(SUM(dv.subtotal)) OVER (ORDER BY DATE_FORMAT(v.fecha_venta, '%Y-%m')) AS ventas_mes_anterior
FROM ventas v
JOIN detalles_venta dv ON v.id = dv.venta_id
GROUP BY DATE_FORMAT(v.fecha_venta, '%Y-%m');
