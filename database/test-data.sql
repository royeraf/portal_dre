-- Datos ficticios para desarrollo local.
-- No contiene información institucional real.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

INSERT IGNORE INTO `users`
    (`id`, `name`, `email`, `password`, `created_at`, `updated_at`)
VALUES
    (9001, 'Usuario de Prueba', 'tester@example.invalid', '$2y$10$R.rJiuOUtjh.Nr7CtrZMuuuTJPUpcC4NjBIsVz9XTd3O3oG4RlTXG', NOW(), NOW());

INSERT IGNORE INTO `area` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
    (9001, 'Área de Prueba', NOW(), NOW());

INSERT IGNORE INTO `direcciones`
    (`id`, `nombre`, `slug`, `descripcion`, `activo`, `created_at`, `updated_at`)
VALUES
    (9001, 'Dirección de Prueba', 'direccion-prueba', 'Registro ficticio para desarrollo local.', 1, NOW(), NOW());

INSERT IGNORE INTO `areas_menu`
    (`id`, `nombre`, `slug`, `descripcion`, `direccion_id`, `orden`, `activo`, `created_at`, `updated_at`)
VALUES
    (9001, 'Área de Prueba', 'area-prueba', 'Contenido ficticio para verificar el menú.', 9001, 1, 1, NOW(), NOW());

INSERT IGNORE INTO `documentodegestion` (`id`, `titulo`, `created_at`, `updated_at`) VALUES
    (9001, 'Documento de gestión de prueba', CURDATE(), CURDATE());

INSERT IGNORE INTO `comunicados`
    (`id`, `titulo`, `imagen`, `created_at`, `updated_at`, `url`)
VALUES
    (9001, 'Comunicado de prueba', 'test/comunicado-prueba.jpg', CURDATE(), CURDATE(), 'https://example.invalid/comunicado-prueba');

INSERT IGNORE INTO `convocatoria`
    (`id`, `titulo`, `tipo`, `descripcion`, `fecha_inicio`, `fecha_termino`, `es_activo`, `estado`, `created_at`, `updated_at`)
VALUES
    (9001, 'Convocatoria de prueba', 'PRUEBA', 'Convocatoria ficticia para validar el listado del portal.', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), 1, 'PRUEBA', NOW(), NOW());

INSERT IGNORE INTO `noticias`
    (`id`, `titulo`, `descripcioncorta`, `contenido`, `img1`, `activo`, `fechapubli`, `iduser`, `created_at`, `updated_at`)
VALUES
    (9001, 'Noticia de prueba', 'Contenido ficticio para desarrollo.', 'Esta noticia solo sirve para probar el portal local.', 'test/noticia-prueba.jpg', 1, NOW(), 9001, NOW(), NOW());

INSERT IGNORE INTO `popup`
    (`id`, `titulopopup`, `estado`, `enlace_popup`, `created_at`, `updated_at`)
VALUES
    (9001, 'Popup de prueba', 1, 'https://example.invalid/popup-prueba', NOW(), NOW());

INSERT IGNORE INTO `slider`
    (`id`, `img_slider`, `activo_slider`, `created_at`, `updated_at`, `titulo`, `descripcioncorta`, `link`)
VALUES
    (9001, 'test/slider-prueba.jpg', 1, NOW(), NOW(), 'Slider de prueba', 'Texto ficticio de prueba.', '#');

INSERT IGNORE INTO `video_embevido`
    (`id`, `titulo`, `contenido`, `created_at`, `updated_at`)
VALUES
    (9001, 'Video de prueba', 'https://www.youtube.com/embed/dQw4w9WgXcQ', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
