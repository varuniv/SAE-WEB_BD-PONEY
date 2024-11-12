-- Inserts des personnes
insert into PERSONNE values (1, 'Michel', 'Dupont', '2 rue De Gaulle, Orléans', 'dupont.michel@gmail.com', 12),
                            (2,'Kirby', 'NomDesMondes', 'DreamLand,POP','poyo@gmail.com',200),
                            (3, 'Jean', 'Paul', '2 avenue Toto, Bourges', 'jpaul@orange.fr', 42),
                            (4, 'Alex', 'Roger', '1 rue De Gaulle, Orléans', 'alex@mail.com', 23),
                            (5, 'Sophie', 'Lefevre', '12 rue du Parc, Nantes', 'sophie.lefevre@gmail.com', 30),
                            (6, 'Luca', 'Moretti', '3 avenue de la Mer, Nice', 'luca.moretti@hotmail.com', 27),
                            (7, 'Emma', 'Dubois', '45 boulevard de la Liberté, Lyon', 'emma.dubois@gmail.com', 35),
                            (8, 'Tom', 'Hanks', '56 rue du Cinema, Paris', 'tom.hanks@gmail.com', 50),
                            (101, 'Jean-Pierre', 'Polnaref', 'Tortue', 'jeanpierre@yahoo.com', 35),
                            (102, 'Toto', 'Titi', '1 rue de Tata, Olivet', 'toto@tutu.com', 18),
                            (103, 'Lisa', 'Atwood', 'Laferme', 'lisa.at.wood@yahoo.com', 20),
                            (104, 'Julien', 'Coucou', '1 Rue du Ranch, Chat', 'coucou@yahoo.com', 89);

-- Inserts des adhérants
insert into ADHERANT values (1, 41, 'Junior'),
                            (2, 35, 'Junior'),
                            (3, 15, 'Amateur'),
                            (4, 10, 'Espoir'),
                            (5, 12, 'Junior'),
                            (6, 17, 'Junior'),
                            (7, 16, 'Amateur'),
                            (8, 9, 'Senior');

-- Inserts des moniteurs
insert into MONITEUR values (101, 15000, 1989),
                            (102, 4269, 2022),
                            (103, 5000, 2015),
                            (104, 3000, 2021);

-- Inserts des poneys
insert into PONEY values (151,'Moew',50),
                        (152,'Abyss',45),
                        (153,'Caramel Salé',30),
                        (154,'Caramel',50),
                        (155,'Shtorm',40),
                        (156, 'Shadow', 55),
                        (157, 'Blaze', 48),
                        (158, 'Poppy', 60),
                        (159, 'Twilight', 47),
                        (160, 'Ginger', 52);

-- Inserts des dates des cours
insert into CRENEAU values ('2024-12-01', '19:00:00'),
                           ('2024-12-08', '14:00:00'),
                           ('2024-12-08', '16:00:00'),
                           ('2024-12-11', '14:00:00'),
                           ('2024-12-15', '10:00:00'),
                           ('2024-12-16', '9:00:00'),
                           ('2024-12-16', '10:00:00'),
                           ('2024-12-16', '11:00:00'),
                           ('2024-12-16', '12:00:00'),
                           ('2024-12-16', '18:00:00'),
                           ('2024-12-17', '8:00:00'),
                           ('2024-12-17', '13:00:00'),
                           ('2024-12-19','18:00:00'),
                           ('2024-12-20','9:00:00');

-- Inserts des cours 
insert into COURS values (1001,"Introdution d'equitation", 10, 2, 101,'2024-12-16', '10:00:00', 'Junior'),
                         (1002,"Entrainement d'equitation", 8, 2, 102,'2024-12-16', '11:00:00','Amateur'),
                         (1003,"Farming XP", 1, 2, 102,'2024-12-16', '18:00:00','Espoir'),
                         (1004,"Entrainement", 12, 1, 103, '2024-12-16', '9:00:00', 'Junior'),
                         (1005,"Course", 10, 2, 101, '2024-12-16', '11:00:00', 'Amateur'),
                         (1006,"Level up", 5, 1, 103, '2024-12-16', '12:00:00', 'Senior'),
                         (1007,"Cours théorique", 30, 2, 104, '2024-12-16', '18:00:00', 'Junior');

-- Inserts des réservations aux cours et des poneys
insert into RESERVER values (1, 151, 1001),
                            (2, 152, 1001),
                            (3, 153, 1002),
                            (4, 155, 1003),
                            (5, 156, 1004),
                            (6, 157, 1004),
                            (7, 157, 1005),
                            (8, 159, 1006);
