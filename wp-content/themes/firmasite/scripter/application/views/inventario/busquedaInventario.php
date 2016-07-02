<style>
.ui-widget-header 
{
	background:none;
	background-color:#DD4814;
}
</style>

<div class="perimeter">
<div>total de resultados:<?php echo $numero_elementos;?></div>
<?php
	$j=1;
	for($i=0;$i<$numero_elementos;$i+=$limite)
	{
	?>
	<div class="numero_pagina <? if($j==$posicion_inicial+1) echo 'current_numero_pagina';?>" <?php if($j!=$posicion_inicial+1){?> onclick="paginar('<?php echo $j-1;?>');"<?php }?> ><label class="numero_pagina_texto"><?php echo $j++;?></label></div>
	<?php
	}
?>
<br>
<br>
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
				<div class="shadow_marco <?php if( !empty($row_array['promocion']) ) {?> promocion_container<?php }?>" id="shadow_marco_<?php echo $row_array['id_inventario'];?>">
					
						<div class="tittle_marco" ><?php echo $row_array['npc']; ?>
						</div>
						<?php 
							if( !empty($row_array['promocion']) ) 
							{	
						?>
							<div class="promocion_div tooltip_class" title="<?php echo title_promocion($row_array['promocion']);?>">
								<div class="promocion_button promocion_class">
								</div>
							</div>
						<?php 
							}
						?>
						<?php
						
							if(file_exists('images/inventario/tiny_size/'.$row_array['npc'].'.jpg'))
								$backgoundImage=$row_array['npc'];
							else
								$backgoundImage=$row_array['marca_refaccion'];
						?>
						<div id="contenedor_imagen_marco_<?php echo $row_array['id_inventario'];?>" class="contenedor_imagen_marco tooltip_class" title="Maximizar imagen" onclick="mostrarOriginal('<?php echo $backgoundImage;?>');">
						
							<div id="imagen_marco_<?php echo $row_array['id_inventario'];?>" class="imagen_marco">
							<?php	
									$backgoundImageStyle= '<style>#imagen_marco_'.$row_array['id_inventario'].'{background-image: url("'.base_url().'images/inventario/tiny_size/';
									$backgoundImageStyle.=$backgoundImage;
									$backgoundImageStyle.='.jpg'.'");}</style>';
									echo $backgoundImageStyle;
							?>
							</div>
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
							
							<?php if(!empty($row_array['precio']))
							{
							?>
							<tr >
								<td class="custom_td"><label class="concepto_field">Precio:</label>
								</td>
								<td class="custom_td">$<label class="concepto_value precio_producto" id="producto_precio_<?php echo $row_array['id_inventario'];?>" ><?php echo round($row_array['precio'],2); ?></label>
								</td>
							</tr>
							<?php 
							}
							?>
						</table>
					</div>
					<div class="bno-accions acciones">
						<div class="icon- bno-button  tooltip_class" title="Expandir" onclick="expandir('<?php echo $row_array['id_inventario'];?>');">
						&#xe682
						</div>
						<div class="icon- bno-button  tooltip_class" id="abrir_dialog" title="Abrir en ventana emergente" onclick="abrir_dialogo('<?php echo $row_array['id_inventario'];?>');">
						&#xe75a
						</div>
						<?php 
							if( $this->centinela->is_logged_in())
							{
						?>
							<div class="icon- bno-button  tooltip_class" title="Añadir al carrito" onclick="agregar_carrito('<?php echo $row_array['id_inventario'];?>');">
							&#xe702
							</div>
						<?php
							if($this->centinela->get('rol')==1){
						?>
							<div class="icon- bno-button  tooltip_class" title="Modificar producto" onclick="agregar_carrito('<?php echo $row_array['id_inventario'];?>');">
							&#xe605
							</div>
							<div class="icon- bno-button  tooltip_class" title="Agregar promocion" onclick="agregar_carrito('<?php echo $row_array['id_inventario'];?>');">
							&#xe630
							</div>
						<?php
							}
						?>
						<?php
							}
						?>
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

<div>total de resultados:<?php echo $numero_elementos;?></div>
<?php
	$j=1;
	for($i=0;$i<$numero_elementos;$i+=$limite)
	{
	?>
	<div class="numero_pagina <? if($j==$posicion_inicial+1) echo 'current_numero_pagina';?>" <?php if($j!=$posicion_inicial+1){?> onclick="paginar('<?php echo $j-1;?>');"<?php }?> ><label class="numero_pagina_texto"><?php echo $j++;?></label></div>
	<?php
	}
?>
</div>
<div id="dialog_info">
</div>
<br>
<br>
<?php //debugg($numero_elementos);?>
<script>

$(document).ready(function()
{
	dialogo=$('#dialog_info');
	dialogo.dialog(
	{
		resizable: false,
		width: 800,
		modal: true,
		autoOpen: false,
		show: "blind",
		hide: "explode",
		title:"Vista completa",
		buttons: 
		{
			"Cerrar": function() 
			{
				$( this ).dialog( "close" );
			}
		}
	});
		 $( '.tooltip_class' ).tooltip(
		 {
			tooltipClass: "custom-tooltip-styling",
			position: 
			{
				my: "center bottom-20",
				at: "center top",
				using: function( position, feedback ) 
				{
					$( this ).css( position );
					$( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
				}
			}
		});	
		
	<?php 
		if(!empty($inventantario_array))
		{
			foreach($inventantario_array AS $producto)
			{	
				if(!empty($producto['promocion']))
				{
	?>	
				calcularPrecio(JSON.parse('<?php echo json_encode($producto);?>'));
	<?php 		
				}
			}
		}
	?>		
		
});

function calcularPrecio(producto)
{	
	if(producto!='')
	{
		switch(producto.promocion.nombre_tabla_promocion)
		{
			case 'ci_promocion_fija':
										$('#producto_precio_' + producto.id_inventario).text(producto.promocion.precio_oferta);
										break;
		}
	}
}

function abrir_dialogo(id_producto)
{	
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto + '/TRUE',
		type: 'POST',
		success : function(html)
		{		
				dialogo.dialog('option', 'title', 'My New title');
				dialogo.html(html);
				dialogo.dialog( "open" );
		}           
	});	
}

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


function reducir(id_producto)
{
	$('#shadow_marco_'+id_producto).removeClass('hidden_class');
	marcar_ultimo($('#shadow_marco_'+id_producto));
	$('#celda_marco_'+id_producto).removeClass('expanded_celda_marco');
	$('#expanded_'+id_producto).addClass('hidden_class');
	$('#expanded_'+id_producto).html('');
	$('html, body').animate(
	{
		scrollTop: $('#shadow_marco_'+id_producto).offset().top
	}, 1000);	
}	

function mostrarOriginal(npc)
{
	var rutaImg='<?php echo base_url().'images/inventario/original_size/' ?>';
	var complementImg='.jpg';
	var htmlDiv='<div class="contenedor_imagen_original"><div id="imagen_original_id" class="imagen_original">';
	htmlDiv+='<style>#imagen_original_id{background-image:url("' + rutaImg + npc + complementImg + '");}</style>';
	htmlDiv+='</div></div>';
	dialogo.dialog('option', 'title', 'Imagen Maximizada ');
	dialogo.html(htmlDiv);
	dialogo.dialog( "open" );
}	
function abrir_dialogo(id_producto)
{	
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto + '/TRUE',
		type: 'POST',
		success : function(html)
		{		
				dialogo.html(html);
				dialogo.dialog( "open" );
		}           
	});	
}

function paginar(numero_pagina)
{
	$('#form_container').html('<div style="width:100%; text-align:center;"><label > Cargando...</label><br><br><br><img src="<?php echo base_url();?>images/loading.gif"></div>');
	$.ajax({
			url : '<?php echo site_url().'/inventario/buscar/';?>' + numero_pagina ,
			type: 'POST',
			success : function(html)
			{
				$('#form_container').html(html);
			}           
		});
}

function marcar_ultimo(elemento)
{
	$('.last_selected').removeClass('last_selected');
	$(elemento).addClass('last_selected');
}

	<?php 
		if( $this->centinela->is_logged_in() ) 
		{
	?>
	function agregar_carrito(id_producto)
	{
		$.ajax(
		{
			url : '<?php echo site_url();?>/carrito/add_carrito/' + id_producto,
			type: 'POST',
			success : function(html)
			{		
					if(html=='correcto')
						alert('Producto agregado al carrito');
					if(html=='already')
						alert('Este producto ya estaba en el carrito');
					if(html=='error')
						alert('Producto invalido');
			}           
		});	
	}
	<?php 
		}
	?>
</script>