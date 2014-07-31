---------------------------------------------NO PASADOS







 ---------------------------------------------PASADOS
INSERT INTO `lc000386_qjarvis`.`qj_usergroup` (`_id`, `description`) VALUES ('9', 'Quadramma/Endi -> Users');
UPDATE `lc000386_qjarvis`.`qj_user` SET `_usergroup_id` = '9' WHERE `qj_user`.`_id` = 2;
UPDATE `lc000386_qjarvis`.`qj_user` SET `_usergroup_id` = '9' WHERE `qj_user`.`_id` = 3;
UPDATE `lc000386_qjarvis`.`qj_user` SET `_usergroup_id` = '9' WHERE `qj_user`.`_id` = 4;
UPDATE `lc000386_qjarvis`.`qj_user` SET `_usergroup_id` = '9' WHERE `qj_user`.`_id` = 5;
INSERT INTO `lc000386_qjarvis`.`qj_usergroup_group` (`_id`, `_usergroup_id`, `_group_id`, `_profile_id`) VALUES (NULL, '9', '2', '4');
INSERT INTO `lc000386_qjarvis`.`qj_menu` (`_id`, `description`, `_profile_id`, `_group_id`) VALUES (NULL, 'QJB / User', '4', '2');
INSERT INTO `lc000386_qjarvis`.`qj_menu_module` (`_id`, `_menu_id`, `_module_id`) VALUES (NULL, '9', '13'), (NULL, '9', '14');
UPDATE `lc000386_qjarvis`.`qj_user` SET `password` = 'MTIzNDU2'
INSERT INTO `lc000386_qjarvis`.`qj_usergroup` (`_id`, `description`) VALUES ('10', 'Jazmin Chebar App / Administradores');
INSERT INTO `lc000386_qjarvis`.`qj_group` (`_id`, `description`) VALUES ('5', 'App Jazmin Chebar 2014');
INSERT INTO `lc000386_qjarvis`.`qj_usergroup_group` (`_id`, `_usergroup_id`, `_group_id`, `_profile_id`) VALUES (NULL, '10', '5', '1');
INSERT INTO `lc000386_qjarvis`.`qj_menu` (`_id`, `description`, `_profile_id`, `_group_id`) VALUES ('10', 'AppJazminChebbar / Admins Menu', '1', '5');
INSERT INTO `lc000386_qjarvis`.`qj_menu_module` (`_id`, `_menu_id`, `_module_id`) VALUES (NULL, '10', '12');
CREATE TABLE IF NOT EXISTS `qj_group_usergroup_menu` (
  `_id` int(11) NOT NULL AUTO_INCREMENT,
  `_id_group` int(11) NOT NULL,
  `_id_usergroup` int(11) NOT NULL,
  `_id_menu` int(11) NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `qj_usergroup` ADD `_id_profile` INT NOT NULL ;
UPDATE `lc000386_qjarvis`.`qj_usergroup` SET `_id_profile` = '1';
INSERT INTO `lc000386_qjarvis`.`qj_menu_module` (`_id`, `_menu_id`, `_module_id`) VALUES (NULL, '3', '4');
UPDATE `lc000386_qjarvis`.`qj_module` SET `state` = 'module-profile-list' WHERE `qj_module`.`_id` = 4;
ALTER TABLE `qj_profile` DROP `_id`;
ALTER TABLE `qj_profile` ADD `_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;




