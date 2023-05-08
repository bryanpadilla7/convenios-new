<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>
</head>
<style>
    table {
        width: 100%;
        border-spacing: 0px;
    }

    td {
        text-align: left;
        padding: 12px;
    }

    h3 {
        line-height: 200%;
    }

    body {
        font-family: Arial, sans-serif;
    }

    th {
        background: #323e48;
        color: white;
        height: 3%;
        text-align: center;
        font-weight: bold;
    }


</style>

<body>
    <div>
        <table>
            <tr>
                <td><h3>DIRECCIÓN GENERAL DE COMUNICACIONES</h3></td>
                <td><img src="img/logo.jpg" width="200" height="130"></td>
            </tr>
        </table>
    </div>

    @foreach($data as $d)
    <table>
        <tbody>
            <tr>
                <th colspan="2">Información del instrumento</th>
            </tr>
            <tr>
                <td>Nombre del instrumento:</td>
                <td>{{ $d->instrument_name }}</td>
            </tr>
            <tr>
                <td>Tipo de convenio:</td>
                <td>{{ $d->type_instrument_name }}</td>
            </tr>
            <tr>
                <td>Entidad:</td>
                <td>{{ $d->entity }}</td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td>{{ $d->description }}</td>
            </tr>
            <tr>
                <td>Sector:</td>
                <td>{{ $d->sector_name }}</td>
            </tr>
            
        </tbody>
    </table>
    <br>
    <table>
        <tbody> 
            <tr>
                <th colspan="8">Exoneraciones</th>
            </tr>
            <tr>
                <td><strong>Espacio</strong></td>
                <td><strong>Fechas</strong></td>
                <td><strong>Horas</strong></td>
                <td><strong>Tarifa</strong></td>
                <td><strong>Asistentes</strong></td>
                <td><strong>Monto por hora</strong></td>
                <td><strong>Monto por persona</strong></td>
                <td><strong>Descripción</strong></td>
            </tr>

            @foreach($d->exonerations as $exo)
                <tr>
                    <td>{{ $exo->place_name }}</td>
                    <td>{{ $exo->date }}</td>
                    <td>{{ $exo->hour }}</td>
                    <td>{{ $exo->charge }}</td>
                    <td>{{ $exo->people }}</td>
                    <td>{{ $exo->amount_hour }}</td>
                    <td>{{ $exo->amount_people }}</td>
                    <td>{{ $exo->exonerated_description }}</td>
                </tr>    
            @endforeach
        </tbody>
    </table>
    <br><br>
    <h4>Monto Total por Hora: ${{ $d->totalAmountHour }}</h4>
    <h4>Monto Total por Persona: ${{ $d->totalAmountPeople }}</h4>
    <br>
    <h4>Total de contribución: ${{ $d->totalContributed }}</h4>
    @endforeach

    <div id="footer">

    </div>
</body>

</html>
