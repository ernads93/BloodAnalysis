<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the sample class
require_once("classes/Sample.php");

// create the sample object. when this object is created, it will do all sample-save stuff automatically
// so this single line handles the entire sample save process.
$registration = new Sample();
?>

<?php
            function generateRandomString($length) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
?>

<div class="sample-box">
  <h2>Add new sample</h2>
  <!-- MESSAGE AND ERROR STATS HERE -->
  <div>
        <p class="error-message">
            <?php
            // show potential errors / feedback (from register object)
                if (isset($registration)) {
                    if ($registration->errors) {
                        foreach ($registration->errors as $error) {
                            echo $error;
                        }
                    }
                    if ($registration->messages) {
                        foreach ($registration->messages as $message) {
                            echo $message;
                        }
                    }
                }
            ?>
    </p>
    </div>
  
  <form method="post" action="dashboard.php?link=sample" name="sampleform">
        
        <!-- PATIENT INFO STARTS HERE -->
        <div style="grid-row:1; grid-column:1/-1">
            <h3>PATIENT INFO</h3>
        </div>
        <div style="grid-row:2; grid-column:1;">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Name" name="patient_name" value="" />
        </div>

        <div style="grid-row:2; grid-column:2;">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Surname" name="patient_surname" value="" />
        </div>
        <div style="grid-row:2; grid-column:3;">
            <i class="fas fa-calendar-day"></i>
            <input type="date" name="patient_birthdate" value="" />
        </div>

        <!-- SAMPLE INFO STARTS HERE -->
        <div style="grid-row:3; grid-column:1/-1">
            <h3>SAMPLE INFO</h3>
        </div>
        <div style="grid-row:4; grid-column:1/3">
            <i class="fas fa-info"></i>
            <input type="text" placeholder="Sample Nmr." name="sample_number" value="<?php echo generateRandomString(6); ?>" />
        </div>
        <div style="grid-row:4;">
            <i class="fas fa-calendar-day"></i>
        <input type="date" placeholder="SmapleDate" name="sample_date" value="" />
        </div>
        <div style="grid-row:5; grid-column: 1/-1;">
            <h3>SAMPLE DATA</h3>
        </div>

        <!-- SEDIMENTATION STARTS HERE -->
        <div style="grid-row:6; grid-column: 1/-1;">
            <label>SEDIMENTATION</label>
        </div>
        <div style="grid-row:7; grid-column: 1;">
            <label>ESR</label>
        </div>
        <div style="grid-row:7; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="esr_hour" value="" />
        </div>
        <div style="grid-row:7; grid-column: 3;">
            <label>4.0 - 12.0 mm/h</label>
        </div>
        <div style="grid-row:8; grid-column: 1;">
            <label></label>
        </div>
        <div style="grid-row:8; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="esr_2hour" value="" />
        </div>
        <div style="grid-row:8; grid-column: 3;">
            <label>12.0 - 24.0 mm/2h</label>
        </div>
        <div style="grid-row:9; grid-column: 1;">
            <label>Leukocytes</label>
        </div>
        <div style="grid-row:9; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="leukocytes" value="" />
        </div>
        <div style="grid-row:9; grid-column: 3;">
            <label>5.0 - 10.0 x 10⁹/L</label>
        </div>
        <div style="grid-row:10; grid-column: 1;">
            <label>Bleeding time</label>
        </div>
        <div style="grid-row:10; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="bleeding_time" value="" />
        </div>
        <div style="grid-row:10; grid-column: 3;">
            <label>60 - 240 s</label>
        </div>
        <div style="grid-row:11; grid-column: 1;">
            <label>Coagulation time</label>
        </div>
        <div style="grid-row:11; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="coagulation_time" value="" />
        </div>
        <div style="grid-row:11; grid-column: 3;">
            <label>300 - 900 s</label>
        </div>
        
        
        
        <!-- URIN STARTS HERE -->
        <div style="grid-row:12; grid-column: 1/-1;">
            <label>URIN</label>
        </div>
        <div style="grid-row:13; grid-column: 1;">
        <label>Appearance</label>
        </div>
        <div style="grid-row:13; grid-column: 2;">
            <select id="cars" name="urin_appearance">
                <option value="clear">Clear</option>
                <option value="cloudy">Cloudy</option>
            </select>   
        </div>
        <div style="grid-row:14; grid-column: 1;">
            <label>Color</label>
        </div>
        <div style="grid-row:14; grid-column: 2;">
        <select id="cars" name="urin_color">
                <option value="yellow">Yellow</option>
                <option value="other">Other</option>
            </select> 
        </div>
        <div style="grid-row:14; grid-column: 3;">
            <input type="text" placeholder="Enter urin color... (if other)" name="other_urin_color" value="" />
        </div>
        <div style="grid-row:15; grid-column: 1;">
            <label>pH</label>
        </div>
        <div style="grid-row:15; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_ph" value="" />
        </div>
        <div style="grid-row:15; grid-column: 3;">
            <label>4.8 - 7.5</label>
        </div>
        <div style="grid-row:16; grid-column: 1;">
            <label>Specific weight</label>
        </div>
        <div style="grid-row:16; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_weight" value="" />
        </div>
        <div style="grid-row:16; grid-column: 3;">
            <label>1.003 - 1.040</label>
        </div>
        <div style="grid-row:17; grid-column: 1;">
            <label>Proteins</label>
        </div>
        <div style="grid-row:17; grid-column: 2;">
        <select name="urin_proteins">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:18; grid-column: 1;">
            <label>Glucose</label>
        </div>
        <div style="grid-row:18; grid-column: 2;">
        <select name="urin_glucose">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:19; grid-column: 1;">
            <label>Ketones</label>
        </div>
        <div style="grid-row:19; grid-column: 2;">
        <select name="urin_ketones">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:20; grid-column: 1;">
            <label>Blood</label>
        </div>
        <div style="grid-row:20; grid-column: 2;">
        <select name="urin_blood">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:21; grid-column: 1;">
            <label>Nitrites</label>
        </div>
        <div style="grid-row:21; grid-column: 2;">
        <select name="urin_nitrites">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:22; grid-column: 1;">
            <label>Bilirubin</label>
        </div>
        <div style="grid-row:22; grid-column: 2;">
        <select name="urin_bilirubin">
                <option value="neg.">Neg.</option>
                <option value="pos.">Pos.</option>
            </select> 
        </div>
        <div style="grid-row:23; grid-column: 1;">
            <label>Urobilinogen</label>
        </div>
        <div style="grid-row:23; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_urobilinogen" value="" />
        </div>
        <div style="grid-row:23; grid-column: 3;">
            <label>max. 17.0</label>
        </div>
        
        
        
        <!-- URIN SEDIMENTATION STARTS HERE -->
        <div style="grid-row:24; grid-column: 1/-1;">
            <label>URIN SEDIMENTATION</label>
        </div>
        <div style="grid-row:25; grid-column: 1;">
            <label>ERC</label>
        </div>
        <div style="grid-row:25; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_erc" value="" />
        </div>
        <div style="grid-row:26; grid-column: 1;">
            <label>LKC</label>
        </div>
        <div style="grid-row:26; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_lkc" value="" />
        </div>
        <div style="grid-row:27; grid-column: 1;">
            <label>Epithelium</label>
        </div>
        <div style="grid-row:27; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_epi" value="" />
        </div>
        <div style="grid-row:28; grid-column: 1;">
            <label>Mucus</label>
        </div>
        <div style="grid-row:28; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_mucus" value="" />
        </div>
        <div style="grid-row:29; grid-column: 1;">
            <label>Salts</label>
        </div>
        <div style="grid-row:29; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_salts" value="" />
        </div>
        <div style="grid-row:30; grid-column: 1;">
            <label>Crystals</label>
        </div>
        <div style="grid-row:30; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_crystals" value="" />
        </div>
        <div style="grid-row:31; grid-column: 1;">
            <label>Bacteria</label>
        </div>
        <div style="grid-row:31; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="urin_bacteria" value="" />
        </div>



        <!-- SERUM STARTS HERE -->
        <div style="grid-row:32; grid-column: 1/-1;">
            <label>SERUM</label>
        </div>
        <div style="grid-row:33; grid-column: 1;">
            <label>GLU</label>
        </div>
        <div style="grid-row:33; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_glu" value="" />
        </div>
        <div style="grid-row:33; grid-column: 3;">
            <label>3.9 - 6.1 mmol/L</label>
        </div>
        <div style="grid-row:34; grid-column: 1;">
            <label>CHOL</label>
        </div>
        <div style="grid-row:34; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_chol" value="" />
        </div>
        <div style="grid-row:34; grid-column: 3;">
            <label>0.0 - 5.7 mmol/L</label>
        </div>
        <div style="grid-row:35; grid-column: 1;">
            <label>TGL</label>
        </div>
        <div style="grid-row:35; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_tgl" value="" />
        </div>
        <div style="grid-row:35; grid-column: 3;">
            <label>0.0 - 2.3 mmol/L</label>
        </div>
        <div style="grid-row:36; grid-column: 1;">
            <label>ahdl</label>
        </div>
        <div style="grid-row:36; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_ahdl" value="" />
        </div>
        <div style="grid-row:36; grid-column: 3;">
            <label>0.9 - 1.55 mmol/L</label>
        </div>
        <div style="grid-row:37; grid-column: 1;">
            <label>RISK</label>
        </div>
        <div style="grid-row:37; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_risk" value="" />
        </div>
        <div style="grid-row:37; grid-column: 3;">
            <label>3.0 - 6.2</label>
        </div>
        
        <!-- BLOOD COUNT STARTS HERE -->
        <div style="grid-row:38; grid-column: 1/-1;">
            <label>BLOOD COUNT</label>
        </div>
        <div style="grid-row:39; grid-column: 1;">
            <label>WBC</label>
        </div>
        <div style="grid-row:39; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_wbc" value="" />
        </div>
        <div style="grid-row:39; grid-column: 3;">
            <label>4.0 - 9.7 x 10⁹/L</label>
        </div>
        <div style="grid-row:40; grid-column: 1;">
            <label>NEU</label>
        </div>
        <div style="grid-row:40; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_neu" value="" />
        </div>
        <div style="grid-row:40; grid-column: 3;">
            <label>44.0 - 80.0 %N</label>
        </div>
        <div style="grid-row:41; grid-column: 1;">
            <label>LYM</label>
        </div>
        <div style="grid-row:41; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_lym" value="" />
        </div>
        <div style="grid-row:41; grid-column: 3;">
            <label>20.0 - 46.0 %L</label>
        </div>
        <div style="grid-row:42; grid-column: 1;">
            <label>MONO</label>
        </div>
        <div style="grid-row:42; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_mono" value="" />
        </div>
        <div style="grid-row:42; grid-column: 3;">
            <label>2.0 - 12.0 %M</label>
        </div>
        <div style="grid-row:43; grid-column: 1;">
            <label>EOS</label>
        </div>
        <div style="grid-row:43; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_eos" value="" />
        </div>
        <div style="grid-row:43; grid-column: 3;">
            <label>0.0 - 7.0 %E</label>
        </div>
        <div style="grid-row:44; grid-column: 1;">
            <label>BASO</label>
        </div>
        <div style="grid-row:44; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_baso" value="" />
        </div>
        <div style="grid-row:44; grid-column: 3;">
            <label>0.0 - 2.0 %B</label>
        </div>
        <div style="grid-row:45; grid-column: 1;">
            <label>RBC</label>
        </div>
        <div style="grid-row:45; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_rbc" value="" />
        </div>
        <div style="grid-row:45; grid-column: 3;">
            <label>3.86 - 5.08 x 10¹²/L</label>
        </div>
        <div style="grid-row:46; grid-column: 1;">
            <label>HGB</label>
        </div>
        <div style="grid-row:46; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_hgb" value="" />
        </div>
        <div style="grid-row:46; grid-column: 3;">
            <label>119. - 157. g/L</label>
        </div>
        <div style="grid-row:47; grid-column: 1;">
            <label>HCT</label>
        </div>
        <div style="grid-row:47; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_hct" value="" />
        </div>
        <div style="grid-row:47; grid-column: 3;">
            <label>.360 - .470 L/L</label>
        </div>
        <div style="grid-row:48; grid-column: 1;">
            <label>MCV</label>
        </div>
        <div style="grid-row:48; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_mcv" value="" />
        </div>
        <div style="grid-row:48; grid-column: 3;">
            <label>83.0 - 92.0 fL</label>
        </div>
        <div style="grid-row:49; grid-column: 1;">
            <label>MCH</label>
        </div>
        <div style="grid-row:49; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_mch" value="" />
        </div>
        <div style="grid-row:49; grid-column: 3;">
            <label>27.0 - 34.0 pg</label>
        </div>
        <div style="grid-row:50; grid-column: 1;">
            <label>MCHC</label>
        </div>
        <div style="grid-row:50; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_mchc" value="" />
        </div>
        <div style="grid-row:50; grid-column: 3;">
            <label>320. - 345. g/L</label>
        </div>
        <div style="grid-row:51; grid-column: 1;">
            <label>RDW</label>
        </div>
        <div style="grid-row:51; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_rdw" value="" />
        </div>
        <div style="grid-row:51; grid-column: 3;">
            <label>14.6 - 16.5 %CV</label>
        </div>
        <div style="grid-row:52; grid-column: 1;">
            <label>PLT</label>
        </div>
        <div style="grid-row:52; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_plt" value="" />
        </div>
        <div style="grid-row:52; grid-column: 3;">
            <label>158. - 424. x 10⁹/L</label>
        </div>
        <div style="grid-row:53; grid-column: 1;">
            <label>MPV</label>
        </div>
        <div style="grid-row:53; grid-column: 2;">
            <input type="text" placeholder="Enter value..." name="serum_mpv" value="" />
        </div>
        <div style="grid-row:53; grid-column: 3;">
            <label>6.8 - 10.4 fL</label>
        </div>

    
    <div style="grid-row:54; grid-column: 3;">
        <input class="btn" type="submit" name="save_sample" value="Save" />
    </div>
  </form>
</div>

