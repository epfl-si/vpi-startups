<?php

echo '
//Initialiser les tableau pour afficher l\'avant et l\'après le clique sur le bouton
var list_fields_name_after = [];
var list_fields_name_before = [];

//Mettre le contenu dans le tableau (le contenu est dit dans les pages des changements)
list_fields_name_before = read(list_fields_name);

/*
Fonction "compare" qui sert à comparer les données d\'avant et d\'après sont 
différents, si c\'est le cas, un pop-up de confirmation va afficher les changements et 
demander si l\'utilisateur est d\'accord ou pas de poursuivre.

Cette fonction sert aussi à porter les paramètres "filename" et "get".
"filename" est le nom du fichier php qui contient les requêtes pour écrire dans la base de données
"get" est la valeur qui est sur l\'url  
*/
function compare_and_write(list_fields_name_before, list_fields_name_after, get, filename, sciper, action)
{

    for (let i = 0; i < list_fields_name_before.length; i++) 
    {           
        if(list_fields_name_before[i][1] != list_fields_name_after[i][1])
        {
            console.log("before : "+list_fields_name_before[i][1]);
            console.log("after : "+list_fields_name_after[i][1]);
            //Ecriture des changements dans la base de données
            $.ajax
            ({  
                //Chemin vers la page qui contient les requêtes SQL
                url:"tools/"+filename,
                method:"POST",
                dataType:"text",
                data: 
                {  
                    action : action,
                    sciper : sciper,
                    get : get,
                    name_field : list_fields_name_before[i][0],
                    before_changes : list_fields_name_before[i][1],
                    after_changes : list_fields_name_after[i][1],
                },
                /*Si tout est bien, il affiche un pop-up, en disant que les changements
                ont été faits et il rafraîchit la page pour montrer à l\'utilisateur les changements*/
                success:function(data)
                {
                    alert("The "+list_fields_name_before[i][0]+" was changed");
                }
                
            });            
        }
    }
}


//Permet de récupérer les données qui ont été écrit après le clique sur le bouton
function after_click()
{
    /*Mettre les données dans le tableau after et appeler la fonction compare en donnant
    les tableaux, le nom du fichier et le paramètre qui est dans l\'url*/
    list_fields_name_after = read(list_fields_name);
    compare_and_write(list_fields_name_before, list_fields_name_after, get, filename, sciper, action);
}


/*
Fonction qui permet de faire un tableau multi-dimension (plus d\'un paramètre par ligne), 
en allant chercher les valeurs par rapport aux id\'s qu\'on a initialiser sur la page des changements
*/
function read(list_fields_name) 
{
    //Initialiser un tableau vide pour mettre les valeurs des id\'s que nous avons spécifiés
    var list_fields_name_read =[];

    for (let i = 0; i < list_fields_name.length; i++) 
    {
        /*
        list_fields_name_read.push permet d\'ajouter au tableau vide, les id\'s et les valeurs des id\'s.
        Les valeurs des id\'s sont récupérés par le document.getElementByID().value
        */
        list_fields_name_read.push([list_fields_name[i], document.getElementById(list_fields_name[i]).value]);
        
    }
    //Faire un return du tableau pour l\'utiliser ailleurs de la fonction
    return list_fields_name_read; 
    
}



';

?>