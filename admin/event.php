<html>
<head>
    <title>Events</title>
    <link rel="stylesheet" type="text/css" href="../css/adminstyle.css"/>
</head>


<body>
<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';


$db = DB::getInstance();
$sql = $db->dbh->prepare("SELECT * FROM events");
$sql->execute();
$eventData = $sql->fetchAll();
$events_length = count($eventData);

for($i = $events_length - 1; $i >= 0; $i--){
    $id = $eventData[$i]['id'];
    ?>
    <div class="admin-events" id="event-<?php echo $eventData[$i]['id'] ?>">
        <h2><?php echo "Type:"; ?> </h2><p class="event-info"><?php echo $eventData[$i]['type'] ?></p><br>
        <h2><?php echo "Instructor:"; ?> </h2><p class="event-info"><?php echo $eventData[$i]['instructor'] ?></p><br>
        <h2><?php echo "Location:"; ?> </h2><p class="event-info"> <?php echo $eventData[$i]['location'] ?></p><br>
        <h2><?php echo "Start:"; ?> </h2><p class="event-info"><?php echo $eventData[$i]['start'] ?></p><br>
        <h2><?php echo "End:"; ?> </h2><p class="event-info"><?php echo $eventData[$i]['end'] ?></p><br>
        <h2><?php echo "Spots left:"; ?> </h2><p class="event-info"><?php echo $eventData[$i]['spots'] ?></p><br>
        <div class="admin-btns" id="admin-events-delete" style="cursor:pointer">Delete</div>

        <form action="participants.php" method="get">
        <input name="id" type="hidden" value="<?php echo $eventData[$i]['id'] ?>"></input>
        <input class="admin-btns" id="admin-events-view" type="submit" value="participants"></input>
        </form>


        
    </div>

    <?php
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    var targetID;
    $('body').on('click', '#admin-events-delete', function (event) {
        targetID = $(event.target).parent().attr("id");
        targetID = targetID.substring(targetID.indexOf('-') + 1, targetID.length);
        $choice = deleteItem();

        if($choice == true){
            $.ajax({
                url: '/admin/deleteEvent.php',
                type: 'post',
                data: {eventID: targetID},
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


    function deleteItem() {
        if (confirm("Are you sure?")) {
            return true;
        }
        return false;
    }



</script>

</body>
</html>