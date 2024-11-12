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


create or replace function poneyfatigue(idPoney int, dateCreneau date, heureCren time) returns boolean
begin
    declare compteur int default 0;
    declare idCours int;
    declare dureeCours int;
    declare result boolean default false;
    declare fini boolean default false;
    declare lesCours cursor for select idC, dureeC from COURS where dateC = dateCreneau 
        and heureC <= heureCren and ADDTIME(heureC, sec_to_time(dureec * 3600)) >= heureCren - interval 2 hour;         
    declare continue handler for not found set fini = true;
    open lesCours;
    while not fini do
        fetch lesCours into idCours, dureeCours;  
        if not fini then
            if exists (select 1 from RESERVER where idP = idPoney and idC = idCours) then
                set compteur = compteur + dureeCours;
                if compteur >= 2 then
                    set result = true;
                end if;
            end if;
        end if;
    end while;
    close lesCours;
    return result;
end |


create or replace trigger check_poney_repos before insert on RESERVER for each row
begin
    declare dateCreneau date;
    declare heureCreneau time;
    declare poneyIndisponible boolean;
    declare mes varchar(200);
    select dateC, heureC 
    into dateCreneau, heureCreneau 
    from COURS 
    where idC = new.idC;
    select poneyfatigue(new.idP, dateCreneau, heureCreneau) into poneyIndisponible;
    if poneyIndisponible then
        set mes = "réservation impossible. le poney est fatigué et doit se reposer";
        signal SQLSTATE '45000' set message_text = mes;
    end if;
end |

delimiter ;
