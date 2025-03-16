<div id="overlay" class="overlay hidden">

    <div class="popup flex-column h-50" id="sql-popup">
        <h4>Run an SQL Query</h4>
        <input id="commandInput" class="w-80 h-50"/>
        <h5 class="my-2">Response:</h5>
        <span id="response" class="w-80 overflow-scroll"></span>
        <div class="button-container mt-4">
            <button class="btn btn-danger" id="submit">Run (You can not undo this action)</button>
            <button class="btn btn-success" id="cancel">Cancel</button>
        </div>
    </div>
</div>

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

    <button class="btn btn-danger" id="showPopup">Run SQL Query</button>

</div>
