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

/*
echo "<!-- ";
print_r ($e4);
print_r ($p4);
echo "-->";
*/
//echo "<!-- ". $p1 ." ". $p2 ." ". $p3 . " ". $p4 ." ". $p5 ."-->";
//echo "<Transform translation='";
//MapCubeToSphere($p5[0],  $p5[1], $p5[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 0 1'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p4[0],  $p4[1], $p4[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 1'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p3[0],  $p3[1], $p3[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p2[0],  $p2[1], $p2[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p1[0],  $p1[1], $p1[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";


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
/*
echo "\n<!-- start of MakeQuad() -->\n";
echo "<!-- top left: ". $quad[0][0] ." ". $quad[0][1] ." ". $quad[0][2] ." -->\n";
echo "<!-- bottom left: ". $quad[1][0] ." ". $quad[1][1] ." ". $quad[1][2] ." -->\n";
echo "<!-- bottom right: ". $quad[2][0] ." ". $quad[2][1] ." ". $quad[2][2] ." -->\n";
echo "<!-- top right: ". $quad[3][0] ." ". $quad[3][1] ." ". $quad[3][2] ." -->\n";
*/
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
/*
echo "<Transform translation='";
MapCubeToSphere($quad[0][0], $quad[0][1], $quad[0][2]);
echo "'><shape><Appearance><Material diffuseColor='". $color[0] ."  ". $color[1] ." ". $color[2] ."'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";
echo "<Transform translation='";
MapCubeToSphere($quad[1][0], $quad[1][1], $quad[1][2]);
echo "'><shape><Appearance><Material diffuseColor='". $color[0] ."  ". $color[1] ." ". $color[2] ."'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";
echo "<Transform translation='";
MapCubeToSphere($quad[2][0], $quad[2][1], $quad[2][2]);
echo "'><shape><Appearance><Material diffuseColor='". $color[0] ."  ". $color[1] ." ". $color[2] ."'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p2[0],  $p2[1], $p2[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
//echo "<Transform translation='";
//MapCubeToSphere($p1[0],  $p1[1], $p1[2]);
//echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
//echo "</shape></Transform>";
*/
echo "\n<!-- End of MakeQuade() -->\n";
}

function MakePlanet($type,$radius) {


/*
Planet types:
    City Planets (Ecumenopolis) — Urban sprawl has taken over the entire surface of a world. Theoretically possible, but only with extreme technology and/or a constant inflow of resources from off-world. May serve as home base to a culture of Planet Looters. Often has a population in the trillions. The concept supposedly first appeared in the writings of 19th century spiritualist Thomas Lake Harris. The first recognized usage in science fiction would be Trantor in Isaac Asimov's Foundation trilogy. The planet Coruscant in the Star Wars movies would probably be the most familiar to modern audiences. The logistics of such worlds — how they get food, dissipate excess heat and so forth — can be a subject of geeky speculation, as shown in multiple Irregular Webcomics. See also Planetville.
    Cloud Planets — The land is not where Newton wants it. If something or someone lives here, either the ground floats through the sky in chunks, or there are hover-cities. Either way, watch that first step. Sometimes Hand Waved by making them Jovian planets, although no known gas giants are anywhere near habitable. Venus again is a prime example, as some levels of its upper atmosphere would be pretty nice and potentially habitable — if not for those pesky sulfuric acid clouds around.
    Dark Planets — Like the Desert, but owe their lack of plant life to perpetual night; usually due to constant opaque cloud cover or spooky ominous fog. If inhabited, this might be the product of industrialization run amok, with the clouds being clouds of pollution. Home of the Big Bad, look for the Evil Tower of Ominousness with the perpetual lightning storm. It's like Planet Mordor. This is kind of like the real-life Venus, which even comes complete with the lightning storms. However, such planets in fiction are invariably described as "barely habitable", whereas the real version is of course completely uninhabitable. Dark Planets could also be Rogue Planets that do not orbit any star, although then there is the issue of what is keeping the atmosphere warm enough and replenishing the oxygen. Some of these planets could be tidally locked to their star with one side permanently facing it, rendering the facing side uninhabitable due to temperature and the dark side extremely cold, usually with a small habitable strip on the divide. These worlds also generate extreme weather, which can add to this atmosphere.
    Death Worlds — Not a biome in and of itself, but can be any of the aforementioned types. This is a world where Everything Is Trying to Kill You, but you still have compelling reasons to go there. After all, except Earth (and, possibly, Mars) all other Solar System planets are unquestionably those (though Venus takes the cake, as if it's some sort of planetary Australia), and there is thriving research activity around, with a regular expedition and terraforming proposals popping up.
    Desert Planets — These look like the cheaper parts of California, and are thus very common. May have aliens that act like Bedouin or Touareg, and a thriving black market on water. Multiple suns are common. Mars is sort of a desert planet, but with no breathable atmosphere, although recent discoveries pretty reliably show that it's an Ice Planet as well — it's just that all that ice is under the desert. Desert Planets are fairly realistic as these sorts of planets go, as long as there is some water. Any place that is sufficiently arid becomes a desert, but some ocean (say, 20% of the planet's surface), or underground water would be needed to support the plant life needed to create a breathable atmosphere.
    Farm Planets — If a Planet City is lucky, there will be another planet in the same system which is dedicated entirely for food production. Most of these are like a giant version of an American Midwest wheat farm. Complete with hicks. Technology level may range from highly advanced (in which case they are often largely automated with a population as low as hundreds or thousands) to feudal.
    Forest Planets — A planet whose land surface is mostly or entirely covered by forest. While Jungle Planets tend to be tropical in nature, a Forest Planet tends to have a more temperate climate with trees similar to oak, birch, redwoods and so on. Sometimes found in the form of a Forest Moon orbiting a large planet. Earth several million years ago could be considered a Forest Planet, since the warmer atmosphere and higher atmospheric humidity levels meant much more of the planet was covered in lush, tropical landscape.
    Garbage Planets — The entire planet is being used as a dumping ground for useless waste. Likely to act as home for scavengers looking to make a quick buck, treasure hunters seeking some long-lost treasure, and large numbers of mercenaries and criminals. The actual surface conditions can range from desert-like to incredibly hostile if the Phlebotinum is leaking out of ships.
    Ice Planets — Planets whose entire surfaces look like Greenland glaciers. Somewhat justified, as there actually are frozen-over planets and moons (for example, several moons of Jupiter and Saturn). Planets that normally have large oceans (like Earth) can look like this during a really deep Ice Age, and paleontologists believe that this may have happened to Earth in the past in a controversial scenario known as "Snowball Earth". The obvious question on an Ice planet is how it sustains life if there are so few plants to provide oxygen and a food chain; this paradox can be somewhat solved by allowing for a narrow equatorial band warm enough to support plant life, or by limiting life to the sea and having the food chain be based on geothermal energy/chemosynthesis (i.e. how we think life on Europa would work). It's interesting to note that the Saturn's Moon Titan, while being an "Ice Planet" of −179.2 °C, seems to be in every way just as dynamic and varied a planet as the Earthnote Just with liquid hydrocarbons instead of water and ice as solid as rock instead of water.
    Jungle Planets — Mind the bugs, they are positively enormous. Often home to the Cargo Cult and vulnerable to a God Guise. Expect most things that crop up in Hungry Jungle stories. Equivalent in video games is the Jungle Japes.
    Ocean Planets — These tend to have just a few, if any, mountains tall enough to breach the surface and make islands; if there are, they're prime beachfront vacation spots. Earth is arguably an ocean planet, just one with a lot of tectonic activity to create islands and continents (and even so, the average elevation of the Earth's surface is still well below sea level). This was even more true 500 million years ago, when the only life that existed was in the sea, and there was much less land above water than there is today. An extrasolar planet, GJ 1214b, has cropped up practically next door to us (a mere 42 light-years), which does appear to be an ocean planet, albeit a very hot one, and extremely uninhabitable.
    Swamp Planets — Like the Jungle, but easier to lose your shoe. (Or your ship. Just ask Luke Skywalker.)
    Twilight worlds, a.k.a. Tidally Locked Planets. While not truly single-biome, they traditionally have only about three: blazing hot desert on the day side, temperate zone of perpetual twilight at the day/night terminator, and sub-freezing wasteland on the night side.
    Vancouver Planets — Planets noted for a striking similarity to the pine-covered, mountainous oceanfront regions around the Canadian city of Vancouver (which, by an odd coincidence, is the filming location of many sci-fi television series).
    Volcano Planets — Defined by earthquakes, smoke, rivers of lava, and lots and lots of unchained mountains you don't want to climb. Featured in Revenge of the Sith; the Y-class planet in the Star Trek: Voyager episode "Demon" is also similar to this. Equivalent in video games is Lethal Lava Land. In the real-life solar system, this is a fair description of Jupiter's moon Io. Earth used to look a bit like this, too. Planetologists expect that any rocky planet will look like this in the first few hundred million years of its formation, so expect to see a lot of them. The air almost certainly won't be breathable, though, so bring your ventilator mask. 
*/
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

echo "\n<Group DEF='planet'>\n";
SubQuad($front,$radius,$div);
SubQuad($top,$radius,$div);
SubQuad($right,$radius,$div);
SubQuad($back,$radius,$div);
SubQuad($left,$radius,$div);
SubQuad($bottom,$radius,$div);
echo "</Group>\n";
}

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE X3D PUBLIC \"ISO//Web3D//DTD X3D 3.2//EN\" \"http://www.web3d.org/specifications/x3d-3.2.dtd\">\n";
echo "<X3D>";
echo "<head>
<component level='1' name='CADGeometry'></component>
<component level='1' name='Geospatial'></component>
</head>";
echo "<Scene>\n<Background> </Background> \n";


echo "<Transform translation='0 0 0'><shape><Appearance><Material diffuseColor='1 1 1' emissiveColor='1 1 1'></Material></Appearance><Sphere radius='100' ></Sphere>";
echo "</shape></Transform>";
echo "<PointLight ambientIntensity='1' attenuation='1,0,0' color='1,1,1' global='false' intensity='1' location='0,0,0'  on='true' radius='10000' shadowFilterSize='0' shadowIntensity='0' shadowMapSize='1024' shadowOffset='0' zFar='-1' zNear='-1' ></PointLight>";


echo "<Transform translation='0 0 0'><shape><Appearance><Material diffuseColor='1 1 1'  emissiveColor='1 1 1' transparency='0.5'></Material></Appearance><Sphere radius='150' ></Sphere>";
echo "</shape></Transform>";


echo "<Transform translation='1000 -1000 0'>";
echo "<LOD range='1500 2500 5000'>";
//echo "<GeoLOD DEF='front_level_00' child1Url='\"planet_test.php?lvl=1&child=1\"' child2Url='\"planet_test.php?lvl=1\"' child3Url='\"planet_test.php?lvl=1\"' child4Url='\"planet_test.php?lvl=1\"' containerField='children'>\n";
// front level 00 
MakePlanet("gas",100);
MakePlanet("ocean",100);
MakePlanet("earth",100);
//echo "</<GeoLOD>\n";
echo "</LOD>";
echo "</Transform>";

echo "<Transform translation='-1000 -1000 0'>";
echo "<LOD range='1500 2500 5000'>";
//echo "<GeoLOD DEF='front_level_00' child1Url='\"planet_test.php?lvl=1&child=1\"' child2Url='\"planet_test.php?lvl=1\"' child3Url='\"planet_test.php?lvl=1\"' child4Url='\"planet_test.php?lvl=1\"' containerField='children'>\n";
// front level 00 
MakePlanet(100,3);
MakePlanet(100,2);
MakePlanet(100,1);
//echo "</<GeoLOD>\n";
echo "</LOD>";
echo "</Transform>";

echo "<Transform translation='1000 1000 0'>";
echo "<LOD range='1500 2500 5000'>";
//echo "<GeoLOD DEF='front_level_00' child1Url='\"planet_test.php?lvl=1&child=1\"' child2Url='\"planet_test.php?lvl=1\"' child3Url='\"planet_test.php?lvl=1\"' child4Url='\"planet_test.php?lvl=1\"' containerField='children'>\n";
// front level 00 
MakePlanet(100,3);
MakePlanet(100,2);
MakePlanet(100,1);
//echo "</<GeoLOD>\n";
echo "</LOD>";
echo "</Transform>";
/*
echo "<Transform translation='";
MapCubeToSphere($bottom[0][0],  $bottom[0][1], $bottom[0][2]);
echo "'><shape><Appearance><Material diffuseColor='1 0 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";

echo "<Transform translation='";
MapCubeToSphere($bottom[1][0],  $bottom[1][1], $bottom[1][2]);
echo "'><shape><Appearance><Material diffuseColor='1 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";

echo "<Transform translation='";
MapCubeToSphere($bottom[2][0],  $bottom[2][1], $bottom[2][2]);
echo "'><shape><Appearance><Material diffuseColor='0 1 0'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";

echo "<Transform translation='";
MapCubeToSphere($bottom[3][0],  $bottom[3][1], $bottom[3][2]);
echo "'><shape><Appearance><Material diffuseColor='0 1 1'></Material></Appearance><Sphere radius='0.05' ></Sphere>";
echo "</shape></Transform>";
*/
echo "\n</Scene>";
echo "</X3D>\n";
?>
