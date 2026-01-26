// ENTRÉES:
//     age : entier (âge du conducteur)
function calculPoliceAssurance(age, anciennete_permis, nb_accidents, assure_depuis){
// let age;
// //     anciennete_permis : entier (années depuis l'obtention du permis)
// let anciennete_permis;
// //     nb_accidents : entier (nombre d'accidents responsables)
// let nb_accidents;
// //     assure_depuis : entier (années d'assurance dans la compagnie, 0 si nouveau client)
// let assure_depuis;

// VARIABLES:
//     tarif_base : chaîne de caractères (tarif calculé avant bonus)
let tarif_base= "";
//     tarif_final : chaîne de caractères (tarif final avec bonus éventuel)
let tarif_final= "";
//     est_fidele : booléen (vrai si assuré depuis plus d'un an)
let est_fidele;
// CONSTANTES:
//     TARIFS : tableau de chaînes ← ["A", "B", "C", "D"]
const TARIFS = ["A", "B", "C", "D"];
//     REFUS : chaîne ← "REFUSÉ"
const REFUS = "REFUSÉ";

// DÉBUT
//     AFFICHER "=== CALCUL DU TARIF D'ASSURANCE ==="
console.log("=== CALCUL DU TARIF D'ASSURANCE ===");
//     AFFICHER "Âge :", age, "ans"
console.log("Âge :", age, "ans");
//     AFFICHER "Ancienneté permis :", anciennete_permis, "ans"
console.log("Ancienneté permis :", anciennete_permis, "ans");
//     AFFICHER "Nombre d'accidents :", nb_accidents
console.log("Nombre d'accidents :", nb_accidents);
//     AFFICHER "Assuré depuis :", assure_depuis, "ans"
console.log("Assuré depuis :", assure_depuis, "ans");
//     // Étape 1: Validation des données d'entrée
//     AFFICHER "--- Validation des données ---"
console.log("--- Validation des données ---");

//     SI (age < 16) OU (age > 120) ALORS

//         AFFICHER "Erreur : Âge invalide"
//         RETOURNER "ERREUR_AGE"
//     FIN SI
    if (age < 16 || age > 120) {
        console.log("Erreur : Âge invalide");
            return "ERREUR_AGE";
    }    

//     SI (anciennete_permis < 0) OU (anciennete_permis > age - 16) ALORS
//         AFFICHER "Erreur : Ancienneté permis invalide"
//         RETOURNER "ERREUR_PERMIS"
//     FIN SI
    if (anciennete_permis < 0 || anciennete_permis > age - 16){
        console.log("Erreur : Ancienneté permis invalide");
            return "ERREUR_PERMIS";
    }

//     SI (nb_accidents < 0) ALORS
//         AFFICHER "Erreur : Nombre d'accidents invalide"
//         RETOURNER "ERREUR_ACCIDENTS"
//     FIN SI
    if (nb_accidents < 0){
        console.log("Erreur : Nombre d'accidents invalide");
        return "ERREUR_ACCIDENTS";
    }     

//     SI (assure_depuis < 0) ALORS
//         AFFICHER "Erreur : Ancienneté assurance invalide"
//         RETOURNER "ERREUR_ASSURANCE"
//     FIN SI
    if (assure_depuis < 0){
        console.log("Erreur : Ancienneté assurance invalide");
            return "ERREUR_ASSURANCE";
    }    
    
//     AFFICHER "Données validées avec succès"
console.log("Données validées avec succès");
//     // Étape 2: Calcul direct du tarif selon le profil
//     AFFICHER "--- Calcul du tarif de base ---"
console.log("--- Calcul du tarif de base ---");
    
//     // CAS 1: Jeune conducteur inexpérimenté (< 25 ans ET permis < 2 ans)
//     SI (age < 25) ET (anciennete_permis < 2) ALORS
//         AFFICHER "Profil : Jeune conducteur inexpérimenté"
        if (age < 25 && anciennete_permis < 2) {
                console.log("Profil : Jeune conducteur inexpérimenté");
        
        
//         SI nb_accidents = 0 ALORS
//             AFFICHER "Aucun accident : tarif D autorisé"
//             tarif_base ← "D"

            if (nb_accidents === 0) {
                    console.log("Aucun accident : tarif D autorisé");
                    tarif_base = "D";
            }

//         SINON
//             AFFICHER "Au moins un accident : refus obligatoire"
//             tarif_base ← "REFUSÉ"
            else {
                console.log("Au moins un accident : refus obligatoire");
                tarif_base = "REFUSÉ";
            }
//       FIN SI
        }
//     // CAS 2: Conducteur à risque modéré
//     // (< 25 ans ET permis >= 2 ans) OU (>= 25 ans ET permis < 2 ans)
//     SINON SI ((age < 25) ET (anciennete_permis >= 2)) OU 
//              ((age >= 25) ET (anciennete_permis < 2)) ALORS
//         AFFICHER "Profil : Conducteur avec un facteur de risque"
        else if (age < 25 && anciennete_permis >= 2 || age >= 25 && anciennete_permis < 2) {
                console.log("Profil : Conducteur avec un facteur de risque");

//         SI nb_accidents = 0 ALORS
//             AFFICHER "Aucun accident : tarif C autorisé"
//             tarif_base ← "C"
            if (nb_accidents === 0) {
                console.log("Aucun accident : tarif C autorisé");
                tarif_base = "C";
            }

//         SINON SI nb_accidents = 1 ALORS
//             AFFICHER "Un accident : tarif D autorisé"
//             tarif_base ← "D"
            else if (nb_accidents === 1) {
                console.log("Un accident : tarif D autorisé");
                tarif_base = "D";
            }

//         SINON
//             AFFICHER "Trop d'accidents (", nb_accidents, ") : refus"
//             tarif_base ← "REFUSÉ"
            else {
                console.log("Trop d'accidents ", nb_accidents, " : refus");
             tarif_base = "REFUSÉ";
            }

//         FIN SI
        }    
            
            
            
        
//     // CAS 3: Conducteur expérimenté (>= 25 ans ET permis >= 2 ans)
//     SINON
//         AFFICHER "Profil : Conducteur expérimenté"
        else {
            console.log("Profil : Conducteur expérimenté");
             
//         SI nb_accidents = 0 ALORS
//             AFFICHER "Aucun accident : tarif B autorisé"
//             tarif_base ← "B"
            if (nb_accidents === 0){
                console.log("Aucun accident : tarif B autorisé");
                tarif_base = "B";
            }

//         SINON SI nb_accidents = 1 ALORS
//             AFFICHER "Un accident : tarif C autorisé"
//             tarif_base ← "C"
            else if (nb_accidents === 1){
                console.log("Un accident : tarif C autorisé");
                tarif_base = "C";
            }

//         SINON SI nb_accidents = 2 ALORS
//             AFFICHER "Deux accidents : tarif D autorisé"
//             tarif_base ← "D"
            else if (nb_accidents === 2){
                console.log("Deux accident : tarif D autorisé");
                tarif_base = "D";
            }

//         SINON
//             AFFICHER "Trop d'accidents (", nb_accidents, ") : refus"
//             tarif_base ← "REFUSÉ"
            else {
                console.log("Trop d'accidents ", nb_accidents, " : refus");
            tarif_base = "REFUSÉ";
            }

//         FIN SI
        } 
//     FIN SI
            
            
            
            
                
        
//     AFFICHER "Tarif de base calculé :", tarif_base
        console.log("Tarif de base calculé :", tarif_base);
   
//     // Étape 3: Application directe du bonus fidélité
//     AFFICHER "--- Application bonus fidélité ---"
//     est_fidele ← (assure_depuis > 1)
        console.log("--- Application bonus fidélité ---");
        est_fidele = (assure_depuis > 1);
//     SI est_fidele ET (tarif_base ≠ "REFUSÉ") ALORS
//         AFFICHER "Client fidèle détecté (assuré depuis", assure_depuis, "ans)"
//         AFFICHER "Application du bonus fidélité sur tarif :", tarif_base
        if(est_fidele && tarif_base !== "REFUSÉ"){
            console.log("Client fidèle détecté (assuré depuis", assure_depuis, "ans)");
            console.log("Application du bonus fidélité sur tarif :", tarif_base);
        
//         SI tarif_base = "D" ALORS
//             AFFICHER "Amélioration D → C"
//             tarif_final ← "C"
            if(tarif_base === "D") {
                console.log("Amélioration D → C");
                tarif_final = "C";
            }
//         SINON SI tarif_base = "C" ALORS
//             AFFICHER "Amélioration C → B"
//             tarif_final ← "B"
            else if (tarif_base === "C"){
                console.log("Amélioration C → B");
                tarif_final = "B";
            }

//         SINON SI tarif_base = "B" ALORS
//             AFFICHER "Amélioration B → A"
//             tarif_final ← "A"
            else if(tarif_base === "B"){
             console.log("Amélioration B → A");
             tarif_final = "A";
            }

//         SINON SI tarif_base = "A" ALORS
//             AFFICHER "Déjà au meilleur tarif"
//             tarif_final ← "A"
            else if (tarif_base === "A") {
             console.log("Déjà au meilleur tarif");
             tarif_final = "A";
            }

//         SINON
//             AFFICHER "Tarif non reconnu, pas de bonus"
//             tarif_final ← tarif_base
            else {
             console.log("Tarif non reconnu, pas de bonus");
             tarif_final = tarif_base;
            }
//      FIN SI
        } 
            
                 
        else {
            if (tarif_base === "REFUSÉ"){
                console.log("Pas de bonus sur un refus");
                }
            else{
                console.log("Pas de bonus fidélité (assuré depuis", assure_depuis, "ans)")
                }
            tarif_final = tarif_base;
            }
    
    
//     // Étape 4: Résultat final
//     AFFICHER "--- Résultat final ---"
//     AFFICHER "Tarif proposé :", tarif_final
console.log("--- Résultat final ---");
console.log("Tarif proposé :", tarif_final);

return tarif_final;
}
calculPoliceAssurance(25, 2, 0, 2);
// FIN
