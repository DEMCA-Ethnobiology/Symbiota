CREATE TABLE `ethnocollcommlink` (
  `ethCollCommLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commID` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollCommLinkID`),
  KEY `collID` (`collID`),
  KEY `commID` (`commID`)
);

CREATE TABLE `ethnocolllanglink` (
  `ethCollLangLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collID` int(10) NOT NULL,
  `langID` varchar(45) DEFAULT NULL,
  `fileurl` varchar(250) DEFAULT NULL,
  `filetopic` varchar(45) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollLangLinkID`),
  KEY `collID` (`collID`),
  KEY `langID` (`langID`)
);

CREATE TABLE `ethnocollpercommlink` (
  `ethCollPerCommLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perID` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `commID` int(10) DEFAULT NULL,
  `resident` int(1) DEFAULT NULL,
  `commcomments` varchar(100) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollPerCommLinkID`),
  KEY `perID` (`perID`),
  KEY `collID` (`collID`),
  KEY `commID` (`commID`),
  KEY `resident` (`resident`)
);

CREATE TABLE `ethnocollperlanglink` (
  `ethCollPerLangLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perID` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `langID` varchar(45) DEFAULT NULL,
  `langcomments` varchar(100) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollPerLangLinkID`),
  KEY `perID` (`perID`),
  KEY `collID` (`collID`),
  KEY `langID` (`langID`)
);

CREATE TABLE `ethnocollperlink` (
  `ethCollPerLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perID` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `rolearr` varchar(1000) DEFAULT NULL,
  `rolecomments` varchar(100) DEFAULT NULL,
  `projectCode` varchar(45) DEFAULT NULL,
  `defaultdisplay` varchar(10) DEFAULT NULL,
  `residenceCommunity` int(10) DEFAULT NULL,
  `residenceStatus` varchar(15) DEFAULT NULL,
  `birthCommunity` int(10) DEFAULT NULL,
  `commcomments` varchar(100) DEFAULT NULL,
  `targetLanguage` varchar(45) DEFAULT NULL,
  `targetLangQual` varchar(15) DEFAULT NULL,
  `secondLanguage` varchar(45) DEFAULT NULL,
  `secondLangQual` varchar(15) DEFAULT NULL,
  `thirdLanguage` varchar(45) DEFAULT NULL,
  `thirdLangQual` varchar(15) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollPerLinkID`),
  KEY `perID` (`perID`),
  KEY `collID` (`collID`),
  KEY `projectCode` (`projectCode`),
  KEY `defaultdisplay` (`defaultdisplay`)
);

CREATE TABLE `ethnocollreflink` (
  `ethCollRefLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refid` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCollRefLinkID`),
  KEY `collID` (`collID`),
  KEY `refid` (`refid`)
);

CREATE TABLE `ethnocommlanglink` (
  `ethCommLangLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `commID` int(10) NOT NULL,
  `collID` int(10) NOT NULL,
  `langID` varchar(45) NOT NULL,
  `linktype` varchar(25) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethCommLangLinkID`),
  KEY `commID` (`commID`),
  KEY `langID` (`langID`),
  KEY `linktype` (`linktype`),
  KEY `collID` (`collID`)
);

CREATE TABLE `ethnocommunity` (
  `ethComID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `communityname` varchar(100) NOT NULL,
  `country` varchar(64) NOT NULL,
  `stateProvince` varchar(255) NOT NULL,
  `county` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `decimalLatitude` double DEFAULT NULL,
  `decimalLongitude` double DEFAULT NULL,
  `elevationInMeters` int(6) DEFAULT NULL,
  `languagecomments` varchar(1000) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethComID`),
  KEY `communityname` (`communityname`),
  KEY `country` (`country`),
  KEY `stateProvince` (`stateProvince`),
  KEY `county` (`county`),
  KEY `decimalLatitude` (`decimalLatitude`),
  KEY `decimalLongitude` (`decimalLongitude`),
  KEY `elevationInMeters` (`elevationInMeters`),
  KEY `municipality` (`municipality`)
);

CREATE TABLE `ethnodata` (
  `ethdid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `occid` int(10) DEFAULT NULL,
  `etheventid` int(10) DEFAULT NULL,
  `tid` int(10) DEFAULT NULL,
  `refpages` varchar(50) DEFAULT NULL,
  `verbatimVernacularName` varchar(500) DEFAULT NULL,
  `annotatedVernacularName` varchar(500) DEFAULT NULL,
  `verbatimLanguage` varchar(255) DEFAULT NULL,
  `langId` varchar(255) DEFAULT NULL,
  `otherVerbatimVernacularName` varchar(500) DEFAULT NULL,
  `otherLangId` varchar(255) DEFAULT NULL,
  `verbatimParse` varchar(500) DEFAULT NULL,
  `annotatedParse` varchar(500) DEFAULT NULL,
  `verbatimGloss` varchar(500) DEFAULT NULL,
  `annotatedGloss` varchar(500) DEFAULT NULL,
  `typology` varchar(20) DEFAULT NULL,
  `translation` varchar(1000) DEFAULT NULL,
  `taxonomicDescription` varchar(500) DEFAULT NULL,
  `nameDiscussion` varchar(1000) DEFAULT NULL,
  `consultantComments` varchar(1000) DEFAULT NULL,
  `useDiscussion` varchar(1000) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethdid`),
  KEY `occid` (`occid`),
  KEY `tid` (`tid`),
  KEY `langId` (`langId`),
  KEY `typology` (`typology`),
  KEY `verbatimVernacularName` (`verbatimVernacularName`),
  KEY `verbatimParse` (`verbatimParse`),
  KEY `verbatimGloss` (`verbatimGloss`),
  KEY `translation` (`translation`),
  KEY `etheventid` (`etheventid`),
  KEY `annotatedVernacularName` (`annotatedVernacularName`),
  KEY `annotatedParse` (`annotatedParse`),
  KEY `annotatedGloss` (`annotatedGloss`),
  KEY `otherLangId` (`otherLangId`)
);

CREATE TABLE `ethnodataevent` (
  `etheventid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collid` int(10) DEFAULT NULL,
  `occid` int(10) DEFAULT NULL,
  `refid` int(10) DEFAULT NULL,
  `ethComID` int(10) DEFAULT NULL,
  `datasource` varchar(100) DEFAULT NULL,
  `eventdate` varchar(100) DEFAULT NULL,
  `eventlocation` varchar(255) DEFAULT NULL,
  `namedatadiscussion` varchar(5000) DEFAULT NULL,
  `usedatadiscussion` varchar(5000) DEFAULT NULL,
  `consultantdiscussion` varchar(5000) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`etheventid`),
  KEY `collid` (`collid`),
  KEY `refid` (`refid`),
  KEY `datasource` (`datasource`),
  KEY `ethComID` (`ethComID`),
  KEY `eventdate` (`eventdate`),
  KEY `eventlocation` (`eventlocation`),
  KEY `occid` (`occid`)
);

CREATE TABLE `ethnodataeventperlink` (
  `ethdplinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `etheventid` int(10) DEFAULT NULL,
  `ethPerID` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethdplinkid`),
  KEY `etheventid` (`etheventid`),
  KEY `ethPerID` (`ethPerID`)
);

CREATE TABLE `ethnodatanamesemtaglink` (
  `ethntaglinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethdid` int(10) DEFAULT NULL,
  `ethTagId` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethntaglinkid`),
  KEY `ethTagId` (`ethTagId`),
  KEY `ethdid` (`ethdid`)
);

CREATE TABLE `ethnodatapersonnellink` (
  `ethdplinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethdid` int(10) DEFAULT NULL,
  `ethPerID` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethdplinkid`),
  KEY `ethPerID` (`ethPerID`),
  KEY `ethdid` (`ethdid`)
);

CREATE TABLE `ethnodatausepartslink` (
  `ethuptlinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethdid` int(10) DEFAULT NULL,
  `ethpuid` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethuptlinkid`),
  KEY `ethpuid` (`ethpuid`),
  KEY `ethdid` (`ethdid`)
);

CREATE TABLE `ethnodatausetaglink` (
  `ethutaglinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethdid` int(10) DEFAULT NULL,
  `ethuoid` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethutaglinkid`),
  KEY `ethuoid` (`ethuoid`),
  KEY `ethdid` (`ethdid`)
);

CREATE TABLE `ethnolinkages` (
  `ethlinkid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethdid` int(10) DEFAULT NULL,
  `ethdidlink` int(10) DEFAULT NULL,
  `linktype` varchar(50) DEFAULT NULL,
  `refid` int(10) DEFAULT NULL,
  `refpages` varchar(50) DEFAULT NULL,
  `discussion` varchar(5000) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethlinkid`),
  KEY `linktype` (`linktype`),
  KEY `refid` (`refid`),
  KEY `ethdid` (`ethdid`),
  KEY `ethdidlink` (`ethdidlink`)
);

CREATE TABLE `ethnomedia` (
  `ethmediaid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collid` int(10) DEFAULT NULL,
  `url` varchar(250) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `eaffile` varchar(250) DEFAULT NULL,
  `displaySettings` text,
  `initialtimestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethmediaid`),
  KEY `eaffile` (`eaffile`),
  KEY `collid` (`collid`)
);

CREATE TABLE `ethnomedocclink` (
  `ethMedOccLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethmediaid` int(10) NOT NULL,
  `occid` int(10) NOT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethMedOccLinkID`),
  KEY `ethmediaid` (`ethmediaid`),
  KEY `occid` (`occid`)
);

CREATE TABLE `ethnomedtaxalink` (
  `ethMedTaxaLinkID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethmediaid` int(10) NOT NULL,
  `tid` int(10) NOT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethMedTaxaLinkID`),
  KEY `ethmediaid` (`ethmediaid`),
  KEY `tid` (`tid`)
);

CREATE TABLE `ethnonamesemantictags` (
  `ethTagId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentTagId` int(10) DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sortsequence` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethTagId`),
  KEY `parentTagId` (`parentTagId`),
  KEY `tag` (`tag`)
);

INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (1, NULL, 'Animal', '(plant name contains an animal name, e.g., <i>snake\'s whistle</i>)', 1);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (2, 1, 'Mammal', '(e.g., squirrel egg tree, for some Celastraceae)', 1);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (3, 1, 'Bird', '(e.g., bat wing, for <i>Passiflora</i>)', 2);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (4, 1, 'Reptile', '(e.g., snake\'s whistle, for a <i>Philodendron</i>)', 3);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (5, 1, 'Fish', '(e.g., fish tail for <i>Asplundia</i>)', 4);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (6, 1, 'Arthropod', '(e.g., ant tree, for <i>Cecropia</i>)', 5);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (7, NULL, 'Color', '(plant name contains reference to a color)', 2);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (8, NULL, 'Habitat', '(name contains reference to habitat or ecosystem, \'swamp flower\')', 3);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (9, NULL, 'Morphology', '(plant name refers to an aspect of its morphology, e.g., sticky)', 4);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (10, 9, 'Leaf morphology', '(e.g., narrow-leaf May flower)', 1);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (11, 9, 'Wood/trunk/branch morphology', '(e.g., smooth-bark X)', 2);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (12, 9, 'Texture', '(e.g., sandy leaf)', 3);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (13, NULL, 'Other plant', '(plant name refers to another plant, the \'daisy look-alike\')', 5);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (14, NULL, 'Senses', '(plant name contains a reference to the senses, e.g., smell or feeling)', 6);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (15, NULL, 'Use', '(plant name refers to use, e.g., \'broom\', \'scorpion medicine\')', 7);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (16, NULL, 'Host plant', '(can be used for parasitic plants, or for animals, particularly arthropods)', 8);
INSERT INTO `ethnonamesemantictags`(`ethTagId`, `parentTagId`, `tag`, `description`, `sortsequence`) VALUES (17, NULL, 'Onomatopoeia', '(particularly useful to tag bird names, \'whippoorwill\')', 9);

CREATE TABLE `ethnopersonnel` (
  `ethPerID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) DEFAULT NULL,
  `birthyear` int(4) DEFAULT NULL,
  `birthyearestimation` varchar(25) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `sexcomments` varchar(100) DEFAULT NULL,
  `birthcommunityID` int(10) DEFAULT NULL,
  `primarylanguageID` varchar(45) DEFAULT NULL,
  `InitialTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethPerID`),
  KEY `title` (`title`),
  KEY `firstname` (`firstname`),
  KEY `lastname` (`lastname`),
  KEY `birthcommunityID` (`birthcommunityID`),
  KEY `primarylanguageID` (`primarylanguageID`)
);

CREATE TABLE `ethnopersonnelroles` (
  `roleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `roleName` varchar(45) CHARACTER SET latin1 NOT NULL,
  `sortSeq` int(10) DEFAULT NULL,
  PRIMARY KEY (`roleID`),
  KEY `roleName` (`roleName`)
);

INSERT INTO `ethnopersonnelroles` VALUES (1, 'Annotator/commentator', 1);
INSERT INTO `ethnopersonnelroles` VALUES (2, 'Consultant, native-speaker', 2);
INSERT INTO `ethnopersonnelroles` VALUES (3, 'Consultant, non-native speaker', 3);
INSERT INTO `ethnopersonnelroles` VALUES (4, 'Craftsman/woman', 4);
INSERT INTO `ethnopersonnelroles` VALUES (5, 'Data capture', 5);
INSERT INTO `ethnopersonnelroles` VALUES (6, 'Field biologist', 6);
INSERT INTO `ethnopersonnelroles` VALUES (7, 'Food specialist', 7);
INSERT INTO `ethnopersonnelroles` VALUES (8, 'Hunter/trapper', 8);
INSERT INTO `ethnopersonnelroles` VALUES (9, 'Interpreter', 9);
INSERT INTO `ethnopersonnelroles` VALUES (10, 'Interviewer', 10);
INSERT INTO `ethnopersonnelroles` VALUES (11, 'Medicinal specialist', 11);
INSERT INTO `ethnopersonnelroles` VALUES (12, 'Musician', 12);
INSERT INTO `ethnopersonnelroles` VALUES (13, 'Narrator', 13);
INSERT INTO `ethnopersonnelroles` VALUES (14, 'Photographer', 14);
INSERT INTO `ethnopersonnelroles` VALUES (15, 'Researcher', 15);
INSERT INTO `ethnopersonnelroles` VALUES (16, 'Ritual specialist', 16);
INSERT INTO `ethnopersonnelroles` VALUES (17, 'Singer', 17);
INSERT INTO `ethnopersonnelroles` VALUES (18, 'Transcriber', 18);
INSERT INTO `ethnopersonnelroles` VALUES (19, 'Translator', 19);
INSERT INTO `ethnopersonnelroles` VALUES (20, 'Other', 20);

CREATE TABLE `ethnotaxapartsused` (
  `ethpuid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sortsequence` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethpuid`),
  KEY `tid` (`tid`),
  KEY `description` (`description`)
);

INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (1, 4, 'Whole organism', 1);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (2, 4, 'Aerial (above ground) parts of plant', 2);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (3, 4, 'Root, rhizome, tuber, bulb, corm (underground parts of plant)', 3);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (4, 4, 'Stem or stalk (not woody)', 4);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (5, 4, 'Leaf', 5);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (6, 4, 'Tender leaf and/or shoot', 6);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (7, 4, 'Bark or fiber', 7);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (8, 4, 'Wood or woody trunk or branch', 8);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (9, 4, 'Fruit, seed, or spore', 9);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (10, 4, 'Flower', 10);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (11, 4, 'Spike, thorn, prickle', 11);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (12, 4, 'Sap, resin, latex', 12);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (13, 4, 'Not reported', 13);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (14, 5, 'Whole organism', 1);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (15, 5, 'Stem (stipe)', 2);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (16, 5, 'Cap', 3);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (17, 5, 'Not reported', 4);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (18, 6, 'Whole animal (e.g., worms for bait)', 1);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (19, 6, 'Fur, skin', 2);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (20, 6, 'Meat', 3);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (21, 6, 'Larvae', 4);
INSERT INTO `ethnotaxapartsused`(`ethpuid`, `tid`, `description`, `sortsequence`) VALUES (22, 6, 'Teeth, bones', 5);

CREATE TABLE `ethnotaxauseheaders` (
  `ethuhid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tid` int(10) DEFAULT NULL,
  `headerText` varchar(255) DEFAULT NULL,
  `sortsequence` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethuhid`),
  KEY `tid` (`tid`),
  KEY `headerText` (`headerText`)
);

INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (1, 4, 'Consumption (human foods and beverages)', 1);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (2, 4, 'Fodder (animals)', 2);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (3, 4, 'Construction and fencing', 3);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (4, 4, 'Medicine for humans', 4);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (5, 4, 'Medicine for animals (veterinary)', 5);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (6, 4, 'Treatment', 6);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (7, 4, 'Tools and material culture (not Consumption)', 7);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (8, 4, 'Sound production', 8);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (9, 4, 'Fuel', 9);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (10, 4, 'Hunting', 10);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (11, 4, 'Fishing', 11);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (12, 4, 'Commercial', 12);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (13, 4, 'Ritual and ornamental', 13);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (14, 5, NULL, 1);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (15, 6, NULL, 1);
INSERT INTO `ethnotaxauseheaders`(`ethuhid`, `tid`, `headerText`, `sortsequence`) VALUES (16, 4, 'Prognosticator', 14);

CREATE TABLE `ethnouseoptions` (
  `ethuoid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ethuhid` int(10) DEFAULT NULL,
  `optionText` varchar(255) DEFAULT NULL,
  `sortsequence` int(10) DEFAULT NULL,
  `initialtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ethuoid`),
  KEY `ethuhid` (`ethuhid`),
  KEY `optionText` (`optionText`)
);

INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (1, 1, 'Consumed raw', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (2, 1, 'Consumed cooked', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (3, 1, 'Wrapping (e.g., of cheese, meat, cooked foods)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (4, 1, 'Condiment, sauces', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (5, 1, 'Beverage', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (6, 1, 'Masticant', 6);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (7, 1, 'Famine (eaten only in times of famine)', 7);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (8, 1, 'Other (see below)', 8);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (9, 2, 'Domesticated fowl', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (10, 2, 'Domesticated mammals', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (11, 2, 'Other (see below)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (12, 3, 'House construction (frame)', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (13, 3, 'House construction (thatching)', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (14, 3, 'Fencing (planted fields, in home for housesite, corral of domesticated fowl, animal and bird cages, living fencing, thorn fencing)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (15, 3, 'Rope, fiber and other tying uses', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (16, 3, 'Other (see below)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (17, 4, 'Medicine topically applied', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (18, 4, 'Medicine ingested solid', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (19, 4, 'Medicine ingested teas', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (20, 4, 'Cleanser (soap, shampoo, toothpaste)', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (21, 4, 'Other (see below)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (22, 4, 'Use not further specified', 6);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (23, 5, 'Medicine topically applied', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (24, 5, 'Medicine ingested solid', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (25, 5, 'Other (see below)', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (26, 5, 'Use not further specified', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (27, 6, 'Abortifacient', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (28, 6, 'Aphrodisiac, narcotic', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (29, 6, 'Bone (broken, fractured)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (30, 6, 'Cleanser', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (31, 6, 'Coughing', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (32, 6, 'Cut, sore, lesion, rash', 6);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (33, 6, 'Digestive system', 7);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (34, 6, 'Diabetes', 8);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (35, 6, 'Evil eye, witchcraft, envy', 9);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (36, 6, 'Eyes, ears, or nose', 10);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (37, 6, 'Fever', 11);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (38, 6, 'Heart condition', 12);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (39, 6, 'Pain, joint, tendon, muscle', 13);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (40, 6, 'Repellant', 14);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (41, 6, 'Other (see below)', 16);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (42, 6, 'Not reported', 15);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (43, 7, 'Abrasives', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (44, 7, 'Agriculture: Plow parts', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (45, 7, 'Agriculture: Planting sticks, husking, thrashing, forked sticks', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (46, 7, 'Agriculture: Shading, seed propagation, seed protection', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (47, 7, 'Artesanry and handicrafts (not including baskets and ceramics)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (48, 7, 'Basketry', 6);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (49, 7, 'Ceramics', 7);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (50, 7, 'Cloth and clothing', 8);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (51, 7, 'Cutting instruments', 9);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (52, 7, 'Digging stick', 10);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (53, 7, 'Dye', 11);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (54, 7, 'Furniture (e.g., beds, chairs, cradles, hanging shelves)', 12);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (55, 7, 'Hammers and pounding instruments', 13);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (56, 7, 'Handle (axe, hoe)', 14);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (57, 7, 'Mat', 15);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (58, 7, 'Paint', 16);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (59, 7, 'Toys and recreation (tops, dolls)', 17);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (60, 7, 'Utensils (kitchen and food preparation utensils such as trays, wooden bowls)', 18);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (61, 7, 'Weaving tools', 19);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (62, 7, 'Other (see below)', 20);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (63, 8, 'Rattles and bells', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (64, 8, 'Flutes and whistles (wind instruments)', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (65, 8, 'Drums and percussion', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (66, 8, 'Other (see below)', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (67, 9, 'Firewood', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (68, 9, 'Tinder', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (69, 9, 'Charcoal', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (70, 10, 'Bows and arrows, slingshots, blow or dart guns', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (71, 10, 'Animal snares', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (72, 10, 'Bait', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (73, 10, 'Poison', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (74, 11, 'Fish traps', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (75, 11, 'Poison', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (76, 11, 'Bait', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (77, 12, 'Commercialized locally', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (78, 12, 'Commercialized distantly', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (79, 13, 'Garden plant', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (80, 13, 'Decorative use (rituals and home)', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (81, 13, 'Body adornment (necklaces, bracelet)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (82, 13, 'Incense', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (83, 14, 'Food', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (84, 14, 'Drug', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (85, 15, 'Food', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (86, 15, 'Pet', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (87, 15, 'Bait (fishing and hunting)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (88, 15, 'Pelts/skin for clothing', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (89, 16, 'Birth', 1);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (90, 16, 'Death', 2);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (91, 16, 'Food', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (92, 16, 'Love', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (93, 16, 'Luck-Good (enrichment, good harvest, good hunting or fishing)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (94, 16, 'Luck-Bad (impoverishment, blight, house destruction)', 6);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (96, 9, 'Other (see below)', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (97, 10, 'Other (see below)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (98, 11, 'Other (see below)', 4);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (99, 12, 'Other (see below)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (100, 13, 'Other (see below)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (101, 14, 'Other (see below)', 3);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (102, 15, 'Other (see below)', 5);
INSERT INTO `ethnouseoptions`(`ethuoid`, `ethuhid`, `optionText`, `sortsequence`) VALUES (103, 16, 'Other (see below)', 7);

