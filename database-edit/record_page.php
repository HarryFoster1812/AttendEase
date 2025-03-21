<head>
    <link rel="stylesheet" href="../css/admin.css">
    <?php    
        if(isset($_COOKIE["darkMode"])){
            echo '<link rel="stylesheet" id="darkstylesheet" href="../css/admin_dark.css">';
        }
    ?>
</head>
<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1 class="my-4 db-text">Record in <?php echo $table; ?></h1>

    <?php
    /*
    $table = $_GET["table"];
    $filter = $_GET["filter"];
    $id = $_GET["id"];
    $multifilter = $_GET["multi"];
    */
    if(isset($multifilter)){
        $filter = json_decode($filter);
        $id = json_decode($id);
        $query = 'SELECT * FROM '.$table.' WHERE ';
        for($i=0;$i<sizeof($filter);$i++){
            $query .= $filter[$i].'='.$id[$i].' AND ';
        }
        $query = rtrim($query, 'AND ');
    }

    else{
        $query = "SELECT * FROM ".$table." WHERE ".$filter."=".$id;
    }

    echo "<h3 class='mb-4 db-text' id='query'>".$query."</h3>";

    $record = $db->query($query , [])[0];
    $columns = array_keys($record);

    for($i=0;$i<sizeof($columns);$i++){
    $content = '
    <h2 class="mb-3 db-text">'.$columns[$i].'</h2>
    <input class ="px-2 mb-4" value="'.$record[$columns[$i]].'" data-default="'.$record[$columns[$i]].'"/>
    ';
        echo $content;
    }
    ?>
    <button class="btn btn-warning mb-3" id="change">Change</button>
    <button class="btn btn-success mb-3" id="reset">Reset</button>
</div>
