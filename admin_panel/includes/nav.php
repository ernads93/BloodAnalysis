<div class="sidebar">
        <img src="styles/logo_white.png" />
        <ul>
          <li>
            <a href="?link=sample"><i class="fas fa-sticky-note"></i>Blood test</a>
          </li>
          <?php
            $checkRole = "admin";
            if($_SESSION['user_name'] == $checkRole) { ?>
              <li>
                <a href="?link=users"><i class="fas fa-plus-square"></i>Users</a>
              </li>
            <?php }
          ?>
          <li>
            <a href="dashboard.php?logout"><i class="fas fa-sign-out-alt"></i>Log-out</a>
          </li>
        </ul>
        <div class="help">
          <a href="?link=help"><i class="fas fa-question"></i></a>
        </div>
      </div>