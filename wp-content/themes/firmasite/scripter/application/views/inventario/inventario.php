<style>
	.shadow_marco
	{
		background-color: #FFFFFF;
		border: 3px solid #CCCCCC;
		border-radius: 5px;
		box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.1);
		width:100%;
		margin-bottom: 21px;
		margin-left:1%;
		margin-right:1%;
	}


	.shadow_marco:hover
	{
		/*border: 2px solid #3F47CC;*/
		box-shadow: 15px 15px 0 rgba(0, 0, 0, 0.1);
		margin-top: -20px;
		margin-left: -20px;
	}

	.tittle_marco
	{
		color:#FFFFFF;
		background-color:#FF4031;
		font-size:20px;
		text-transform:uppercase;
		text-align:center;
		border-bottom:3px solid #FF4031;
		border-top:3px solid #FF4031;
		margin-top:-11px;
		border-top-left-radius:5px;
		border-top-right-radius:5px;
	}
</style>
<div >
<form id="catFinder" name="catFinder">
<?php echo $dataUniverse; ?>
</form>
</div>
<br>
<br>
<script>
$(document).ready(function()
{
		$('#boton_buscar').click(function()
		{
			$.ajax(
			{
						url : '<?php echo site_url();?>/gridManajer/cat_injektion',
						type: 'POST',
						data: $('#catFinder').serialize(),
						success : function(html)
						{
								$('#form_container').html(html);
						}
			});
		});

});
</script>