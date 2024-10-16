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

-- Les cours ne peuvent être effectués de 20h à 8h

create or replace trigger heuresSansCours before insert on COURS for each row
begin
    declare mes varchar(200) default "";
    if hour(new.heureC)>20 or hour(new.heureC)<8 then
        set mes=concat("Le cours ",new.nomC, " ne peut pas avoir lieu. Le créneau ne doit pas être entre 20h et 8h");
        signal SQLSTATE '45000' set MESSAGE_TEXT=mes;
    end if;
end |

-- Un moniteur ne peut pas avoir un cours qui commence pendant un autre cours qu'il gère

create or replace function moniteurOccupe(dateCours date, heureCours time, idMoniteur int) returns boolean
begin
    declare estOccupe boolean default false;
    declare dateDebut date;
    declare heureDebut int;
    declare heureFin int;
    declare dureeCours int;
    declare fini boolean default false;
    declare coursDuMoniteur cursor for select dateC,heureC,dureeC from COURS where idM=idMoniteur;
    declare continue handler for not found set fini = true ;
    set heureFin=hour(heureDebut)+dureeCours;
    open coursDuMoniteur;
    while not fini do
        fetch coursDuMoniteur into dateDebut,heureDebut,dureeCours;
        if not fini then
            if dateCours=dateDebut then
                if hour(heureCours)>heureDebut and hour(heureCours)<heureFin then
                    set estOccupe=true;
                end if;
            end if;
        end if;
    end while;
    close coursDuMoniteur;
    return estOccupe;
end |

create or replace trigger moniteurPasDispo before insert on COURS for each row
begin
    declare mes varchar(200) default "";
    declare moniteurOccupe boolean;
    select moniteurOccupe(new.dateC,new.heureC,new.idM) into moniteurOccupe;
    if not moniteurOccupe then
        set mes=concat("Le moniteur a déjà un cours sur le créneau: ",new.dateC,", ",new.heureC);
        signal SQLSTATE "45000" set MESSAGE_TEXT=mes;
    end if;
end |
