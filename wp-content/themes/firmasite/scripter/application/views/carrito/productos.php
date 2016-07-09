
	<?php
		if(!empty($productos))
		{
	?>
		<table class="table table-responsive table-hover">
					<tr class="success">
						<td colspan="2">
						</td>
						<td class="no_essencial">
						</td>
						<td class="no_essencial">
						</td>
						<td class="no_essencial">
						</td>
						<td style="text-align:center;" >
							<div class="bno-accions acciones">
								<div class="icon- bno-button tooltip_class_accion" onclick="vaciar_carrito();" title="Vaciar carrito" >
									&#xe6a8
								</div>
								<div class="icon- bno-button tooltip_class_accion" onclick="generar_pedido();"  title="Generar pedido">
									&#xe6b5
								</div>
							</div>
						</td>
					</tr>
					<tr class="success">
						<td><b>CODIGO:</b>
						</td>
						<td class="no_essencial"><b>TIPO:</b>
						</td>
						<td class="no_essencial"><b>COMPONENTE:</b>
						</td>
						<td class="no_essencial"><b>VEHICULO:</b>
						</td>
						<td ><b>PRECIO:</b>
						</td>
						<td class="col-md-2" style="text-align:center;"><b>ACCIONES:</b>
						</td>
					</tr>
			<?php
					foreach($productos AS $producto)
					{
				?>
					<tr <?php if(!empty($producto->promocion)){?> class="promocion_container tooltip_class_accion" title="<?php echo title_promocion($producto->promocion);?>"<?php }?>>
						<td><?php echo $producto->npc; ?>
						</td>
						<td class="no_essencial"><?php echo $producto->marca_componente; ?>
						</td>
						<td class="no_essencial"><?php echo $producto->componente; ?>
						</td>
						<td class="no_essencial"><?php echo $producto->marca; ?>
						</td>
						<td>$<label class="precio_producto" id="producto_precio_<?php echo $producto->id_inventario;?>" ><?php echo round($producto->precio,2); ?></label>
						</td>
						<td class="success" style="text-align:center;">
							<div class="bno-accions acciones">
								<div class="icon- bno-button  tooltip_class_accion " title="Expandir" onclick="expandir('<?php echo $producto->id_inventario;?>');">
										&#xe682
								</div>
								<div class="icon- bno-button  tooltip_class_accion " title="Abrir en ventana emergente" onclick="abrir_dialogo('<?php echo $producto->id_inventario;?>');">
										&#xe75a
								</div>
								<div class="icon- bno-button  tooltip_class_accion " title="Remover del carrito" onclick="remover_carrito('<?php echo $producto->id_inventario;?>');">
										&#xe701
								</div>
							</div>
						</td>
					</tr>
				<?php
					}
			?>
		</table>
		<div class="celda_marco">
		</div>
	<?php
	}
	else
	{
	?>
	<div class="contenedor_info"><label class="concepto_field" style="font-size:16px;">No hay productos en el carrito</label></div>
	<?php
	}
	?>
<div id="dialog_info">
</div>
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
	$('.celda_marco').hide('fast');
	$( '.tooltip_class_accion' ).tooltip(
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

	<?php
		if(!empty($productos))
		{
			foreach($productos AS $producto)
			{
				if(!empty($producto->promocion))
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
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{
				dialogo.html(html);
				dialogo.dialog( "open" );
		}
	});
}

function generar_pedido()
{
	window.location = '<?php echo ci_word_pres_url();?>?page_id=31&traerCarrito=TRUE';
}

function remover_carrito(id_producto)
{
	$.ajax(
	{
		url : '<?php echo site_url();?>/carrito/remove_carrito/' + id_producto,
		type: 'POST',
		success : function(html)
		{
				$('#form_container').html(html);
		}
	});
}

function vaciar_carrito()
{
	if(confirm("¿Seguro deceas vaciar el carrito?"))
	$.ajax(
	{
		url : '<?php echo site_url();?>/carrito/vaciar_carrito/',
		type: 'POST',
		success : function(html)
		{
				$('#form_container').html(html);
		}
	});
}

function expandir(id_producto)
{
	$('.celda_marco').addClass('expanded_celda_marco');
	$('.celda_marco').removeClass('hidden_class');
	$('.celda_marco').show('fast');
	$.ajax(
	{
		url : '<?php echo site_url();?>/carrito/informacionProducto/' + id_producto,
		type: 'POST',
		success : function(html)
		{
				$('.celda_marco').html(html);
				$('html, body').animate(
				{
					scrollTop: $('.celda_marco').offset().top
				}, 1000);
		}
	});
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

function reducir(id_producto)
{
	$('.celda_marco').html('');
	$('.celda_marco').addClass('hidden_class');
	$('.celda_marco').removeClass('expanded_celda_marco');
	$('.celda_marco').hide('fast');
}
</script>