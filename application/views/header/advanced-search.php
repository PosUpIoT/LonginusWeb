
<style>
	#input-plate{
    text-transform: uppercase;
	}
	.content {
		padding-top: 5px !important;
	}
	#map-search {
     height: 300px;
   }
   .form-custom{
   	clear: both;
   	padding-top: 20px;
   }
</style>

<div class="container">
<div class="row">
	<div class="col-lg-12" >
		<?php
			$this->load->helper('url');
			$t = base_url(uri_string());
			if(strpos($t, "feed/search") === false) {
				echo '<a data-toggle="collapse" class="btn btn-primary btn-sm" data-target="#collapseExample" aria-expanded="false"  aria-controls="collapseExample" style="float:right;margin:5px;"><i class="fa fa-filter"></i> &nbsp; &nbsp;<span>Advanced Search</span></a>';
			}
		?>
	</div>
	<div class="col-lg-12">
		<div class="collapse" id="collapseExample">
		<form class="unibar-search" method="GET" id="adv-search"  enctype='application/json' action="<?=base_url('index.php/feed/search')?>" style="padding-top: 10px;">
		  <div class="row">
		    <div class="col-lg-6">
		      <div class="form-group">
			    <div class="col-sm-10">
                	<input class="form-control" name="search" id="search" type="text" placeholder="Search anything..." style="width:100%;">
			    </div>
			  </div>
		      <div class="form-group form-custom">
			    <div class="col-sm-10">
			    	<label for="disabledTextInput">Search Type:</label><br>
			    	<label class="radio-inline">
					  <input type="radio" name="searchType" id="searchType1" value="1" checked="checked"> Found
					</label>
					<label class="radio-inline">
					  <input type="radio" name="searchType" id="searchType2" value="2"> Lost
					</label>
			    </div>
			  </div>
		      <div class="form-group form-custom">
			    <div class="col-sm-10">
	            	<select name="category" id="search-category" class="form-control">
	            		<option disabled="disabled" value="" selected>Category</option>
	            		<?php foreach($categories as $category){ ?>
	            		<option value="<?php echo $category['name'] ?>"> <?php echo ucfirst($category['name']) ?></option>
	            		<?php } ?>
	            	</select>
			    </div>
			  </div>
			  <div id="properties-container"></div>
			  <div class="row">
			  	<div class="col-sm-10">
			  		
					<input type="hidden" name="properties" id="hdnProperties" />
					<input type="hidden" name="rad" id="hdnRadius" />
					<input type="hidden" name="lat" id="hdnLat" />
					<input type="hidden" name="lng" id="hdnLng" />
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token" />
	                <button type="submit" id="advancedSearchBtn"  name="advsearch" style="margin-top: 20px;" class="btn btn-primary case-u">

	                <span id="nloading-search" ><i class="fa-filter mgr-5"></i>search</span>
	                <span id="loading-search" class="hidden"><i class="fa fa-cog fa-spin fa-3x fa-fw mgr-5"></i>searching...</span>
	                </button>
			  	</div>
			  </div>
			  </form>
		    </div>
			  <div class="col-lg-6">

 					<div id="map-search"></div>
 					<p style="margin:20px;">Drag/expand the circle to change the search radius.</p>
			  </div><!-- /.col-lg-6 -->
		  </div>
		  <br>
		  <br>	
		  </form>
		</div>	
	</div>
</div>
</div>