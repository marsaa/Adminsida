<?php

require_once "../database.php";


    ?>
    <p>Are you sure that you want to email ALL participants of this event?</p>
    <p>This process may take a while. Please don't close this page while it's working</p>

    <form method="POST" action="">
        <input type="hidden" name="content" value="<?php echo $_POST['content'] ?>">
        <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
        <input type="submit" name="submit" value="YES" onclick="working()">
    </form>
    <div id="working" style="display: none;">working...</div>

    <script type="text/javascript">

        function working() {
            document.getElementById('working').style.display = "block";
        }
    </script>

<?php


   if(isset($_POST['content']) && isset($_POST['submit']))
   {
       if($_POST['submit'] == "YES"){

           echo "email sent to: ";
           echo " ";
           ?>
           <br>
           <?php

           $db = DB::getInstance();
           $sql = $db->dbh->prepare("SELECT * FROM bookings WHERE event_id = :id");
           $sql->bindValue(":id",$_POST['id']);
           $sql->execute();
           $bookings = $sql->fetchAll();



           $bookings_length = count($bookings);


           for($i = 0; $i<$bookings_length; $i++) {
               $db = DB::getInstance();
               $sql = $db->dbh->prepare("SELECT email FROM users WHERE id = :user_id");
               $sql->bindValue(":user_id",$bookings[$i]['user_id']);
               $sql->execute();
               $email = $sql->fetchAll();
               $email = $email[0]['email'];

               ?>
               <p> <?php echo $email ?></p>
               <?php

           }
           ?>
           <br>
           <?php
           echo "done!";
       }

   }
?>