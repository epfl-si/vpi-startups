<?php

//Script Javascript pour masquer le menu si header=false dans les paramètres de l'url des pages des graphiques
echo "
<script>
    $(document).ready(function(){
        var url = window.location.href;
        var get_url = new URL(url);
        var header_result = get_url.searchParams.get('header');

        if(header_result == 'false')
        {
            $('#header').css('display', 'none');
        }
    });
</script>
";
?>
