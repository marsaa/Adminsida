<html>
<head>
<title>Participants</title>
    <link rel="stylesheet" type="text/css" href="../css/adminstyle.css"/>
</head>

<body>


<?php 
require_once "../database.php";

if(!empty($_GET['id'])){

	$user_id = null;
	$bookings = null;
	
	$id = $_GET['id'];


    if(isset($_POST['submit'])){
        if($_POST['submit'] == "Mail all" && isset($_POST['content'])){
            ?><div id="mail-content" style="display: none"><?php echo $_POST['content'] ?></div> <?php
            echo $_POST['content'];
        }
    }

	?>


    <form method="POST" action="mailAll.php">
        <input type="text" name="content" size="100"><br><br>
        <input type="submit" name="submit" value="Submit">
        <input type="hidden" name="id" value="<?php echo $id ?>">
    </form>

    <?php

	$db = DB::getInstance();
    $sql = $db->dbh->prepare("SELECT * FROM bookings WHERE event_id = :id");
    $sql->bindValue(":id",$id);
    $sql->execute();
    $bookings = $sql->fetchAll();


    $bookings_length = count($bookings);

    $user_info = array();
    for($i = 0; $i<$bookings_length; $i++){

    $user_id = $bookings[$i]['user_id'];

    $db = DB::getInstance();
    $sql = $db->dbh->prepare("SELECT * FROM users WHERE id = :user_id");
    $sql->bindValue(":user_id",$user_id);
    $sql->execute();
    $user_info = array_merge_recursive($user_info, $sql->fetchAll())

    ?> <div class="admin-participants" id="participant-<?php echo $user_id ?>">
            <h2>Name: </h2><p><?php echo  $user_info[$i]['firstname'] . " " . $user_info[$i]['lastname']?></p>
            <h2>Email: </h2><p> <?php echo $user_info[$i]['email']; ?> </p>
        <div class="admin-btns" id="admin-participants-delete" style="cursor:pointer">Remove from event</div>
        </div>
        <?php

    }

}
?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    var targetID;
    $('body').on('click', '#admin-participants-delete', function (event) {
        console.log($(event.target).parent().attr("id"));
        targetID = $(event.target).parent().attr("id");
        targetID = targetID.substring(targetID.indexOf('-') + 1, targetID.length);
        $choice = checkIfSure();

        if($choice == true){
            $.ajax({
                url: '/admin/deleteUser.php',
                type: 'post',
                data: {user_id: targetID},
                dataType: 'json',
                success: function (output) {
                    alert("Success " + output);
                    location.reload();
                },
                error: function (error) {
                    alert("Error " + error);
                }
            });
        }
        else if($choice == false){

        }
    });
    $('body').on('click', '#mail-submit', function (event) {
        console.log("hej");
    });

    function checkIfSure() {
        if (confirm("Are you sure?")) {
            return true;
        }
        return false;
    }
</script>


</html>