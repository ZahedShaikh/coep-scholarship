<html>
    <head>

        <title>Application form print</title>

        <style>
            .invoice-box {
                max-width: 800px;
                margin: auto;
                padding: 30px;
                border: 1px solid #eee;
                box-shadow: 0 0 10px rgba(0, 0, 0, .15);
                font-size: 16px;
                line-height: 24px;
                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                color: #555;

            }

            .invoice-box table {
                width: 100%;
                line-height: inherit;
                text-align: left;
                border-collapse: collapse;
            }

            .invoice-box table td {
                padding: 10px;
                vertical-align: top;
            }

            .invoice-box table tr td:nth-child(6) {
                text-align: left;
            }

            .invoice-box table tr.top table td {
                padding-bottom: 20px;
            }

            .invoice-box table tr.top table td.title {
                font-size: 45px;
                line-height: 45px;
                color: #333;
            }

            .invoice-box table tr.information table td {
                padding-bottom: 40px;
            }

            .invoice-box table tr.heading td {
                background: #eee;
                border-bottom: 1px solid #ddd;
                font-weight: bold;
            }

            .invoice-box table tr.details td {
                padding-bottom: 10px;
            }

            .invoice-box table tr.item td{
                border-bottom: 1px solid #eee;
            }

            .invoice-box table tr.item.last td {
                border-bottom: none;
            }

            .invoice-box table tr.total td:nth-child(6) {
                border-top: 2px solid #eee;
                font-weight: bold;
            }

            @media only screen and (max-width: 600px) {
                .invoice-box table tr.top table td {
                    width: 100%;
                    display: block;
                    text-align: left;
                }

                .invoice-box table tr.information table td {
                    width: 100%;
                    display: block;
                    text-align: center;
                }
            }

            /** RTL **/
            .rtl {
                direction: rtl;
                font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            }

            .rtl table {
                text-align: right;
            }

            .rtl table tr td:nth-child(6) {
                text-align: left;
            }
        </style>

        <style type="text/css">
            @media print {
                #printbtn {
                    display :  none;
                }
            }
        </style>


    </head>

    <body>

        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="2">

                        <table>
                            <tr>
                                <td class="title">
                                    <img src="{{URL::asset('images/avatar.png')}}" alt="profile Pic" height="100" width="100">
                                </td>

                                <td>
                                    Form No #: {{ $info->id }}<br>
                                    Updated on: {{ $info->updated_at }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    <td>
                        Personnel Details
                    </td>
                </tr>
            </table>


            <table >
                <col width="20">
                <col width="40">
                <col width="15">
                <col width="30">

                <tr>
                    <td>Full Name</td>
                    <td>{{ $info->name }} {{ $info->middleName }} {{ $info->surName }}</td>
                    <td>Category</td>
                    <td>{{ $info->category }}</td>
                </tr>
                <tr>
                    <td>Year of admission</td>
                    <td>{{ $info->yearOfAdmission }}</td>
                    <td>Gender</td>
                    <td>{{ $info->gender }}</td>
                </tr>
                <tr>
                    <td>Name of College</td>
                    <td>{{ $info->college }}</td>
                    <td>Contact</td>
                    <td>{{ $info->contact }}</td>
                </tr>
                <tr>
                    <td>Email-ID</td>
                    <td>{{ $info->email }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>


            <table>
                <tr class="heading">
                    <td>
                        Semester Details
                    </td>

                </tr>
            </table>


            <table >


                <col width="20%">
                <col width="40%">
                <col width="15%">
                <col width="30%">

                <tr>
                    <td>Semester 1:</td>
                    <td>{{ $marks->semester1 }}</td>
                    <td>Semester 5:</td>
                    <td>{{ $marks->semester5 }}</td>
                </tr>
                <tr>
                    <td>Semester 2:</td>
                    <td>{{ $marks->semester2 }}</td>
                    <td>Semester 6:</td>
                    <td>{{ $marks->semester6 }}</td>
                </tr>
                <tr>
                    <td>Semester 3:</td>
                    <td>{{ $marks->semester3 }}</td>
                    <td>Semester 7:</td>
                    <td>{{ $marks->semester7 }}</td>
                </tr>
                <tr>
                    <td>Semester 4:</td>
                    <td>{{ $marks->semester4 }}</td>
                    <td>Semester 8:</td>
                    <td>{{ $marks->semester8 }}</td>
                </tr>
                <tr>
                    <td>CGPA:</td>
                    <td>{{ $marks->CGPA }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>



            <table>
                <tr class="heading">
                    <td>
                        Bank Details
                    </td>
                </tr>
            </table>


            <table>
                <col width="20%">
                <col width="40%">
                <col width="15%">
                <col width="30%">

                <tr>
                    <td>Bank Name</td>
                    <td>{{ $banks->bank_Name }}</td>
                    <td>Account No</td>
                    <td>{{ $banks->account_No }}</td>
                </tr>
                <tr>
                    <td>IFSC Code</td>
                    <td>{{ $banks->IFSC_Code }}</td>
                    <td>Branch</td>
                    <td>{{ $banks->branch }}</td>
                </tr>                
            </table>

            <br>

            <div style="text-align: center">
                <input id ="printbtn" type="button" value="Print this page" onclick="window.print();" >
            </div>
        </div>

    </body>
</html>
