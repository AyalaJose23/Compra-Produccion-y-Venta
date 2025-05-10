-- Function: sp_realizar_arqueo(integer)

-- DROP FUNCTION sp_realizar_arqueo(integer);

CREATE OR REPLACE FUNCTION sp_realizar_arqueo(p_aper_cod integer)
  RETURNS void AS
$BODY$
DECLARE
    v_monto_efectivo NUMERIC := 0;
    v_monto_tarjeta NUMERIC := 0;
    v_monto_cheque NUMERIC := 0;
    v_estado_apertura VARCHAR(20);
BEGIN
   
    -- Verificar si existen cobros pendientes
    IF EXISTS (
        SELECT 1
        FROM cobros
        WHERE cobro_estado = 'PENDIENTE' AND aper_cod = p_aper_cod
    ) THEN
        RAISE EXCEPTION 'No se puede generar un arqueo. Existen cobros pendientes.';
    END IF;

    -- Calcular monto total en efectivo
    SELECT COALESCE(SUM(monto), 0)
    INTO v_monto_efectivo
    FROM cobros_formadetalle
    WHERE form_cod = 1
      AND id_cobros IN (
          SELECT id_cobros FROM cobros WHERE aper_cod = p_aper_cod AND cobro_estado != 'ANULADO'
      );

    -- Calcular monto total en tarjeta
    SELECT COALESCE(SUM(monto), 0)
    INTO v_monto_tarjeta
    FROM cobro_tarjeta
    WHERE id_cobros IN (
          SELECT id_cobros FROM cobros WHERE aper_cod = p_aper_cod AND cobro_estado != 'ANULADO'
      );

    -- Calcular monto total en cheques
    SELECT COALESCE(SUM(monto), 0)
    INTO v_monto_cheque
    FROM cobro_cheque
    WHERE id_cobros IN (
          SELECT id_cobros FROM cobros WHERE aper_cod = p_aper_cod AND cobro_estado != 'ANULADO'
      );

    -- Insertar el arqueo en la tabla
    INSERT INTO arqueo (
        aper_cod, arq_fecha, arq_hora, arq_montoefectivo, arq_montocheque, arq_montotarjeta, arq_estado
    )
    VALUES (
        p_aper_cod, CURRENT_DATE, CURRENT_TIME, v_monto_efectivo, v_monto_cheque, v_monto_tarjeta, 'ACTIVO'
    );

    RAISE NOTICE 'Arqueo realizado exitosamente.';
END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION sp_realizar_arqueo(integer)
  OWNER TO postgres;