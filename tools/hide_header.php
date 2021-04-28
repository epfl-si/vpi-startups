<?php

echo "
<script>
    $(document).ready(function(){
        var url = window.location.href;
        var url2 = new URL(url);
        var c = url2.searchParams.get('header');
        console.log(c);

        if(c == 'false')
        {
            $('#header').css('display', 'none');
        }
    });
</script>
";
?>
