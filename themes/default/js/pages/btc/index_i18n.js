function getQr(data){
  console.log(data);
  $.post(site_url+'btc/generate_qr',
  {
    csrf_token: csrf_token,
    value: data
  }, function(qrcode){
    $('#qrcode').html('<img src="'+qrcode.img_url+'" alt="qrcode" title="Scan QR Code to proceed with the payment." />');
    $('#qr-address').append(data);
  });
}

function checkRedeem(data)
{
  $.post(site_url+'btc/check_redeemcode',
    {
      csrf_token: csrf_token,
      redeem_code: data.redeem_code
    },
      function(status)
      {
        console.log(status);

        var obj = JSON.parse(status);
        var amount_satoshi = $('#amount').attr('data-amount-satoshi');

        $('#redeemcode').val(data.redeem_code);
        $('#redeemaddress').val(data.address);
        $('#redeeminvoice').val(data.invoice);

        console.log('checkRedeem');
        console.log(obj.pending_balance);

        if(obj.pending_balance == 0)
        {
          setTimeout(checkRedeem(data), 10000);
        }
        else if (obj.pending_balance < amount_satoshi)
        {
          $('#paystatus').empty();
          $('#paystatus').append('Status: Incorrect payment amount.');
          setTimeout(checkRedeem(data), 10000);
        }
        else if(obj.pending_balance >= amount_satoshi)
        {
          $('#paystatus').empty();
          $('#paystatus').append('Status: Transaction confirmed! <i class="fa fa-check-circle"></i>');
          $('#paysub').removeAttr('disabled');
        }
      }
  );
}

function checkBalance(data)
{
  $.post(site_url+'btc/check_redeemcode',
  {
    csrf_token: csrf_token,
    redeem_code: data.redeem_code
  },
    function(status)
    {
      console.log('checkBalance');

      $('#redeemcode').val(data.redeem_code);
      $('#redeemaddress').val(data.address);
      $('#redeeminvoice').val(data.invoice);

      var obj = JSON.parse(status);
      var amount_satoshi = $('#amount').attr('data-amount-satoshi');

      console.log(obj.balance);

      if(obj.balance >= amount_satoshi)
      {
        $('#paystatus').empty();
        $('#paystatus').append('Status: Transfer confirmed! <i class="fa fa-check-circle"></i>');
        $('#paysub').removeAttr('disabled');
      }
      else
      {
        $('#paystatus').empty();
        $('#paystatus').append('Status: Transfer not yet confirmed!');
      }
    }
  );
}

function getFees(param)
{
  $.get(site_url+'btc/calculate_fees/'+param.input+'/'+param.output+'/'+param.priority, function(data){
    console.log(data);
    $('#tx_fee').empty();
    $('#tx_fee').append('Fee: '+data.fee+' BTC');

    var amount        = $('#amount').attr('data-amount');

    var total_amount = 0;

    total_amount += parseFloat(amount);
    total_amount += parseFloat(data.fee);

    $('#pay_total').empty();
    $('#pay_total').append('Total: '+total_amount.toFixed(8)+' BTC');
    $('#grand_total').val(total_amount.toFixed(8));
    $('#redeem_fee').val(data.fee);
  });
}

function processRedeemcode(data)
{
  getQr(data.address);

  if(uri_seg_2 == 'process')
  {
    checkBalance(data);
  }
  else
  {
    checkRedeem(data);
    getFees(
      {
        input: 1,
        output: 1,
        priority: 'medium',
      }
    );
  }

  $('div.loader').hide();
}

$(document).ready(function(){

  if(data == null)
  {
    $.get(site_url+'btc/create_redeemcode', function(result){
      console.log(result);
      processRedeemcode(result);
    });
  }
  else
  {
    processRedeemcode(data);
  }
});

$('#add_credits').click(function(e){
  e.preventDefault();

  var current_charge = $('input[name="txn_amount"]').val();
  var min_charge     = 0.00020000;

  if(current_charge < min_charge)
  {
    var charge = min_charge;
  }
  else
  {
    var charge = current_charge;
  }

  $('input[name="amount"]').val(charge);

  // delay by 3 seconds
  setTimeout(function(){
      // make the modal appear
      $('#add_credits_modal').modal({
        fadeDuration: 200,
        fadeDelay: 0.50
      });
  }, 3000);
});
