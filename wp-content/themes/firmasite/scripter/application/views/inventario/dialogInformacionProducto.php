<div>
	<form id="informacionProducto" name="informacionProducto">
		<?php

			if(file_exists('images/inventario/middle_size/'.$producto->npc.'.jpg'))
				$backgoundImage=$producto->npc;
			else
				$backgoundImage=$this->config->item('no_image');
		?>
		<div  class="contenedor_imagen_middle <?php if( !empty($producto->promocion) ) {?> promocion_container<?php }?> toottip_class_dialog" onclick="mostrarOriginal('<?php echo $backgoundImage;?>');" title="Maximizar imagen">
			<div id="imagen_middle_<?php echo $producto->id_inventario;?>" class="imagen_middle">
			<?php
					$backgoundImageStyle= '<style>#imagen_middle_'.$producto->id_inventario.'{background-image: url("'.base_url().'images/inventario/middle_size/';
					$backgoundImageStyle.=$backgoundImage;
					$backgoundImageStyle.='.jpg'.'");}</style>';
					echo $backgoundImageStyle;
			?>
			</div>
		</div>
		<div class="contenedor_info toottip_class_dialog" <?php if(!empty($producto->promocion)){?> title="<?php echo title_promocion($producto->promocion);?> <?php }?>">
			<table class="table table-striped table-bordered table-hover table_expanded">
				<?php
					if( isset($producto->npc) &&  !empty($producto->npc))
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">CODIGO:</label>
					</td>
					<td class=""><label class="concepto_value"><?php echo $producto->npc; ?></label>
					</td>
				</tr>
				<?php
					}

					if( isset($producto->marca_refaccion) &&  !empty($producto->marca_refaccion) )
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">MARCA:</label>
					</td>
					<td class=""><label class="concepto_value"><?php echo $producto->marca_refaccion; ?></label>
					</td>
				</tr>
				<?php
					}

					if( isset($producto->marca_componente) &&  !empty($producto->marca_componente) )
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">TIPO:</label>
					</td>
					<td class=""><label class="concepto_value"><?php echo $producto->marca_componente; ?></label>
					</td>
				</tr>
				<?php
					}

					if( isset($producto->componente)  &&  !empty($producto->componente))
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">COMPONENTE:</label>
					</td>
					<td class=""><label class="concepto_value"><?php echo $producto->componente; ?></label>
					</td>
				</tr>
				<?php
					}
					 if( isset($producto->marca)  &&  !empty($producto->marca))
					{
				?>
					<tr >
						<td class=""><label class="concepto_field">VEHICULO:</label>
						</td>
						<td class=""><label class="concepto_value"><?php echo $producto->marca; ?></label>
						</td>
					</tr>
				<?php
					}
					if( isset($producto->origen)  &&  !empty($producto->origen))
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">ORIGEN:</label>
					</td>
					<td class=""><label class="concepto_value"><?php echo $producto->origen; ?></label>
					</td>
				</tr>
				<?php
					}
					if( isset($producto->precio)  &&  !empty($producto->precio))
					{
				?>
				<tr >
					<td class=""><label class="concepto_field">PRECIO:</label>
					</td>
					<td class="">$<label class="concepto_value precio_producto" id="producto_precio_dialog_<?php echo $producto->id_inventario;?>" ><?php echo round(floatval(preg_replace("/[^-0-9\.]/","",$producto->precio)),2); ?></label>
					</td>
				</tr>
				<?php
				}
					if( isset($producto->descripcion)  &&  !empty($producto->descripcion))
					{
				?>
				<tr >
					<td class="" style="vertical-align: middle;"><label class="concepto_field">DESCRIPCIÓN:</label>
					</td>
					<td style="vertical-align: middle;"><label class="concepto_value"><?php echo $producto->descripcion; ?></label>
					</td>
				</tr>
				<?php
					}
					if( isset($producto->referencias)  &&  $producto->referencias !='')
					{
				?>
				<tr >
					<td class=""  style="vertical-align: middle;"><label class="important_concepto_field">REFERENCIAS:</label>
					</td>
					<td class="" ><label class="important_concepto_field"><?php echo $producto->referencias; ?></label>
					</td>
				</tr>
				<?php
					}
				?>
			</table>
		</div>
	</form>
</div>
<br>
<script>
$(document).ready(function()
{
	$( '.toottip_class_dialog' ).tooltip(
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
	if(!empty($producto->promocion))
	{
	?>
		calcularPrecioDialog(JSON.parse('<?php echo json_encode($producto);?>'));
	<?php
	}
	?>
});



function calcularPrecioDialog(producto)
{
	if(producto!='')
	{
		switch(producto.promocion.nombre_tabla_promocion)
		{
			case 'ci_promocion_fija':
										$('#producto_precio_dialog_' + producto.id_inventario).text(producto.promocion.precio_oferta);
										break;
		}
	}
}
</script>