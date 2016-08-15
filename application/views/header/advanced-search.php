
<style>
	#input-plate{
    text-transform: uppercase;
	}
	.content {
		padding-top: 5px !important;
	}

</style>

<div class="container">
<div class="row">
	<div class="col-lg-12" >
	
		<a  data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="float:right;">
		  
		  <i class="fa fa-filter"></i>	&nbsp;	&nbsp;<span>Advanced Search</span>
		</a>
	</div>
	<div class="col-lg-12">
		<div class="collapse" id="collapseExample">
		<form class="unibar-search" method="post" action="<?=base_url('index.php/feed/quickSearch')?>">
		  <div class="row">
		    <div class="col-lg-6">
		      <div class="form-group">
			    <div class="col-sm-10">
                	<input class="form-control" name="search" id="search" type="text" placeholder="Search anything..." style="width:100%;">
			    </div>
			  </div>
			  <br>
			  <br>
		      <div class="form-group">
			    <div class="col-sm-10">
	            	<select name="category" id="search-category" class="form-control">
	            		<option disabled="disabled" selected>Category</option>
	            		<?php foreach($categories as $category){ ?>
	            		<option value="<?php echo $category['name'] ?>"> <?php echo ucfirst($category['name']) ?></option>
	            		<?php } ?>
	            	</select>
			    </div>
			  </div>
			  <div id="properties-container" style="clear: both;padding-top: 20px;"></div>
			  <div class="row">
			  	<div class="col-sm-10">
			  		
	                <button type="button" id="advancedSearchBtn"  style="margin-top: 20px;" class="btn btn-primary case-u">

	                <span id="nloading-search" ><i class="fa-filter mgr-5"></i>search</span>
	                <span id="loading-search" class="hidden"><i class="fa fa-cog fa-spin fa-3x fa-fw mgr-5"></i>searching...</span>
	                </button>
			  	</div>
			  </div>
			  
		    </div>
			  <div class="col-lg-6">

			  </div><!-- /.col-lg-6 -->
		  </div>
		  <br>
		  <br>	
		  </form>
		</div>	
	</div>
</div>
</div>