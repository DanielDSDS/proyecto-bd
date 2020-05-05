/*Se asume que un encargado solo puede encargarse de un inventario por semestre*/

/*LISTO*/
CREATE TABLE Movilizaciones(
	codigo_movilizacion SERIAL NOT NULL,
	fecha_mov DATE NOT NULL,
	motivo VARCHAR(16) NOT NULL,
	PRIMARY KEY(codigo_movilizacion)
);

/*LISTO*/
CREATE TABLE Tipos_bien(
	nombre_tipo VARCHAR(16) NOT NULL,
	PRIMARY KEY(nombre_tipo)
);


/*LISTO*/
CREATE TABLE Nombre_empleados(
	cedula INT NOT NULL,
	nombre VARCHAR(32) NOT NULL,
	PRIMARY KEY(cedula)
);

/*LISTO*/
CREATE TABLE Empleados(
	ficha_empleado SERIAL NOT NULL,
	cedula INT NOT NULL UNIQUE,
	PRIMARY KEY(ficha_empleado),
	FOREIGN KEY(cedula) REFERENCES Nombre_empleados (cedula)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/
CREATE TABLE Sedes (
	codigo_sede SERIAL NOT NULL UNIQUE,
	descripcion VARCHAR(16) NOT NULL,
	direccion VARCHAR(32) NOT NULL UNIQUE,
	PRIMARY KEY(codigo_sede)
);

/*LISTO*/

/*AL INTENTAR ELIMINAR UN EMPLEADO QUE ES ENCARGADO DE SEDE
SE IMPRIME UNA ADVERTENCIA DICIENDO QUE OTRO EMPLEADO DEBE SER ASIGNADO COMO
ENCARGADO DE DICHA SEDE ANTES DE ELIMINARLO*/

/*AL ELIMINAR UNA TUPLA DE LAS SEDES SE ELIMINA UNA TUPLA DE ESTA TABLA*/
CREATE TABLE Encargados_x_sede (
	ficha_encargado SERIAL NOT NULL,
	codigo_sede SERIAL NOT NULL,
	PRIMARY KEY (ficha_encargado),
	FOREIGN KEY (ficha_encargado) REFERENCES Empleados (ficha_empleado)
		ON UPDATE CASCADE
		ON DELETE NO ACTION,
	FOREIGN KEY (codigo_sede) REFERENCES Sedes (codigo_sede)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*AL ELIMINAR UN EMPLEADO QUE SEA RESPONSABLE SE FRENA
Y SE ADVIERTE QUE DEBE SER ASIGNADO OTRO EMPLEADO COMO RESPONSABLE 
PARA PODER ELIMINAR*/

/*AL ELIMINAR UNA UNIDAD SE ELIMINA UNA DE ESTAS TUPLAS*/
CREATE TABLE Responsables_x_unidad(
    ficha_responsable SERIAL,
	PRIMARY KEY (ficha_responsable),
	FOREIGN KEY (ficha_responsable) REFERENCES Empleados (ficha_empleado)
		ON UPDATE CASCADE
		ON DELETE NO ACTION
);

/*LISTO*/

/*AL ELIMINAR UN RESPONSABLE SE FRENA Y SE ADVIERTE QUE 
DEBE SER ASIGNADO OTRO EMPLEADO COMO RESPONSABLE DE DICHA UNIDAD*/

/*AL ELIMINAR UNA SEDE SE ELIMINA LA UNIDAD*/
CREATE TABLE Unidades(
	codigo_unidad SERIAL NOT NULL UNIQUE,
	codigo_sede SERIAL NOT NULL,
	ficha_responsable SERIAL,
	nombre VARCHAR(32) NOT NULL,
	fec_inicio_cargo DATE ,
	PRIMARY KEY(codigo_unidad),
	FOREIGN KEY(ficha_responsable) REFERENCES Responsables_x_unidad (ficha_responsable)
		ON UPDATE CASCADE 
		ON DELETE NO ACTION,
	FOREIGN KEY(codigo_sede) REFERENCES Sedes (codigo_sede)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*CLAVE FORANEA DE RESPONSABLES_X_UNIDAD*/
ALTER TABLE Responsables_x_unidad ADD codigo_unidad SERIAL NOT NULL REFERENCES Unidades (codigo_unidad)
	ON UPDATE CASCADE 
	ON DELETE CASCADE;


/*LISTO*/

/*se eliminaron las claves foraneas con respecto a las unidades para poder
guardar los detalles de movilizaciones aun cuando se hayan eliminado unidades*/
/*AL INSERTAR LOS CODIGOS DE UNIDADES SE VALIDA CON UN SELECT EN EL FRONT
SI LAS UNIDADES INSERTADAS EXISTEN*/

/*AL ELIMINAR CUALQUIERA DE LAS DOS UNIDADES SE MANTIENE GUARDADO
EL DETALLE DE TODAS MANERAS*/

/*AL ELIMINAR UN CODIGO DE MOVILIZACION SE ELIMINA SU RESPECTIVO DETALLE*/
CREATE TABLE Detalles_movilizacion(
	codigo_movilizacion SERIAL NOT NULL,
	id_movilizacion SERIAL NOT NULL UNIQUE,
	codigo_unidad_cede SERIAL NOT NULL,
	codigo_unidad_recibe SERIAL NOT NULL,
	PRIMARY KEY(codigo_movilizacion,id_movilizacion),
	FOREIGN KEY(codigo_movilizacion) REFERENCES Movilizaciones (codigo_movilizacion)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*Al registrar un inventario se guarda tanto en inventarios como en libro_inventarios*/

/*AL ELIMINAR UN ENCARGADO DE UN INVENTARIO (SEDE) SE ELIMINA DICHO 
INVENTARIO PERO SE MANTIENE GUARDADO EN UN HISTORICO DE INVENTARIOS*/
CREATE TABLE Inventarios(
	anio INT NOT NULL,
	semestre VARCHAR(16) NOT NULL,
    ficha_encargado SERIAL NOT NULL,
	fec_inicio DATE NOT NULL,
	fec_fin DATE,
	fec_verificacion DATE,
	status VARCHAR(16) NOT NULL,
	tipo_inventario VARCHAR(16) NOT NULL,
	PRIMARY KEY(anio,semestre,ficha_encargado),
	FOREIGN KEY(ficha_encargado) REFERENCES Encargados_x_sede (ficha_encargado)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*HISTORICO DE INVENTARIOS QUE GUARDA TODOS LOS INVENTARIOS REALIZADOS*/
CREATE TABLE Libro_inventarios(
	anio INT NOT NULL,
	semestre VARCHAR(16) NOT NULL,
    ficha_encargado SERIAL NOT NULL,
	codigo_sede SERIAL NOT NULL,
	fec_inicio DATE NOT NULL,
	fec_fin DATE,
	fec_verificacion DATE,
	status VARCHAR(16) NOT NULL,
	tipo_inventario VARCHAR(16) NOT NULL,
	PRIMARY KEY(anio,semestre,ficha_encargado)
);

/*LISTO*/

/*Aqui se introducen los bienes cuando se hace un inventario,
Cuando se introduzca algun bien debe verificarse su existencia*/

/*SI SE ACTUALIZA ALGUN DATO DEL INVENTARIO SE DA UNA ADVERTENCIA*/

/*SI SE ELIMINA LA TUPLA DEL HISTORICO DE INVENTARIO SE ELIMINA EN BIENES_X_INVENTARIO*/
CREATE TABLE Bienes_x_inventario (
	anio INT NOT NULL,
	semestre VARCHAR(16) NOT NULL,
	ficha_encargado SERIAL NOT NULL,
	numero_bien SERIAL NOT NULL,
	observacion VARCHAR(16) NOT NULL,
	status VARCHAR(16) NOT NULL,
	PRIMARY KEY(anio,semestre,ficha_encargado,numero_bien),
	FOREIGN KEY(anio,semestre,ficha_encargado) REFERENCES Libro_inventarios (anio,semestre,ficha_encargado)
		ON UPDATE NO ACTION
		ON DELETE CASCADE
);

CREATE TABLE Detalle_x_bien(
	anio INT NOT NULL,
	semestre VARCHAR(16) NOT NULL,
	ficha_encargado SERIAL NOT NULL,
	numero_bien SERIAL NOT NULL UNIQUE,
	detalle VARCHAR(16) NOT NULL,
	PRIMARY KEY(anio,semestre,ficha_encargado,numero_bien),
	FOREIGN KEY(anio,semestre,numero_bien,ficha_encargado) REFERENCES Bienes_x_inventario (anio,semestre,numero_bien,ficha_encargado)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*UN TIPO DE BIEN NO PUEDE SER ACTUALIZADO O ELIMINADO
YA QUE EXISTEN BIENES YA REGISTRADOS POR ESE NOMBRE*/

/*AL INGRESAR UN NUEVO BIEN SE VALIDA LA EXISTENCIA DE LA FICHA DEL RESPONSABLE
INGRESADO DENTRO DE LA UNIDAD QUE SE QUIERE INGRESAR*/

CREATE TABLE Bienes(
	numero_bien SERIAL NOT NULL UNIQUE,
	ficha_responsable SERIAL,
	descripcion VARCHAR(16) NOT NULL,
	fec_adquisicion DATE NOT NULL,
	fec_desincorporacion DATE NOT NULL,
	origen VARCHAR(16) NOT NULL,
	tipo_mov VARCHAR(16) NOT NULL,
	tipo VARCHAR(16) NOT NULL,
	PRIMARY KEY (numero_bien),
	FOREIGN KEY (tipo) REFERENCES Tipos_bien (nombre_tipo)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
/*SI SE INTENTA ELIMINAR EL TIPO DE BIEN SE FRENA AQUI*/
CREATE TABLE Inamovibles(
	numero_bien SERIAL NOT NULL UNIQUE, 
	tipo VARCHAR(16) NOT NULL,
	PRIMARY KEY(numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Bienes (numero_bien)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(tipo) REFERENCES Tipos_bien (nombre_tipo)
		ON UPDATE NO ACTION 
		ON DELETE NO ACTION 
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
/*SI SE INTENTA ELIMINAR EL TIPO DE BIEN SE FRENA AQUI*/
CREATE TABLE Movibles(
	numero_bien SERIAL NOT NULL UNIQUE,
	tipo VARCHAR(16) NOT NULL,
	PRIMARY KEY(numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Bienes (numero_bien)
		ON UPDATE CASCADE 
		ON DELETE CASCADE,
	FOREIGN KEY(tipo) REFERENCES Tipos_bien (nombre_tipo)
		ON UPDATE CASCADE
		ON DELETE NO ACTION
);

CREATE TABLE Bienes_x_mov (
	codigo_movilizacion SERIAL NOT NULL,
	id_movilizacion SERIAL NOT NULL UNIQUE,
	numero_bien SERIAL NOT NULL,
	PRIMARY KEY(codigo_movilizacion,id_movilizacion,numero_bien),
	FOREIGN KEY(id_movilizacion, codigo_movilizacion) REFERENCES Detalles_movilizacion (id_movilizacion, codigo_movilizacion)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY(numero_bien) REFERENCES Movibles (numero_bien)
		ON UPDATE CASCADE
		ON DELETE NO ACTION
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
CREATE TABLE Tangibles(
	numero_bien SERIAL NOT NULL UNIQUE,
	numero_orden SERIAL NOT NULL,
	numero_factura SERIAL NOT NULL,
	proveedor VARCHAR(16) NOT NULL,
	precio DECIMAL(2,0) NOT NULL,
	lapso VARCHAR(16) NOT NULL,
	status VARCHAR(16) NOT NULL,
	PRIMARY KEY(numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Movibles (numero_bien)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
CREATE TABLE Intangibles(
	numero_bien SERIAL NOT NULL UNIQUE,
	fec_caducidad DATE NOT NULL,
	status VARCHAR(16) NOT NULL,
	compartida VARCHAR(16) NOT NULL,
	PRIMARY KEY(numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Movibles (numero_bien)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
CREATE TABLE Componentes(
	numero_bien SERIAL NOT NULL,
	cod_componente SERIAL NOT NULL UNIQUE,
	PRIMARY KEY(numero_bien, cod_componente),
	FOREIGN KEY(numero_bien) REFERENCES Tangibles (numero_bien)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
CREATE TABLE Edificaciones(
	numero_bien SERIAL NOT NULL UNIQUE,
	superficie DECIMAL NOT NULL,
	tipo VARCHAR(16) NOT NULL,
	ubicacion VARCHAR(32) NOT NULL,
	status VARCHAR(16) NOT NULL,
	PRIMARY KEY (numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Inamovibles (numero_bien)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

/*LISTO*/

/*SI SE ELIMINA EL NUMERO_BIEN SE ELIMINA ACA TAMBIEN*/
CREATE TABLE Naturales(
	numero_bien SERIAL NOT NULL UNIQUE,
	nombre_cientifico VARCHAR(32) NOT NULL UNIQUE,
	nombre_vulgar VARCHAR(16) NOT NULL UNIQUE,
	frutal VARCHAR(16) NOT NULL,
	periodo_floracion VARCHAR(32),
	fec_plantacion DATE NOT NULL,
	origen VARCHAR(16) NOT NULL,
	fotografia VARCHAR(64) NOT NULL,
	ubicacion VARCHAR(32) NOT NULL,
	status VARCHAR(16) NOT NULL,
	PRIMARY KEY(numero_bien),
	FOREIGN KEY(numero_bien) REFERENCES Inamovibles (numero_bien)
		ON UPDATE CASCADE
	 	ON DELETE CASCADE
);

/*LISTO*/

CREATE TABLE Ciudades(
	direccion VARCHAR(32) NOT NULL,
	ciudad VARCHAR(16) NOT NULL,
	PRIMARY KEY(direccion,ciudad),
	FOREIGN KEY(direccion) REFERENCES Sedes (direccion)
		ON UPDATE NO ACTION
		ON DELETE CASCADE
);

/*LISTO*/

CREATE TABLE Nombres_componentes(
	cod_componente SERIAL NOT NULL UNIQUE,
	nombre VARCHAR(16) NOT NULL,
	PRIMARY KEY(cod_componente),
	FOREIGN KEY(cod_componente) REFERENCES Componentes (cod_componente)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);


ALTER TABLE Empleados ADD codigo_unidad SERIAL NOT NULL REFERENCES Unidades (codigo_unidad)
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE Inventarios 
	ADD CONSTRAINT check_status_inventarios
	CHECK (status = 'En ejecucion' or status = 'En conciliacion' or status = 'Cerrado');

ALTER TABLE Inventarios
	ADD CONSTRAINT check_fechas_inventarios
	CHECK (fec_inicio < fec_fin and fec_verificacion = fec_fin);

ALTER TABLE Libro_inventarios 
	ADD CONSTRAINT check_status_libro
	CHECK (status = 'En ejecucion' or status = 'En conciliacion' or status = 'Cerrado');

ALTER TABLE Libro_inventarios 
	ADD CONSTRAINT check_fechas_libro
	CHECK (fec_inicio < fec_fin and fec_verificacion = fec_fin);

ALTER TABLE Tipos_bien 
	ADD CONSTRAINT check_tipos_tipo_bienes
	CHECK (nombre_tipo = 'Tangible' or nombre_tipo = 'Intangible' or nombre_tipo = 'Edificacion' or nombre_tipo = 'Natural');
	
ALTER TABLE Bienes_x_inventario 
	ADD CONSTRAINT check_status_bienesxinventario
	CHECK (status = 'En ejecucion' or status = 'En conciliacion' or status = 'Cerrado');

ALTER TABLE Bienes
	ADD CONSTRAINT check_fechas_bienes
	CHECK (fec_adquisicion < fec_desincorporacion);

ALTER TABLE Bienes
	ADD CONSTRAINT check_origen_bienes
	CHECK (origen = 'Compra' or origen = 'Donacion' or origen = 'Prestamo');

ALTER TABLE Bienes 
	ADD CONSTRAINT check_tipo_mov_bienes
	CHECK (tipo_mov = 'Movible' or tipo_mov = 'Inamovible');

ALTER TABLE Inamovibles
	ADD CONSTRAINT check_tipo_inamovibles
	CHECK (tipo = 'Edificacion' or tipo = 'Natural');

ALTER TABLE Movibles
	ADD CONSTRAINT check_tipo_movibles
	CHECK (tipo = 'Edificacion' or tipo = 'Natural');

ALTER TABLE Tangibles
	ADD CONSTRAINT check_status_tangibles
	CHECK (status = 'EPR' or status = 'Activo' or status = 'Dañado' or status = 'Obsoleto' or status = 'ER' or status = 'Desincorporado');

ALTER TABLE Intangibles
	ADD CONSTRAINT check_status_intangibles
	CHECK (status = 'EPR' or status = 'Vigente' or status = 'Vencido' or status = 'Desincorporado');

ALTER TABLE Edificaciones
	ADD CONSTRAINT check_tipo_edificaciones
	CHECK (tipo = 'Propia' or tipo = 'Comodato');

ALTER TABLE Edificaciones	
	ADD CONSTRAINT check_status_edifiaciones
	CHECK (status = 'EPR' or status = 'Construyendo' or status = 'Habitada' or status = 'Deshabitada' or status = 'Desincorporada');

ALTER TABLE Naturales
	ADD CONSTRAINT check_status_naturales
	CHECK (status = 'EPR' or status = 'Plantado' or status = 'Enfermo' or status = 'Extinto');
