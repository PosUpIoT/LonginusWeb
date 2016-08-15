    <!-- Content -->
    <!-- Content -->
    <section class="content pad-lg bg-black-3">
    
      <!-- Container -->
      <div class="container">

        <!-- Header -->
        <header class="text-center mgb-30">
          <p>Não tem uma conta ainda? Cadastre <a href="<?php  echo base_url('/home/signup') ?>" class="uline-hov">aqui</a></p>
          <br>
          <div id="infoMessage" style="color: red;"><?php echo $this->session->flashdata('message');?></div>
        </header>
        <!-- /Header -->
      
        <!-- Login Form -->
        <div class="unicard unicard-framed account-form">
          <div>
            <h5 class="text-center fw-bold">Email Login</h5>
            <form action="<?php  echo base_url('/user/auth') ?>" method="POST">
              <input class="text-box form-control" name="email" id="email" type="email" placeholder="Seu Email"> 
              <input class="text-box form-control" name="password" id="password"  type="password" placeholder="Sua Senha">
              <button class="btn btn-green btn-block" type="submit">Entrar</button>
            </form>
          </div>
          
          <div>
            <h5 class="text-center fw-bold">Login por redes sociais</h5>
            <a class="btn btn-split bg-facebook" href="#">
              <span class="bg-black-10pc"><i class="fa-facebook"></i></span>
              <span>Entrar com o Facebook</span>
            </a>
            <a class="btn btn-split bg-twitter" href="#">
              <span class="bg-black-10pc"><i class="fa-twitter"></i></span>
              <span>Entrar com o Twitter</span>
            </a>
            <a class="btn btn-split bg-google-plus" href="#">
              <span class="bg-black-10pc"><i class="fa-google-plus"></i></span>
              <span>Entrar com o Google</span>
            </a>
          </div>
        
        </div>
        <!-- /Login Form -->

      </div>
      <!-- /Container -->
    
    </section>
    <!-- /Content -->