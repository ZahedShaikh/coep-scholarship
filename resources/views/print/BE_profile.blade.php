<html>
    <head>

        <title>TATA Samarth Scholarship</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <script src="{{ asset('/static/js/app.js') }}" defer></script>

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
            .button {
                background-color: #008CBA;
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
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
                                    <img src="{{URL::asset('/static/images/avatar.png')}}" alt="profile Pic" height="60" width="60">
                                </td>

                                <td>
                                    Form No #: &nbsp;{{ $info->id }}<br>
                                    Updated on: &nbsp;{{ $info->updated_at }}<br>
                                    TATA Samarth Scholarship
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


            <table>
                <col width="35%">
                <col width="50%">
                <col width="20%">
                <col width="20%">

                <tr>
                    <td>Full Name</td>
                    <td>&nbsp;{{ $info->name }} &nbsp;{{ $info->middleName }} &nbsp;{{ $info->surName }}</td>
                    <td>Category</td>
                    <td>&nbsp;{{ $info->category }}</td>
                </tr>
                <tr>
                    <td>Year of admission</td>
                    <td>&nbsp;{{ $info->yearOfAdmission }}</td>
                    <td>Gender</td>
                    <td>&nbsp;{{ $info->gender }}</td>
                </tr>
                <tr>
                    <td>Name of College</td>
                    <td>&nbsp;{{ $info->college }}</td>
                    <td>Contact</td>
                    <td>&nbsp;{{ $info->contact }}</td>
                </tr>
                <tr>
                    <td>Email-ID</td>
                    <td>&nbsp;{{ $info->email }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>



            <table>
                <tr class="heading">
                    <td>
                        SSC/HSC/Diploma Details
                    </td>
                </tr>
            </table>

            <table>
                <col width="20">
                <col width="20">
                <col width="20">

                <tr>
                    <td>SSC: &nbsp;{{ $ssc_marks->ssc }}%</td>
                    <td>HSC: &nbsp;{{ $ssc_marks->hsc }}%</td>
                    <td>Diploma:  &nbsp;{{ $ssc_marks->diploma }}%</td>
                </tr>
            </table>


            <table>
                <tr class="heading">
                    <td>
                        UG Details
                    </td>
                </tr>
            </table>


            <table >
                <col width="33%">
                <col width="33%">
                <col width="33%">

                <tr>
                    <td>1st Semester  :&nbsp;{{ $marks->semester1 }}</td>
                    <td>4th Semester  :&nbsp;{{ $marks->semester4 }}</td>
                    <td>7th Semester  :&nbsp;{{ $marks->semester7 }}</td>
                </tr>

                <tr>
                    <td>2nd Semester  :&nbsp;{{ $marks->semester2 }}</td>
                    <td>5th Semester  :&nbsp;{{ $marks->semester5 }}</td>
                    <td>8th Semester  :&nbsp;{{ $marks->semester8 }}</td>
                </tr>
                <tr>

                </tr>
                <tr>
                    <td>3rd Semester  :&nbsp;{{ $marks->semester3 }}</td>
                    <td>6th Semester  :&nbsp;{{ $marks->semester6 }}</td>
                    <td>CGPA          :&nbsp;{{ $marks->CGPA }}</td>
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
                <col width="50%">
                <col width="50%">

                <tr>
                    <td>Bank Name&nbsp;:&nbsp;&nbsp;{{ $banks->bank_Name }}</td>
                    <td>Account No&nbsp;:&nbsp;{{ $banks->account_No }}</td>
                </tr>
                <tr>
                    <td>IFSC Code&nbsp;:&nbsp;&nbsp;&nbsp;{{ $banks->IFSC_Code }}</td>
                    <td>Branch&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $banks->branch }}</td>
                </tr>                
            </table>


            <table>
                <col width="70%">
                <tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                    <td></td>
                    <td>Students Signature&nbsp;</td>
                </tr>

            </table>



            <table>
                <tr class="heading">
                    <td>
                        Office Use Only
                    </td>
                </tr>
            </table>


            <table>
                <col width="40%">

                <tr>
                    <td>Officers Signature and Remark</td>
                </tr>

            </table>


            <br>
            <div style="text-align: center">
                <input id ="printbtn" class="button" type="button" value="Print this page" onclick="window.print();" >
            </div>
        </div>

    </body>
</html>
