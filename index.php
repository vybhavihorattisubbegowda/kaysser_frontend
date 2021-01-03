<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="noindex,nofollow" />
    <title>Kaysser Dashboard</title>

    <!-- CSS -->
    <link href="./css/style.min.css" rel="stylesheet" />
    <!-- Jquery -->
    <script src="./assets/jquery/dist/jquery.min.js"></script>
    <!-- JavaScript -->
    <script src="./assets/popper.js/dist/umd/popper.min.js"></script>
    <script src="./assets/bootstrap/dist/js/bootstrap.min.js"></script>
  </head>
  <body>
  <?php 
    $jsonresponses = file_get_contents('http://127.0.0.1:8000/mitarbeiter');//returns entire file as string
    //function decodes json-file(string) as an associative array on (true,null), object on (false) 
    $jsonresponses = json_decode($jsonresponses, false); //returns objects
  ?>
    <div id="main-wrapper">
      <div class="page-wrapper">
        <div class="container-fluid">
          <!-- Start marquee text bar -->
          <div class="row">
            <div class="col-md-12">
              <div class="card p-3">
                <marquee> Bitte halten Sie Abstand von 1,5 Meter</marquee>
              </div>
            </div>
          </div>
          <!-- End marquee text bar -->
          
          <div class="row">
            <!-- Start Lager / Kommissionierer-->
            <div class="col-md-7">
              <div class="card">
                <div class="table-responsive">
                  <table class="table v-middle">
                    
                    <!-- Start Kalenderwoche -->
                    <thead>
                      <tr class="bg-light">
                        <th><h4>Lager /Kommissionierer</h4></th>

                        
                        <th class="flex-column align-items-center">
                          <div class="d-flex align-items-center justify-content-center">
                          KW1
                          </div>

                          <div>
                            <label class="label label-success">Mo</label>
                            <label class="label label-success">Di</label>
                            <label class="label label-success">Mi</label>
                            <label class="label label-success">Do</label>
                            <label class="label label-success">Fr</label>
                          </div>
                        </th>
                         
                      </tr>
                    </thead>
                    <!-- End Kalenderwoche -->
                    
                    <!-- Start Mitarbeiter Namen -->
                    <tbody>
                    <?php foreach($jsonresponses as $jsonresponse){ //there are objects(each mitarbeiter) so, for loop 
                    ?> 
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <div class="m-r-10">
                            <?php
                              //gets all checkin/outs, if many timings then gives it in array
                              $timesheets = $jsonresponse->attendences[0]->timesheets;
                              $timesheetsCount = count($timesheets);
                              if($timesheetsCount>0){
                                $lastArray = $timesheets[$timesheetsCount-1];
                                if(is_null($lastArray->checkOut)){
                                  echo '<a class="btn btn-circle d-flex btn-success text-white" >';
                                }else{
                                  echo '<a class="btn btn-circle d-flex btn-danger text-white" >';
                                }
                              }else { 
                                echo '<a class="btn btn-circle d-flex btn-danger text-white" >';
                              }
                              echo $jsonresponse->nachname[0].$jsonresponse->vorname[0]; 
                             
                              echo '</a>';
                            ?>
                            
                            </div>
                            <div class="">
                              <h4 class="m-b-0 font-16"> 
                              <?php
                              echo $jsonresponse->nachname.' '.$jsonresponse->vorname; 
                              ?>
                              </h4>
                            </div>
                          </div>
                        </td>

                        <td>
                          <?php
                          //each mitarbeiter is an entire object($jsonresponse) with key&values,
                          //the key attendences has an object. that object contains arrays
                          // the object of attendences is in index(position) so,attendences[0]
                          //that 0 position has arrays inside 
                          /** 
                          foreach($jsonresponse->attendences as $attendence){  
                            if( $attendence->status){
                              echo '<label class="label label-success">P</label>';
                            }else{
                              echo '<label class="label label-success">'.$attendence->status.'</label>';
                            }
                          }
                          */
                          ?>
                          <label class="label label-success">P</label>
                          <label class="label label-success">P</label>
                          <label class="label label-success">P</label>
                          <label class="label label-primary">UR</label>
                          <label class="label label-warning">KR</label>
                          
                        </td>
                        
                      </tr>
                    <?php }
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- End Lager / Kommissionierer-->
            
            
            <!-- Kommissionierleistung + Wareneingang-->
            <div class="col-md-5">
              <!-- Start Kommissionierleistung -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Kommissionierleistung</h4>
                  <table class="table no-border mini-table m-t-20">
                    <tbody>
                      <tr>
                        <td class="text-muted"></td>

                        <td class="font-medium">Aktueller Tag</td>
                        <td class="font-medium">Tag/ Letzter Monat</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Aufträge</td>
                        <td class="font-medium">83%</td>
                        <td class="font-medium">34</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Kunden</td>
                        <td class="font-medium">28.56 in</td>
                        <td class="font-medium">34</td>
                      </tr>

                      <tr>
                        <td class="text-muted">Paletten</td>
                        <td class="font-medium">78%</td>
                        <td class="font-medium">34</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Gewicht</td>
                        <td class="font-medium">78%</td>
                        <td class="font-medium">34</td>
                      </tr>
                      <tr>
                        <td class="text-muted">Lieferquote</td>
                        <td class="font-medium">78%</td>
                        <td class="font-medium">34</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- End Kommissionierleistung -->
              
              <!-- Start Wareneingang -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Wareneingaenge</h4>

                  <div class="table-responsive">
                    <table class="table v-middle">
                      <tbody>
                        <tr>
                          <td class="text-muted"></td>
                          <td class="text-muted"></td>
                          <td class="text-medium">Firma</td>

                          <td class="font-medium">Palleten</td>
                          <td class="font-medium">Stellplates</td>
                          <td class="font-medium">Anliefernummer</td>
                        </tr>
                        <tr>
                          <td>Montag 12.12.2020</td>
                          <td>8:00 uhr</td>
                          <td>John Doe GmbH</td>
                          <td>23</td>
                          <td>46</td>
                          <td>356</td>
                        </tr>
                        <tr>
                          <td>Montag 12.12.2020</td>
                          <td>8:00 uhr</td>
                          <td>John Doe GmbH</td>
                          <td>23</td>
                          <td>46</td>
                          <td>356</td>
                        </tr>
                        <tr>
                          <td>Montag 12.12.2020</td>
                          <td>8:00 uhr</td>
                          <td>John Doe GmbH</td>
                          <td>23</td>
                          <td>46</td>
                          <td>356</td>
                        </tr>
                        <tr>
                          <td>Montag 12.12.2020</td>
                          <td>8:00 uhr</td>
                          <td>John Doe GmbH</td>
                          <td>23</td>
                          <td>46</td>
                          <td>356</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Wareneingang -->
            
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
