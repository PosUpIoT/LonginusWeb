
$( document ).ready(function() {
  $.ajaxSetup({async:false});
  $('#advancedSearchBtn').on('click',function()
  {
  	var term = $('#search').val();
  	var cat = $("#search-category option:selected" ).val();
  	var type = $("input[name=searchType]:checked").val();
  	var properties = [];
  	var common_elements = $('.category-property input[type=text]');
  	$(common_elements).each(function( index ) {
	  properties.push({property: this.name, value:  this.value})
	});
  	var advanced_elements = $('.category-property.has-subproperties');
  	$(advanced_elements).each(function( index ) {
  		var prop = $(this).data('prop')
  		var prop_val = $('.category-property.has-subproperties input[name='+prop+']:checked').val();
  		if(prop_val != "")
  		{
  			var temp_data = [];
			var temp = null;
			$($("."+prop_val+"-sub .inner-props")).each(function( index ) {
				temp = $(this).select2('val');
				if(temp != null)
				{
					if(temp.length > 0)
					{
						temp_data.push({subproperty: $(this).data('subprop'), value:temp});					
					}
				}
			});
	  		properties.push({property: prop, value:  prop_val, subproperties: temp_data})
  		}
	});
  	//first level

	$("#nloading-search").addClass( "hidden" );
	$("#loading-search").removeClass( "hidden" );
  	$.ajax({
	  url: "/index.php/feed/search",
      type: 'POST',
      data: { term: term, type: type, category: cat, properties: properties} ,
      contentType: 'application/json; charset=utf-8',
      success:function(data) {
      	alert(data); 
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
	}).done(function() {
		$("#loading-search").addClass( "hidden" );
		$("#nloading-search").removeClass( "hidden" );
	});
  });

  $("#search-category").change(function() {
  		var str = "";


    	str = $("#search-category option:selected" ).val();
    	$.get("/index.php/feed/getCategoryProperties?category="+str, function(data, status){
        	//alert("Data: " + data + "\nStatus: " + status);
        	//var props = $.parseJSON(data);

        		$("#properties-container").html(data);
        		$('.inner-props').select2();
        		$('#input-plate').mask('SSS-0000');
     			$('.property-radio').change(function() {
	     				var current = this.value;
	     				$('.property-suboptions').addClass('hidden');
	     				$('.'+current+'-sub').removeClass('hidden'); 
        				$('.inner-props').select2().val(null).trigger('change');
	    		});
    	});


	});

});
