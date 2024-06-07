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

CREATE DATABASE UTP_GROUP;
USE UTP_GROUP;

-- TABLA DE ESTUDIANTES
CREATE TABLE students (
    student_id VARCHAR(10) PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    profile_picture VARCHAR(255),
    description TEXT,
    career VARCHAR(100),
    study_mode ENUM('Presencial', 'Virtual', 'Asincrónica')
);

-- TABAL DE PROFESORES
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
);

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
    skill_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10),
    skill_name VARCHAR(60),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- TABLA DE HOBBIES
CREATE TABLE hobbies (
    hobby_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10),
    hobby_name VARCHAR(60),
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- TABLA DE GRUPOS POR CURSO
CREATE TABLE groups (
    group_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    group_name VARCHAR(100),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)
);

-- TABLA DE ROLES PARA LOS GRUPOS
CREATE TABLE roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(100),
    description TEXT
);

-- TABLA DE MIEMBROS DE GRUPOS
CREATE TABLE group_members (
    group_id INT,
    student_id VARCHAR(10),
    role_id INT,
    FOREIGN KEY (group_id) REFERENCES groups(group_id),
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (role_id) REFERENCES roles(role_id),
    PRIMARY KEY (group_id, student_id)
);

-- TABLA DE FEEDBACK
CREATE TABLE feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    giver_id VARCHAR(10),
    receiver_id VARCHAR(10),
    group_id INT,
    stars TINYINT,
    comment TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (giver_id) REFERENCES students(student_id),
    FOREIGN KEY (receiver_id) REFERENCES students(student_id),
    FOREIGN KEY (group_id) REFERENCES groups(group_id)
);
