use erasmus;
-- drop table candidato, tutorLegal;



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
    destino varchar(60),
    
    constraint fk_convocatoria_codigoProyecto foreign key (codigoProyecto) references proyecto(codigoProyecto)
);


create table candidato(
	dni varchar(9) primary key,
    apellidos varchar(100) not null,
    nombre varchar(100) not null,
    fechaNac date not null,
    curso varchar(10) not null,
    telefono varchar(9) not null,
    correo varchar(30) not null,
    domicilio varchar(50),
    pass varchar(30),
    idConvocatoria int(3),
    dniTutor varchar(9),
    apellidosTutor varchar(100),
    nombreTutor varchar(100),
    telefonoTutor varchar(9),
    domicilioTutor varchar(50),
    constraint candidato_fk_convocatoria foreign key (idConvocatoria) references convocatoria(id)
);

create table destinatario(
	codigoGrupo varchar(6) primary key,
    nombre varchar(30)
);

create table convocatoria_destinatario(
    codigoGrupo varchar(6),
    idConvocatoria int(3),
    constraint convocatoria_destinatario_fk_convocatoria foreign key (idConvocatoria) references convocatoria(id),
    constraint convocatoria_destinatario_fk_destinatario foreign key (codigoGrupo) references destinatario(codigoGrupo)
);

create table itemBaremable(
	id int(3) auto_increment primary key,
    nombre varchar(20)
);

create table convocatoria_candidato_baremacion(
    idConvocatoria int(3),
    idCandidato varchar(9),
    idItemBaremable int(3),
    nota int(2),
    url varchar(100),
    constraint convocatoria_candidato_baremacion_pk primary key (idConvocatoria,idCandidato,idItemBaremable),
    constraint convocatoria_candidato_baremacion_fk_convocatoria foreign key (idConvocatoria) references convocatoria(id),
    constraint convocatoria_candidato_baremacion_fk_candidato foreign key (idCandidato) references candidato(dni),
    constraint convocatoria_candidato_baremacion_fk_itemBaremable foreign key (idItemBaremable) references itemBaremable(id)
);

create table convocatoria_itemBaremable(
	idConvocatoria int(3),
    idItem int(3),
    importancia varchar(3),
    requisito varchar(2),
    valorMinimo int(2),
    aportaAlumno varchar(2),

    constraint convocatoria_itemBaremable_fk_convocatoria foreign key (idConvocatoria) references convocatoria(id),
    constraint convocatoria_itemBaremable_fk_itemBaremable foreign key (idItem) references itemBaremable(id)
);

create table nivelIdioma(
	id int(3) auto_increment primary key,
    nombre varchar(3)
);

-- tabla para dar los puntos por nivel de idioma
create table convocatoriaBaremoIdioma(
    idIdioma int(3),
    idConvocatoria int(3),
    puntos int(2),

    constraint convocatoriaBaremoIdioma_nivelIdioma foreign key (idIdioma) references nivelIdioma(id),
    constraint convocatoriaBaremoIdioma_Convocatoria foreign key (idConvocatoria) references convocatoria(id)
);

create table user(
    dni varchar(9) primary key ,
    pass varchar(30)
);





