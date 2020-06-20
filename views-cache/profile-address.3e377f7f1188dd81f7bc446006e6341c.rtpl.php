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
                <form method="post" action="/profile/address">
					<h3>Endereço</h3>
						<p id="billing_address_1_field" class="form-group">
							<label class="" for="billing_cep_1">Cep <abbr title="required" class="required">*</abbr>
							</label>
							<input type="text" value="<?php echo htmlspecialchars( $address["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="00000-000" id="billing_cep_1" name="zipcode" class="input-text">
							<input type="submit" value="Atualizar CEP" id="place_order" class="button alt" formaction="/profile/address" formmethod="get">
						</p>
						<p id="billing_address_1_field" class="form-group">
							<label class="" for="billing_identifier">Identificador do Endereço <abbr title="required" class="required"></abbr>
							</label>
							<input type="text" value="<?php echo htmlspecialchars( $address["desidentifier"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Exemplo: Residência ou Escritório" id="billing_identifier" name="identifier" class="form-control">
						</p>
						<div class="row">
							<div class="col-sm-9">
								<p id="billing_address_1_field" class="form-group">
									<label class="" for="billing_address_1">Endereço <abbr title="required" class="required">*</abbr>
									</label>
									<input type="text" value="<?php echo htmlspecialchars( $address["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Logradouro, número e bairro" id="billing_address_1" name="desaddress" class="form-control">
								</p>
							</div>
							<div class="col-sm-3">
								<p id="billing_number_1_field" class="form-group">
									<label class="" for="billing_number_1">Número <abbr title="required" class="required">*</abbr>
									</label>
									<input type="text" value="<?php echo htmlspecialchars( $address["desnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Número" id="billing_address_1" name="desnumber" class="form-control">
								</p>
							</div>
						</div>
						<p id="billing_address_2_field" class="form-group">
							<input type="text" value="<?php echo htmlspecialchars( $address["descomplement"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Complemento (opcional)" id="billing_address_2" name="descomplement" class="form-control">
	                    </p>
	                    <p id="billing_district_field" class="form-group" data-o_class="form-row form-row-wide address-field validate-required">
							<label class="" for="billing_district">Bairro <abbr title="required" class="required">*</abbr>
							</label>
							<input type="text" value="<?php echo htmlspecialchars( $address["desdistrict"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="billing_district" name="desdistrict" class="form-control">
						</p>
						<p id="billing_city_field" class="form-group" data-o_class="form-row form-row-wide address-field validate-required">
							<label class="" for="billing_city">Cidade <abbr title="required" class="required">*</abbr>
							</label>
							<input type="text" value="<?php echo htmlspecialchars( $address["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" placeholder="Cidade" id="billing_city" name="descity" class="form-control">
						</p>
						<p id="billing_state_field" class="form-group" data-o_class="form-row form-row-first address-field validate-state">
							<label class="" for="billing_state">Estado</label>
							<input type="text" id="billing_state" name="desstate" placeholder="Estado" value="<?php echo htmlspecialchars( $address["desstate"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form-control">
						</p>
						<p id="billing_state_field" class="form-group" data-o_class="form-row form-row-first address-field validate-state">
							<label class="" for="billing_state">País</label>
							<input type="text" id="billing_state" name="descountry" placeholder="País" value="<?php echo htmlspecialchars( $address["descountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="form-control">
						</p>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>


