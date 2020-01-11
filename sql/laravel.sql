/*
Navicat MySQL Data Transfer

Source Server         : 本地数据库
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2020-01-11 11:18:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS `subject`;
CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL COMMENT '选项A',
  `option_b` varchar(255) DEFAULT NULL COMMENT '选项B',
  `option_c` varchar(255) DEFAULT NULL COMMENT '选项C',
  `option_d` varchar(255) DEFAULT NULL COMMENT '选项D',
  `right` char(1) DEFAULT NULL COMMENT '正确答案',
  `status` tinyint(4) DEFAULT NULL COMMENT '1正常 2关闭',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO `subject` VALUES ('7', '比特币2', '啊2', '吧2', '吃2', '的2', 'A', '1');
INSERT INTO `subject` VALUES ('11', 'gegehrhr', 'r', 'h', 'r', 'h', 'B', '1');
INSERT INTO `subject` VALUES ('10', 'hello', 'h1', 'e2', 'l3', 'o4', 'B', '1');
INSERT INTO `subject` VALUES ('5', '新能源产品已333', 'uy5y5', 'u5j5', '7kjy6k6', 'k6k6', 'B', '1');
INSERT INTO `subject` VALUES ('6', '比特币', '啊', '吧', '吃', '的', 'B', '1');
INSERT INTO `subject` VALUES ('8', '中本聪', '中', '本', '葱', '的', 'D', '1');
INSERT INTO `subject` VALUES ('9', '这是题目', '这', '是', '题', '目', 'C', '1');
INSERT INTO `subject` VALUES ('12', 'hrhtjjtjt', 'g', 'jt', 'f', 'n', 'A', '1');
INSERT INTO `subject` VALUES ('13', '会如何如何', '黄', '浩然', '替换', '额', 'A', '1');
INSERT INTO `subject` VALUES ('14', '他如何如何交通集团就', '合同号', '就突然', '苦苦', '热认同感会让人', 'A', '1');
INSERT INTO `subject` VALUES ('15', '还叫人塔尔和', '五花肉如何', '让她集', '有几天', '和任何人', 'A', '1');
INSERT INTO `subject` VALUES ('16', '儿歌哥哥', '如果让', '浩然', '有内通过', '还替换', 'A', '1');
INSERT INTO `subject` VALUES ('17', '回个骨灰级', 'EHR', '投入和', '让各位', '二', 'A', '1');
INSERT INTO `subject` VALUES ('18', '该3二哥', '4有个会', '3', '给', '还好', 'C', '1');
INSERT INTO `subject` VALUES ('19', '合伙人', '借替换', '花间提壶', '加油加油', '木苦于', 'A', '1');
INSERT INTO `subject` VALUES ('20', 'kkk67j56th5ryh', '交通局', '已经有', '可以可以', '人桐谷和人', 'A', '1');
INSERT INTO `subject` VALUES ('21', 'kykt6y', 'j6t56就', '5会', '鸡同鸭讲', '今天又就', 'A', '1');
INSERT INTO `subject` VALUES ('22', '旧t65jeu56', 'j6tj', '空加入可见', '就好', '5回家5', 'A', '1');
INSERT INTO `subject` VALUES ('23', '跟4额个b', '5', '突然', '55', '有', 'C', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(32) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT '微信昵称',
  `headimgurl` varchar(255) DEFAULT NULL COMMENT '微信头像地址',
  `avatar` varchar(255) DEFAULT NULL COMMENT '本地头像',
  `last_time` int(11) DEFAULT '0' COMMENT '最新答题时间',
  `share_time` int(11) DEFAULT '0' COMMENT '最新分享时间',
  `status` tinyint(4) DEFAULT '1',
  `best` tinyint(3) unsigned DEFAULT '0' COMMENT '最好成绩',
  `poster` varchar(255) DEFAULT NULL COMMENT '最好成绩海报',
  `remember_token` varchar(255) DEFAULT NULL,
  `wechat` varchar(255) DEFAULT NULL COMMENT '微信号',
  `r_account` varchar(255) DEFAULT NULL COMMENT 'R网账号',
  `r_uid` int(10) unsigned DEFAULT '0' COMMENT 'R网uid',
  `tel` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'aaa', '翘首', 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJtxfkusaicfaFaPfspIxyPvA1TeSzHiahAr6eGrmVN5oKH8oB3x65su1sMTtk9MicFLIQiaTdlWOsBWg/132', null, '0', '0', '1', '0', null, '', null, null, '0', null);
INSERT INTO `user` VALUES ('8', 'aaaaa', '翘首翘首翘首', 'http://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJtxfkusaicfaFaPfspIxyPvA1TeSzHiahAr6eGrmVN5oKH8oB3x65su1sMTtk9MicFLIQiaTdlWOsBWg/132', 'avatar/202001/1578040207_3474.png', '1578622845', '1578709245', '1', '5', 'poster/8_5.png', null, 'wecha5&lt;script&gt;', 'account5&lt;js&gt;', '55', null);
