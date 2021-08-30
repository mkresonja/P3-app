create database mkresonja_20_20 default character set utf8;
use mkresonja_20_20;
create table ontologija(
    sifra int not null primary key auto_increment,
    naslov varchar(255),
    autor varchar(255),
    izdavac varchar(255),
    zanr varchar(255),
      brojStranica int
);
insert into ontologija(naslov,autor,izdavac,zanr,brojStranica)
values ('Misery','Stephen King','Lumen','Triler',293),
('Prijelazi','Stephen King','Vorto Palabra','Fantasy',319),
('Revoleraš','Alex Landragin','Lumen','Fantasy',207),
('Sova','Samuel Bjork','Znanje','Kriminalistički roman',433),
('Vreća kostiju','Stephen King','Algoritam','Horor',447),
('Zelena milja','Stephen King','SysPrint','Fantasy',595),
('1984.','George Orwell','Šareni dućan','Distopijska fikcija',350)

select * from ontologija 

DELETE FROM ontologija
WHERE sifra = 1;
