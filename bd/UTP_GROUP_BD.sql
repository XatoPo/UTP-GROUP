/* 
 * UTP_GROUP_BD.sql
 * 
 * This file contains the SQL statements to create the database schema for the
 * UTP Group project.
 * 
 * Author: Flavio Sebastian Villanueva Medina (flaviovm2013@gmail.com)
 *
 * Date: 2024-06-06
 *
 * Copyright (c) 2024Flavio Sebastian Villanueva Medina
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Create for HACKATON 2024 - UTP
 *
 * Byte Busters
 */

CREATE DATABASE IF NOT EXISTS UTP_GROUP;
USE UTP_GROUP;

CREATE TABLE students (
    student_id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    cellphone VARCHAR(15),
    profile_picture VARCHAR(255),
    description TEXT,
    career VARCHAR(100),
    study_mode ENUM('Presencial', 'Virtual', 'Asincrónica'),
    birth_date DATE,
    academic_cycle INT
);

-- TABLA DE PROFESORES
CREATE TABLE professors (
    professor_id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

-- TABLA DE CURSOS
CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100),
    professor_id VARCHAR(10),
    FOREIGN KEY (professor_id) REFERENCES professors(professor_id)
) AUTO_INCREMENT = 1001;


-- TABLA INTERMEDIA DE ESTUDIANTES - CURSOS
CREATE TABLE student_courses (
    student_id VARCHAR(10),
    course_id INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    PRIMARY KEY (student_id, course_id)
);

-- TABLA DE HABILIDADES
CREATE TABLE skills (
    skill_id CHAR(6) PRIMARY KEY,
    student_id VARCHAR(10),
    skill_name VARCHAR(60),
    skill_topic ENUM('Skills Blandas', 'Skills Técnicas'),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Trigger para autogenerar skill_id en el formato 'SK1001'
DELIMITER //
CREATE TRIGGER trg_skills_id BEFORE INSERT ON skills
FOR EACH ROW
BEGIN
    SET NEW.skill_id = (SELECT CONCAT('SK', LPAD(IFNULL(MAX(CAST(SUBSTRING(skill_id, 3) AS UNSIGNED)), 0) + 1, 4, '0')) FROM skills);
END;
//
DELIMITER ;

-- TABLA DE HOBBIES
CREATE TABLE hobbies (
    hobby_id CHAR(6) PRIMARY KEY,
    student_id VARCHAR(10),
    hobby_name VARCHAR(60),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Trigger para autogenerar hobby_id en el formato 'SK1001'
DELIMITER //
CREATE TRIGGER trg_hobby_id BEFORE INSERT ON hobbies
FOR EACH ROW
BEGIN
    SET NEW.hobby_id = (SELECT CONCAT('HB', LPAD(IFNULL(MAX(CAST(SUBSTRING(hobby_id, 3) AS UNSIGNED)), 0) + 1, 4, '0')) FROM hobbies);
END;
//
DELIMITER ;

-- TABLA DE GRUPOS POR CURSO
CREATE TABLE groups (
    group_id CHAR(6) PRIMARY KEY,
    course_id INT,
    group_name VARCHAR(100),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

-- Trigger para autogenerar group_id en el formato 'GR1000' en adelante
DELIMITER //
CREATE TRIGGER trg_groups_id BEFORE INSERT ON groups
FOR EACH ROW
BEGIN
    SET NEW.group_id = (SELECT CONCAT('GR', LPAD(IFNULL(MAX(CAST(SUBSTRING(group_id, 3) AS UNSIGNED)), 999) + 1, 4, '0')) FROM groups);
END;
//
DELIMITER ;

-- TABLA DE ROLES PARA LOS GRUPOS
CREATE TABLE roles (
    role_id CHAR(6) PRIMARY KEY,
    role_name VARCHAR(100),
    description TEXT
);

-- Trigger para autogenerar role_id en el formato 'ROLE1' y así sucesivamente
DELIMITER //
CREATE TRIGGER trg_role_id BEFORE INSERT ON roles
FOR EACH ROW
BEGIN
    SET NEW.role_id = CONCAT('ROLE', (SELECT IFNULL(MAX(CAST(SUBSTRING(role_id, 5) AS UNSIGNED)), 0) + 1));
END;
//
DELIMITER ;

-- TABLA DE FEEDBACK
CREATE TABLE feedback (
    feedback_id CHAR(6) PRIMARY KEY,
    giver_id VARCHAR(10),
    receiver_id VARCHAR(10),
    group_id CHAR(6),
    stars TINYINT,
    comment TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (giver_id) REFERENCES students(student_id),
    FOREIGN KEY (receiver_id) REFERENCES students(student_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id)
);

-- Trigger para autogenerar feedback_id en el formato 'FB1000' en adelante
DELIMITER //
CREATE TRIGGER trg_feedback_id BEFORE INSERT ON feedback
FOR EACH ROW
BEGIN
    SET NEW.feedback_id = (SELECT CONCAT('FB', LPAD(IFNULL(MAX(CAST(SUBSTRING(feedback_id, 3) AS UNSIGNED)), 999) + 1, 4, '0')) FROM feedback);
END;
//
DELIMITER ;

-- DATOS TABLA DE ESTUDIANTES
INSERT INTO students (student_id, name, email, password, cellphone, profile_picture, description, career, study_mode, birth_date, academic_cycle) VALUES 
('U21201391', 'Flavio Sebastian Villanueva Medina', 'U21201391@gmail.com', 'ContPrueba373', '+51 992851981', 'images\perfil\U21201391-photo.jpg', 'Soy un estudiante apasionado de Ingeniería de Software, me considero proactivo, adaptable a entornos laborales dinámicos y con una rápida capacidad de aprendizaje de nuevas tecnologías. Estoy constantemente explorando y actualizándome en innovaciones tecnológicas. Además de mi pasión por la programación, soy un amante de la música y tengo una gran melomanía, disfruto escuchando música en mis tiempos libres. También soy un apasionado de Marvel, los cómics y el coleccionismo. Me encanta sumergirme en los mundos de superhéroes y adquirir artículos de colección relacionados. Busco desafíos que impulsan mi crecimiento como programador y oportunidades para aplicar mis habilidades en un entorno colaborativo y desafiante, combinando mi pasión por la tecnología con mis intereses personales.', 'Ingeniería de Software', 'Presencial', '2002-01-28', 7),
('U21201392', 'Andrea Isabel Ramirez Lopez', 'U21201392@utp.edu.pe', 'ContPrueba374', '+51 997654321', 'images/perfil/U21201392-photo.jpg', 'Soy estudiante de Administración de Empresas, interesada en la gestión de recursos humanos y estrategias empresariales. Me gusta el trabajo en equipo y busco siempre mejorar mis habilidades en liderazgo y comunicación.', 'Administración de Empresas', 'Presencial', '2006-04-10', 2),
('U21201393', 'Carlos Enrique Gomez Torres', 'U21201393@utp.edu.pe', 'ContPrueba375', '+51 993456789', 'images/perfil/U21201393-photo.jpg', 'Estudiante de Ingeniería Civil, apasionado por el diseño estructural y la construcción sostenible. Disfruto trabajando en proyectos que involucran innovación en la ingeniería y busco contribuir al desarrollo de infraestructuras eficientes.', 'Ingeniería Civil', 'Virtual', '2007-09-25', 1),
('U21201394', 'Lucia Marisol Paredes Herrera', 'U21201394@utp.edu.pe', 'ContPrueba376', '+51 991234567', 'images/perfil/U21201394-photo.jpg', 'Futura comunicadora social, enfocada en el periodismo digital y la producción audiovisual. Me gusta contar historias y crear contenido que impacte positivamente en la sociedad.', 'Comunicación Social', 'Asincrónica', '2005-11-20', 3),
('U21201395', 'Miguel Angel Rios Castro', 'U21201395@utp.edu.pe', 'ContPrueba377', '+51 992345678', 'images/perfil/U21201395-photo.jpg', 'Soy estudiante de Marketing y Publicidad, interesado en las estrategias digitales y el comportamiento del consumidor. Me motiva crear campañas innovadoras que conecten con las audiencias.', 'Marketing y Publicidad', 'Presencial', '2006-01-30', 2),
('U21201396', 'Valeria Sofia Delgado Rojas', 'U21201396@utp.edu.pe', 'ContPrueba378', '+51 994567890', 'images/perfil/U21201396-photo.jpg', 'Estudio Derecho, con un interés particular en el derecho corporativo y la defensa de los derechos humanos. Busco aplicar mis conocimientos en entornos que promuevan la justicia y la equidad.', 'Derecho', 'Virtual', '2007-07-15', 1),
('U21201397', 'Jorge Luis Fernandez Muñoz', 'U21201397@utp.edu.pe', 'ContPrueba379', '+51 995678901', 'images/perfil/U21201397-photo.jpg', 'Futuro ingeniero electrónico, apasionado por la robótica y los sistemas embebidos. Me gusta desarrollar proyectos que integren tecnología avanzada y solucionen problemas del mundo real.', 'Ingeniería Electrónica', 'Asincrónica', '2005-03-22', 3),
('U21201398', 'Ana Maria Gonzales Chavez', 'U21201398@utp.edu.pe', 'ContPrueba380', '+51 996789012', 'images/perfil/U21201398-photo.jpg', 'Estudiante de Psicología, interesada en la psicología clínica y el desarrollo personal. Mi objetivo es ayudar a las personas a superar sus desafíos y alcanzar su máximo potencial.', 'Psicología', 'Presencial', '2006-10-05', 2),
('U21201399', 'Pedro Alejandro Torres Vasquez', 'U21201399@utp.edu.pe', 'ContPrueba381', '+51 997890123', 'images/perfil/U21201399-photo.jpg', 'Futuro ingeniero mecánico, con una gran pasión por el diseño y la manufactura de maquinaria. Disfruto trabajar en proyectos que involucren innovación y eficiencia energética.', 'Ingeniería Mecánica', 'Virtual', '2007-05-18', 1),
('U21201400', 'Claudia Beatriz Ramirez Soto', 'U21201400@utp.edu.pe', 'ContPrueba382', '+51 998901234', 'images/perfil/U21201400-photo.jpg', 'Estudiante de Enfermería, comprometida con el cuidado y la atención de pacientes. Me motiva contribuir al bienestar de las personas y mejorar los sistemas de salud.', 'Enfermería', 'Asincrónica', '2005-12-30', 3),
('U21201401', 'Luis Fernando Castillo Rivas', 'U21201401@utp.edu.pe', 'ContPrueba383', '+51 999012345', 'images/perfil/U21201401-photo.jpg', 'Estudio Contabilidad, con un enfoque en la auditoría y la gestión financiera. Me apasiona el análisis de datos y la optimización de recursos económicos.', 'Contabilidad', 'Presencial', '2006-08-25', 2),
('U21201402', 'Maria Teresa Ortiz Peña', 'U21201402@utp.edu.pe', 'ContPrueba384', '+51 991112233', 'images/perfil/U21201402-photo.jpg', 'Soy estudiante de Arquitectura, interesada en el diseño sostenible y la planificación urbana. Mi objetivo es crear espacios que sean funcionales y estéticamente atractivos.', 'Arquitectura', 'Virtual', '2007-02-14', 1),
('U21201403', 'Jose Manuel Herrera Luna', 'U21201403@utp.edu.pe', 'ContPrueba385', '+51 992223344', 'images/perfil/U21201403-photo.jpg', 'Futuro ingeniero de sistemas, apasionado por la ciberseguridad y el desarrollo de software. Me gusta resolver problemas complejos y mejorar la eficiencia de los sistemas tecnológicos.', 'Ingeniería de Sistemas', 'Asincrónica', '2005-04-10', 3),
('U21201404', 'Camila Andrea Salazar Mendoza', 'U21201404@utp.edu.pe', 'ContPrueba386', '+51 993334455', 'images/perfil/U21201404-photo.jpg', 'Estudiante de Medicina, con un gran interés en la cirugía y la investigación médica. Me motiva aprender constantemente y contribuir al avance de la ciencia médica.', 'Medicina', 'Presencial', '2006-06-29', 2),
('U21201405', 'Daniel Alejandro Chavez Ruiz', 'U21201405@utp.edu.pe', 'ContPrueba387', '+51 994445566', 'images/perfil/U21201405-photo.jpg', 'Futuro economista, interesado en la macroeconomía y las políticas públicas. Me apasiona analizar datos económicos y buscar soluciones a problemas financieros.', 'Economía', 'Virtual', '2007-01-18', 1),
('U21201406', 'Laura Isabel Perez Vega', 'U21201406@utp.edu.pe', 'ContPrueba388', '+51 995556677', 'images/perfil/U21201406-photo.jpg', 'Soy estudiante de Biología, enfocada en la investigación genética y la conservación ambiental. Me encanta trabajar en proyectos que busquen preservar la biodiversidad.', 'Biología', 'Asincrónica', '2005-09-12', 3),
('U21201407', 'Rodrigo Emilio Vargas Castillo', 'U21201407@utp.edu.pe', 'ContPrueba389', '+51 996667788', 'images/perfil/U21201407-photo.jpg', 'Estudio Ingeniería Industrial, interesado en la optimización de procesos y la gestión de la calidad. Me motiva mejorar la eficiencia y productividad en las empresas.', 'Ingeniería Industrial', 'Presencial', '2006-03-03', 2),
('U21201408', 'Patricia Rosa Diaz Flores', 'U21201408@utp.edu.pe', 'ContPrueba390', '+51 997778899', 'images/perfil/U21201408-photo.jpg', 'Estudiante de Ciencias de la Comunicación, con un enfoque en la publicidad y las relaciones públicas. Me gusta crear estrategias comunicacionales efectivas y creativas.', 'Ciencias de la Comunicación', 'Virtual', '2007-11-08', 1),
('U21201409', 'Victor Hugo Lopez Paredes', 'U21201409@utp.edu.pe', 'ContPrueba391', '+51 998889900', 'images/perfil/U21201409-photo.jpg', 'Futuro químico, apasionado por la investigación en materiales y la química ambiental. Me motiva descubrir nuevas aplicaciones y soluciones sostenibles.', 'Química', 'Asincrónica', '2005-07-25', 3),
('U21201410', 'Elena Margarita Ruiz Santos', 'U21201410@utp.edu.pe', 'ContPrueba392', '+51 999990000', 'images/perfil/U21201410-photo.jpg', 'Soy estudiante de Sociología, interesada en el estudio de las dinámicas sociales y la justicia social. Mi objetivo es contribuir a una sociedad más equitativa y justa.', 'Sociología', 'Presencial', '2006-05-17', 2),
('U21201411', 'Juan Carlos Mendez Herrera', 'U21201411@utp.edu.pe', 'ContPrueba393', '+51 991111222', 'images/perfil/U21201411-photo.jpg', 'Estudio Ingeniería de Software, con un interés particular en el desarrollo de aplicaciones móviles y la inteligencia artificial. Me gusta estar al día con las últimas tendencias tecnológicas.', 'Ingeniería de Software', 'Virtual', '2007-10-22', 1),
('U21201412', 'Luciana Beatriz Rojas Chavez', 'U21201412@utp.edu.pe', 'ContPrueba394', '+51 992222333', 'images/perfil/U21201412-photo.jpg', 'Estudiante de Ingeniería Ambiental, comprometida con la sostenibilidad y la gestión de recursos naturales. Me apasiona trabajar en proyectos que busquen proteger el medio ambiente.', 'Ingeniería Ambiental', 'Asincrónica', '2005-08-19', 3),
('U21201413', 'Ricardo Antonio Vega Ruiz', 'U21201413@utp.edu.pe', 'ContPrueba395', '+51 993333444', 'images/perfil/U21201413-photo.jpg', 'Futuro ingeniero de telecomunicaciones, interesado en las redes de comunicación y la tecnología 5G. Me motiva estar a la vanguardia de las innovaciones tecnológicas.', 'Ingeniería de Telecomunicaciones', 'Presencial', '2006-12-02', 2),
('U21201414', 'Gabriela Sofia Navarro Ramirez', 'U21201414@utp.edu.pe', 'ContPrueba396', '+51 994444555', 'images/perfil/U21201414-photo.jpg', 'Soy estudiante de Educación, con un enfoque en la educación inicial y la pedagogía infantil. Me encanta trabajar con niños y contribuir a su desarrollo integral.', 'Educación Inicial', 'Virtual', '2007-06-27', 1),
('U21201415', 'David Alfonso Paredes Jimenez', 'U21201415@utp.edu.pe', 'ContPrueba397', '+51 995555666', 'images/perfil/U21201415-photo.jpg', 'Estudio Física, apasionado por la investigación en física teórica y la astrofísica. Me motiva entender los principios fundamentales del universo.', 'Física', 'Asincrónica', '2005-04-30', 3),
('U21201416', 'Alejandra Lucia Morales Flores', 'U21201416@utp.edu.pe', 'ContPrueba398', '+51 996666777', 'images/perfil/U21201416-photo.jpg', 'Estudiante de Literatura, interesada en la crítica literaria y la escritura creativa. Me apasiona analizar obras literarias y crear mis propias historias.', 'Literatura', 'Presencial', '2006-11-14', 2),
('U21201417', 'Cristian Andres Cruz Diaz', 'U21201417@utp.edu.pe', 'ContPrueba399', '+51 997777888', 'images/perfil/U21201417-photo.jpg', 'Futuro ingeniero eléctrico, con un gran interés en las energías renovables y la automatización industrial. Me gusta trabajar en proyectos que promuevan la sostenibilidad energética.', 'Ingeniería Eléctrica', 'Virtual', '2007-03-05', 1),
('U21201418', 'Sofia Carolina Ramirez Torres', 'U21201418@utp.edu.pe', 'ContPrueba400', '+51 998888999', 'images/perfil/U21201418-photo.jpg', 'Soy estudiante de Historia, enfocada en la historia contemporánea y los estudios culturales. Me motiva investigar y comprender los eventos que han moldeado el mundo actual.', 'Historia', 'Asincrónica', '2005-09-07', 3),
('U21201419', 'Julian Alejandro Herrera Castillo', 'U21201419@utp.edu.pe', 'ContPrueba401', '+51 999999111', 'images/perfil/U21201419-photo.jpg', 'Estudio Filosofía, interesado en la ética y la filosofía política. Me apasiona debatir y analizar cuestiones fundamentales sobre la existencia y la sociedad.', 'Filosofía', 'Presencial', '2006-02-23', 2),
('U21201420', 'Carla Fernanda Lopez Vega', 'U21201420@utp.edu.pe', 'ContPrueba402', '+51 991000111', 'images/perfil/U21201420-photo.jpg', 'Estudiante de Nutrición, comprometida con la promoción de estilos de vida saludables y la educación alimentaria. Me motiva ayudar a las personas a mejorar su bienestar a través de la nutrición.', 'Nutrición', 'Virtual', '2007-08-11', 1),
('U21201421', 'Pablo Miguel Torres Herrera', 'U21201421@utp.edu.pe', 'ContPrueba403', '+51 992111222', 'images/perfil/U21201421-photo.jpg', 'Futuro politólogo, interesado en las relaciones internacionales y la política comparada. Me motiva analizar y proponer soluciones a los desafíos globales.', 'Ciencias Políticas', 'Asincrónica', '2005-10-03', 3),
('U21201422', 'Daniela Isabel Perez Lopez', 'U21201422@utp.edu.pe', 'ContPrueba404', '+51 993222333', 'images/perfil/U21201422-photo.jpg', 'Soy estudiante de Artes Plásticas, interesada en la pintura y la escultura contemporánea. Me apasiona expresar mi creatividad y explorar nuevas técnicas artísticas.', 'Artes Plásticas', 'Presencial', '2006-01-27', 2),
('U21201423', 'Javier Alejandro Ruiz Flores', 'U21201423@utp.edu.pe', 'ContPrueba405', '+51 994333444', 'images/perfil/U21201423-photo.jpg', 'Estudiante de Ingeniería Geológica, con un enfoque en la exploración y explotación de recursos minerales. Me motiva trabajar en proyectos que contribuyan al desarrollo sostenible.', 'Ingeniería Geológica', 'Virtual', '2007-09-01', 1),
('U21201424', 'Lucia Maria Fernandez Herrera', 'U21201424@utp.edu.pe', 'ContPrueba406', '+51 995444555', 'images/perfil/U21201424-photo.jpg', 'Soy estudiante de Trabajo Social, comprometida con la ayuda comunitaria y la defensa de los derechos sociales. Me motiva trabajar en proyectos que promuevan la inclusión y la justicia social.', 'Trabajo Social', 'Asincrónica', '2005-05-21', 3);

-- DATOS TABLA DE PROFESORES
INSERT INTO professors (professor_id, name, email, password) VALUES 
('C15137', 'María Fernanda López Gonzales', 'C15137@utp.edu.pe', 'Profcotra400'),
('C15138', 'Roberto Miguel Torres Vargas', 'C15138@utp.edu.pe', 'Profcotra401'),
('C15139', 'Ana Patricia Ramos Díaz', 'C15139@utp.edu.pe', 'Profcotra402'),
('C15140', 'Luis Alberto Castillo Ruiz', 'C15140@utp.edu.pe', 'Profcotra403'),
('C15141', 'Elena Gabriela Morales Fuentes', 'C15141@utp.edu.pe', 'Profcotra404');

-- DATOS TABLA DE CURSOS
INSERT INTO courses (course_name, professor_id) VALUES
('Herramientas para la Comunicación Efectiva', 'C15137'),
('Programación Lógica y Funcional', 'C15138'),
('Programación de Videojuegos con C++', 'C15139'),
('Seguridad Informática', 'C15140'),
('Programación de Sistemas de Información', 'C15141'),
('Sistemas Distribuidos', 'C15141'),
('Redes y Comunicación de Datos I', 'C15140'),
('Redes y Comunicación de Datos II', 'C15139'),
('Arquitectura de Computadoras', 'C15138'),
('Química', 'C15137'),
('Quimica Inorganica', 'C15137'),
('Problemas y Desafios del Perú Actual', 'C15138'),
('Logica y Probabilidad', 'C15139'),
('Matematica para los Negocios', 'C15140');

-- DATOS TABLA ESTUDIANTES-CURSOS
INSERT INTO student_courses (student_id, course_id) VALUES 
('U21201391', 1001),
('U21201392', 1001),
('U21201393', 1001),
('U21201394', 1001),        
('U21201395', 1001),
('U21201396', 1001),
('U21201397', 1001),        
('U21201398', 1001),
('U21201399', 1001),
('U21201400', 1001),
('U21201401', 1001),
('U21201402', 1001),
('U21201403', 1001),
('U21201404', 1001),
('U21201405', 1001),
('U21201406', 1001),
('U21201407', 1001),
('U21201408', 1001),
('U21201409', 1001),
('U21201410', 1001),
('U21201411', 1001),
('U21201412', 1001),
('U21201413', 1001),
('U21201414', 1001),
('U21201415', 1001),
('U21201416', 1001),
('U21201417', 1001),
('U21201418', 1001);

-- DATOS TABLA HABILIDADES
INSERT INTO skills (student_id, skill_name, skill_topic) VALUES 
('U21201391', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201391', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201391', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201391', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201391', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201391', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201391', 'Programación en C++', 'Conocimientos'),
('U21201391', 'Desarrollo de software ágil', 'Conocimientos'),
('U21201391', 'Bases de datos SQL', 'Conocimientos'),
('U21201391', 'Ingeniería de requisitos', 'Conocimientos'),
('U21201391', 'Pruebas unitarias', 'Conocimientos'),
('U21201391', 'Control de versiones con Git', 'Conocimientos'),

('U21201392', 'Liderazgo', 'Habilidades Blandas'),
('U21201392', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201392', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201392', 'Resolución de conflictos', 'Habilidades Blandas'),
('U21201392', 'Negociación', 'Habilidades Blandas'),
('U21201392', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201392', 'Gestión de recursos humanos', 'Conocimientos'),
('U21201392', 'Estrategias de marketing', 'Conocimientos'),
('U21201392', 'Análisis financiero', 'Conocimientos'),
('U21201392', 'Planificación estratégica', 'Conocimientos'),
('U21201392', 'Manejo de Excel avanzado', 'Conocimientos'),
('U21201392', 'Desarrollo organizacional', 'Conocimientos'),

('U21201393', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201393', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201393', 'Liderazgo', 'Habilidades Blandas'),
('U21201393', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201393', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201393', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201393', 'Diseño estructural', 'Conocimientos'),
('U21201393', 'AutoCAD', 'Conocimientos'),
('U21201393', 'Cálculo de estructuras', 'Conocimientos'),
('U21201393', 'Gestión de proyectos de construcción', 'Conocimientos'),
('U21201393', 'Ingeniería de suelos', 'Conocimientos'),
('U21201393', 'Modelado BIM', 'Conocimientos'),

('U21201394', 'Creatividad', 'Habilidades Blandas'),
('U21201394', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201394', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201394', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201394', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201394', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201394', 'Redacción periodística', 'Conocimientos'),
('U21201394', 'Producción audiovisual', 'Conocimientos'),
('U21201394', 'Comunicación digital', 'Conocimientos'),
('U21201394', 'Fotografía profesional', 'Conocimientos'),
('U21201394', 'Edición de video', 'Conocimientos'),
('U21201394', 'Gestión de redes sociales', 'Conocimientos'),

('U21201395', 'Creatividad', 'Habilidades Blandas'),
('U21201395', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201395', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201395', 'Negociación', 'Habilidades Blandas'),
('U21201395', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201395', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201395', 'Estrategias de marketing digital', 'Conocimientos'),
('U21201395', 'Análisis de mercado', 'Conocimientos'),
('U21201395', 'Publicidad creativa', 'Conocimientos'),
('U21201395', 'Gestión de campañas publicitarias', 'Conocimientos'),
('U21201395', 'SEO y SEM', 'Conocimientos'),
('U21201395', 'Email marketing', 'Conocimientos'),

('U21201396', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201396', 'Liderazgo', 'Habilidades Blandas'),
('U21201396', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201396', 'Resolución de conflictos', 'Habilidades Blandas'),
('U21201396', 'Negociación', 'Habilidades Blandas'),
('U21201396', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201396', 'Derecho corporativo', 'Conocimientos'),
('U21201396', 'Legislación laboral', 'Conocimientos'),
('U21201396', 'Derecho civil y procesal civil', 'Conocimientos'),
('U21201396', 'Redacción de contratos', 'Conocimientos'),
('U21201396', 'Derecho penal', 'Conocimientos'),
('U21201396', 'Litigación oral', 'Conocimientos'),

('U21201397', 'Creatividad', 'Habilidades Blandas'),
('U21201397', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201397', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201397', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201397', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201397', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201397', 'Robótica', 'Conocimientos'),
('U21201397', 'Sistemas embebidos', 'Conocimientos'),
('U21201397', 'Programación en VHDL', 'Conocimientos'),
('U21201397', 'Diseño de circuitos electrónicos', 'Conocimientos'),
('U21201397', 'Microcontroladores', 'Conocimientos'),
('U21201397', 'Sensores y actuadores', 'Conocimientos'),

('U21201398', 'Empatía', 'Habilidades Blandas'),
('U21201398', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201398', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201398', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201398', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201398', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201398', 'Psicología clínica', 'Conocimientos'),
('U21201398', 'Terapia cognitivo-conductual', 'Conocimientos'),
('U21201398', 'Evaluación psicológica', 'Conocimientos'),
('U21201398', 'Intervención en crisis', 'Conocimientos'),
('U21201398', 'Psicología infantil', 'Conocimientos'),
('U21201398', 'Psicopatología', 'Conocimientos'),

('U21201399', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201399', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201399', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201399', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201399', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201399', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201399', 'Mecánica de fluidos', 'Conocimientos'),
('U21201399', 'Diseño mecánico', 'Conocimientos'),
('U21201399', 'Manufactura asistida por computadora', 'Conocimientos'),
('U21201399', 'Mantenimiento predictivo', 'Conocimientos'),
('U21201399', 'Termodinámica', 'Conocimientos'),
('U21201399', 'Análisis de fallos', 'Conocimientos'),

('U21201400', 'Empatía', 'Habilidades Blandas'),
('U21201400', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201400', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201400', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201400', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201400', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201400', 'Cuidados de enfermería', 'Conocimientos'),
('U21201400', 'Técnicas de primeros auxilios', 'Conocimientos'),
('U21201400', 'Farmacología', 'Conocimientos'),
('U21201400', 'Enfermería quirúrgica', 'Conocimientos'),
('U21201400', 'Atención primaria de salud', 'Conocimientos'),
('U21201400', 'Gestión de servicios de salud', 'Conocimientos'),

('U21201401', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201401', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201401', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201401', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201401', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201401', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201401', 'Contabilidad financiera', 'Conocimientos'),
('U21201401', 'Auditoría interna', 'Conocimientos'),
('U21201401', 'Normas Internacionales de Información Financiera (NIIF)', 'Conocimientos'),
('U21201401', 'Impuestos y fiscalidad', 'Conocimientos'),
('U21201401', 'Control de gestión', 'Conocimientos'),
('U21201401', 'Contabilidad de costos', 'Conocimientos'),

('U21201402', 'Creatividad', 'Habilidades Blandas'),
('U21201402', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201402', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201402', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201402', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201402', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201402', 'Diseño arquitectónico', 'Conocimientos'),
('U21201402', 'Autodesk Revit', 'Conocimientos'),
('U21201402', 'Urbanismo', 'Conocimientos'),
('U21201402', 'Eficiencia energética en edificios', 'Conocimientos'),
('U21201402', 'Historia de la arquitectura', 'Conocimientos'),
('U21201402', 'Modelado 3D', 'Conocimientos'),

('U21201403', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201403', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201403', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201403', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201403', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201403', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201403', 'Ciberseguridad', 'Conocimientos'),
('U21201403', 'Desarrollo de software', 'Conocimientos'),
('U21201403', 'Redes de computadoras', 'Conocimientos'),
('U21201403', 'Administración de bases de datos', 'Conocimientos'),
('U21201403', 'Inteligencia artificial', 'Conocimientos'),
('U21201403', 'Ingeniería de software', 'Conocimientos'),

('U21201404', 'Empatía', 'Habilidades Blandas'),
('U21201404', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201404', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201404', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201404', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201404', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201404', 'Anatomía humana', 'Conocimientos'),
('U21201404', 'Fisiología médica', 'Conocimientos'),
('U21201404', 'Cirugía general', 'Conocimientos'),
('U21201404', 'Investigación clínica', 'Conocimientos'),
('U21201404', 'Farmacología médica', 'Conocimientos'),
('U21201404', 'Diagnóstico por imágenes', 'Conocimientos'),

('U21201405', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201405', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201405', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201405', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201405', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201405', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201405', 'Análisis macroeconómico', 'Conocimientos'),
('U21201405', 'Modelos econométricos', 'Conocimientos'),
('U21201405', 'Políticas públicas', 'Conocimientos'),
('U21201405', 'Microeconomía avanzada', 'Conocimientos'),
('U21201405', 'Economía internacional', 'Conocimientos'),
('U21201405', 'Economía del desarrollo', 'Conocimientos'),

('U21201406', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201406', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201406', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201406', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201406', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201406', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201406', 'Genética molecular', 'Conocimientos'),
('U21201406', 'Biotecnología', 'Conocimientos'),
('U21201406', 'Ecología y conservación', 'Conocimientos'),
('U21201406', 'Microbiología', 'Conocimientos'),
('U21201406', 'Biología celular', 'Conocimientos'),
('U21201406', 'Bioquímica', 'Conocimientos'),

('U21201407', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201407', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201407', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201407', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201407', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201407', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201407', 'Optimización de procesos', 'Conocimientos'),
('U21201407', 'Gestión de la calidad', 'Conocimientos'),
('U21201407', 'Manufactura Lean', 'Conocimientos'),
('U21201407', 'Logística industrial', 'Conocimientos'),
('U21201407', 'Seguridad industrial', 'Conocimientos'),
('U21201407', 'Simulación de procesos', 'Conocimientos'),

('U21201408', 'Creatividad', 'Habilidades Blandas'),
('U21201408', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201408', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201408', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201408', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201408', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201408', 'Publicidad y relaciones públicas', 'Conocimientos'),
('U21201408', 'Producción multimedia', 'Conocimientos'),
('U21201408', 'Estrategias de comunicación', 'Conocimientos'),
('U21201408', 'Comunicación organizacional', 'Conocimientos'),
('U21201408', 'Marketing digital', 'Conocimientos'),
('U21201408', 'Gestión de la comunicación de crisis', 'Conocimientos'),

('U21201409', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201409', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201409', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201409', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201409', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201409', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201409', 'Química analítica', 'Conocimientos'),
('U21201409', 'Química orgánica', 'Conocimientos'),
('U21201409', 'Síntesis de materiales', 'Conocimientos'),
('U21201409', 'Química ambiental', 'Conocimientos'),
('U21201409', 'Análisis instrumental', 'Conocimientos'),
('U21201409', 'Fisicoquímica', 'Conocimientos'),

('U21201410', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201410', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201410', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201410', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201410', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201410', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201410', 'Programación en Java', 'Conocimientos'),
('U21201410', 'Desarrollo web con HTML/CSS', 'Conocimientos'),
('U21201410', 'Bases de datos MySQL', 'Conocimientos'),
('U21201410', 'Ingeniería de software', 'Conocimientos'),
('U21201410', 'Desarrollo de aplicaciones móviles', 'Conocimientos'),
('U21201410', 'Control de versiones con Git', 'Conocimientos'),

('U21201411', 'Resolución de problemas', 'Habilidades Blandas'),
('U21201411', 'Trabajo en equipo', 'Habilidades Blandas'),
('U21201411', 'Comunicación efectiva', 'Habilidades Blandas'),
('U21201411', 'Gestión del tiempo', 'Habilidades Blandas'),
('U21201411', 'Adaptabilidad', 'Habilidades Blandas'),
('U21201411', 'Pensamiento crítico', 'Habilidades Blandas'),
('U21201411', 'Diseño gráfico', 'Conocimientos'),
('U21201411', 'Adobe Photoshop', 'Conocimientos'),
('U21201411', 'Illustrator', 'Conocimientos'),
('U21201411', 'Diseño de interfaces (UI)', 'Conocimientos'),
('U21201411', 'Desarrollo web front-end', 'Conocimientos'),
('U21201411', 'Animación digital', 'Conocimientos');

-- DATOS TABLA DE HOBBIES
INSERT INTO hobbies (student_id, hobby_name) VALUES 
('U21201391', 'Jugar al fútbol'),
('U21201391', 'Tocar la guitarra'),
('U21201391', 'Leer novelas de ciencia ficción'),
('U21201392', 'Pintar al óleo'),
('U21201392', 'Practicar senderismo'),
('U21201392', 'Cocinar platos internacionales'),
('U21201393', 'Bailar salsa'),
('U21201393', 'Jugar al ajedrez'),
('U21201393', 'Ver películas de terror'),
('U21201394', 'Hacer yoga'),
('U21201394', 'Cantar en un coro'),
('U21201394', 'Coleccionar sellos'),
('U21201395', 'Hacer fotografía'),
('U21201395', 'Montar en bicicleta'),
('U21201395', 'Escuchar música clásica'),
('U21201396', 'Hacer manualidades'),
('U21201396', 'Correr maratones'),
('U21201396', 'Viajar y explorar nuevas culturas'),
('U21201397', 'Bailar hip-hop'),
('U21201397', 'Jugar videojuegos'),
('U21201397', 'Leer libros de poesía'),
('U21201398', 'Cocinar recetas veganas'),
('U21201398', 'Hacer surf'),
('U21201398', 'Tocar el piano'),
('U21201399', 'Pintar acuarelas'),
('U21201399', 'Hacer jardinería'),
('U21201399', 'Practicar escalada en roca'),
('U21201400', 'Bailar danza contemporánea'),
('U21201400', 'Tocar el violín'),
('U21201400', 'Ver documentales de historia'),
('U21201401', 'Hacer fotografía de paisajes'),
('U21201401', 'Jugar al baloncesto'),
('U21201401', 'Ver series de ciencia ficción'),
('U21201402', 'Dibujar caricaturas'),
('U21201402', 'Cocinar comida italiana'),
('U21201402', 'Escuchar música electrónica'),
('U21201403', 'Practicar artes marciales'),
('U21201403', 'Jugar al tenis de mesa'),
('U21201403', 'Leer libros de autoayuda'),
('U21201404', 'Bailar danza clásica'),
('U21201404', 'Tocar la batería'),
('U21201404', 'Ver documentales de naturaleza'),
('U21201405', 'Hacer ejercicios de cardio'),
('U21201405', 'Jugar al voleibol'),
('U21201405', 'Ver películas de comedia'),
('U21201406', 'Aprender idiomas'),
('U21201406', 'Hacer yoga'),
('U21201406', 'Navegar por internet'),
('U21201407', 'Hacer senderismo'),
('U21201407', 'Cocinar comida asiática'),
('U21201407', 'Escuchar música pop'),
('U21201408', 'Jugar videojuegos de estrategia'),
('U21201408', 'Bailar música electrónica'),
('U21201408', 'Leer cómics de superhéroes'),
('U21201409', 'Jugar al rugby'),
('U21201409', 'Cocinar postres'),
('U21201409', 'Ver películas de suspense'),
('U21201410', 'Hacer fotografía de retrato'),
('U21201410', 'Jugar al golf'),
('U21201410', 'Leer libros de historia'),
('U21201411', 'Tocar el saxofón'),
('U21201411', 'Bailar breakdance'),
('U21201411', 'Ver documentales de viajes'),
('U21201412', 'Hacer acrobacias en bicicleta'),
('U21201412', 'Jugar al billar'),
('U21201412', 'Leer libros de filosofía'),
('U21201413', 'Hacer manualidades con papel'),
('U21201413', 'Bailar salsa'),
('U21201413', 'Ver películas de acción'),
('U21201414', 'Cocinar comida mexicana'),
('U21201414', 'Tocar el piano'),
('U21201414', 'Escuchar música indie'),
('U21201415', 'Jugar al pádel'),
('U21201415', 'Hacer ejercicios de mindfulness'),
('U21201415', 'Ver series de drama'),
('U21201416', 'Hacer yoga'),
('U21201416', 'Jugar al fútbol sala'),
('U21201416', 'Leer libros de ciencia'),
('U21201417', 'Pintar al óleo'),
('U21201417', 'Cocinar platos vegetarianos'),
('U21201417', 'Ver películas de fantasía'),
('U21201418', 'Hacer ejercicios de pilates'),
('U21201418', 'Jugar al cricket'),
('U21201418', 'Escuchar música clásica'),
('U21201419', 'Bailar hip-hop'),
('U21201419', 'Hacer manualidades con arcilla'),
('U21201419', 'Ver documentales de arte'),
('U21201420', 'Hacer ejercicios de calistenia'),
('U21201420', 'Jugar al baloncesto'),
('U21201420', 'Leer libros de biografías'),
('U21201421', 'Cocinar repostería'),
('U21201421', 'Tocar la guitarra'),
('U21201421', 'Ver películas de comedia romántica'),
('U21201422', 'Practicar natación'),
('U21201422', 'Jugar al tenis'),
('U21201422', 'Escuchar música electrónica'),
('U21201423', 'Hacer ejercicios de crossfit'),
('U21201423', 'Jugar al hockey sobre hielo'),
('U21201423', 'Ver películas de ciencia ficción'),
('U21201424', 'Cocinar comida tailandesa'),
('U21201424', 'Tocar el violín'),
('U21201424', 'Escuchar música pop');
