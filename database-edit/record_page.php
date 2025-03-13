<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1>Record in <?php echo $table; ?></h1>

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

    echo $query;

    $record = $db->query($query , [])[0];
    $columns = array_keys($record);

    for($i=0;$i<sizeof($columns);$i++){
    $content = '
    <h2>'.$columns[$i].'</h2>
    <input value="'.$record[$columns[$i]].'"/>
    ';
        echo $content;
    }
    ?>
    <button class="btn btn-success">Change</button>
</div>
