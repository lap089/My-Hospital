
<?php
global $user;

if($user->uid) {
    echo '
    <div class="menu-user">
    <strong>Hi </strong>
    <a href="/user">'. $user->name .'</a>
    </div>
    <div class="menu-log">
    <a href="/user/logout">Logout <i class="fa fa-sign-out"></i></a>
    </div>';
} else {
    echo '<div class="menu-log">
    <a href="/user">Login <i class="fa fa-sign-in"></i></a>
    </div>';
}

?>





