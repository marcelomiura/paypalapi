<div>
    <p>
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at, laoreet mattis, massa.
    </p>
    <div class="row-fluid">
        <div class="span8">

            <!-- product info -->
            <table class="table table-bordered">

                <tr class="well">
                    <td class="tdRight" colspan="4" >
                        <b class="text-info">{{product.name}}</b>
                    </td>
                </tr>
                <tr>
                    <td class="tb_title">Description</td>
                    <td class="tb_title">Amount</td>
                    <td class="tb_title">Price</td>
                    <td class="tb_title">Actions</td>
                </tr>
                <tr>
                    <td class="tdRight">{{product.snippet}}</td>
                    <td class="tdCenter"><span>{{value}}</span></td>
                    <td class="tdCenter">R$ {{product.price}}</td>
                    <td>
                        <form action="php/SetExpressCheckout.php" method="POST">
                            <input type="hidden" name="amt" value="{{value}}">
                            <input type="hidden" name="name" value="{{product.name}}">
                            <input type="hidden" name="snipet" value="{{product.snippet}}">
                            <input type="hidden" name="price" value="{{product.price}}">
                            <button class="btn btn-block btn-sm btn-default" type="SUBMIT"> <img src="https://www.paypalobjects.com/webstatic/mktg/br/botao-checkout_horizontal_ap.png" border="0"> </button>
                        </form>
                        <button onclick="alert('Não possui função programada. Apenas teste.')" class="btn btn-block btn-sm btn-success" role="button"> pay </button>
                    </td>
                </tr>
                <tr>
                    <td class="total_price" colspan="4">TOTAL: R$ {{value * product.price}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="info_form">
        <div class="linha_form">
            <label>Name:</label>
            <div class="input_preencher">
                <span>{{user.nome}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>Adress:</label>
            <div class="input_preencher">
                <span>{{user.adress}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>Neighborhood:</label>
            <div class="input_preencher">
                <span>{{user.neighborhood}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>City:</label>
            <div class="input_preencher">
                <span>{{user.city}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>State:</label>
            <div class="input_preencher">
                <span>{{user.state}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>CEP:</label>
            <div class="input_preencher">
                <span>{{user.cep}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>E-mail:</label>
            <div class="input_preencher">
                <span>{{user.email}}</span>
            </div>
        </div>

        <div class="linha_form">
            <label>Phone:</label>
            <div class="input_preencher">
                <span>{{user.phone}}</span>
            </div>
        </div>
    </div>
    <div class="span4" style="margin-top: 20px;">
            <button class="btn btn-block" onclick="window.location.href=''"> back to store </button>
        </div>
</div>