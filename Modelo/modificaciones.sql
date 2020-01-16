
USE ordenservicios;

/*
ALTER TABLE `t_Equipo`
	MODIFY num_serie VARCHAR(45) UNIQUE NOT NULL; /* Evalua que sea único en esta tabla. */
  
CREATE TABLE t_Detalle_historico_epo
(
  id_detalle_historial INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  id_historico_epo INTEGER UNSIGNED NOT NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  notas TEXT NULL,
  FOREIGN KEY(id_historico_epo) REFERENCES t_Historico_epo(id_historico_epo)
    ON DELETE RESTRICT ON UPDATE CASCADE    
);
