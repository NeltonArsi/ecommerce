<?php if(!class_exists('Rain\Tpl')){exit;}?>
<div class="product-big-title-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="product-bit-title text-center">
                    <h2>Minha Conta</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="single-product-area">
    <div class="zigzag-bottom"></div>
    <div class="container">
        <div class="row">                
            <div class="col-md-3">
                <?php require $this->checkTemplate("profile-menu");?>
            </div>
            <div class="col-md-9">
                <?php if( $success != '' ){ ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </div>
                <?php } ?>
                <?php if( $error != '' ){ ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </div>
                <?php } ?>                
                <form>
					<div class="woocommerce-billing-fields">
						<h3>Endereços</h3>
                        <?php $counter1=-1;  if( isset($address) && ( is_array($address) || $address instanceof Traversable ) && sizeof($address) ) foreach( $address as $key1 => $value1 ){ $counter1++; ?>
						<table class="shop_table" border="2">
							<tbody>
								<thead>
									<tr style="line-height: 5px" class="">
										<th class="" style="text-align:left;"><?php echo htmlspecialchars( $value1["desidentifier"], ENT_COMPAT, 'UTF-8', FALSE ); ?>  -  (CEP: <?php echo htmlspecialchars( $value1["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>)</th>
										<th class="product-name" width="15"><a href="/profile/address/<?php echo htmlspecialchars( $value1["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Editar</a></th>
									</tr>
								</thead>
								<tr style="line-height: 3px" class="">
									<td colspan="2" class="" style="text-align:left;">
										<span><?php echo htmlspecialchars( $value1["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["desnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php if( $value1["descomplement"] != '' ){ ?> - <?php echo htmlspecialchars( $value1["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php }else{ ?>- <?php } ?> <?php echo htmlspecialchars( $value1["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></
									</td>
                                </tr>
								<tr style="line-height: 3px" class="">
									<td colspan="2" class="" style="text-align:left; heigth: 1px;">
										<span><?php echo htmlspecialchars( $value1["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> / <?php echo htmlspecialchars( $value1["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - <?php echo htmlspecialchars( $value1["descountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
									</td>
                                </tr>
							</tbody>
						</table>
                        <?php } ?>
						<form action="/profile/address/update" class="address" method="get" name="address">
							<div id="address">
								<div class="form-row place-order">
									<!--input type="submit" value="Alterar Endereço" style="margin-top: 30px; "class="button alt"-->
								</div>
								<div class="clear"></div>
							</div>     
						</form>                                
						<form action="/profile/address/create" class="new-address" method="get" name="new-address">
							<div id="new-address">
								<div class="form-row place-order">
									<input type="submit" value="Novo Endereço" style="margin-top: 30px; "class="button alt">
								</div>
								<div class="clear"></div>
							</div>     
						</form>                                   
					</div>
                </form>
            </div>
        </div>
    </div>
</div>


