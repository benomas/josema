<style>
.ui-widget-header
{
	background:none;
	background-color:#3F47CC;
}
.negative{
	color:red;
	padding:20px;
	font-size: 20px;
	font-weight: bold;
}

.btn-default{
	background-color:#B83C11;
}
#B83C11
</style>
<div id="container">
	<?php if($userData->suspended){?>
		<div class="negative">
			Cliente suspendido
		</div>
	<?php }?>
	<form id="formularioPedido">
	<input type="hidden" name="numeroFilas" id="numeroFilas" value="<?php echo set_value('numeroFilas',$numeroFilas); ?>">
	<input type="hidden" name="productIds" id="productIds" value="<?php echo json_encode($productosValidosCarrito); ?>">
	<table class="table table-responsive table-hover" id="formSeccion1">
		<?php
		if($vendedor){
		?>
		<tr>
			<td >
				Pedido generado por:
			</td>
			<td colspan="2">
				<?php
					$nombre= $vendedor->nombre.' '.$vendedor->apellido_paterno.' '.$vendedor->apellido_materno;
					if(empty($nombre))
						$nombre=$vendedor->nick;
				echo $nombre;?>
			</td>
		</tr>
		<?php
		}
		?>
		<tr >
			<td>
				Nombre del Cliente:
			</td>
			<td colspan="2">
				<?php
					$nombre= $userData->nombre.' '.$userData->apellido_paterno.' '.$userData->apellido_materno;
					if(empty($nombre))
						$nombre=$userData->nick;
				echo $nombre;?>
			</td>
		</tr>
		<tr>
			<td >
				Recoger en sucursal:
			</td>
			<td colspan="2">
				 <input type="checkbox" id="tipo_envio" name="tipo_envio" value="sucursal">
			</td>
		</tr>
		<tr>
			<td >
				Fecha:
			</td>
			<td colspan="2">
				 <?php echo date("m-d-Y H:i:s");?>
			</td>
		</tr>
		<tr>
			<td>
				Tipo de Pedido
			</td>
			<td colspan="2">
				<?php
					echo form_dropdown(	"envio",
										array("1"=>"Normal", "2"=>"Urgente"),
										"1",
										" id='envio' class='test' "
										);
				?>
			</td>
		</tr>
	</table>
	<table class="table table-responsive table-hover" id="formSeccion2">
		<tr class="success" >
			<td >
				<b>CODIGO</b>
			</td>
			<td class="no_essencial">
				<b>DESCRIPCION</b>
			</td>
			<?php
				if($promociones_habilitadas && $vendedor){
			?>
			<td class="col-md-1">
				<b>PRECIO PROMOCIÓN</b>
			</td>
			<?php
				}
			?>
			<td class="col-md-1">
				<b>PRECIO</b>
			</td>
			<td class="col-md-1">
				<b>CANTIDAD</b>
			</td>
			<td>
				<b>SUBTOTAL</b>
			</td>
			<td class="col-md-2" style="text-align:center;">
				<b>ACCIÓN</b>
			</td>
		</tr>
		<script>
			var validCarProducts        = {}
			var jsonProductos           = <?php echo !empty($productos) ? json_encode($productos):'{}'?>;
		</script>
		<?php
				foreach($productos AS $producto)
				{
					if( isset($carrito) && isset($producto->id_inventario) && isset($carrito->{$producto->id_inventario}) && $carrito->{$producto->id_inventario} > 0){
				?>
					<script>
						validCarProducts['<?php echo $producto->id_inventario?>'] = '<?php echo $carrito->{$producto->id_inventario}?>'
					</script>
					<tr id="numeroFila<?php echo $producto->id_inventario;?>" <?php  if(!empty($producto->promocion)){?> class="promocion_container tooltip_class_accion" title="<?php echo title_promocion($producto->promocion);?>"<?php }?> >
						<td >
							<input class="form-control" id="npc<?php echo $producto->id_inventario;?>" name="NPC<?php echo $producto->id_inventario;?>" size="10" type="hidden" value="<?php echo $producto->npc;?>" >
							<?php echo $producto->npc;?>
						</td>
						<td class="no_essencial">
							<input class="form-control" id="descripcion<?php echo $producto->id_inventario;?>" name="Descripcion<?php echo $producto->id_inventario;?>" size="50" type="hidden"  value="<?php echo $producto->descripcion;?>">
							<?php echo $producto->descripcion;?>
						</td>
						<?php
							if($promociones_habilitadas && $vendedor){
						?>
						<td class="col-md-1">
						<?php
							if(isset($producto->precio_promocion) && $producto->precio_promocion > 0){
						?>
				 			<input 
							 	type="checkbox"
								id="precio_promocion_<?php echo $producto->id_inventario;?>"
								name="precio_promocion_<?php echo $producto->id_inventario;?>"
								value="precio_promocion" 
								onclick="cambiarPrecioPromocion('<?php echo $producto->id_inventario;?>')"/>
						<?php
							}
						?>
						</td>
						<?php
							}
						?>
						<td class="col-md-1">
							$<label class="precio_producto" id="producto_precio_<?php echo $producto->id_inventario;?>" ><?php echo round(floatval(preg_replace("/[^-0-9\.]/","",$producto->precio)),2); ?></label>
						</td>
						<td class="col-md-1">
							<div>
								<script>
									var jsonProducto<?php echo ($producto->id_inventario);?>=<?php echo json_encode(($producto));?>;
									if (window.jsonProductos == null)
										window.jsonProductos = [];
									window.jsonProductos['<?php echo ($producto->id_inventario);?>'] = jsonProducto<?php echo ($producto->id_inventario);?>;
								</script>
							</div>
							<input class="form-control numeric" id="cantidad<?php echo $producto->id_inventario;?>" name="Cantidad<?php echo $producto->id_inventario;?>" value="<?php echo !empty($carrito->{$producto->id_inventario}) ? $carrito->{$producto->id_inventario} : 0 ?>"
							size="6" type="text" onchange="updateSubtotal(this.value,jsonProducto<?php echo ($producto->id_inventario);?>,'<?php echo $producto->id_inventario;?>',true);"
												 onkeyup="updateSubtotal(this.value,jsonProducto<?php echo ($producto->id_inventario);?>,'<?php echo $producto->id_inventario;?>',true);"

							>
						</td>
						<td>
							<label class="moneda" >$</label><label class="subtotal" id="subtotal<?php echo $producto->id_inventario;?>">0</label>
						</td>
						<td class="success col-md-2" style="text-align:center;">
							<div class="bno-accions acciones">
								<!--<div class="icon- bno-button  tooltip_class_accion " title="Expandir" onclick="expandir('<?php echo $producto->id_inventario;?>');">
										&#xe682
								</div>-->
								<div class="icon- bno-button  tooltip_class_accion " title="Abrir en ventana emergente" onclick="abrir_dialogo('<?php echo $producto->id_inventario;?>');">
										&#xe75a
								</div>
								<div class="icon- bno-button  tooltip_class_accion " title="Remover producto del pedido" onclick='removerFila(/\<tr.*?id=\"numeroFila<?php echo $producto->id_inventario;?>\".*?\>([.|\s|\S]*?)tr\>/,"<?php echo $producto->id_inventario;?>");'>
										&#xe701
								</div>
							</div>
						</td>
					</tr>
				<?php
					}
						
				}

		?>
				<tr >
					<td colspan="2" ><b>GRAN SUB TOTAL:</b>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="gran_sub_total">0</label>
					</td>
					<td>
					</td>
				</tr>
				<!--
				<tr >
					<td colspan="2" ><b>DESCUENTO ADICIONAL:</b><span style="font-size:12px; padding-left:3px;">En la compra de $2500 pesos o más, recibe un descuento adicional de %2 y envió gratis</span style="">
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="descuento_adicional">0</label>
					</td>
					<td>
					</td>
				</tr>-->
				<tr >
					<td colspan="2"><b>IVA:</b>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="iva">0</label>
					</td>
					<td>
					</td>
				</tr>
				<tr >
					<td colspan="2"><b>Gastos de envio:</b>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="gastos_envio">0</label>
					</td>
					<td>
					</td>
				</tr>
				<tr >
					<td colspan="2"><b>GRAN TOTAL:</b>
					</td>
					<td>
					</td>
					<td>
					</td>
					<td>
						<label class="moneda" >$</label><label id="total">0</label>
					</td>
					<td>
					</td>
				</tr>
	</table>
	<table class="table" id="formSeccion4">
		<tr>
			<td>
				Observaciones
			</td>
			<td colspan="2">
				<textarea class="form-control" name="Observaciones" rows="3"></textarea>
			</td>
		</tr>
	</table>
	</form>
	<div>
		<div id="boton_limpiar" class="btn btn-default"  name="boton_limpiar">Borrar</div>
		<?php
		if(!$clientSelected){
		?>
			<div style="background-color:#F2DEDE; margin-top:10px; height:50px; padding:10px;">
				Pedido inhabilitado, Es obligatorio que selecciones un cliente
			</div>
		<?php
		}
		else{
		?>
			<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Enviar </div>
			<div id="mensaje_monto_minimo" style="background-color:#F2DEDE; margin-top:10px; height:50px; padding:10px;">
				El monto del pedido debe ser de almenos $2500 pesos
			</div>
		<?php
		}
		?>
	</div>
</div>
<div class="celda_marco">
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
        <h4 class="modal-title" id="myModalLabel" style="color:#3F47CC;">Vista completa</h4>
      </div>
      <div class="modal-body" id="modal-info-data">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#FF4031;">Cerrar</button>
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
        <h4 class="modal-title" id="myModalLabel" style="color:#3F47CC;">Imagen Maximizada</h4>
      </div>
      <div class="modal-body" id="modal-info-img">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" style="background-color:#FF4031;">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
var productosValidosCarrito = <?php echo json_encode($productosValidosCarrito)?>;
$(document).ready(function()
{
	$('.celda_marco').hide('fast');
	var limit=<?php echo $filasDefault;?>;
	var temp=$('#numeroFilas').val();
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
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
	var config = {};
	config.negative=false;
	config.decimal=false;

	$(".numeric").numeric(config);


	<?php
		if(!empty($productos))
		{
			foreach($productos AS $producto)
			{
				if(!empty($producto->promocion))
				{
	?>
				var jsonProducto = <?php echo json_encode($producto);?>;
				calcularPrecio(jsonProducto);
	<?php
				}
			}
		}
	?>

	$('[name="tipo_envio"]').on('change',function(){
		updateTotal();
	});
	let validCarProductKeys = Object.keys(validCarProducts)
	for (let i=0; i<validCarProductKeys.length; i++)
		updateSubtotal(
			validCarProducts[validCarProductKeys[i]],
			jsonProductos[validCarProductKeys[i]],
			validCarProductKeys[i]
		);
	$("#productIds").val(JSON.stringify(productosValidosCarrito))
});

var getValidProductsIndex = (idProduct) => {
	return productosValidosCarrito.indexOf(idProduct);
}

var updateCar = (idProduct,quantity=1) => {
	if (quantity == null || quantity==0){
		var index = getValidProductsIndex(idProduct);
		if (index > -1) {
		  	productosValidosCarrito.splice(index, 1);
			$("#productIds").val(JSON.stringify(productosValidosCarrito))
		}
	}
	else{
		var index = getValidProductsIndex(idProduct);
		if (index < 0){
			productosValidosCarrito.push(idProduct)
			$("#productIds").val(JSON.stringify(productosValidosCarrito))
		}
	}
	return new Promise((resolve,reject) => {
		$.ajax({
			url     : '<?php echo site_url();?>/carrito/add_carrito/' + idProduct + '/' + quantity,
			type    : 'POST',
			success : (html)=>{resolve(html)},
			error   : (error)=>{reject(error)}
		});
	});
}

function removerFila(idTr,idProduct)
{
	$("#formSeccion2").html( $("#formSeccion2").html().replace(idTr,''));
	updateCar(idProduct,0)
	updateTotal();
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
}

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
			$('#modal-info-data').html(html);
			$('#modal_laucher_data').trigger('click');
		}
	});
}

function updateTotal()
{
	num_elementos='<?php echo !empty($productos)? count($productos):0 ;?>';
	total=0;

	var total_antes_de_iva=0;
	var descuento_adicional=0;
	var iva=0;
	var tipo_envio = $('[name=tipo_envio]').prop('checked');
	//var gastos_envio = 180.00 * (!tipo_envio);
	var gastos_envio = 0;

	for(i=0;i<num_elementos;i++)
	{
		let idProduct =productosValidosCarrito[i]
		precio = Number($('#subtotal'+idProduct).text() );
		if(isNumber(precio))
		{
			total_antes_de_iva = total_antes_de_iva + precio;
		}
	}

	total_antes_de_iva = Math.round(total_antes_de_iva*100)/100;
	if(total_antes_de_iva>(2500/1.16))
	{
		//descuento_adicional	= Math.round(total_antes_de_iva*100*0.02)/100;
		total 					= total_antes_de_iva;
		gastos_envio=0;
	}
	else
		total 				=total_antes_de_iva;

	if(total_antes_de_iva===0)
		gastos_envio=0;

	iva 	= Math.round(total*100*0.16)/100;
	total   = total + iva + gastos_envio;

	var res 			= total_antes_de_iva.toString();
	total_antes_de_iva	= res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
	res 				= descuento_adicional.toString();
	descuento_adicional	= res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
	res 				= iva.toString();
	iva 				= res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
	res 				= total.toString();
	total 				= res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');

	$('#gran_sub_total').text(total_antes_de_iva);
	$('#descuento_adicional').text(descuento_adicional);
	$('#iva').text(iva);
	$('#gastos_envio').text(gastos_envio);

	$('#boton_enviar').hide();
	$('#mensaje_monto_minimo').show();

	if(total > 2500){
		$('#boton_enviar').show();
		$('#mensaje_monto_minimo').hide();
	}

	$('#total').text(total);
}

function updateSubtotal(cantidad,producto, elemento,save=false)
{
	var res;
	if(isPositiveInteger(cantidad))
	{
		$('#cantidad'+elemento).attr('value',cantidad);
		if(producto)
		{
			res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
			if(typeof producto.promocion!=='undefined')
			switch(producto.promocion.nombre_tabla_promocion)
			{
				case 'ci_promocion_fija':
											res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
											break;
				case 'ci_promocion_rango':
											min=producto.promocion.cantidad_min;
											max=producto.promocion.cantidad_max;
											cantidad_precio_especial=0;
											cantidad_precio_normal=0;

											if(min && max)
											{
												if(cantidad >= min)
												{
													if( cantidad <= max )
													{
														cantidad_precio_especial 	= cantidad;
														cantidad_precio_normal 		= 0;
													}
													else
													{
														cantidad_precio_especial	= 	max;
														cantidad_precio_normal 		=	cantidad - max;
													}
												}
												else
												{
													cantidad_precio_especial	= 	0;
													cantidad_precio_normal 		=	cantidad;
												}
											}

											if(min && !max)
											{
												if( cantidad >= min )
												{
													cantidad_precio_especial 	= cantidad;
													cantidad_precio_normal 		= 0;
												}
												else
												{
													cantidad_precio_especial	= 	0;
													cantidad_precio_normal 		=	cantidad;
												}

											}

											if(!min && max)
											{
												if( cantidad <= max )
												{
													cantidad_precio_especial 	= cantidad;
													cantidad_precio_normal 		= 0;
												}
												else
												{
													cantidad_precio_especial	= 	max;
													cantidad_precio_normal 		=	cantidad - max;
												}
											}
											if(!min && !max)
											{
												cantidad_precio_especial	= 	cantidad;
												cantidad_precio_normal 		=	0;
											}
											precio_normal = Math.round(producto.precio * 100)/100;
											precio_normal = precio_normal.toString();
											precio_normal = precio_normal.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');

											res_precio_normal = Number(cantidad_precio_normal * precio_normal);


											precio_especial = Math.round(producto.promocion.precio_oferta * 100)/100;
											precio_especial = precio_especial.toString();
											precio_especial = precio_especial.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');

											res_precio_especial = Number(cantidad_precio_especial * precio_especial);

											res = res_precio_normal + res_precio_especial;
											break;
				case 'ci_promocion_m_n':	Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
											break;
				default:res = Number(cantidad * Number($('#producto_precio_'+ producto.id_inventario ).text()));
							break;
			}
			res = res.toString();
			res=res.replace(/([0-9]*\.[0-9]{2})(.*?)$/,'$1');
			$('#subtotal'+elemento).text(Number(res));
			if(save)
				updateCar(elemento,cantidad)
		}
	}
	else
		$('#subtotal'+elemento).text(0);
	updateTotal();
}

function isPositiveInteger(s)
{
	return /^[0-9]+$/.test(s);
}

function isNumber(s)
{
	return /^[-+]?([0-9]*\.[0-9]+|[0-9]+)$/.test(s);
}

$('#boton_enviar').click(function()
{
	$("#numeroFilas").val(productosValidosCarrito.length)
	$('.form-control').prop('disabled', false);
	$.ajax(
	{
		url : '<?php echo site_url();?>/formSender/sendPedido',
		type: 'POST',
		data: $('#formularioPedido').serialize(),
		success : function(html)
		{
				$('#form_container').html(html);
		}
	});
});

$('#boton_limpiar').click(function()
{
	$.ajax({
				url : '<?php echo site_url();?>/formSender/loadForm',
				type: 'POST',
				success : function(html)
				{
					$('#form_container').html(html);
				}
			});
});

$('#aniadir').click(function()
{
	temp=$('#numeroFilas').val();
	temp++;
	$('#numeroFilas').val(temp);
	newLine='<tr id="numeroFila'+ temp + '"><td><input class="form-control" id=npc'+ temp + ' name="NPC'+ temp + '" size="10" type="text"></td>';
	newLine+='<td><input class="form-control" id=descripcion'+ temp + ' name="Descripcion'+ temp + '" size="50" type="text"></td>';
	newLine+='<td><input class="form-control" id=cantidad' + temp + ' name="Cantidad'+ temp + '" size="6" type="text"></td></tr>';
	$('#formSeccion2').append(newLine);
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
});
$('#quitar').click(function()
{
	temp=$('#numeroFilas').val();
	limit=<?php echo $filasDefault;?>;
	if(temp > limit)
	{
		$('#numeroFila' + temp).remove();
		temp--;
		$('#numeroFilas').val(temp);
	}
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
});

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
	$('#modal-info-img').html(htmlDiv);
	$('#modal_laucher_img').trigger('click');
}

function reducir(id_producto)
{
	$('.celda_marco').html('');
	$('.celda_marco').addClass('hidden_class');
	$('.celda_marco').removeClass('expanded_celda_marco');
	$('.celda_marco').hide('fast');
}

function cambiarPrecioPromocion (valor) {
	
	if (window.jsonProductos[valor] ==  null)
		return

	var se_aplica_promocion = $('[name=precio_promocion_' + valor + ']').prop('checked');
	
	if (se_aplica_promocion){
		if(window.jsonProductos[valor].originalPrice == null)
			window.jsonProductos[valor].originalPrice = rounded(window.jsonProductos[valor].precio);
		
		window.jsonProductos[valor].precio = rounded(window.jsonProductos[valor].precio_promocion);
	}else{
		if(window.jsonProductos[valor].originalPrice != null)
			window.jsonProductos[valor].precio = window.jsonProductos[valor].originalPrice
	}

	let cantidad  = $('#cantidad'+valor).val();
	$('#producto_precio_' + valor).text(window.jsonProductos[valor].precio);
	updateSubtotal(cantidad,window.jsonProductos[valor],valor,true)
}

function rounded (valor){
	return Math.round(valor * 100)/100
}
</script>