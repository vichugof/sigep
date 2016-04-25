
CREATE TABLE quejas
(
  id serial NOT NULL,
  solicitante character varying(250) NOT NULL,
  solicitante_email character varying(250) NOT NULL,
  fecha timestamp without time zone NOT NULL,
  radicado character varying(50) NOT NULL,
  frips integer NOT NULL,
  comentario character varying(50),
  ip character varying(50) NOT NULL,
  tipoep_id integer NOT NULL,
  fechaactualizacion timestamp without time zone,
  fechacreacion timestamp without time zone,
  CONSTRAINT quejas_pkey PRIMARY KEY (id),
  CONSTRAINT quejas_idtipo_fkey FOREIGN KEY (tipoep_id)
      REFERENCES tipoep (idtipo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE INDEX idex_solicitante ON quejas USING btree(solicitante);
CREATE INDEX idex_solicitante_email ON quejas USING btree(solicitante_email);

CREATE TABLE anexos_ep
(
  id serial NOT NULL,
  queja_id integer NOT NULL,
  user_id character varying(254),
  file_path character varying(254),
  
  fechaactualizacion timestamp without time zone,
  fechacreacion timestamp without time zone,
  CONSTRAINT id_pkey PRIMARY KEY (id ),
  CONSTRAINT fk_queja FOREIGN KEY (queja_id ) REFERENCES quejas (id) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE INDEX idex_user_id ON anexos_ep USING btree(user_id);


CREATE TABLE seguimiento
(
  id serial NOT NULL,
  quejas_id integer NOT NULL,
  fechainiproceso date NOT NULL,
  fechafinproceso date NOT NULL,
		timestamp without time zone,
  fechacreacion timestamp without time zone,
  usuario_id integer,
  CONSTRAINT seguimiento_pkey PRIMARY KEY (id),
  CONSTRAINT fk_seguimiento FOREIGN KEY (usuario_id)
      REFERENCES usuario (idusuario) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT seguimiento_idquejas_fkey FOREIGN KEY (quejas_id)
      REFERENCES quejas (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);