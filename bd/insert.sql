-- usuarios
insert into user (usuario, pass) values ('manolo','1234'),('silverio','1234');

--  proyectos
INSERT INTO proyecto (codigoProyecto, nombreProyecto, fechaInicio, fechaFin) VALUES
        ('PROJ001', 'Proyecto 1', '2023-01-01', '2024-12-31'),
        ('PROJ002', 'Proyecto 2', '2023-02-01', '2024-12-31'),
        ('PROJ003', 'Proyecto 3', '2023-03-01', '2024-12-31'),
        ('PROJ004', 'Proyecto 4', '2023-04-01', '2024-12-31'),
        ('PROJ005', 'Proyecto 5', '2023-05-01', '2024-12-31');

-- destinatario
INSERT INTO destinatario (codigoGrupo, nombre) VALUES
    ('1DAW', 'Desarrollo de Aplicaciones Web - 1º'),
    ('2DAW', 'Desarrollo de Aplicaciones Web - 2º'),
    ('1DAM', 'Desarrollo de Aplicaciones Multiplataforma - 1º'),
    ('2DAM', 'Desarrollo de Aplicaciones Multiplataforma - 2º'),
    ('1ASIR', 'Administración de Sistemas Informáticos en Red - 1º'),
    ('2ASIR', 'Administración de Sistemas Informáticos en Red - 2º'),
    ('1SEA', 'Sistemas Eléctricos y Automatizados - 1º'),
    ('2SEA', 'Sistemas Eléctricos y Automatizados - 2º'),
    ('1STI', 'Sistemas de Telecomunicaciones e Informáticos - 1º'),
    ('2STI', 'Sistemas de Telecomunicaciones e Informáticos - 2º'),
    ('1MI', 'Mecatrónica Industrial - 1º'),
    ('2MI', 'Mecatrónica Industrial - 2º'),
    ('1ER', 'Energías Renovables - 1º'),
    ('2ER', 'Energías Renovables - 2º');

-- nivel Inglés
INSERT INTO nivelIdioma (nombre) VALUES ('A1'), ('A2'), ('B1'), ('B2'), ('C1'), ('C2');

-- item baremable
INSERT INTO itemBaremable (nombre) VALUES
    ('Nivel Idiomas'),
    ('Informe de Idoneidad'),
    ('Nota Media'),
    ('Entrevista Personal');

-- convocatorias
INSERT INTO convocatoria (num_movilidades, duracion, tipo, fechaIniSolicitud, fechaFinSolicitud, fechaIniPruebas, fechaFinPruebas, fechaListadoProvisional, fechaListadoDefinitivo, codigoProyecto, destino)
VALUES
     (6, 95, 'Larga duración', '2023-01-01', '2023-02-28', '2023-03-01', '2023-04-30', '2023-05-01', '2023-06-30', 'PROJ001', 'Destino1'),
     (6, 85, 'Corta duración', '2023-06-01', '2023-06-30', '2023-07-01', '2023-07-31', '2023-08-01', '2023-08-31', 'PROJ002', 'Destino2'),
     (6, 100, 'Larga duración', '2023-11-01', '2023-11-30', '2023-12-01', '2023-12-31', '2024-01-01', '2024-01-31', 'PROJ003', 'Destino3'),
     (6, 80, 'Corta duración', '2023-10-01', '2023-10-31', '2023-11-01', '2023-11-30', '2023-12-01', '2023-12-31', 'PROJ004', 'Destino4'),
     (6, 105, 'Larga duración', '2023-09-01', '2023-10-31', '2023-11-01', '2023-12-31', '2024-01-01', '2024-02-28', 'PROJ005', 'Destino5'),
     (8, 20, 'Corta duración', '2023-12-01', '2023-12-31', '2024-01-01', '2024-01-31', '2024-02-01', '2024-02-29', 'PROJ003', 'Destino2');

INSERT INTO convocatoria (num_movilidades, duracion, tipo, fechaIniSolicitud, fechaFinSolicitud, fechaIniPruebas, fechaFinPruebas, fechaListadoProvisional, fechaListadoDefinitivo, codigoProyecto, destino)
VALUES
     (6, 95, 'Larga duración', '2023-12-04', '2023-12-30', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-08', 'PROJ004', 'España'),
     (6, 85, 'Corta duración', '2023-12-04', '2023-12-30', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-08', 'PROJ002', 'Francia'),
     (6, 100, 'Larga duración', '2023-12-04', '2023-12-30', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-08', 'PROJ001', 'Alemania'),
     (6, 80, 'Corta duración', '2023-12-04', '2023-12-30', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-08', 'PROJ005', 'Italia'),
     (6, 105, 'Larga duración', '2023-12-04', '2023-12-30', '2023-12-05', '2023-12-06', '2023-12-07', '2023-12-08', 'PROJ001', 'Portugal');

-- solicitudes
INSERT INTO solicitud (dni, apellidos, nombre, fechaNac, curso, telefono, correo, domicilio, pass, idConvocatoria, dniTutor, apellidosTutor, nombreTutor, telefonoTutor, domicilioTutor, imagen) VALUES
('21460184B', 'García', 'Juan', '2000-01-01', '1DAW', '666666666', 'juan@gmail.com', 'Calle Falsa 123', '1234', 1, NULL, NULL, NULL, NULL, NULL, '/recursos/imgSolicitud/hombre.png'),
('44068965E', 'Martínez', 'Ana', '2001-02-02', '1DAW', '666666666', 'ana@gmail.com', 'Calle Verdadera 234', '1234', 2, NULL, NULL, NULL, NULL, NULL, '/recursos/imgSolicitud/hombre.png'),
('06841683B', 'Rodríguez', 'Pedro', '2002-03-03', '2DAW', '666666666', 'pedro@gmail.com', 'Avenida Principal 345', '1234', 3, NULL, NULL, NULL, NULL, NULL, '/recursos/imgSolicitud/hombre.png'),
('24535837N', 'López', 'María', '2003-04-04', '2DAW', '666666666', 'maria@gmail.com', 'Plaza Mayor 456', '1234', 4, NULL, NULL, NULL, NULL, NULL, '/recursos/imgSolicitud/hombre.png'),
('48701978F', 'González', 'Luis', '2004-05-05', '2SEA', '666666666', 'luis@gmail.com', 'Calle Secundaria 567', '1234', 5, NULL, NULL, NULL, NULL, NULL, '/recursos/imgSolicitud/hombre.png'),
('80749342E', 'Pérez', 'Laura', '2005-06-06', '2SEA', '666666666', 'laura@gmail.com', 'Calle Tercera 678', '1234', 6, '46849093W', 'Pérez', 'Carlos', '777777777', 'Calle Cuarta 789', '/recursos/imgSolicitud/mujer.png'),
('27598239X', 'Sánchez', 'Carlos', '2006-07-07', '1SEA', '666666666', 'carlos@gmail.com', 'Calle Quinta 789', '1234', 1, '73158992V', 'Sánchez', 'Luisa', '777777777', 'Calle Sexta 890', '/recursos/imgSolicitud/mujer.png'),
('43313335B', 'Torres', 'Elena', '2007-08-08', '2MI', '666666666', 'elena@gmail.com', 'Calle Séptima 890', '1234', 2, '71732694H', 'Torres', 'Manuel', '777777777', 'Calle Octava 901', '/recursos/imgSolicitud/mujer.png'),
('09123445N', 'Navarro', 'Manuel', '2008-09-09', '2MI', '666666666', 'manuel@gmail.com', 'Calle Novena 901', '1234', 3, '67091510G', 'Navarro', 'Elena', '777777777', 'Calle Décima 012', '/recursos/imgSolicitud/mujer.png'),
('51946667V', 'Ruiz', 'Sara', '2009-10-10', '2ER', '666666666', 'sara@gmail.com', 'Calle Undécima 012', '1234', 4, '37283527K', 'Ruiz', 'Juan', '777777777', 'Calle Duodécima 123', '/recursos/imgSolicitud/mujer.png');
