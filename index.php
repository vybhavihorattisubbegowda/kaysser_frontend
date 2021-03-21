<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Kaysser TV-Dashboard</title>

    <!-- CSS -->
    <link href="./css/style.min.css" rel="stylesheet" />
    <link href="./css/style.css" rel="stylesheet" />
    <!-- Jquery -->
    <script src="./assets/jquery/dist/jquery.min.js"></script>
    <!-- JavaScript -->
    <script src="./assets/popper.js/dist/umd/popper.min.js"></script>
    <script src="./assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="./js/chart_util.js"></script>
  </head>
  <body>
  <?php 
    setlocale (LC_TIME, 'German', 'de_DE', 'deu'); 
    $jsonresponses = file_get_contents('http://127.0.0.1:8000/mitarbeiter');//returns entire file as string
    //function decodes json-file(string) as an associative array on (true,null), object on (false) 
    $jsonresponses = json_decode($jsonresponses, false); //returns many objects
  ?>
    <div id="main-wrapper">
      <div class="page-wrapper">
        <div class="container-fluid">
          <!-- Start: marquee text bar -->
          <div class="row">
            <div class="col-md-12">
              <div class="card p-3">
                <marquee>+++  <img src="./images/social distance.png" alt="social distance image" width="50" height="50">  Bitte mindest Schutzabstand zu anderen halten +++</img> 
                             <img src="./images/handwashing method.png" alt="handwashing method image" width="50" height="50"> Regelmäßig Haende waschen +++</img>
                </marquee>
              </div>
            </div>
          </div>
          <!-- End: marquee text bar -->
          
          <div class="row">
            <!-- Start: Lager / Kommissionierer-->
            <div class="col-md-8">
              <div class="card">
                <div class="table-responsive">
                  <table class="table v-middle">
                    
                    <!-- Start: Kalenderwoche -->
                    <thead>
                      <tr class="bg-white">
                        <th><h3>Kommissionierer</h3></th>
                          <?php
                          
                            $current_week_time = strtotime("now");
                            $week_number =  utf8_encode(strftime("%U", $current_week_time));
                            $calender_week_counter = 0;
                            //12 weeks for 3 Months
                            for($i=0; $i<12; $i++){
                            
                          ?>
                        <!-- <th> is looping 12 times inside-->    
                        <th class="flex-column align-items-center">
                              <div class="font-18 d-flex align-items-center justify-content-center">
                              <?php 
                                $calender_week = $week_number+$i;
                                
                                echo '<label class="label label-info">KW'.$calender_week.'</label>';
                              ?>
                              </div> 
                            
                         </th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <!-- End: Kalenderwoche -->
                    
                    
                    <!-- Start: Mitarbeiter Names -->
                    <tbody>
                    <?php foreach($jsonresponses as $jsonresponse){ //there are objects(each mitarbeiter) so, for loop 
                    ?> 
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="m-r-10">
                              <?php
                                //gets all checkins/outs, if many timings then gives it in array
                                $timesheets = $jsonresponse->attendences[0]->timesheets;
                                $timesheetsCount = count($timesheets);
                                if($timesheetsCount > 0){
                                    $lastArray = $timesheets[$timesheetsCount-1];
                                    //Worker name shown Green when checkOut column has Null else Red 
                                    if(is_null($lastArray->checkOut) || $lastArray->checkOut == ""){
                                      echo '<a class="btn btn-circle d-flex btn-success text-white">';
                                    }else{
                                      echo '<a class="btn btn-circle d-flex btn-danger text-white">';
                                    }
                                }else { 
                                  echo '<a class="btn btn-circle d-flex btn-danger text-white">';
                                }
                                echo $jsonresponse->nachname[0].$jsonresponse->vorname[0]; 
                              
                                echo '</a>';
                              ?>
                            
                            </div>
                            <div class="">
                              <h3 class="m-b-0 font-16"> 
                              <?php
                              echo $jsonresponse->nachname.' '.$jsonresponse->vorname; 
                              ?>
                              </h3>
                            </div>
                          </div>
                        </td>
                        <?php 
                          //each mitarbeiter has 72 dates for 3 months
                          //array_chunk() makes an array with 6 elements. the rest elements will be in last array. array length also 6
                            $kw_dates = array_chunk($jsonresponse->attendences, 6); 
                            foreach($kw_dates as $kw_date){//looping through chunk arrays (72/6 = 12arrays)
                                echo '<td>';// entire weekdays inside each <td>
                              foreach($kw_date as $day){ // looping through each elements of an array out of 12 arrays
                                //if(is_null($day->status) || $day->status == ""){
                                   
                                if(!isset($day->status->code)){
                                  echo '<label class="label label-danger">MS</label>';
                                  }
                                else{
                                      if($day->status->code == "An"){
                                          echo '<label class="label label-success">AN</label>';
                                      }else{
                                        echo '<label class="label label-danger">'.$day->status->code.'</label>';
                                      }
                                  }
                                }
                              echo '</td>';
                              
                            }
                       
                        ?>
                      </tr>
                    <?php } ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- End: Lager / Kommissionierer-->
            
            
            <!-- Kommissionierleistung + Wareneingang-->
            <div class="col-md-4">
              <!-- Start: Kommissionierleistung Heading -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Kommissionierleistung</h3>
                  <canvas id="canvas"></canvas>
                </div>
              </div>
              <!-- End: Kommissionierleistung Heading -->
              
              
              
              <!-- Start: Wareneingang -->
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Wareneingaenge</h3>

                  <div class="table-responsive">
                    <table class="table v-middle">
                      <tbody>
                        <tr class="font-weight-bold">
                          <td>Datum</td>
                          <td>Uhrzeit</td>
                          <td>Firma</td>
                          <td>Palleten</td>
                          <td>Stellplaetze</td>
                          <td>Anliefernummer</td>
                        </tr>
                        <?php
                        
                          $delveries = file_get_contents('http://127.0.0.1:8000/delivery');
                          $delveries = json_decode($delveries,false);

                          foreach($delveries as $delivery){
                            $weekdays = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
                            $time = strtotime($delivery->date);
                            $numeric_day = date("w", $time);//0 to 6
                            $day = $weekdays[$numeric_day];
                          
                          echo '<tr>';
                         
                          echo '<td>'.$day.', '.$delivery->date.'</td>';
                          echo '<td>'.$delivery->time.'</td>';
                          echo '<td>'.$delivery->company->name.'</td>';
                          echo '<td>'.$delivery->pallets.'</td>';
                          echo '<td>'.$delivery->storageArea.'</td>';
                          echo '<td>'.$delivery->deliveryNr.'</td>';
                          echo '</tr>';
                          }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- End: Wareneingang -->

              <div><img src="./images/kaysser_logo.png" 
                    alt="Firmenlogo" 
                    style = "position: fixed; bottom: 0; right: 0; width: 200px;"
                    ></img>
              </div>
            
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Start Kommissionierleistung Grafik-->   
<?php
$orders = file_get_contents('http://127.0.0.1:8000/orders/summary');
$orders = json_decode($orders, false);
?>
    <script>
      var color = Chart.helpers.color;
      var barChartData = {
        labels: ["Auftraege", "Kunden", "Paletten", "Gewicht", "Lieferquote"],
        datasets: [
          {
            label: "Aktueller Monat",
            backgroundColor: color(window.chartColors.red)
              .alpha(0.5)
              .rgbString(),
            borderColor: window.chartColors.red,
            borderWidth: 1,
            data: [<?php echo $orders[0]->orders ?>, <?php echo $orders[0]->orders ?>, <?php echo $orders[1]->pallets/100 ?>, <?php echo number_format($orders[0]->weight/10000, 2) ?>, 84],
          },
          {
            label: "Letzter Monat",
            backgroundColor: color(window.chartColors.blue)
              .alpha(0.5)
              .rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: [<?php echo $orders[1]->orders ?>, <?php echo $orders[1]->orders ?>, <?php echo $orders[1]->pallets/100 ?>, <?php echo number_format($orders[1]->weight/10000, 2) ?>, 91],
          },
        ]
      };

      window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
          type: "bar",
          data: barChartData,

          options: {
            responsive: true,
                tooltips: {
                    enabled: true
                },
                hover: {
                    animationDuration: 1
                },
                animation: {
                    duration: 1,
                    onComplete: function () {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;
                        ctx.textAlign = 'center';
                        ctx.fillStyle = "rgba(0, 0, 0, 1)";
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);

                            });
                        });
                    }
                },
            scales: {
              yAxes: [
                {
                  display: false,
                },
              ],
            },
            plugins: {
              legend: {
                position: "top",
              },

              title: {
                display: true,
                text: "Chart.js Bar Chart",
              },
            },
          },
        });
      };
    </script>
    <!-- End Kommissionierleistung Grafik-->  
  </body>
</html>
