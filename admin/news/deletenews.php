<?php 

$objDB = mssql_select_db("intelle");
$data = mssql_query(" SELECT * FROM news")
or die(mssql_error());

$ID = $_GET['ID'];
$sql = "update news set status='0' WHERE ID = '$ID'";

  mssql_query($sql);


?>
<script type="text/javascript">
    window.location = "../indexadmin.php?Menu=2&Submenu=shownews";
</script>