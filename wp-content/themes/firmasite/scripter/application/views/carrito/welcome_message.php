<style>

	.perimeter
	{
		display:inline-block;
		padding-left:2.5%;
		width:100%;
	}
	.shadow_marco
	{
		background-color: #FFFFFF;
		border: 4px double #FF4031;
		border-radius: 5px;
		box-shadow: 0 0 12px 6px #CCCCCC;
		width:100%;
		height:100%;
		margin-bottom: 21px;
		margin-left:1%;
		margin-right:1%;
	}
	
	.expanded
	{
		background-color: #FFFFFF;
		border: 4px double #FF4031;
		border-radius: 5px;
		box-shadow: 0 0 12px 6px #CCCCCC;
	}
	
	
	.last_selected
	{
		border: 4px double #145E8D;
		box-shadow: 0 0 12px 6px #662D4C;
	}
	
	
	.hidden_class
	{
		display:none;
	}
	
	.fila_marco
	{
		display:inline-block;
	}
	.celda_marco
	{
		display:inline-block;
		width:24%;
		max-width:300px;
		min-width:230px;
		height:21%;
		max-height:400px;
		min-height:270px;
		padding:2%;
	}
	.field_marco
	{
		display:inline-block;
		width:100%;
		color:#3F47CC;
		margin-left:10px;
	}
	
	.tittle_marco
	{
		color:#FFFFFF;
		background-color:#FF4031;
		font-size:20px;
		text-transform:uppercase;
		text-align:center;
		width:50%;
		border-bottom-right-radius:5px;
		display:inline-block;
		border-bottom:3px groove #FF4031;
		border-right:3px groove #FF4031;
		border-top:1px solid #CCCCCC;
		border-left:1px solid #CCCCCC;
	}
	
	.contenedor_imagen_marco
	{
		text-align:center;
		margin-top:3px;
		margin-bottom:3px;
	}
	
	
	.loading
	{
		text-align:center;
	}
	.imagen_marco
	{
		width:120px; 
		height:120px;
	}
	.concepto_field
	{
		font-weight: bold;
		color:#3F47CC;
	}
	.concepto_value
	{
		color:#FF4031;
	}
	
	.important_concepto_field
	{
		font-weight: bold;
		color:#878CE5;
	}
	
	.important_concepto_value
	{
		color:#045C4B;
	}
	
	
	.fields_area
	{
		
	}
	
	.acciones
	{
		width:96%;
		display:inline-block;
		border:1px solid #FF4031;
		margin:2%;
		border-radius:8px;
		background-color: #3F47CC;
	}
	
	.bloque_expandir_button
	{
		width:30%;
		height:40px;
		display:inline-block;
		margin:0 3px;
		border-radius:4px;
	}
	.bloque_expandir_button:hover
	{
		background-color: #FF4031;
	}
	.img_expandir
	{
		width:40px; 
		height:100%;
		max-width:100px;
		margin-left: 8px;
	}
	
	.bloque_expandir_aniadir_carrito
	{
		width:30%;
		height:40px;
		display:inline-block;
		margin:0 3px;
		border-radius:4px;
	}
	.bloque_expandir_aniadir_carrito:hover
	{
		background-color: #FF4031;
	}
	.img_expandir_aniadir_carrito
	{
		width:40px; 
		height:100%;
		max-width:100px;
		margin-left: 8px;
	}
	
	
	.bloque_contraer_button
	{
		width:30%;
		height:40px;
		display:inline-block;
		margin:0 3px;
		border-radius:4px;
	}
	.bloque_contraer_button:hover
	{
		background-color: #FF4031;
	}
	
	.img_contraer
	{
		width:40px; 
		height:100%;
		max-width:100px;
		margin-left: 40%;
	}
	
	
	.bloque_contraer_aniadir_carrito
	{
		width:30%;
		height:40px;
		display:inline-block;
		margin:0 3px;
		border-radius:4px;
	}
	.bloque_contraer_aniadir_carrito:hover
	{
		background-color: #FF4031;
	}
	
	.img_contraer_aniadir_carrito
	{
		width:40px; 
		height:100%;
		max-width:100px;
		margin-left: 40%;
	}
	
	.table 
	{
		margin-bottom: 0px; 
		font-size: 10px;
	}
	
	.table_expanded 
	{
		font-size: 13px;
	}
	.custom_td
	{
		padding: 4px !important;
	}
	
	.expanded_celda_marco 
	{
		display: inline-block;
		height: 30%;
		max-height: 600px;
		max-width: 1050px;
		min-height: 270px;
		min-width: 230px;
		padding: 5%;
		width: 100%;
	}
	
	.contenedor_imagen_original
	{
		text-align:center;
		background-color:#FFFFFF;
		border-radius: 10px;
		border: 1px solid #FF4031;
		margin:0 2%;
		width:96%;
	}
	
	.contenedor_info
	{
		background-color:#FFFFFF;
		margin:2%;
		width:96%;
	}
	
	.imagen_original
	{
		width:250px; 
		height:250px;
	}
	
</style>
<div class="perimeter">
<form id="catFinder" name="catFinder">
<?php 
		if(empty($inventantario_array))
			echo '0 resultados';
		else
		foreach($inventantario_array AS $row_array)
		{
			if(!empty($row_array))
			{
			?> 
			<div class="celda_marco" id="celda_marco_<?php echo $row_array['id_inventario'];?>" >
				<div class="shadow_marco" id="shadow_marco_<?php echo $row_array['id_inventario'];?>">
					
						<div class="tittle_marco" ><?php echo $row_array['npc']; ?>
						</div>
						
						<div id="contenedor_imagen_marco_<?php echo $row_array['id_inventario'];?>" class="contenedor_imagen_marco" >
						<?php if(file_exists('images/inventario/tiny_size/'.$row_array['npc'].'.jpg'))
						{
						?>
						<img class="imagen_marco" src="<?php echo base_url().'images/inventario/tiny_size/'.$row_array['npc'].'.jpg'; ?>"  >
						<?php 
						} 
						else
						{
						?>
						
						<img class="imagen_marco " src="<?php echo base_url().'images/inventario/tiny_size/'.$row_array['marca_refaccion'].'.jpg'; ?>" >
						<?php 
						}
						?>
						</div>
					<div class="contenedor_info">
						<table class="table table-striped table-bordered table-hover">
							<tr >
								<td class="custom_td"><label class="concepto_field">TIPO:</label>
								</td>
								<td class="custom_td"><label class="concepto_value"><?php echo $row_array['marca_componente']; ?></label>
								</td>
							</tr>
							<tr >
								<td class="custom_td"><label class="concepto_field">COMPONENTE:</label>
								</td>
								<td class="custom_td"><label class="concepto_value"><?php echo $row_array['componente']; ?></label>
								</td>
							</tr>
							<?php if(!empty($row_array['marca']))
							{
							?>
								<tr >
									<td class="custom_td"><label class="concepto_field">VEHICULO:</label>
									</td>
									<td class="custom_td"><label class="concepto_value"><?php echo $row_array['marca']; ?></label>
									</td>
								</tr>
							<?php 
							}
							?>
						</table>
					</div>
					<div class="acciones">
						<div class="bloque_expandir_button toottip_class" title="Expandir" onclick="expandir('<?php echo $row_array['id_inventario'];?>');">
							<img class="img_expandir" src="<?php echo base_url();?>images/template/expand.png" >
						</div>
						<div class="bloque_expandir_aniadir_carrito toottip_class" title="Añadir al carrito" onclick="expandir('<?php echo $row_array['id_inventario'];?>');">
							<img class="img_expandir_aniadir_carrito" src="<?php echo base_url();?>images/template/aniadir_carrito.png" >
						</div>
					</div>
				</div>
				<div class="expanded hidden_class" id="expanded_<?php echo $row_array['id_inventario'];?>">
					
				</div>
			</div>
			
			<?php
			}
		}
?>
</form>
</div>
<br>
<br>
<script>
$(document).ready(function()
{
		
		 $( '.toottip_class' ).tooltip(
		 {
			position: {
			my: "center bottom-20",
			at: "center top",
			using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
			}
		});	
		
});
function expandir(id_producto)
{	
	$('#shadow_marco_'+id_producto).addClass('hidden_class');
	$('#celda_marco_'+id_producto).addClass('expanded_celda_marco');
	$('#expanded_'+id_producto).html('<img style="width:120px; height:120px;" src="<?php echo base_url();?>images/loading.gif" >');
	$('#expanded_'+id_producto).removeClass('hidden_class');
	marcar_ultimo($('#expanded_'+id_producto));
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/informacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{		
				$('#expanded_'+id_producto).html(html);
				 $('html, body').animate(
				 {
					scrollTop: $('#expanded_'+id_producto).offset().top
				  }, 1000);
		}           
	});	
}

function marcar_ultimo(elemento)
{
	$('.last_selected').removeClass('last_selected');
	$(elemento).addClass('last_selected');
}
</script>