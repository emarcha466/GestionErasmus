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