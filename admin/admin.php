<!DOCTYPE html>
<html>
<head>
    <title>Projekt IT - Style test</title>
    <link rel="stylesheet" type="text/css" href="../css/adminstyle.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../fullPageScroll/jquery.fullPage.css"/>

    <script type="text/javascript" src="../fullPageScroll/jquery.fullPage.js"></script>

    <script src="https://use.fontawesome.com/bbba27360b.js"></script>
</head>
<body>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database.php';

if(!empty($_POST) && isset($_POST) && isset($_POST['instructor']) && isset($_POST['types'])) {

    $classname = "";
    $location = "";
    $year = "";
    $month = "";
    $day = "";
    $start = "";
    $end = "";
    $spots = 0;
    $instructor = "";
    $types = "";


    if (!empty($_POST['types']))
    {
        $types = trim($_POST['types']);
    }
    if (!empty($_POST['Location']))
    {
        $location = trim($_POST['Location']);
    }
    if (!empty($_POST['year']))
    {
        $year = trim($_POST['year']);
    }
    if (!empty($_POST['month']))
    {
        $month = trim($_POST['month']);
    }
    if (!empty($_POST['day']))
    {
        $day = trim($_POST['day']);
    }
    if (!empty($_POST['start']))
    {
        $start = trim($_POST['start']);
    }
    if (!empty($_POST['end']))
    {
        $end = trim($_POST['end']);
    }
    if (!empty($_POST['instructor']))
    {
        $instructor = trim($_POST['instructor']);
    }
    if (!empty($_POST['spots']))
    {
        $spots = trim($_POST['spots']);
    }

    $dateTimeStart = $year . "-" . $month . "-" . $day . " " . $start . ":" . "00"  ;
    $dateTimeEnd = $year . "-" . $month . "-" . $day . " " . $end . ":" . "00";

    echo $types;
    echo " ";
    echo $instructor;
    echo " ";
    echo $location;
    echo " ";
    echo $spots;



    $db = DB::getInstance();
    $sql = $db->dbh->prepare("INSERT INTO events (type, instructor, location, start, end, spots) VALUES (:type, :instructor, :location, :start, :end, :spots)");
    $sql->bindValue(":type", $types);
    $sql->bindValue(":instructor", $instructor);
    $sql->bindValue(":location", $location);
    $sql->bindValue(":start", $dateTimeStart);
    $sql->bindValue(":end", $dateTimeEnd);
    $sql->bindValue(":spots", $spots);

    $sql->execute();

}
?>



    <script type="text/javascript">
        $(document).ready(function () {
            $('#fullpage').fullpage({
                sectionsColor: ['green', '#4BBFC3', '#7BAABE', 'red'],
                anchors: ['schedule', 'inclass', 'members'],
                scrollingSpeed: 1000,
                slidesNavigation: true,
                slidesNavPosition: 'bottom',
                controlArrows: false,
                verticalCentered: false,

                afterLoad: function(anchorLink, index){
                    if (index == 1) {
                        $('#social-btns').fadeTo(0, 0);
                    } 
                },

                onLeave: function(anchorLink, index){
                    if (index == 1) {
                        $('#social-btns').fadeTo("fast", 0);
                    // $('#vibez, mute-wrapper').fadeTo("fast", 1);
                } else {
                    $('#social-btns').fadeTo("fast", 1);
                    // $('#vibez, mute-wrapper').fadeTo("fast", 0);
                }
            },
        });
        });
    </script>
    <div class="no-highlight" id="cssmenu">
        <ul>
            <li><p id="admin">ADMIN</p></li>
            <li><a href='#schedule'>SCHEDULE</a></li>
            <span class="menu-divider"></span>
            <li><a href="#inclass">WHO IS IN YOUR CLASS</a></li>
            <span class="menu-divider"></span>
            <li><a href='#members'>ALL MEMBERS</a></li> 
            <span class="menu-divider"></span>

    </div>




    <div id="fullpage">
        <div class="section" id="section0">
                <div class="container">
                    <div class="buttonWrapLeft">
                        <a href="#inclass" class="buttonLeft"></a>
                    </div>

                    <div class="content">
         <li class="dropdown">
              
                    <form id="login-form">
                        
                        <input type="button" id="create" value="CREATE EVENT" style="cursor:pointer" onclick="document.getElementById('modal').style.display='block'">
                        <a id="create" href="admin/event.php" style="cursor:pointer">Delete event</a>
                    </form>
            </li>
        </ul>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content animate">
            <div id="signup-header">Create Event</div>
            <form action="" method="POST">
                <div class="register">

                    <label>Classname</label>
                    <input name="Classname" type="text" placeholder="Classname">

                    <label>Location</label>
                    <input name="Location" type="text" placeholder="Location">

                    <label>time</label>
                    <div class="time">
                        <select name="year">
                            <option value="">Year</option><?php

                            for ($y = date('Y'); $y <= date('Y', strtotime('+5 years')); $y++)
                            {
                            echo '<option value="' . $y . '">' . $y . '</option>';
                            }
                            ?>
                        </select>
                        <select name="month">
                            <option value="">Month</option>
                            <?php
                            // 12 månader visas med dess namn
                            for ($m = 1; $m <= 12; $m++)
                            {
                                echo '<option name="month" value="' . $m . '">' . date('F', mktime(0, 0, 0, $m, 1)) . '</option>';
                            }
                            ?>
                        </select>
                        <select name="day">
                            <option value="">Day</option>
                            <?php
                            for ($d = 1; $d <= 31; $d++)
                            {
                                echo '<option value="' . $d . '">' . $d . '</option>';

                            }
            ?>
                        </select>
                        <select name="start">
                            <option value="">Start time</option>
                            <?php

                            for ($i = 0; $i<10; $i++)
                            {
                                echo '<option value="' . $i . '">' . "0" . $i . '</option>';
                            }
                            for($i = 10; $i<24; $i++)
                            {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>

                        </select>
                        <select name="end">
                            <option value="">End time</option>
                            <?php
                            for ($i = 0; $i<10; $i++)
                            {
                                echo '<option value="' . $i . '">' . "0" . $i . '</option>';
                            }
                            for($i = 10; $i<24; $i++)
                            {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }

                            ?>
                        </select>
                        <select name="instructor">
                            <option value="">Instructor</option>
                            <?php
                            require_once "database.php";
                            $state = true;

                                $db = DB::getInstance();
                                $sql = $db->dbh->prepare("SELECT firstname FROM users WHERE admin = :state");
                                $sql->bindValue(":state", $state);
                                $sql->execute();
                                $admins = $sql->fetchAll();
                                $admins_length = count($admins);

                            for ($i = 0; $i < $admins_length; $i++)
                            {
                                echo '<option value="' . $admins[$i]['firstname'] . '">' . $admins[$i]['firstname'] . '</option>';

                            }
                            ?>
                        </select>

                        <select name="spots">
                            <option value="">spots</option>
                            <?php
                            for ($d = 1; $d < 100; $d++)
                            {
                                echo '<option value="' . $d . '">' . $d . '</option>';

                            }
                            ?>
                        </select>

                        <select name="types">
                            <option value="">Types</option>
                            <?php
                            $db = DB::getInstance();
                            $sql = $db->dbh->prepare("SELECT type FROM event_types");
                            $sql->bindValue(":state", $state);
                            $sql->execute();
                            $types = $sql->fetchAll();
                            $types_length = count($types);

                            for($i = 0; $i<$types_length; $i++){
                                echo '<option value="'. $types[$i]['type'] . '">' . $types[$i]['type'] . '</option>';
                            }

                            ?>

                        </select>


                    </div>
                    <input type="text" name="website" placeholder="Webbplats">
                    <div class="clearfix">
                        <input type="button" name="cancelbtn" value="CANCEL"></input>
                        <input type="submit" name="submitbtn" value="CREATE">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

        <div class="section" id="section1">
   
                <div class="container">
                    <div class="buttonWrapLeft">
                        <a href="#inclass" class="buttonLeft"></a>
                    </div>

                    <div class="content">
                        ABOUT VIBING PEOPLE
                    </div>
                 </div>
            </div>
            

            
        <div class="section" id="section2">
          
                <div class="container">
                    <div class="buttonWrapLeft">
                        <a href="#members" class="buttonLeft"></a>
                    </div>

                    <div class="content">
                        1
                    </div>

                </div>
            </div>
            
        </div>

       
    </div>
    <script type="text/javascript" src="js/mute.js"></script>
    <script type="text/javascript" src="js/tab.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <!-- <script type="text/javascript" src="js/hide.js"></script> -->


</body>
</html>