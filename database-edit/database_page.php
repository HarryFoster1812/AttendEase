<head>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<div id="overlay" class="overlay hidden">

    <div class="popup flex-column h-50" id="sql-popup">
        <h4 class="text-primary">Run an SQL Query</h4>
        <textarea id="commandInput" class="w-80 h-50"></textarea>
        <h5 class="my-2 text-primary">Response:</h5>
        <span id="response" class="w-80 overflow-scroll text-black"></span>
        <div class="button-container mt-4">
            <button class="btn btn-danger" id="submit">Run (You can not undo this action)</button>
            <button class="btn btn-success" id="cancel">Cancel</button>
        </div>
    </div>
</div>

<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1 class="text-primary mb-5 db-title">Database Tables</h1>
    <div class="list-group">
    <?php
    $tables = $db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE :dbName ORDER BY TABLE_NAME ;" , [":dbName" => $db->getDbname()]);

    
    for($i=0;$i<sizeof($tables);$i++){
        $tableName = $tables[$i]["TABLE_NAME"];
        $content = '
        <a class="list-group-item text-center px-5 table-link" href="./?table='.$tableName.'">'.$tableName.'</a>';
        echo $content;
    }

    ?>
    </div>
    <button class="btn btn-danger mt-4" id="showPopup">Run SQL Query</button>

</div>
