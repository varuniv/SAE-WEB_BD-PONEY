-- Inserts des personnes
insert into PERSONNE values (1, 'Michel', 'Dupont', '2 rue De Gaulle, Orléans', 'dupont.michel@gmail.com', 12),
                            (2,'Kirby', 'DesctructeurDesMondes', 'DreamLand,POP','poyo@gmail.com',200),
                            (101, 'Jean-Pierre', 'Polnaref', 'Tortue', 'jeanpierre@yahoo.com', 65),
                            (102, 'Toto', 'Titi', '1 rue de Tata, Olivet', 'toto@tutu.com', 18); 

-- Inserts des adhérants
insert into ADHERANT values (1, 41, 'Junior'),
                            (2, 35, 'Junior');

-- Inserts des moniteurs
insert into MONITEUR values (101, 15000, 1989),
                            (102, 4269, 2022);

-- Inserts des poneys
insert into PONEY values (151,'Moew',50),
                        (152,'Abyss',45),
                        (153,'Caramel Salé',30),
                        (154,'Caramel',50),
                        (155,'Shtorm',40);

-- Inserts des dates des cours
insert into CRENEAU values ('2024-12-01', '18:30:00'),
                           ('2024-12-01', '19:30:00');

insert into COURS values (1001, 10, 1, 101, 'Junior');