
USE ordenservicios;

/*
ALTER TABLE `t_Refaccion`
	ADD medidas VARCHAR(45) NULL; 
*/

/*
ALTER TABLE `t_Equipo`
	MODIFY num_serie VARCHAR(45) UNIQUE NOT NULL; /* Evalua que sea único en esta tabla. */
  


/*
CREATE TABLE t_Detalle_historico_epo
(
  id_detalle_historial INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_historico_epo INTEGER UNSIGNED NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  notas TEXT NULL,
  FOREIGN KEY(id_historico_epo) REFERENCES t_Historico_epo(id_historico_epo)
    ON DELETE RESTRICT ON UPDATE CASCADE    
);
*/

CREATE TABLE t_Dev_Lexmark
(
  id_dev_lexmark INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  cantidad INTEGER UNSIGNED NOT NULL,
  sr VARCHAR(20) NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  id_refaccion INT UNSIGNED NOT NULL,
  id_clientes INTEGER UNSIGNED NOT NULL,
  id_sucursal INTEGER UNSIGNED NOT NULL,
  FOREIGN KEY(id_refaccion) REFERENCES t_Refaccion(id_refaccion)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_clientes) REFERENCES t_Clientes(id_clientes)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  FOREIGN KEY(id_sucursal) REFERENCES t_Sucursales(id_sucursal)
    ON DELETE RESTRICT ON UPDATE CASCADE
  /* Revisar esta pagina :  https://blog.openalfa.com/como-trabajar-con-restricciones-de-clave-externa-en-mysql 
    ON DELETE RESTRICT = No se puede borrar en la tabla "t_Dev_Lexmark" un registro que este contenido en la tabla "t_Sucursales"
    ON UPDATE CASCADE = Se actualiza en automaticamente, cuando se modifique un registro en "t_Sucursales" se refrejara en la tabla "t_Dev_Lexmark".
  */    
)


