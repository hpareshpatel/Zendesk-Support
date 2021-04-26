<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);


if( isset($_POST['form_type']) && $_POST['form_type'] == 'DotCom')
{
	$url = 'https://<InstanceName>.zendesk.com/api/v2/requests.json';
	$header[] = "Content-type: application/json";
	
	$name = addslashes($_POST['sname']);
	$email = addslashes($_POST['semail']);
	$phone = addslashes($_POST['scontact']);
	$btype = addslashes($_POST['segment']);
	$desc = ( addslashes($_POST['sdesc']) );
	
	$data = '
	{
		"request": 
		{
			"tags":["Inquiry-Data"],
			"via": {"channel": "web"},
			"subject": "Contact for Free Consulting - DotCom", 
			"requester": {"name": "'.$name.'", "email": "'.$email.'"}, 
			"comment": {"html_body": "'.$desc.'" },
			"custom_fields": [{"id": 360002528575, "value": "'.$name.'"},
			  {"id": 360002528595, "value": "'.$phone.'"},
			  {"id": 360002614736, "value": "'.$btype.'"}]
		}
	}';

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	
	$data = curl_exec($ch);
	
	if (curl_errno($ch)) {
		$error_msg = curl_error($ch);
	}
	curl_close($ch);
	
	if (isset($error_msg)) {
		echo "<a href='".$_SERVER['REQUEST_URI']."'>Please try again.</a>";
	}
	else
	{
		echo "We received your request. A member of our support staff will respond as soon as possible";
	}
}
else
{
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdn.ckeditor.com/4.15.0/standard/ckeditor.js"></script>
<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h4 style="padding:20px 0px"> &nbsp; Send us your requirements  -  DotCom </h4>
        <form method="post" id="bulk_supplies_form" accept-charset="UTF-8" class="form-horizontal form-row-seperated contact-form" onSubmit="return validations();">
          <div class="error" style="padding:0px 0px 10px 15px;"></div>
          <input type="hidden" name="form_type" value="DotCom" />
          <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-5">
              <input name="sname" type="text" maxlength="100" placeholder="Full Name" value="" class="tReq tName form-control" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-5">
              <input name="semail" type="text" maxlength="400" placeholder="Email address" value="" class="tReq tEmail form-control" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-10"></label>
            <div class="col-md-5">
              <input name="scontact" type="text" maxlength="50" placeholder="Contact No " class="tReq tNum form-control" >
              <div><small>(eg.+91-98xxx98xxx)</small></div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-5">
              <select name="segment" class="form-control tType tReq">
                <option value="">Select your segment</option>
                <option value="Salary_Pension_Income">Salary / Pension Income</option>
                <option value="business_income">Business Income</option>
                <option value="capital_gains">Capital Gains</option>
                <option value="income_tax">Income Tax</option>
                <option value="gst_registration">GST Registration</option>
                <option value="gst_filing">GST Filing</option>
                <option value="bookkeeping">Bookkeeping</option>
                <option value="tds_plans">TDS Plans</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-7"> 
              <textarea name="sdesc" rows="3" class="form-control tMsg tReq" placeholder="Write a message..."></textarea>
              <div><small>Please enter the details of your request. A member of our support staff will respond as soon as possible.</small></div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-2"></label>
            <div class="col-md-5">
              <button type="submit" class="btn btn-primary">Send Request</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- End of navkar Zendesk Widget script -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> 
<script>
CKEDITOR.replace( 'sdesc' );
function validations()
{
	var isValid = 1;

	$('.error').html('');
	var vName = $('.tName').val();
	if ( $.trim(vName)!="" )
	{
		isValid = 1;
	}
	else
	{
		isValid = 0;
		$('.error').html("Please provide name");
		$('.tName').focus();
		return false;
	}
	
	var vEmail = $('.tEmail').val();
	var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	if (filter.test(vEmail))
		isValid = 1;
	else{
		isValid = 0;
		$('.error').html("Please provide valid email address");
		$('.tEmail').focus();
		return false;
	}
	
	var vPhone = $('.tNum').val();
	var phoneno = /^(\+91[\-\s]?)?[0]?(91)?[6789]\d{9}$/;
	if( vPhone.match(phoneno) )
	{
		isValid = 1;
	}
	else
	{
		isValid = 0;
		$('.error').html("Please provide valid contact number");
		$('.tNum').focus();
		return false;
	}
	
	var vType = $('.tType').val();
	if ( $.trim(vType)!="" )
	{
		isValid = 1;
	}
	else
	{
		isValid = 0;
		$('.error').html("Please choose your segment");
		$('.tType').focus();
		return false;
	}
		
	if (isValid == 0) return false;  
	else return;
}

</script> 
<?php
}
?>