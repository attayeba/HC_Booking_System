<?php
    class FormElement{
        public $Name;
        public $Type;
        public $Values;

        function __construct($_Name, $_Type, $_Values){
            $this->Name = $_Name;
            $this->Type = $_Type;
            $this->Values = $_Values;
        } 
    }

    // Auto generates forms
    class FormGenerator{
        public static function generate_form($Title, $Action, $Success, $Elements){
            $DisplayTitle = $Title;
            $ID_Title = str_replace(" ","_", $Title);
            // col-md-offset-3
            echo "
                <script>
                    $(function(){
                        $('#$ID_Title').on('click', function(){
                            $.ajax({
                                type: 'POST',
                                url: '$Action',
                                data: $('#$ID_Title-Form').serialize(),
                                success: function(response) {
                                    $('#$ID_Title-output').html(response);
                                    if (typeof callback !== 'undefined' && typeof callback === 'function') {
                                        callback();
                                    }
                                }
                            });
                        });
                    });
                </script>
                <div class='page-header text-center'>
                    <h2>$DisplayTitle</h2>
                </div>
                <div class='row'>
                    <div class='col-md-12'> 
                        <div class='jumbotron'>
                            <form class='form-horizontal' method='POST' id='$ID_Title-Form' action='$Action'>";
                                foreach ($Elements as $Element) {
                                    FormGenerator::display_element($Element);
                                }
                echo "
                                <input type='hidden' name='submitted' value='true' />
                                <div class='form-group'>
                                    <label class='control-label' for='$ID_Title'></label>
                                    <input type='button' class='btn btn-success btn-block' role='button' id='$ID_Title' value='$DisplayTitle'>
                                    <br />
                                    <div id='$ID_Title-output' class='well'></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            ";
        }
        
        
        private static function display_element($Element){
            //remove underscores for displayed text
            $DisplayName = str_replace("_"," ", $Element->Name);
            $Name = $Element->Name;
            $Type = $Element->Type;
            echo "<div class='form-group'>";
            $label = $Element->Type != "hidden" ? "<label class='control-label' for='$Name'>$DisplayName:</label>" : "";
            echo $label;
            switch($Element->Type){
                case "text":
                case "password":
                case "date":
                case "hidden":
                    $Value = isset($Element->Values[0]) ? $Element->Values[0] : "";
                    echo "<input type='$Type' class='form-control' id='$Name' placeholder='$DisplayName' name='$Name' value='$Value'>";
                    break;
                case "select":

                    echo "<select class='form-control' id='$Name' name='$Name'>";
                    foreach ($Element->Values as $Value) {
                        if(is_array($Value)){
                            $ID = $Value[0];
                            $Text = $Value[1];
                            $Selected = isset($Value[2]) ? "selected='selected'" : "";
                            echo "<option value='$ID' $Selected>$Text ($ID)</option>";
                        }
                        else{
                            $Selected = substr($Value, 0 , 1) == "*" ? "selected='selected'" : "";
                            $Value = str_replace("*", "", $Value);
                            echo "<option value='$Value' $Selected>$Value</option>";
                        }
                    }
                    echo "</select>";
                    break;
                case "radio":
                    foreach ($Element->Values as $Value) {
                        $Checked = substr($Value, 0 , 1) == "*" ? "checked='checked'" : "";
                        $Value = str_replace("*", "", $Value);
                        echo "<div class='radio'>";
                        echo "  <label><input type='$Type' name='$Name' value='$Value' $Checked>$Value</label>";
                        echo "</div>";
                    }
                    break;
            }
            echo "</div>";
        }

        public static function generate_element($Name, $Type, $Values){
            return new FormElement($Name, $Type, $Values);
        }
    }
?>