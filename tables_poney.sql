create or replace table PERSONNE(
    id int primary key,
    prenom varchar(20),
    nom varchar(20),
    adresse varchar(50),
    mail varchar(30),
    age int
);

create or replace table ADHERANT(
    idA int(20) primary key,
    poidsA int,
    niveauA varchar(20)
);

create or replace table MONITEUR(
    idM int primary key,
    salaireM int,
    anneeRecrutement int
);

create or replace table PONEY(
    idP int(20) primary key,
    nomP varchar(20) unique,
    poidsMax int
);

create or replace table CRENEAU(
    dateC date,
    heureC time,
    primary key(dateC, heureC)
);

create or replace table COURS(
    idC int(20) primary key,
    nomC varchar(40),
    nbPersMax int,
    dureeC int,
    idM int,
    dateC date,
    heureC time,
    niveauC varchar(20)
);

create or replace table RESERVER(
    idA int(20),
    idP int(20),
    idC int(20),
    primary key(idA, idP, idC)
);

-- Clés étrangères

alter table ADHERANT add foreign key (idA) references PERSONNE (id);
alter table MONITEUR add foreign key (idM) references PERSONNE (id);
alter table COURS add foreign key (idM) references MONITEUR (idM);
alter table COURS add foreign key (dateC, heureC) references CRENEAU (dateC, heureC);
alter table RESERVER add foreign key(idA) references ADHERANT (idA);
alter table RESERVER add foreign key (idP) references PONEY (idP);
alter table RESERVER add foreign key (idC) references COURS (idC);

