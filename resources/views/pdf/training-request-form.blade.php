<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Training Request Form</title>

    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; line-height: 1.4; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #000; }
        th, td { padding: 1px 6px; text-align: left; vertical-align: top; } /* top-aligned */

        /* Custom class for borderless tables */
        table.no-border, 
        table.no-border th, 
        table.no-border td {
            border: none;
        }

        .no-border { border: none; } /* keeps your old usage safe */
        .text-center { text-align: center; }
        .section-title { background-color: #f0f0f0; font-weight: bold; padding: 5px; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td colspan="2" rowspan="4" style="vertical-align: middle !important;">
                <table style="border:0; margin: 0 !important">
                    <tr>
                        <td width="20%" style="border:0;">
                            <img src="{{ public_path(\App\Models\Setting::get('app_logo', 'images/default-logo.png')) }}" style="height: 80px; width: 80px;">
                        </td>
                        <td width="80%" style="border:0; font-size: 8px !important;">
                            <span style="font-weight: bolder">TLP TERMINAL SDN BHD</span> <br>
                            Bangunan Pentadbiran,Langsat Marine Terminal, <br>
                            Lot 1, PTD 4845, Jalan Persiaran Tanjung Langsat, <br>
                            Pelabuhan Tanjung Langsat, <br>
                            81700 Pasir Gudang, Johor
                        </td>
                    </tr>
                </table>
            </td>
            <td width="13%">DOC. NO</td>
            <td width="14%">TLPT-HCA-FR-001</td>
        </tr>
        <tr>
            <td>REV. NO</td>
            <td>3</td>
        </tr>
        <tr>
            <td>REV. DATE</td>
            <td>01 JAN 2026</td>
        </tr>
        <tr>
            <td>PAGE NO</td>
            <td>1 OF 1 PAGES</td>
        </tr>
        <tr>
            <td colspan="2" style="vertical-align: middle !important; font-weight:bolder;">
                TITLE: TRAINING REQUEST
            </td>
            <td colspan="2" class="text-center" style="background-color: black; color: white; font-weight:bolder">
                THIS RECORD SHOULD BE <br> KEPT FOR A MIN. 3 YEARS
            </td>
        </tr>
        <tr>
            <td width="30%">Training / Course / Programme</td>
            <td colspan="3">
                {{ $training->training_title }}
            </td>
        </tr>
        <tr>
            <td width="30%">Requested By</td>
            <td colspan="3">
                {{ $training->requestor_name }} ({{ $training->deparment_name }})
            </td>
        </tr>
        <tr>
            <td>Conducted / Organized By</td>
            <td colspan="3">
                {{ $training->training_organiser }}
            </td>
        </tr>
        <tr>
            <td>Training Venue</td>
            <td colspan="3">
                {{ $training->training_venue }}
            </td>
        </tr>
        <tr>
            <td>Training Cost</td>
            <td colspan="3">RM {{ number_format($training->training_cost, 2, '.', ',')  }}</td>
        </tr>
        <tr>
            <td>Dates of Training</td>
            <td colspan="3">
                From {{ $training->training_start_date }} To {{ $training->training_end_date }}
            </td>
        </tr>
        <tr>
            <td>Training Objective</td>
            <td colspan="3">
                {!! nl2br($training->training_objective) !!}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr style="background-color: rgb(196, 196, 196)">
                <td colspan="3" style="font-weight:bolder;">LIST OF PARTICIPANTS</td>
            </tr>
            <tr>
                <th width="1%" class="text-center">NO</th>
                <th>NAME</th>
                <th>DEPARTMENT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($training->participants as $index => $p)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->department }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <tr style="background-color: rgb(196, 196, 196)">
            <td colspan="2" style="font-weight:bolder;">FOR HUMAN RESOURCE DEVELOPMENT DEPARTMENT USE</td>
        </tr>
        <tr>
            <td width="30%">Transport To Venue</td>
            <td>
                {{ $training->reviewStatus->transport_to_venue_text }}
                {{ $training->reviewStatus->transportation_remark != null ? '(' . $training->reviewStatus->transportation_remark . ')' : '' }}
            </td>
        </tr>
        <tr>
            <td>Approved Cost</td>
            <td>RM {{ number_format($training->reviewStatus->approved_training_cost, 2, '.', ',')  }}</td>
        </tr>
        <tr>
            <td>Training Hours</td>
            <td>{{ $training->reviewStatus->training_duration }} Hour(s)</td>
        </tr>
        <tr>
            <td>Accommodation</td>
            <td>
                {{ $training->reviewStatus->is_accomodation_required == 1 ? 'Yes' : 'No' }}
                {{ $training->reviewStatus->accommodation_name != null ? '(' . $training->reviewStatus->accommodation_name . ')' : '' }}
            </td>
        </tr>
        <tr>
            <td>HRDF Claimable</td>
            <td>
                {{ $training->reviewStatus->is_hdrc_claimable == 1 ? 'Yes' : 'No' }}
            </td>
        </tr>
        <tr>
            <td>Budget Under ATP</td>
            <td>
                {{ $training->reviewStatus->is_budget_under_atp == 1 ? 'Yes' : 'No' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td width="58%" rowspan="2">REMARKS:</td>
            <td width="14%" class="text-center" style="background-color: rgb(196, 196, 196)">
                VERIFIED BY
            </td>
            <td width="14%" class="text-center" style="background-color: rgb(196, 196, 196)">
                CONFIRMED BY
            </td>
            <td width="14%" class="text-center" style="background-color: rgb(196, 196, 196)">
                APPROVED BY
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <br><br><br>
                {{ 'EXECUTIVE' }}
            </td>
            <td class="text-center">
                <br><br><br>
                {{ 'HOD' }}
            </td>
            <td class="text-center">
                <br><br><br>
                {{ 'HOC' }}
            </td>
        </tr>
        <tr>
            <td colspan="4" style="border: none !important; padding: 0 !important">
                <span style="font-weight: bolder; color:rgb(27, 27, 82)">This document is deemed CONTROLLED only when viewed electronically from the shared folder.</span>
            </td>
        </tr>
    </table>
</body>
</html>
