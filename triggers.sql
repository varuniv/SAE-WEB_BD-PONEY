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

-- Un créneau n'est pas compris entre 20h et 8h
create or replace trigger creneauCorrecte before insert on CRENEAU for each row
begin
    declare mes varchar(200) default "";
    if hour(new.heureC)>20 or hour(new.heureC)<8 then
        set mes=concat("Le créneau ne doit pas être compris entre 20h et 8h");
        signal SQLSTATE "45000" set MESSAGE_TEXT=mes;
    end if;
end |

-- Un poney est fatigué quand il a eu 2 heure de cours sans pause (retour true si il est fatigué)
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

-- Un poney ne peut pas être réservé tout de suite après deux heures de cours
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

-- Un cours ne peut durer plus de 2 heures

create or replace trigger dureeInferieureDureeMax before insert on COURS for each row
begin
    declare mes varchar(200) default "";
    if new.dureeC>2 then
        set mes=concat("Le cours ", new.nomC, " dure plus de 2 heures");
        signal SQLSTATE "45000" set MESSAGE_TEXT=mes;
    end if;
end |

-- Un moniteur ne peut avoir un cours qui commence pendant un autre

create or replace trigger pasDeCoursPendantUnCours before insert on COURS for each row
begin
    declare mes varchar(200) default "";
    declare fini boolean default false;
    declare dateNewCours date;
    declare heureNewCours time;
    declare dureeNewCours int default 0;
    declare dateCours date;
    declare heureCours time;
    declare dureeCours int default 0;
    declare heureFinCours time;
    declare heureFinNewCours time;
    
    declare coursDuMoniteur cursor for select dateC, heureC, dureeC from COURS where idM = new.idM;
    
    declare continue handler for not found set fini = true;

    set dateNewCours = new.dateC;
    set heureNewCours = new.heureC;
    set dureeNewCours = new.dureeC;
    
    set heureFinNewCours = addtime(heureNewCours, sec_to_time(dureeNewCours * 60));

    open coursDuMoniteur;
    while not fini do
        fetch coursDuMoniteur into dateCours, heureCours, dureeCours;
        set heureFinCours = addtime(heureCours, sec_to_time(dureeCours * 60));
        if dateNewCours = dateCours then
            if (heureNewCours < heureFinCours and heureFinNewCours > heureCours) then
                set fini=true;
                set mes = concat("Le moniteur a déjà un cours pendant le créneau");
                signal sqlstate "45000" set message_text = mes;
            end if;
        end if;
    end while;
    close coursDuMoniteur;
end |

-- Les cours ne peuvent être effectués de 20h à 8h

create or replace trigger heuresSansCours before insert on COURS for each row
begin
    declare mes varchar(200) default "";
    if hour(new.heureC)>20 or hour(new.heureC)<8 then
        set mes=concat("Le cours ",new.nomC, " ne peut pas avoir lieu. Le créneau ne doit pas être entre 20h et 8h");
        signal SQLSTATE '45000' set MESSAGE_TEXT=mes;
    end if;
end |

delimiter ;
