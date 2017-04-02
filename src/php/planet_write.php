<?php

function MapCubeToSphere( $x, $y, $z,$radius )
{
//echo "\n<!-- x = $x y = $y z = $z -->\n";
    $x2 = (float) $x * (float) $x;
    $y2 = (float) $y * (float) $y;
    $z2 = (float) $z * (float) $z;
//echo "<!-- x2 = $x2 y2 = $y2 z2 = $z2 -->\n";
//echo "<!-- ".$x2*0.5." ".$y2*0.5." ".$z2*0.5." -->\n";

    $x = (float) $x * (float) sqrt( 1.0 - ( $y2 * 0.5 ) - ( $z2 * 0.5 ) + ( ($y2 * $z2) / 3.0 ) );
    $y = (float) $y * (float) sqrt( 1.0 - ( $z2 * 0.5 ) - ( $x2 * 0.5 ) + ( ($z2 * $x2) / 3.0 ) );
    $z = (float) $z * (float) sqrt( 1.0 - ( $x2 * 0.5 ) - ( $y2 * 0.5 ) + ( ($x2 * $y2) / 3.0 ) );
echo ($x*$radius);echo " "; echo ($y*$radius); echo " "; echo ($z*$radius); echo " \n";
}

function SubQuad ($quad,$radius,$div)
{
echo "\n<!--start of SubQuad(".$div.") -->\n";
//echo "\n<!--start of root node -->\n";
//MakeQuad($quad);
//echo "\n<!--end of root node -->\n";
// 0= top left
// 1= bottom left
// 2= bottom right
// 3= top right

// e1 = bottom right to left
$e1 = array  ( $quad[2][0] - $quad[1][0],
               $quad[2][1] - $quad[1][1],
               $quad[2][2] - $quad[1][2]);

// e2 = top right to left
$e2 = array  ( $quad[3][0] - $quad[0][0],
               $quad[3][1] - $quad[0][1],
               $quad[3][2] - $quad[0][2]);

// e3 = top to bottom left
$e3 = array  ( $quad[0][0] - $quad[1][0],
               $quad[0][1] - $quad[1][1],
               $quad[0][2] - $quad[1][2]);

// e4 = top to bottom right
$e4 = array  ( $quad[3][0] - $quad[2][0],
               $quad[3][1] - $quad[2][1],
               $quad[3][2] - $quad[2][2]);

// p1 = bottom center 
$p1 = array ($e1[0]*0.5+$quad[1][0],
             $e1[1]*0.5+$quad[1][1],
             $e1[2]*0.5+$quad[1][2]);

// p2 = top center
$p2 = array ($e2[0]*0.5+$quad[0][0],
             $e2[1]*0.5+$quad[0][1],
             $e1[2]*0.5+$quad[0][2]);


// p3 = left center
$p3 = array ($e3[0]*0.5+$quad[1][0],
             $e3[1]*0.5+$quad[1][1],
             $e3[2]*0.5+$quad[1][2]);


// p4 = right center
$p4 = array ($e4[0]*0.5+$quad[2][0],
             $e4[1]*0.5+$quad[2][1],
             $e4[2]*0.5+$quad[2][2]);


$e5 = array ($p2[0] - $p1[0], // Position3 e5 = p2 - p1;
             $p2[1] - $p1[1],
             $p2[2] - $p1[2]);
// center
$p5 = array ($e5[0] * 0.5 + $p1[0], // Position3 p5 = e5 * 0.5f + p1;
             $e5[1] * 0.5 + $p1[1],
             $e5[2] * 0.5 + $p1[2]);


if ($div == 1 )
{
echo "\n<!--top left -->\n";
MakeQuad(array ($quad[0], $p3, $p5,$p2),$radius);

echo "\n<!--top right -->\n";
MakeQuad(array ($p2, $p5,$p4,$quad[3]),$radius);


echo "\n<!--bottom left -->\n";
MakeQuad(array ($p3,$quad[1],$p1,$p5,$p3),$radius);

echo "\n<!--bottom right -->\n";
MakeQuad(array ($p1,$quad[2],$p4,$p5),$radius);

} else { 

echo "\n<!--top left -->\n";
SubQuad(array ($quad[0], $p3, $p5,$p2),$radius,($div-1));

echo "\n<!--top right -->\n";
SubQuad(array ($p2, $p5,$p4,$quad[3]),$radius,($div-1));


echo "\n<!--bottom left -->\n";
SubQuad(array ($p3,$quad[1],$p1,$p5,$p3),$radius,($div-1));

echo "\n<!--bottom right -->\n";
SubQuad(array ($p1,$quad[2],$p4,$p5),$radius,($div-1));

}

echo "\n<!-- end of SubQuad(".$div.") -->\n";

}

function MakeQuad($quad,$radius) 
{

$color = array (rand(0,1000)/1000, rand(0,1000)/1000 , rand(0,1000)/1000 );
echo "<Shape>";
echo "<Appearance><Material diffuseColor='". $color[0] ."  ". $color[1] ." ". $color[2] ."'></Material></Appearance>\n";
echo "<QuadSet>";
echo "<Coordinate point='\n";
MapCubeToSphere($quad[0][0],  $quad[0][1], $quad[0][2],$radius);
MapCubeToSphere($quad[1][0],  $quad[1][1], $quad[1][2],$radius);
MapCubeToSphere($quad[2][0],  $quad[2][1], $quad[2][2],$radius);
MapCubeToSphere($quad[3][0],  $quad[3][1], $quad[3][2],$radius);
echo "'></Coordinate>";
echo "</QuadSet>";
echo "</Shape>";

echo "\n<!-- End of MakeQuade() -->\n";
}

function MakePlanet($radius) {
$div = 3
$front = array   (
array(-1,  1, 1), // top left
array(-1, -1, 1), // bottom left
array( 1, -1, 1), // bottom right
array( 1,  1, 1) // top right
);

$top = array (
array (-1,1,-1),
array (-1,  1, 1),
array ( 1,  1, 1),
array ( 1,  1, -1),
);

$bottom = array (
array(-1,  -1, 1),
array(-1,  -1, -1),
array(1,  -1, -1),
array(1,  -1, 1)
);

$right = array (
array(1,  1, 1),
array( 1, -1, 1),
array( 1, -1, -1),
array(1,  1, -1),
);

$left = array (
array(-1,  1, -1),
array(-1,  -1, -1),
array(-1,  -1, 1),
array(-1,  1, 1)
);


$back = array (
array(1,  1, -1),
array( 1, -1, -1),
array( -1, -1, -1),
array(-1,  1, -1)
);

$file = fopen("newfile.x3d", "w") or die("Unable to open file!");

fwrite($file,"<?xml version='1.0' encoding='UTF-8'?>\n");
echo "<!DOCTYPE X3D PUBLIC \"ISO//Web3D//DTD X3D 3.2//EN\" \"http://www.web3d.org/specifications/x3d-3.2.dtd\">\n";
echo "<X3D>";
echo "<head>
<component level='1' name='CADGeometry'></component>
<component level='1' name='Geospatial'></component>
</head>";
echo "\n<Group DEF='planet'>\n";
SubQuad($front,$radius,$div);
SubQuad($top,$radius,$div);
SubQuad($right,$radius,$div);
SubQuad($back,$radius,$div);
SubQuad($left,$radius,$div);
SubQuad($bottom,$radius,$div);
echo "</Group>\n";
echo "\n</Scene>";
echo "</X3D>\n";
fclose($myfile);

}

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE X3D PUBLIC \"ISO//Web3D//DTD X3D 3.2//EN\" \"http://www.web3d.org/specifications/x3d-3.2.dtd\">\n";
echo "<X3D>";
echo "<head>
<component level='1' name='CADGeometry'></component>
<component level='1' name='Geospatial'></component>
</head>";
echo "<Scene>\n<Background> </Background> \n";
echo "<Transform translation='1000 -1000 0'>";
echo "<LOD range='1500 2500 5000'>";
//echo "<GeoLOD DEF='front_level_00' child1Url='\"planet_test.php?lvl=1&child=1\"' child2Url='\"planet_test.php?lvl=1\"' child3Url='\"planet_test.php?lvl=1\"' child4Url='\"planet_test.php?lvl=1\"' containerField='children'>\n";
// front level 00 
MakePlanet(100);
MakePlanet(100);
MakePlanet(100);
//echo "</<GeoLOD>\n";
echo "</LOD>";
echo "</Transform>";

echo "\n</Scene>";
echo "</X3D>\n";
?>
