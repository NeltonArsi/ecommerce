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
                <form method="post" action="/profile/address/create">
					<h3>Endereço</h3>
				        <div class="box-body">
				            <div class="form-group" class="form-row form-row-wide address-field validate-required">
								<label for="cep">Cep: <abbr title="required"></abbr></label>
								<input type="text" value="<?php echo htmlspecialchars( $address["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="cep" name="deszipcode" class="input-text" placeholder="00000-000">
								<input type="submit" value="Atualizar CEP" id="place_order" class="button alt" formaction="/profile/address/create" formmethod="get">
							</div>
							<div class="form-group">
								<label for="identifier">Identificador do Endereço:<abbr title="required"></abbr></label>
								<input type="text" value="<?php echo htmlspecialchars( $address["desidentifier"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="identifier" name="desidentifier" class="form-control" placeholder="Exemplo: Residência ou Escritório">
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="address">Endereço:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Logradouro" id="address" name="desaddress" class="form-control">
									</div>
								</div>
								<div class="col-sm-2">
									<div class="form-group">
										<label for="number">Número:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["desnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Número" id="number" name="desnumber" class="form-control">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label for="complement">Complemento:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Complemento (opcional)" id="complement" name="descomplement" class="form-control">
									</div>
								</div>
							</div>
		                    <div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label for="district">Bairro:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="district" name="desdistrict" class="form-control">
									</div>
									<div class="col-sm-6">
										<label for="city">Cidade:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="city" name="descity" class="form-control">
									</div>
								</div>	
							</div>
		                    <div class="form-group">
								<div class="row">
									<div class="col-sm-6">
										<label for="state">Estado:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="state" name="desstate" placeholder="Estado"class="form-control">
									</div>
									<div class="col-sm-6">
										<label for="country">País:<abbr title="required"></abbr></label>
										<input type="text" value="<?php echo htmlspecialchars( $address["descountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" id="country" name="descountry" placeholder="País" class="form-control">
									</div>
								</div>	
							</div>
						</div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>


