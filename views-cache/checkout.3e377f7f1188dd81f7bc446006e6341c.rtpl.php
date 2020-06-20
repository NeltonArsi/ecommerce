<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="product-big-title-area">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-bit-title text-center">
					<h2>Pagamento</h2>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="single-product-area">
	<div class="zigzag-bottom"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="product-content-right">
					<form action="/checkout" class="checkout" method="post" name="checkout">
						<div id="customer_details" class="col2-set">
							<div class="row">
								<div class="col-md-7">

									<?php if( $error != '' ){ ?>
									<div class="alert alert-danger">
										<?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
									</div>
									<?php } ?>

									<div class="woocommerce-billing-fields">
										<h3>Endereços</h3>
                                        <?php $counter1=-1;  if( isset($address) && ( is_array($address) || $address instanceof Traversable ) && sizeof($address) ) foreach( $address as $key1 => $value1 ){ $counter1++; ?>
										<table class="shop_table" border="2">
											<tbody>
												<thead>
													<tr style="line-height: 10px" class="">
														<th class="" style="text-align:left;"><?php echo htmlspecialchars( $value1["desidentifier"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
														<th width="15"><input type="radio" <?php if( $cart["deszipcode"] === $value1["deszipcode"] ){ ?> checked="checked" <?php } ?>id="address-padrao" name="address-padrao" style="float:center; margin: 5px;"></th>
													</tr>
												</thead>
												<tr style="line-height: 3px" class="">
													<td colspan="2" class="product-name" style="text-align:left;">
														<span><?php echo htmlspecialchars( $value1["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["desnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php if( $value1["descomplement"] != '' ){ ?> - <?php echo htmlspecialchars( $value1["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php }else{ ?>- <?php } ?> <?php echo htmlspecialchars( $value1["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
													</td>
	                                            </tr>
												<tr style="line-height: 3px" class="">
													<td colspan="2" class="product-name" style="text-align:left; heigth: 1px;">
														<span><?php echo htmlspecialchars( $value1["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> / <?php echo htmlspecialchars( $value1["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $value1["descountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?> (CEP: <?php echo htmlspecialchars( $value1["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>)</span>
													</td>
	                                            </tr>
											</tbody>
										</table>
                                        <?php } ?>
									</div>
								</div>								
								<div class="col-md-5">

									<?php if( $error != '' ){ ?>
									<div class="alert alert-danger">
										<?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
									</div>
									<?php } ?>

									<div class="clear"></div>
									<h3>Detalhes do Pedido</h3>
									<div id="order_review" style="position: relative;">
										<table class="shop_table">
											<thead>
												<tr>
													<th class="product-name">Produto</th>
													<th class="product-total">Total</th>
												</tr>
											</thead>
											<tbody>
	                                            <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
												<tr class="cart_item">
													<td class="product-name">
														<?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <strong class="product-quantity">× <?php echo htmlspecialchars( $value1["nrqtd"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong> 
													</td>
													<td class="product-total">
														<span class="amount">R$<?php echo formatPrice($value1["vltotal"]); ?></span>
													</td>
	                                            </tr>
	                                            <?php } ?>
											</tbody>
											<tfoot>
												<tr class="cart-subtotal">
													<th>Subtotal</th>
													<td><span class="amount">R$<?php echo formatPrice($cart["vlsubtotal"]); ?></span>
													</td>
												</tr>
												<tr class="shipping">
													<th>Frete</th>
													<td>
														R$<?php echo formatPrice($cart["vlfreight"]); ?>
														<input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
													</td>
												</tr>
												<tr class="order-total">
													<th>Total do Pedido</th>
													<td><strong><span class="amount">R$<?php echo formatPrice($cart["vltotal"]); ?></span></strong> </td>
												</tr>
											</tfoot>
										</table>
										<h3>Forma de Pagamento</h3>
										<div class="col-md-4">
											<p id="billing_state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
												<input type="radio" checked="checked" id="boleto" name="payment-method" placeholder="País" value="1" style="float:left; margin: 30px;">
												<label class="" for="boleto"><img style="height:64px;" src="/res/site/img/logo-boleto_itau.png"></label>
											</p>
										</div>
										<div class="col-md-4">
											<p id="billing_state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
												<input type="radio" id="method-pagseguro" name="payment-method" placeholder="País" value="2" style="float:left; margin: 30px;">
												<label class="" for="method-pagseguro"><img style="height:64px;" src="/res/site/img/logo-pagseguro.png"></label>
											</p>
										</div>
										<div class="col-md-4">
											<p id="billing_state_field" class="form-row form-row-first address-field validate-state" data-o_class="form-row form-row-first address-field validate-state">
												<input type="radio" id="method-paypal" name="payment-method" placeholder="País" value="3" style="float:left; margin: 30px;">
												<label class="" for="method-paypal"><img style="height:64px;" src="/res/site/img/logo-paypal.png"></label>
											</p>
										</div>
										<div id="payment">
											<div class="form-row place-order">
												<input type="submit" data-value="Place order" value="Finalizar Compra" id="place_order" name="woocommerce_checkout_place_order" style="margin-top: 30px; "class="button alt">
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>