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
    modality ENUM('Presencial', 'Virtual 24/7', 'Asincrónica'),
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
    number_of_students INT,
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
    SET NEW.role_id = (SELECT CONCAT('ROLE', IFNULL(MAX(CAST(SUBSTRING(role_id, 5) AS UNSIGNED)), 0) + 1) FROM roles);
END;
//
DELIMITER ;

-- TABLA DE ESTUDIANTES POR GRUPOS
CREATE TABLE students_groups (
    student_id VARCHAR(10),
    group_id CHAR(6),
    role_id CHAR(6),
    FOREIGN KEY (role_id) REFERENCES roles(role_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id),
    PRIMARY KEY (student_id, group_id)
);

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
('U21208430', 'Francesco Riva Reyes', 'U21208430@utp.edu.pe', 'Francesco1234UGR', '+51 941959936', '', '', 'Ingeniería de Software', 'Presencial', '2004-01-02', 7),
('U21220883', 'Sebastian Salvador Quenta Tunque', 'U21220883@utp.edu.pe', 'Salva3434UGR', '+51 916286018 ', '', '', 'Ingeniería de Software', 'Presencial', '2004-04-03', 7),
('U21210984', 'Morelia Paola Gonzales Valdivia', 'U21210984@utp.edu.pe', 'Morlia1234UGR', '+51 972799160', '', '', 'Ingeniería de Software', 'Virtual', '2004-02-16', 7),
('U21201391', 'Flavio Sebastian Villanueva Medina', 'U21201391@gmail.com', 'ContPrueba373', '+51 992851981', 'U21201391-photo.jpg', 'Soy un estudiante apasionado de Ingeniería de Software, me considero proactivo, adaptable a entornos laborales dinámicos y con una rápida capacidad de aprendizaje de nuevas tecnologías. Estoy constantemente explorando y actualizándome en innovaciones tecnológicas. Además de mi pasión por la programación, soy un amante de la música y tengo una gran melomanía, disfruto escuchando música en mis tiempos libres. También soy un apasionado de Marvel, los cómics y el coleccionismo. Me encanta sumergirme en los mundos de superhéroes y adquirir artículos de colección relacionados. Busco desafíos que impulsan mi crecimiento como programador y oportunidades para aplicar mis habilidades en un entorno colaborativo y desafiante, combinando mi pasión por la tecnología con mis intereses personales.', 'Ingeniería de Software', 'Presencial', '2004-01-28', 7),
('U21200272', 'Eduardo Davis Brito Escobar', 'U21200272@gmail.com', 'Eduar1234UGR', '+51 997839791', 'U21200272-photo.jpg', 'Soy un estudiante de Ingeniería de Sistemas e Informática, me considero bastante hábil en el ámbito de diseño, por lo que puedo ejercer un óptimo papel en este, además me encanta analizar hasta el más mínimo detalle los proyectos para que no pueda tener ningún error futuro.', 'Ingeniería de Sistemas e Informática', 'Presencial', '2003-09-15', 7),
('U21201392', 'Andrea Isabel Ramirez Lopez', 'U21201392@utp.edu.pe', 'ContPrueba374', '+51 997654321', 'U21201392-photo.jpg', 'Soy estudiante de Administración de Empresas, interesada en la gestión de recursos humanos y estrategias empresariales. Me gusta el trabajo en equipo y busco siempre mejorar mis habilidades en liderazgo y comunicación.', 'Administración de Empresas', 'Presencial', '2006-04-10', 2),
('U21201393', 'Carlos Enrique Gomez Torres', 'U21201393@utp.edu.pe', 'ContPrueba375', '+51 993456789', 'U21201393-photo.jpg', 'Estudiante de Ingeniería Civil, apasionado por el diseño estructural y la construcción sostenible. Disfruto trabajando en proyectos que involucran innovación en la ingeniería y busco contribuir al desarrollo de infraestructuras eficientes.', 'Ingeniería Civil', 'Virtual', '2007-09-25', 1),
('U21201394', 'Lucia Marisol Paredes Herrera', 'U21201394@utp.edu.pe', 'ContPrueba376', '+51 991234567', 'U21201394-photo.jpg', 'Futura comunicadora social, enfocada en el periodismo digital y la producción audiovisual. Me gusta contar historias y crear contenido que impacte positivamente en la sociedad.', 'Comunicación Social', 'Asincrónica', '2005-11-20', 3),
('U21201395', 'Miguel Angel Rios Castro', 'U21201395@utp.edu.pe', 'ContPrueba377', '+51 992345678', 'U21201395-photo.jpg', 'Soy estudiante de Marketing y Publicidad, interesado en las estrategias digitales y el comportamiento del consumidor. Me motiva crear campañas innovadoras que conecten con las audiencias.', 'Marketing y Publicidad', 'Presencial', '2006-01-30', 2),
('U21201396', 'Valeria Sofia Delgado Rojas', 'U21201396@utp.edu.pe', 'ContPrueba378', '+51 994567890', 'U21201396-photo.jpg', 'Estudio Derecho, con un interés particular en el derecho corporativo y la defensa de los derechos humanos. Busco aplicar mis Skills Técnicas en entornos que promuevan la justicia y la equidad.', 'Derecho', 'Virtual', '2007-07-15', 1),
('U21201397', 'Jorge Luis Fernandez Muñoz', 'U21201397@utp.edu.pe', 'ContPrueba379', '+51 995678901', 'U21201397-photo.jpg', 'Futuro ingeniero electrónico, apasionado por la robótica y los sistemas embebidos. Me gusta desarrollar proyectos que integren tecnología avanzada y solucionen problemas del mundo real.', 'Ingeniería Electrónica', 'Asincrónica', '2005-03-22', 3),
('U21201398', 'Ana Maria Gonzales Chavez', 'U21201398@utp.edu.pe', 'ContPrueba380', '+51 996789012', 'U21201398-photo.jpg', 'Estudiante de Psicología, interesada en la psicología clínica y el desarrollo personal. Mi objetivo es ayudar a las personas a superar sus desafíos y alcanzar su máximo potencial.', 'Psicología', 'Presencial', '2006-10-05', 2),
('U21201399', 'Pedro Alejandro Torres Vasquez', 'U21201399@utp.edu.pe', 'ContPrueba381', '+51 997890123', 'U21201399-photo.jpg', 'Futuro ingeniero mecánico, con una gran pasión por el diseño y la manufactura de maquinaria. Disfruto trabajar en proyectos que involucren innovación y eficiencia energética.', 'Ingeniería Mecánica', 'Virtual', '2007-05-18', 1),
('U21201400', 'Claudia Beatriz Ramirez Soto', 'U21201400@utp.edu.pe', 'ContPrueba382', '+51 998901234', 'U21201400-photo.jpg', 'Estudiante de Enfermería, comprometida con el cuidado y la atención de pacientes. Me motiva contribuir al bienestar de las personas y mejorar los sistemas de salud.', 'Enfermería', 'Asincrónica', '2005-12-30', 3),
('U21201401', 'Luis Fernando Castillo Rivas', 'U21201401@utp.edu.pe', 'ContPrueba383', '+51 999012345', 'U21201401-photo.jpg', 'Estudio Contabilidad, con un enfoque en la auditoría y la gestión financiera. Me apasiona el análisis de datos y la optimización de recursos económicos.', 'Contabilidad', 'Presencial', '2006-08-25', 2),
('U21201402', 'Maria Teresa Ortiz Peña', 'U21201402@utp.edu.pe', 'ContPrueba384', '+51 991112233', 'U21201402-photo.jpg', 'Soy estudiante de Arquitectura, interesada en el diseño sostenible y la planificación urbana. Mi objetivo es crear espacios que sean funcionales y estéticamente atractivos.', 'Arquitectura', 'Virtual', '2007-02-14', 1),
('U21201403', 'Jose Manuel Herrera Luna', 'U21201403@utp.edu.pe', 'ContPrueba385', '+51 992223344', 'U21201403-photo.jpg', 'Futuro ingeniero de sistemas, apasionado por la ciberseguridad y el desarrollo de software. Me gusta resolver problemas complejos y mejorar la eficiencia de los sistemas tecnológicos.', 'Ingeniería de Sistemas', 'Asincrónica', '2005-04-10', 3),
('U21201404', 'Camila Andrea Salazar Mendoza', 'U21201404@utp.edu.pe', 'ContPrueba386', '+51 993334455', 'U21201404-photo.jpg', 'Estudiante de Medicina, con un gran interés en la cirugía y la investigación médica. Me motiva aprender constantemente y contribuir al avance de la ciencia médica.', 'Medicina', 'Presencial', '2006-06-29', 2),
('U21201405', 'Daniel Alejandro Chavez Ruiz', 'U21201405@utp.edu.pe', 'ContPrueba387', '+51 994445566', 'U21201405-photo.jpg', 'Futuro economista, interesado en la macroeconomía y las políticas públicas. Me apasiona analizar datos económicos y buscar soluciones a problemas financieros.', 'Economía', 'Virtual', '2007-01-18', 1),
('U21201406', 'Laura Isabel Perez Vega', 'U21201406@utp.edu.pe', 'ContPrueba388', '+51 995556677', 'U21201406-photo.jpg', 'Soy estudiante de Biología, enfocada en la investigación genética y la conservación ambiental. Me encanta trabajar en proyectos que busquen preservar la biodiversidad.', 'Biología', 'Asincrónica', '2005-09-12', 3),
('U21201407', 'Rodrigo Emilio Vargas Castillo', 'U21201407@utp.edu.pe', 'ContPrueba389', '+51 996667788', 'U21201407-photo.jpg', 'Estudio Ingeniería Industrial, interesado en la optimización de procesos y la gestión de la calidad. Me motiva mejorar la eficiencia y productividad en las empresas.', 'Ingeniería Industrial', 'Presencial', '2006-03-03', 2),
('U21201408', 'Patricia Rosa Diaz Flores', 'U21201408@utp.edu.pe', 'ContPrueba390', '+51 997778899', 'U21201408-photo.jpg', 'Estudiante de Ciencias de la Comunicación, con un enfoque en la publicidad y las relaciones públicas. Me gusta crear estrategias comunicacionales efectivas y creativas.', 'Ciencias de la Comunicación', 'Virtual', '2007-11-08', 1),
('U21201409', 'Victor Hugo Lopez Paredes', 'U21201409@utp.edu.pe', 'ContPrueba391', '+51 998889900', 'U21201409-photo.jpg', 'Futuro químico, apasionado por la investigación en materiales y la química ambiental. Me motiva descubrir nuevas aplicaciones y soluciones sostenibles.', 'Química', 'Asincrónica', '2005-07-25', 3),
('U21201410', 'Elena Margarita Ruiz Santos', 'U21201410@utp.edu.pe', 'ContPrueba392', '+51 999990000', 'U21201410-photo.jpg', 'Soy estudiante de Sociología, interesada en el estudio de las dinámicas sociales y la justicia social. Mi objetivo es contribuir a una sociedad más equitativa y justa.', 'Sociología', 'Presencial', '2006-05-17', 2),
('U21201411', 'Juan Carlos Mendez Herrera', 'U21201411@utp.edu.pe', 'ContPrueba393', '+51 991111222', 'U21201411-photo.jpg', 'Estudio Ingeniería de Software, con un interés particular en el desarrollo de aplicaciones móviles y la inteligencia artificial. Me gusta estar al día con las últimas tendencias tecnológicas.', 'Ingeniería de Software', 'Virtual', '2007-10-22', 1),
('U21201412', 'Luciana Beatriz Rojas Chavez', 'U21201412@utp.edu.pe', 'ContPrueba394', '+51 992222333', 'U21201412-photo.jpg', 'Estudiante de Ingeniería Ambiental, comprometida con la sostenibilidad y la gestión de recursos naturales. Me apasiona trabajar en proyectos que busquen proteger el medio ambiente.', 'Ingeniería Ambiental', 'Asincrónica', '2005-08-19', 3),
('U21201413', 'Ricardo Antonio Vega Ruiz', 'U21201413@utp.edu.pe', 'ContPrueba395', '+51 993333444', 'U21201413-photo.jpg', 'Futuro ingeniero de telecomunicaciones, interesado en las redes de comunicación y la tecnología 5G. Me motiva estar a la vanguardia de las innovaciones tecnológicas.', 'Ingeniería de Telecomunicaciones', 'Presencial', '2006-12-02', 2),
('U21201414', 'Gabriela Sofia Navarro Ramirez', 'U21201414@utp.edu.pe', 'ContPrueba396', '+51 994444555', 'U21201414-photo.jpg', 'Soy estudiante de Educación, con un enfoque en la educación inicial y la pedagogía infantil. Me encanta trabajar con niños y contribuir a su desarrollo integral.', 'Educación Inicial', 'Virtual', '2007-06-27', 1),
('U21201415', 'David Alfonso Paredes Jimenez', 'U21201415@utp.edu.pe', 'ContPrueba397', '+51 995555666', 'U21201415-photo.jpg', 'Estudio Física, apasionado por la investigación en física teórica y la astrofísica. Me motiva entender los principios fundamentales del universo.', 'Física', 'Asincrónica', '2005-04-30', 3),
('U21201416', 'Alejandra Lucia Morales Flores', 'U21201416@utp.edu.pe', 'ContPrueba398', '+51 996666777', 'U21201416-photo.jpg', 'Estudiante de Literatura, interesada en la crítica literaria y la escritura creativa. Me apasiona analizar obras literarias y crear mis propias historias.', 'Literatura', 'Presencial', '2006-11-14', 2),
('U21201417', 'Cristian Andres Cruz Diaz', 'U21201417@utp.edu.pe', 'ContPrueba399', '+51 997777888', 'U21201417-photo.jpg', 'Futuro ingeniero eléctrico, con un gran interés en las energías renovables y la automatización industrial. Me gusta trabajar en proyectos que promuevan la sostenibilidad energética.', 'Ingeniería Eléctrica', 'Virtual', '2007-03-05', 1),
('U21201418', 'Sofia Carolina Ramirez Torres', 'U21201418@utp.edu.pe', 'ContPrueba400', '+51 998888999', 'U21201418-photo.jpg', 'Soy estudiante de Historia, enfocada en la historia contemporánea y los estudios culturales. Me motiva investigar y comprender los eventos que han moldeado el mundo actual.', 'Historia', 'Asincrónica', '2005-09-07', 3),
('U21201419', 'Julian Alejandro Herrera Castillo', 'U21201419@utp.edu.pe', 'ContPrueba401', '+51 999999111', 'U21201419-photo.jpg', 'Estudio Filosofía, interesado en la ética y la filosofía política. Me apasiona debatir y analizar cuestiones fundamentales sobre la existencia y la sociedad.', 'Filosofía', 'Presencial', '2006-02-23', 2),
('U21201420', 'Carla Fernanda Lopez Vega', 'U21201420@utp.edu.pe', 'ContPrueba402', '+51 991000111', 'U21201420-photo.jpg', 'Estudiante de Nutrición, comprometida con la promoción de estilos de vida saludables y la educación alimentaria. Me motiva ayudar a las personas a mejorar su bienestar a través de la nutrición.', 'Nutrición', 'Virtual', '2007-08-11', 1),
('U21201421', 'Pablo Miguel Torres Herrera', 'U21201421@utp.edu.pe', 'ContPrueba403', '+51 992111222', 'U21201421-photo.jpg', 'Futuro politólogo, interesado en las relaciones internacionales y la política comparada. Me motiva analizar y proponer soluciones a los desafíos globales.', 'Ciencias Políticas', 'Asincrónica', '2005-10-03', 3),
('U21201422', 'Daniela Isabel Perez Lopez', 'U21201422@utp.edu.pe', 'ContPrueba404', '+51 993222333', 'U21201422-photo.jpg', 'Soy estudiante de Artes Plásticas, interesada en la pintura y la escultura contemporánea. Me apasiona expresar mi creatividad y explorar nuevas técnicas artísticas.', 'Artes Plásticas', 'Presencial', '2006-01-27', 2),
('U21201423', 'Javier Alejandro Ruiz Flores', 'U21201423@utp.edu.pe', 'ContPrueba405', '+51 994333444', 'U21201423-photo.jpg', 'Estudiante de Ingeniería Geológica, con un enfoque en la exploración y explotación de recursos minerales. Me motiva trabajar en proyectos que contribuyan al desarrollo sostenible.', 'Ingeniería Geológica', 'Virtual', '2007-09-01', 1),
('U21201424', 'Lucia Maria Fernandez Herrera', 'U21201424@utp.edu.pe', 'ContPrueba406', '+51 995444555', 'U21201424-photo.jpg', 'Soy estudiante de Trabajo Social, comprometida con la ayuda comunitaria y la defensa de los derechos sociales. Me motiva trabajar en proyectos que promuevan la inclusión y la justicia social.', 'Trabajo Social', 'Asincrónica', '2005-05-21', 3);

-- DATOS TABLA DE PROFESORES
INSERT INTO professors (professor_id, name, email, password) VALUES 
('C15137', 'María Fernanda López Gonzales', 'C15137@utp.edu.pe', 'Profcotra400'),
('C15138', 'Roberto Miguel Torres Vargas', 'C15138@utp.edu.pe', 'Profcotra401'),
('C15139', 'Ana Patricia Ramos Díaz', 'C15139@utp.edu.pe', 'Profcotra402'),
('C15140', 'Luis Alberto Castillo Ruiz', 'C15140@utp.edu.pe', 'Profcotra403'),
('C15141', 'Elena Gabriela Morales Fuentes', 'C15141@utp.edu.pe', 'Profcotra404');

-- DATOS TABLA DE CURSOS
INSERT INTO courses (course_name, professor_id, modality) VALUES
('Herramientas para la Comunicación Efectiva', 'C15137', 'Presencial'),
('Programación Lógica y Funcional', 'C15138', 'Virtual 24/7'),
('Programación de Videojuegos con C++', 'C15139', 'Virtual 24/7'),
('Seguridad Informática', 'C15140', 'Virtual 24/7'),
('Programación de Sistemas de Información', 'C15141', 'Presencial'),
('Sistemas Distribuidos', 'C15141', 'Presencial'),
('Redes y Comunicación de Datos I', 'C15140', 'Presencial'),
('Redes y Comunicación de Datos II', 'C15139', 'Virtual 24/7'),
('Arquitectura de Computadoras', 'C15138', 'Presencial'),
('Química', 'C15137', 'Presencial'),
('Quimica Inorganica', 'C15137', 'Virtual 24/7'),
('Problemas y Desafios del Perú Actual', 'C15138', 'Presencial'),
('Logica y Probabilidad', 'C15139', 'Presencial'),
('Matematica para los Negocios', 'C15140', 'Virtual 24/7');

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
('U21201418', 1001),
('U21201419', 1001),
('U21201420', 1001),
('U21201421', 1001),

('U21201422', 1002),
('U21201423', 1002),
('U21201424', 1002),
('U21208430', 1002),
('U21220883', 1002),
('U21210984', 1002),
('U21201391', 1002),
('U21201392', 1002),
('U21201393', 1002),
('U21201394', 1002),
('U21201395', 1002),
('U21201396', 1002),
('U21201397', 1002),
('U21201398', 1002),
('U21201399', 1002),
('U21201400', 1002),
('U21201401', 1002),
('U21201402', 1002),
('U21201403', 1002),
('U21201404', 1002),
('U21201405', 1002),
('U21201406', 1002),
('U21201407', 1002),
('U21201408', 1002),
('U21201409', 1002),
('U21201410', 1002),
('U21201411', 1002),
('U21201412', 1002),
('U21201413', 1002),
('U21201414', 1002),
('U21201415', 1002),

('U21201422', 1003),
('U21201423', 1003),
('U21201424', 1003),
('U21208430', 1003),
('U21220883', 1003),
('U21210984', 1003),
('U21201391', 1003),
('U21201392', 1003),
('U21201393', 1003),
('U21201394', 1003),
('U21201395', 1003),
('U21201396', 1003),
('U21201397', 1003),
('U21201398', 1003),
('U21201399', 1003),
('U21201400', 1003),
('U21201401', 1003),
('U21201402', 1003),
('U21201403', 1003),
('U21201404', 1003),
('U21201405', 1003),
('U21201406', 1003),
('U21201407', 1003),
('U21201408', 1003),
('U21201409', 1003),
('U21201410', 1003),
('U21201411', 1003),
('U21201412', 1003),
('U21201413', 1003),
('U21201414', 1003),
('U21201415', 1003),

('U21201391', 1004),
('U21201392', 1004),
('U21201393', 1004),
('U21201394', 1004),
('U21201395', 1004),
('U21201396', 1004),
('U21201397', 1004),
('U21201398', 1004),
('U21201399', 1004),
('U21201400', 1004),
('U21201401', 1004),
('U21201402', 1004),
('U21201403', 1004),
('U21201404', 1004),
('U21201405', 1004),
('U21201406', 1004),
('U21201407', 1004),
('U21201408', 1004),
('U21201409', 1004),
('U21201410', 1004),
('U21201411', 1004),
('U21201412', 1004),
('U21201413', 1004),
('U21201414', 1004),
('U21201415', 1004),
('U21201416', 1004),
('U21201417', 1004),
('U21201418', 1004),
('U21201419', 1004),
('U21201420', 1004),
('U21201421', 1004);

-- DATOS TABLA HABILIDADES
INSERT INTO skills (student_id, skill_name, skill_topic) VALUES 
('U21201391', 'Trabajo en equipo', 'Skills Blandas'),
('U21201391', 'Comunicación efectiva', 'Skills Blandas'),
('U21201391', 'Adaptabilidad', 'Skills Blandas'),
('U21201391', 'Pensamiento crítico', 'Skills Blandas'),
('U21201391', 'Resolución de problemas', 'Skills Blandas'),
('U21201391', 'Gestión del tiempo', 'Skills Blandas'),
('U21201391', 'Programación en C++', 'Skills Técnicas'),
('U21201391', 'Desarrollo de software ágil', 'Skills Técnicas'),
('U21201391', 'Bases de datos SQL', 'Skills Técnicas'),
('U21201391', 'Ingeniería de requisitos', 'Skills Técnicas'),
('U21201391', 'Pruebas unitarias', 'Skills Técnicas'),
('U21201391', 'Control de versiones con Git', 'Skills Técnicas'),

('U21201392', 'Liderazgo', 'Skills Blandas'),
('U21201392', 'Trabajo en equipo', 'Skills Blandas'),
('U21201392', 'Comunicación efectiva', 'Skills Blandas'),
('U21201392', 'Resolución de conflictos', 'Skills Blandas'),
('U21201392', 'Negociación', 'Skills Blandas'),
('U21201392', 'Gestión del tiempo', 'Skills Blandas'),
('U21201392', 'Gestión de recursos humanos', 'Skills Técnicas'),
('U21201392', 'Estrategias de marketing', 'Skills Técnicas'),
('U21201392', 'Análisis financiero', 'Skills Técnicas'),
('U21201392', 'Planificación estratégica', 'Skills Técnicas'),
('U21201392', 'Manejo de Excel avanzado', 'Skills Técnicas'),
('U21201392', 'Desarrollo organizacional', 'Skills Técnicas'),

('U21201393', 'Comunicación efectiva', 'Skills Blandas'),
('U21201393', 'Trabajo en equipo', 'Skills Blandas'),
('U21201393', 'Liderazgo', 'Skills Blandas'),
('U21201393', 'Adaptabilidad', 'Skills Blandas'),
('U21201393', 'Resolución de problemas', 'Skills Blandas'),
('U21201393', 'Gestión del tiempo', 'Skills Blandas'),
('U21201393', 'Diseño estructural', 'Skills Técnicas'),
('U21201393', 'AutoCAD', 'Skills Técnicas'),
('U21201393', 'Cálculo de estructuras', 'Skills Técnicas'),
('U21201393', 'Gestión de proyectos de construcción', 'Skills Técnicas'),
('U21201393', 'Ingeniería de suelos', 'Skills Técnicas'),
('U21201393', 'Modelado BIM', 'Skills Técnicas'),

('U21201394', 'Creatividad', 'Skills Blandas'),
('U21201394', 'Comunicación efectiva', 'Skills Blandas'),
('U21201394', 'Trabajo en equipo', 'Skills Blandas'),
('U21201394', 'Gestión del tiempo', 'Skills Blandas'),
('U21201394', 'Resolución de problemas', 'Skills Blandas'),
('U21201394', 'Adaptabilidad', 'Skills Blandas'),
('U21201394', 'Redacción periodística', 'Skills Técnicas'),
('U21201394', 'Producción audiovisual', 'Skills Técnicas'),
('U21201394', 'Comunicación digital', 'Skills Técnicas'),
('U21201394', 'Fotografía profesional', 'Skills Técnicas'),
('U21201394', 'Edición de video', 'Skills Técnicas'),
('U21201394', 'Gestión de redes sociales', 'Skills Técnicas'),

('U21201395', 'Creatividad', 'Skills Blandas'),
('U21201395', 'Comunicación efectiva', 'Skills Blandas'),
('U21201395', 'Trabajo en equipo', 'Skills Blandas'),
('U21201395', 'Negociación', 'Skills Blandas'),
('U21201395', 'Resolución de problemas', 'Skills Blandas'),
('U21201395', 'Gestión del tiempo', 'Skills Blandas'),
('U21201395', 'Estrategias de marketing digital', 'Skills Técnicas'),
('U21201395', 'Análisis de mercado', 'Skills Técnicas'),
('U21201395', 'Publicidad creativa', 'Skills Técnicas'),
('U21201395', 'Gestión de campañas publicitarias', 'Skills Técnicas'),
('U21201395', 'SEO y SEM', 'Skills Técnicas'),
('U21201395', 'Email marketing', 'Skills Técnicas'),

('U21201396', 'Comunicación efectiva', 'Skills Blandas'),
('U21201396', 'Liderazgo', 'Skills Blandas'),
('U21201396', 'Trabajo en equipo', 'Skills Blandas'),
('U21201396', 'Resolución de conflictos', 'Skills Blandas'),
('U21201396', 'Negociación', 'Skills Blandas'),
('U21201396', 'Gestión del tiempo', 'Skills Blandas'),
('U21201396', 'Derecho corporativo', 'Skills Técnicas'),
('U21201396', 'Legislación laboral', 'Skills Técnicas'),
('U21201396', 'Derecho civil y procesal civil', 'Skills Técnicas'),
('U21201396', 'Redacción de contratos', 'Skills Técnicas'),
('U21201396', 'Derecho penal', 'Skills Técnicas'),
('U21201396', 'Litigación oral', 'Skills Técnicas'),

('U21201397', 'Creatividad', 'Skills Blandas'),
('U21201397', 'Resolución de problemas', 'Skills Blandas'),
('U21201397', 'Trabajo en equipo', 'Skills Blandas'),
('U21201397', 'Comunicación efectiva', 'Skills Blandas'),
('U21201397', 'Gestión del tiempo', 'Skills Blandas'),
('U21201397', 'Adaptabilidad', 'Skills Blandas'),
('U21201397', 'Robótica', 'Skills Técnicas'),
('U21201397', 'Sistemas embebidos', 'Skills Técnicas'),
('U21201397', 'Programación en VHDL', 'Skills Técnicas'),
('U21201397', 'Diseño de circuitos electrónicos', 'Skills Técnicas'),
('U21201397', 'Microcontroladores', 'Skills Técnicas'),
('U21201397', 'Sensores y actuadores', 'Skills Técnicas'),

('U21201398', 'Empatía', 'Skills Blandas'),
('U21201398', 'Comunicación efectiva', 'Skills Blandas'),
('U21201398', 'Trabajo en equipo', 'Skills Blandas'),
('U21201398', 'Resolución de problemas', 'Skills Blandas'),
('U21201398', 'Adaptabilidad', 'Skills Blandas'),
('U21201398', 'Gestión del tiempo', 'Skills Blandas'),
('U21201398', 'Psicología clínica', 'Skills Técnicas'),
('U21201398', 'Terapia cognitivo-conductual', 'Skills Técnicas'),
('U21201398', 'Evaluación psicológica', 'Skills Técnicas'),
('U21201398', 'Intervención en crisis', 'Skills Técnicas'),
('U21201398', 'Psicología infantil', 'Skills Técnicas'),
('U21201398', 'Psicopatología', 'Skills Técnicas'),

('U21201399', 'Resolución de problemas', 'Skills Blandas'),
('U21201399', 'Trabajo en equipo', 'Skills Blandas'),
('U21201399', 'Comunicación efectiva', 'Skills Blandas'),
('U21201399', 'Gestión del tiempo', 'Skills Blandas'),
('U21201399', 'Adaptabilidad', 'Skills Blandas'),
('U21201399', 'Pensamiento crítico', 'Skills Blandas'),
('U21201399', 'Mecánica de fluidos', 'Skills Técnicas'),
('U21201399', 'Diseño mecánico', 'Skills Técnicas'),
('U21201399', 'Manufactura asistida por computadora', 'Skills Técnicas'),
('U21201399', 'Mantenimiento predictivo', 'Skills Técnicas'),
('U21201399', 'Termodinámica', 'Skills Técnicas'),
('U21201399', 'Análisis de fallos', 'Skills Técnicas'),

('U21201400', 'Empatía', 'Skills Blandas'),
('U21201400', 'Comunicación efectiva', 'Skills Blandas'),
('U21201400', 'Trabajo en equipo', 'Skills Blandas'),
('U21201400', 'Gestión del tiempo', 'Skills Blandas'),
('U21201400', 'Resolución de problemas', 'Skills Blandas'),
('U21201400', 'Adaptabilidad', 'Skills Blandas'),
('U21201400', 'Cuidados de enfermería', 'Skills Técnicas'),
('U21201400', 'Técnicas de primeros auxilios', 'Skills Técnicas'),
('U21201400', 'Farmacología', 'Skills Técnicas'),
('U21201400', 'Enfermería quirúrgica', 'Skills Técnicas'),
('U21201400', 'Atención primaria de salud', 'Skills Técnicas'),
('U21201400', 'Gestión de servicios de salud', 'Skills Técnicas'),

('U21201401', 'Pensamiento crítico', 'Skills Blandas'),
('U21201401', 'Trabajo en equipo', 'Skills Blandas'),
('U21201401', 'Comunicación efectiva', 'Skills Blandas'),
('U21201401', 'Resolución de problemas', 'Skills Blandas'),
('U21201401', 'Gestión del tiempo', 'Skills Blandas'),
('U21201401', 'Adaptabilidad', 'Skills Blandas'),
('U21201401', 'Contabilidad financiera', 'Skills Técnicas'),
('U21201401', 'Auditoría interna', 'Skills Técnicas'),
('U21201401', 'Normas Internacionales de Información Financiera (NIIF)', 'Skills Técnicas'),
('U21201401', 'Impuestos y fiscalidad', 'Skills Técnicas'),
('U21201401', 'Control de gestión', 'Skills Técnicas'),
('U21201401', 'Contabilidad de costos', 'Skills Técnicas'),

('U21201402', 'Creatividad', 'Skills Blandas'),
('U21201402', 'Comunicación efectiva', 'Skills Blandas'),
('U21201402', 'Trabajo en equipo', 'Skills Blandas'),
('U21201402', 'Gestión del tiempo', 'Skills Blandas'),
('U21201402', 'Adaptabilidad', 'Skills Blandas'),
('U21201402', 'Resolución de problemas', 'Skills Blandas'),
('U21201402', 'Diseño arquitectónico', 'Skills Técnicas'),
('U21201402', 'Autodesk Revit', 'Skills Técnicas'),
('U21201402', 'Urbanismo', 'Skills Técnicas'),
('U21201402', 'Eficiencia energética en edificios', 'Skills Técnicas'),
('U21201402', 'Historia de la arquitectura', 'Skills Técnicas'),
('U21201402', 'Modelado 3D', 'Skills Técnicas'),

('U21201403', 'Pensamiento crítico', 'Skills Blandas'),
('U21201403', 'Trabajo en equipo', 'Skills Blandas'),
('U21201403', 'Comunicación efectiva', 'Skills Blandas'),
('U21201403', 'Resolución de problemas', 'Skills Blandas'),
('U21201403', 'Gestión del tiempo', 'Skills Blandas'),
('U21201403', 'Adaptabilidad', 'Skills Blandas'),
('U21201403', 'Ciberseguridad', 'Skills Técnicas'),
('U21201403', 'Desarrollo de software', 'Skills Técnicas'),
('U21201403', 'Redes de computadoras', 'Skills Técnicas'),
('U21201403', 'Administración de bases de datos', 'Skills Técnicas'),
('U21201403', 'Inteligencia artificial', 'Skills Técnicas'),
('U21201403', 'Ingeniería de software', 'Skills Técnicas'),

('U21201404', 'Empatía', 'Skills Blandas'),
('U21201404', 'Comunicación efectiva', 'Skills Blandas'),
('U21201404', 'Trabajo en equipo', 'Skills Blandas'),
('U21201404', 'Resolución de problemas', 'Skills Blandas'),
('U21201404', 'Adaptabilidad', 'Skills Blandas'),
('U21201404', 'Gestión del tiempo', 'Skills Blandas'),
('U21201404', 'Anatomía humana', 'Skills Técnicas'),
('U21201404', 'Fisiología médica', 'Skills Técnicas'),
('U21201404', 'Cirugía general', 'Skills Técnicas'),
('U21201404', 'Investigación clínica', 'Skills Técnicas'),
('U21201404', 'Farmacología médica', 'Skills Técnicas'),
('U21201404', 'Diagnóstico por imágenes', 'Skills Técnicas'),

('U21201405', 'Pensamiento crítico', 'Skills Blandas'),
('U21201405', 'Trabajo en equipo', 'Skills Blandas'),
('U21201405', 'Comunicación efectiva', 'Skills Blandas'),
('U21201405', 'Resolución de problemas', 'Skills Blandas'),
('U21201405', 'Gestión del tiempo', 'Skills Blandas'),
('U21201405', 'Adaptabilidad', 'Skills Blandas'),
('U21201405', 'Análisis macroeconómico', 'Skills Técnicas'),
('U21201405', 'Modelos econométricos', 'Skills Técnicas'),
('U21201405', 'Políticas públicas', 'Skills Técnicas'),
('U21201405', 'Microeconomía avanzada', 'Skills Técnicas'),
('U21201405', 'Economía internacional', 'Skills Técnicas'),
('U21201405', 'Economía del desarrollo', 'Skills Técnicas'),

('U21201406', 'Pensamiento crítico', 'Skills Blandas'),
('U21201406', 'Trabajo en equipo', 'Skills Blandas'),
('U21201406', 'Comunicación efectiva', 'Skills Blandas'),
('U21201406', 'Resolución de problemas', 'Skills Blandas'),
('U21201406', 'Gestión del tiempo', 'Skills Blandas'),
('U21201406', 'Adaptabilidad', 'Skills Blandas'),
('U21201406', 'Genética molecular', 'Skills Técnicas'),
('U21201406', 'Biotecnología', 'Skills Técnicas'),
('U21201406', 'Ecología y conservación', 'Skills Técnicas'),
('U21201406', 'Microbiología', 'Skills Técnicas'),
('U21201406', 'Biología celular', 'Skills Técnicas'),
('U21201406', 'Bioquímica', 'Skills Técnicas'),

('U21201407', 'Resolución de problemas', 'Skills Blandas'),
('U21201407', 'Trabajo en equipo', 'Skills Blandas'),
('U21201407', 'Comunicación efectiva', 'Skills Blandas'),
('U21201407', 'Gestión del tiempo', 'Skills Blandas'),
('U21201407', 'Adaptabilidad', 'Skills Blandas'),
('U21201407', 'Pensamiento crítico', 'Skills Blandas'),
('U21201407', 'Optimización de procesos', 'Skills Técnicas'),
('U21201407', 'Gestión de la calidad', 'Skills Técnicas'),
('U21201407', 'Manufactura Lean', 'Skills Técnicas'),
('U21201407', 'Logística industrial', 'Skills Técnicas'),
('U21201407', 'Seguridad industrial', 'Skills Técnicas'),
('U21201407', 'Simulación de procesos', 'Skills Técnicas'),

('U21201408', 'Creatividad', 'Skills Blandas'),
('U21201408', 'Comunicación efectiva', 'Skills Blandas'),
('U21201408', 'Trabajo en equipo', 'Skills Blandas'),
('U21201408', 'Gestión del tiempo', 'Skills Blandas'),
('U21201408', 'Resolución de problemas', 'Skills Blandas'),
('U21201408', 'Adaptabilidad', 'Skills Blandas'),
('U21201408', 'Publicidad y relaciones públicas', 'Skills Técnicas'),
('U21201408', 'Producción multimedia', 'Skills Técnicas'),
('U21201408', 'Estrategias de comunicación', 'Skills Técnicas'),
('U21201408', 'Comunicación organizacional', 'Skills Técnicas'),
('U21201408', 'Marketing digital', 'Skills Técnicas'),
('U21201408', 'Gestión de la comunicación de crisis', 'Skills Técnicas'),

('U21201409', 'Pensamiento crítico', 'Skills Blandas'),
('U21201409', 'Trabajo en equipo', 'Skills Blandas'),
('U21201409', 'Comunicación efectiva', 'Skills Blandas'),
('U21201409', 'Resolución de problemas', 'Skills Blandas'),
('U21201409', 'Gestión del tiempo', 'Skills Blandas'),
('U21201409', 'Adaptabilidad', 'Skills Blandas'),
('U21201409', 'Química analítica', 'Skills Técnicas'),
('U21201409', 'Química orgánica', 'Skills Técnicas'),
('U21201409', 'Síntesis de materiales', 'Skills Técnicas'),
('U21201409', 'Química ambiental', 'Skills Técnicas'),
('U21201409', 'Análisis instrumental', 'Skills Técnicas'),
('U21201409', 'Fisicoquímica', 'Skills Técnicas'),

('U21201410', 'Pensamiento crítico', 'Skills Blandas'),
('U21201410', 'Trabajo en equipo', 'Skills Blandas'),
('U21201410', 'Comunicación efectiva', 'Skills Blandas'),
('U21201410', 'Resolución de problemas', 'Skills Blandas'),
('U21201410', 'Gestión del tiempo', 'Skills Blandas'),
('U21201410', 'Adaptabilidad', 'Skills Blandas'),
('U21201410', 'Programación en Java', 'Skills Técnicas'),
('U21201410', 'Desarrollo web con HTML/CSS', 'Skills Técnicas'),
('U21201410', 'Bases de datos MySQL', 'Skills Técnicas'),
('U21201410', 'Ingeniería de software', 'Skills Técnicas'),
('U21201410', 'Desarrollo de aplicaciones móviles', 'Skills Técnicas'),
('U21201410', 'Control de versiones con Git', 'Skills Técnicas'),

('U21201411', 'Resolución de problemas', 'Skills Blandas'),
('U21201411', 'Trabajo en equipo', 'Skills Blandas'),
('U21201411', 'Comunicación efectiva', 'Skills Blandas'),
('U21201411', 'Gestión del tiempo', 'Skills Blandas'),
('U21201411', 'Adaptabilidad', 'Skills Blandas'),
('U21201411', 'Pensamiento crítico', 'Skills Blandas'),
('U21201411', 'Diseño gráfico', 'Skills Técnicas'),
('U21201411', 'Adobe Photoshop', 'Skills Técnicas'),
('U21201411', 'Illustrator', 'Skills Técnicas'),
('U21201411', 'Diseño de interfaces (UI)', 'Skills Técnicas'),
('U21201411', 'Desarrollo web front-end', 'Skills Técnicas'),
('U21201411', 'Animación digital', 'Skills Técnicas');

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

-- DATOS TABLA DE ROLES
INSERT INTO roles (role_name, description) VALUES 
('Líder', 'El líder de un grupo de estudiantes es el responsable de la organización y el control de los recursos de la asignatura. Está encargado de asegurar la seguridad y la eficiencia de los recursos, y de coordinar las actividades de los estudiantes. Además, es responsable de garantizar la calidad y la integridad de los materiales y recursos utilizados en la asignatura.'),
('Motivador', 'El motivador es el responsable de motivar y inspirar a los estudiantes a participar en la asignatura. Está encargado de crear un ambiente de aprendizaje positivo y de proporcionar los recursos y materiales necesarios para que los estudiantes puedan desarrollar sus habilidades y conocimientos en el área de estudio. Además, es responsable de garantizar que los estudiantes estén motivados a continuar aprendiendo y a desarrollar sus habilidades.'),
('Creativo', 'El creativo es el responsable de generar ideas y soluciones innovadoras para resolver los problemas y mejorar la calidad de la asignatura. Está encargado de proporcionar los estudiantes con recursos y materiales para desarrollar sus ideas y soluciones, y de asegurar que los resultados sean efectivos y satisfactorios. Además, es responsable de garantizar que los estudiantes estén capaces de pensar de manera creativa y de desarrollar sus habilidades en el área de estudio.'),
('Mediador', 'El mediador es el responsable de coordinar y supervisar las actividades de los estudiantes en la asignatura. Está encargado de asegurar que los estudiantes estén participando de actividades de manera efectiva y de garantizar que los recursos y materiales estén disponibles para que los estudiantes puedan desarrollar sus habilidades y conocimientos en el área de estudio. Además, es responsable de garantizar que los estudiantes estén satisfechos con la asignatura y que estén dispuestos a continuar aprendiendo y desarrollando sus habilidades.'),
('Investigador', 'El investigador es el responsable de investigar y desarrollar nuevas tecnologías y soluciones en el área de estudio. Está encargado de proporcionar los estudiantes con recursos y materiales para desarrollar sus investigaciones y de asegurar que los resultados sean efectivos y satisfactorios. Además, es responsable de garantizar que los estudiantes estén capaces de pensar de manera creativa y de desarrollar sus habilidades en el área de estudio.');

-- DATOS TABLA DE GRUPOS
INSERT INTO groups (course_id, group_name, number_of_students) VALUES
(1001, 'Grupo 1', 5),
(1001, 'Grupo 2', 5),
(1001, 'Grupo 3', 5),
(1001, 'Grupo 4', 5), 
(1001, 'Grupo 5', 5),
(1001, 'Grupo 6', 6),

(1002, 'Grupo 1', 5),
(1002, 'Grupo 2', 5),
(1002, 'Grupo 3', 5),
(1002, 'Grupo 4', 5), 
(1002, 'Grupo 5', 5),
(1002, 'Grupo 6', 6),

(1003, 'Grupo 1', 5),
(1003, 'Grupo 2', 5),
(1003, 'Grupo 3', 5),
(1003, 'Grupo 4', 5), 
(1003, 'Grupo 5', 5),
(1003, 'Grupo 6', 6);

-- DATOS TABLA DE ESTUDIANTES-GRUPOS
INSERT INTO students_groups (student_id, group_id, role_id) VALUES 
('U21201391', 'GR1000', 'ROLE1'),
('U21201392', 'GR1000', 'ROLE2'),
('U21201393', 'GR1000', 'ROLE3'),
('U21201394', 'GR1000', 'ROLE4'),
('U21201395', 'GR1000', 'ROLE5'),

('U21201396', 'GR1001', 'ROLE1'),
('U21201397', 'GR1001', 'ROLE2'),
('U21201398', 'GR1001', 'ROLE3'),
('U21201399', 'GR1001', 'ROLE4'),
('U21201400', 'GR1001', 'ROLE5'),

('U21201401', 'GR1002', 'ROLE1'),
('U21201402', 'GR1002', 'ROLE2'),
('U21201403', 'GR1002', 'ROLE3'),
('U21201404', 'GR1002', 'ROLE4'),
('U21201405', 'GR1002', 'ROLE5'),

('U21201406', 'GR1003', 'ROLE1'),
('U21201407', 'GR1003', 'ROLE2'),
('U21201408', 'GR1003', 'ROLE3'),
('U21201409', 'GR1003', 'ROLE4'),
('U21201410', 'GR1003', 'ROLE5'),

('U21201411', 'GR1004', 'ROLE1'),
('U21201412', 'GR1004', 'ROLE2'),
('U21201413', 'GR1004', 'ROLE3'),
('U21201414', 'GR1004', 'ROLE4'),
('U21201415', 'GR1004', 'ROLE5'),

('U21201416', 'GR1005', 'ROLE1'),
('U21201417', 'GR1005', 'ROLE2'),
('U21201418', 'GR1005', 'ROLE3'),
('U21201419', 'GR1005', 'ROLE4'),
('U21201420', 'GR1005', 'ROLE5'),
('U21201421', 'GR1005', 'ROLE5'),

('U21201422', 'GR1006', 'ROLE1'),
('U21201423', 'GR1006', 'ROLE2'),
('U21201424', 'GR1006', 'ROLE3'),
('U21208430', 'GR1006', 'ROLE4'),
('U21220883', 'GR1006', 'ROLE5'),

('U21210984', 'GR1007', 'ROLE1'),
('U21201391', 'GR1007', 'ROLE2'),
('U21201392', 'GR1007', 'ROLE3'),
('U21201393', 'GR1007', 'ROLE4'),
('U21201394', 'GR1007', 'ROLE5'),

('U21201395', 'GR1008', 'ROLE1'),
('U21201396', 'GR1008', 'ROLE2'),
('U21201397', 'GR1008', 'ROLE3'),
('U21201398', 'GR1008', 'ROLE4'),
('U21201399', 'GR1008', 'ROLE5'),

('U21201400', 'GR1009', 'ROLE1'),
('U21201401', 'GR1009', 'ROLE2'),
('U21201402', 'GR1009', 'ROLE3'),
('U21201403', 'GR1009', 'ROLE4'),
('U21201404', 'GR1009', 'ROLE5'),

('U21201405', 'GR1010', 'ROLE1'),
('U21201406', 'GR1010', 'ROLE2'),
('U21201407', 'GR1010', 'ROLE3'),
('U21201408', 'GR1010', 'ROLE4'),
('U21201409', 'GR1010', 'ROLE5'),

('U21201410', 'GR1011', 'ROLE1'),
('U21201411', 'GR1011', 'ROLE2'),
('U21201412', 'GR1011', 'ROLE3'),
('U21201413', 'GR1011', 'ROLE4'),
('U21201414', 'GR1011', 'ROLE5'),
('U21201415', 'GR1011', 'ROLE5'),
('U21201416', 'GR1011', 'ROLE5'),

('U21201422', 'GR1012', 'ROLE1'),
('U21201423', 'GR1012', 'ROLE2'),
('U21201424', 'GR1012', 'ROLE3'),
('U21208430', 'GR1012', 'ROLE4'),
('U21220883', 'GR1012', 'ROLE5'),

('U21201392', 'GR1013', 'ROLE1'),
('U21201393', 'GR1013', 'ROLE3'),
('U21201394', 'GR1013', 'ROLE4'),

('U21201396', 'GR1014', 'ROLE1'),

('U21201401', 'GR1015', 'ROLE1'),
('U21201402', 'GR1015', 'ROLE2'),

('U21201406', 'GR1016', 'ROLE2'),
('U21201407', 'GR1016', 'ROLE3'),
('U21201408', 'GR1016', 'ROLE4'),

('U21201411', 'GR1017', 'ROLE1'),
('U21201412', 'GR1017', 'ROLE2'),
('U21201413', 'GR1017', 'ROLE3'),
('U21201414', 'GR1017', 'ROLE4');

-- funcionales de la aplicacion
-- 1. Login usuario
DELIMITER $$
CREATE FUNCTION validarLogin (
    student_id_v VARCHAR(10),
    password_v VARCHAR(255)
) RETURNS BOOLEAN
BEGIN
    DECLARE existe BOOLEAN;
    SELECT EXISTS(SELECT * FROM students WHERE student_id_v = student_id AND password_v = password) INTO existe;
    RETURN existe;
END$$
DELIMITER ;

-- 2. Obtener Datos de Estudiante
DELIMITER $$
CREATE PROCEDURE ObtenerEstudiantePorId (
    IN student_id_v VARCHAR(10)
)
BEGIN
    SELECT * FROM students WHERE student_id = student_id_v;
END$$
DELIMITER ;

-- 3. Procedure para obtener cursos de un estudiante por su id
DELIMITER $$
CREATE PROCEDURE ObtenerCursosEstudiantePorId (
    IN student_id_c VARCHAR(10)
)
BEGIN
    SELECT c.course_id, c.course_name, c.modality, p.name from courses c 
    INNER JOIN student_courses sc ON c.course_id = sc.course_id 
    INNER JOIN professors p ON c.professor_id = p.professor_id 
    WHERE sc.student_id = student_id_c
    ORDER by c.course_name ;
END$$
DELIMITER ;

-- 4. Obtener Skills de un estudiante
DELIMITER $$
CREATE PROCEDURE ObtenerSkillsPorEstudiante (
    IN student_id_v VARCHAR(10)
)
BEGIN
    SELECT skill_id, skill_name, skill_topic FROM skills WHERE student_id = student_id_v;
END$$
DELIMITER ;

-- 5. Obtener Hobbies de un estudiante
DELIMITER $$
CREATE PROCEDURE ObtenerHobbiesPorEstudiante (
    IN student_id_v VARCHAR(10)
)
BEGIN
    SELECT hobby_id, hobby_name FROM hobbies WHERE student_id = student_id_v;
END$$
DELIMITER ;


-- 6. Procedure para obtener estudiantes de un curso
DELIMITER $$

CREATE PROCEDURE ObtenerEstudiantesPorCursoId (
    IN course_id_s INT(11)
)
BEGIN
    SELECT * 
    FROM students s
    INNER JOIN student_courses sc ON s.student_id = sc.student_id 
    WHERE sc.course_id = course_id_s;
END$$

DELIMITER ;

-- 7. Procedure para obtener datos de un curso
DELIMITER $$

CREATE PROCEDURE ObtenerCursoPorId (
    IN course_id_s INT(11)
)
BEGIN
    SELECT course_name, professor_id, modality FROM courses WHERE course_id = course_id_s;
END$$

DELIMITER ;

DELIMITER $$

-- 8. Procedure para obtener los grupos de un curso
CREATE PROCEDURE ObtenerGruposPorCursoId (
    IN course_id_s INT(11)
)
BEGIN
    SELECT g.group_id, g.course_id, g.group_name, g.number_of_students
    FROM groups g
    WHERE g.course_id = course_id_s;
END$$

-- 9. Procedure para obtener los alumnos de un grupo
CREATE PROCEDURE ObtenerAlumnosPorGrupoId (
    IN group_id_s CHAR(6)
)
BEGIN
    SELECT s.student_id, s.name, s.career, s.birth_date, s.academic_cycle, s.profile_picture 
    FROM students s
    INNER JOIN students_groups sg ON s.student_id = sg.student_id 
    WHERE sg.group_id = group_id_s;
END$$

-- 10. Procedure para agregar un alumno a un grupo
CREATE PROCEDURE AgregarAlumnoEnGrupo (
    IN group_id_s CHAR(6),
    IN student_id_s VARCHAR(10)
)   
BEGIN
    INSERT INTO students_groups (group_id, student_id) VALUES (group_id_s, student_id_s);
END$$

-- 11. Procedure para eliminar un alumno de un grupo
CREATE PROCEDURE EliminarAlumnoDelGrupo (
    IN group_id_s CHAR(6),
    IN student_id_s VARCHAR(10)
)   
BEGIN
    DELETE FROM students_groups WHERE group_id = group_id_s AND student_id = student_id_s;
END$$

-- 12. Procedure para editar el rol de un alumno de un grupo
CREATE PROCEDURE EditarRolAlumnoDelGrupo (
    IN group_id_s CHAR(6),
    IN student_id_s VARCHAR(10),
    IN role_id_s CHAR(6)
)   
BEGIN
    UPDATE students_groups SET role_id = role_id_s WHERE group_id = group_id_s AND student_id = student_id_s;
END$$

-- 13. Procedure para obtener el rol de un alumno de un grupo
CREATE PROCEDURE ObtenerRolAlumnoDelGrupo (
    IN group_id_s CHAR(6),
    IN student_id_s VARCHAR(10)
)
BEGIN
    DECLARE role_id CHAR(6);
    DECLARE role_name VARCHAR(100);
    
    -- Seleccionar el role_id del estudiante en el grupo dado
    SELECT sg.role_id, r.role_name 
    INTO role_id, role_name
    FROM students_groups sg
    INNER JOIN roles r ON sg.role_id = r.role_id
    WHERE sg.group_id = group_id_s AND sg.student_id = student_id_s;
    
    -- Devolver el role_id y el nombre del rol
    SELECT role_id, role_name;
END$$



-- 14. Procedure para listar los roles
DELIMITER $$
CREATE PROCEDURE ListarRoles ()
BEGIN
    SELECT * FROM roles;
END$$

DELIMITER ;