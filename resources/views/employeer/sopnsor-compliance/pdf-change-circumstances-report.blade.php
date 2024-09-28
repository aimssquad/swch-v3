<!DOCTYPE html>
<html>
<head>
    <title>Change of Circumstances Report</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .header-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .company-details {
            font-size: 12px;
            margin: 5px 0;
        }
        .company-details p {
            margin: 2px 0; /* Adjust spacing between details */
        }
        hr {
            border: 1px solid #000; /* Bottom border to separate header */
        }
        .section-title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .employee-details th, .employee-details td {
            border: none; /* No borders for employee details */
            padding: 5px;
        }
    </style>
</head>
<body>

    <!-- Letterhead Section (Company Information) -->
    <div class="header-container">
        <div class="company-name">{{ $Roledata->com_name }}</div>
        <div class="company-details">
            <p><strong>Contact Person:</strong> {{ $Roledata->f_name }} {{ $Roledata->l_name }}</p>
            <p><strong>Email:</strong> {{ $Roledata->email }}</p>
            <p><strong>Phone:</strong> {{ $Roledata->p_no }}</p>
            <p><strong>Address:</strong> {{ $Roledata->address ?? 'N/A' }}</p>
            <p><strong>Website:</strong> {{ $Roledata->website ?? 'N/A' }}</p>
        </div>
        <hr>
    </div>

    <!-- Employee Details Section -->
    <h3 class="section-title">Employee Details</h3>
    <table class="employee-details">
        <tr>
            <th>Employee Name:</th>
            <td>{{ $employee->emp_fname }} {{ $employee->emp_mname }} {{ $employee->emp_lname }}</td>
        </tr>
        <tr>
            <th>Employee Code:</th>
            <td>{{ $employee->emp_code }}</td>
        </tr>
        <tr>
            <th>Designation:</th>
            <td>{{ $employee->emp_designation }}</td>
        </tr>
        <tr>
            <th>Contact Number:</th>
            <td>{{ $employee->emp_ps_phone }}</td>
        </tr>
        <tr>
            <th>Nationality:</th>
            <td>{{ $employee->nationality }}</td>
        </tr>
    </table>

    <!-- Change of Circumstances History Section -->
    <h3 class="section-title">Change of Circumstances History</h3>
    <table>
        <thead>
            <tr>
                <th>Date of Change</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Nationality</th>
                <th>Visa Expiration</th>
                <th>Passport Expiration</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($changeHistory as $change)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($change->date_change)) }}</td>
                    <td>{{ $change->emp_designation }}</td>
                    <td>{{ $change->emp_ps_phone }}</td>
                    <td>{{ $change->nationality }}</td>
                    <td>{{ $change->visa_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->visa_exp_date)) : 'N/A' }}</td>
                    <td>{{ $change->pass_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->pass_exp_date)) : 'N/A' }}</td>
                    <td>{{ $change->remarks ?? 'None' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
