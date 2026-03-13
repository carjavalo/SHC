-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-03-2026 a las 23:30:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `cod_categoria` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `descripcion`, `cod_categoria`, `created_at`, `updated_at`) VALUES
(9, 'Inducción Institucional', 29, '2026-01-05 21:08:05', '2026-01-05 21:11:25'),
(10, 'Cursos', 28, '2026-01-05 21:13:12', '2026-01-05 21:13:12'),
(11, 'Diplomados', 28, '2026-01-05 21:13:23', '2026-01-05 21:13:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `imagen` varchar(255) NOT NULL,
  `tipo` enum('banner','multimedia') NOT NULL DEFAULT 'banner',
  `seccion` enum('banner_superior','galeria_multimedia') NOT NULL DEFAULT 'banner_superior',
  `url_enlace` varchar(500) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `velocidad_cambio` decimal(4,1) NOT NULL DEFAULT 5.0,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `banners`
--

INSERT INTO `banners` (`id`, `titulo`, `subtitulo`, `imagen`, `tipo`, `seccion`, `url_enlace`, `orden`, `activo`, `velocidad_cambio`, `created_by`, `created_at`, `updated_at`) VALUES
(14, NULL, NULL, 'banners/1773144594_EooOx5KLEp.mp4', 'multimedia', 'galeria_multimedia', NULL, 0, 1, 5.0, 1, '2026-03-10 17:09:54', '2026-03-10 17:09:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(28, 'Extensión Académica', '2026-01-05 20:44:47', '2026-01-05 20:44:47'),
(29, 'Coordinación Académica', '2026-01-05 20:45:15', '2026-01-05 20:45:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `id_area` bigint(20) UNSIGNED NOT NULL,
  `instructor_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `estado` enum('borrador','activo','finalizado','archivado') NOT NULL DEFAULT 'borrador',
  `codigo_acceso` varchar(10) DEFAULT NULL,
  `max_estudiantes` int(11) DEFAULT NULL,
  `imagen_portada` varchar(255) DEFAULT NULL,
  `objetivos` text DEFAULT NULL,
  `requisitos` text DEFAULT NULL,
  `duracion_horas` int(11) DEFAULT NULL,
  `nota_minima_aprobacion` decimal(3,2) NOT NULL DEFAULT 3.00 COMMENT 'Nota mínima para aprobar el curso (0.0 - 5.0)',
  `nota_maxima` decimal(3,2) NOT NULL DEFAULT 5.00 COMMENT 'Nota máxima del curso (siempre 5.0)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `id_area`, `instructor_id`, `fecha_inicio`, `fecha_fin`, `estado`, `codigo_acceso`, `max_estudiantes`, `imagen_portada`, `objetivos`, `requisitos`, `duracion_horas`, `nota_minima_aprobacion`, `nota_maxima`, `created_at`, `updated_at`) VALUES
(13, 'Reanimación Cardiopulmonar(RCP)', NULL, 10, 44, '2026-01-05 00:00:00', NULL, 'activo', 'AKOQD7', NULL, 'cursos/portadas/fnNjsPQQ8xtazUNrAmbuQkRi3PMi4hXkDuMjDayy.png', NULL, NULL, 20, 3.00, 5.00, '2026-01-06 03:18:42', '2026-03-11 23:11:54'),
(14, 'Hemato Oncología', NULL, 11, 45, NULL, NULL, 'activo', 'K3HJMJ', NULL, NULL, NULL, NULL, 115, 3.00, 5.00, '2026-01-06 18:51:49', '2026-01-06 18:56:21'),
(17, 'pagos', 'practica', 10, 44, '2026-01-01 00:00:00', '2026-04-30 23:59:00', 'activo', 'RJ3ZRN', NULL, 'cursos/portadas/ij514HBRhjh6EObLwXLIkECDhQJaJtAO6mSiUOf6.jpg', 'Aprender', 'Que sea bachiller', NULL, 3.00, 5.00, '2026-01-17 01:47:17', '2026-03-12 19:55:56'),
(18, 'Inducción Institucional (General)', NULL, 9, 44, '2026-01-01 19:00:00', '2026-01-31 19:00:00', 'activo', 'WVCVG3', NULL, 'cursos/portadas/Mm1x04uATVbbeMbUt4TOtLk2gtskDWJUReD7rpBd.png', NULL, NULL, NULL, 4.00, 5.00, '2026-01-22 21:24:01', '2026-01-22 21:44:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_actividades`
--

CREATE TABLE `curso_actividades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Material al que pertenece esta actividad',
  `titulo` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('tarea','evaluacion','quiz','proyecto') NOT NULL,
  `instrucciones` text DEFAULT NULL,
  `contenido_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contenido_json`)),
  `linked_material_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`linked_material_ids`)),
  `prerequisite_activity_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'IDs de actividades que deben completarse antes de esta' CHECK (json_valid(`prerequisite_activity_ids`)),
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `puntos_maximos` int(11) NOT NULL DEFAULT 100,
  `permite_entregas_tardias` tinyint(1) NOT NULL DEFAULT 0,
  `intentos_permitidos` int(11) NOT NULL DEFAULT 1,
  `es_obligatoria` tinyint(1) NOT NULL DEFAULT 1,
  `porcentaje_curso` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Porcentaje que representa la actividad sobre el curso (0-100%)',
  `nota_minima_aprobacion` decimal(3,2) NOT NULL DEFAULT 3.00 COMMENT 'Nota mínima para aprobar la actividad (0.0 - 5.0)',
  `habilitado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_actividades`
--

INSERT INTO `curso_actividades` (`id`, `curso_id`, `material_id`, `titulo`, `descripcion`, `tipo`, `instrucciones`, `contenido_json`, `linked_material_ids`, `prerequisite_activity_ids`, `fecha_apertura`, `fecha_cierre`, `puntos_maximos`, `permite_entregas_tardias`, `intentos_permitidos`, `es_obligatoria`, `porcentaje_curso`, `nota_minima_aprobacion`, `habilitado`, `created_at`, `updated_at`) VALUES
(20, 13, NULL, 'Examen RCP', '', 'evaluacion', '', NULL, NULL, NULL, NULL, NULL, 100, 0, 3, 1, 0.00, 3.00, 0, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(21, 14, NULL, 'Evaluación final', NULL, 'quiz', NULL, '{\"duration\":30,\"questions\":[{\"id\":1,\"text\":\"sdfdgdgdfbfgrg\",\"points\":20,\"options\":{\"A\":\"rgrghgds\",\"B\":\"grgrsdg\"},\"correctAnswers\":[\"A\"],\"isMultipleChoice\":false},{\"id\":2,\"text\":\"GRGRHRHRRHTRHRHRHRH\",\"points\":20,\"options\":{\"A\":\"sgtjtttggnvcjxghd\",\"B\":\"xbgfhgtgnvbgh\"},\"correctAnswers\":[\"B\"],\"isMultipleChoice\":false}],\"totalPoints\":40}', '[46]', NULL, NULL, NULL, 5, 0, 2, 1, 0.00, 3.00, 1, '2026-01-06 18:51:49', '2026-01-15 19:22:22'),
(22, 14, NULL, 'Evaluacion 2', '', 'quiz', '', '\"{\\\"duration\\\":30,\\\"totalPoints\\\":80,\\\"questions\\\":[{\\\"id\\\":1,\\\"text\\\":\\\"Usted se encuentra con un compa\\\\u00f1ero desayunando en la cafeter\\\\u00eda, cuando de repente un se\\\\u00f1or de 43 a\\\\u00f1os se lleva las manos al cuello, comienza a toser fuertemente y habla, por lo que su compa\\\\u00f1ero decide ir por ayuda, mientras que usted se encarga de instaurar el manejo. \\\\u00bfCu\\\\u00e1l es la acci\\\\u00f3n terap\\\\u00e9utica m\\\\u00e1s recomendada?\\\",\\\"points\\\":20,\\\"options\\\":{\\\"A\\\":\\\"Practicar maniobra de Heimlich.\\\",\\\"B\\\":\\\"Tumbar el paciente al suelo y realizar compresiones tor\\\\u00e1cicas\\\",\\\"C\\\":\\\"Sentar al paciente y darle un vaso de agua\\\",\\\"D\\\":\\\"Consolar al paciente y decirle que conserve la calma\\\"},\\\"correctAnswer\\\":\\\"A\\\"},{\\\"id\\\":2,\\\"text\\\":\\\"\\\\u00bfQu\\\\u00e9 es quimioterapia?\\\",\\\"points\\\":20,\\\"options\\\":{\\\"A\\\":\\\"Provocar una alteraci\\\\u00f3n celular en la sintesis de la proteina\\\",\\\"B\\\":\\\"Tratamiento a partir de mol\\\\u00e9culas que destruyen las c\\\\u00e9lulas cancer\\\\u00edgenas respetando las c\\\\u00e9lulas sanas\\\",\\\"C\\\":\\\"Proceso de crecimiento descontrolado de las c\\\\u00e9lulas.\\\",\\\"D\\\":\\\"todas las anteriores\\\"},\\\"correctAnswer\\\":\\\"B\\\"},{\\\"id\\\":3,\\\"text\\\":\\\"En el alumbramiento (tercera etapa del parto), \\\\u00bfcu\\\\u00e1l de las siguientes acciones corresponde a la atenci\\\\u00f3n inmediata del reci\\\\u00e9n nacido?\\\",\\\"points\\\":20,\\\"options\\\":{\\\"A\\\":\\\"Provocar una alteraci\\\\u00f3n celular en la s\\\\u00edntesis de la prote\\\\u00edna\\\",\\\"B\\\":\\\"Tratamiento a partir de mol\\\\u00e9culas que destruyen las c\\\\u00e9lulas cancer\\\\u00edgenas respetando las c\\\\u00e9lulas sanas\\\",\\\"C\\\":\\\"Proceso de crecimiento descontrolado de las c\\\\u00e9lulas\\\",\\\"D\\\":\\\"ninguna de las anteriores\\\"},\\\"correctAnswer\\\":\\\"C\\\"},{\\\"id\\\":4,\\\"text\\\":\\\"En caso de derrames accidentales del medicamento citost\\\\u00e1tico se deben realizar las siguientes acciones, excepto\\\",\\\"points\\\":20,\\\"options\\\":{\\\"A\\\":\\\"Actuar sin demora: Utilizar siempre bata impermeable, gafas de protecci\\\\u00f3n ocular, mascarilla con filtro, y doble guante de l\\\\u00e1tex sin polvo o de nitrilo.\\\",\\\"B\\\":\\\"Recoger el derrame con pa\\\\u00f1o absorbente (seco si es l\\\\u00edquido, h\\\\u00famedo si es polvo).\\\",\\\"C\\\":\\\"Desechar los residuos y el material utilizado en el envase de residuos org\\\\u00e1nicos\\\",\\\"D\\\":\\\"Todas las opciones son correctas\\\"},\\\"correctAnswer\\\":\\\"A\\\"}]}\"', NULL, NULL, NULL, NULL, 80, 0, 1, 1, 0.00, 3.00, 1, '2026-01-06 18:51:49', '2026-01-15 19:21:23'),
(32, 17, 66, 'Preliquidar 1', 'realizar', 'tarea', '1)\n2)\n3)\n4)', NULL, NULL, NULL, '2026-01-01 00:00:00', '2026-02-28 23:59:00', 5, 0, 1, 1, 10.00, 4.00, 0, '2026-01-17 01:47:17', '2026-02-03 19:04:20'),
(33, 17, 66, 'preliquidar 2', 'conteste', 'tarea', '1)\n2)\n3)\n4)', NULL, NULL, '[1768595689131]', '2026-01-01 00:00:00', '2026-02-28 23:59:00', 5, 0, 1, 1, 90.00, 5.00, 0, '2026-01-17 01:47:17', '2026-02-03 20:58:28'),
(34, 17, 67, 'liquidacion 1', 'contestar y subir', 'tarea', '1)\n2)\n3)', NULL, NULL, NULL, '2026-01-01 00:00:00', '2026-04-30 23:59:00', 5, 0, 1, 1, 50.00, 4.00, 0, '2026-01-17 01:47:17', '2026-02-03 20:58:14'),
(35, 17, 67, 'Liquidacion2', 'responda en Breve', 'tarea', '1)\n2)\n3)', NULL, NULL, '[1768595865224]', '2026-01-01 00:00:00', '2026-01-31 23:59:00', 5, 0, 1, 1, 50.00, 5.00, 0, '2026-01-17 01:47:17', '2026-01-17 01:47:17'),
(36, 17, 68, 'Pos liquidar 1', 'conteste', 'tarea', '1)\n2)\n3)', NULL, NULL, NULL, '2026-01-01 00:00:00', '2026-01-31 23:59:00', 5, 0, 1, 1, 0.50, 5.00, 0, '2026-01-17 01:47:17', '2026-01-17 01:47:17'),
(37, 17, 68, 'Final Post Liquidacion jum', 'conteste con cuidado ok', 'quiz', 'tiene 20 minutos para responder', '{\"duration\":\"20\",\"questions\":[{\"id\":\"1\",\"text\":\"aaaaaaaaaaaaaaaaaaaaaaaaaaa\",\"points\":\"1.5\",\"options\":{\"A\":\"vvvvvvvvvvvv\",\"B\":\"vvvvvvvvvvvvvvvv\",\"C\":\"vvvvvvvvvvvvvvv\"},\"correctAnswers\":[\"A\"],\"isMultipleChoice\":\"false\"},{\"id\":\"2\",\"text\":\"bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb\",\"points\":\"1.5\",\"options\":{\"A\":\"bbbbbbb\",\"B\":\"bbbbbbbbbbbb\",\"C\":\"bbbbbbbbbbbbb\"},\"correctAnswers\":[\"B\"],\"isMultipleChoice\":\"false\"},{\"id\":\"3\",\"text\":\"rrrrrrrrrrrrrrrrr\",\"points\":\"0.5\",\"options\":{\"A\":\"ggggggggggggg\",\"B\":\"ffffffffffffffff\",\"C\":\"gggggggggggg\",\"D\":\"hhhhhhhhhhhhhhhhhhh\"},\"correctAnswers\":[\"D\"],\"isMultipleChoice\":\"false\"},{\"id\":\"4\",\"text\":\"zzzzzzzzzzzzzzzzzzzzzzz\",\"points\":\"1.5\",\"options\":{\"A\":\"rrrrrrrrrrrrrr\",\"B\":\"rrtttttttttttttttttt\",\"C\":\"trrrrrrrrrrrrrr\"},\"correctAnswers\":[\"A\"],\"isMultipleChoice\":\"false\"}]}', NULL, '[\"36\"]', '2026-02-03 15:50:00', '2026-02-28 16:15:00', 5, 0, 1, 1, 99.50, 5.00, 1, '2026-01-17 01:47:17', '2026-02-04 21:50:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_actividad_entrega`
--

CREATE TABLE `curso_actividad_entrega` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `actividad_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contenido` text DEFAULT NULL,
  `puntos_obtenidos` decimal(8,2) DEFAULT 0.00,
  `observaciones_estudiante` text DEFAULT NULL,
  `archivo_path` varchar(255) DEFAULT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `comentarios_instructor` text DEFAULT NULL,
  `estado` enum('entregado','revisado','aprobado','rechazado') NOT NULL DEFAULT 'entregado',
  `entregado_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `revisado_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_actividad_entregas`
--

CREATE TABLE `curso_actividad_entregas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `actividad_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrega` timestamp NULL DEFAULT NULL,
  `estado` enum('pendiente','entregado','tarde') NOT NULL DEFAULT 'pendiente',
  `archivo_path` varchar(255) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `retroalimentacion` text DEFAULT NULL,
  `fecha_calificacion` timestamp NULL DEFAULT NULL,
  `calificado_por` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_asignaciones`
--

CREATE TABLE `curso_asignaciones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `asignado_por` bigint(20) UNSIGNED NOT NULL,
  `docente_id` bigint(20) UNSIGNED DEFAULT NULL,
  `estado` enum('activo','inactivo','expirado') NOT NULL DEFAULT 'activo',
  `fecha_asignacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_expiracion` timestamp NULL DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_asignaciones`
--

INSERT INTO `curso_asignaciones` (`id`, `curso_id`, `estudiante_id`, `asignado_por`, `docente_id`, `estado`, `fecha_asignacion`, `fecha_expiracion`, `observaciones`, `created_at`, `updated_at`) VALUES
(1, 13, 46, 44, NULL, 'inactivo', '2026-01-06 18:52:10', NULL, NULL, '2026-01-06 18:52:10', '2026-03-12 17:50:05'),
(2, 14, 46, 44, NULL, 'inactivo', '2026-01-06 18:52:10', NULL, NULL, '2026-01-06 18:52:10', '2026-03-12 17:50:08'),
(3, 14, 36, 1, NULL, 'inactivo', '2026-01-23 17:23:23', NULL, NULL, '2026-01-06 18:53:16', '2026-01-23 17:23:53'),
(4, 13, 36, 1, 45, 'activo', '2026-03-12 22:03:45', NULL, NULL, '2026-01-06 18:56:55', '2026-03-12 22:03:45'),
(6, 17, 36, 1, 45, 'activo', '2026-03-12 22:03:45', NULL, NULL, '2026-01-17 01:48:37', '2026-03-12 22:03:45'),
(9, 17, 37, 1, NULL, 'activo', '2026-01-19 19:09:32', NULL, NULL, '2026-01-19 19:09:32', '2026-01-19 19:09:32'),
(10, 17, 46, 1, 45, 'activo', '2026-03-12 20:56:07', NULL, NULL, '2026-01-19 19:09:32', '2026-03-12 20:56:07'),
(11, 18, 36, 1, 45, 'inactivo', '2026-03-12 21:00:53', NULL, NULL, '2026-01-22 21:25:37', '2026-03-12 21:33:28'),
(26, 18, 63, 1, NULL, 'activo', '2026-01-24 02:12:13', NULL, NULL, '2026-01-24 02:12:13', '2026-01-24 02:12:13'),
(27, 14, 63, 1, NULL, 'activo', '2026-01-24 02:14:23', NULL, NULL, '2026-01-24 02:14:23', '2026-01-24 02:14:23'),
(28, 18, 74, 1, NULL, 'activo', '2026-02-05 23:48:14', NULL, NULL, '2026-02-05 23:48:14', '2026-02-05 23:48:14'),
(29, 18, 75, 1, NULL, 'activo', '2026-02-05 23:48:14', NULL, NULL, '2026-02-05 23:48:17', '2026-02-05 23:48:17'),
(30, 18, 76, 1, NULL, 'inactivo', '2026-02-05 23:48:14', NULL, NULL, '2026-02-05 23:48:19', '2026-03-12 22:43:58'),
(31, 18, 46, 1, 45, 'activo', '2026-03-12 19:54:34', NULL, NULL, '2026-03-12 19:36:23', '2026-03-12 19:54:34'),
(32, 13, 76, 1, 45, 'activo', '2026-03-12 22:44:08', NULL, NULL, '2026-03-12 22:44:08', '2026-03-12 22:44:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_estudiantes`
--

CREATE TABLE `curso_estudiantes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `estudiante_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_inscripcion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activo','inactivo','completado','abandonado') NOT NULL DEFAULT 'activo',
  `progreso` int(11) NOT NULL DEFAULT 0,
  `ultima_actividad` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_estudiantes`
--

INSERT INTO `curso_estudiantes` (`id`, `curso_id`, `estudiante_id`, `fecha_inscripcion`, `estado`, `progreso`, `ultima_actividad`, `created_at`, `updated_at`) VALUES
(15, 13, 46, '2026-01-19 19:02:43', 'inactivo', 0, '2026-01-19 19:02:43', '2026-01-19 19:02:43', '2026-01-19 19:02:43'),
(16, 14, 46, '2026-01-19 19:02:45', 'inactivo', 0, '2026-01-19 19:02:45', '2026-01-19 19:02:45', '2026-01-19 19:02:45'),
(17, 17, 37, '2026-01-19 19:10:37', 'activo', 0, '2026-01-19 19:10:37', '2026-01-19 19:10:37', '2026-01-19 19:10:37'),
(31, 18, 63, '2026-01-24 02:13:36', 'activo', 0, '2026-01-24 02:13:36', '2026-01-24 02:13:36', '2026-01-24 02:13:36'),
(38, 18, 74, '2026-02-05 23:48:14', 'activo', 0, NULL, '2026-02-05 23:48:14', '2026-02-05 23:48:14'),
(39, 18, 75, '2026-02-05 23:48:14', 'activo', 0, NULL, '2026-02-05 23:48:17', '2026-02-05 23:48:17'),
(40, 18, 76, '2026-02-05 23:48:14', 'inactivo', 0, NULL, '2026-02-05 23:48:19', '2026-02-05 23:48:19'),
(43, 18, 46, '2026-03-12 20:58:12', 'activo', 0, '2026-03-12 20:58:12', '2026-03-12 20:58:12', '2026-03-12 20:58:12'),
(44, 17, 46, '2026-03-12 20:58:17', 'activo', 0, '2026-03-12 20:58:17', '2026-03-12 20:58:17', '2026-03-12 20:58:17'),
(45, 18, 36, '2026-03-12 21:01:34', 'inactivo', 0, '2026-03-12 21:01:34', '2026-03-12 21:01:34', '2026-03-12 21:01:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_foros`
--

CREATE TABLE `curso_foros` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `contenido` text NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `es_anuncio` tinyint(1) NOT NULL DEFAULT 0,
  `es_fijado` tinyint(1) NOT NULL DEFAULT 0,
  `likes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_foros`
--

INSERT INTO `curso_foros` (`id`, `curso_id`, `usuario_id`, `titulo`, `contenido`, `parent_id`, `es_anuncio`, `es_fijado`, `likes`, `created_at`, `updated_at`) VALUES
(14, 17, 44, 'discutir', 'temas libres', NULL, 0, 1, 0, '2026-01-17 01:47:17', '2026-01-17 01:47:17'),
(15, 18, 44, '¡Bienvenidos al hospital!', 'Nos complace iniciar con ustedes este proceso de inducción, en el cual conocerán los lineamientos, normas y procedimientos que orientan nuestra labor asistencial y académica. Este espacio busca facilitar su integración, fortalecer su desempeño y promover una atención en salud responsable, ética y de calidad. Les deseamos una experiencia formativa exitosa.\n\n\n', NULL, 1, 1, 0, '2026-01-22 21:24:01', '2026-01-22 21:24:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_materiales`
--

CREATE TABLE `curso_materiales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('archivo','video','imagen','documento','clase_en_linea') NOT NULL,
  `archivo_path` varchar(255) DEFAULT NULL,
  `archivo_nombre` varchar(255) DEFAULT NULL,
  `archivo_extension` varchar(10) DEFAULT NULL,
  `archivo_size` bigint(20) DEFAULT NULL,
  `url_externa` varchar(255) DEFAULT NULL,
  `orden` int(11) NOT NULL DEFAULT 0,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `es_publico` tinyint(1) NOT NULL DEFAULT 1,
  `porcentaje_curso` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Porcentaje que representa el material sobre el curso (0-100%)',
  `nota_minima_aprobacion` decimal(3,2) NOT NULL DEFAULT 3.00 COMMENT 'Nota mínima para aprobar el material (0.0 - 5.0)',
  `prerequisite_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `curso_materiales`
--

INSERT INTO `curso_materiales` (`id`, `curso_id`, `titulo`, `descripcion`, `tipo`, `archivo_path`, `archivo_nombre`, `archivo_extension`, `archivo_size`, `url_externa`, `orden`, `fecha_inicio`, `fecha_fin`, `es_publico`, `porcentaje_curso`, `nota_minima_aprobacion`, `prerequisite_id`, `created_at`, `updated_at`) VALUES
(39, 13, 'introducción curso de soporte vital básico HUV', '', 'video', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/1tzum92RP6Na5h6j8_p3CZzyZUki1xhWw/view?usp=sharing', 1, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(40, 13, 'Generalidades de la rcp y soporte vital básico adulto', '', 'video', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/1u-zHrzfLMZL5s7i0TXJRinSENVDl1MNv/view', 2, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(41, 13, 'Ovace', '', 'video', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/1U4yZoT0GhJyKVe93NuqIHiLAEG3MEYs1/view', 3, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(42, 13, 'Video Dea', '', 'video', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/18q365bkXNDzhUfZ14ECqkdGcT1XMb5Sc/view', 4, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(43, 13, 'Soporte vital básico pediátrico', '', 'video', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/1yT2LA4yEK42z5HU3uhYjkr1DP4N7Qrhw/view', 5, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 03:18:42', '2026-01-06 03:18:42'),
(44, 14, 'MODULO 1', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/67f834bd1a857fdd10bbbe14/interactive-content-modulo-1-hemato', 1, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 18:51:49', '2026-01-06 18:51:49'),
(45, 14, 'MODULO 2', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/67f8373820540ffde531a7f7/interactive-content-modulo-2-hemato', 2, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 18:51:49', '2026-01-06 18:51:49'),
(46, 14, 'MODULO 3', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/67f83819285f3787bbefc6b3/interactive-content-modulo-3-hemato', 3, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 18:51:49', '2026-01-06 18:51:49'),
(47, 14, 'MODULO 4', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/67f838b7f15f85cbc97cb840/interactive-content-modulo-4-hemato', 4, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-06 18:51:49', '2026-01-06 18:51:49'),
(66, 17, 'Preliquidacion', 'Un proceso', 'documento', 'cursos/17/materiales/G08ibg6HJxkN35pgTV4X1j8ebryBzbB0HcJ72tHx.jpg', 'foto1.jpg', 'jpg', 98073, NULL, 1, NULL, NULL, 1, 20.00, 3.00, NULL, '2026-01-17 01:47:17', '2026-01-20 17:11:03'),
(67, 17, 'Liquidar', 'pagos efectivos', 'documento', 'cursos/17/materiales/vifcMyWv5Z0Gh7qn6of0kiITzQSaiKulTfXh7hbU.jpg', 'foto1.jpg', 'jpg', 98073, NULL, 2, NULL, NULL, 1, 20.00, 3.00, 66, '2026-01-17 01:47:17', '2026-01-20 17:11:16'),
(68, 17, 'Post Liquidar', 'reclamos', 'documento', 'cursos/17/materiales/2e6Vh6ZRHekjkmcdm21SnosDd97QEbF2occgM8fi.jpg', 'foto2.jpg', 'jpg', 84755, NULL, 3, NULL, NULL, 1, 60.00, 3.00, 67, '2026-01-17 01:47:17', '2026-01-20 17:11:24'),
(69, 18, '1. DIRECCIONAMIENTO ESTRATÉGICO', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65847b54c60dcb00144860aa/interactive-content-direccionamiento-estrategico?authuser=0', 1, NULL, NULL, 1, 0.00, 3.00, NULL, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(70, 18, '2. GESTIÓN CALIDAD', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65848554c60dcb00144d93e6/interactive-content-gestion-calidad?authuser=0', 2, NULL, NULL, 1, 0.00, 3.00, 69, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(71, 18, '3. COORDINACIÓN ACADÉMICA', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65848393cbb59a001482f35f/interactive-content-coordinacion-academica?authuser=0', 3, NULL, NULL, 1, 0.00, 3.00, 70, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(72, 18, '4. POLÍTICA DOCENCIA SERVICIO', '', 'documento', NULL, NULL, NULL, NULL, 'https://drive.google.com/file/d/1KOej1QcErj-m0bT0j0XlFfRWN_3on5y5/view?usp=classroom_web&authuser=0', 4, NULL, NULL, 1, 0.00, 3.00, 71, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(73, 18, '5. POLÍTICA DE GESTIÓN DEL CONOCIMIENTO Y LA INNOVACIÓN', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65b7c10320d46c0014fc41f2/interactive-content-politica-de-gestion-del-conocimiento-y-la-innovacion?authuser=0', 5, NULL, NULL, 1, 0.00, 3.00, 72, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(74, 18, '6. POLÍTICA DE HUMANIZACIÓN', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/66d5c3491f0c039ac5a77f86/interactive-content-politica-de-humanizacion?authuser=0', 6, NULL, NULL, 1, 0.00, 3.00, 73, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(75, 18, '7. DARUMA', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65858260899e670015866159/interactive-content-daruma?authuser=0', 7, NULL, NULL, 1, 0.00, 3.00, 74, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(76, 18, '8. DERECHOS Y DEBERES DEL PACIENTE', '', 'documento', NULL, NULL, NULL, NULL, 'https://www.calameo.com/read/006141493fcc60112b715?authuser=0', 8, NULL, NULL, 1, 0.00, 3.00, 75, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(77, 18, '9. SEGURIDAD DEL PACIENTE', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65f85fc0bb328200149b9d62/interactive-content-seguridad-del-paciente?authuser=0', 9, NULL, NULL, 1, 0.00, 3.00, 76, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(78, 18, '10. CONTROL DE INFECCIONES', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/6691937cbf1e2c0d70d02a64/interactive-content-control-de-infecciones?authuser=0', 10, NULL, NULL, 1, 0.00, 3.00, 77, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(79, 18, '11. SEGURIDAD Y SALUD EN EL TRABAJO', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/658487bfc5af6d0013a17017/interactive-content-salud-ocupacional?authuser=0', 11, NULL, NULL, 1, 0.00, 3.00, 78, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(80, 18, '12. GESTIÓN AMBIENTAL', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/65848901c5af6d0013a224a9/interactive-content-gestion-ambiental?authuser=0', 12, NULL, NULL, 1, 0.00, 3.00, 79, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(81, 18, '13. ATENCIÓN QUIRÚRGICA', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/66df6e2bc9379e1c924c706d/interactive-content-atencion-quirurgica?authuser=0', 13, NULL, NULL, 1, 0.00, 3.00, 80, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(82, 18, '14. PROGRAMAS SOCIALES', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/658580a378f80a0015b854ab/interactive-content-programas-sociales?authuser=0', 14, NULL, NULL, 1, 0.00, 3.00, 81, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(83, 18, '15. TRABAJO MIMHOS', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/6585bd42899e6700159fe0be/interactive-content-trabajo-mimhos?authuser=0', 15, NULL, NULL, 1, 0.00, 3.00, 82, '2026-01-22 21:24:01', '2026-01-22 21:24:01'),
(84, 18, '16. LACTANCIA MATERNA', '', 'video', NULL, NULL, NULL, NULL, 'https://view.genially.com/6585bc35fa7c870015622fd4/interactive-content-lactancia-materna?authuser=0', 16, NULL, NULL, 1, 0.00, 3.00, 83, '2026-01-22 21:24:01', '2026-01-22 21:24:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_material_visto`
--

CREATE TABLE `curso_material_visto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `curso_id` bigint(20) UNSIGNED NOT NULL,
  `material_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `visto_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_chat`
--

CREATE TABLE `mensajes_chat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remitente_id` bigint(20) UNSIGNED NOT NULL,
  `destinatario_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mensaje` text NOT NULL,
  `tipo` enum('individual','grupal') NOT NULL DEFAULT 'individual',
  `grupo_destinatario` varchar(255) DEFAULT NULL,
  `es_difusion` tinyint(1) NOT NULL DEFAULT 0,
  `leido` tinyint(1) NOT NULL DEFAULT 0,
  `leido_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mensajes_chat`
--

INSERT INTO `mensajes_chat` (`id`, `remitente_id`, `destinatario_id`, `mensaje`, `tipo`, `grupo_destinatario`, `es_difusion`, `leido`, `leido_at`, `created_at`, `updated_at`) VALUES
(1, 1, 36, 'como estas?', 'individual', NULL, 0, 0, NULL, '2026-01-21 21:24:17', '2026-01-21 21:24:17'),
(2, 1, 36, 'como estas?', 'individual', NULL, 0, 0, NULL, '2026-01-21 21:27:26', '2026-01-21 21:27:26'),
(3, 36, 44, 'Mensaje de prueba automático - 2026-01-21 16:51:13', 'individual', NULL, 0, 0, NULL, '2026-01-21 21:51:13', '2026-01-21 21:51:13'),
(4, 1, 36, 'hola como estas?', 'individual', NULL, 0, 0, NULL, '2026-01-21 22:07:11', '2026-01-21 22:07:11'),
(5, 1, 36, 'hola como estas?', 'individual', NULL, 0, 0, NULL, '2026-01-21 22:07:55', '2026-01-21 22:07:55'),
(6, 1, 36, 'hola como esta', 'individual', NULL, 0, 0, NULL, '2026-01-21 22:13:07', '2026-01-21 22:13:07'),
(7, 1, 44, 'care nalga', 'individual', NULL, 0, 0, NULL, '2026-01-21 22:22:39', '2026-01-21 22:22:39'),
(8, 1, 36, 'como estas', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:30:04', '2026-01-21 23:30:04'),
(9, 1, 36, 'care  rabano', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:33:15', '2026-01-21 23:33:15'),
(10, 1, 36, 'hola', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:40:50', '2026-01-21 23:40:50'),
(11, 1, 36, 'Care zapato', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:44:39', '2026-01-21 23:44:39'),
(12, 1, 36, 'Mensaje de prueba del sistema de tiempo real - 2026-01-21 18:51:57', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:51:57', '2026-01-21 23:51:57'),
(13, 1, 36, 'pendejo', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:56:29', '2026-01-21 23:56:29'),
(14, 1, 36, 'nojoda mano', 'individual', NULL, 0, 0, NULL, '2026-01-21 23:56:55', '2026-01-21 23:56:55'),
(15, 1, 44, 'hablame pana bien ono', 'individual', NULL, 0, 0, NULL, '2026-01-22 00:12:15', '2026-01-22 00:12:15'),
(16, 36, 44, 'entonces', 'individual', NULL, 0, 0, NULL, '2026-01-22 00:14:00', '2026-01-22 00:14:00'),
(17, 36, 44, 'hola', 'individual', NULL, 0, 0, NULL, '2026-01-22 00:14:27', '2026-01-22 00:14:27'),
(18, 44, 36, 'entoces', 'individual', NULL, 0, 0, NULL, '2026-01-22 00:14:57', '2026-01-22 00:14:57'),
(19, 36, 44, 'bien pana gracias', 'individual', NULL, 0, 0, NULL, '2026-01-22 00:15:16', '2026-01-22 00:15:16'),
(23, 1, 37, 'carenalga', 'individual', NULL, 0, 0, NULL, '2026-02-08 01:17:44', '2026-02-08 01:17:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_01_15_131421_create_servicios_areas_table', 1),
(2, '0001_01_01_000000_create_users_table', 2),
(3, '0001_01_01_000001_create_cache_table', 2),
(4, '0001_01_01_000002_create_jobs_table', 2),
(5, '2025_06_05_181325_add_apellidos_to_users_table', 2),
(6, '2025_06_05_213518_create_procedimientos_table', 2),
(7, '2025_06_16_134428_add_role_to_users_table', 2),
(8, '2025_06_16_142644_add_document_fields_to_users_table', 3),
(9, '2025_06_18_213757_create_user_logins_table', 3),
(10, '2025_06_19_140901_create_categorias_table', 3),
(11, '2025_06_19_200000_create_areas_table', 3),
(12, '2025_06_19_210000_create_cursos_table', 3),
(13, '2025_06_19_210001_create_curso_estudiantes_table', 3),
(14, '2025_06_19_210002_create_curso_materiales_table', 3),
(15, '2025_06_19_210003_create_curso_foros_table', 3),
(16, '2025_06_19_210004_create_curso_actividades_table', 3),
(17, '2025_09_25_153030_create_curso_progreso_tables', 3),
(18, '2025_10_31_000001_add_clase_en_linea_to_curso_materiales', 3),
(19, '2025_10_31_000002_add_contenido_json_to_curso_actividades', 3),
(20, '2025_11_04_000001_add_habilitado_to_curso_actividades', 3),
(21, '2025_11_20_150112_add_observaciones_estudiante_to_curso_actividad_entrega_table', 3),
(22, '2025_11_21_190249_create_user_operations_table', 3),
(23, '2025_12_12_125124_add_operador_to_role_enum_in_users_table', 3),
(24, '2026_01_05_140000_create_curso_asignaciones_table', 3),
(25, '2026_01_06_000001_add_prerequisite_id_to_curso_materiales_table', 3),
(26, '2026_01_07_000001_add_linked_material_ids_to_curso_actividades_table', 3),
(27, '2026_01_15_000001_create_servicios_areas_table', 4),
(28, '2026_01_15_000002_create_vinculacion_contrato_table', 5),
(29, '2026_01_15_000003_create_sedes_table', 6),
(30, '2026_01_15_000004_add_servicio_vinculacion_sede_to_users_table', 7),
(31, '2025_06_20_100000_add_grading_system_fields', 8),
(32, '2025_06_20_110000_change_curso_dates_to_datetime', 9),
(33, '2025_06_20_120000_add_nota_minima_to_actividades', 10),
(34, '2025_06_20_130000_add_prerequisite_activity_ids_to_actividades', 10),
(35, '2026_01_20_132416_create_curso_actividad_entregas_table', 11),
(36, '2026_01_21_150233_add_phone_to_users_table', 12),
(37, '2026_01_21_150335_add_phone_to_users_table', 12),
(38, '2026_01_21_155452_create_mensajes_chat_table', 13),
(39, '2026_01_21_161603_add_tipo_and_grupo_to_mensajes_chat_table', 14),
(40, '2026_02_03_164209_add_puntos_obtenidos_to_curso_actividad_entrega', 15),
(41, '2026_03_09_000001_create_banners_table', 16),
(42, '2026_03_11_215325_add_docente_id_to_curso_asignaciones', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos`
--

CREATE TABLE `procedimientos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Cod_Episodio` int(11) DEFAULT NULL,
  `Cod_Sala` int(11) DEFAULT NULL,
  `Nom_Sala` varchar(100) DEFAULT NULL,
  `Num_Cama` varchar(20) DEFAULT NULL,
  `F_Ingreso` datetime DEFAULT NULL,
  `Cod_Eps` varchar(20) DEFAULT NULL,
  `Nom_Eps` varchar(100) DEFAULT NULL,
  `Hist_Clinica` int(11) DEFAULT NULL,
  `Tipo_Ident` varchar(5) DEFAULT NULL,
  `Num_Ident` varchar(20) DEFAULT NULL,
  `Edad` int(11) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL,
  `Servicio` varchar(100) DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `Medico_Trata` varchar(100) DEFAULT NULL,
  `Cod_Diag` varchar(10) DEFAULT NULL,
  `CIE10` varchar(10) DEFAULT NULL,
  `Diagnostico` varchar(255) DEFAULT NULL,
  `Antimicrobiano` varchar(100) DEFAULT NULL,
  `Cantidad` varchar(50) DEFAULT NULL,
  `Presentacion` varchar(50) DEFAULT NULL,
  `Via_Aplicacion` varchar(50) DEFAULT NULL,
  `Tiem_Horas` varchar(50) DEFAULT NULL,
  `Dias_Antibioticos` varchar(50) DEFAULT NULL,
  `Fec_Sumistro` date DEFAULT NULL,
  `Ho_Sumisnistro` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'HUV-CALI', '2026-01-15 20:55:00', '2026-01-15 20:55:00'),
(2, 'HUV-CARTAGO', '2026-01-15 20:55:00', '2026-01-15 20:55:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios_areas`
--

CREATE TABLE `servicios_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicios_areas`
--

INSERT INTO `servicios_areas` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Administrativo', NULL, NULL),
(2, 'Consulta Externa', NULL, NULL),
(3, 'Hospitalizacion', NULL, NULL),
(4, 'Sala de Operaciones', NULL, NULL),
(5, 'Uci', NULL, NULL),
(6, 'Urgencias', NULL, NULL),
(7, 'Banco de Sangre', NULL, NULL),
(8, 'Unidad Renal', NULL, NULL),
(9, 'Otro', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3PngWJA4416xUzy9tEl0fhYGPWkgpyhTLbo0PJ3p', 1, '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMWRGSXhXbGJPanFsY3pWUk5KMllRZklHM3FMVmhSdkRSZWFJVllQWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU0OiJodHRwOi8vMTkyLjE2OC4yLjIwMDo4MDAxL2FjYWRlbWljby9jb250cm9sLXBlZGFnb2dpY28iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773354346),
('7Yl9VZrDbHqkT1cVKcTEvjI6Cyr2kPzM9KnTp6Xb', 36, '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVUNiemZPWkxGWkNBa0xET1FhNzdoSW1RRVN1dEJ6bHF3cXNJbWwxTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly8xOTIuMTY4LjIuMjAwOjgwMDEvYWNhZGVtaWNvL2N1cnNvcy1kaXNwb25pYmxlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM2O30=', 1773337402);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `apellido1` varchar(100) DEFAULT NULL,
  `apellido2` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('Super Admin','Administrador','Docente','Estudiante','Registrado','Operador') NOT NULL DEFAULT 'Registrado',
  `tipo_documento` enum('DNI','Pasaporte','Carnet de Extranjería','Cédula') DEFAULT NULL,
  `numero_documento` varchar(20) DEFAULT NULL,
  `servicio_area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vinculacion_contrato_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sede_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `apellido1`, `apellido2`, `email`, `phone`, `role`, `tipo_documento`, `numero_documento`, `servicio_area_id`, `vinculacion_contrato_id`, `sede_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Carlos Jairton', 'Valderrama', 'Orobio', 'carjavalosistem@gmail.com', '302 5269287', 'Super Admin', 'DNI', '121424443', NULL, NULL, NULL, '2025-06-17 02:36:45', '$2y$12$EnOfSKid6Q0GxBR0ncZjde2okJWsrZIr999R7/gzJAEcAZJ2IIvPq', NULL, '2025-06-16 18:26:54', '2026-01-21 20:42:23'),
(36, 'Uno Estudiante', 'uno', 'uno', 'uno@estudiante.com', '+51987654322', 'Estudiante', 'Pasaporte', '6427785448', NULL, NULL, NULL, '2025-06-17 02:19:51', '$2y$12$StNFxknxExNgSqNAjmUm7.HS70qnEEojUDTx3nV74SK0ojFU0p3AK', 'kkUHsDK3WYCRqj2Lk6JQGhfEHAR4MC5TXweEvzFUR8iuehCv7xoa5vfbbFww', '2025-06-17 02:17:36', '2026-02-03 21:43:57'),
(37, 'Dos Estudiante', 'dos', 'dos', 'dos@estudiante.com', '+51987654323', 'Estudiante', 'Cédula', '1233321', NULL, NULL, NULL, '2025-06-17 05:04:04', '$2y$12$y1RMMw0/bqy4KgVa.L4DRetmOPVCm0ceI38zTioB0tbjlCRjjicYa', NULL, '2025-06-17 02:48:13', '2026-01-23 01:36:49'),
(38, 'Usuario', 'Prueba', 'Verificado', 'test@example.com', '+51987654324', 'Estudiante', 'DNI', '87654321', NULL, NULL, NULL, '2025-06-17 05:04:04', '$2y$12$8RjSJS9V/WqEVYGKw8HQAuTI7G73FXCIcfbbCpK4sXUopD1dwyLCi', NULL, '2025-06-17 03:03:26', '2026-01-23 01:37:27'),
(44, 'Jhon Andres', 'Carrillo', 'Bolaños', 'touma11913@gmail.com', '311 6306106', 'Operador', 'Cédula', '1143995780', NULL, NULL, NULL, '2025-12-12 18:00:34', '$2y$12$a8e/Y0JRjQieHsX2QgkUDertB9rhX/hSRx1m7XVpW8Xu6NGA.DdXy', 'QLPyS1gPoibKzWluPR9pge5TrlaGCqlENxxcOayq9iriFUIGGC265udoTN8Z', '2025-12-12 18:00:32', '2026-01-21 20:42:23'),
(45, 'DocenteCurso', 'Prueba', 'Prueba', 'uno@docente.com', '+51987654326', 'Docente', 'Cédula', '987654321123', NULL, NULL, NULL, '2026-01-05 23:19:48', '$2y$12$MXkIdaF70ayAirlxuhBJie.8UqI.fo5gm0tXPW8b.KSOkY.m9iaWi', NULL, '2026-01-05 23:19:46', '2026-01-21 20:42:23'),
(46, 'Tres Estudiante', 'Estudiante', 'Tres', 'tres@estudiante.com', '+51987654327', 'Estudiante', 'Cédula', '1143995781', NULL, 1, 1, '2026-01-06 17:36:28', '$2y$12$9AwYRyLI0via2rqHKuSOneQCa4C5wTgZuZeOkghXKa5G.EIR8Jd72', 'Rlr701ReyqSAqOniW6LgFgQJpIqDfyjKPE6HjaquinJSTr1BqyWabvnnB85P', '2026-01-06 17:36:28', '2026-02-05 01:56:04'),
(63, 'Julanin', 'pacual', 'Prueba', 'carjavalo1@hotmail.com', '3002588545', 'Estudiante', 'Cédula', '36985214147', NULL, 1, 1, '2026-01-24 02:12:10', '$2y$12$GZd5Ndjp/jiIPSia67J.le7qhOU/QvF3BtXRJxjmSTur0MHwIHKBi', NULL, '2026-01-24 02:11:04', '2026-02-05 01:56:04'),
(74, 'Cinco', 'estudiante', 'Cinco', 'cinco@estudiante.com', '30003252232', 'Estudiante', 'Cédula', '123123123', NULL, NULL, NULL, '2026-02-05 23:48:14', '$2y$12$UzocY2Q84yz39A0b6nSK1OfliXrtev1nQ95zXIcwjCATkvVncfMYq', NULL, '2026-02-05 23:48:14', '2026-02-05 23:48:14'),
(75, 'seis', 'estudiante', 'seis', 'seis@estudiante.com', '3152555363', 'Estudiante', 'Cédula', '555555555', NULL, NULL, NULL, '2026-02-05 23:48:14', '$2y$12$YLMxY6I0DPt2ZF0KG8iMl.qi1AeEcpJhj3UwJ7Di0Lcxl1CmMKHOK', NULL, '2026-02-05 23:48:17', '2026-02-05 23:48:17'),
(76, 'cuatro', 'estudiante', 'cuatro', 'cuatro@estudiante.com', '3123223536', 'Estudiante', 'Cédula', '321321321', NULL, NULL, NULL, '2026-02-05 23:48:14', '$2y$12$JesjImtQK9y50B2Li7PRvOWOv6H5eHaJn4f.1aiargX7qWsZvwbse', NULL, '2026-02-05 23:48:19', '2026-02-05 23:48:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `status` enum('success','failed') NOT NULL,
  `email_verified` enum('verified','unverified') DEFAULT NULL,
  `failure_reason` varchar(255) DEFAULT NULL,
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_logins`
--

INSERT INTO `user_logins` (`id`, `user_id`, `email`, `ip_address`, `user_agent`, `status`, `email_verified`, `failure_reason`, `attempted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-15 18:50:06', '2026-01-15 18:50:06', '2026-01-15 18:50:06'),
(187, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-11-21 23:40:28', '2025-11-21 23:40:28', '2025-11-21 23:40:28'),
(188, 36, 'uno@estudiante.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-11-21 23:52:35', '2025-11-21 23:52:35', '2025-11-21 23:52:35'),
(189, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-09 17:24:39', '2025-12-09 17:24:39', '2025-12-09 17:24:39'),
(190, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'failed', 'verified', 'Credenciales inválidas', '2025-12-09 23:02:24', '2025-12-09 23:02:24', '2025-12-09 23:02:24'),
(191, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-09 23:02:33', '2025-12-09 23:02:33', '2025-12-09 23:02:33'),
(192, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-10 21:26:01', '2025-12-10 21:26:01', '2025-12-10 21:26:01'),
(193, 36, 'uno@estudiante.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-11 01:13:22', '2025-12-11 01:13:22', '2025-12-11 01:13:22'),
(194, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'success', 'verified', NULL, '2025-12-11 01:32:27', '2025-12-11 01:32:27', '2025-12-11 01:32:27'),
(195, NULL, 'carjavalosiste@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2025-12-12 00:37:03', '2025-12-12 00:37:03', '2025-12-12 00:37:03'),
(196, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-12 00:37:12', '2025-12-12 00:37:12', '2025-12-12 00:37:12'),
(197, 36, 'uno@estudiante.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'success', 'verified', NULL, '2025-12-12 00:52:17', '2025-12-12 00:52:17', '2025-12-12 00:52:17'),
(198, NULL, 'carjavalosistem@mail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2025-12-12 01:14:10', '2025-12-12 01:14:10', '2025-12-12 01:14:10'),
(199, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-12 01:14:20', '2025-12-12 01:14:20', '2025-12-12 01:14:20'),
(200, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2025-12-12 17:55:28', '2025-12-12 17:55:28', '2025-12-12 17:55:28'),
(201, 44, 'touma11913@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'success', 'unverified', NULL, '2025-12-12 18:02:08', '2025-12-12 18:02:08', '2025-12-12 18:02:08'),
(202, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-05 19:55:32', '2026-01-05 19:55:32', '2026-01-05 19:55:32'),
(203, 44, 'touma11913@gmail.com', '192.168.2.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-05 19:59:08', '2026-01-05 19:59:08', '2026-01-05 19:59:08'),
(204, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-05 20:00:05', '2026-01-05 20:00:05', '2026-01-05 20:00:05'),
(205, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-05 20:27:16', '2026-01-05 20:27:16', '2026-01-05 20:27:16'),
(206, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 02:38:56', '2026-01-06 02:38:56', '2026-01-06 02:38:56'),
(207, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 16:39:34', '2026-01-06 16:39:34', '2026-01-06 16:39:34'),
(208, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 17:21:37', '2026-01-06 17:21:37', '2026-01-06 17:21:37'),
(209, 46, 'programasdeextensionhuv@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-06 17:39:57', '2026-01-06 17:39:57', '2026-01-06 17:39:57'),
(210, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 17:47:08', '2026-01-06 17:47:08', '2026-01-06 17:47:08'),
(211, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 18:55:29', '2026-01-06 18:55:29', '2026-01-06 18:55:29'),
(212, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 19:56:48', '2026-01-06 19:56:48', '2026-01-06 19:56:48'),
(213, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 21:17:57', '2026-01-06 21:17:57', '2026-01-06 21:17:57'),
(214, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 21:21:16', '2026-01-06 21:21:16', '2026-01-06 21:21:16'),
(215, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 21:22:10', '2026-01-06 21:22:10', '2026-01-06 21:22:10'),
(216, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-06 21:23:01', '2026-01-06 21:23:01', '2026-01-06 21:23:01'),
(217, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-15 19:00:24', '2026-01-15 19:00:24', '2026-01-15 19:00:24'),
(218, 44, 'touma11913@gmail.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'verified', 'Credenciales inválidas', '2026-01-15 19:17:26', '2026-01-15 19:17:26', '2026-01-15 19:17:26'),
(219, 44, 'touma11913@gmail.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-15 19:17:43', '2026-01-15 19:17:43', '2026-01-15 19:17:43'),
(220, 36, 'uno@estudiante.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'verified', 'Credenciales inválidas', '2026-01-15 19:19:22', '2026-01-15 19:19:22', '2026-01-15 19:19:22'),
(221, 36, 'uno@estudiante.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-15 19:19:29', '2026-01-15 19:19:29', '2026-01-15 19:19:29'),
(222, 44, 'touma11913@gmail.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-15 19:20:20', '2026-01-15 19:20:20', '2026-01-15 19:20:20'),
(223, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-15 21:39:40', '2026-01-15 21:39:40', '2026-01-15 21:39:40'),
(224, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-16 17:12:56', '2026-01-16 17:12:56', '2026-01-16 17:12:56'),
(225, 44, 'touma11913@gmail.com', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-16 17:25:31', '2026-01-16 17:25:31', '2026-01-16 17:25:31'),
(226, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-17 01:04:19', '2026-01-17 01:04:19', '2026-01-17 01:04:19'),
(227, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-17 01:59:45', '2026-01-17 01:59:45', '2026-01-17 01:59:45'),
(228, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-17 02:19:31', '2026-01-17 02:19:31', '2026-01-17 02:19:31'),
(229, NULL, 'uno@estdiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-17 02:24:46', '2026-01-17 02:24:46', '2026-01-17 02:24:46'),
(230, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-17 02:25:29', '2026-01-17 02:25:29', '2026-01-17 02:25:29'),
(231, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 16:38:00', '2026-01-19 16:38:00', '2026-01-19 16:38:00'),
(232, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-19 17:13:58', '2026-01-19 17:13:58', '2026-01-19 17:13:58'),
(233, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-19 17:14:09', '2026-01-19 17:14:09', '2026-01-19 17:14:09'),
(234, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 18:55:22', '2026-01-19 18:55:22', '2026-01-19 18:55:22'),
(235, 37, 'dos@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 18:55:56', '2026-01-19 18:55:56', '2026-01-19 18:55:56'),
(236, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'failed', 'verified', 'Credenciales inválidas', '2026-01-19 18:56:47', '2026-01-19 18:56:47', '2026-01-19 18:56:47'),
(237, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 18:56:53', '2026-01-19 18:56:53', '2026-01-19 18:56:53'),
(238, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 18:57:41', '2026-01-19 18:57:41', '2026-01-19 18:57:41'),
(239, 37, 'dos@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:00:44', '2026-01-19 19:00:44', '2026-01-19 19:00:44'),
(240, 46, 'tres@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'unverified', NULL, '2026-01-19 19:01:18', '2026-01-19 19:01:18', '2026-01-19 19:01:18'),
(241, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:03:30', '2026-01-19 19:03:30', '2026-01-19 19:03:30'),
(242, 37, 'dos@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:10:29', '2026-01-19 19:10:29', '2026-01-19 19:10:29'),
(243, 46, 'tres@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:11:24', '2026-01-19 19:11:24', '2026-01-19 19:11:24'),
(244, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'failed', 'verified', 'Credenciales inválidas', '2026-01-19 19:12:07', '2026-01-19 19:12:07', '2026-01-19 19:12:07'),
(245, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:12:12', '2026-01-19 19:12:12', '2026-01-19 19:12:12'),
(246, 46, 'tres@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:14:00', '2026-01-19 19:14:00', '2026-01-19 19:14:00'),
(247, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:14:32', '2026-01-19 19:14:32', '2026-01-19 19:14:32'),
(248, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 19:14:53', '2026-01-19 19:14:53', '2026-01-19 19:14:53'),
(249, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 20:27:51', '2026-01-19 20:27:51', '2026-01-19 20:27:51'),
(250, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 20:31:34', '2026-01-19 20:31:34', '2026-01-19 20:31:34'),
(251, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 20:49:37', '2026-01-19 20:49:37', '2026-01-19 20:49:37'),
(252, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 21:13:02', '2026-01-19 21:13:02', '2026-01-19 21:13:02'),
(253, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 21:25:54', '2026-01-19 21:25:54', '2026-01-19 21:25:54'),
(254, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-19 21:27:01', '2026-01-19 21:27:01', '2026-01-19 21:27:01'),
(255, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-20 00:34:27', '2026-01-20 00:34:27', '2026-01-20 00:34:27'),
(256, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', 'success', 'verified', NULL, '2026-01-20 16:32:11', '2026-01-20 16:32:11', '2026-01-20 16:32:11'),
(257, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-20 17:42:57', '2026-01-20 17:42:57', '2026-01-20 17:42:57'),
(258, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-20 17:55:02', '2026-01-20 17:55:02', '2026-01-20 17:55:02'),
(259, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-20 18:00:06', '2026-01-20 18:00:06', '2026-01-20 18:00:06'),
(260, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-20 20:24:55', '2026-01-20 20:24:55', '2026-01-20 20:24:55'),
(261, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 02:57:37', '2026-01-21 02:57:37', '2026-01-21 02:57:37'),
(262, NULL, 'carjavalosistemq@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-21 16:46:10', '2026-01-21 16:46:10', '2026-01-21 16:46:10'),
(263, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 16:46:20', '2026-01-21 16:46:20', '2026-01-21 16:46:20'),
(264, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 17:00:59', '2026-01-21 17:00:59', '2026-01-21 17:00:59'),
(265, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 19:29:18', '2026-01-21 19:29:18', '2026-01-21 19:29:18'),
(266, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 19:58:50', '2026-01-21 19:58:50', '2026-01-21 19:58:50'),
(267, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-21 20:18:48', '2026-01-21 20:18:48', '2026-01-21 20:18:48'),
(268, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-21 21:22:14', '2026-01-21 21:22:14', '2026-01-21 21:22:14'),
(269, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 00:11:11', '2026-01-22 00:11:11', '2026-01-22 00:11:11'),
(270, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'verified', 'Credenciales inválidas', '2026-01-22 00:20:36', '2026-01-22 00:20:36', '2026-01-22 00:20:36'),
(271, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 00:20:40', '2026-01-22 00:20:40', '2026-01-22 00:20:40'),
(272, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 01:05:45', '2026-01-22 01:05:45', '2026-01-22 01:05:45'),
(273, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 17:20:18', '2026-01-22 17:20:18', '2026-01-22 17:20:18'),
(274, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:24:50', '2026-01-22 21:24:50', '2026-01-22 21:24:50'),
(275, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:25:19', '2026-01-22 21:25:19', '2026-01-22 21:25:19'),
(276, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:25:51', '2026-01-22 21:25:51', '2026-01-22 21:25:51'),
(277, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:34:07', '2026-01-22 21:34:07', '2026-01-22 21:34:07'),
(278, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:39:33', '2026-01-22 21:39:33', '2026-01-22 21:39:33'),
(279, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-22 21:41:06', '2026-01-22 21:41:06', '2026-01-22 21:41:06'),
(280, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 00:13:31', '2026-01-23 00:13:31', '2026-01-23 00:13:31'),
(281, NULL, 'carjavalossistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-23 01:11:12', '2026-01-23 01:11:12', '2026-01-23 01:11:12'),
(282, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 01:11:20', '2026-01-23 01:11:20', '2026-01-23 01:11:20'),
(283, NULL, 'evarisbothuv@gmail.com', '192.168.2.202', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 01:12:39', '2026-01-23 01:12:39', '2026-01-23 01:12:39'),
(284, NULL, 'asprillaangie222@gmail.com', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 01:22:58', '2026-01-23 01:22:58', '2026-01-23 01:22:58'),
(285, NULL, 'soportesistemasagesochuv@gmail.com', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 01:50:06', '2026-01-23 01:50:06', '2026-01-23 01:50:06'),
(286, NULL, 'soportesistemasagesochuv@gmail.com', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 01:58:12', '2026-01-23 01:58:12', '2026-01-23 01:58:12'),
(287, NULL, 'soportesistemasagesochuv@gmail.com', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 01:59:38', '2026-01-23 01:59:38', '2026-01-23 01:59:38'),
(288, NULL, 'cirugiamujeres@correohuv.gov.co', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 02:07:53', '2026-01-23 02:07:53', '2026-01-23 02:07:53'),
(289, NULL, 'cirugiamujeres@correohuv.gov.co', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 02:22:24', '2026-01-23 02:22:24', '2026-01-23 02:22:24'),
(290, NULL, 'cirugiamujeres@correohuv.gov.co', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 02:23:44', '2026-01-23 02:23:44', '2026-01-23 02:23:44'),
(291, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 16:49:21', '2026-01-23 16:49:21', '2026-01-23 16:49:21'),
(292, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 17:20:26', '2026-01-23 17:20:26', '2026-01-23 17:20:26'),
(293, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 18:06:02', '2026-01-23 18:06:02', '2026-01-23 18:06:02'),
(294, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 18:26:15', '2026-01-23 18:26:15', '2026-01-23 18:26:15'),
(295, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 18:28:31', '2026-01-23 18:28:31', '2026-01-23 18:28:31'),
(296, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 18:29:39', '2026-01-23 18:29:39', '2026-01-23 18:29:39'),
(297, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 18:37:28', '2026-01-23 18:37:28', '2026-01-23 18:37:28'),
(298, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 18:38:54', '2026-01-23 18:38:54', '2026-01-23 18:38:54'),
(299, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 18:45:33', '2026-01-23 18:45:33', '2026-01-23 18:45:33'),
(300, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 18:47:12', '2026-01-23 18:47:12', '2026-01-23 18:47:12'),
(301, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 19:04:37', '2026-01-23 19:04:37', '2026-01-23 19:04:37'),
(302, NULL, 'carjavalo1q@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-23 19:08:15', '2026-01-23 19:08:15', '2026-01-23 19:08:15'),
(303, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 19:08:23', '2026-01-23 19:08:23', '2026-01-23 19:08:23'),
(304, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 19:10:22', '2026-01-23 19:10:22', '2026-01-23 19:10:22'),
(305, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 19:21:04', '2026-01-23 19:21:04', '2026-01-23 19:21:04'),
(306, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-23 19:22:27', '2026-01-23 19:22:27', '2026-01-23 19:22:27'),
(307, NULL, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-23 19:28:14', '2026-01-23 19:28:14', '2026-01-23 19:28:14'),
(308, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 19:57:57', '2026-01-23 19:57:57', '2026-01-23 19:57:57'),
(309, NULL, 'programasdeextensionhuv@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 20:02:54', '2026-01-23 20:02:54', '2026-01-23 20:02:54'),
(310, NULL, 'programasdeextensionhuv@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 20:03:19', '2026-01-23 20:03:19', '2026-01-23 20:03:19'),
(311, NULL, 'programasdeextensionhuv@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:04:16', '2026-01-23 20:04:16', '2026-01-23 20:04:16'),
(312, NULL, 'jandrescarrillo@estudiante.uniajc.edu.co', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 20:08:16', '2026-01-23 20:08:16', '2026-01-23 20:08:16'),
(313, NULL, 'jandrescarrillo@estudiante.uniajc.edu.co', '192.168.30.60', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'success', 'unverified', NULL, '2026-01-23 20:09:19', '2026-01-23 20:09:19', '2026-01-23 20:09:19'),
(314, NULL, 'jandrescarrillo@estudiante.uniajc.edu.co', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:09:37', '2026-01-23 20:09:37', '2026-01-23 20:09:37'),
(315, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:19:20', '2026-01-23 20:19:20', '2026-01-23 20:19:20'),
(316, NULL, 'jandrescarrillo@estudiante.uniajc.edu.co', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-23 20:30:45', '2026-01-23 20:30:45', '2026-01-23 20:30:45'),
(317, NULL, 'jandrescarrillo@estudiante.uniajc.edu.co', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-01-23 20:30:45', '2026-01-23 20:30:45', '2026-01-23 20:30:45'),
(318, 36, 'uno@estudiante.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:33:09', '2026-01-23 20:33:09', '2026-01-23 20:33:09'),
(319, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:34:20', '2026-01-23 20:34:20', '2026-01-23 20:34:20'),
(320, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:40:57', '2026-01-23 20:40:57', '2026-01-23 20:40:57'),
(321, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:45:47', '2026-01-23 20:45:47', '2026-01-23 20:45:47'),
(322, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 20:46:00', '2026-01-23 20:46:00', '2026-01-23 20:46:00'),
(323, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-23 23:00:01', '2026-01-23 23:00:01', '2026-01-23 23:00:01'),
(324, NULL, 'lan2605@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-24 02:03:33', '2026-01-24 02:03:33', '2026-01-24 02:03:33'),
(325, NULL, 'lan2605@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-24 02:05:37', '2026-01-24 02:05:37', '2026-01-24 02:05:37'),
(326, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-24 02:09:32', '2026-01-24 02:09:32', '2026-01-24 02:09:32'),
(327, 63, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-24 02:11:08', '2026-01-24 02:11:08', '2026-01-24 02:11:08'),
(328, 63, 'carjavalo1@hotmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-01-24 02:12:09', '2026-01-24 02:12:09', '2026-01-24 02:12:09'),
(329, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-27 00:02:29', '2026-01-27 00:02:29', '2026-01-27 00:02:29'),
(330, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-27 00:02:47', '2026-01-27 00:02:47', '2026-01-27 00:02:47'),
(331, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-27 01:30:52', '2026-01-27 01:30:52', '2026-01-27 01:30:52'),
(332, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 01:53:59', '2026-01-28 01:53:59', '2026-01-28 01:53:59'),
(333, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 01:54:01', '2026-01-28 01:54:01', '2026-01-28 01:54:01'),
(334, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 01:54:05', '2026-01-28 01:54:05', '2026-01-28 01:54:05'),
(335, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 01:54:11', '2026-01-28 01:54:11', '2026-01-28 01:54:11'),
(336, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 01:54:21', '2026-01-28 01:54:21', '2026-01-28 01:54:21'),
(337, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 23:58:52', '2026-01-28 23:58:52', '2026-01-28 23:58:52'),
(338, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-28 23:59:10', '2026-01-28 23:59:10', '2026-01-28 23:59:10'),
(339, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-29 01:17:14', '2026-01-29 01:17:14', '2026-01-29 01:17:14'),
(340, 1, 'carjavalosistem@gmail.com', '127.0.0.1', 'Symfony', 'success', 'verified', NULL, '2026-01-29 01:18:33', '2026-01-29 01:18:33', '2026-01-29 01:18:33'),
(341, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-01-29 01:32:55', '2026-01-29 01:32:55', '2026-01-29 01:32:55'),
(342, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-01-29 01:38:36', '2026-01-29 01:38:36', '2026-01-29 01:38:36'),
(343, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-02 17:19:45', '2026-02-02 17:19:45', '2026-02-02 17:19:45'),
(344, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-03 18:26:41', '2026-02-03 18:26:41', '2026-02-03 18:26:41'),
(345, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-03 18:32:09', '2026-02-03 18:32:09', '2026-02-03 18:32:09'),
(346, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-03 19:03:53', '2026-02-03 19:03:53', '2026-02-03 19:03:53'),
(347, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-03 19:04:17', '2026-02-03 19:04:17', '2026-02-03 19:04:17'),
(348, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'success', 'verified', NULL, '2026-02-03 21:32:01', '2026-02-03 21:32:01', '2026-02-03 21:32:01'),
(349, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-03 23:39:42', '2026-02-03 23:39:42', '2026-02-03 23:39:42'),
(350, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-04 00:35:28', '2026-02-04 00:35:28', '2026-02-04 00:35:28'),
(351, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-04 01:02:49', '2026-02-04 01:02:49', '2026-02-04 01:02:49'),
(352, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-04 20:21:21', '2026-02-04 20:21:21', '2026-02-04 20:21:21'),
(353, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-04 20:24:11', '2026-02-04 20:24:11', '2026-02-04 20:24:11'),
(354, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-05 00:22:33', '2026-02-05 00:22:33', '2026-02-05 00:22:33'),
(355, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 01:28:46', '2026-02-05 01:28:46', '2026-02-05 01:28:46'),
(356, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 01:56:44', '2026-02-05 01:56:44', '2026-02-05 01:56:44'),
(357, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-05 17:26:26', '2026-02-05 17:26:26', '2026-02-05 17:26:26'),
(358, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 20:37:44', '2026-02-05 20:37:44', '2026-02-05 20:37:44'),
(359, NULL, 'cuatro@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'unverified', NULL, '2026-02-05 20:58:29', '2026-02-05 20:58:29', '2026-02-05 20:58:29'),
(360, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-05 21:26:31', '2026-02-05 21:26:31', '2026-02-05 21:26:31'),
(361, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 21:48:54', '2026-02-05 21:48:54', '2026-02-05 21:48:54'),
(362, NULL, 'cuatro@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-05 21:55:23', '2026-02-05 21:55:23', '2026-02-05 21:55:23'),
(363, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-05 23:19:36', '2026-02-05 23:19:36', '2026-02-05 23:19:36'),
(364, NULL, 'cinco@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 23:31:03', '2026-02-05 23:31:03', '2026-02-05 23:31:03'),
(365, 76, 'cuatro@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 23:49:22', '2026-02-05 23:49:22', '2026-02-05 23:49:22'),
(366, 74, 'cinco@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-02-05 23:50:05', '2026-02-05 23:50:05', '2026-02-05 23:50:05'),
(367, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-06 02:22:59', '2026-02-06 02:22:59', '2026-02-06 02:22:59'),
(368, NULL, 'carjavalosistem@mail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-02-06 23:56:39', '2026-02-06 23:56:39', '2026-02-06 23:56:39'),
(369, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-08 00:48:30', '2026-02-08 00:48:30', '2026-02-08 00:48:30'),
(370, 44, 'touma11913@gmail.com', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-11 00:23:23', '2026-02-11 00:23:23', '2026-02-11 00:23:23'),
(371, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-17 19:04:12', '2026-02-17 19:04:12', '2026-02-17 19:04:12'),
(372, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-02-18 21:32:05', '2026-02-18 21:32:05', '2026-02-18 21:32:05'),
(373, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-05 21:38:44', '2026-03-05 21:38:44', '2026-03-05 21:38:44'),
(374, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-09 17:45:27', '2026-03-09 17:45:27', '2026-03-09 17:45:27'),
(375, NULL, 'carjavalosiste@mail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-03-10 00:54:34', '2026-03-10 00:54:34', '2026-03-10 00:54:34'),
(376, NULL, 'carjavalosistem@mail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-03-10 00:54:42', '2026-03-10 00:54:42', '2026-03-10 00:54:42'),
(377, NULL, 'carjavalosistem@mail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'failed', 'unverified', 'Credenciales inválidas', '2026-03-10 00:54:55', '2026-03-10 00:54:55', '2026-03-10 00:54:55'),
(378, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 00:55:15', '2026-03-10 00:55:15', '2026-03-10 00:55:15');
INSERT INTO `user_logins` (`id`, `user_id`, `email`, `ip_address`, `user_agent`, `status`, `email_verified`, `failure_reason`, `attempted_at`, `created_at`, `updated_at`) VALUES
(379, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 01:51:44', '2026-03-10 01:51:44', '2026-03-10 01:51:44'),
(380, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 02:42:35', '2026-03-10 02:42:35', '2026-03-10 02:42:35'),
(381, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-10 03:17:49', '2026-03-10 03:17:49', '2026-03-10 03:17:49'),
(382, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 16:54:21', '2026-03-10 16:54:21', '2026-03-10 16:54:21'),
(383, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 17:09:20', '2026-03-10 17:09:20', '2026-03-10 17:09:20'),
(384, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 19:58:31', '2026-03-10 19:58:31', '2026-03-10 19:58:31'),
(385, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-10 20:53:06', '2026-03-10 20:53:06', '2026-03-10 20:53:06'),
(386, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-11 01:07:56', '2026-03-11 01:07:56', '2026-03-11 01:07:56'),
(387, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-11 23:03:41', '2026-03-11 23:03:41', '2026-03-11 23:03:41'),
(388, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-11 23:13:46', '2026-03-11 23:13:46', '2026-03-11 23:13:46'),
(389, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-12 03:02:33', '2026-03-12 03:02:33', '2026-03-12 03:02:33'),
(390, 45, 'uno@docente.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'unverified', NULL, '2026-03-12 03:03:49', '2026-03-12 03:03:49', '2026-03-12 03:03:49'),
(391, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 17:09:36', '2026-03-12 17:09:36', '2026-03-12 17:09:36'),
(392, 1, 'carjavalosistem@gmail.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'success', 'verified', NULL, '2026-03-12 17:09:58', '2026-03-12 17:09:58', '2026-03-12 17:09:58'),
(393, 45, 'uno@docente.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 17:11:33', '2026-03-12 17:11:33', '2026-03-12 17:11:33'),
(394, 46, 'tres@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 18:15:28', '2026-03-12 18:15:28', '2026-03-12 18:15:28'),
(395, 45, 'uno@docente.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 20:56:50', '2026-03-12 20:56:50', '2026-03-12 20:56:50'),
(396, 46, 'tres@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 20:57:49', '2026-03-12 20:57:49', '2026-03-12 20:57:49'),
(397, 45, 'uno@docente.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 20:58:39', '2026-03-12 20:58:39', '2026-03-12 20:58:39'),
(398, 36, 'uno@estudiante.com', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', 'success', 'verified', NULL, '2026-03-12 20:59:22', '2026-03-12 20:59:22', '2026-03-12 20:59:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_operations`
--

CREATE TABLE `user_operations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `operation_type` varchar(50) NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`details`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_operations`
--

INSERT INTO `user_operations` (`id`, `user_id`, `operation_type`, `entity_type`, `entity_id`, `description`, `details`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-05 21:38:56\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 02:38:56', '2026-01-06 02:38:56'),
(2, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-06 11:39:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 16:39:34', '2026-01-06 16:39:34'),
(3, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 12:39:36\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 17:39:36', '2026-01-06 17:39:36'),
(4, 46, 'login', 'Session', NULL, 'Inicio de sesión: programasdeextensionhuv@gmail.com', '{\"email\":\"programasdeextensionhuv@gmail.com\",\"login_time\":\"2026-01-06 12:39:57\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 17:39:57', '2026-01-06 17:39:57'),
(5, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 12:47:03\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 17:47:03', '2026-01-06 17:47:03'),
(6, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-06 12:47:08\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 17:47:08', '2026-01-06 17:47:08'),
(7, 44, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Prueba D', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Prueba D\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-01-06 13:52:10\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:52:10', '2026-01-06 18:52:10'),
(8, 44, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: Prueba D', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Prueba D\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-06 13:52:10\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:52:10', '2026-01-06 18:52:10'),
(9, 44, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-06 13:53:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:53:16', '2026-01-06 18:53:16'),
(10, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 13:55:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:55:21', '2026-01-06 18:55:21'),
(11, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-06 13:55:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:55:29', '2026-01-06 18:55:29'),
(12, 44, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-01-06 13:56:55\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:56:55', '2026-01-06 18:56:55'),
(13, 36, 'enroll', 'Curso', 14, 'Inscripción al curso: Hemato Oncología', '{\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_inscripcion\":\"2026-01-06 13:58:16\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 18:58:16', '2026-01-06 18:58:16'),
(14, 36, 'view', 'Material', 44, 'Visualización de material: MODULO 1', '{\"material_titulo\":\"MODULO 1\",\"curso_id\":14,\"fecha_visualizacion\":\"2026-01-06 14:27:06\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 19:27:06', '2026-01-06 19:27:06'),
(15, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 14:56:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 19:56:40', '2026-01-06 19:56:40'),
(16, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-06 14:56:48\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 19:56:48', '2026-01-06 19:56:48'),
(17, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-06 16:17:57\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:17:57', '2026-01-06 21:17:57'),
(18, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 16:20:53\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:20:53', '2026-01-06 21:20:53'),
(19, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-06 16:21:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:21:16', '2026-01-06 21:21:16'),
(20, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 16:21:50\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:21:50', '2026-01-06 21:21:50'),
(21, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-06 16:22:10\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:22:10', '2026-01-06 21:22:10'),
(22, 44, 'create', 'Asignacion', 15, 'Asignación de curso \'Inducción 2026\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":15,\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_asignacion\":\"2026-01-06 16:22:31\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:22:31', '2026-01-06 21:22:31'),
(23, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 16:22:47\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:22:47', '2026-01-06 21:22:47'),
(24, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-06 16:23:01\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:23:01', '2026-01-06 21:23:01'),
(25, 36, 'enroll', 'Curso', 15, 'Inscripción al curso: Inducción 2026', '{\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_inscripcion\":\"2026-01-06 16:23:18\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:23:18', '2026-01-06 21:23:18'),
(26, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-06 16:24:39\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-06 21:24:39', '2026-01-06 21:24:39'),
(27, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-15 14:00:24\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-15 19:00:24', '2026-01-15 19:00:24'),
(28, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-15 14:17:43\"}', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 19:17:43', '2026-01-15 19:17:43'),
(29, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-15 14:19:03\"}', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 19:19:03', '2026-01-15 19:19:03'),
(30, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-15 14:19:29\"}', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 19:19:29', '2026-01-15 19:19:29'),
(31, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-15 14:20:09\"}', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 19:20:09', '2026-01-15 19:20:09'),
(32, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-15 14:20:20\"}', '192.168.30.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-15 19:20:20', '2026-01-15 19:20:20'),
(33, 1, 'create', 'Asignacion', 15, 'Asignación de curso \'Inducción 2026\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":15,\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_asignacion\":\"2026-01-15 14:38:52\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-15 19:38:52', '2026-01-15 19:38:52'),
(34, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-15 15:58:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-15 20:58:37', '2026-01-15 20:58:37'),
(35, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-15 16:39:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-15 21:39:40', '2026-01-15 21:39:40'),
(36, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-16 12:12:56\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-16 17:12:56', '2026-01-16 17:12:56'),
(37, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-16 20:03:30\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-17 01:03:30', '2026-01-17 01:03:30'),
(38, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-16 20:04:19\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-17 01:04:19', '2026-01-17 01:04:19'),
(39, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-01-16 20:48:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-17 01:48:37', '2026-01-17 01:48:37'),
(40, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-16 20:59:45\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 01:59:45', '2026-01-17 01:59:45'),
(41, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-16 21:07:20\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 02:07:20', '2026-01-17 02:07:20'),
(42, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-16 21:19:31\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-17 02:19:31', '2026-01-17 02:19:31'),
(43, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-16 21:24:18\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-17 02:24:18', '2026-01-17 02:24:18'),
(44, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-16 21:25:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-17 02:25:29', '2026-01-17 02:25:29'),
(45, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 11:38:00\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 16:38:00', '2026-01-19 16:38:00'),
(46, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 12:14:05\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-19 17:14:05', '2026-01-19 17:14:05'),
(47, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-19 12:14:09\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-19 17:14:09', '2026-01-19 17:14:09'),
(48, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 13:55:08\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:55:08', '2026-01-19 18:55:08'),
(49, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-19 13:55:22\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:55:22', '2026-01-19 18:55:22'),
(50, 36, 'enroll', 'Curso', 15, 'Inscripción al curso: Inducción 2026', '{\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_inscripcion\":\"2026-01-19 13:55:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:55:36', '2026-01-19 18:55:36'),
(51, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 13:55:42\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:55:42', '2026-01-19 18:55:42'),
(52, 37, 'login', 'Session', NULL, 'Inicio de sesión: dos@estudiante.com', '{\"email\":\"dos@estudiante.com\",\"login_time\":\"2026-01-19 13:55:56\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:55:56', '2026-01-19 18:55:56'),
(53, 37, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 13:56:16\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:56:16', '2026-01-19 18:56:16'),
(54, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 13:56:53\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:56:53', '2026-01-19 18:56:53'),
(55, 1, 'create', 'Asignacion', 15, 'Asignación de curso \'Inducción 2026\' al estudiante: Estudiante dos', '{\"estudiante_id\":37,\"estudiante_nombre\":\"Estudiante dos\",\"curso_id\":15,\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_asignacion\":\"2026-01-19 13:57:18\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:57:18', '2026-01-19 18:57:18'),
(56, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 13:57:33\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:57:33', '2026-01-19 18:57:33'),
(57, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 13:57:41\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 18:57:41', '2026-01-19 18:57:41'),
(58, 1, 'create', 'Asignacion', 15, 'Asignación de curso \'Inducción 2026\' al estudiante: tres Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"tres Estudiante\",\"curso_id\":15,\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_asignacion\":\"2026-01-19 14:00:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:00:23', '2026-01-19 19:00:23'),
(59, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:00:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:00:27', '2026-01-19 19:00:27'),
(60, 37, 'login', 'Session', NULL, 'Inicio de sesión: dos@estudiante.com', '{\"email\":\"dos@estudiante.com\",\"login_time\":\"2026-01-19 14:00:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:00:44', '2026-01-19 19:00:44'),
(61, 37, 'enroll', 'Curso', 15, 'Inscripción al curso: Inducción 2026', '{\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_inscripcion\":\"2026-01-19 14:00:51\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:00:51', '2026-01-19 19:00:51'),
(62, 37, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:00:57\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:00:57', '2026-01-19 19:00:57'),
(63, 46, 'login', 'Session', NULL, 'Inicio de sesión: tres@estudiante.com', '{\"email\":\"tres@estudiante.com\",\"login_time\":\"2026-01-19 14:01:18\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:01:18', '2026-01-19 19:01:18'),
(64, 46, 'enroll', 'Curso', 15, 'Inscripción al curso: Inducción 2026', '{\"curso_titulo\":\"Inducci\\u00f3n 2026\",\"fecha_inscripcion\":\"2026-01-19 14:02:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:02:36', '2026-01-19 19:02:36'),
(65, 46, 'enroll', 'Curso', 13, 'Inscripción al curso: Reanimación Cardiopulmonar(RCP)', '{\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_inscripcion\":\"2026-01-19 14:02:43\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:02:43', '2026-01-19 19:02:43'),
(66, 46, 'enroll', 'Curso', 14, 'Inscripción al curso: Hemato Oncología', '{\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_inscripcion\":\"2026-01-19 14:02:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:02:45', '2026-01-19 19:02:45'),
(67, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:03:24\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:03:24', '2026-01-19 19:03:24'),
(68, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 14:03:30\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:03:30', '2026-01-19 19:03:30'),
(69, 1, 'asignacion_masiva', 'Curso', 17, 'Asignación masiva del curso \'pagos\' a 2 estudiantes', '{\"curso_id\":17,\"curso_titulo\":\"pagos\",\"total_estudiantes\":3,\"asignados\":2,\"reasignados\":0,\"ya_asignados\":1,\"ya_inscritos\":0}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:09:32', '2026-01-19 19:09:32'),
(70, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:10:11\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:10:11', '2026-01-19 19:10:11'),
(71, 37, 'login', 'Session', NULL, 'Inicio de sesión: dos@estudiante.com', '{\"email\":\"dos@estudiante.com\",\"login_time\":\"2026-01-19 14:10:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:10:29', '2026-01-19 19:10:29'),
(72, 37, 'enroll', 'Curso', 17, 'Inscripción al curso: pagos', '{\"curso_titulo\":\"pagos\",\"fecha_inscripcion\":\"2026-01-19 14:10:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:10:37', '2026-01-19 19:10:37'),
(73, 37, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:11:10\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:11:10', '2026-01-19 19:11:10'),
(74, 46, 'login', 'Session', NULL, 'Inicio de sesión: tres@estudiante.com', '{\"email\":\"tres@estudiante.com\",\"login_time\":\"2026-01-19 14:11:24\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:11:24', '2026-01-19 19:11:24'),
(75, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:11:55\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:11:55', '2026-01-19 19:11:55'),
(76, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 14:12:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:12:12', '2026-01-19 19:12:12'),
(77, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:13:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:13:44', '2026-01-19 19:13:44'),
(78, 46, 'login', 'Session', NULL, 'Inicio de sesión: tres@estudiante.com', '{\"email\":\"tres@estudiante.com\",\"login_time\":\"2026-01-19 14:14:00\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:00', '2026-01-19 19:14:00'),
(79, 46, 'enroll', 'Curso', 17, 'Inscripción al curso: pagos', '{\"curso_titulo\":\"pagos\",\"fecha_inscripcion\":\"2026-01-19 14:14:08\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:08', '2026-01-19 19:14:08'),
(80, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:14:17\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:17', '2026-01-19 19:14:17'),
(81, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-19 14:14:32\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:32', '2026-01-19 19:14:32'),
(82, 36, 'enroll', 'Curso', 17, 'Inscripción al curso: pagos', '{\"curso_titulo\":\"pagos\",\"fecha_inscripcion\":\"2026-01-19 14:14:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:40', '2026-01-19 19:14:40'),
(83, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 14:14:47\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:47', '2026-01-19 19:14:47'),
(84, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 14:14:53\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 19:14:53', '2026-01-19 19:14:53'),
(85, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 15:27:26\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:27:26', '2026-01-19 20:27:26'),
(86, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-19 15:27:51\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:27:51', '2026-01-19 20:27:51'),
(87, 36, 'view', 'Material', 66, 'Visualización de material: Preliquidacion', '{\"material_titulo\":\"Preliquidacion\",\"curso_id\":17,\"fecha_visualizacion\":\"2026-01-19 15:29:07\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:29:07', '2026-01-19 20:29:07'),
(88, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 15:31:25\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:31:25', '2026-01-19 20:31:25'),
(89, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 15:31:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:31:34', '2026-01-19 20:31:34'),
(90, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 15:47:55\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:47:55', '2026-01-19 20:47:55'),
(91, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-19 15:49:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 20:49:37', '2026-01-19 20:49:37'),
(92, 36, 'submit', 'Actividad', 32, 'Entrega de actividad: Preliquidar 1', '{\"actividad_titulo\":\"Preliquidar 1\",\"curso_id\":17,\"fecha_entrega\":\"2026-01-19 16:03:20\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:03:20', '2026-01-19 21:03:20'),
(93, 36, 'submit', 'Actividad', 33, 'Entrega de actividad: preliquidar 2', '{\"actividad_titulo\":\"preliquidar 2\",\"curso_id\":17,\"fecha_entrega\":\"2026-01-19 16:06:43\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:06:43', '2026-01-19 21:06:43'),
(94, 36, 'view', 'Material', 67, 'Visualización de material: Liquidar', '{\"material_titulo\":\"Liquidar\",\"curso_id\":17,\"fecha_visualizacion\":\"2026-01-19 16:07:04\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:07:04', '2026-01-19 21:07:04'),
(95, 36, 'submit', 'Actividad', 34, 'Entrega de actividad: liquidacion 1', '{\"actividad_titulo\":\"liquidacion 1\",\"curso_id\":17,\"fecha_entrega\":\"2026-01-19 16:11:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:11:36', '2026-01-19 21:11:36'),
(96, 36, 'view', 'Material', 68, 'Visualización de material: Post Liquidar', '{\"material_titulo\":\"Post Liquidar\",\"curso_id\":17,\"fecha_visualizacion\":\"2026-01-19 16:11:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:11:46', '2026-01-19 21:11:46'),
(97, 36, 'submit', 'Actividad', 35, 'Entrega de actividad: Liquidacion2', '{\"actividad_titulo\":\"Liquidacion2\",\"curso_id\":17,\"fecha_entrega\":\"2026-01-19 16:12:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:12:12', '2026-01-19 21:12:12'),
(98, 36, 'submit', 'Actividad', 36, 'Entrega de actividad: Pos liquidar 1', '{\"actividad_titulo\":\"Pos liquidar 1\",\"curso_id\":17,\"fecha_entrega\":\"2026-01-19 16:12:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:12:39', '2026-01-19 21:12:39'),
(99, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 16:12:56\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:12:56', '2026-01-19 21:12:56'),
(100, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 16:13:02\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:13:02', '2026-01-19 21:13:02'),
(101, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 16:25:41\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:25:41', '2026-01-19 21:25:41'),
(102, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-19 16:25:54\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:25:54', '2026-01-19 21:25:54'),
(103, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-19 16:26:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:26:23', '2026-01-19 21:26:23'),
(104, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 16:27:01\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-19 21:27:01', '2026-01-19 21:27:01'),
(105, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-19 19:34:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-20 00:34:27', '2026-01-20 00:34:27'),
(106, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-20 11:32:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:146.0) Gecko/20100101 Firefox/146.0', '2026-01-20 16:32:12', '2026-01-20 16:32:12'),
(107, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-20 12:55:02\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-20 17:55:02', '2026-01-20 17:55:02'),
(108, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-20 13:00:06\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-20 18:00:06', '2026-01-20 18:00:06'),
(109, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-20 13:16:12\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-20 18:16:12', '2026-01-20 18:16:12'),
(110, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-20 15:24:55\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-20 20:24:55', '2026-01-20 20:24:55'),
(111, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-21 11:46:20\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 16:46:20', '2026-01-21 16:46:20'),
(112, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-21 12:00:20\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 17:00:20', '2026-01-21 17:00:20'),
(113, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-21 12:00:59\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 17:00:59', '2026-01-21 17:00:59'),
(114, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-21 14:29:18\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 19:29:18', '2026-01-21 19:29:18'),
(115, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-21 14:58:50\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 19:58:50', '2026-01-21 19:58:50'),
(116, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-21 14:59:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 19:59:37', '2026-01-21 19:59:37'),
(117, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-21 15:18:48\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-21 20:18:48', '2026-01-21 20:18:48'),
(118, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-21 16:22:14\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-21 21:22:14', '2026-01-21 21:22:14'),
(119, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-21 19:19:22\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 00:19:22', '2026-01-22 00:19:22'),
(120, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-21 19:20:40\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 00:20:40', '2026-01-22 00:20:40'),
(121, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-21 19:29:27\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 00:29:27', '2026-01-22 00:29:27'),
(122, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-21 20:05:45\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 01:05:45', '2026-01-22 01:05:45'),
(123, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:24:38\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:24:38', '2026-01-22 21:24:38'),
(124, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-22 16:24:50\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:24:50', '2026-01-22 21:24:50'),
(125, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:25:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:25:16', '2026-01-22 21:25:16'),
(126, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-22 16:25:19\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:25:19', '2026-01-22 21:25:19'),
(127, 44, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-22 16:25:37\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:25:37', '2026-01-22 21:25:37'),
(128, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:25:41\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:25:41', '2026-01-22 21:25:41'),
(129, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-22 16:25:51\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:25:51', '2026-01-22 21:25:51'),
(130, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:34:01\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:34:01', '2026-01-22 21:34:01'),
(131, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-22 16:34:07\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:34:07', '2026-01-22 21:34:07'),
(132, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:39:03\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:39:03', '2026-01-22 21:39:03'),
(133, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-22 16:39:33\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:39:33', '2026-01-22 21:39:33'),
(134, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 16:40:41\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:40:41', '2026-01-22 21:40:41'),
(135, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-22 16:41:06\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-22 21:41:06', '2026-01-22 21:41:06'),
(136, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-22 19:13:31\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 00:13:31', '2026-01-23 00:13:31'),
(137, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 19:14:05\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 00:14:05', '2026-01-23 00:14:05'),
(138, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-22 20:11:20\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 01:11:20', '2026-01-23 01:11:20'),
(139, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 20:51:11\"}', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 01:51:11', '2026-01-23 01:51:11'),
(140, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 20:59:21\"}', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 01:59:21', '2026-01-23 01:59:21'),
(141, NULL, 'login', 'Session', NULL, 'Inicio de sesión: soportesistemasagesochuv@gmail.com', '{\"email\":\"soportesistemasagesochuv@gmail.com\",\"login_time\":\"2026-01-22 20:59:38\"}', '192.168.2.135', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 01:59:38', '2026-01-23 01:59:38'),
(142, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: angie asprilla', '{\"estudiante_id\":51,\"estudiante_nombre\":\"angie asprilla\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-22 21:11:47\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 02:11:47', '2026-01-23 02:11:47'),
(143, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 21:13:09\"}', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 02:13:09', '2026-01-23 02:13:09'),
(144, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 21:23:08\"}', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 02:23:08', '2026-01-23 02:23:08'),
(145, NULL, 'login', 'Session', NULL, 'Inicio de sesión: cirugiamujeres@correohuv.gov.co', '{\"email\":\"cirugiamujeres@correohuv.gov.co\",\"login_time\":\"2026-01-22 21:23:44\"}', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 02:23:44', '2026-01-23 02:23:44'),
(146, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: angie asprilla', '{\"estudiante_id\":52,\"estudiante_nombre\":\"angie asprilla\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-22 21:24:38\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 02:24:38', '2026-01-23 02:24:38'),
(147, NULL, 'view', 'Material', 69, 'Visualización de material: 1. DIRECCIONAMIENTO ESTRATÉGICO', '{\"material_titulo\":\"1. DIRECCIONAMIENTO ESTRAT\\u00c9GICO\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-22 21:28:19\"}', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 02:28:19', '2026-01-23 02:28:19'),
(148, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 21:28:53\"}', '192.168.161.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-01-23 02:28:53', '2026-01-23 02:28:53'),
(149, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-22 21:29:47\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 02:29:47', '2026-01-23 02:29:47'),
(150, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 11:46:41\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 16:46:41', '2026-01-23 16:46:41'),
(151, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-23 11:49:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 16:49:21', '2026-01-23 16:49:21'),
(152, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-23 12:20:26\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 17:20:26', '2026-01-23 17:20:26'),
(153, 1, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-23 12:23:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 17:23:23', '2026-01-23 17:23:23'),
(154, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 12:38:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 17:38:23', '2026-01-23 17:38:23'),
(155, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 12:38:56\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 17:38:56', '2026-01-23 17:38:56'),
(156, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 13:26:00\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:26:00', '2026-01-23 18:26:00'),
(157, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-23 13:26:15\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 18:26:15', '2026-01-23 18:26:15'),
(158, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 13:28:33\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:28:33', '2026-01-23 18:28:33'),
(159, NULL, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 13:29:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:29:39', '2026-01-23 18:29:39');
INSERT INTO `user_operations` (`id`, `user_id`, `operation_type`, `entity_type`, `entity_id`, `description`, `details`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(160, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 13:38:17\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:38:17', '2026-01-23 18:38:17'),
(161, NULL, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 13:38:54\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:38:54', '2026-01-23 18:38:54'),
(162, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 13:46:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:46:21', '2026-01-23 18:46:21'),
(163, NULL, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 13:47:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:47:12', '2026-01-23 18:47:12'),
(164, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 13:48:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 18:48:39', '2026-01-23 18:48:39'),
(165, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:07:16\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:07:16', '2026-01-23 19:07:16'),
(166, NULL, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 14:08:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:08:23', '2026-01-23 19:08:23'),
(167, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: yoyo yamin', '{\"estudiante_id\":57,\"estudiante_nombre\":\"yoyo yamin\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-23 14:08:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:08:39', '2026-01-23 19:08:39'),
(168, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:09:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:09:46', '2026-01-23 19:09:46'),
(169, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-23 14:10:22\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:10:22', '2026-01-23 19:10:22'),
(170, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-01-23 14:11:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:11:21', '2026-01-23 19:11:21'),
(171, 36, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 14:16:48\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:16:48', '2026-01-23 19:16:48'),
(172, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-23 14:17:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:17:34', '2026-01-23 19:17:34'),
(173, 36, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 14:17:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:17:40', '2026-01-23 19:17:40'),
(174, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-01-23 14:18:16\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:18:16', '2026-01-23 19:18:16'),
(175, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:19:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:19:44', '2026-01-23 19:19:44'),
(176, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:21:43\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:21:43', '2026-01-23 19:21:43'),
(177, NULL, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 14:22:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:22:27', '2026-01-23 19:22:27'),
(178, NULL, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 14:22:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:22:27', '2026-01-23 19:22:27'),
(179, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:25:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:25:39', '2026-01-23 19:25:39'),
(180, NULL, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 14:28:58\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:28:58', '2026-01-23 19:28:58'),
(181, NULL, 'view', 'Material', 69, 'Visualización de material: 1. DIRECCIONAMIENTO ESTRATÉGICO', '{\"material_titulo\":\"1. DIRECCIONAMIENTO ESTRAT\\u00c9GICO\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 14:29:59\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:29:59', '2026-01-23 19:29:59'),
(182, 1, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: julanin pacual', '{\"estudiante_id\":59,\"estudiante_nombre\":\"julanin pacual\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-23 14:35:52\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:35:52', '2026-01-23 19:35:52'),
(183, NULL, 'enroll', 'Curso', 14, 'Inscripción al curso: Hemato Oncología', '{\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_inscripcion\":\"2026-01-23 14:36:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:36:39', '2026-01-23 19:36:39'),
(184, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:38:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-23 19:38:40', '2026-01-23 19:38:40'),
(185, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 14:57:57\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:57:57', '2026-01-23 19:57:57'),
(186, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 14:58:06\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 19:58:06', '2026-01-23 19:58:06'),
(187, NULL, 'login', 'Session', NULL, 'Inicio de sesión: programasdeextensionhuv@gmail.com', '{\"email\":\"programasdeextensionhuv@gmail.com\",\"login_time\":\"2026-01-23 15:03:19\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:03:19', '2026-01-23 20:03:19'),
(188, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:03:36\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:03:36', '2026-01-23 20:03:36'),
(189, NULL, 'login', 'Session', NULL, 'Inicio de sesión: programasdeextensionhuv@gmail.com', '{\"email\":\"programasdeextensionhuv@gmail.com\",\"login_time\":\"2026-01-23 15:04:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:04:16', '2026-01-23 20:04:16'),
(190, NULL, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 15:04:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:04:16', '2026-01-23 20:04:16'),
(191, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: juan salcedo', '{\"estudiante_id\":60,\"estudiante_nombre\":\"juan salcedo\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-01-23 15:05:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:05:12', '2026-01-23 20:05:12'),
(192, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:06:47\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:06:47', '2026-01-23 20:06:47'),
(193, NULL, 'login', 'Session', NULL, 'Inicio de sesión: jandrescarrillo@estudiante.uniajc.edu.co', '{\"email\":\"jandrescarrillo@estudiante.uniajc.edu.co\",\"login_time\":\"2026-01-23 15:09:19\"}', '192.168.30.60', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-23 20:09:19', '2026-01-23 20:09:19'),
(194, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:09:31\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:09:31', '2026-01-23 20:09:31'),
(195, NULL, 'login', 'Session', NULL, 'Inicio de sesión: jandrescarrillo@estudiante.uniajc.edu.co', '{\"email\":\"jandrescarrillo@estudiante.uniajc.edu.co\",\"login_time\":\"2026-01-23 15:09:37\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:09:37', '2026-01-23 20:09:37'),
(196, NULL, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 15:09:52\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:09:52', '2026-01-23 20:09:52'),
(197, 1, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: ANDRES CARRILLO', '{\"estudiante_id\":61,\"estudiante_nombre\":\"ANDRES CARRILLO\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-23 15:11:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:11:34', '2026-01-23 20:11:34'),
(198, NULL, 'enroll', 'Curso', 14, 'Inscripción al curso: Hemato Oncología', '{\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_inscripcion\":\"2026-01-23 15:12:01\"}', '192.168.30.60', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', '2026-01-23 20:12:01', '2026-01-23 20:12:01'),
(199, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 15:19:20\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:19:20', '2026-01-23 20:19:20'),
(200, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:33:00\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:00', '2026-01-23 20:33:00'),
(201, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-01-23 15:33:09\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:09', '2026-01-23 20:33:09'),
(202, 36, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 15:33:17\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:17', '2026-01-23 20:33:17'),
(203, 36, 'view', 'Material', 69, 'Visualización de material: 1. DIRECCIONAMIENTO ESTRATÉGICO', '{\"material_titulo\":\"1. DIRECCIONAMIENTO ESTRAT\\u00c9GICO\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:25\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:25', '2026-01-23 20:33:25'),
(204, 36, 'view', 'Material', 70, 'Visualización de material: 2. GESTIÓN CALIDAD', '{\"material_titulo\":\"2. GESTI\\u00d3N CALIDAD\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:29\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:29', '2026-01-23 20:33:29'),
(205, 36, 'view', 'Material', 71, 'Visualización de material: 3. COORDINACIÓN ACADÉMICA', '{\"material_titulo\":\"3. COORDINACI\\u00d3N ACAD\\u00c9MICA\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:33\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:33', '2026-01-23 20:33:33'),
(206, 36, 'view', 'Material', 71, 'Visualización de material: 3. COORDINACIÓN ACADÉMICA', '{\"material_titulo\":\"3. COORDINACI\\u00d3N ACAD\\u00c9MICA\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:34\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:34', '2026-01-23 20:33:34'),
(207, 36, 'view', 'Material', 72, 'Visualización de material: 4. POLÍTICA DOCENCIA SERVICIO', '{\"material_titulo\":\"4. POL\\u00cdTICA DOCENCIA SERVICIO\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:36\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:36', '2026-01-23 20:33:36'),
(208, 36, 'view', 'Material', 73, 'Visualización de material: 5. POLÍTICA DE GESTIÓN DEL CONOCIMIENTO Y LA INNOVACIÓN', '{\"material_titulo\":\"5. POL\\u00cdTICA DE GESTI\\u00d3N DEL CONOCIMIENTO Y LA INNOVACI\\u00d3N\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:37\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:37', '2026-01-23 20:33:37'),
(209, 36, 'view', 'Material', 74, 'Visualización de material: 6. POLÍTICA DE HUMANIZACIÓN', '{\"material_titulo\":\"6. POL\\u00cdTICA DE HUMANIZACI\\u00d3N\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:39\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:39', '2026-01-23 20:33:39'),
(210, 36, 'view', 'Material', 75, 'Visualización de material: 7. DARUMA', '{\"material_titulo\":\"7. DARUMA\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:41\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:41', '2026-01-23 20:33:41'),
(211, 36, 'view', 'Material', 76, 'Visualización de material: 8. DERECHOS Y DEBERES DEL PACIENTE', '{\"material_titulo\":\"8. DERECHOS Y DEBERES DEL PACIENTE\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:42\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:42', '2026-01-23 20:33:42'),
(212, 36, 'view', 'Material', 77, 'Visualización de material: 9. SEGURIDAD DEL PACIENTE', '{\"material_titulo\":\"9. SEGURIDAD DEL PACIENTE\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:44\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:44', '2026-01-23 20:33:44'),
(213, 36, 'view', 'Material', 78, 'Visualización de material: 10. CONTROL DE INFECCIONES', '{\"material_titulo\":\"10. CONTROL DE INFECCIONES\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:46\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:46', '2026-01-23 20:33:46'),
(214, 36, 'view', 'Material', 79, 'Visualización de material: 11. SEGURIDAD Y SALUD EN EL TRABAJO', '{\"material_titulo\":\"11. SEGURIDAD Y SALUD EN EL TRABAJO\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:47\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:47', '2026-01-23 20:33:47'),
(215, 36, 'view', 'Material', 80, 'Visualización de material: 12. GESTIÓN AMBIENTAL', '{\"material_titulo\":\"12. GESTI\\u00d3N AMBIENTAL\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:49\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:49', '2026-01-23 20:33:49'),
(216, 36, 'view', 'Material', 81, 'Visualización de material: 13. ATENCIÓN QUIRÚRGICA', '{\"material_titulo\":\"13. ATENCI\\u00d3N QUIR\\u00daRGICA\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:51\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:51', '2026-01-23 20:33:51'),
(217, 36, 'view', 'Material', 82, 'Visualización de material: 14. PROGRAMAS SOCIALES', '{\"material_titulo\":\"14. PROGRAMAS SOCIALES\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:52\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:52', '2026-01-23 20:33:52'),
(218, 36, 'view', 'Material', 83, 'Visualización de material: 15. TRABAJO MIMHOS', '{\"material_titulo\":\"15. TRABAJO MIMHOS\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:54\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:54', '2026-01-23 20:33:54'),
(219, 36, 'view', 'Material', 84, 'Visualización de material: 16. LACTANCIA MATERNA', '{\"material_titulo\":\"16. LACTANCIA MATERNA\",\"curso_id\":18,\"fecha_visualizacion\":\"2026-01-23 15:33:56\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:33:56', '2026-01-23 20:33:56'),
(220, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:34:16\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:34:16', '2026-01-23 20:34:16'),
(221, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 15:34:20\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:34:20', '2026-01-23 20:34:20'),
(222, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:40:52\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:40:52', '2026-01-23 20:40:52'),
(223, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 15:40:57\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:40:57', '2026-01-23 20:40:57'),
(224, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 15:45:44\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:45:44', '2026-01-23 20:45:44'),
(225, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 15:45:47\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:45:47', '2026-01-23 20:45:47'),
(226, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-23 15:46:00\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 20:46:00', '2026-01-23 20:46:00'),
(227, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 17:57:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 22:57:09', '2026-01-23 22:57:09'),
(228, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-23 18:00:02\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-23 23:00:02', '2026-01-23 23:00:02'),
(229, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 20:36:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-24 01:36:45', '2026-01-24 01:36:45'),
(230, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 21:05:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:05:23', '2026-01-24 02:05:23'),
(231, NULL, 'login', 'Session', NULL, 'Inicio de sesión: lan2605@hotmail.com', '{\"email\":\"lan2605@hotmail.com\",\"login_time\":\"2026-01-23 21:05:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:05:37', '2026-01-24 02:05:37'),
(232, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 21:07:51\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:07:51', '2026-01-24 02:07:51'),
(233, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-23 21:09:32\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-24 02:09:32', '2026-01-24 02:09:32'),
(234, 63, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 21:11:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:11:36', '2026-01-24 02:11:36'),
(235, 63, 'login', 'Session', NULL, 'Inicio de sesión: carjavalo1@hotmail.com', '{\"email\":\"carjavalo1@hotmail.com\",\"login_time\":\"2026-01-23 21:12:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:12:09', '2026-01-24 02:12:09'),
(236, 63, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-01-23 21:13:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-24 02:13:36', '2026-01-24 02:13:36'),
(237, 1, 'create', 'Asignacion', 14, 'Asignación de curso \'Hemato Oncología\' al estudiante: Julanin pacual', '{\"estudiante_id\":63,\"estudiante_nombre\":\"Julanin pacual\",\"curso_id\":14,\"curso_titulo\":\"Hemato Oncolog\\u00eda\",\"fecha_asignacion\":\"2026-01-23 21:14:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-24 02:14:23', '2026-01-24 02:14:23'),
(238, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-23 21:17:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-24 02:17:36', '2026-01-24 02:17:36'),
(239, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-26 19:02:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-27 00:02:29', '2026-01-27 00:02:29'),
(240, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-26 19:02:47\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-27 00:02:47', '2026-01-27 00:02:47'),
(241, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-01-26 19:37:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-27 00:37:23', '2026-01-27 00:37:23'),
(242, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-01-26 20:30:52\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-27 01:30:52', '2026-01-27 01:30:52'),
(243, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-28 18:58:52\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-28 23:58:52', '2026-01-28 23:58:52'),
(244, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-28 18:59:10\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-28 23:59:10', '2026-01-28 23:59:10'),
(245, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-28 20:17:14\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-29 01:17:14', '2026-01-29 01:17:14'),
(246, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-28 20:32:55\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-01-29 01:32:55', '2026-01-29 01:32:55'),
(247, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-01-28 20:38:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-01-29 01:38:36', '2026-01-29 01:38:36'),
(248, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-03 13:26:41\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-03 18:26:41', '2026-02-03 18:26:41'),
(249, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-03 13:32:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-03 18:32:09', '2026-02-03 18:32:09'),
(250, 44, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-03 14:04:11\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-03 19:04:11', '2026-02-03 19:04:11'),
(251, 44, 'login', 'Session', NULL, 'Inicio de sesión: touma11913@gmail.com', '{\"email\":\"touma11913@gmail.com\",\"login_time\":\"2026-02-03 14:04:17\"}', '192.168.30.60', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-03 19:04:17', '2026-02-03 19:04:17'),
(252, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-02-03 16:32:01\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 21:32:01', '2026-02-03 21:32:01'),
(253, 36, 'submit', 'Quiz', 37, 'Resolución de quiz: Final Post Liquidacion jum - Calificación: 0', '{\"quiz_titulo\":\"Final Post Liquidacion jum\",\"calificacion\":0,\"curso_id\":17,\"fecha_resolucion\":\"2026-02-03 16:43:57\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 21:43:57', '2026-02-03 21:43:57'),
(254, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-03 18:05:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', '2026-02-03 23:05:45', '2026-02-03 23:05:45'),
(255, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-03 18:34:38\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-03 23:34:38', '2026-02-03 23:34:38'),
(256, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-03 18:39:42\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', '2026-02-03 23:39:42', '2026-02-03 23:39:42'),
(257, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-03 20:02:49\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-04 01:02:49', '2026-02-04 01:02:49'),
(258, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-04 15:21:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-04 20:21:21', '2026-02-04 20:21:21'),
(259, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-04 15:23:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-04 20:23:23', '2026-02-04 20:23:23'),
(260, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-04 15:24:11\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-04 20:24:11', '2026-02-04 20:24:11'),
(261, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-04 20:28:14\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 01:28:14', '2026-02-05 01:28:14'),
(262, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-04 20:28:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 01:28:46', '2026-02-05 01:28:46'),
(263, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-04 20:56:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 01:56:40', '2026-02-05 01:56:40'),
(264, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-04 20:56:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 01:56:44', '2026-02-05 01:56:44'),
(265, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-05 15:37:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 20:37:44', '2026-02-05 20:37:44'),
(266, NULL, 'login', 'Session', NULL, 'Inicio de sesión: cuatro@estudiante.com', '{\"email\":\"cuatro@estudiante.com\",\"login_time\":\"2026-02-05 15:58:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 20:58:29', '2026-02-05 20:58:29'),
(267, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 16:26:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 21:26:09', '2026-02-05 21:26:09'),
(268, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-05 16:26:31\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 21:26:31', '2026-02-05 21:26:31'),
(269, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 16:48:30\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 21:48:30', '2026-02-05 21:48:30'),
(270, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-05 16:48:54\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 21:48:54', '2026-02-05 21:48:54'),
(271, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 16:54:52\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 21:54:52', '2026-02-05 21:54:52'),
(272, NULL, 'login', 'Session', NULL, 'Inicio de sesión: cuatro@estudiante.com', '{\"email\":\"cuatro@estudiante.com\",\"login_time\":\"2026-02-05 16:55:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 21:55:23', '2026-02-05 21:55:23'),
(273, NULL, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 17:25:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 22:25:09', '2026-02-05 22:25:09'),
(274, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-05 18:19:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-05 23:19:36', '2026-02-05 23:19:36'),
(275, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 18:30:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 23:30:29', '2026-02-05 23:30:29'),
(276, NULL, 'login', 'Session', NULL, 'Inicio de sesión: cinco@estudiante.com', '{\"email\":\"cinco@estudiante.com\",\"login_time\":\"2026-02-05 18:31:03\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 23:31:03', '2026-02-05 23:31:03'),
(277, 76, 'login', 'Session', NULL, 'Inicio de sesión: cuatro@estudiante.com', '{\"email\":\"cuatro@estudiante.com\",\"login_time\":\"2026-02-05 18:49:22\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 23:49:22', '2026-02-05 23:49:22'),
(278, 76, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-02-05 18:49:37\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 23:49:37', '2026-02-05 23:49:37'),
(279, 74, 'login', 'Session', NULL, 'Inicio de sesión: cinco@estudiante.com', '{\"email\":\"cinco@estudiante.com\",\"login_time\":\"2026-02-05 18:50:05\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-02-05 23:50:05', '2026-02-05 23:50:05'),
(280, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-07 19:48:30\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-08 00:48:30', '2026-02-08 00:48:30'),
(281, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-17 14:04:13\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-17 19:04:13', '2026-02-17 19:04:13'),
(282, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-02-18 16:32:05\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-02-18 21:32:05', '2026-02-18 21:32:05'),
(283, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-05 16:38:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-05 21:38:44', '2026-03-05 21:38:44'),
(284, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-05 16:38:51\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-05 21:38:51', '2026-03-05 21:38:51'),
(285, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-09 12:45:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-09 17:45:27', '2026-03-09 17:45:27'),
(286, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-09 19:55:15\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 00:55:15', '2026-03-10 00:55:15'),
(287, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-09 20:38:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 01:38:09', '2026-03-10 01:38:09'),
(288, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-09 20:51:44\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 01:51:44', '2026-03-10 01:51:44'),
(289, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-09 21:41:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 02:41:36', '2026-03-10 02:41:36'),
(290, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-09 21:42:35\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 02:42:35', '2026-03-10 02:42:35'),
(291, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-09 22:17:49\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-10 03:17:49', '2026-03-10 03:17:49'),
(292, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-09 22:17:57\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-10 03:17:57', '2026-03-10 03:17:57'),
(293, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-10 11:54:21\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 16:54:21', '2026-03-10 16:54:21'),
(294, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-10 12:08:22\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 17:08:22', '2026-03-10 17:08:22'),
(295, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-10 12:09:20\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 17:09:20', '2026-03-10 17:09:20'),
(296, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-10 13:30:15\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 18:30:15', '2026-03-10 18:30:15'),
(297, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-10 14:58:31\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 19:58:31', '2026-03-10 19:58:31'),
(298, 1, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-10 14:58:49\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 19:58:49', '2026-03-10 19:58:49'),
(299, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-10 15:53:06\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-10 20:53:06', '2026-03-10 20:53:06'),
(300, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-10 20:06:07\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 01:06:07', '2026-03-11 01:06:07'),
(301, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-03-10 20:07:56\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-11 01:07:56', '2026-03-11 01:07:56'),
(302, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-10 20:09:17\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 01:09:17', '2026-03-11 01:09:17'),
(303, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-10 20:09:28\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 01:09:28', '2026-03-11 01:09:28'),
(304, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-11 18:03:41\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 23:03:41', '2026-03-11 23:03:41'),
(305, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-11 18:10:47\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-11 23:10:47', '2026-03-11 23:10:47'),
(306, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-03-11 18:13:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-11 23:13:46', '2026-03-11 23:13:46'),
(307, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-11 22:02:33\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 03:02:33', '2026-03-12 03:02:33'),
(308, 45, 'login', 'Session', NULL, 'Inicio de sesión: uno@docente.com', '{\"email\":\"uno@docente.com\",\"login_time\":\"2026-03-11 22:03:49\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 03:03:49', '2026-03-12 03:03:49');
INSERT INTO `user_operations` (`id`, `user_id`, `operation_type`, `entity_type`, `entity_id`, `description`, `details`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(309, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-11 22:06:10\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 03:06:10', '2026-03-12 03:06:10'),
(310, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-03-12 12:09:36\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 17:09:36', '2026-03-12 17:09:36'),
(311, 1, 'login', 'Session', NULL, 'Inicio de sesión: carjavalosistem@gmail.com', '{\"email\":\"carjavalosistem@gmail.com\",\"login_time\":\"2026-03-12 12:09:58\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 17:09:58', '2026-03-12 17:09:58'),
(312, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 12:10:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 17:10:45', '2026-03-12 17:10:45'),
(313, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 12:10:51\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 17:10:51', '2026-03-12 17:10:51'),
(314, 36, 'enroll', 'Curso', 17, 'Inscripción al curso: pagos', '{\"curso_titulo\":\"pagos\",\"fecha_inscripcion\":\"2026-03-12 12:11:00\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 17:11:00', '2026-03-12 17:11:00'),
(315, 36, 'enroll', 'Curso', 13, 'Inscripción al curso: Reanimación Cardiopulmonar(RCP)', '{\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_inscripcion\":\"2026-03-12 12:11:04\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 17:11:04', '2026-03-12 17:11:04'),
(316, 36, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 12:11:24\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 17:11:24', '2026-03-12 17:11:24'),
(317, 45, 'login', 'Session', NULL, 'Inicio de sesión: uno@docente.com', '{\"email\":\"uno@docente.com\",\"login_time\":\"2026-03-12 12:11:33\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 17:11:33', '2026-03-12 17:11:33'),
(318, 45, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 13:15:19\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 18:15:19', '2026-03-12 18:15:19'),
(319, 46, 'login', 'Session', NULL, 'Inicio de sesión: tres@estudiante.com', '{\"email\":\"tres@estudiante.com\",\"login_time\":\"2026-03-12 13:15:28\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 18:15:28', '2026-03-12 18:15:28'),
(320, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 14:36:19\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 19:36:19', '2026-03-12 19:36:19'),
(321, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-12 14:36:23\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 19:36:23', '2026-03-12 19:36:23'),
(322, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 14:54:29\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 19:54:29', '2026-03-12 19:54:29'),
(323, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-12 14:54:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 19:54:34', '2026-03-12 19:54:34'),
(324, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 14:59:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 19:59:46', '2026-03-12 19:59:46'),
(325, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 15:25:27\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 20:25:27', '2026-03-12 20:25:27'),
(326, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 15:55:09\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 20:55:09', '2026-03-12 20:55:09'),
(327, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Tres Estudiante Estudiante', '{\"estudiante_id\":46,\"estudiante_nombre\":\"Tres Estudiante Estudiante\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 15:56:07\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 20:56:07', '2026-03-12 20:56:07'),
(328, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 15:56:40\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:56:40', '2026-03-12 20:56:40'),
(329, 45, 'login', 'Session', NULL, 'Inicio de sesión: uno@docente.com', '{\"email\":\"uno@docente.com\",\"login_time\":\"2026-03-12 15:56:50\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:56:50', '2026-03-12 20:56:50'),
(330, 45, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 15:57:32\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:57:32', '2026-03-12 20:57:32'),
(331, 46, 'login', 'Session', NULL, 'Inicio de sesión: tres@estudiante.com', '{\"email\":\"tres@estudiante.com\",\"login_time\":\"2026-03-12 15:57:49\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:57:49', '2026-03-12 20:57:49'),
(332, 46, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-03-12 15:58:12\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:58:12', '2026-03-12 20:58:12'),
(333, 46, 'enroll', 'Curso', 17, 'Inscripción al curso: pagos', '{\"curso_titulo\":\"pagos\",\"fecha_inscripcion\":\"2026-03-12 15:58:17\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:58:17', '2026-03-12 20:58:17'),
(334, 46, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 15:58:24\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:58:24', '2026-03-12 20:58:24'),
(335, 45, 'login', 'Session', NULL, 'Inicio de sesión: uno@docente.com', '{\"email\":\"uno@docente.com\",\"login_time\":\"2026-03-12 15:58:39\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:58:39', '2026-03-12 20:58:39'),
(336, 45, 'logout', 'Session', NULL, 'Cierre de sesión', '{\"logout_time\":\"2026-03-12 15:59:07\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:59:07', '2026-03-12 20:59:07'),
(337, 36, 'login', 'Session', NULL, 'Inicio de sesión: uno@estudiante.com', '{\"email\":\"uno@estudiante.com\",\"login_time\":\"2026-03-12 15:59:22\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 20:59:22', '2026-03-12 20:59:22'),
(338, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 16:00:05\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 21:00:05', '2026-03-12 21:00:05'),
(339, 1, 'create', 'Asignacion', 18, 'Asignación de curso \'Inducción Institucional (General)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":18,\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_asignacion\":\"2026-03-12 16:00:53\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 21:00:53', '2026-03-12 21:00:53'),
(340, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 16:01:18\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 21:01:18', '2026-03-12 21:01:18'),
(341, 36, 'enroll', 'Curso', 18, 'Inscripción al curso: Inducción Institucional (General)', '{\"curso_titulo\":\"Inducci\\u00f3n Institucional (General)\",\"fecha_inscripcion\":\"2026-03-12 16:01:34\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 21:01:34', '2026-03-12 21:01:34'),
(342, 36, 'enroll', 'Curso', 13, 'Inscripción al curso: Reanimación Cardiopulmonar(RCP)', '{\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_inscripcion\":\"2026-03-12 16:01:38\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:147.0) Gecko/20100101 Firefox/147.0', '2026-03-12 21:01:38', '2026-03-12 21:01:38'),
(343, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 16:33:46\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 21:33:46', '2026-03-12 21:33:46'),
(344, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 16:42:30\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 21:42:30', '2026-03-12 21:42:30'),
(345, 1, 'create', 'Asignacion', 17, 'Asignación de curso \'pagos\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":17,\"curso_titulo\":\"pagos\",\"fecha_asignacion\":\"2026-03-12 17:03:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 22:03:45', '2026-03-12 22:03:45'),
(346, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: Uno Estudiante uno', '{\"estudiante_id\":36,\"estudiante_nombre\":\"Uno Estudiante uno\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 17:03:45\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 22:03:45', '2026-03-12 22:03:45'),
(347, 1, 'create', 'Asignacion', 13, 'Asignación de curso \'Reanimación Cardiopulmonar(RCP)\' al estudiante: cuatro estudiante', '{\"estudiante_id\":76,\"estudiante_nombre\":\"cuatro estudiante\",\"curso_id\":13,\"curso_titulo\":\"Reanimaci\\u00f3n Cardiopulmonar(RCP)\",\"fecha_asignacion\":\"2026-03-12 17:44:08\"}', '192.168.2.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', '2026-03-12 22:44:08', '2026-03-12 22:44:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculacion_contrato`
--

CREATE TABLE `vinculacion_contrato` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `vinculacion_contrato`
--

INSERT INTO `vinculacion_contrato` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Nomina', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(2, 'Agesoc', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(3, 'Asstracud', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(4, 'Estudiante', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(5, 'Docente', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(6, 'Unidad Renal', '2026-01-15 20:51:14', '2026-01-15 20:51:14'),
(7, 'Otro', '2026-01-15 20:51:14', '2026-01-15 20:51:14');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_cod_categoria_index` (`cod_categoria`),
  ADD KEY `areas_descripcion_index` (`descripcion`);

--
-- Indices de la tabla `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_created_by_foreign` (`created_by`);

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorias_descripcion_unique` (`descripcion`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cursos_codigo_acceso_unique` (`codigo_acceso`),
  ADD KEY `cursos_id_area_index` (`id_area`),
  ADD KEY `cursos_instructor_id_index` (`instructor_id`),
  ADD KEY `cursos_estado_index` (`estado`),
  ADD KEY `cursos_codigo_acceso_index` (`codigo_acceso`),
  ADD KEY `cursos_fecha_inicio_index` (`fecha_inicio`),
  ADD KEY `cursos_fecha_fin_index` (`fecha_fin`);

--
-- Indices de la tabla `curso_actividades`
--
ALTER TABLE `curso_actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_actividades_curso_id_index` (`curso_id`),
  ADD KEY `curso_actividades_tipo_index` (`tipo`),
  ADD KEY `curso_actividades_fecha_apertura_index` (`fecha_apertura`),
  ADD KEY `curso_actividades_fecha_cierre_index` (`fecha_cierre`),
  ADD KEY `curso_actividades_es_obligatoria_index` (`es_obligatoria`),
  ADD KEY `curso_actividades_material_id_index` (`material_id`);

--
-- Indices de la tabla `curso_actividad_entrega`
--
ALTER TABLE `curso_actividad_entrega`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curso_actividad_entrega_curso_id_actividad_id_user_id_unique` (`curso_id`,`actividad_id`,`user_id`),
  ADD KEY `curso_actividad_entrega_actividad_id_foreign` (`actividad_id`),
  ADD KEY `curso_actividad_entrega_user_id_foreign` (`user_id`),
  ADD KEY `curso_actividad_entrega_curso_id_user_id_index` (`curso_id`,`user_id`);

--
-- Indices de la tabla `curso_actividad_entregas`
--
ALTER TABLE `curso_actividad_entregas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curso_actividad_entregas_actividad_id_estudiante_id_unique` (`actividad_id`,`estudiante_id`),
  ADD KEY `curso_actividad_entregas_estudiante_id_foreign` (`estudiante_id`),
  ADD KEY `curso_actividad_entregas_calificado_por_foreign` (`calificado_por`),
  ADD KEY `curso_actividad_entregas_estado_index` (`estado`);

--
-- Indices de la tabla `curso_asignaciones`
--
ALTER TABLE `curso_asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curso_estudiante_asignacion_unique` (`curso_id`,`estudiante_id`),
  ADD KEY `curso_asignaciones_estudiante_id_foreign` (`estudiante_id`),
  ADD KEY `curso_asignaciones_asignado_por_foreign` (`asignado_por`),
  ADD KEY `curso_asignaciones_docente_id_foreign` (`docente_id`);

--
-- Indices de la tabla `curso_estudiantes`
--
ALTER TABLE `curso_estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curso_estudiantes_curso_id_estudiante_id_unique` (`curso_id`,`estudiante_id`),
  ADD KEY `curso_estudiantes_curso_id_index` (`curso_id`),
  ADD KEY `curso_estudiantes_estudiante_id_index` (`estudiante_id`),
  ADD KEY `curso_estudiantes_estado_index` (`estado`),
  ADD KEY `curso_estudiantes_fecha_inscripcion_index` (`fecha_inscripcion`);

--
-- Indices de la tabla `curso_foros`
--
ALTER TABLE `curso_foros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_foros_curso_id_index` (`curso_id`),
  ADD KEY `curso_foros_usuario_id_index` (`usuario_id`),
  ADD KEY `curso_foros_parent_id_index` (`parent_id`),
  ADD KEY `curso_foros_es_anuncio_index` (`es_anuncio`),
  ADD KEY `curso_foros_es_fijado_index` (`es_fijado`),
  ADD KEY `curso_foros_created_at_index` (`created_at`);

--
-- Indices de la tabla `curso_materiales`
--
ALTER TABLE `curso_materiales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_materiales_curso_id_index` (`curso_id`),
  ADD KEY `curso_materiales_tipo_index` (`tipo`),
  ADD KEY `curso_materiales_orden_index` (`orden`),
  ADD KEY `curso_materiales_es_publico_index` (`es_publico`),
  ADD KEY `curso_materiales_prerequisite_id_index` (`prerequisite_id`);

--
-- Indices de la tabla `curso_material_visto`
--
ALTER TABLE `curso_material_visto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `curso_material_visto_curso_id_material_id_user_id_unique` (`curso_id`,`material_id`,`user_id`),
  ADD KEY `curso_material_visto_material_id_foreign` (`material_id`),
  ADD KEY `curso_material_visto_user_id_foreign` (`user_id`),
  ADD KEY `curso_material_visto_curso_id_user_id_index` (`curso_id`,`user_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mensajes_chat_destinatario_id_foreign` (`destinatario_id`),
  ADD KEY `mensajes_chat_remitente_id_destinatario_id_index` (`remitente_id`,`destinatario_id`),
  ADD KEY `mensajes_chat_created_at_index` (`created_at`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios_areas`
--
ALTER TABLE `servicios_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_numero_documento_unique` (`numero_documento`),
  ADD KEY `users_servicio_area_id_foreign` (`servicio_area_id`),
  ADD KEY `users_vinculacion_contrato_id_foreign` (`vinculacion_contrato_id`),
  ADD KEY `users_sede_id_foreign` (`sede_id`);

--
-- Indices de la tabla `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_logins_user_id_attempted_at_index` (`user_id`,`attempted_at`),
  ADD KEY `user_logins_email_attempted_at_index` (`email`,`attempted_at`),
  ADD KEY `user_logins_status_attempted_at_index` (`status`,`attempted_at`),
  ADD KEY `user_logins_ip_address_index` (`ip_address`);

--
-- Indices de la tabla `user_operations`
--
ALTER TABLE `user_operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_operations_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `user_operations_operation_type_created_at_index` (`operation_type`,`created_at`),
  ADD KEY `user_operations_entity_type_index` (`entity_type`);

--
-- Indices de la tabla `vinculacion_contrato`
--
ALTER TABLE `vinculacion_contrato`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `curso_actividades`
--
ALTER TABLE `curso_actividades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `curso_actividad_entrega`
--
ALTER TABLE `curso_actividad_entrega`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `curso_actividad_entregas`
--
ALTER TABLE `curso_actividad_entregas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso_asignaciones`
--
ALTER TABLE `curso_asignaciones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `curso_estudiantes`
--
ALTER TABLE `curso_estudiantes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `curso_foros`
--
ALTER TABLE `curso_foros`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `curso_materiales`
--
ALTER TABLE `curso_materiales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `curso_material_visto`
--
ALTER TABLE `curso_material_visto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `servicios_areas`
--
ALTER TABLE `servicios_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT de la tabla `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=399;

--
-- AUTO_INCREMENT de la tabla `user_operations`
--
ALTER TABLE `user_operations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=348;

--
-- AUTO_INCREMENT de la tabla `vinculacion_contrato`
--
ALTER TABLE `vinculacion_contrato`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_cod_categoria_foreign` FOREIGN KEY (`cod_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_id_area_foreign` FOREIGN KEY (`id_area`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cursos_instructor_id_foreign` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_actividades`
--
ALTER TABLE `curso_actividades`
  ADD CONSTRAINT `curso_actividades_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_actividades_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `curso_materiales` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `curso_actividad_entrega`
--
ALTER TABLE `curso_actividad_entrega`
  ADD CONSTRAINT `curso_actividad_entrega_actividad_id_foreign` FOREIGN KEY (`actividad_id`) REFERENCES `curso_actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_actividad_entrega_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_actividad_entrega_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_actividad_entregas`
--
ALTER TABLE `curso_actividad_entregas`
  ADD CONSTRAINT `curso_actividad_entregas_actividad_id_foreign` FOREIGN KEY (`actividad_id`) REFERENCES `curso_actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_actividad_entregas_calificado_por_foreign` FOREIGN KEY (`calificado_por`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `curso_actividad_entregas_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_asignaciones`
--
ALTER TABLE `curso_asignaciones`
  ADD CONSTRAINT `curso_asignaciones_asignado_por_foreign` FOREIGN KEY (`asignado_por`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_asignaciones_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_asignaciones_docente_id_foreign` FOREIGN KEY (`docente_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `curso_asignaciones_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_estudiantes`
--
ALTER TABLE `curso_estudiantes`
  ADD CONSTRAINT `curso_estudiantes_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_estudiantes_estudiante_id_foreign` FOREIGN KEY (`estudiante_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_foros`
--
ALTER TABLE `curso_foros`
  ADD CONSTRAINT `curso_foros_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_foros_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `curso_foros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_foros_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `curso_materiales`
--
ALTER TABLE `curso_materiales`
  ADD CONSTRAINT `curso_materiales_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_materiales_prerequisite_id_foreign` FOREIGN KEY (`prerequisite_id`) REFERENCES `curso_materiales` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `curso_material_visto`
--
ALTER TABLE `curso_material_visto`
  ADD CONSTRAINT `curso_material_visto_curso_id_foreign` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_material_visto_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `curso_materiales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `curso_material_visto_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensajes_chat`
--
ALTER TABLE `mensajes_chat`
  ADD CONSTRAINT `mensajes_chat_destinatario_id_foreign` FOREIGN KEY (`destinatario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mensajes_chat_remitente_id_foreign` FOREIGN KEY (`remitente_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_sede_id_foreign` FOREIGN KEY (`sede_id`) REFERENCES `sedes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_servicio_area_id_foreign` FOREIGN KEY (`servicio_area_id`) REFERENCES `servicios_areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_vinculacion_contrato_id_foreign` FOREIGN KEY (`vinculacion_contrato_id`) REFERENCES `vinculacion_contrato` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `user_logins`
--
ALTER TABLE `user_logins`
  ADD CONSTRAINT `user_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `user_operations`
--
ALTER TABLE `user_operations`
  ADD CONSTRAINT `user_operations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
