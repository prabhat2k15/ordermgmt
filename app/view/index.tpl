<!DOCTYPE html>
<html lang="en">
<head>
    {include file="header.tpl"}
</head>
<body>
<div id="fb-root"></div>
<script type="text/tmpl">(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=1452169561514708";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
{include file="navbar.tpl"}
{include file=$__fragment__}
{include file="moresearch.tpl"}
{include file="footer.tpl"}
</body>
</html>
