<?php


require_once("admin_panel/vendor/autoload.php"); //loading mPDF

/**
 * Class GetResults
 * output the Results to the patient
 */
class GetResults {

    

    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();
        
        
        // happens when user clicks get_results button
        if (isset($_POST["get_results"])) {
            
            
            $this->getResults();
        }
    }

    /**
     * Get data
     */
    private function getResults() {
        
        if (empty($_POST['patient_surname'])) {
            $this->errors[] = "ERROR: Surname can't be empty.";
        } elseif (empty($_POST['patient_birthdate'])) {
            $this->errors[] = "ERROR: Birthdate can't be empty.";
        } elseif (empty($_POST['sample_number'])) {
            $this->errors[] = "ERROR: Sample number can't be empty.";
        } elseif (!empty($_POST['patient_surname']) 
                && !empty($_POST['patient_birthdate'])
                && !empty($_POST['sample_number'])) {

             // create a database connection, using the constants from config/db.php
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);   

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                $patient_surname = $this->db_connection->real_escape_string($_POST['patient_surname']);
                $patient_birthdate = $this->db_connection->real_escape_string($_POST['patient_birthdate']);
                $sample_number = $this->db_connection->real_escape_string($_POST['sample_number']);

                // database query, getting all the info of the selected sample number
                $sql = "SELECT *
                        FROM samples
                        WHERE patient_surname = '" . $patient_surname . "' AND patient_birthdate = '" . $patient_birthdate . "' and sample_number = '" . $sample_number . "';";
                $result_of_login_check = $this->db_connection->query($sql);
                
                // if this data exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    //PDF formating and output
                    $mpdf = new \Mpdf\Mpdf();

                    $data = '';
                    $data .= '<img src="styles/logo.png" style="width: 35%; float: right;">';
                    $data .= '<strong>Patient: <strong>' . $result_row->patient_name . ' ' . $result_row->patient_surname . '<br />';
                    $data .= '<strong>Birthdate: <strong>' . $result_row->patient_birthdate . '<br />';
                    $data .= '<br />';
                    $data .= '<strong>Sample number: <strong>' . $result_row->sample_number . '<br />';
                    $data .= '<strong>Sample date: <strong>' . $result_row->sample_date . '<br />';
                    $data .= '<br />';
                    $data .= '<br />';
                    $data .= '<h1 style="text-align: center;">SAMPLE RESULTS</h1>';
                    
                    //Sedimentation
                    $data .= '<h2 style="text-align: center;">Sedimentation</h2>'; 
                    $data .= '
                    <table style="width: 100%; table-layout: fixed;">
                    <tr>
                      <td style="width: 33%;"><strong>Data</strong></td>
                      <td style="width: 33%;"><strong>Result</strong></td>
                      <td style="width: 33%;"><strong>Reference</strong></td>
                    </tr>
                    <tr>
                      <td>ESR</td>
                      <td>' . $result_row->esr_hour . '</td>
                      <td>4.0 - 12.0 mm/h</td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>' . $result_row->esr_2hour . '</td>
                      <td>12.0 - 24.0 mm/2h</td>
                    </tr>
                    <tr>
                      <td>Leukocytes</td>
                      <td>' . $result_row->leukocytes . '</td>
                      <td>5.0 - 10.0 x 10⁹/L</td>
                    </tr>
                    <tr>
                      <td>Bleeding time</td>
                      <td>' . $result_row->bleeding_time . '</td>
                      <td>60 - 240 s</td>
                    </tr>
                    <tr>
                      <td>Coagulation time</td>
                      <td>' . $result_row->coagulation_time . '</td>
                      <td>300 - 900 s</td>
                    </tr>
                  </table>';

                  // Urin
                  if ($result_row->urin_color == 'other') {
                    $urin_color = $result_row->other_urin_color;
                  } else {
                    $urin_color = $result_row->urin_color;
                  }

                  $data .= '<h2 style="text-align: center;">Urin</h2>'; 
                    $data .= '
                    <table style="width: 100%; table-layout: fixed;">
                    <tr>
                      <td style="width: 33%;"><strong>Data</strong></td>
                      <td style="width: 33%;"><strong>Result</strong></td>
                      <td style="width: 33%;"><strong>Reference</strong></td>
                    </tr>
                    <tr>
                      <td>Appearance</td>
                      <td>' . $result_row->urin_appearance . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Color</td>
                      <td>' . $urin_color . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>pH</td>
                      <td>' . $result_row->urin_ph . '</td>
                      <td>4.8 - 7.5</td>
                    </tr>
                    <tr>
                      <td>Specific weight</td>
                      <td>' . $result_row->urin_weight . '</td>
                      <td>1.003 - 1.040</td>
                    </tr>
                    <tr>
                      <td>Proteins</td>
                      <td>' . $result_row->urin_proteins . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Glucose</td>
                      <td>' . $result_row->urin_glucose . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Ketones</td>
                      <td>' . $result_row->urin_ketones . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Blood</td>
                      <td>' . $result_row->urin_blood . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Nitrites</td>
                      <td>' . $result_row->urin_nitrites . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Bilirubin</td>
                      <td>' . $result_row->urin_bilirubin . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Urobilinogen</td>
                      <td>' . $result_row->urin_urobilinogen . '</td>
                      <td>max. 17.0</td>
                    </tr>
                  </table>';

                  //Urin sedimentation
                  $data .= '<h2 style="text-align: center;">Urin sedimentation</h2>'; 
                    $data .= '
                    <table style="width: 100%; table-layout: fixed;">
                    <tr>
                      <td style="width: 33%;"><strong>Data</strong></td>
                      <td style="width: 33%;"><strong>Result</strong></td>
                      <td style="width: 33%;"><strong>Reference</strong></td>
                    </tr>
                    <tr>
                      <td>ERC</td>
                      <td>' . $result_row->urin_erc . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>LKC</td>
                      <td>' . $result_row->urin_lkc . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Epithelium</td>
                      <td>' . $result_row->urin_epi . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Mucus</td>
                      <td>' . $result_row->urin_mucus . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Salts</td>
                      <td>' . $result_row->urin_salts . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Crystals</td>
                      <td>' . $result_row->urin_crystals . '</td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Bacteria</td>
                      <td>' . $result_row->urin_bacteria . '</td>
                      <td></td>
                    </tr>
                  </table>';

                  //Serum
                  $data .= '<h2 style="text-align: center;">Serum</h2>'; 
                    $data .= '
                    <table style="width: 100%; table-layout: fixed;">
                    <tr>
                      <td style="width: 33%;"><strong>Data</strong></td>
                      <td style="width: 33%;"><strong>Result</strong></td>
                      <td style="width: 33%;"><strong>Reference</strong></td>
                    </tr>
                    <tr>
                      <td>GLU</td>
                      <td>' . $result_row->serum_glu . '</td>
                      <td>3.9 - 6.1 mmol/L</td>
                    </tr>
                    <tr>
                      <td>CHOL</td>
                      <td>' . $result_row->serum_chol . '</td>
                      <td>0.0 - 5.7 mmol/L</td>
                    </tr>
                    <tr>
                      <td>TGL</td>
                      <td>' . $result_row->serum_tgl . '</td>
                      <td>0.0 - 2.3 mmol/L</td>
                    </tr>
                    <tr>
                      <td>ahdl</td>
                      <td>' . $result_row->serum_ahdl . '</td>
                      <td>0.9 - 1.55 mmol/L</td>
                    </tr>
                    <tr>
                      <td>RISK</td>
                      <td>' . $result_row->serum_risk . '</td>
                      <td>3.0 - 6.2</td>
                    </tr>
                  </table>';

                  //Blood count
                  $data .= '<h2 style="text-align: center;">Blood count</h2>'; 
                    $data .= '
                    <table style="width: 100%; table-layout: fixed;">
                    <tr>
                      <td style="width: 33%;"><strong>Data</strong></td>
                      <td style="width: 33%;"><strong>Result</strong></td>
                      <td style="width: 33%;"><strong>Reference</strong></td>
                    </tr>
                    <tr>
                      <td>WBC</td>
                      <td>' . $result_row->serum_wbc . '</td>
                      <td>4.0 - 9.7 x 10⁹/L</td>
                    </tr>
                    <tr>
                      <td>NEU</td>
                      <td>' . $result_row->serum_neu . '</td>
                      <td>44.0 - 80.0 %N</td>
                    </tr>
                    <tr>
                      <td>LYM</td>
                      <td>' . $result_row->serum_lym. '</td>
                      <td>20.0 - 46.0 %L</td>
                    </tr>
                    <tr>
                      <td>MONO</td>
                      <td>' . $result_row->serum_mono . '</td>
                      <td>2.0 - 12.0 %M</td>
                    </tr>
                    <tr>
                      <td>EOS</td>
                      <td>' . $result_row->serum_eos . '</td>
                      <td>0.0 - 7.0 %E</td>
                    </tr>
                    <tr>
                      <td>BASO</td>
                      <td>' . $result_row->serum_baso . '</td>
                      <td>0.0 - 2.0 %B</td>
                    </tr>
                    <tr>
                      <td>RBC</td>
                      <td>' . $result_row->serum_rbc . '</td>
                      <td>3.86 - 5.08 x 10¹²/L</td>
                    </tr>
                    <tr>
                      <td>HGB</td>
                      <td>' . $result_row->serum_hgb . '</td>
                      <td>119. - 157. g/L</td>
                    </tr>
                    <tr>
                      <td>HCT</td>
                      <td>' . $result_row->serum_hct . '</td>
                      <td>.360 - .470 L/L</td>
                    </tr>
                    <tr>
                      <td>MCV</td>
                      <td>' . $result_row->serum_mcv . '</td>
                      <td>83.0 - 92.0 fL</td>
                    </tr>
                    <tr>
                      <td>MCH</td>
                      <td>' . $result_row->serum_mch . '</td>
                      <td>27.0 - 34.0 pg</td>
                    </tr>
                    <tr>
                      <td>MCHC</td>
                      <td>' . $result_row->serum_mchc . '</td>
                      <td>320. - 345. g/L</td>
                    </tr>
                    <tr>
                      <td>RDW</td>
                      <td>' . $result_row->serum_rdw . '</td>
                      <td>14.6 - 16.5 %CV</td>
                    </tr>
                    <tr>
                      <td>PLT</td>
                      <td>' . $result_row->serum_plt . '</td>
                      <td>158. - 424. x 10⁹/L</td>
                    </tr>
                    <tr>
                      <td>MPV</td>
                      <td>' . $result_row->serum_mpv . '</td>
                      <td>6.8 - 10.4 fL</td>
                    </tr>
                  </table>';

                  $data .= '<br />'; 
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />'; 
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<br />';
                  $data .= '<em>Digitally signed.</em>'; 



                    $mpdf->WriteHTML($data);
                    $mpdf->Output('file.pdf', 'D');



                    } else {
                        $this->errors[] = "ERROR: Sample data does not exist. Chech your input, or wait till the results are processed.";
                    }
                } else {
                    $this->errors[] = "ERROR: Database connection problem.";
                }                      
            } else {
                $this->errors[] = "ERROR: Database connection problem.";
            }


        }

    }
