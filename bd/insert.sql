-- usuarios
insert into user (dni, pass) values ('11111111H','1234'),('54254654T','1234');

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

-- solicitudes
INSERT INTO solicitud (dni, apellidos, nombre, fechaNac, curso, telefono, correo, domicilio, pass, idConvocatoria, dniTutor, apellidosTutor, nombreTutor, telefonoTutor, domicilioTutor) VALUES
('21460184B', 'García', 'Juan', '2000-01-01', '1º ESO', '123456789', 'juan@gmail.com', 'Calle Falsa 123', 'pass123', 1, NULL, NULL, NULL, NULL, NULL),
('44068965E', 'Martínez', 'Ana', '2001-02-02', '2º ESO', '234567890', 'ana@gmail.com', 'Calle Verdadera 234', 'pass234', 2, NULL, NULL, NULL, NULL, NULL),
('06841683B', 'Rodríguez', 'Pedro', '2002-03-03', '3º ESO', '345678901', 'pedro@gmail.com', 'Avenida Principal 345', 'pass345', 3, NULL, NULL, NULL, NULL, NULL),
('24535837N', 'López', 'María', '2003-04-04', '4º ESO', '456789012', 'maria@gmail.com', 'Plaza Mayor 456', 'pass456', 4, NULL, NULL, NULL, NULL, NULL),
('48701978F', 'González', 'Luis', '2004-05-05', '1º Bachillerato', '567890123', 'luis@gmail.com', 'Calle Secundaria 567', 'pass567', 5, NULL, NULL, NULL, NULL, NULL),
('80749342E', 'Pérez', 'Laura', '2005-06-06', '2º Bachillerato', '678901234', 'laura@gmail.com', 'Calle Tercera 678', 'pass678', 6, '78901234G', 'Pérez', 'Carlos', '789012345', 'Calle Cuarta 789'),
('27598239X', 'Sánchez', 'Carlos', '2006-07-07', '1º Universidad', '789012345', 'carlos@gmail.com', 'Calle Quinta 789', 'pass789', 1, '89012345H', 'Sánchez', 'Luisa', '890123456', 'Calle Sexta 890'),
('43313335B', 'Torres', 'Elena', '2007-08-08', '2º Universidad', '890123456', 'elena@gmail.com', 'Calle Séptima 890', 'pass890', 2, '90123456I', 'Torres', 'Manuel', '901234567', 'Calle Octava 901'),
('09123445N', 'Navarro', 'Manuel', '2008-09-09', '3º Universidad', '901234567', 'manuel@gmail.com', 'Calle Novena 901', 'pass901', 3, '01234567J', 'Navarro', 'Elena', '012345678', 'Calle Décima 012'),
('51946667V', 'Ruiz', 'Sara', '2009-10-10', '4º Universidad', '012345678', 'sara@gmail.com', 'Calle Undécima 012', 'pass012', 4, '12345678K', 'Ruiz', 'Juan', '123456789', 'Calle Duodécima 123');
