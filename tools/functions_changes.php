<?php


echo '
//Initialiser les tableau pour afficher l\'avant et l\'après le clique sur le bouton
var arr_after = [];
var arr_before = [];

//Mettre le contenu dans le tableau (le contenu est dit dans les pages des changements)
arr_before = read(arr);

/*
Fonction "compare" qui sert à comparer les données d\'avant et d\'après sont 
différents, si c\'est le cas, un pop-up de confirmation va afficher les changements et 
demander si l\'utilisateur est d\'accord ou pas de poursuivre.

Cette fonction sert aussi à porter les paramètres "filename" et "get".
"filename" est le nom du fichier php qui contient les requêtes pour écrire dans la base de données
"get" est la valeur qui est sur l\'url  
*/
function compare(arr_before, arr_after, filename, get)
{
    for (let i = 0; i < arr_before.length; i++) 
    {   
        
        if(arr_before[i][1] != arr_after[i][1])
        {
            //Supprimer les balises HTML pour l\'affichage des changements 
            var str_replaced_before = arr_before[i][1].replace(/<[^>]*>/g, "");
            var str_replaced_after = arr_after[i][1].replace(/<[^>]*>/g, "");

            //Pop-up de confirmation où sont affichés les changements
            var resultat = window.confirm(\'BEFORE :\\n \\n\'+str_replaced_before+\'\\n\\nAFTER :\\n \\n\'+str_replaced_after+\'\\n\');

            //Passer en paramètre que c\'est un changement
            var change_company = "true";
            
            //Si l\'utilisateur est d\'accord avec les changements (si oui = true)
            if (resultat == true)
            {
                //Tester si toutes les regex du formulaire ont été respectées
                var resultat_form = form_change_startup.checkValidity();

                //Si les regex ont été respectées
                if(resultat_form == true)
                {
                    //Changer la variable à true pour écrire dans la base de données les changements
                    var valid = "true";

                    if (valid == "true")
                    {
                        //Ecriture des changements dans la base de données
                        $.ajax
                        ({  
                            //Chemin vers la page qui contient les requêtes SQL
                            url:"tools/"+filename,
                            method:"POST",
                            dataType:"text",
                            data: 
                            {
                                get : get,
                                name_field : arr_before[i][0],
                                changed_field : arr_after[i][1],
                                change_company : change_company
                            },

                            /*Si tout est bien, il affiche un pop-up, en disant que les changements
                            ont été faits et il rafraîchit la page pour montrer à l\'utilisateur les changements*/
                            success:function(data)
                            {
                                alert("The "+arr_before[i][0]+" was changed");
                                window.location.replace("company_information_modification.php?id="+get);
                                location.reload();
                            }
                        });
                    }
                }   
            }          
        }
    }
}


//Permet de récupérer les données qui ont été écrit après le clique sur le bouton
function after_click()
{
    /*Mettre les données dans le tableau after et appeler la fonction compare en donnant
    les tableaux, le nom du fichier et le paramètre qui est dans l\'url*/
    arr_after = read(arr);
    compare(arr_before, arr_after, filename, get);
}


/*
Fonction qui permet de faire un tableau multi-dimension (plus d\'un paramètre par ligne), 
en allant chercher les valeurs par rapport aux id\'s qu\'on a initialiser sur la page des changements
*/
function read(arr) 
{
    //Initialiser un tableau vide pour mettre les valeurs des id\'s que nous avons spécifiés
    var arr_read =[];

    for (let i = 0; i < arr.length; i++) 
    {
        /*
        arr_read.push permet d\'ajouter au tableau vide, les id\'s et les valeurs des id\'s.
        Les valeurs des id\'s sont récupérés par le document.getElementByID().value
        */
        arr_read.push([arr[i], document.getElementById(arr[i]).value]);
        
    }
    //Faire un return du tableau pour l\'utiliser ailleurs de la fonction
    return arr_read; 
    
}

//Fonction pour mettre un exit year dans la base de données pour la startup
function company_delete()
{
    //Fonction pour avoir l\'année courante
    function GetDateYear() 
    {
        var today = new Date();
        var year = today.getFullYear();
        return year;
    }
    
    //Récupérer la date du jour
    var year_date = GetDateYear();

    //Passer en paramètre que c\'est un effacement
    var delete_startup = "true";

    //Pop-up de confirmation où il demande à l\'utilisateur s\'il veut vraiment effacer la startup
    var resultat = window.confirm("Do you really want to erase the company?");
    
    //Si l\'utilisateur est d\'accord avec les changements (si oui = true)
    if (resultat == true)
    {
        //Ecriture des changements dans la base de données
        $.ajax
        ({  
            //Chemin vers la page qui contient les requêtes SQL
            url:"tools/company_information_modification_db.php",
            method:"POST",
            dataType:"text",
            data: 
            {
                delete_startup : delete_startup,
                get : get,
                year_date : year_date,
            },

            /*Si tout est bien, il affiche un pop-up, en disant que les changements
            ont été faits et il rafraîchit la page pour montrer à l\'utilisateur les changements*/
            success:function(data)
            {
                alert("The startup was erased");
                setTimeout(function()
                {
                    window.location.reload(1);
                }, 0);
            }
        });
    }         
}


';

?>