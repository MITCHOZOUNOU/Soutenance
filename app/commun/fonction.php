<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function database_login()
{
    $bdd = "null";
    try {
        $bdd = new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $bdd;
}

function stats($table, $field=null, $fieldentry=null): array
{

    $stats = [];

    $database = database_login();

    if (!is_null($field) && !is_null($fieldentry)) {
        $request = "SELECT * FROM " . $table . " WHERE " . $field . " = :field_entry and est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute([
            "field_entry" => $fieldentry
        ]);
    } else {
        $request = "SELECT * FROM " . $table . " WHERE est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute();
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $stats = $data;
        }
    }

    return $stats;
}

function verifier_info($info): bool
{
    return (isset($info) and !empty($info));
}

function check_username_exist($username)
{
    $users = "false";
    $bdd = database_login();
    $req = $bdd->prepare('SELECT id from utilisateur WHERE nom_utilisateur=?');
    $req->execute([$username]);
    $users = $req->fetch();
    return $users;
}

function check_email_exist($email)
{
    $users = "false";
    $bdd = database_login();
    $req = $bdd->prepare('SELECT id from utilisateur WHERE email=?');
    $req->execute([$email]);
    $users = $req->fetch();
    return $users;
}

/**
 * Cette fonction permet de verifier si un utilisateur dans la base de donnée ne possède pas ce nom d'utilisateur.
 * @param string $nom_utilisateur Le nom d'utilisateur a vérifié.
 *
 * @return bool $check
 */
function check_user_name_exist_in_bdd(string $nom_utilisateur)
{

    $check = false;

    $bdd = database_login();

    $requette = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE nom_utilisateur = :nom_utilisateur";

    $verifier_nom_utilisateur = $bdd->prepare($requette);

    $resultat = $verifier_nom_utilisateur->execute([
        'nom_utilisateur' => $nom_utilisateur,
    ]);

    if ($resultat) {

        $nbr_utilisateur = $verifier_nom_utilisateur->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

        $check = ($nbr_utilisateur > 0) ? true : false;
    }

    return $check;
}

/**
 * Cette fonction permet de verifier si l'email existe dans la base de donnée ne possède pas ce nom d'utilisateur.
 * @param string $l'email est vérifié.
 *
 * @return bool $check
 */
function check_email_exist_in_bdd(string $email)
{

    $check = false;

    $bdd = database_login();

    $requette = "SELECT count(*) as nbr_utilisateur FROM utilisateur WHERE email = :email";

    $verifier_email = $bdd->prepare($requette);

    $resultat = $verifier_email->execute([
        'email' => $email,
    ]);

    if ($resultat) {

        $nbr_utilisateur = $verifier_email->fetch(PDO::FETCH_ASSOC)["nbr_utilisateur"];

        $check = ($nbr_utilisateur > 0) ? true : false;
    }

    return $check;
}

/**
 * Send mail.
 *
 * @param string $destination The destination.
 * @param string $subject The subject.
 * @param string $body The body.
 * @return bool The result.
 */
function send_email(string $destination, string $subject, string $body): bool
{
    // passing true in constructor enables exceptions in PHPMailer
    $mail = new PHPMailer(true);
    $mail->CharSet = "UTF-8";

    try {

        // Server settings
        // for detailed debug output
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->Username = MAIL_ADDRESS;
        $mail->Password = MAIL_PASSWORD;

        // Sender and recipient settings
        $mail->setFrom(MAIL_ADDRESS, htmlspecialchars_decode('Bibliothèque de Parakou'));
        $mail->addAddress($destination, 'utilisateur');
        $mail->addReplyTo(MAIL_ADDRESS, htmlspecialchars_decode('Bibliothèque de Parakou'));

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = htmlspecialchars_decode($subject);
        $mail->Body = $body;

        return $mail->send();
    } catch (Exception $e) {

        return false;
    }
}

/**
 * Fonction buffer pour récupérer du html.
 * @param string $ cette envoi du html.
 *
 * @return bool $check
 */

function buffer_html_file($filename)
{
    ob_start(); //démarre la temporisation de sortie

    include $filename; //Inclut des fichier html dans le tampon

    $html = ob_get_contents(); // Récupère le contenu du tampon
    ob_end_clean(); // Arrête et vide la tamporisation de sortie

    return $html; // Retourne le contenu du fichier html
}

/** 
 * Cette fonction permet de générer un token pour la validation du compte en fonction de l'id de l'utilsateur 

 * @param int $user_id
 * @param string $type
 * @param string $token
 *@return bool $insertion_token
 */


function insertion_token(int $user_id, string $type, string $token): bool
{

    $insertion_token = false;

    $bdd = database_login();

    $request = "INSERT INTO token (user_id, type, token) VALUES (:user_id, :type, :token)";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'user_id' => $user_id,
            'type' => $type,
            'token' => $token
        ]
    );

    if ($request_execution) {

        $insertion_token = true;
    }

    return $insertion_token;
}

/**
 * Récupérer le token.
 *
 * @param string $.
 * @return int $.
 */
function recuperer_token(string $user_id)
{
    $token = [];

    $bdd = database_login();

    $request = "SELECT token FROM token WHERE user_id=:user_id";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute([
        'user_id' => $user_id
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {
            $token = $data;
        }
    }
    return $token;
}

/**
 * Cette fonction permet de récupérer l'id de l'utilisateur grace a son adresse mail.
 *
 * @param string $email L'email de l'utilisateur.
 * @return int $user_id L'id de l'utilisateur.
 */
function recuperer_id_utilisateur_par_son_mail(string $email): int
{

    $user_id = 0;

    $bdd = database_login();

    if (is_object($bdd)) {

        $request = "SELECT id FROM utilisateur WHERE email=:email";

        $request_prepare = $bdd->prepare($request);

        $request_execution = $request_prepare->execute([
            'email' => $email
        ]);

        if ($request_execution) {
            $data = $request_prepare->fetch(PDO::FETCH_ASSOC);
            if (isset($data) && !empty($data) && is_array($data)) {
                $user_id = $data["id"];
            }
        }
    }
    return $user_id;
}

/**
 * Cette fonction permet de verifier si le id_utilisateur existe dans la base de donnée .
 * @param string $nom_utilisateur Le nom d'utilisateur est vérifié.
 *
 * @return bool $check
 */
function check_token_exist(int $user_id, string $token, string $type, int $est_actif = 1, int $est_supprimer = 0): bool
{

    $check = false;

    $bdd = database_login();

    if (is_object($bdd)) {

        $requette = "SELECT * FROM token WHERE user_id = :user_id and token= :token and type= :type and est_actif= :est_actif and $est_supprimer= :est_supprimer";

        $verifier_id_utilisateur = $bdd->prepare($requette);

        $resultat = $verifier_id_utilisateur->execute([
            'user_id' => $user_id,
            'token' => $token,
            'type' => $type,
            'est_actif' => $est_actif,
            'est_supprimer' => $est_supprimer
        ]);

        if ($resultat) {

            $data = $verifier_id_utilisateur->fetchAll(PDO::FETCH_ASSOC);

            if (isset($data) && !empty($data) && is_array($data)) {

                $check = true;
            }
        }
    }
    return $check;
}

/**
 * cette fonction permet d'exécuter la requête UPDATE TOKEN et faire passer le est_supprimer à 1.
 * @param string $id_utilisateurs identifiant de l'utilisateur
 * @return bool $est_actif 
 * @return bool $est_supprimer
 * @return bool $suppression_logique_token
 */

function suppression_logique_token(int $id_utilisateur): bool
{

    $suppression_logique_token = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE token SET est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE user_id= :id_utilisateur";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id_utilisateur' => $id_utilisateur,
            'est_actif' => 0,
            'est_supprimer' => 1,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $suppression_logique_token = true;
    }

    return $suppression_logique_token;
}

/**
 * Cette fonction pour mettre à jour la table utilisateur .
 * @param string $$request_execution.
 *
 * @return bool $activation_compte_utilisateur
 */


function activation_compte_utilisateur(int $id_utilisateur): bool
{

    $activation_compte_utilisateur = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE utilisateur SET est_actif = :est_actif, maj_le = :maj_le WHERE id= :id_utilisateur";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'id_utilisateur' => $id_utilisateur,
            'est_actif' => 1,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $activation_compte_utilisateur = true;
    }

    return $activation_compte_utilisateur;
}

/**
 * Cette fonction permet de verifier si le id_utilisateur existe dans la base de donnée .
 * @param string $nom_utilisateur Le nom d'utilisateur a vérifié.
 *
 * @return bool $check
 */
function check_id_utilisateur_exist_in_bdd(int $user_id, string $type, string $token, int $est_actif, int $est_supprimer): bool
{

    $check = false;

    $bdd = database_login();

    $requette = "SELECT * FROM token WHERE user_id = :user_id and type= :type and token= :token and est_actif= :est_actif and est_supprimer= :est_supprimer";

    $verifier_id_utilisateur = $bdd->prepare($requette);

    $resultat = $verifier_id_utilisateur->execute([
        'user_id' => $user_id,
        'type' => $type,
        'token' => $token,
        'est_actif' => $est_actif,
        'est_supprimer' => $est_supprimer
    ]);

    if ($resultat) {

        $data = $verifier_id_utilisateur->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $check = true;
        }
    }

    return $check;
}
/**
 * Cette fonction permet de verifier si un utilisateur (nom utilisateur + mot de passe) existe dans la base de donnée.
 *
 * @param string $nom_utilisateur Le nom de l'utilisateur.
 * @param string $mot_de_passe Le mot de passe de l'utilisateur.
 * @param string $profil Le profil de l'utilisateur.
 * @param int $est_actif Est-ce que l'utilisateur est actif ou pas.
 *
 * @return array $user Les informations de l'utilisateur.
 */
function check_if_user_exist(string $nom_utilisateur, string $mot_de_passe, string $profil, int $est_actif = 1, int $est_supprimer = 0): array
{

    $user = [];

    $bdd = database_login();

    $requette = "SELECT id, nom, prenom, sexe, email, nom_utilisateur, avatar, profil, telephone, adresse, date_naissance FROM utilisateur WHERE nom_utilisateur = :nom_utilisateur and mot_de_passe = :mot_de_passe and profil = :profil and est_actif = :est_actif and est_supprimer = :est_supprimer";

    $verifier_nom_utilisateur = $bdd->prepare($requette);

    $resultat = $verifier_nom_utilisateur->execute([
        'nom_utilisateur' => $nom_utilisateur,
        'mot_de_passe' => sha1($mot_de_passe),
        'profil' => $profil,
        'est_actif' => $est_actif,
        'est_supprimer' => $est_supprimer,
    ]);

    if ($resultat) {
        $donnees = $verifier_nom_utilisateur->fetch(PDO::FETCH_ASSOC);
        if (is_array($donnees) && !empty($donnees)) {
            $user = $donnees;
        }
    }
    return $user;
}

/**Cette fonction permet de verifier si l'utilisateur est connecter.
 * @param string $si l'utilisateur existe et est connecté.
 *
 * @return bool $utilisateur_connecter
 */


function check_if_user_connected(): bool
{
    return !empty($_SESSION);
}



/**Cette fonction permet de rechercher si le mot de passe existe et appartient à l'utilisateur enregistrer dans la base de donnée .
 * @param string $si le mot de passe existe.
 *
 * @return bool $users = true
 */


function check_password_exist(string $mot_de_passe, int $id)
{
    $users = "false";
    $bdd = database_login();
    $req = $bdd->prepare('SELECT id from utilisateur WHERE mot_de_passe=:mot_de_passe AND id=:id');
    $req->execute(array(
        'mot_de_passe' => sha1($mot_de_passe),
        'id' => $id
    ));
    $users = $req->fetch();
    if ($users) {
        $users = true;
    }
    return $users;
}

/** 
 * Cette fonction permet de mettre à jour le mot de passe dans le champ mot_de_passe de la table utilisateur dans la base de données.
 * @param int $id_user L'id de l'utilisateur.
 * @param string $mot_de_passe Le mot de passe de l'utilisateur.
 * @return bool $update_password_in_bdd
 */
function update_password_in_bdd(int $id_user, string $mot_de_passe)
{
    $update_password = false;

    $bdd = database_login();
    $requete = "UPDATE utilisateur SET mot_de_passe = :mot_de_passe WHERE id = :id_user";
    $requete_prepare = $bdd->prepare($requete);
    $requete_execute = $requete_prepare->execute(array(
        'mot_de_passe' => sha1($mot_de_passe),
        'id_user' => $id_user
    ));

    if ($requete_execute) {
        $update_password = true;
    }

    return $update_password;
}

/**
 * Cette fonction permet de mettre a jour les information de l'utilisateur a partir de son identifiant (id).
 *
 * @param int $id
 * @param string|null $nom
 * @param string|null $prenom
 * @param string|null $sexe
 * @param string|null $date_naissance
 * @param string|null $telephone
 * @param string|null $avatar
 * @param string|null $nom_utilisateur
 * @param string|null $adresse
 *
 * @return bool
 */
function mettre_a_jour_informations_utilisateur(int $id, string $nom = null, string $prenom = null, string $sexe = null, string $date_naissance = null, string $telephone = null, string $nom_utilisateur = null, string $adresse = null): bool
{
    $mettre_a_jour_informations_utilisateur = false;
    $data = ["id" => $id, "maj_le" => date("Y-m-d H:i:s")];
    $bdd = database_login();
    if (is_object($bdd)) {
        $request = "UPDATE utilisateur SET";

        if (!empty($nom)) {
            $request .= " nom = :nom,";
            $data["nom"] = $nom;
        }

        if (!empty($prenom)) {
            $request .= " prenom = :prenom,";
            $data["prenom"] = $prenom;
        }

        if (!empty($sexe)) {
            $request .= " sexe = :sexe,";
            $data["sexe"] = $sexe;
        }

        if (!empty($date_naissance)) {
            $request .= " date_naissance = :date_naissance,";
            $data["date_naissance"] = $date_naissance;
        }

        if (!empty($telephone)) {
            $request .= " telephone = :telephone,";
            $data["telephone"] = $telephone;
        }

        if (!empty($adresse)) {
            $request .= " adresse = :adresse,";
            $data["adresse"] = $adresse;
        }

        if (!empty($nom_utilisateur)) {
            $request .= " nom_utilisateur = :nom_utilisateur,";
            $data["nom_utilisateur"] = $nom_utilisateur;
        }

        $request .= " maj_le = :maj_le";
        $request .= " WHERE id = :id";

        $request_prepare = $bdd->prepare($request);

        $request_execution = $request_prepare->execute($data);

        if ($request_execution) {
            $mettre_a_jour_informations_utilisateur = true;
        }
    }

    return $mettre_a_jour_informations_utilisateur;
}

/**
 * Cette fonction permet de récupérer la mise à jour du profil de l'utilisateur.
 *
 * @param int $id L'identifiant de l'utilisateur.
 * @return array|false Les informations mises à jour de l'utilisateur, ou false en cas d'erreur.
 */
function recup_mettre_a_jour_informations_utilisateur($id)
{
    $bdd = database_login();

    $request = $bdd->prepare('SELECT id, nom, prenom, sexe, date_naissance, email, telephone, nom_utilisateur, avatar, adresse, profil FROM utilisateur WHERE id = :id');

    $result = $request->execute([
        'id' => $id,
    ]);

    if ($result) {
        $data = $request->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    return false;
}


/** Cette fonction permet d'inserer un utilisateur de profile MEMBRE
 * @param int $id
 * @return bool
 */
function enregistrer_utilisateur(string $nom, string $prenom, string $email, string $nom_utilisateur, string $mot_de_passe, string $profil = "MEMBRE"): bool
{
    $enregistrer_utilisateur = false;

    $bdd = database_login();

    if (!is_null($bdd)) {

        // Ecriture de la requête
        $requette = 'INSERT INTO utilisateur (nom, prenom, email, nom_utilisateur, profil, mot_de_passe) VALUES (:nom, :prenom, :email, :nom_utilisateur, :profil, :mot_de_passe)';

        // Préparation
        $inserer_utilisateur = $bdd->prepare($requette);

        // Exécution ! La recette est maintenant en base de données
        $resultat = $inserer_utilisateur->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'nom_utilisateur' => $nom_utilisateur,
            'profil' => $profil,
            'mot_de_passe' => sha1($mot_de_passe)
        ]);

        if ($resultat) {
            $enregistrer_utilisateur = true;
        }
    }

    return $enregistrer_utilisateur;
}




/**
 * Cette fonction permet d'ajouter un auteur à la base de données.
 *
 * @param string $nom_aut Le nom de l'auteur.
 * @param string $prenom_aut Le prénom de l'auteur.
 *
 * @return bool $ajout_auteur Le résultat de l'ajout de l'auteur.
 */
function ajout_auteur(string $nom_aut, string $prenom_aut): array
{
    $ajout_auteur = [];

    if (!empty($nom_aut) && !empty($prenom_aut)) {
        $bdd = database_login();

        // Ecriture de la requête
        $requete = 'INSERT INTO auteur (nom_aut, prenoms_aut) VALUES (:nom_aut, :prenoms_aut)';

        // Préparation
        $inserer_auteur = $bdd->prepare($requete);

        // Exécution ! L'auteur est maintenant en base de données
        $resultat = $inserer_auteur->execute([
            'nom_aut' => $nom_aut,
            'prenoms_aut' => $prenom_aut
        ]);

        if ($resultat) {
            $lastInsertID = $bdd->lastInsertId();

            $ajout_auteur[] = $lastInsertID;
        }
    }

    return $ajout_auteur;
}

/**
 * Cette fonction permet de récupérer la liste des auteurs de la base de donnée.
 *
 * @return array $liste_auteurs La liste des auteurs.
 */
function get_liste_auteurs(): array
{

    $liste_auteurs = array();

    $bdd = database_login();

    // Ecriture de la requête
    $requette = 'SELECT * FROM auteur';

    // Préparation
    $verifier_liste_auteurs = $bdd->prepare($requette);

    // Exécution ! La recette est maintenant en base de données
    $resultat = $verifier_liste_auteurs->execute();

    if ($resultat) {

        $liste_auteurs = $verifier_liste_auteurs->fetchAll(PDO::FETCH_ASSOC);
    }


    return $liste_auteurs;
}


/**
 * Cett fonction permet de d'ajouter une langue à la base de données.
 *
 * @param string $langue Le nom de la langue .
 *
 * @return bool $ajout_langue Le resultat de l'ajout de la langue.
 */
function ajout_langue(string $langue): bool
{

    $ajout_langue = false;

    if (isset($langue) && !empty($langue)) {

        $bdd = database_login();

        // Ecriture de la requête
        $requette = 'INSERT INTO langue (lib_lang) VALUES (:langue);';

        // Préparation
        $inserer_langue = $bdd->prepare($requette);

        // Exécution ! La recette est maintenant en base de données
        $resultat = $inserer_langue->execute([
            'langue' => $langue
        ]);


        if ($resultat) {
            $ajout_langue = true;
        }
    }

    return $ajout_langue;
}

/** 
 *Cette fonction permet de vérifier si une langue existe dans la base de données
 * @param string $lib_lang libellé de la langue.
 * @return bool Message d'erreur si la langue existe 
     
 */
function check_if_langue_exist(string $langue)
{
    $users = [];
    $liblang = false;
    $bdd = database_login();
    $req = $bdd->prepare('SELECT cod_lang from langue WHERE lib_lang=?');
    $req_exec = $req->execute([$langue]);
    if ($req_exec) {

        $users = $req->fetch();
        if (!empty($users) && is_array($users)) {
            $liblang = true;
        }
    }
    return $liblang;
}

/**
 * Cette fonction permet de récupérer la liste des langues de la base de donnée.
 *
 * @return array $liste_langues La liste des langues.
 */
function get_liste_langue(): array
{

    $liste_langues = array();

    $bdd = database_login();

    // Ecriture de la requête
    $requette = 'SELECT * FROM langue';

    // Préparation
    $verifier_liste_langues = $bdd->prepare($requette);

    // Exécution ! La recette est maintenant en base de données
    $resultat = $verifier_liste_langues->execute();

    if ($resultat) {

        $liste_langues = $verifier_liste_langues->fetchAll(PDO::FETCH_ASSOC);
    }


    return $liste_langues;
}

/**
 * Modifie une langue dans la base de données.
 *
 * @param int $cod_lang Le code de la langue à modifier.
 * @param string $langue La nouvelle langue.
 
 * @return bool True si la modification a réussi, False sinon.
 */
function modifier_langue(int $cod_lang, string $langue): bool
{
    $modifier = false;
    $date = date("Y-m-d H:i:s");
    $bdd = database_login();
    $req_prepare = $bdd->prepare('UPDATE langue SET lib_lang = :lib_lang, maj_le = :maj_le WHERE cod_lang = :cod_lang');
    $req_exec = $req_prepare->execute([
        'cod_lang' => $cod_lang,
        'lib_lang' => $langue,
        'maj_le' => $date

    ]);

    if ($req_exec) {
        $modifier = true;
    }
    return $modifier;
}


/**
 * Cett fonction permet de récupérer une langue exitant dans la base de données via son code langue.
 *
 * @param int $cod_lang
 * @return  .
 */
function get_langue_by_id(int $cod_lang)
{
    $bdd = database_login();

    // Requête pour récupérer l'auteur par son num_aut
    $requete = 'SELECT * FROM langue WHERE cod_lang = :cod_lang';

    // Préparation de la requête
    $query = $bdd->prepare($requete);

    // Exécution de la requête en liant le paramètre :num_aut
    $query->execute(['cod_lang' => $cod_lang]);

    // Récupération du résultat de la requête
    $langue = $query->fetch(PDO::FETCH_ASSOC);

    return $langue;
}

/**
 * Cett fonction permet de supprimer  une langue existant dans la base de données via son code langue.
 *
 * @param int $cod_lang
 * @return bool .
 */
function supprimer_langue($cod_lang)
{
    // Vérifier si la langue existe
    $langue = get_langue_by_id($cod_lang);

    if (empty($langue)) {
        // La langue n'existe pas, retourner false
        return false;
    }

    // Supprimer la langue de la base de données
    $bdd = database_login();
    $sql = "DELETE FROM langue WHERE cod_lang = :cod_lang";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':cod_lang', $cod_lang, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result) {
        // Suppression réussie
        return true;
    } else {
        // Suppression échouée
        return false;
    }
}


/**
 * Modifie un auteur dans la base de données.
 *
 * @param int $num_aut Le numéro de l'auteur à modifier.
 * @param string $nom_aut Le nouveau nom de l'auteur.
 * @param string $prenom_aut Le nouveau prénom de l'auteur.
 * @return bool True si la modification a réussi, False sinon.
 */
function modifier_auteur(int $num_aut, string $nom_aut, string $prenom_aut): bool
{
    $modifier = false;
    $date = date("Y-m-d H:i:s");
    $bdd = database_login();
    $req_prepare = $bdd->prepare('UPDATE auteur SET nom_aut = :nom_aut, prenoms_aut = :prenoms_aut, maj_le = :maj_le WHERE num_aut = :num_aut');
    $req_exec = $req_prepare->execute([
        'nom_aut' => $nom_aut,
        'prenoms_aut' => $prenom_aut,
        'maj_le' => $date,
        'num_aut' => $num_aut
    ]);

    if ($req_exec) {
        $modifier = true;
    }
    return $modifier;
}


/**
 * Vérifie si un auteur existe dans la base de données.
 * @param string $nom Nom de l'auteur.
 * @param string $prenom Prénom de l'auteur.
 * @return string|bool Message d'erreur si l'auteur existe, False sinon.
 */
function check_if_auteur_exist(string $nom, string $prenom)
{
    $bdd = database_login();
    $req = $bdd->prepare('SELECT num_aut FROM auteur WHERE nom_aut = ? AND prenoms_aut = ?');
    $req_exec = $req->execute([$nom, $prenom]);

    if ($req_exec) {
        $auteur = $req->fetch();
        if ($auteur !== false) {
            return 'Cet auteur existe déjà';
        }
    }

    return false;
}

/**
 * Cett fonction permet de supprimer  un auteur exitant dans la base de données via son numéro d'auteur.
 *
 * @param int $num_aut
 * @return bool .
 */
function supprimer_auteur($num_aut)
{
    // Vérifier si l'auteur existe
    $auteur = get_auteur_by_id($num_aut);

    if (empty($auteur)) {
        // L'auteur n'existe pas, retourner false ou gérer l'erreur selon vos besoins
        return false;
    }

    // Supprimer l'auteur de la base de données
    $bdd = database_login();
    $sql = "DELETE FROM auteur WHERE num_aut = :num_aut";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':num_aut', $num_aut, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result) {
        // Suppression réussie
        return true;
    } else {
        // Suppression échouée, gérer l'erreur selon vos besoins
        return false;
    }
}


/**
 * Cett fonction permet de récupérer un auteur exitant dans la base de données via son numéro d'auteur.
 *
 * @param int $num_aut
 * @return  .
 */
function get_auteur_by_id(int $num_aut)
{
    $bdd = database_login();

    // Requête pour récupérer l'auteur par son num_aut
    $requete = 'SELECT * FROM auteur WHERE num_aut = :num_aut';

    // Préparation de la requête
    $query = $bdd->prepare($requete);

    // Exécution de la requête en liant le paramètre :num_aut
    $query->execute(['num_aut' => $num_aut]);

    // Récupération du résultat de la requête
    $auteur = $query->fetch(PDO::FETCH_ASSOC);

    return $auteur;
}


/**
 * Cette fonction permet de désactiver un utilisatreur en faisant passé le est_actif de la table utilisateur à zéro
 * @param int $id l'id de l'utilisateur
 * @return bool $profile_active 
 */

//cette fonction permet de désactiver le profil d'un utilisateur
function desactiver_utilisateur(int $id): bool
{

    $profile_active = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE utilisateur SET  est_actif = :est_actif, maj_le = :maj_le WHERE id= :id";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(array(
        'id' => $id,
        'est_actif' => 0,
        'maj_le' => $date
    ));

    if ($request_execution) {

        $profile_active = true;
    }

    return $profile_active;
}


/**
 * Cette fonction permet de supprimer un utilisateur en faisant passé le est_actif de la table utilisateur à 0 et le est_supprimer à 0
 * @param int $id  l'id de l'utilisateur
 * @return bool $profile_supprimer
 */

function supprimer_utilisateur(int $id): bool
{

    $profile_supprimer = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE utilisateur SET  est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE id= :id";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(array(
        'id' => $id,
        'est_actif' => 0,
        'est_supprimer' => 1,
        'maj_le' => $date
    ));
    if ($request_execution) {

        $profile_supprimer = true;
    }

    return $profile_supprimer;
}


/**
 * .3++++++
 * 
 *update_avatar


 *Elle permet de mettre à jour l'avatar de l'utilisateur
 * @param id $id id de l'utilisateur.
 * @param avatar $avatar avatar de l'utilisateur.
 * @return bool update_avatar
 */
function update_avatar(int $id, string $avatar)
{
    $update_avatar = false;
    $bdd = database_login();

    $req = $bdd->prepare('UPDATE utilisateur set avatar=:avatar where id =:id ');
    $req_exec = $req->execute(array(
        'id' => $id,
        'avatar' => $avatar
    ));

    if ($req_exec) {
        $update_avatar = true;
    }
    return $update_avatar;
}


//Fonction pour récupérer l'avatar du profil

/**
 * Cette fonction permet de récupérer la photo du profil .
 * @param int $id l'id de l'utilisateur.
 *
 * @return array $data
 */
function recup_update_avatar($id)
{

    $data = "";
    $data_avatar = "";

    $bdd = database_login();

    $request = $bdd->prepare('SELECT  avatar FROM utilisateur WHERE id = :id');

    $resultat = $request->execute(array(
        'id' => $id,
    ));

    if ($resultat) {
        $data = $request->fetch(PDO::FETCH_ASSOC);
        //die(var_dump($data));
        $data_avatar = implode($data);
    }
    return $data_avatar;
}

/**
 * delete_avatar
 *
 * Elle permet de supprimer la photo personnalisée de l'utilisateur et de restaurer l'image par défaut si nécessaire.
 * @param $id identifiant de l'utilisateur.
 * @return bool
 */
function delete_avatar(int $id)
{
    $delete_avatar = false;
    $bdd = database_login();

    // Vérifier si l'utilisateur a déjà une image personnalisée
    $req_select = $bdd->prepare('SELECT avatar FROM utilisateur WHERE id = :id');
    $req_select->execute(array('id' => $id));
    $row = $req_select->fetch(PDO::FETCH_ASSOC);
    $current_avatar = $row['avatar'];

    // Ne mettre à jour l'avatar que si l'utilisateur a une image personnalisée
    if ($current_avatar !== 'Non defini') {
        $req_update = $bdd->prepare('UPDATE utilisateur SET avatar = :avatar WHERE id = :id');
        $req_exec = $req_update->execute(array(
            'id' => $id,
            'avatar' => 'Non defini'
        ));

        if ($req_exec) {
            $delete_avatar = true;
        }
    }

    return $delete_avatar;
}

/**
 * Cette fonction permet d'effectuer la mise à jour de l'avatar de l'utilisateur
 *
 * @param  int $id L'id de l'utilisateur
 * @param  string $avatar La photo de profil
 * @return bool
 */
function mise_a_jour_avatar(int $id, string $avatar): bool
{

    $mise_a_jour_avatar = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    if (is_object($bdd)) {

        $request = "UPDATE utilisateur SET avatar = :avatar, maj_le = :maj_le  WHERE id= :id";

        $request_prepare = $bdd->prepare($request);

        $request_execution = $request_prepare->execute(
            [
                'id' => $id,
                'avatar' => $avatar,
                'maj_le' => $date,
            ]
        );

        if ($request_execution) {

            $mise_a_jour_avatar = true;
        }
    }

    return $mise_a_jour_avatar;
}

/**
 * Cett fonction permet de d'ajouter un domaine à la base de données.
 *
 * @param string $domaine Le nom du domaine .
 *
 * @return bool $ajout_domaine Le resultat de l'ajout du domaine.
 */
function ajout_domaine(string $domaine): array
{

    $ajout_domaine = [];

    if (isset($domaine) && !empty($domaine)) {

        $bdd = database_login();

        // Ecriture de la requête
        $requette = 'INSERT INTO domaine (lib_dom) VALUES (:domaine);';

        // Préparation
        $inserer_domaine = $bdd->prepare($requette);

        // Exécution ! La recette est maintenant en base de données
        $resultat = $inserer_domaine->execute([
            'domaine' => $domaine
        ]);


        if ($resultat) {
            $lastInsertID = $bdd->lastInsertId();

            $ajout_domaine[] = $lastInsertID;
        }
    }

    return $ajout_domaine;
}

/** 
 *Cette fonction permet de vérifier si un domaine existe dans la base de données
 * @param string $lib_dom libellé de la domaine.
 * @return bool 
     
 */
function check_if_domaine_exist(string $domaine)
{
    $users = [];
    $libdom = false;
    $bdd = database_login();
    $req = $bdd->prepare('SELECT cod_dom from domaine WHERE lib_dom=?');
    $req_exec = $req->execute([$domaine]);
    if ($req_exec) {

        $users = $req->fetch();
        if (!empty($users) && is_array($users)) {
            $libdom = true;
        }
    }
    return $libdom;
}

/**
 * Cette fonction permet de récupérer la liste des domaines de la base de donnée.
 *
 * @return array $liste_domaines La liste des domaines.
 */
function get_liste_domaine(): array
{

    $liste_domaines = array();

    $bdd = database_login();

    // Ecriture de la requête
    $requette = 'SELECT * FROM domaine';

    // Préparation
    $verifier_liste_domaines = $bdd->prepare($requette);

    // Exécution ! La recette est maintenant en base de données
    $resultat = $verifier_liste_domaines->execute();

    if ($resultat) {

        $liste_domaines = $verifier_liste_domaines->fetchAll(PDO::FETCH_ASSOC);
    }


    return $liste_domaines;
}

/**
 * Modifier un domaine dans la base de données.
 *
 * @param int $cod_dom Le code de la langue à modifier.
 * @param string $domaine La nouvelle langue.
 
 * @return bool True si la modification a réussi, False sinon.
 */
function modifier_domaine(int $cod_dom, string $domaine): bool
{
    $modifier = false;
    $date = date("Y-m-d H:i:s");
    $bdd = database_login();
    $req_prepare = $bdd->prepare('UPDATE domaine SET lib_dom = :lib_dom, maj_le = :maj_le WHERE cod_dom = :cod_dom');
    $req_exec = $req_prepare->execute([
        'cod_dom' => $cod_dom,
        'lib_dom' => $domaine,
        'maj_le' => $date

    ]);

    if ($req_exec) {
        $modifier = true;
    }
    return $modifier;
}

/**
 * Cett fonction permet de récupérer un domaine exitant dans la base de données via son code domaine.
 *
 * @param int $cod_dom
 * @return  .
 */
function get_domaine_by_id(int $cod_dom)
{
    $bdd = database_login();
    // Requête pour récupérer le domaine par son cod_dom
    $requete = 'SELECT * FROM domaine WHERE cod_dom = :cod_dom';

    // Préparation de la requête
    $query = $bdd->prepare($requete);

    // Exécution de la requête en liant le paramètre :num_aut
    $query->execute(['cod_dom' => $cod_dom]);

    // Récupération du résultat de la requête
    $domaine = $query->fetch(PDO::FETCH_ASSOC);

    return $domaine;
}

/**
 * Cett fonction permet de supprimer  un domaine exitant dans la base de données via son code domaine.
 *
 * @param int $cod_dom
 * @return bool .
 */
function supprimer_domaine($cod_dom)
{
    // Vérifier si le domaine existe
    $domaine = get_domaine_by_id($cod_dom);

    if (empty($domaine)) {
        // Le domaine n'existe pas, retourner false
        return false;
    }

    // Supprimer le domaine de la base de données
    $bdd = database_login();
    $sql = "DELETE FROM domaine WHERE cod_dom = :cod_dom";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':cod_dom', $cod_dom, PDO::PARAM_INT);
    $result = $stmt->execute();

    if ($result) {
        // Suppression réussie
        return true;
    } else {
        // Suppression échouée
        return false;
    }
}

/**
 * Cette fonction permet de récupérer la liste des membres de la base de données avec le profil "membre".
 *
 * @return array|null La liste des membres s'il y en a, sinon null.
 */
function get_liste_membres(): ?array
{
    $liste_membres = array();

    try {

        $bdd = database_login();

        // Assurez-vous de remplacer "votre_table_utilisateur" par le nom réel de votre table "utilisateur"
        $sql = "SELECT * FROM utilisateur WHERE profil = 'membre'";

        // Préparation de la requête
        $verifier_liste_membres = $bdd->prepare($sql);

        // Exécution de la requête
        $verifier_liste_membres->execute();

        // Récupération des résultats
        $liste_membres = $verifier_liste_membres->fetchAll(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $bdd = null;
    } catch (PDOException $e) {
        // Gérer les erreurs éventuelles (facultatif)
        // Vous pouvez afficher un message d'erreur ou enregistrer les erreurs dans un fichier journal par exemple.
        // echo "Erreur : " . $e->getMessage();
    }

    // Retourner la liste des membres ou null si aucun membre n'est trouvé
    return !empty($liste_membres) ? $liste_membres : null;
}

/**
 * Cette fonction permet de récupérer les informations d'un membre par son ID.
 *
 * @param int $id L'identifiant du membre à récupérer.
 * @return array|null Les informations du membre s'il existe, sinon null.
 */
function obtenir_membre_par_id($id): ?array
{
    try {
        $bdd = database_login();

        // Assurez-vous de remplacer "votre_table_utilisateur" par le nom réel de votre table "utilisateur"
        $sql = "SELECT * FROM utilisateur WHERE id = :id AND profil = 'membre' LIMIT 1";

        // Préparation de la requête
        $requete = $bdd->prepare($sql);

        // Liaison des paramètres de la requête
        $requete->bindParam(':id', $id, PDO::PARAM_INT);

        // Exécution de la requête
        $requete->execute();

        // Récupération du membre
        $membre = $requete->fetch(PDO::FETCH_ASSOC);

        // Fermeture de la connexion à la base de données
        $bdd = null;

        // Retourner les informations du membre ou null s'il n'existe pas
        return $membre ? $membre : null;
    } catch (PDOException $e) {

        return null;
    }
}

function ajout_ouvrage_recup_id(string $titre, int $nb_exp, string $an_pub, int $aut_principal, string $image): array
{

    $insertselect = [];

    $database = database_login();

    $insertrequest = "INSERT INTO ouvrage (titre, nb_ex, periodicite, num_aut, image) VALUES (:titre, :nb_ex, :periodicite, :num_aut, :image)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'titre' => $titre,
            'nb_ex' => $nb_exp,
            'periodicite' => $an_pub,
            'num_aut' => $aut_principal,
            'image' => $image
        ]
    );

    if ($insertrequest_execution) {

        $lastInsertID = $database->lastInsertId();

        $insertselect[] = $lastInsertID;
    }

    return $insertselect;
}

function assoc_ouvrage_lang_an_pub(int $id_ouv, int $id_lang, string $an_pub): bool
{

    $assoc = false;

    $database = database_login();

    $insertrequest = "INSERT INTO date_parution (id_ouvrage, id_langue, date) VALUES (:id_ouvrage, :id_langue, :date)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'id_ouvrage' => $id_ouv,
            'id_langue' => $id_lang,
            'date' => $an_pub,
        ]
    );

    if ($insertrequest_execution) {
        $assoc = true;
    }

    return $assoc;
}

function assoc_ouvrage_aut_secondaires(int $id_ouv, int $id_auteur): bool
{

    $assoc = false;

    $database = database_login();

    $insertrequest = "INSERT INTO ouvrages_auteurs_secondaires (id_ouvrage, id_auteur_secondaire) VALUES (:id_ouvrage, :id_auteur_secondaire)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'id_ouvrage' => $id_ouv,
            'id_auteur_secondaire' => $id_auteur,
        ]
    );

    if ($insertrequest_execution) {
        $assoc = true;
    }

    return $assoc;
}

function assoc_ouvrage_domaine(int $id_ouv, int $id_dom): bool
{

    $assoc = false;

    $database = database_login();

    $insertrequest = "INSERT INTO ouvrages_domaines (id_ouvrage, id_domaine) VALUES (:id_ouvrage, :id_domaine)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'id_ouvrage' => $id_ouv,
            'id_domaine' => $id_dom,
        ]
    );

    if ($insertrequest_execution) {
        $assoc = true;
    }

    return $assoc;
}

function check_if_exist($table, $field, $fieldentry): bool
{

    $exist = false;

    $database = database_login();

    $request = "SELECT * FROM " . $table . " WHERE " . $field . " = :field_entry and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "field_entry" => $fieldentry
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $exist = true;
        }
    }

    return $exist;
}

function liste_ouvrages($page = null, $titre = null, $domaine = null): array
{

    $liste_ouvrages = [];

    $nb_ouvrages_par_page = 12;

    $database = database_login();

    if (!is_null($page)) {

        if (!is_null($titre)) {

            $request = "SELECT * FROM ouvrage WHERE titre LIKE :titre and est_actif = 1 and est_supprimer = 0 ORDER BY cod_ouv DESC LIMIT " . $nb_ouvrages_par_page . " OFFSET " . $nb_ouvrages_par_page * ($page - 1);

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'titre' => '%' . $titre . '%'
            ]);

        } elseif (!is_null($domaine)) {

            $request_dom = "SELECT id_ouvrage FROM ouvrages_domaines WHERE id_domaine = :id_domaine and est_actif = 1 and est_supprimer = 0";

            $request_dom_prepare = $database->prepare($request_dom);

            $request_dom_execution = $request_dom_prepare->execute([
                'id_domaine' => $domaine
            ]);

            if ($request_dom_execution) {

                $data_dom = $request_dom_prepare->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($data_dom) && is_array($data_dom)) {

                    $liste_cod_dom = $data_dom;

                    $placeholders = implode(',', array_fill(0, count($liste_cod_dom), '?'));

                    $request = "SELECT * FROM ouvrage WHERE cod_ouv IN ($placeholders) and est_actif = 1 and est_supprimer = 0 ORDER BY cod_ouv DESC LIMIT " . $nb_ouvrages_par_page . " OFFSET " . $nb_ouvrages_par_page * ($page - 1);

                    $request_prepare = $database->prepare($request);

                    $request_execution = $request_prepare->execute(array_values(array_column($liste_cod_dom, 'id_ouvrage')));
                }

            }

        } elseif (!is_null($titre) && !is_null($domaine)) {

            $request_dom = "SELECT id_ouvrage FROM ouvrages_domaines WHERE id_domaine = :id_domaine and est_actif = 1 and est_supprimer = 0";

            $request_dom_prepare = $database->prepare($request_dom);

            $request_dom_execution = $request_dom_prepare->execute([
                'id_domaine' => $domaine
            ]);

            if ($request_dom_execution) {

                $data_dom = $request_dom_prepare->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($data_dom) && is_array($data_dom)) {

                    $liste_cod_dom = $data_dom;

                    $placeholders = implode(',', array_fill(0, count($liste_cod_dom), '?'));

                    $request = "SELECT * FROM ouvrage WHERE cod_ouv IN ($placeholders) AND titre LIKE '%" . $titre . "%' AND est_actif = 1 AND est_supprimer = 0 ORDER BY cod_ouv DESC LIMIT " . $nb_ouvrages_par_page . " OFFSET " . $nb_ouvrages_par_page * ($page - 1);

                    $request_prepare = $database->prepare($request);

                    $request_execution = $request_prepare->execute(array_values(array_column($liste_cod_dom, 'id_ouvrage')));
                }

            }

        } else {

            $request = "SELECT * FROM ouvrage WHERE est_actif = 1 and est_supprimer = 0 ORDER BY cod_ouv DESC LIMIT " . ($page - 1) * $nb_ouvrages_par_page . ", " . $nb_ouvrages_par_page * $page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute();
        }

    } elseif (is_null($page)) {

        $request = "SELECT * FROM ouvrage WHERE est_actif = 1 and est_supprimer = 0 and nb_ex > nb_emprunter OR nb_emprunter IS NULL ORDER BY cod_ouv DESC";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute();
    }

    if (!empty($request_execution)) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $liste_ouvrages = $data;
        }
    }

    return $liste_ouvrages;
}

function recup_ouvrage_par_cod_ouv($cod_ouv): array
{
    $ouvrage = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrage WHERE cod_ouv =:cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $ouvrage = $data;
        }
    }

    return $ouvrage;
}

function recup_auteur_par_num_aut($num_aut): array
{
    $auteur = [];

    $database = database_login();

    $request = "SELECT * FROM auteur WHERE num_aut =:num_aut and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_aut" => $num_aut
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $auteur = $data;
        }
    }

    return $auteur;
}

function recup_num_auteurs_secondaires_par_cod_ouv($cod_ouv): array
{
    $auteurs = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrages_auteurs_secondaires WHERE id_ouvrage =:cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $auteurs = $data;
        }
    }

    return $auteurs;
}

function recup_num_domaines_par_cod_ouv($cod_ouv): array
{
    $domaines = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrages_domaines WHERE id_ouvrage =:cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $domaines = $data;
        }
    }

    return $domaines;
}

function recup_domaine_par_cod_dom($cod_dom): array
{
    $domaine = [];

    $database = database_login();

    $request = "SELECT * FROM domaine WHERE cod_dom =:cod_dom and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_dom" => $cod_dom
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data) && is_array($data)) {

            $domaine = $data;
        }
    }

    return $domaine;
}

function recup_cod_langue_par_cod_ouv($cod_ouv): array
{
    $cod_lang = [];

    $database = database_login();

    $request = "SELECT * FROM date_parution WHERE id_ouvrage =:cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $cod_lang = $data;
        }
    }

    return $cod_lang;
}

function recup_langue_par_cod_lang($cod_lang): array
{
    $langue = [];

    $database = database_login();

    $request = "SELECT * FROM langue WHERE cod_lang =:cod_lang and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "cod_lang" => $cod_lang
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $langue = $data;
        }
    }

    return $langue;
}

function suppression_ouvrage(int $cod_ouv): bool
{

    $suppression_ouvrage = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage SET est_actif = :est_actif, est_supprimer = :est_supprimer, maj_le = :maj_le WHERE cod_ouv= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'est_actif' => 0,
            'est_supprimer' => 1,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $suppression_ouvrage = true;
    }

    return $suppression_ouvrage;
}

function maj_ouvrage(int $cod_ouv, string $titre, int $nb_ex, string $periodicite, int $num_aut, string $image): bool
{

    $mis_a_jour_ouvrage = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage SET titre = :titre, nb_ex = :nb_ex, periodicite = :periodicite, num_aut = :num_aut, image = :image, maj_le = :maj_le WHERE cod_ouv= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'titre' => $titre,
            'nb_ex' => $nb_ex,
            'periodicite' => $periodicite,
            'num_aut' => $num_aut,
            'image' => $image,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $mis_a_jour_ouvrage = true;
    }

    return $mis_a_jour_ouvrage;
}

function maj_assoc_ouvrage_lang_an_pub(int $cod_ouv, int $cod_lang, string $periodicite): bool
{

    $maj_assoc_ouvrage_lang_an_pub = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE date_parution SET est_actif = 0, est_supprimer = 1, mis_a_jour_le = :maj_le WHERE id_ouvrage= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $insertrequest = "INSERT INTO date_parution (id_ouvrage, id_langue, date, mis_a_jour_le) VALUES (:id_ouvrage, :id_langue, :date, :maj_le)";

        $insertrequest_prepare = $bdd->prepare($insertrequest);

        $insertrequest_execution = $insertrequest_prepare->execute(
            [
                'id_ouvrage' => $cod_ouv,
                'id_langue' => $cod_lang,
                'date' => $periodicite,
                'maj_le' => $date
            ]
        );

        if ($insertrequest_execution) {
            $maj_assoc_ouvrage_lang_an_pub = true;
        }
    }

    return $maj_assoc_ouvrage_lang_an_pub;
}

function rem_old_assoc_ouvrage_aut_secondaires(int $cod_ouv): bool
{
    $rem_old_assoc_ouvrage_aut_secondaires = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrages_auteurs_secondaires SET est_actif = 0, est_supprimer = 1, mis_a_jour_le = :maj_le WHERE id_ouvrage= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $rem_old_assoc_ouvrage_aut_secondaires = true;
    }

    return $rem_old_assoc_ouvrage_aut_secondaires;
}

function maj_assoc_ouvrage_aut_secondaires(int $cod_ouv, int $num_aut): bool
{

    $maj_assoc_ouvrage_aut_secondaires = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $insertrequest = "INSERT INTO ouvrages_auteurs_secondaires (id_ouvrage, id_auteur_secondaire, mis_a_jour_le) VALUES (:id_ouvrage, :id_auteur_secondaire, :maj_le)";

    $insertrequest_prepare = $bdd->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'id_ouvrage' => $cod_ouv,
            'id_auteur_secondaire' => $num_aut,
            'maj_le' => $date
        ]
    );

    if ($insertrequest_execution) {
        $maj_assoc_ouvrage_aut_secondaires = true;
    }

    return $maj_assoc_ouvrage_aut_secondaires;
}

function rem_old_assoc_ouvrage_domaine(int $cod_ouv): bool
{
    $rem_old_assoc_ouvrage_domaine = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrages_domaines SET est_actif = 0, est_supprimer = 1, mis_a_jour_le = :maj_le WHERE id_ouvrage= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $rem_old_assoc_ouvrage_domaine = true;
    }

    return $rem_old_assoc_ouvrage_domaine;
}

function maj_assoc_ouvrage_domaine(int $cod_ouv, int $cod_dom): bool
{

    $maj_assoc_ouvrage_domaine = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $insertrequest = "INSERT INTO ouvrages_domaines (id_ouvrage, id_domaine, mis_a_jour_le) VALUES (:id_ouvrage, :id_domaine, :maj_le)";

    $insertrequest_prepare = $bdd->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'id_ouvrage' => $cod_ouv,
            'id_domaine' => $cod_dom,
            'maj_le' => $date
        ]
    );

    if ($insertrequest_execution) {
        $maj_assoc_ouvrage_domaine = true;
    }


    return $maj_assoc_ouvrage_domaine;
}

function recup_membre($num_mem = null): array
{
    $recup_membre = [];

    $database = database_login();

    if (is_null($num_mem)) {
        $request = "SELECT * FROM utilisateur WHERE profil = 'MEMBRE' and est_actif = 1 and est_supprimer = 0 ORDER BY nom DESC";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute();
    }

    if (!is_null($num_mem) && is_int($num_mem)) {
        $request = "SELECT * FROM utilisateur WHERE profil = 'MEMBRE' and id = :num_mem and est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'num_mem' => $num_mem
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $recup_membre = $data;
        }
    }

    return $recup_membre;
}

function ajout_emprunt_recup_emprunt(string $num_emp, int $num_mem, int $est_actif): array
{

    $insertselect = [];

    $database = database_login();

    $insertrequest = "INSERT INTO emprumt (num_emp, num_mem, est_actif) VALUES (:num_emp, :num_mem, :est_actif)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'num_emp' => $num_emp,
            'num_mem' => $num_mem,
            'est_actif' => $est_actif
        ]
    );

    if ($insertrequest_execution) {

        $query = "SELECT * FROM emprumt WHERE id = :id";

        $query_prepare = $database->prepare($query);

        $query_execution = $query_prepare->execute(
            [
                'id' => $database->lastInsertId(),
            ]
        );

        if ($query_execution) {

            $data = $query_prepare->fetch(PDO::FETCH_ASSOC);

            if (isset($data) && !empty($data) && is_array($data)) {

                $insertselect = $data;
            }
        }
    }

    return $insertselect;
}

function assoc_emprunt_ouvrages(int $num_mem, string $num_emp, int $cod_ouv): bool
{

    $assoc = false;

    $database = database_login();

    $insertrequest = "INSERT INTO ouvrage_emprunt (num_mem, num_emp, cod_ouv) VALUES (:num_mem, :num_emp, :cod_ouv)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'num_mem' => $num_mem,
            'num_emp' => $num_emp,
            'cod_ouv' => $cod_ouv
        ]
    );

    if ($insertrequest_execution) {
        $assoc = true;
    }

    return $assoc;
}

function liste_emprunts($page = null, $num_emp = null, $membre = null): array
{

    $liste_emprunts = [];

    $nb_emprunts_par_page = 10;

    $database = database_login();

    if (!is_null($page)) {

        if (!is_null($num_emp)) {

            $request = "SELECT * FROM emprumt WHERE num_emp LIKE :num_emp and est_supprimer = 0 ORDER BY id DESC LIMIT " . $nb_emprunts_par_page . " OFFSET " . $nb_emprunts_par_page * ($page - 1);

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'num_emp' => '%' . $num_emp . '%'
            ]);

        } elseif (!is_null($membre)) {

            $request = "SELECT * FROM emprumt WHERE num_mem = :num_mem and est_supprimer = 0 ORDER BY id DESC LIMIT " . $nb_emprunts_par_page . " OFFSET " . $nb_emprunts_par_page * ($page - 1);

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'num_mem' => $membre
            ]);

        } elseif (!is_null($num_emp) && !is_null($membre)) {

            $request = "SELECT * FROM emprumt WHERE num_mem = :num_mem AND num_emp LIKE '%" . $num_emp . "%' AND est_supprimer = 0 ORDER BY id DESC LIMIT " . $nb_emprunts_par_page . " OFFSET " . $nb_emprunts_par_page * ($page - 1);

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute([
                'num_mem' => $membre
            ]);

        } else {

            $request = "SELECT * FROM emprumt WHERE est_supprimer = 0 ORDER BY id DESC LIMIT " . ($page - 1) * $nb_emprunts_par_page . ", " . $nb_emprunts_par_page * $page;

            $request_prepare = $database->prepare($request);

            $request_execution = $request_prepare->execute();
        }

    } elseif (is_null($page)) {
        $request = "SELECT * FROM emprumt WHERE est_supprimer = 0";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute();
        
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $liste_emprunts = $data;
        }
    }

    return $liste_emprunts;
}

function recup_cod_ouvs_par_num_emp($num_emp): array
{
    $ouvrages = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrage_emprunt WHERE num_emp =:num_emp and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_emp" => $num_emp
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $ouvrages = $data;
        }
    }

    return $ouvrages;
}

function recup_ouvrage($cod_ouv): array
{

    $recup_ouvrage = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrage WHERE cod_ouv = :cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        'cod_ouv' => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $recup_ouvrage = $data;
        }
    }

    return $recup_ouvrage;
}

function recup_emprunt_par_num_emp($num_emp): array
{
    $emprunt = [];

    $database = database_login();

    $request = "SELECT * FROM emprumt WHERE num_emp =:num_emp and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_emp" => $num_emp
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $emprunt = $data;
        }
    }

    return $emprunt;
}

function maj_emprunt(string $num_emp, int $num_mem): bool
{

    $maj_emprunt = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE emprumt SET num_mem = :num_mem, maj_le = :maj_le WHERE num_emp= :num_emp";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'num_mem' => $num_mem,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $maj_emprunt = true;
    }

    return $maj_emprunt;
}

function rem_old_assoc_emprunt_ouvrages(string $num_emp): bool
{
    $rem_old_assoc_emprunt_ouvrages = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage_emprunt SET est_actif = 0, est_supprimer = 1, maj_le = :maj_le WHERE num_emp= :num_emp";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $rem_old_assoc_emprunt_ouvrages = true;
    }

    return $rem_old_assoc_emprunt_ouvrages;
}

function maj_assoc_emprunt_ouvrages(int $num_mem, string $num_emp, int $cod_ouv, string $date_butoir_retour): bool
{
    $maj_assoc_emprunt_ouvrages = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $insertrequest = "INSERT INTO ouvrage_emprunt (num_mem, num_emp, cod_ouv, maj_le, date_butoir_retour) VALUES (:num_mem, :num_emp, :cod_ouv, :maj_le, :date_butoir_retour)";

    $insertrequest_prepare = $bdd->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'num_mem' => $num_mem,
            'num_emp' => $num_emp,
            'cod_ouv' => $cod_ouv,
            'date_butoir_retour' => $date_butoir_retour,
            'maj_le' => $date
        ]
    );

    if ($insertrequest_execution) {
        $maj_assoc_emprunt_ouvrages = true;
    }


    return $maj_assoc_emprunt_ouvrages;
}

function suppression_emprunt($num_emp): bool
{

    $suppression_emprunt = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE emprumt SET est_actif = 0, est_supprimer = 1, maj_le = :maj_le WHERE num_emp= :num_emp";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $suppression_emprunt = true;
    }

    return $suppression_emprunt;
}

function maj_ouvrage_nb_emprunter(int $cod_ouv, int $nb_emprunter): bool
{

    $maj_ouvrage_nb_emprunter = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage SET nb_emprunter = :nb_emprunter, maj_le = :maj_le WHERE cod_ouv= :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'cod_ouv' => $cod_ouv,
            'nb_emprunter' => $nb_emprunter,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $maj_ouvrage_nb_emprunter = true;
    }

    return $maj_ouvrage_nb_emprunter;
}

function check_if_book_returned(string $num_emp, int $cod_ouv): bool
{

    $check_if_book_returned = false;

    $database = database_login();

    $request = "SELECT * FROM ouvrage_emprunt WHERE num_emp = :num_emp and cod_ouv = :cod_ouv and date_effective_retour IS NOT NULL";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_emp" => $num_emp,
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $check_if_book_returned = true;
        }
    }

    return $check_if_book_returned;
}

function verifier_ligne_dans_ouvrage_emprunt($num_mem, $num_emp, $cod_ouv): bool
{

    $exist = false;

    $database = database_login();

    $request = "SELECT * FROM ouvrage_emprunt WHERE num_mem = :num_mem and num_emp = :num_emp and cod_ouv = :cod_ouv and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_mem" => $num_mem,
        "num_emp" => $num_emp,
        "cod_ouv" => $cod_ouv
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
            $exist = true;
        }
    }

    return $exist;
}

function recup_emprunt_depuis_ouvrage_emprunt($num_emp=null): array
{
    $recup_emprunt_depuis_ouvrage_emprunt = [];

    $database = database_login();

    if (!is_null($num_emp)) {
        $request = "SELECT * FROM ouvrage_emprunt WHERE num_emp =:num_emp and est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            "num_emp" => $num_emp
        ]);

        if ($request_execution) {

            $data = $request_prepare->fetch(PDO::FETCH_ASSOC);
    
            if (isset($data) && !empty($data) && is_array($data)) {
    
                $recup_emprunt_depuis_ouvrage_emprunt = $data;
            }
        }
    }

    if (is_null($num_emp)) {
        $request = "SELECT * FROM ouvrage_emprunt WHERE est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute();

        if ($request_execution) {

            $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);
    
            if (isset($data) && !empty($data) && is_array($data)) {
    
                $recup_emprunt_depuis_ouvrage_emprunt = $data;
            }
        }
    }

    return $recup_emprunt_depuis_ouvrage_emprunt;
}

function marquer_membre_indelicat(int $num_mem): bool
{

    $marquer_membre_indelicat = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE utilisateur SET indelicat = 1, maj_le = :maj_le WHERE id= :num_mem";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_mem' => $num_mem,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $marquer_membre_indelicat = true;
    }

    return $marquer_membre_indelicat;
}

function maj_ouvrage_emprunt(string $num_emp, $date_effective_retour, $cod_ouv, $etat_ouvrage): bool
{

    $maj_ouvrage_emprunt = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage_emprunt SET date_effective_retour = :date_effective_retour, etat_ouvrage = :etat_ouvrage, maj_le = :maj_le WHERE num_emp = :num_emp and cod_ouv = :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'cod_ouv' => $cod_ouv,
            'date_effective_retour' => $date_effective_retour,
            'etat_ouvrage' => $etat_ouvrage,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $maj_ouvrage_emprunt = true;
    }

    return $maj_ouvrage_emprunt;
}

function recup_membre_depuis_ouvrage_emprunt($num_mem): array
{
    $recup_membre_depuis_ouvrage_emprunt = [];

    $database = database_login();

    $request = "SELECT * FROM ouvrage_emprunt WHERE num_mem =:num_mem and est_actif = 1 and est_supprimer = 0";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute([
        "num_mem" => $num_mem
    ]);

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $recup_membre_depuis_ouvrage_emprunt = $data;
        }
    }

    return $recup_membre_depuis_ouvrage_emprunt;
}

function ajouter_membre_indelicat(int $num_mem, string $num_emp, int $cod_ouv, string $date_butoir_retour, $date_effective_retour, $etat_ouvrage): bool
{

    $ajouter_membre_indelicat = false;

    $database = database_login();

    $insertrequest = "INSERT INTO membre_indelicat (num_mem, num_emp, cod_ouv, date_butoir_retour, date_effective_retour, etat_ouvrage) VALUES (:num_mem, :num_emp, :cod_ouv, :date_butoir_retour, :date_effective_retour, :etat_ouvrage)";

    $insertrequest_prepare = $database->prepare($insertrequest);

    $insertrequest_execution = $insertrequest_prepare->execute(
        [
            'num_mem' => $num_mem,
            'num_emp' => $num_emp,
            'cod_ouv' => $cod_ouv,
            'date_butoir_retour' => $date_butoir_retour,
            'date_effective_retour' => $date_effective_retour,
            'etat_ouvrage' => $etat_ouvrage
        ]
    );

    if ($insertrequest_execution) {
        $ajouter_membre_indelicat = true;
    }

    return $ajouter_membre_indelicat;
}

function recup_membres_indelicats($page=null, $num_mem = null): array
{
    $recup_membres_indelicats = [];

    $nb_membres_indelicats_par_page = 10;

    $database = database_login();

    if (is_null($num_mem)) {
        $request = "SELECT * FROM membre_indelicat WHERE est_actif = 1 and est_supprimer = 0 ORDER BY id DESC LIMIT " . $nb_membres_indelicats_par_page . " OFFSET " . $nb_membres_indelicats_par_page * ($page - 1);

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute();
    }

    if (!is_null($num_mem) && is_int($num_mem) && !is_null($page)) {
        $request = "SELECT * FROM membre_indelicat WHERE num_mem = :num_mem and est_actif = 1 and est_supprimer = 0 ORDER BY id DESC LIMIT " . $nb_membres_indelicats_par_page . " OFFSET " . $nb_membres_indelicats_par_page * ($page - 1);

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'num_mem' => $num_mem
        ]);
    }

    if (!is_null($num_mem) && is_null($page)) {
        $request = "SELECT * FROM membre_indelicat WHERE num_mem = :num_mem and est_actif = 1 and est_supprimer = 0";

        $request_prepare = $database->prepare($request);

        $request_execution = $request_prepare->execute([
            'num_mem' => $num_mem
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $recup_membres_indelicats = $data;
        }
    }

    return $recup_membres_indelicats;
}

function approuver_emprunt(string $num_emp): bool
{
    $approuver_emprunt = false;

    $date = date("Y-m-d H:i:s");

    $database = database_login();

    $request = "UPDATE emprumt SET date_approbation = :date_approbation, date_butoir_retour = :date_butoir_retour, est_actif = 1, maj_le = :maj_le WHERE num_emp= :num_emp";

    $request_prepare = $database->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'date_approbation' => $date,
            'date_butoir_retour' => date('Y-m-d H:i:s', strtotime($date . " +1 week")),
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $approuver_emprunt = true;
    }

    return $approuver_emprunt;
}

function maj_date_approb_butoir(string $num_emp, string $date_approbation, string $date_butoir_retour): bool
{

    $maj_date_approb_butoir = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE ouvrage_emprunt SET date_approbation = :date_approbation, date_butoir_retour = :date_butoir_retour, maj_le = :maj_le WHERE num_emp = :num_emp";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'date_approbation' => $date_approbation,
            'date_butoir_retour' => $date_butoir_retour,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $maj_date_approb_butoir = true;
    }

    return $maj_date_approb_butoir;
}

function maj_membre_indelicat($num_emp, $cod_ouv, $banque, $numero_compte): bool
{

    $maj_membre_indelicat = false;

    $date = date("Y-m-d H:i:s");

    $bdd = database_login();

    $request = "UPDATE membre_indelicat SET banque = :banque, numero_compte = :numero_compte, maj_le = :maj_le, est_actif=0, est_supprimer=1 WHERE num_emp = :num_emp and cod_ouv = :cod_ouv";

    $request_prepare = $bdd->prepare($request);

    $request_execution = $request_prepare->execute(
        [
            'num_emp' => $num_emp,
            'cod_ouv' => $cod_ouv,
            'banque' => $banque,
            'numero_compte' => $numero_compte,
            'maj_le' => $date
        ]
    );

    if ($request_execution) {

        $maj_membre_indelicat = true;
    }

    return $maj_membre_indelicat;
}
