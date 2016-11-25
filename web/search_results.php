<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>yourSPACE </title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>
<div class="topbar">
    <?php include 'topbar.php'?>
</div>

<div class="nav">
    <?php include 'navigation.php'?>
</div>
<div class="wrapper">

<gcse:searchbox-only resultsUrl="search_results.php" newWindow="false" queryParameterName="search">

    <div id="content">
    <script>
        (function() {
        var cx = '010277497475013333864:hwamqpgvgfq';
        var gcse = document.createElement('script');
        gcse.type = 'text/javascript';
        gcse.async = true;
        gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(gcse, s);
        })();
    </script>
    <gcse:searchresults-only></gcse:searchresults-only>

    </div>

</div>
<div class="footer">
    <?php include('footer.php') ?>
</div>
</body>
</html>
