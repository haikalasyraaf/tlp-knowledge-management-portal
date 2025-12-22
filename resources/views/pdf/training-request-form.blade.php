<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Training Request Form</title>

    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; line-height: 1.4; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 20px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #000; }
        th, td { padding: 5px; text-align: left; vertical-align: top; } /* top-aligned */

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
            <td colspan="2" rowspan="4" style="vertical-align: middle !important; margin: 0 !important; padding: 0 0 0 24px !important">
                <table style="border:0; margin: 0 !important;">
                    <tr>
                        <td width="20%" style="border: 0; vertical-align: middle !important; padding: 0 !important;">
                            <img src="{{ public_path('images/tlp-logo-document.png') }}" style="height: 75px; padding: 0 !important;">
                        </td>
                        <td width="80%" style="border:0; font-size: 9px !important; vertical-align: middle !important">
                            <span style="font-weight: bolder">TLP TERMINAL SDN BHD</span> <br>
                            Bangunan Pentadbiran,Langsat Marine Terminal, <br>
                            Lot 1, PTD 4845, Jalan Persiaran Tanjung Langsat, <br>
                            Pelabuhan Tanjung Langsat, <br>
                            81700 Pasir Gudang, Johor
                        </td>
                    </tr>
                </table>
            </td>
            <td width="12%" style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">DOC. NO</td>
            <td width="14%" style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">TLPT-HCA-FR-001</td>
        </tr>
        <tr>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">REV. NO</td>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">3</td>
        </tr>
        <tr>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">REV. DATE</td>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">01 JAN 2026</td>
        </tr>
        <tr>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">PAGE NO</td>
            <td style="padding: 0 0 0 6px !important; vertical-align: middle; font-size: 10px !important;">1 OF 1 PAGES</td>
        </tr>
        <tr>
            <td colspan="2" style="vertical-align: middle !important; font-weight:bolder; font-size: 16px !important;">
                TITLE : TRAINING REQUEST
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
            <td>Date(s) of Training</td>
            <td colspan="3" style="padding: 0">
                <table width="100%" style="margin: 0">
                    <tr>
                        <td width="15%" style="border: 0 !important; border-right: 1px solid black !important;">From</td>
                        <td width="35%" style="border: 0 !important; border-right: 1px solid black !important;">{{ $training->training_start_date->format('d/m/Y') }}</td>
                        <td width="15%" style="border: 0 !important; border-right: 1px solid black !important;">To</td>
                        <td width="35%" style="border: 0 !important;">{{ $training->training_end_date->format('d/m/Y') }}</td>
                    </tr>
                </table>
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
            @for($i = 0; $i < 10; $i++)
                @php
                    $participant = $training->participants[$i] ?? null;
                @endphp

                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $participant->name ?? '' }}</td>
                    <td>{{ $participant->department ?? '' }}</td>
                </tr>
            @endfor
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

    <table style="font-size: 10px !important;">
        <tr>
            <td width="52%" rowspan="2">REMARKS:</td>
            <td width="16%" class="text-center" style="background-color: rgb(196, 196, 196)">
                VERIFIED BY
            </td>
            <td width="16%" class="text-center" style="background-color: rgb(196, 196, 196)">
                CONFIRMED BY
            </td>
            <td width="16%" class="text-center" style="background-color: rgb(196, 196, 196)">
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
                <span style="font-weight: bolder; color:rgb(27, 27, 82); font-size: 12px !important;">This document is deemed CONTROLLED only when viewed electronically from the shared folder.</span>
            </td>
        </tr>
    </table>
</body>
</html>
