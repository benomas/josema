<?php
/**
 * @package firmasite
 */
// this one letting us translate page template names
?>
<script>
	
	var basicFilter={
		name1:'<?php echo !empty($_GET["basic_filter_name1"])?$_GET["basic_filter_name1"]:"" ?>',
		value1:'<?php echo !empty($_GET["basic_filter_value1"])?$_GET["basic_filter_value1"]:"" ?>',
		name2:'<?php echo !empty($_GET["basic_filter_name2"])?$_GET["basic_filter_name2"]:"" ?>',
		value2:'<?php echo !empty($_GET["basic_filter_value2"])?$_GET["basic_filter_value2"]:"" ?>',
		name3:'<?php echo !empty($_GET["basic_filter_name3"])?$_GET["basic_filter_name3"]:"" ?>',
		value3:'<?php echo !empty($_GET["basic_filter_value3"])?$_GET["basic_filter_value3"]:"" ?>',
		name4:'<?php echo !empty($_GET["basic_filter_name4"])?$_GET["basic_filter_name4"]:"" ?>',
		value4:'<?php echo !empty($_GET["basic_filter_value4"])?$_GET["basic_filter_value4"]:"" ?>'
	};

	var url = '<?php echo get_rcodeigniter_access_url('inventario/buscar/');?>'
	
	let queryFilter = '?'
	for (let i = 1; i < 5; i++)
		if (
			basicFilter['name' + i] != null && 
			basicFilter['name' + i] !== '' && 
			basicFilter['value' + i] != null && 
			basicFilter['value' + i] !== ''
		){
			if (queryFilter !== '?')
				queryFilter = queryFilter + '&'
			queryFilter = queryFilter + 'basic_filter_name' + i + '=' + basicFilter['name' + i] + '&basic_filter_value' + i + '=' + basicFilter['value' + i]
		}

	function getUrlVars()
	{
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}
	var oldQueryString = getUrlVars()
	url = url + '0' + queryFilter
	console.log(url)
	
	$.ajax({
			url,
			type: 'POST',
			success : function(html)
			{
				$('#form_container').html(html);
			}           
		});
</script>