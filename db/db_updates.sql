/*---------------MODIFICACIÓN DE LA TABLA ESTABLIMETS---------------*/
ALTER TABLE `establiments` ADD `allow_extra_persons` INT(1) NOT NULL DEFAULT '0' AFTER `persons_min`, ADD `extra_quantity` INT NOT NULL DEFAULT '0' AFTER `allow_extra_persons`, ADD `extra_price` DECIMAL(10,2) NOT NULL DEFAULT '0' AFTER `extra_quantity`;

ALTER TABLE `establiments` ADD `title_real` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`;

ALTER TABLE `establiments` ADD `reserva_inmediata` INT NOT NULL DEFAULT '0' AFTER `terms_fr`;

ALTER TABLE `establiments` ADD `indications_es` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `description_small_fr`, ADD `indications_ca` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `indications_es`, ADD `indications_en` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `indications_ca`, ADD `indications_fr` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL AFTER `indications_en`;

/*-------------- MODIFICACIÓN DE LA TABLA ESTABLIMENTS_NITSMIN -------------*/

ALTER TABLE `establiments_nitsmin` ADD `dia_entrada` INT NOT NULL AFTER `nitsmin`;
UPDATE `establiments_nitsmin` SET `dia_entrada`=1 WHERE `dia_entrada`=0 

ALTER TABLE `establiments_nitsmin` ADD `precio_extra` INT NOT NULL DEFAULT '0' AFTER `dia_entrada`;

ALTER TABLE `establiments_nitsmin` ADD `reserva_multiplo` INT NULL DEFAULT '0' AFTER `precio_extra`;

/* ------------- MODIFICACIÓN DE LA TABLA PAYMODULES --------------------*/
INSERT INTO `somrurals`.`paymodules` (`pid`, `title_ca`, `title_es`, `title_en`, `title_fr`) VALUES ('2', 'Targeta de crèdit', 'Tarjeta de crédito', 'Credit card', 'Carte de crédit'), ('3', 'PayPal', 'PayPal', 'PayPal', 'PayPal');

/* Cambio de valor por defecto del día de entrada para minimo numero de noches */
ALTER TABLE `establiments_nitsmin` CHANGE `dia_entrada` `dia_entrada` INT(11) NOT NULL DEFAULT '0';

/*--------------- MODIFICACIÓN DE LA TABLA LANDINGS ---------------------*/
ALTER TABLE `landings` ADD `linked_pid` INT(11) NOT NULL DEFAULT '0' AFTER `status`, ADD `linked_cid` INT(11) NOT NULL DEFAULT '0' AFTER `linked_pid`;

/* CREACION de tabla payments */
DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL,
  `id_type` int(2) NOT NULL DEFAULT '1',
  `resid` int(11) NOT NULL,
  `id_transaction` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `id_paymentway` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0: pendiente; 9: realizado',
  `quantity` decimal(6,2) NOT NULL DEFAULT '0.00',
  `datetime` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `secure_payment` char(1) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `amount` decimal(11,2) DEFAULT NULL,
  `commerce_id` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `terminal` int(11) DEFAULT NULL,
  `control` varchar(75) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `response` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `error_code` varchar(12) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `response_datetime` datetime DEFAULT NULL,
  `authorisation_code` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `create_user` varchar(80) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  `create_ip` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `modify_user` varchar(80) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `modify_time` datetime DEFAULT NULL,
  `modify_ip` varchar(15) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci COMMENT='Registro de los pagos realizados';

--
-- Indices de la tabla `payments`
--
ALTER TABLE `payments`
  ADD UNIQUE KEY `id` (`id`);
--
-- AUTO_INCREMENT de la tabla `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



/* Nuevo estado de reservas */
INSERT INTO `reservations_states` (`restid`, `title_ca`, `title_es`, `title_en`, `title_fr`) VALUES ('5', 'Cancel·lada per caducitat del pagament', 'Cancelada por caducidad del pago', 'Canceled by expiration of payment', 'Annulée par l''expiration de paiement');

-- Nuevo campo para recoger el datetime del momento en que se solicita el pago al usuario (para controlar caducidad de reservas)
ALTER TABLE `reservations` ADD `payment_request` DATETIME NULL ;
-- Actualización de reservas antiguas aún no confirmadas para que tenga el payment_request
update `reservations` set payment_request = resdate WHERE `restid` = 2


-- Actualización de campos NOT NULL en tabla de comentarios/valoraciones
ALTER TABLE `comments` CHANGE `title_ca` `title_ca` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `title_es` `title_es` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `title_en` `title_en` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `title_fr` `title_fr` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `comments_es` `comments_es` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `comments_en` `comments_en` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL, CHANGE `comments_fr` `comments_fr` VARCHAR(256) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE `comments` CHANGE `como` `como` SMALLINT(6) NULL;

-- Añadir forma de pago de tarjeta de crédito
INSERT INTO `paymodules` (`pid`, `title_ca`, `title_es`, `title_en`, `title_fr`) VALUES ('2', 'Targeta de crèdit', 'Tarjeta de crédito', 'Credit Card', 'Carte de crédit');


-- Añado nuevos servicios a las casas
ALTER TABLE `perfils` ADD `orden` INT NOT NULL DEFAULT '0' AFTER `desc_fr`;
ALTER TABLE `perfils` ADD `active` INT NOT NULL DEFAULT '0' AFTER `desc_fr`;
UPDATE `perfils` SET `active`=1 WHERE 1;
ALTER TABLE `serveis` ADD `active` INT NOT NULL DEFAULT '0' AFTER `ext`;
UPDATE `serveis` SET `active`=1 WHERE 1;

INSERT INTO `perfils` (`perid`, `title_es`, `title_ca`, `title_en`, `title_fr`, `desc_es`, `desc_ca`, `desc_en`, `desc_fr`) VALUES ('11', 'Pistas de Esquí', 'Pistes d''Esquí', 'Ski slopes', 'Pistes de ski', '', '', '', ''), ('12', 'Cercano a Río / Lago', 'Proper a Riu/Llac', 'Near River / Lake', 'Près de la rivière / Lac', '', '', '', '');
INSERT INTO `perfils` (`perid`, `title_es`, `title_ca`, `title_en`, `title_fr`, `desc_es`, `desc_ca`, `desc_en`, `desc_fr`) VALUES ('13', 'Cercano a Parque Nacional / Parque Natural', 'Proper a Parc Nacional/Parc Natural', 'Near National Park / Nature Reserve', 'Près de réserve de parc national / Nature', '', '', '', '');
INSERT INTO `serveis` (`serid`, `title_es`, `title_ca`, `title_en`, `title_fr`, `css`, `orden`, `ext`) VALUES ('23', 'Acceso a discapacitados', 'Accès a discapacitats', 'Disabled access', 'Accès handicapés', '', '0', '0'), ('24', 'Bañera', 'Banyera', 'Bathtub', 'Bath', '', '', '0');
INSERT INTO `serveis` (`serid`, `title_es`, `title_ca`, `title_en`, `title_fr`, `css`, `orden`, `ext`) VALUES ('25', 'Cuna para bebés', 'Bressol per nadons', 'Cradle for babies', 'Lit bébé', '', '0', '0'), ('26', 'Granja / Estable', 'Granja/Estable', 'Farm / Stable', '', '', '0', '1'), ('27', 'Parque Infantil', 'Parc Infantil', 'Playground', 'Aire de jeux', '', '0', '1'), ('28', 'Sala de juegos / Billar / Futbolín / Ping Pong', 'Sala de jocs/Billar/Futbolí/Ping Pong', 'Games room / Billiards / Foosball / Ping Pong', 'Salle de jeux / Billard / Baby-foot / Ping Pong', '', '0', '0'), ('29', 'Sala grupos', 'Sala grups', 'Room for groups', 'Salle pour les groupes', '', '0', '0');
UPDATE `serveis` SET `orden` = '15' WHERE `serveis`.`serid` = 11;
UPDATE `serveis` SET `orden` = '14' WHERE `serveis`.`serid` = 8;
UPDATE `serveis` SET `orden` = '13' WHERE `serveis`.`serid` = 21;
UPDATE `serveis` SET `orden` = '12' WHERE `serveis`.`serid` = 9;
UPDATE `serveis` SET `orden` = '11' WHERE `serveis`.`serid` = 2;
UPDATE `serveis` SET `orden` = '10' WHERE `serveis`.`serid` = 12;
UPDATE `perfils` SET `orden` = '15' WHERE `perfils`.`perid` = 3;
UPDATE `perfils` SET `orden` = '14' WHERE `perfils`.`perid` = 10;
UPDATE `perfils` SET `orden` = '13' WHERE `perfils`.`perid` = 11;
UPDATE `perfils` SET `orden` = '12' WHERE `perfils`.`perid` = 2;
UPDATE `perfils` SET `orden` = '11' WHERE `perfils`.`perid` = 1;



-- nueva forma de pago para el pago retenido en caso de reserva inmediata
INSERT INTO `reservations_states` (`restid`, `title_ca`, `title_es`, `title_en`, `title_fr`) VALUES ('6', 'Pago retenido pendiente de disponibilidad', 'Pago retenido pendiente de disponibilidad', 'Pago retenido pendiente de disponibilidad', 'Pago retenido pendiente de disponibilidad');
INSERT INTO `reservations_states` (`restid`, `title_ca`, `title_es`, `title_en`, `title_fr`) VALUES ('7', 'Reserva pendiente del pago inmediato', 'Reserva pendiente del pago inmediato', 'Reserva pendiente del pago inmediato', 'Reserva pendiente del pago inmediato');

-- Creo y activo un campo de determina las formas de pago activas para reserva inmediata
ALTER TABLE `paymodules` ADD `reserva_inmediata` INT NOT NULL DEFAULT '0' ;
UPDATE `paymodules` SET `reserva_inmediata` = '1' WHERE `paymodules`.`pid` = 2;

-- Creo nuevo campo para almacenar la ruta de los iCal externos de los establecimientos
ALTER TABLE `establiments` ADD `external_ical` VARCHAR(512) NULL ;

ALTER TABLE `establiments_prices` ADD `managed_online` SMALLINT(1) NOT NULL DEFAULT '0' ;


ALTER TABLE `establiments` ADD `checkouttime_weeks` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `checkouttimeto`;

ALTER TABLE `establiments_nitsmin` ADD COLUMN `precio_bloque_dias` INT(11) NULL DEFAULT 0 AFTER `reserva_multiplo`;

ALTER TABLE `establiments_nitsmin` ADD COLUMN `precio_extra_bloque_dias` INT(11) NULL DEFAULT 0 AFTER `precio_bloque_dias`;

