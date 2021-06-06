<?php
    $file = file("lecture.txt");
    $json = array();
    $array = array();
    $unebalise = false;
    $Code = false;   
    $string = "";
    $test = "{";
    $analyse = false;
    foreach ($file as $line_num => $line) 
    {
        
        $MyLineCaract =  explode(" ", $line);
        foreach($MyLineCaract as $Mycarac)
        {
            if(!$analyse)
            {
                if($Mycarac == "#")
                {
                    $analyse = true;
                }
                else
                {
                    echo "Markdown faux";
                    exit();
                }
            }
            if(!$Code)
            {
                switch ($Mycarac) {
                   case '#':
                       $key = "h1";
                       $unebalise = true;
                       break;
                   case '##':
                       $key = "h2";
                       $unebalise = true;
                       break;
                    case "\r\n":
                       $array[$key] = $string;
                       $test .= '"'.$key.'":'.$string.',';
                       $string = "";
                       $array = array();
                       $unebalise = false;
                       break;
                     case "```sh\r\n":
                       $key = "code";
                       $unebalise = true;
                       $Code = true;
                       break; 
                    case "###":
                       $key = "h3";
                       $unebalise = true;
                       break;
                    case "*":
                       $key = "ul";
                       $unebalise = true;
                       break;   
                   default:
                        if(!$unebalise)
                        {
                            $key = "p";
                            $unebalise = true;
                        }
                        $string .= $Mycarac. " ";
                        break;
               }   
            }
            else
            {
                if($Mycarac == "```\r\n")
                {
                    $Code = false;
                }
                $string .= $Mycarac. " ";
            }
        }
    }
    $json = json_encode(rtrim($test,',')."}");
    print_r($json);
?>
