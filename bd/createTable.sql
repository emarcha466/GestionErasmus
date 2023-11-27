use erasmus;
-- drop table candidato, tutorLegal;

create table tutorLegal(
	dni varchar(9) primary key,
    apellidos varchar(100),
    nombre varchar(100),
    telefono varchar(9),
    domicilio varchar(50)
);
create table candidato(
	dni varchar(9) primary key,
    apellidos varchar(100),
    nombre varchar(100),
    fechaNac date,
    curso varchar(10),
    telefono varchar(9),
    correo varchar(30),
    domicilio varchar(50),
    tutorLegalDNI varchar(3),
    
    constraint candidato_fk_tutorLegal foreign key (tutorLegalDNI) references tutorLegal(dni)
);

create table proyecto(
	codigoProyecto varchar(30) primary key,
    nombreProyecto varchar(60),
    fechaInicio date,
    fechaFin date
);

create table convocatoria(
	id int(3) auto_increment primary key,
    num_movilidades int(2),
    duracion int(3),
    tipo varchar(20),
    fechaIniSolicitud date,
    fechaFinSolicitud date,
    fechaIniPruebas date,
    fechaFinPruebas date,
    fechaListadoProvisional date,
    fechaListadoDefinitivo date,
    codigoProyecto varchar(30),
    
    constraint fk_convocatoria_codigoProyecto foreign key (codigoProyecto) references proyecto(codigoProyecto)
);

create table convocatoria_candidato_varemacion(
    idConvocatoria int(3),
    idCandidato varchar(9),
    idItemVaremable int(3),
    nota int(2),
    url varchar(100)
);

create table destinatario(
	codigoGrupo varchar(6) primary key,
    nombre varchar(30)
);

create table convocatoria_destinatario(
    codigoGrupo varchar(6),
    idConvocatorioa int(3)
);
create table destinatarios_convocatoria(
	idConvocatoria varchar(3),
    idDestinatario varchar(6),
    
    constraint fkDestinatarios_convocatoria foreign key (idDestinatario) references destinatario(codigoGrupo)
);

create table itemVaremable(
	id int(3) auto_increment primary key,
    nombre varchar(20)
);

create table convocatoria_itemVaremable(
	idConvocatoria varchar(3),
    idItem varchar(3),
    importancia varchar(3),
    requisito varchar(2),
    valorMinimo int(2),
    aportaAlumno varchar(2)
);

create table nivelIdioma(
	id int(3) auto_increment primary key,
    nombre varchar(3)
);

-- tabla para dar los puntos por nivel de idioma
create table convocatoriaVaremoIdioma(
    idIdioma int(3),
    idConvocatoria int(3),
    puntos int(2)
);





