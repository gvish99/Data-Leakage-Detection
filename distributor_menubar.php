<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../index.php">Data Leakage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php 
           if($_SESSION['usertype']=="distributor"){
            echo "
<li class='nav-item active'>
        <a class='nav-link' href='distributor_dashboard.php'>Home</a>
      </li>
            ";
           }
      ?>
                        
    </ul>
    
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link" href="../main/logout.php">Logout</a>
      </li>                                    
    </ul>
  </div>
</nav>