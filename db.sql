/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.7.19 : Database - quick_mysql_test_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `_users` */

DROP TABLE IF EXISTS `_users`;

CREATE TABLE `_users` (
  `pk_user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_addr` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`pk_user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `_users` */

insert  into `_users`(`pk_user_id`,`first_name`,`last_name`,`email_addr`) values (1,'Yardley','Mckinney','massa.Mauris@augueid.ca'),(2,'Edan','Logan','aptent.taciti@vehiculaetrutrum.org'),(3,'Nero','Pacheco','fermentum.risus@fringillaeuismodenim.ca'),(4,'Ezra','Jefferson','sem.ut.dolor@facilisis.com'),(5,'Thomas','Stein','rutrum@facilisiseget.co.uk'),(6,'Talon','Floyd','sit.amet@justoProinnon.com'),(7,'Arsenio','Snyder','Proin.nisl@faucibuslectusa.co.uk'),(8,'Reuben','Cook','metus.eu@purussapien.co.uk'),(9,'Chaney','Gutierrez','Morbi.metus@magnisdis.co.uk'),(10,'Cyrus','Stone','lacus.Etiam@elementumat.com'),(11,'Judah','Mccall','dolor.Fusce@neque.edu'),(12,'Amal','Moore','vitae.semper.egestas@quislectus.ca'),(13,'Joel','Gardner','ultricies@nonhendreritid.ca'),(14,'Macon','Wiley','ut@lobortisquispede.org'),(15,'Garrett','Stewart','dui.Fusce.aliquam@turpisnon.com'),(16,'Isaiah','Myers','orci.adipiscing.non@dolor.co.uk'),(17,'Austin','Holman','amet.orci@Nullamlobortisquam.com'),(18,'Raymond','Duran','Vivamus@sed.co.uk'),(19,'Gage','Daniel','pulvinar@nibh.ca'),(20,'Malik','Guerra','amet.luctus.vulputate@pellentesque.org'),(21,'Oliver','Simmons','sed.facilisis@necante.net'),(22,'Zachary','Cooley','Nunc.ac@vehicula.ca'),(23,'Brent','Richmond','leo.in.lobortis@et.com'),(24,'Gregory','Patton','Ut.tincidunt.orci@nec.net'),(25,'Bradley','Hatfield','vel@nullaante.co.uk'),(26,'Ian','Love','nunc.In@nuncullamcorpereu.edu'),(27,'Derek','Campos','facilisi.Sed.neque@pulvinararcuet.ca'),(28,'Tanek','Thomas','malesuada.fringilla@aliquamarcu.edu'),(29,'Harding','Nieves','odio@tellusimperdietnon.edu'),(30,'Allen','Dennis','non@sociisnatoquepenatibus.ca'),(31,'Baker','Walter','Cras.dolor@turpisvitaepurus.com'),(32,'Chadwick','Drake','sem@dui.com'),(33,'Fuller','Blackwell','est@Quisque.edu'),(34,'Zeph','Holt','Sed@Aeneaneuismod.co.uk'),(35,'Jerry','Harrington','Nam.tempor@congue.co.uk'),(36,'Clayton','Simmons','aliquam.enim@nibh.org'),(37,'Mark','Rutledge','neque.Nullam.ut@neccursusa.net'),(38,'Chancellor','Cooke','malesuada@fringillacursus.com'),(39,'Wang','Barnett','nunc.ac@nonummyac.org'),(40,'Chadwick','Michael','dui@nasceturridiculus.co.uk'),(41,'Hu','Curry','hendrerit@cursus.com'),(42,'Graham','Rich','porttitor@atiaculisquis.edu'),(43,'Len','Woodard','nibh.enim@ultriciesadipiscingenim.net'),(44,'Martin','Jones','In@Quisque.com'),(45,'Herrod','Levy','consectetuer.ipsum.nunc@sodaleselit.ca'),(46,'Palmer','Hendricks','at.pretium@natoque.edu'),(47,'Keith','Brock','convallis.convallis.dolor@est.co.uk'),(48,'Clayton','Shaw','non.vestibulum.nec@quistristique.co.uk'),(49,'Steel','Macias','interdum.Nunc@massaMaurisvestibulum.net'),(50,'Tyrone','Baxter','aliquam.iaculis.lacus@acnullaIn.ca'),(51,'Branden','Maxwell','at@Duisat.com'),(52,'Chester','Green','placerat.augue@urna.com'),(53,'Reuben','Willis','augue.eu.tellus@sitamet.com'),(54,'Hashim','Atkinson','ornare@aceleifendvitae.net'),(55,'Mohammad','Taylor','Fusce.mi@diamdictum.ca'),(56,'Baker','Graham','amet.diam@aliquam.co.uk'),(57,'Abel','Hewitt','Mauris.quis@nisiCum.com'),(58,'Igor','Hutchinson','lobortis@vehicularisus.net'),(59,'Jasper','Owens','erat@dignissim.com'),(60,'Fritz','Newton','convallis.erat@malesuada.edu'),(61,'Colin','Delgado','lorem.eu.metus@velarcu.net'),(62,'Macaulay','Britt','tempor.augue.ac@semutcursus.net'),(63,'Xavier','Nolan','placerat@sagittissemper.com'),(64,'Forrest','Wallace','dui.augue.eu@aliquetmagnaa.net'),(65,'Deacon','Ochoa','mollis.Phasellus@magnisdis.ca'),(66,'Barclay','Richmond','lobortis@nascetur.edu'),(67,'Derek','Cooper','Sed.nec.metus@Nunclectuspede.net'),(68,'Upton','Conrad','auctor.non.feugiat@arcu.edu'),(69,'Thane','Salazar','Aliquam@ornarelectus.ca'),(70,'Hasad','Kline','Nunc.mauris@augueeu.edu'),(71,'Connor','Bond','gravida.mauris@necluctusfelis.co.uk'),(72,'Lane','Black','risus.quis.diam@nequepellentesquemassa.co.uk'),(73,'Benedict','Weiss','adipiscing.Mauris@Duisami.co.uk'),(74,'Russell','Bryan','purus.in.molestie@indolor.net'),(75,'Benjamin','Floyd','Cras.vehicula@urnaVivamusmolestie.edu'),(76,'Gannon','Spencer','enim.sit@aliquetmolestietellus.co.uk'),(77,'Reed','Dixon','semper.rutrum@Inscelerisque.net'),(78,'Hashim','Gibson','penatibus.et.magnis@malesuadavel.org'),(79,'Ulric','Kirby','eleifend.Cras.sed@cursusin.com'),(80,'Xanthus','Harvey','hymenaeos@et.net'),(81,'Benjamin','Maldonado','penatibus.et@dolor.com'),(82,'Laith','Bond','et@congueturpisIn.org'),(83,'Alexander','Singleton','nulla@egestas.com'),(84,'Alec','Hendrix','Cras@vehiculaaliquet.ca'),(85,'Oleg','Cline','hendrerit.a.arcu@temporeratneque.ca'),(86,'Ryder','Randall','ac.turpis.egestas@asollicitudinorci.net'),(87,'Devin','Prince','Donec.elementum.lorem@Sedauctor.net'),(88,'Dominic','Arnold','eget.metus.eu@gravida.edu'),(89,'Harrison','Kinney','non.sapien@faucibusutnulla.ca'),(90,'Ulric','Stuart','amet@eudolor.com'),(91,'Scott','Charles','nec.mollis.vitae@liberoMorbi.net'),(92,'Asher','Slater','malesuada.id.erat@ornareIn.org'),(93,'Randall','Booth','montes@Duisami.ca'),(94,'Isaiah','Colon','a@purussapiengravida.edu'),(95,'Benedict','Sawyer','arcu.Curabitur.ut@morbitristique.com'),(96,'Edan','Parker','amet@velsapien.org'),(97,'Raymond','Benton','metus.sit.amet@Vivamusmolestiedapibus.com'),(98,'Perry','Gordon','mattis.semper.dui@Quisqueporttitor.net'),(99,'Odysseus','Curtis','ipsum.dolor@Suspendisseacmetus.co.uk'),(100,'Curran','Dodson','vel.nisl@netuset.co.uk');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
