<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1>Database Tables</h1>

    <?php
    $tables = $db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE :dbName ORDER BY TABLE_NAME ;" , [":dbName" => $db->getDbname()]);


    for($i=0;$i<sizeof($tables);$i++){
        $tableName = $tables[$i]["TABLE_NAME"];
        $content = '
        <a href="./?table='.$tableName.'">'.$tableName.'</a>';
        echo $content;
    }

    ?>

</div>
