
CREATE TABLE `tbldata` (
  `dataID` int(11) NOT NULL AUTO_INCREMENT,
  `deployID` int(11) DEFAULT NULL,
  `folder` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`dataID`)
) ENGINE=InnoDB AUTO_INCREMENT=1;


CREATE TABLE `tbldeploy` (
  `deployID` int(11) NOT NULL AUTO_INCREMENT,
  `environment` varchar(45) DEFAULT NULL,
  `application_type` varchar(45) DEFAULT NULL,
  `application_version` varchar(45) DEFAULT NULL,
  `repo_location` varchar(255) DEFAULT NULL,
  `repo_protocol` varchar(255) DEFAULT NULL,
  `repo_checkoutparams` varchar(45) DEFAULT NULL,
  `repo_userID` int(11) DEFAULT NULL,
  `repo_scm` varchar(45) DEFAULT NULL,
  `web_user` varchar(45) DEFAULT NULL,
  `web_domain` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`deployID`)
) ENGINE=InnoDB AUTO_INCREMENT=1;


CREATE TABLE `tblfiles` (
  `fileID` int(11) NOT NULL AUTO_INCREMENT,
  `deployID` int(11) DEFAULT NULL,
  `file_name` varchar(45) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`fileID`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

CREATE TABLE `tblusers_repo` (
  `repouserID` int(11) NOT NULL AUTO_INCREMENT,
  `repo_username` varchar(45) DEFAULT NULL,
  `repo_password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`repouserID`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

