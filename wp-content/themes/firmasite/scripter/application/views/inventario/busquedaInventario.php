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
<div class="row">
<?php
		if(empty($inventantario_array))
			echo '0 resultados';
		else
		foreach($inventantario_array AS $row_array)
		{
			if(!empty($row_array))
			{
			?>
			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3" id="celda_marco_<?php echo $row_array['id_inventario'];?>" >
				<div class="shadow_marco <?php if( !empty($row_array['promocion']) ) {?> promocion_container<?php }?>" id="shadow_marco_<?php echo $row_array['id_inventario'];?>">

					<div class="tittle_marco tooltip_class" title="<?php echo $row_array['npc']; ?>" data-original-title="<?php echo $row_array['npc']; ?>"><?php echo $row_array['npc']; ?>
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
								$backgoundImage=$this->config->item('no_image');
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
						<div class="table table-striped table-bordered table-hover" style="border:none; border-collapse:unset;">

							<div class="row" >
								<div class="col-xs-5 limita-texto tooltip_class" class="custom_td" data-original-title="VEHICULO" ><div style="display:inline;" class="concepto_field"><b>VEHICULO:</b></div>
								</div>
								<div class="col-xs-7 limita-texto tooltip_class" class="custom_td" data-original-title="<?php if(!empty($row_array['marca'])) echo $row_array['marca']; ?>" ><div style="display:inline;" class="concepto_value"><?php if(!empty($row_array['marca'])) echo $row_array['marca']; else echo 'N/A'; ?></div>
								</div>
							</div>
							<?php
							if(!empty($row_array['precio']))
							{
							?>
							<div class="row">
								<div
									class="col-xs-5 limita-texto tooltip_class"
									class="custom_td"
									data-original-title="Precio"
								>
									<div
										style="display:inline;"
										class="concepto_field"
									>
										<b>PRECIO:</b>
									</div>
								</div>
								<div
									class="col-xs-7 limita-texto tooltip_class"
									class="custom_td"
									data-original-title="<?php echo '$'.round(floatval(preg_replace("/[^-0-9\.]/","",$row_array['precio'])),2); ?>"
								>
									$
									<div
										style="display:inline;"
										class="concepto_value precio_producto"
										id="producto_precio_<?php $row_array['id_inventario'];?>"
									>
										<?php
											echo round(floatval(preg_replace("/[^-0-9\.]/","",$row_array['precio'])),2);
										?>
									</div>
								</div>
							</div>
							<?php
							}
							?>
							<div class="row" >
								<div class="col-xs-5 limita-texto tooltip_class" class="custom_td" data-original-title="descripcion" ><div style="display:inline;" class="concepto_field"><b>DESCRIPCIÓN:</b></div>
								</div>
								<br>
								<div class="col-xs-12 tooltip_class" class="custom_td" data-original-title="<?php if(!empty($row_array['descripcion'])) echo $row_array['descripcion']; ?>" ><div style="display:inline-block; height:65px;" class="concepto_value"><?php if(!empty($row_array['descripcion'])) echo $row_array['descripcion']; else echo 'N/A'; ?></div>
								</div>
							</div>
						</div>
					</div>
					<div class="bno-accions acciones">
						<!--<div class="icon- bno-button  tooltip_class" title="Expandir" onclick="expandir('<?php echo $row_array['id_inventario'];?>');">
						&#xe682
						</div>-->
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
</div>
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
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalData" id="modal_laucher_data" style="visibility:hidden;">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModalData" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:#DD4814;">Vista completa</h4>
      </div>
      <div class="modal-body" id="modal-info-data">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#AE3910;">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalImg" id="modal_laucher_img" style="visibility:hidden;">

</button>

<!-- Modal -->
<div class="modal fade" id="myModalImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="color:#DD4814;">Imagen Maximizada</h4>
      </div>
      <div class="modal-body" id="modal-info-img">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#AE3910;">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<br>
<br>
<?php //debugg($numero_elementos);?>
<script>

$(document).ready(function()
{
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
	$('#modal-info-img').html(htmlDiv);
	$('#modal_laucher_img').trigger('click');
}
function abrir_dialogo(id_producto)
{
	$.ajax(
	{
		url : '<?php echo site_url();?>/inventario/dialogInformacionProducto/' + id_producto + '/TRUE',
		type: 'POST',
		success : function(html)
		{

			$('#modal-info-data').html(html);
			$('#modal_laucher_data').trigger('click');
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
						alertify.success('Producto agregado al carrito');
					if(html=='already')
						alertify.error('Este producto ya estaba en el carrito');
					if(html=='error')
						alertify.error('Producto invalido');
			}
		});
	}
	<?php
		}
	?>
</script>