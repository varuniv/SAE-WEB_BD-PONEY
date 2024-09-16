create table PERSONNE(
    id int primary key,
    nom varchar(20),
    prenom varchar(20),
    adresse varchar(50),
    mail varchar(30),
    age int
);

create table ADHERANT(
    id int primary key,
    poidsA int,
    niveauA varchar(20)
);

create table MONITEUR(
    id int primary key,
    salaireM int,
    anneeRecrutement int
);

create table PONEY(
    idP int primary key,
    poidsMax int
);

create table CRENEAU(
    dateC date,
    heureC time,
    primary key(dateC, heureC)
);

create table COURS(
    idC int primary key,
    nbPers int,
    dureeC int,
    idM int,
    niveauC varchar(20)
);

create table RESERVER(
    idA int,
    idP int,
    idC int,
    primary key(idA, idP, idC)
);

alter table COURS add foreign key (idM) references MONITEUR (idM);
alter table RESERVER add foreign key(idA) references ADHERANT (idA);
alter table RESERVER add foreign key (idP) references PONEY (idP);
alter table RESERVER add foreign key (idC) references COURS (idC);