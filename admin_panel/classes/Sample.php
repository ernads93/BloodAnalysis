<?php

/**
 * Class registration
 * handles the user registration
 */
class Sample
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     */
    public function __construct()
    {
        if (isset($_POST["save_sample"])) {
            $this->saveSample();
        }
        
    }

    /**
     * handles the entire saving process. checks all error possibilities
     */
    private function saveSample()
    {
        
        if (empty($_POST['patient_name'])) {
            $this->errors[] = "ERROR: Patient name can't be empty.";
        } elseif (!preg_match('/[a-zA-Z]/', $_POST['patient_name'])) {
            $this->errors[] = "ERROR: Patient name scheme: only a-Z.";
        } elseif (empty($_POST['patient_surname'])) {
            $this->errors[] = "ERROR: Patient surname can't be empty.";
        } elseif (!preg_match('/[a-zA-Z]/', $_POST['patient_surname'])) {
            $this->errors[] = "ERROR: Patient surname scheme: only a-Z.";
        } elseif (empty($_POST['patient_birthdate'])) {
            $this->errors[] = "ERROR: Patient birthdate can't be empty.";
        } elseif (empty($_POST['sample_number'])) {
            $this->errors[] = "ERROR: Sample number can't be empty.";
        } elseif (strlen($_POST['sample_number']) != 6) {
            $this->errors[] = "ERROR: Sample number must be six characters long.";
        } elseif (empty($_POST['sample_date'])) {
            $this->errors[] = "ERROR: Sample date can't be empty.";
        } elseif (!empty($_POST['patient_name'])
            && !empty($_POST['patient_surname'])
            && !empty($_POST['patient_birthdate'])
            && !empty($_POST['sample_number'])
            && !empty($_POST['sample_date'])
            && strlen($_POST['sample_number']) == 6
            && preg_match('/[a-zA-Z0-9 ]/', $_POST['patient_name'])
            && preg_match('/[a-zA-Z0-9 ]/', $_POST['patient_surname'])
        ) {

            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
            
            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                // escaping, additionally removing everything that could be (html/javascript-) code

                /* Patient and sample data */
                $sample_number = $this->db_connection->real_escape_string(strip_tags($_POST['sample_number'], ENT_QUOTES));
                $patient_name = $this->db_connection->real_escape_string(strip_tags($_POST['patient_name'], ENT_QUOTES));
                $patient_surname = $this->db_connection->real_escape_string(strip_tags($_POST['patient_surname'], ENT_QUOTES));
                $patient_birthdate = $this->db_connection->real_escape_string(strip_tags($_POST['patient_birthdate'], ENT_QUOTES));
                $sample_date = $this->db_connection->real_escape_string(strip_tags($_POST['sample_date'], ENT_QUOTES));

                /* Sedimentation data */
                $esr_hour = $this->db_connection->real_escape_string(strip_tags($_POST['esr_hour'], ENT_QUOTES));
                $esr_2hour = $this->db_connection->real_escape_string(strip_tags($_POST['esr_2hour'], ENT_QUOTES));
                $leukocytes = $this->db_connection->real_escape_string(strip_tags($_POST['leukocytes'], ENT_QUOTES));
                $bleeding_time = $this->db_connection->real_escape_string(strip_tags($_POST['bleeding_time'], ENT_QUOTES));
                $coagulation_time = $this->db_connection->real_escape_string(strip_tags($_POST['coagulation_time'], ENT_QUOTES));

                /* Urin data */
                $urin_appearance = $this->db_connection->real_escape_string(strip_tags($_POST['urin_appearance'], ENT_QUOTES));
                $urin_color = $this->db_connection->real_escape_string(strip_tags($_POST['urin_color'], ENT_QUOTES));
                $other_urin_color = $this->db_connection->real_escape_string(strip_tags($_POST['other_urin_color'], ENT_QUOTES));
                $urin_ph = $this->db_connection->real_escape_string(strip_tags($_POST['urin_ph'], ENT_QUOTES));
                $urin_weight = $this->db_connection->real_escape_string(strip_tags($_POST['urin_weight'], ENT_QUOTES));
                $urin_proteins = $this->db_connection->real_escape_string(strip_tags($_POST['urin_proteins'], ENT_QUOTES));
                $urin_glucose = $this->db_connection->real_escape_string(strip_tags($_POST['urin_glucose'], ENT_QUOTES));
                $urin_ketones = $this->db_connection->real_escape_string(strip_tags($_POST['urin_ketones'], ENT_QUOTES));
                $urin_blood = $this->db_connection->real_escape_string(strip_tags($_POST['urin_blood'], ENT_QUOTES));
                $urin_nitrites = $this->db_connection->real_escape_string(strip_tags($_POST['urin_nitrites'], ENT_QUOTES));
                $urin_bilirubin = $this->db_connection->real_escape_string(strip_tags($_POST['urin_bilirubin'], ENT_QUOTES));
                $urin_urobilinogen = $this->db_connection->real_escape_string(strip_tags($_POST['urin_urobilinogen'], ENT_QUOTES));

                /* Urin sedimentation data */
                $urin_erc = $this->db_connection->real_escape_string(strip_tags($_POST['urin_erc'], ENT_QUOTES));
                $urin_lkc = $this->db_connection->real_escape_string(strip_tags($_POST['urin_lkc'], ENT_QUOTES));
                $urin_epi = $this->db_connection->real_escape_string(strip_tags($_POST['urin_epi'], ENT_QUOTES));
                $urin_mucus = $this->db_connection->real_escape_string(strip_tags($_POST['urin_mucus'], ENT_QUOTES));
                $urin_salts = $this->db_connection->real_escape_string(strip_tags($_POST['urin_salts'], ENT_QUOTES));
                $urin_crystals = $this->db_connection->real_escape_string(strip_tags($_POST['urin_crystals'], ENT_QUOTES));
                $urin_bacteria = $this->db_connection->real_escape_string(strip_tags($_POST['urin_bacteria'], ENT_QUOTES));

                /* Serum data */
                $serum_glu = $this->db_connection->real_escape_string(strip_tags($_POST['serum_glu'], ENT_QUOTES));
                $serum_chol = $this->db_connection->real_escape_string(strip_tags($_POST['serum_chol'], ENT_QUOTES));
                $serum_tgl = $this->db_connection->real_escape_string(strip_tags($_POST['serum_tgl'], ENT_QUOTES));
                $serum_ahdl = $this->db_connection->real_escape_string(strip_tags($_POST['serum_ahdl'], ENT_QUOTES));
                $serum_risk = $this->db_connection->real_escape_string(strip_tags($_POST['serum_risk'], ENT_QUOTES));

                /* Blood count data */
                $serum_wbc = $this->db_connection->real_escape_string(strip_tags($_POST['serum_wbc'], ENT_QUOTES));
                $serum_neu = $this->db_connection->real_escape_string(strip_tags($_POST['serum_neu'], ENT_QUOTES));
                $serum_lym = $this->db_connection->real_escape_string(strip_tags($_POST['serum_lym'], ENT_QUOTES));
                $serum_mono = $this->db_connection->real_escape_string(strip_tags($_POST['serum_mono'], ENT_QUOTES));
                $serum_eos = $this->db_connection->real_escape_string(strip_tags($_POST['serum_eos'], ENT_QUOTES));
                $serum_baso = $this->db_connection->real_escape_string(strip_tags($_POST['serum_baso'], ENT_QUOTES));
                $serum_rbc = $this->db_connection->real_escape_string(strip_tags($_POST['serum_rbc'], ENT_QUOTES));
                $serum_hgb = $this->db_connection->real_escape_string(strip_tags($_POST['serum_hgb'], ENT_QUOTES));
                $serum_hct = $this->db_connection->real_escape_string(strip_tags($_POST['serum_hct'], ENT_QUOTES));
                $serum_mcv = $this->db_connection->real_escape_string(strip_tags($_POST['serum_mcv'], ENT_QUOTES));
                $serum_mch = $this->db_connection->real_escape_string(strip_tags($_POST['serum_mch'], ENT_QUOTES));
                $serum_mchc = $this->db_connection->real_escape_string(strip_tags($_POST['serum_mchc'], ENT_QUOTES));
                $serum_rdw = $this->db_connection->real_escape_string(strip_tags($_POST['serum_rdw'], ENT_QUOTES));
                $serum_plt = $this->db_connection->real_escape_string(strip_tags($_POST['serum_plt'], ENT_QUOTES));
                $serum_mpv = $this->db_connection->real_escape_string(strip_tags($_POST['serum_mpv'], ENT_QUOTES));
                
                // check if sample_number already exists
                $sql = "SELECT * FROM samples WHERE sample_number = '" . $sample_number . "';";
                $query_check_sample_number = $this->db_connection->query($sql);
                
                
                if ($query_check_sample_number->num_rows == 1) {
                        $this->errors[] = "ERROR: Sample number alredy exist. Try again.";
                } else {
                    // write new sample data into database
                    $sql = "INSERT INTO samples (sample_number, patient_name, patient_surname, patient_birthdate, sample_date, esr_hour, esr_2hour, leukocytes, bleeding_time, coagulation_time,
                                                 urin_appearance, urin_color, other_urin_color, urin_ph, urin_weight, urin_proteins, urin_glucose, urin_ketones, urin_blood, urin_nitrites, 
                                                 urin_bilirubin, urin_urobilinogen, urin_erc, urin_lkc, urin_epi, urin_mucus, urin_salts, urin_crystals, urin_bacteria, serum_glu, serum_chol, 
                                                 serum_tgl, serum_ahdl, serum_risk, serum_wbc, serum_neu, serum_lym, serum_mono, serum_eos, serum_baso, serum_rbc, serum_hgb, serum_hct, serum_mcv,
                                                 serum_mch, serum_mchc, serum_rdw, serum_plt, serum_mpv)
                            VALUES('" . $sample_number . "', '" . $patient_name . "', '" . $patient_surname . "', '" . $patient_birthdate . "', '" . $sample_date . "', '" . $esr_hour . "',
                                   '" . $esr_2hour . "', '" . $leukocytes . "', '" . $bleeding_time . "', '" . $coagulation_time . "', '" . $urin_appearance . "', '" . $urin_color . "',
                                   '" . $other_urin_color . "', '" . $urin_ph . "', '" . $urin_weight . "', '" . $urin_proteins . "', '" . $urin_glucose . "', '" . $urin_ketones . "',
                                   '" . $urin_blood . "', '" . $urin_nitrites . "', '" . $urin_bilirubin . "', '" . $urin_urobilinogen . "', '" . $urin_erc . "', '" . $urin_lkc . "',
                                   '" . $urin_epi . "', '" . $urin_mucus . "', '" . $urin_salts . "', '" . $urin_crystals . "', '" . $urin_bacteria . "', '" . $serum_glu . "',
                                   '" . $serum_chol . "', '" . $serum_tgl . "', '" . $serum_ahdl . "', '" . $serum_risk . "', '" . $serum_wbc . "', '" . $serum_neu . "',
                                   '" . $serum_lym . "', '" . $serum_mono . "', '" . $serum_eos . "', '" . $serum_baso . "', '" . $serum_rbc . "', '" . $serum_hgb . "',
                                   '" . $serum_hct . "', '" . $serum_mcv . "', '" . $serum_mch . "', '" . $serum_mchc . "', '" . $serum_rdw . "', '" . $serum_plt . "',
                                   '" . $serum_mpv . "');";
                    $query_new_sample_insert = $this->db_connection->query($sql);
                      
                    // if sample has been added successfully
                    if ($query_new_sample_insert) {
                        $this->messages[] = "MSG: Sample saved.";
                    } else {
                        $this->errors[] = "ERROR: Sample was not saved. Please try again.";
                    }
                }
            } else {
                $this->errors[] = "ERROR: Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "ERROR: An unknown error occurred.";
        }
    }
}