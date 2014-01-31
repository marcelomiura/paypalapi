<div>
    <p>
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nam cursus. Morbi ut mi. Nullam enim leo, egestas id, condimentum at, laoreet mattis, massa.
Sed eleifend nonummy diam. Praesent mauris ante, elementum et, bibendum at, posuere sit amet, nibh. Duis tincidunt lectus quis dui viverra vestibulum.
Suspendisse vulputate aliquam dui. Nulla elementum dui ut augue. Aliquam vehicula mi at mauris. Maecenas placerat, nisl at consequat rhoncus, sem nunc
gravida justo, quis eleifend arcu velit quis lacus. Morbi magna magna, tincidunt a, mattis non, imperdiet vitae, tellus. Sed odio est, auctor ac,
sollicitudin in, consequat vitae, orci. Fusce id felis. Vivamus sollicitudin metus eget eros.
    </p>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span8">

                <!-- product info -->
                <table class="table table-bordered">

                    <tr class="well">
                        <td class="tdRight" colspan="4" >
                            <b class="text-info">{{plan.name}}</b>
                        </td>
                    </tr>
                    <tr>
                        <td class="tb_title">Description</td>
                        <td class="tb_title">Amount</td>
                        <td class="tb_title">Price</td>
                        <td class="tb_title">Actions</td>
                    </tr>
                    <tr>
                        <td class="tdRight">{{plan.snippet}}</td>
                        <td class="tdCenter">{{value}}</td>
                        <td class="tdCenter">R$ {{plan.price}}</td>
                        <td>
                            <form action="php/SetExpressCheckout.php" method="POST">
                                <input type="hidden" name="plan" value="flag">
                                <input type="hidden" name="amt" value="{{value}}">
                                <input type="hidden" name="name" value="{{plan.name}}">
                                <input type="hidden" name="snipet" value="{{plan.snippet}}">
                                <input type="hidden" name="price" value="{{plan.price}}">
                                <button class="btn btn-block btn-sm btn-default" type="SUBMIT"> <img src="https://www.paypalobjects.com/webstatic/mktg/br/botao-checkout_horizontal_ap.png" border="0"> </button>
                            </form>
                            <a href="#/information" class="btn btn-block btn-sm btn-primary" role="button"> continue </a>
                            <button class="btn btn-block btn-sm btn-danger" onclick="alert('Não possui função programada. Apenas teste.')"> remove from cart </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="total_price" colspan="4">TOTAL: R$ {{value * plan.price}}</td>
                    </tr>
                </table>
            </div>

            <div class="span4">
                <button class="btn btn-block" onclick="window.location.href=''"> back to store </button>
            </div>
        </div>
    </div>
</div>