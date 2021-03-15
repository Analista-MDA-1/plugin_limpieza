-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-03-2021 a las 20:49:24
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clean_system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_areas_bodys`
--

CREATE TABLE `clean_areas_bodys` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `ref_id_header` int(11) NOT NULL,
  `ref_id_attribute` int(11) NOT NULL,
  `max_point` double NOT NULL,
  `nickname` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_areas_headers`
--

CREATE TABLE `clean_areas_headers` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `ref_id_categorie` int(11) NOT NULL,
  `identifier_key` text COLLATE utf8mb4_bin,
  `identifier_value` text COLLATE utf8mb4_bin,
  `nickname` text COLLATE utf8mb4_bin NOT NULL,
  `statu_area` tinyint(1) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_atrributes_areas`
--

CREATE TABLE `clean_atrributes_areas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `attribute` text COLLATE utf8mb4_bin NOT NULL,
  `max_point` text COLLATE utf8mb4_bin,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_auth_tkns`
--

CREATE TABLE `clean_auth_tkns` (
  `id` int(11) NOT NULL,
  `ref_id_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `tkn` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `expire_at` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_categories_areas`
--

CREATE TABLE `clean_categories_areas` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `categorie` text COLLATE utf8mb4_bin NOT NULL,
  `description` text COLLATE utf8mb4_bin NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_foreign_tkns`
--

CREATE TABLE `clean_foreign_tkns` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `url` text COLLATE utf8mb4_bin NOT NULL,
  `token` text COLLATE utf8mb4_bin NOT NULL,
  `expire_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_parameters`
--

CREATE TABLE `clean_parameters` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `meta_key` text COLLATE utf8mb4_bin NOT NULL,
  `meta_value` text COLLATE utf8mb4_bin NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_permissions_users`
--

CREATE TABLE `clean_permissions_users` (
  `id` int(11) NOT NULL,
  `ref_id_user` int(11) NOT NULL,
  `action` text COLLATE utf8mb4_bin NOT NULL,
  `?` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_report_bodys`
--

CREATE TABLE `clean_report_bodys` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `ref_id_header` int(11) NOT NULL,
  `ref_id_attribute_body` int(11) NOT NULL,
  `percent_review` double NOT NULL,
  `comments` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_report_headers`
--

CREATE TABLE `clean_report_headers` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `date` datetime NOT NULL,
  `ref_id_user` int(11) NOT NULL,
  `comentarios_in` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `comentarios_out` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `quantity_review` int(11) NOT NULL,
  `type_selection` int(11) NOT NULL,
  `percent_total` double DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_report_imgs`
--

CREATE TABLE `clean_report_imgs` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `ref_id_body` int(11) NOT NULL,
  `img_route` text COLLATE utf8mb4_bin NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clean_report_metas`
--

CREATE TABLE `clean_report_metas` (
  `id` int(11) NOT NULL,
  `ref_id_header` int(11) NOT NULL,
  `meta_key` text COLLATE utf8mb4_bin NOT NULL,
  `meta_value` text COLLATE utf8mb4_bin NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_actions`
--

CREATE TABLE `log_actions` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `ref_id_user` int(11) NOT NULL,
  `categorie` tinyint(1) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `ref_log` text COLLATE utf8mb4_bin NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `payload` text COLLATE utf8mb4_bin NOT NULL,
  `last_activity` text COLLATE utf8mb4_bin NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` text COLLATE utf8mb4_bin NOT NULL,
  `user_agent` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_empleados`
--

CREATE TABLE `usuarios_empleados` (
  `id_empleados` int(11) NOT NULL,
  `ruta_img_dmcid` text COLLATE utf8mb4_unicode_ci,
  `ruta_img` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nombre_completo` text COLLATE utf8mb4_unicode_ci,
  `num_identificacion` text COLLATE utf8mb4_unicode_ci,
  `num_telefono` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `cargo` bigint(20) DEFAULT NULL,
  `usuario` text COLLATE utf8mb4_unicode_ci,
  `contrasena` text COLLATE utf8mb4_unicode_ci,
  `cambiar_contraseña` tinyint(4) DEFAULT NULL,
  `autoriza` tinyint(4) DEFAULT NULL,
  `aprueba` tinyint(4) DEFAULT NULL,
  `remitente_correo` tinyint(4) DEFAULT NULL,
  `chat_estatus` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clean_areas_bodys`
--
ALTER TABLE `clean_areas_bodys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id_attribute` (`ref_id_attribute`),
  ADD KEY `ref_id_header` (`ref_id_header`);

--
-- Indices de la tabla `clean_areas_headers`
--
ALTER TABLE `clean_areas_headers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id_categorie` (`ref_id_categorie`);

--
-- Indices de la tabla `clean_atrributes_areas`
--
ALTER TABLE `clean_atrributes_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_auth_tkns`
--
ALTER TABLE `clean_auth_tkns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_categories_areas`
--
ALTER TABLE `clean_categories_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_foreign_tkns`
--
ALTER TABLE `clean_foreign_tkns`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_parameters`
--
ALTER TABLE `clean_parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_permissions_users`
--
ALTER TABLE `clean_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id_user` (`ref_id_user`);

--
-- Indices de la tabla `clean_report_bodys`
--
ALTER TABLE `clean_report_bodys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id_header` (`ref_id_header`),
  ADD KEY `ref_id_attribute_body` (`ref_id_attribute_body`);

--
-- Indices de la tabla `clean_report_headers`
--
ALTER TABLE `clean_report_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_report_imgs`
--
ALTER TABLE `clean_report_imgs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clean_report_metas`
--
ALTER TABLE `clean_report_metas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ref_id_header` (`ref_id_header`);

--
-- Indices de la tabla `log_actions`
--
ALTER TABLE `log_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios_empleados`
--
ALTER TABLE `usuarios_empleados`
  ADD PRIMARY KEY (`id_empleados`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clean_areas_bodys`
--
ALTER TABLE `clean_areas_bodys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_areas_headers`
--
ALTER TABLE `clean_areas_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_atrributes_areas`
--
ALTER TABLE `clean_atrributes_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_auth_tkns`
--
ALTER TABLE `clean_auth_tkns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_categories_areas`
--
ALTER TABLE `clean_categories_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_foreign_tkns`
--
ALTER TABLE `clean_foreign_tkns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_parameters`
--
ALTER TABLE `clean_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_permissions_users`
--
ALTER TABLE `clean_permissions_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_report_bodys`
--
ALTER TABLE `clean_report_bodys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_report_headers`
--
ALTER TABLE `clean_report_headers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_report_imgs`
--
ALTER TABLE `clean_report_imgs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clean_report_metas`
--
ALTER TABLE `clean_report_metas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_actions`
--
ALTER TABLE `log_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios_empleados`
--
ALTER TABLE `usuarios_empleados`
  MODIFY `id_empleados` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clean_areas_bodys`
--
ALTER TABLE `clean_areas_bodys`
  ADD CONSTRAINT `clean_areas_bodys_ibfk_1` FOREIGN KEY (`ref_id_attribute`) REFERENCES `clean_categories_areas` (`id`),
  ADD CONSTRAINT `clean_areas_bodys_ibfk_2` FOREIGN KEY (`ref_id_header`) REFERENCES `clean_areas_headers` (`id`);

--
-- Filtros para la tabla `clean_areas_headers`
--
ALTER TABLE `clean_areas_headers`
  ADD CONSTRAINT `clean_areas_headers_ibfk_1` FOREIGN KEY (`ref_id_categorie`) REFERENCES `clean_categories_areas` (`id`);

--
-- Filtros para la tabla `clean_permissions_users`
--
ALTER TABLE `clean_permissions_users`
  ADD CONSTRAINT `clean_permissions_users_ibfk_1` FOREIGN KEY (`ref_id_user`) REFERENCES `usuarios_empleados` (`id_empleados`);

--
-- Filtros para la tabla `clean_report_bodys`
--
ALTER TABLE `clean_report_bodys`
  ADD CONSTRAINT `clean_report_bodys_ibfk_1` FOREIGN KEY (`ref_id_header`) REFERENCES `clean_report_headers` (`id`),
  ADD CONSTRAINT `clean_report_bodys_ibfk_2` FOREIGN KEY (`ref_id_attribute_body`) REFERENCES `clean_areas_bodys` (`id`);

--
-- Filtros para la tabla `clean_report_metas`
--
ALTER TABLE `clean_report_metas`
  ADD CONSTRAINT `clean_report_metas_ibfk_1` FOREIGN KEY (`ref_id_header`) REFERENCES `clean_report_headers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
