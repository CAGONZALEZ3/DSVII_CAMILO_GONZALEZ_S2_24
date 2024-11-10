DELIMITER //
-- 1
CREATE PROCEDURE sp_procesar_devolucion(
    IN p_venta_id INT,
    IN p_producto_id INT,
    IN p_cantidad INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_stock INT;
    
    -- Iniciar transacción
    START TRANSACTION;
    
    -- Verificar si la venta y el producto existen
    IF EXISTS (SELECT 1 FROM detalles_venta WHERE venta_id = p_venta_id AND producto_id = p_producto_id) THEN
        -- Actualizar stock del producto
        UPDATE productos 
        SET stock = stock + p_cantidad 
        WHERE id = p_producto_id;

        -- Actualizar el estado de la venta
        UPDATE ventas 
        SET estado = 'devuelta' 
        WHERE id = p_venta_id;

        SET p_mensaje = 'Devolución procesada con éxito';
        
        COMMIT;
    ELSE
        -- Si no existe la venta/producto, deshacer
        ROLLBACK;
        SET p_mensaje = 'Error: Venta o producto no encontrado';
    END IF;
END //

DELIMITER ;


-- 2
DELIMITER //

CREATE PROCEDURE sp_aplicar_descuento(
    IN p_cliente_id INT,
    OUT p_descuento DECIMAL(5,2)
)
BEGIN
    DECLARE v_total_gastado DECIMAL(10,2);
    
    -- Obtener el total gastado por el cliente
    SELECT COALESCE(SUM(total), 0) INTO v_total_gastado 
    FROM ventas 
    WHERE cliente_id = p_cliente_id;

    -- Calcular descuento basado en historial de compras
    IF v_total_gastado >= 1000 THEN
        SET p_descuento = 10.00; -- 10% de descuento
    ELSEIF v_total_gastado >= 500 THEN
        SET p_descuento = 5.00; -- 5% de descuento
    ELSE
        SET p_descuento = 0.00; -- Sin descuento
    END IF;
END //

DELIMITER ;


-- 3
DELIMITER //

CREATE PROCEDURE sp_reporte_bajo_stock()
BEGIN
    SELECT 
        id AS producto_id,
        nombre,
        stock,
        CASE
            WHEN stock < 10 THEN 20 - stock
            ELSE 0
        END AS sugerencia_reposicion
    FROM productos
    WHERE stock < 10;
END //

DELIMITER ;
 

-- 4
DELIMITER //

CREATE PROCEDURE sp_calcular_comisiones(
    IN p_vendedor_id INT,
    OUT p_comision DECIMAL(10,2)
)
BEGIN
    DECLARE v_total_ventas DECIMAL(10,2);
    DECLARE v_total_productos INT;
    
    -- Calcular total de ventas y productos vendidos por el vendedor
    SELECT COALESCE(SUM(v.total), 0), COALESCE(SUM(dv.cantidad), 0)
    INTO v_total_ventas, v_total_productos
    FROM ventas v
    JOIN detalles_venta dv ON v.id = dv.venta_id
    WHERE v.vendedor_id = p_vendedor_id;
    
    -- Calcular comisiones basadas en los criterios
    IF v_total_ventas >= 5000 THEN
        SET p_comision = v_total_ventas * 0.10; -- 10% si supera 5000 en ventas
    ELSEIF v_total_productos >= 100 THEN
        SET p_comision = v_total_productos * 0.50; -- $0.50 por cada producto si supera 100 productos
    ELSE
        SET p_comision = v_total_ventas * 0.05; -- 5% de comision base
    END IF;
END //

DELIMITER ;
x