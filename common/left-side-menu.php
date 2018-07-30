<li>
    <div class="userView">
        <div class="background">
            <img class="responsive-img" src="../images/2b.jpg">
        </div>
        <a href="#!user"><img class="circle" src="../images/<?php echo isset($_SESSION['gender']) ? ($_SESSION['gender'] == 'F' ? "user-girl" : "user") : 'user'?>.png"></a>
        <a href="#!name" class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" data-activates="profile-dropdown"><i class="material-icons right white-text">arrow_drop_down</i><span class="white-text name"><?php echo isset($_SESSION['first_name']) ?  $_SESSION['first_name']." ".$_SESSION['last_name'] : '';?></span></a>
        <a href="#!email"><span class="white-text email truncate"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '';?></span></a>
        <ul id="profile-dropdown" class="dropdown-content">
            <li class="menu-btn" data-change="../common/cuenta.php"><a href="#" class="waves-effect waves-light"><i class="material-icons">account_circle</i> Cuenta</a></li>
            <li><a href="#"><i class="material-icons">help</i> Ayuda</a></li>
            <li class="divider"></li>
            <li><a href="../php/logout.php"><i class="material-icons">keyboard_backspace</i> Salir</a>
            </li>
        </ul>
    </div>
</li>



<!-- <li id="menu-btn-crear-grupo" class="menu-btn menu-btn-active" data-change="ingresar-grupo.php"><a class="waves-effect waves-light"><i class="material-icons">add_box</i>Creación de Grupos</a></li> -->
