create table PERSONNE(
    id int primary key,
    nom varchar(20),
    prenom varchar(20),
    adresse varchar(50),
    mail varchar(30),
    age int
);

create table ADHERANT(
    idA int primary key,
    poidsA int,
    niveauA varchar(20)
);

create table MONITEUR(
    idM int primary key,
    salaireM int,
    anneeRecrutement int
);

create table PONEY(
    idP int primary key,
    nomP varchar(20) unique,
    poidsMax int
);

create table CRENEAU(
    dateC date,
    heureC time,
    primary key(dateC, heureC)
);

create table COURS(
    idC int primary key,
    nomC varchar(40),
    nbPersMax int,
    dureeC int,
    idM int,
    dateC date,
    heureC time,
    niveauC varchar(20)
);

create table RESERVER(
    idA int,
    idP int,
    idC int,
    primary key(idA, idP, idC)
);

alter table ADHERANT add foreign key (idA) references PERSONNE (id);
alter table MONITEUR add foreign key (idM) references PERSONNE (id);
alter table COURS add foreign key (idM) references MONITEUR (id);
alter table COURS add foreign key (dateC) references CRENEAU (dateC);
alter table COURS add foreign key (heureC) references CRENEAU (heureC);
alter table RESERVER add foreign key(idA) references ADHERANT (id);
alter table RESERVER add foreign key (idP) references PONEY (idP);
alter table RESERVER add foreign key (idC) references COURS (idC);

