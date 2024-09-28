<table>
    <tr>
        <th colspan="7" style="text-align: center; font-size: 20px;">Employee Change of Circumstances Report</th>
    </tr>
    <tr>
        <td><strong>Employee Name:</strong></td>
        <td>{{ $employee->emp_fname }} {{ $employee->emp_mname }} {{ $employee->emp_lname }}</td>
        <td><strong>Employee Code:</strong></td>
        <td>{{ $employee->emp_code }}</td>
    </tr>
    <tr>
        <td><strong>Designation:</strong></td>
        <td>{{ $employee->emp_designation }}</td>
        <td><strong>Contact Number:</strong></td>
        <td>{{ $employee->emp_ps_phone }}</td>
    </tr>
    <tr>
        <td><strong>Nationality:</strong></td>
        <td>{{ $employee->nationality }}</td>
    </tr>
</table>

<br>

<table border="1">
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
