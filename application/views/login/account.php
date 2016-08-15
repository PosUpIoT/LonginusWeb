    <!-- Content -->
    <!-- Content -->
    <section class="content pad-lg bg-black-3">
    
      <!-- Container -->
      <div class="container">

        <!-- Header -->
        <header class="text-center mgb-30">
          <?php 
            $this->gravatar = new \emberlabs\gravatarlib\Gravatar();
            $this->gravatar->setAvatarSize(150)->setDefaultImage('identicon');
            echo '<img src="' . $this->gravatar->buildGravatarURL($this->session->email) . '" width="150" height="150" class="mgb-30">';
          ?>
          <p>Deseja ter um avatar personalizado? Clique <a href="#">aqui</a> e saiba como!</p>
        </header>
        <!-- /Header -->
      
        <!-- Login Form -->
        <div class="unicard unicard-framed account-form">
        
          <div>
            <h5 class="text-center fw-bold">Alteração do Perfil</h5>
            <form action="<?php  echo base_url('/user/update') ?>" method="PUT">
              <input class="text-box form-control" type="email" placeholder="Your Email"> 
              <input class="text-box form-control" type="password" placeholder="Your Password">
              <input class="text-box form-control" type="password" placeholder="Repeat Password">
              <button class="btn btn-green btn-block">Alterar</button>
            </form>
          </div>        
        </div>
        <!-- /Login Form -->

      </div>
      <!-- /Container -->
    
    </section>
    <!-- /Content -->