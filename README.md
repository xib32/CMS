# CMS
Svrha ovog rada je demonstrirati stečena znanja iz PHP-a te MySQL-a. 

Cilj ovog CMS-a je postavljanje obavjesti na web stranicu, imamo tri kategorije:
	-Novosti: Osnovne obavjesti
	-Galerije: Obavjesti kojima je primarna svrha prikaz veće količine slika
	-Događaji: Obavjesti o nadolazećim događanjima
	
Sve vrste obavjesti imaju predviđenu mogućnost postavljanja slika i teksta.
CMS je u stanju brisati i mjenjati obavjesti, slike i tekstove.

Ideja ovog projekta je da bude template za rad na izgradnji jednostavnih web stranica koji će biti lagano za nadograđivati s obzirom
na individualne potrebe projekta.

U db/csm.sql file-u se nalazi baza podataka koju je potrebno postaviti da bi projekt funkcionirao
	-DROP DATABASE otkomentirati ukoliko baza već postoji na serveru
index.php - namjenjen da samo prikazuje podatke, sa gledišta korisnika
admin.php - namjenjen za unos podataka, potreban login
default Admin podaci:
	Username:admin
	Password:41244124
