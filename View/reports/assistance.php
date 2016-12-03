<!DOCTYPE html>
<html>
<head>
    <title>Reporte de asistencia</title>

    <link rel='stylesheet' href='../assets/css/normalize.css'/>
    <link rel='stylesheet' href='../assets/css/login.css'/>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body>


<div class="col-sm-4">
    <div class="form">
        <p>De: <input type="text" id="dateDe"></p>
        <p>Hasta: <input type="text" id="dateHasta"></p>
        <button id="btn-filtrar" class="btn">Filtrar</button>
    </div>
    <div class="row panel panel-default">
        <div class="panel-heading">
            Lista de asistencia
        </div>
        <div class="panel-body">
            <table id="dtAssistance" class="table display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Alumno</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div id="bar-table" class="col-sm-8" style="height: 400px;"></div>

<script>

    $(document).ready(function () {
        $("#dateDe").datepicker();
        $("#dateHasta").datepicker();

        var table = $('#dtAssistance').DataTable({

            "processing": true,

            "ajax": {
                "method": "POST",
                "url": "../testing/LogGetter.php", //cambiar por CommunicationHandler
                "dataType": "json",
                "data": {
                    target: "SuscriptionAdministrator",
                    type: "getAssistanceLog",
                    data: {
                        "initDate": initDate,
                        "finalDate": finalDate
                    }
                }
            },

            "columns": [
                {data: "DateTime"},
                {data: "Name"},
            ],
            "order": [0, "des"],
            "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'All']],

        });

        var refreshGraphic = function () {
            var allDates = table.columns(0).data().toArray();

            var datesForTheGraph = [];
            var assistance = [];
            var commonIndex = 0;

            $.each( allDates[0], function ( index, date ) {

                var matchIndex = $.inArray( date, datesForTheGraph ); //Return -1 when doesnt find coincidences

                if ( matchIndex > -1 ) {

                    assistance[ matchIndex ]++;

                }

                else {

                    datesForTheGraph[ commonIndex ] = date;
                    assistance[ commonIndex ] = 1;
                    commonIndex++;

                }

            });

            datesForTheGraph.reverse();

            var data = [
                {
                    x: datesForTheGraph,
                    y: assistance,
                    type: ['bar', 'scatter'],
                    marker: {
                        color: 'rgb(76, 175, 80)'
                    }
                }
            ];

            Plotly.newPlot('bar-table', data);
        };


        var initDate = '6/2/2016';
        var finalDate = '6/2/2016';

        $("#btn-filtrar").click(function(){
            initDate = $("#dateDe").val();
            finalDate = $("#dateHasta").val();
            table.ajax.reload();
            refreshGraphic;
        });
        $('#dtAssistance').on('draw.dt length.dt processing.dt', refreshGraphic);
    });

</script>
</body>
</html>
