<div>
    <div class="tnk_shop alert alert-success">Thanks for shopping!</div>
</div>

<form action="php/RefundTransaction.php" method="POST" ng-show="verificaTransacao()">
    <input type="hidden" name="transID" value="{{transID}}">
    <button class="btn btn-block btn-sm btn-default" type="SUBMIT"> Refund </button>
</form>