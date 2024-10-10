-- Le nombre de personnes inscrites à un cours est inférieur au nombre maximum de personnes inscrites

delimiter |
create or replace trigger nbPersInferieurANbMax before insert on RESERVER for each row
begin
    declare mes varchar(200) default "";
    declare persMax int;
    declare currNbPers int;
    select nbPersMax into persMax from COURS where idC=new.idC;
    select count(idA) into currNbPers from RESERVER where idC=new.idC;
    if currNbPers+1>persMax then
        set mes=concat('Réservation impossible. Le cours ', new.idC, ' est complet');
        signal SQLSTATE '45000' set MESSAGE_TEXT=mes;
    end if;
end |


-- Le niveau de l'adhérent doit correspondre au niveau du cours qu'il réserve

create or replace trigger niveauxCorresponds before insert on RESERVER for each row
begin
    declare mes varchar(200) default "";
    declare nivCours varchar(20);
    declare nivAdherant varchar(20);
    select niveauA into nivAdherant from ADHERANT where idA = new.idA;
    select niveauC into nivCours from COURS where idC = new.idC;
    if nivAdherant != nivCours then
        set mes = concat("Réservation impossible. L'adhérent ", new.ida, " n'a pas le niveau du cours.");
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes;
    end if;
end |

--Les poneys ne peuvent pas porter un cavalier jusqu'à un certain poids (différents pour chaque poney)

create or replace trigger poidsCavalierInferieurAPoidsMax before insert on RESERVER for each row
begin
    declare mes varchar(200) default "";
    declare poidsCavalier int(4);
    declare poidsMaxPoney int(4);
    declare nomCavalier varchar(20);
    declare prenomCavalier varchar(20);
    select nom into nomCavalier from PERSONNE where id=new.idA;
    select prenom into prenomCavalier from PERSONNE where id=new.idA;
    select poidsA into poidsCavalier from ADHERANT where idA=new.idA;
    select poidsMax into poidsMaxPoney from PONEY where idP=new.idP;
    if poidsCavalier>poidsMaxPoney then
        set mes=concat("Réservation impossible. Avec un poids de ", poidsCavalier, ", l'adhérant ",prenomCavalier, " ", nomCavalier, " a un poids supérieur au poids maximum du poney : ", poidsMaxPoney);
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes;
    end if;
end |


-- create or replace trigger tempsReposSuffisant before insert on RESERVER for each row
-- begin
--     declare mes varchar(200) default "";
--     declare idPoney int;
--     declare idCours int;
--     declare heureCreneau hour;
--     declare minuteCreneau minute;
--     declare dateCreneau date;
--     declare dureeCours int;
--     -- declare fini boolean default false;
--     -- declare lesCours cursor for select idC from COURS where;
--     select idP, idC into idPoney, idCours from RESERVER where idA=new.idA and idP=new.idP and idC=new.idC;
--     select hour(heureC), minute(heureC), dateC, dureeC into heureCreneau, minuteCreneau, dateCreneau, dureeCours from COURS where idC=idCours;

    


-- delimiter ;



CREATE or replace TRIGGER check_poney_repos BEFORE INSERT ON RESERVER FOR EACH ROW
BEGIN
    DECLARE cours_duree INT;
    declare dateCoursNew date;
    DECLARE heureCoursNew TIME;
    
    -- Récupérer la durée du cours réservé (2 heures par exemple)
    SELECT dureeC INTO cours_duree
    FROM COURS
    WHERE idC = NEW.idC;
    select dateC into dateCoursNew from COURS where idC = NEW.idC;
    select heureC into heureCoursNew from COURS where idC = NEW.idC;


    -- Vérifier si le poney a été réservé dans les 2 heures avant ce cours
    IF (cours_duree = 2) then
        IF EXISTS (
            SELECT 1
            FROM RESERVER R
            JOIN COURS C ON R.idC = C.idC
            WHERE R.idP = NEW.idP
            AND TIMESTAMPDIFF(HOUR, CONCAT(C.dateC, ' ', C.heureC), CONCAT(dateCoursNew, ' ', heureCoursNew)) < (2 + cours_duree)
        ) THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Ce poney doit se reposer pendant une heure après avoir fait deux heures de cours.';
        END IF;
    END IF;  
END |

DELIMITER ;