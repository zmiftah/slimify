<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Pengingat Jadwal</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/email.css" />
</head>
<body bgcolor="#FFFFFF">
    <!-- BODY -->
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" bgcolor="#FFFFFF">

                <div class="content">
                <table>
                    <tr>
                        <td>
                            <h3>Yth, %s</h3>
                            <p class="lead">
                                Anda dijadwalkan untuk mengikuti kegiatan sbb:
                            </p>

                            <!-- Callout Panel -->
                            <p class="callout">
                                <span><strong>Informasi Jadwal</strong></span> <br />
                                NOMOR SURAT : %s <br />
                                ASAL SURAT : %s <br />
                                HARI/TGL : %s <br />
                                WAKTU : %s <br />
                                TEMPAT : %s <br />
                                KEGIATAN : %s <br /><br /><br /><br />
                            </p><!-- /Callout Panel -->

                            <p class="lead">
                                Regards, <br />
                                Admin Penjadwalan
                            </p>
                        </td>
                    </tr>
                </table>
                </div><!-- /content -->
                                        
            </td>
            <td></td>
        </tr>
    </table><!-- /BODY -->
</body>
</html>