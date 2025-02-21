DELIMITER //

CREATE TRIGGER after_compte_insert
AFTER INSERT ON compte
FOR EACH ROW
BEGIN
    INSERT INTO audit_compte (type_action,solde_ancien,numero_compte,nom_client,solde_nouveau,utilisateur )
    VALUES ('INSERT',0,NEW.numero_compte,NEW.nom_client,NEW.solde,NEW.id_user_id);
END;
//
 
CREATE TRIGGER after_compte_update
AFTER UPDATE ON compte
FOR EACH ROW
BEGIN
    INSERT INTO audit_compte ( type_action, solde_ancien, solde_nouveau, numero_compte,nom_client, utilisateur)
    VALUES ( 'UPDATE', OLD.solde, NEW.solde,NEW.numero_compte,NEW.nom_client,NEW.id_user_id);
END;
//

CREATE TRIGGER after_compte_delete
AFTER DELETE ON compte
FOR EACH ROW
BEGIN
    INSERT INTO audit_compte ( type_action, solde_ancien, solde_nouveau, numero_compte,nom_client, utilisateur)
    VALUES ( 'DELETE', OLD.solde, OLD.solde,OLD.numero_compte,OLD.nom_client,OLD.id_user_id);
END;
//

DELIMITER ;