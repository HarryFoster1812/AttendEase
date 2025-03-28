<head>
    <link rel="stylesheet" href="../css/admin.css">
    <?php    
        if(isset($_COOKIE["darkMode"])){
            echo '<link rel="stylesheet" id="darkstylesheet" href="../css/admin_dark.css">';
        }
    ?>
</head>
<?php
$records = $db->query("SELECT * FROM ".$table, []);
$pdo = $db->getPdo();
$stmt = $pdo->prepare('SHOW KEYS FROM '.$table.' WHERE Key_name = "PRIMARY"');
$stmt->execute();
$keys = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tableInfo = $db->query("SELECT COLUMN_NAME AS 'Field', COLUMN_KEY AS 'Key', COLUMN_DEFAULT AS 'Default' FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :dbName AND TABLE_NAME = :tableName; ", [":dbName" =>$db->getDbname(), ":tableName"=>$table]);
?>



<div id="overlay" class="overlay hidden">

    <div class="popup flex-column h-75" id="insert-popup">
        <h2>Insert a new record</h2>
        <div class ="w-80 overflow-scroll py-2">
            <?php
            for($i=0;$i<sizeof($tableInfo);$i++){
                $columnName = $tableInfo[$i]["Field"];
                $content = '
                    <h3>'.$columnName.'</h3>
                    <input class="mb-3 px-2" value="'.$tableInfo[$i]["Default"].'" />';
                echo $content;
            }
            ?>
        </div>
        <div class="button-container mt-4">
            <button class="btn btn-success" id="submit">Insert</button>
            <button class="btn btn-danger" id="cancel">Cancel</button>
        </div>
    </div>
</div>

<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1 id="tableHead" class="mb-5 mt-4"><?php echo $table; ?> Table</h1>


    <div class="overflow-scroll py-2 d-flex align-items-center" style="max-width:75%;">
        <table>
            <tr>
                <?php
                for($i=0;$i<sizeof($tableInfo);$i++){
                    $columnName = $tableInfo[$i]["Field"];
                    $content = '
                    <th class="px-3">'.$columnName.'</th>';
                    echo $content;
                }
                ?>
                <th>Actions</th>
            </tr>
            <?php 
            for($i=0;$i<sizeof($records);$i++){
            $content = '<tr class="clickable-row">';
                for($j=0;$j<sizeof($tableInfo);$j++){
                    $columnName = $tableInfo[$j]["Field"];
                    $data = $records[$i][$columnName];
                    $content .= '
                    <td class="px-3">'.$data.'</td>';
                }

                $content .= '
                    <td class="px-3">
                        <a href="'.UrlHelper::contructHref($records[$i], $table, $keys).'" style="text-decoration:none">
                            <button class="btn btn-warning">Edit</button>
                        </a>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>';    

                echo $content;
            }
            ?>
                
        </table>
    </div> 
    <button id="insert" class="btn btn-success mt-3">Add new record</button>
</div>



<?php 

/*
$table = $_GET["table"];
$filter = $_GET["filter"];
$id = $_GET["id"];
$multifilter = $_GET["multi"];
*/

?>
