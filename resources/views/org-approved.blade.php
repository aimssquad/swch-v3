<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sub Admin Child Data Verification</title>
</head>

<body style="background-color: #ffff; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 80%; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #d4e2f7; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="text-align: center; padding: 20px; background-color: #17276d; color: white; border-radius: 10px 10px 0 0;">
            <h2>Welcome To Our <strong>{{$sub_comname}}</strong> Organisation</h2> 
            <h4>Here Are Your Credentials to Join Our Organization</h4>
        </div>
            <p style="color: #080808;"><strong>Hello {{ $name }},</strong></p>
            <p style="color: #080808;">Thank you for registering with SkilledWorkersCloud. As your next step, please create your organization profile. You can do this by clicking on the link below.</p>
            <p style="color: #440af3;"><strong><a href="https://skilledworkerscloud.co.uk/hrms/">https://skilledworkerscloud.co.uk/hrms/</a></p>
            <p style="color: #070707;"><strong>Username:</strong> {{$email}}</p>
            <p style="color: #060606;"><strong>Password:</strong> {{$password}}</p>
            <p style="color: #060606;">Here are some useful tips to help you complete your organization profile effortlessly.</p>
            <ul style="padding-left: 18px;">
                <li style="padding-bottom:7px;">To get started, select the 'Organization Profile' tab.</li>
                <li style="padding-bottom:7px;">Next, click on the 'Profile Status' tab. Fill out all the necessary fields in this section. Provide essential business information, including your trading name, company registration number, business address, trading hours (opening and closing times), and the start date of your business operations.</li>

                <li style="padding-bottom:7px;">Please provide details of an authorizing officer. This individual will be the primary contact for the Home Office regarding your sponsor license application. The authorizing officer could be your company's director or another knowledgeable employee. We recommend nominating someone with excellent communication skills to ensure a smooth application process. </li>
                <li style="padding-bottom:7px;">You're also required to provide basic information (e.g., name, job title, etc.) for all employees at your business. This information is necessary to create a hierarchy chart, a mandatory requirement from the Home Office.</li>
                <li style="padding-bottom:7px;">Finally, you'll need to upload specific documents. You'll see a list of document names with an 'upload document' field next to each. Please upload all required documents as instructed. If you need to add more documents, use the 'Add' button at the bottom of the documents section.</li>

                <li style="padding-bottom:7px;">Please note that, there is one document field with the title 'submission sheet'. Ignore this field for now. You have not received the document yet. You will only get the document once you submitted the license application and  pay the Home Office Fees. </li>
                <li style="padding-bottom:7px;">It is crucial that you complete your organization profile thoroughly. Without the necessary information and documents, we regret that we will be unable to assist with your sponsorship application. </li>
            </ul>
            <p style="color: #060606;"><strong>Your journey begins here. Should you have any questions, please feel free to reach out to us at <a style="color: #440af3;" href="https://skilledworkerscloud.co.uk">info@skilledworkerscloud.co.uk</a> We are always here to assist you!</strong></p>
            <p style="color: #060606;"><strong><i>Thanking you.</i></strong></p>
        <div
            style="text-align: center; padding: 20px; background-color: #17276d; color: white; border-radius: 0 0 10px 10px;">
            <p>Thank you,<br>[ {{$sub_comname}} ]<br>{{$sub_address}}<br>{{$sub_zip}}<br>{{$sub_country}}<br><strong>{{$sub_email}}</strong></p>
        </div>
    </div>
</body>

</html>