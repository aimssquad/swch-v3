<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdf View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100%;
        }
        .container {
            width: 100%;
            text-align: center;
            padding: 20px;
        }
        .company-details {
            margin-bottom: 20px;
        }
        .company-details h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .company-details p {
            margin: 0;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
            padding-left: 20px;
            color: #555;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="company-details">
            <h2>{{ strtoupper($companyDetails['name']) }}</h2>
            @if(!empty($companyDetails['address']))<p>{{ $companyDetails['address'] }}</p>@endif
            @if(!empty($companyDetails['address2']))<p>{{ $companyDetails['address2'] }}</p>@endif
            @if(!empty($companyDetails['city']) && !empty($companyDetails['zip']))<p>{{ $companyDetails['city'] }}, {{ $companyDetails['zip'] }}</p>@elseif(!empty($companyDetails['city']))<p>{{ $companyDetails['city'] }}</p>@endif
            @if(!empty($companyDetails['phone']))<p>Phone: {{ $companyDetails['phone'] }}</p>@endif
            @if(!empty($companyDetails['email']))<p>Email: {{ $companyDetails['email'] }}</p>@endif
        </div>

        <table>
            <thead>
                <tr>
                    @foreach($tableHeadings as $heading)
                        <th>{{ $heading }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($tableData as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Powered by Skilled Workers Cloud
    </div>
</body>
</html>
