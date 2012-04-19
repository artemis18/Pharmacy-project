<?php
 /**
     * Create SVG image from xml created by Prescription Designer
     * @param type $filename 
     */
    function convert_to_svg($filename){
        $parser = simplexml_load_file("{$_ENV['root']}pform/xml/" . $filename . ".xml");

        //Count the number of boxes in prescription
        $num_boxes = count($parser->xpath("PrescriptionObjects"));

        //Create an SVG file
        $handle = fopen("{$_ENV['root']}/pform/svg/" . $filename . ".svg", "w");

        //Create the header information for the SVG file
        $svg_header = <<<EOF
<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg">
EOF;
        //Write the header information to file
        fwrite($handle, $svg_header);

        //Assign the prescription background colour
        $bg_red = $parser->xpath("/prescription/bgColour/Red");
        $bg_green = $parser->xpath("/prescription/bgColour/Green");
        $bg_blue = $parser->xpath("/prescription/bgColour/Blue");
        
        //Prescription dimensions
        $pres_width = $parser->xpath("/prescription/Dimensions/width");
        $pres_height = $parser->xpath("/prescription/Dimensions/height");

        //Create the prescription rect object in SVG
        $pres_bg = "\n\n<rect width=\"{$pres_width[0][0]}\" height=\"{$pres_height[0][0]}\" ".
        "style=\"fill:rgb({$bg_red[0][0]}, {$bg_green[0][0]}, {$bg_blue[0][0]}); ".
        "stroke-width:1;stroke:rgb(0,0,0)\" />\n";
        
        //Write the prescription rect Object to file
        fwrite($handle, $pres_bg);
        
        //Iterate through the Boxes
        for($count = 1; $count <= $num_boxes; $count++){
            
            //Get the information for each box
            $x = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/x");
            $y = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/position/y");
            $width = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/dimensions/width");
            $height = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/dimensions/height");
            $line_width = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineWidth");
            $line_r = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Red");
            $line_g = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Green");
            $line_b = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/lineColour/Blue");
            $transparent = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/transparent");
            $fill_r = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Red");
            $fill_g = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Green");
            $fill_b = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/fillColour/Blue");
            $text = $parser->xpath("/prescription/PrescriptionObjects[{$count}]/name");
            

            //Create the prescription rect object
            $box =   "<rect  width=\"{$width[0][0]}\" "
                    ."height=\"{$height[0][0]}\" "
                    ."x=\"{$x[0][0]}\" "
                    ."y=\"{$y[0][0]}\" "
                    ."style=\"fill:rgb({$fill_r[0][0]}, {$fill_g[0][0]}, {$fill_b[0][0]}); stroke-width:{$line_width[0][0]}; ";
                    
            //If the line width is 0, set opacity to 0
            if($line_width[0][0] == "0"){
                $box = $box . "stroke-opacity: 0; ";
            } else{
                $box = $box . "stroke-opacity: 1; ";
            }
            
            //If transparency is true set opacity to 0
            if($transparent[0][0] == "true"){
                $box = $box . "fill-opacity: 0; ";
            }
            
            //Set the stroke colour
            $box = $box . "stroke:rgb({$line_r[0][0]},{$line_g[0][0]},{$line_b[0][0]})\" />\n";
            
            //Offset for text position
            $text_x = $x[0][0] + 3;
            $text_y = $y[0][0] + 13;
            
            //If text is not empty, draw it
            if($text[0][0] != ""){
                
                //Replace all "&" with "&amp;"
                $text = preg_replace('/&/', '&amp;', $text[0][0]);
                $text_dis = "<text  x=\"{$text_x}\" y=\"{$text_y}\">{$text}</text>\n";
                            
                //add text to SVG file
                fwrite($handle, $text_dis);
            }
            
            //Add box rect object to SVG
            fwrite($handle, $box);
        }
        
        //Write finishing tag
        fwrite($handle, "</svg>");
    }
    
    function getHeight($filename){
        $parser = simplexml_load_file("{$_ENV['root']}pform/xml/" . $filename . ".xml");        
        $height = $parser->xpath("/prescription/Dimensions/height");
        return $height[0][0];
    }
    
    function getWidth($filename){
        $parser = simplexml_load_file("{$_ENV['root']}/pform/xml/" . $filename . ".xml");  
        $width = $parser->xpath("/prescription/Dimensions/width");
        return $width[0][0];
    }
?>
