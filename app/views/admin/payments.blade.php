@extends('layouts.admin')
@section('content')
<?php
$total = 0;
if(!$payments->isEmpty())
{

    foreach($payments as $payment)
    {
        $total = round($total+$payment->amount, 2);
    }
}
?>
<h1>Payments (${{ $total }})</h1>
<hr>
@if(!$payments->isEmpty())
<div class="panel panel-default">
    <div class="panel-body">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Payment Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td><a href="/admin/users?q={{ $payment->user->username }}">{{ $payment->user->username }}</a></td>
                    <td>${{ round($payment->amount, 2) }}</td>
                    <td>{{ $payment->type }}</td>
                    <td>{{ Lop::when($payment->date) }}</td>
                    <td>{{ $payment->p_email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<center><?php echo $payments->appends(array_except(Input::all(), 'page'))->links(); ?></center>

@else
<div class="alert alert-info">
    No transactions.
</div>
@endif
@stop