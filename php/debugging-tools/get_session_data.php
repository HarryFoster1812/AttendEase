<pre style="background: #222; color: #0f0; padding: 10px; border-radius: 5px;">
<code>
<?php
    session_start();
    print_r($_SESSION);
    echo "<hr></code><code>";
    print_r(unserialize($_SESSION["user"]));
?>
</code>
</pre>
