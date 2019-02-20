<?php

$configs = include('config.php');
$servername = $configs["servername"];
$username = $configs["username"];
$password = $configs["password"];
$dbname = $configs["dbname"];
$i = 1;

$sql[1] = "CREATE SCHEMA IF NOT EXISTS `evl` DEFAULT CHARACTER SET utf8";

$sql[2] = "USE evl";

$sql[3] = "CREATE TABLE IF NOT EXISTS `evl`.`imported` (
  `router` VARCHAR(4) NOT NULL,
  `date` DATE NOT NULL,
  `id` TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (`router`, `date`, `id`))
  ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8";

$sql[4] = "CREATE TABLE IF NOT EXISTS `evl`.`time` (
  `year` YEAR(4) NOT NULL,
  `month` CHAR(2) NOT NULL,
  PRIMARY KEY (`year`, `month`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8";

$sql[5] = "CREATE TABLE IF NOT EXISTS `evl`.`info` (
  `idPrimaryKey` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `router` VARCHAR(4) NOT NULL,
  `datetime` DATETIME NOT NULL,
  `FW` VARCHAR(45) NOT NULL,
  `prio` TINYINT UNSIGNED NOT NULL,
  `id` INT UNSIGNED NOT NULL,
  `rev` TINYINT UNSIGNED NOT NULL,
  `event` VARCHAR(45) NOT NULL,
  `rule` VARCHAR(45) NOT NULL,
  `time_year` YEAR(4) NOT NULL,
  `time_month` CHAR(2) NOT NULL,
  PRIMARY KEY (`idPrimaryKey`),
  INDEX `fk_info_time1_idx` (`time_year` ASC, `time_month` ASC),
  CONSTRAINT `fk_info_time1`
    FOREIGN KEY (`time_year` , `time_month`)
    REFERENCES `evl`.`time` (`year` , `month`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB";

$sql[6] = "CREATE TABLE IF NOT EXISTS `evl`.`more_info` (
    `descriptionKey` INT NOT NULL AUTO_INCREMENT,
    `ipproto` VARCHAR(10) NULL,
    `ipdatalen` TINYINT UNSIGNED NULL,
    `srcport` SMALLINT UNSIGNED NULL,
    `destport` SMALLINT UNSIGNED NULL,
    `tcphdrlen` TINYINT UNSIGNED NULL,
    `syn` TINYINT UNSIGNED NULL,
    `ece` TINYINT UNSIGNED NULL,
    `cwr` TINYINT UNSIGNED NULL,
    `ttl` TINYINT UNSIGNED NULL,
    `ttlmin` TINYINT UNSIGNED NULL,
    `udptotlen` TINYINT UNSIGNED NULL,
    `ipaddr` VARCHAR(45) NULL,
    `iface` VARCHAR(45) NULL,
    `origsent` SMALLINT UNSIGNED NULL,
    `termsent` SMALLINT UNSIGNED NULL,
    `conntime` SMALLINT UNSIGNED NULL,
    `conn` VARCHAR(20) NULL,
    `action` VARCHAR(45) NULL,
    `badflag` VARCHAR(45) NULL,
    `rule` VARCHAR(45) NULL,
    `recvif` VARCHAR(45) NULL,
    `srcip` VARCHAR(45) NULL,
    `destip` VARCHAR(45) NULL,
    `ipdf` TINYINT UNSIGNED NULL,
    `info_idPrimaryKey` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`descriptionKey`),
    INDEX `fk_description_info1_idx` (`info_idPrimaryKey` ASC),
    CONSTRAINT `fk_description_info1`
      FOREIGN KEY (`info_idPrimaryKey`)
      REFERENCES `evl`.`info` (`idPrimaryKey`)
      ON DELETE CASCADE
      ON UPDATE NO ACTION)
  ENGINE = InnoDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }else{
        while($i != 7){
            if($conn->query($sql[$i]) === TRUE){
                echo $sql[$i] . "<br>";
            }else{
                echo "něco se nepodařilo :/<br>";
            }
            $i++;
        }
    }

}else{
    echo "db už exituje<br>";
}

?>