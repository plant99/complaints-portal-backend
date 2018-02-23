<?php use App\Http\Controllers\ComplaintController;?>
<!DOCTYPE html>
<html>
<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC|Rambla" rel="stylesheet">

    <script type="text/javascript" src="js/jquery.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div class="topbar row">
        <img src="images/header.png"/>
        <p class="col-sm-1"></p>
        <h2 class="col-sm-7"> Website Update Portal</h2>

        <label for="category-filter" class="col-sm-1">Filter</label>
        <select id = "category-filter" class="category-filter col-sm-2">
          <option value="all">all</option>
          <option value="WAITING">waiting</option>
          <option value="PROCESSING">processing</option>
          <option value="RESOLVED">resolved</option>
      </select>
    </div>
  <span class="col-sm-1"></span>
    <div class="complaints-container row">
      
    </div>

    

    <script type="text/javascript" src="js/dashboard.js"></script>

    </body>
</html>