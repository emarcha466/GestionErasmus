use erasmus;
-- DROP TABLE IF EXISTS user, convocatoriaBaremoIdioma, convocatoria_itemBaremable, convocatoria_candidato_baremacion, candidato, convocatoria_destinatario, convocatoria, itemBaremable, destinatario, nivelIdioma, proyecto;
-- tabla de los proyectos
CREATE TABLE proyecto
(
    codigoProyecto varchar(30) primary key,
    nombreProyecto varchar(60),
    fechaInicio    date,
    fechaFin       date
);
-- tabla que almacena el nivel de los idiomas
CREATE TABLE nivelIdioma
(
    id     int(3) auto_increment primary key,
    nombre varchar(3)
);

-- tabla que almacena los ciclos a los que va dirigida la convocatoria
CREATE TABLE destinatario
(
    codigoGrupo varchar(6) primary key,
    nombre      varchar(100)
);

-- tabla que almacena las distintas opciones por las que se barema una solicitud
CREATE TABLE itemBaremable
(
    id     int(3) auto_increment primary key,
    nombre varchar(20)
);

-- tabla que almacena las convocatorias a un proyecto (la beca en si)
CREATE TABLE convocatoria
(
    id                      int(3) auto_increment primary key,
    num_movilidades         int(2),
    duracion                int(3),
    tipo                    varchar(20),
    fechaIniSolicitud       date,
    fechaFinSolicitud       date,
    fechaIniPruebas         date,
    fechaFinPruebas         date,
    fechaListadoProvisional date,
    fechaListadoDefinitivo  date,
    codigoProyecto          varchar(30),
    destino                 varchar(60),

    constraint fk_convocatoria_codigoProyecto foreign key (codigoProyecto) references proyecto (codigoProyecto)
);

-- tabla para almacenar los ciclos a los que va dirigida una convocatoria
CREATE TABLE convocatoria_destinatario
(
    codigoGrupo    varchar(6),
    idConvocatoria int(3),
    constraint convocatoria_destinatario_fk_convocatoria foreign key (idConvocatoria) references convocatoria (id),
    constraint convocatoria_destinatario_fk_destinatario foreign key (codigoGrupo) references destinatario (codigoGrupo)
);

-- tabla que almacena los datos de una solicitud a una convocatoria (la persona que se presenta)
CREATE TABLE candidato
(
    dni            varchar(9) primary key,
    apellidos      varchar(100) not null,
    nombre         varchar(100) not null,
    fechaNac       date         not null,
    curso          varchar(10)  not null,
    telefono       varchar(9)   not null,
    correo         varchar(30)  not null,
    domicilio      varchar(50),
    pass           varchar(30),
    idConvocatoria int(3),
    dniTutor       varchar(9),
    apellidosTutor varchar(100),
    nombreTutor    varchar(100),
    telefonoTutor  varchar(9),
    domicilioTutor varchar(50),
    constraint candidato_fk_convocatoria foreign key (idConvocatoria) references convocatoria (id)
);

-- tabla que almacena la nota que ha sacado el alumno en las distintas opciones baremables
CREATE TABLE convocatoria_candidato_baremacion
(
    idConvocatoria  int(3),
    idCandidato     varchar(9),
    idItemBaremable int(3),
    nota            int(2),
    url             varchar(100),
    constraint convocatoria_candidato_baremacion_pk primary key (idConvocatoria, idCandidato, idItemBaremable),
    constraint convocatoria_candidato_baremacion_fk_convocatoria foreign key (idConvocatoria) references convocatoria (id),
    constraint convocatoria_candidato_baremacion_fk_candidato foreign key (idCandidato) references candidato (dni),
    constraint convocatoria_candidato_baremacion_fk_itemBaremable foreign key (idItemBaremable) references itemBaremable (id)
);


-- tabla que establece el item que se barema en la convocatoria, su importancia (puntos max),
-- requisito (si/no), si es si se establece un valor minimo por el cual si el alumno no supera esa nota
-- queda fuera de la convocatoria, y aporta alumno establece si ese item lo aporta el alumno o el profesor
CREATE TABLE convocatoria_itemBaremable
(
    idConvocatoria int(3),
    idItem         int(3),
    importancia    varchar(3),
    requisito      varchar(2),
    valorMinimo    int(2),
    aportaAlumno   varchar(2),

    constraint convocatoria_itemBaremable_fk_convocatoria foreign key (idConvocatoria) references convocatoria (id),
    constraint convocatoria_itemBaremable_fk_itemBaremable foreign key (idItem) references itemBaremable (id)
);

-- tabla que establece el valor que tendrá cada nivel de idioma en la convocatoria
CREATE TABLE convocatoriaBaremoIdioma
(
    idIdioma       int(3),
    idConvocatoria int(3),
    puntos         int(2),

    constraint convocatoriaBaremoIdioma_nivelIdioma foreign key (idIdioma) references nivelIdioma (id),
    constraint convocatoriaBaremoIdioma_Convocatoria foreign key (idConvocatoria) references convocatoria (id)
);

-- tabla que almacena los administradores
CREATE TABLE user
(
    dni  varchar(9) primary key,
    pass varchar(30)
);