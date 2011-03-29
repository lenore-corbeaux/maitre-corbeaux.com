-- -----------------------------------------------------
-- Table `ActivitySource`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ActivitySource` (
  `idActivitySource` INT NOT NULL AUTO_INCREMENT ,
  `slugActivitySource` VARCHAR(20) NOT NULL ,
  `nameActivitySource` VARCHAR(20) NOT NULL ,
  `linkActivitySource` VARCHAR(255) NOT NULL ,
  `addedDateActivitySource` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`idActivitySource`) ,
  UNIQUE INDEX `uniqueSlugActivitySource` (`slugActivitySource` ASC) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Initial data for `ActivitySource` table
-- -----------------------------------------------------
INSERT INTO `ActivitySource`(`slugActivitySource`, `nameActivitySource`, `linkActivitySource`)
VALUES ('twitter', 'Twitter', 'http://twitter.com/lucascorbeaux'),
('developpezCom', 'Blog Developpez.com', 'http://blog.developpez.com/lucas-corbeaux/'),
('github', 'Github', 'http://www.github.com/lucascorbeaux');

-- -----------------------------------------------------
-- Table `ActivityItem`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `ActivityItem` (
  `idActivityItem` INT NOT NULL AUTO_INCREMENT ,
  `titleActivityItem` VARCHAR(255) NOT NULL ,
  `descriptionActivityItem` VARCHAR(255) NULL ,
  `linkActivityItem` VARCHAR(255) NOT NULL ,
  `externalIdActivityItem` VARCHAR(255) NOT NULL ,
  `publicationDateActivityItem` DATETIME NOT NULL ,
  `addedDateActivityItem` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `idActivitySourceActivityItem` INT NOT NULL ,
  PRIMARY KEY (`idActivityItem`) ,
  INDEX `fkIdActivitySourceActivityItem` (`idActivitySourceActivityItem` ASC) ,
  UNIQUE INDEX `uniqueExternalIdActivityItemIdActivitySourceActivityItem` (`externalIdActivityItem` ASC, `idActivitySourceActivityItem` ASC) ,
  CONSTRAINT `fkIdActivitySourceActivityItem`
    FOREIGN KEY (`idActivitySourceActivityItem` )
    REFERENCES `ActivitySource` (`idActivitySource` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;