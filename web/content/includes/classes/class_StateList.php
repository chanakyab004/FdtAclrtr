<?php
	
	class States {
		
		
		protected $states = array(
        "Alabama" => "AL",
        "Alaska" => "AK",
        "Arizona" => "AZ",
        "Arkansas" => "AR",
        "California" => "CA",
        "Colorado" => "CO",
        "Connecticut" => "CT",
        "Delaware" => "DE",
		 "District of Columbia" => "DC",
        "Florida" => "FL",
        "Georgia" => "GA",
        "Hawaii" => "HI",
        "Idaho" => "ID",
        "Illinois" => "IL",
        "Indiana" => "IN",
        "Iowa" => "IA",
        "Kansas" => "KS",
        "Kentucky" => "KY",
        "Louisiana" => "LA",
        "Maine" => "ME",
        "Maryland" => "MD",
        "Massachusetts" => "MA",
        "Michigan" => "MI",
        "Minnesota" => "MN",
        "Mississippi" => "MS",
        "Missouri" => "MO",
        "Montana" => "MT",
        "Nebraska" => "NE",
        "Nevada" => "NV",
        "New Hampshire" => "NH",
        "New Jersey" => "NJ",
        "New Mexico" => "NM",
        "New York" => "NY",
        "North Carolina" => "NC",
        "North Dakota" => "ND",
        "Ohio" => "OH",
        "Oklahoma" => "OK",
        "Oregon" => "OR",
        "Pennsylvania" => "PA",
        "Rhode Island" => "RI",
        "South Carolina" => "SC",
        "South Dakota" => "SD",
        "Tennessee" => "TN",
        "Texas" => "TX",
        "Utah" => "UT",
        "Vermont" => "VT",
        "Virginia" => "VA",
        "Washington" => "WA",
        "West Virginia" => "WV",
        "Wisconsin" => "WI",
        "Wyoming" => "WY"
    );
	
    	public $output = "";
		
		
    	public function __construct($style = false, $form = null){
            if($style === true){
                ksort($this->states);
            }

            //$this->output = "<select name='state'>";
            $this->output .= "<option value=''>--</option>";

            foreach($this->states as $name => $abbr){
                $this->output .= "<option value='" . $abbr . "'";
                if($form === $abbr){
                    $this->output .= "selected='selected'";
                }

                if($style === true){
                    $this->output .= ">" . $abbr . "</option>";
                } else {
                    $this->output .= ">" . $name . "</option>";
                }
            }
            //$this->output .= "</select>";
        }
		
		
		
		
	}
	
	
?>