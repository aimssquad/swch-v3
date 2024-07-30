<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon" />
    <title>SWCH</title>
    <style>
    .main-table tr td,
    .main-table tr th {
        padding: 5px;
    }

    .main-table tr:nth-child(even) {
        background-color: #dbe5f1;
    }

    td {
        font-size: 13px;
    }
    </style>
	
</head>
<body style="position: relative;">
	<div class="wrapper">
        <div style="padding:5px">
            <div class="row">
                <div class="col-md-12">
                    <h1 style="text-align:center">Capstone Assessment Report</h1>
                    <h2 style="text-align:center">{{$forminfo->form_name}} For the Position of {{$jobinfo->title}}</h2>
                </div>
                <!-- <div class="col-md-12">
                    
                </div> -->
                
                <div class="col-md-12">
                    <table  width="100%" style="font-family:calibri;padding: 0 15px;">
                        <thead>
                            <tr>
                                <th style="background-color:#2caaed;color:#fff;">Sl. No.</th>
                                <th style="background-color:#2caaed;color:#fff;">Candidate Name</th>
                                <th style="background-color:#2caaed;color:#fff;">Assesment Date</th>
                                @foreach($interview_form_capstone as $rec)
                                <th style="background-color:#2caaed;color:#fff;">{{ $rec->capstone_name }}</th>
                                @endforeach
                                <th style="background-color:#2caaed;color:#fff;">Total Score</th>
                                <th style="background-color:#2caaed;color:#fff;">Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($recruitment_interviews as $record)
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td>{{ $record->candidate_name }}</td>
                                <td>{{ date('d/m/Y',strtotime($record->interview_date)) }}</td>
                                @foreach($interview_form_capstone as $rec)
                                <td style="text-align:center">
                                    @php
                                        $cap=DB::table('mock_capstone_details')->where('mock_capstone_details.mock_interview_id', '=', $record->id)->where('mock_capstone_details.form_capstone_id', '=', $rec->id)->first();
                                        //print_r($cap);
                                    @endphp
                                    {{$cap->capstone_score}}
                                </td>
                                @endforeach
                                <td style="text-align:center">{{ $record->capstone_score }}</td>
                                <td>{{ $record->recommendation }}</td>
                            </tr>
                            @endforeach  
                        </tbody>
                    </table>
                </div>
         
            </div>
            
        </div>
	</div>

</body>
</html>