/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-07-06 08:56:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `blog`
-- ----------------------------
DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog
-- ----------------------------
INSERT INTO `blog` VALUES ('1', '2', 'Title', '<span style=\"color: rgb(151, 152, 152); line-height: 18.5714282989502px; text-align: right;\">Content</span>');
INSERT INTO `blog` VALUES ('2', '0', null, null);
INSERT INTO `blog` VALUES ('3', '0', null, null);
INSERT INTO `blog` VALUES ('4', '0', null, null);
INSERT INTO `blog` VALUES ('5', '0', '22', '111');
INSERT INTO `blog` VALUES ('6', '0', '22', '111');
INSERT INTO `blog` VALUES ('7', '0', '22', '111');
INSERT INTO `blog` VALUES ('8', '2', '222', '111');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `identifier` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `timeout` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'db6afb334f7ed4e97d500fc5ff32f357', '056c00e6987402d1cc72d6e99c520833', '1436498600');
