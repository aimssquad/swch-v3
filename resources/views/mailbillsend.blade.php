@if($billing_type=='Organisation')
<p> <b>Dear Business Partner</b>,</p>
@elseif($billing_type=='Candidate')
<p> <b>Dear {{ucfirst($com_name)}}</b>,</p>

@endif
<p>Please find the invoice attached.</p>


  @if($billing_type=='Organisation')
  @if($bill_for=='first invoice recruitment service')
  @elseif($bill_for=='second invoice visa service')
  @else
 <p><b>Note-1:</b> Should you wish to make the payment through Bank Transfer please use the Bank details in the given attachment.</p>
  <p><b>Note-2:</b> should you wish to make the payment through your card details only please login to your organisation profile using following details. </p>
  <p><b>Login ID:</b>{{ $users->email }} </p>
  <p><b>Password:</b>{{ $users->password }}</p>
  <p>Please follow the path (Login>Billing)</p>
  @endif
@elseif($billing_type=='Candidate')


@endif
  <p>  Best Regards</p>

  <p> skilledworkerscloud Limited</p>
