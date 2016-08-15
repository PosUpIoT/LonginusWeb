    <!-- Content -->
    <!-- Content -->
    <section class="content pad-lg bg-black-3">
    
      <!-- Container -->
      <div class="container">

        <!-- Header -->
        <header class="text-center mgb-30">
          <h3>Perdeu? Achou? Com Longinus encontrou!</h3>
          <br>
          <div id="infoMessage" style="color: red;"><?php echo $this->session->flashdata('message');?></div>
        </header>
        <!-- /Header -->
      
        <!-- Login Form -->
        <div class="unicard unicard-framed account-form">
        
          <div>
            <h5 class="text-center fw-bold">Cadastro por Email</h5>
            <form action="<?php  echo base_url('/user/register') ?>" method="POST">
              <label for></label>
              <input class="text-box form-control" id="email" name="email" type="email" placeholder="Seu Email" value="<?php echo  $this->session->flashdata('email');?>"> 
              <input class="text-box form-control" id="password" name="password" type="password" placeholder="Sua Senha">
              <input class="text-box form-control" id="password_conf" name="password_conf" type="password" placeholder="Repetir a Senha">
              <button class="btn btn-green btn-block">Cadastrar</button>
            </form>
          </div>
          
          <div>
            <h5 class="text-center fw-bold">Cadastro Social</h5>
            <a class="btn btn-split bg-facebook" href="#">
              <span class="bg-black-10pc"><i class="fa-facebook"></i></span>
              <span>Cadastrar com Facebook</span>
            </a>
            <a class="btn btn-split bg-twitter" href="#">
              <span class="bg-black-10pc"><i class="fa-twitter"></i></span>
              <span>Cadastrar com Twitter</span>
            </a>
            <a class="btn btn-split bg-google-plus" href="#">
              <span class="bg-black-10pc"><i class="fa-google-plus"></i></span>
              <span>Cadastrar com Google</span>
            </a>
          </div>
        
        </div>
        
        </div>
        <!-- /Login Form -->

      </div>
      <!-- /Container -->
    
    </section>
    <!-- /Content -->