    <!-- Content -->
    <!-- Content -->
    <section class="content pad-md bg-black-3">
    
      <!-- Container -->
      <div class="container">

        <!-- Header -->
        <header class="text-center mgb-30">
          <h3>Perdeu? Achou? Com Longinus encontrou!</h3>
          <br>
          <?php if(validation_errors() != ""){
             echo "<div id='infoMessage' style='color: red;'>".validation_errors()."</div>";
            } ?>
        </header>
        <!-- /Header -->
      
        <!-- Login Form -->
        <div class="unicard unicard-framed account-form">
        
          <div>
            <h5 class="text-center fw-bold">Cadastro por Email</h5>
            <form action="<?php  echo base_url('/index.php/user/register') ?>" method="POST">
              <input class="text-box form-control" id="email" name="email" type="email" placeholder="Seu Email" value="<?php echo set_value('email'); ?>"> 
              <input class="text-box form-control" id="name" name="name" type="text" placeholder="Seu Nome" value="<?php echo set_value('name'); ?>"> 
              <input class="text-box form-control" id="password" name="password" type="password" placeholder="Sua Senha">
              <input class="text-box form-control" id="password_conf" name="password_conf" type="password" placeholder="Repetir a Senha">
              <button class="btn btn-green btn-block">Cadastrar</button>
            </form>
          </div>        
        </div>
        
        </div>
        <!-- /Login Form -->

      </div>
      <!-- /Container -->
    
    </section>
    <!-- /Content -->