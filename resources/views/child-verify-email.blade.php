<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sub Admin Child Data Verification</title>
</head>

<body style="background-color: #ffff; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 80%; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f7f8fa; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div
            style="text-align: center; padding: 20px; background-color: #17276d; color: white; border-radius: 10px 10px 0 0;">
            <h1>Sub Admin Information</h1>
        </div>
        <div style="padding: 20px;">
            <p style="color: #080808; margin-bottom: 10px;"><strong>Sub Admin Organisation Name:</strong> {{$sub_comname}}</p>
            <p style="color: #080808; margin-bottom: 10px;"><strong>Sub Admin Name:</strong> {{ $sub_fname }} {{ $sub_lname}}</p>
            <p style="color: #080808; margin-bottom: 10px;"><strong>Sub Admin Email:</strong>{{ $subadmin_email }}</p>
            <p style="color: #080808; margin-bottom: 10px;"><strong>Sub Admin Phone No:</strong> {{ $subadmin_phone }}</p>
            <div style=" padding: 5px; color: rgb(123, 99, 219);">
                <h1 >Sub Admin Child Information</h1>
            </div>
            <!-- <h1 style="color: #007bff; margin-bottom: 10px;">Sub Admin Child Information</h1> -->
            <p style="color: #080808;">Hello {{ $name }},</p>
            <p style="color: #070707;"><strong>Username:</strong> {{$email}}</p>
            <p style="color: #060606;"><strong>Password:</strong> {{$password}}</p>
            <p style="color: #060606;"><strong>Sub Admin Verify This Organisation.</strong></p>
        </div>
        <div
            style="text-align: center; padding: 20px; background-color: #17276d; color: white; border-radius: 0 0 10px 10px;">
            <p>Thank you,<br>[{{ $sub_fname }} {{ $sub_lname}}]<br>{{$sub_comname}}</p>
        </div>
    </div>
</body>

</html>