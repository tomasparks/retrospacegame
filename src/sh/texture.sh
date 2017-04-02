convert -verbose -seed 200 \
          -size 1024x1024 plasma:fractal -blur 0x15 -colorspace Gray \
  /opt/lampp/htdocs/retrospacegame/data/textures/generic/planets/8Bit/assets/minecraft/textures/blocks/{water_still,sand,grass_top,snow}.png \
  -virtual-pixel tile  -fx 'u[floor(4.9999*u)+1]' \
  map-8Bit.png

convert -verbose -seed 200 \
          -size 1024x1024 plasma:fractal -blur 0x15 -colorspace Gray \
  /opt/lampp/htdocs/retrospacegame/data/textures/generic/planets/RetroNES/assets/minecraft/textures/blocks/{water_still,sand,grass_top,snow}.png \
  -virtual-pixel tile  -fx 'u[floor(4.9999*u)+1]' \
  map-NES.png


convert -verbose -seed 200 \
          -size 1024x1024 plasma:fractal -blur 0x15 -colorspace Gray \
  /opt/lampp/htdocs/retrospacegame/data/textures/generic/planets/16Bitv1/assets/minecraft/textures/blocks/{water_still,sand,grass_top,snow}.png \
  -virtual-pixel tile  -fx 'u[floor(4.9999*u)+1]' \
  map-16Bitv1.png

convert -verbose -seed 200 \
          -size 1024x1024 plasma:fractal -blur 0x15 -colorspace Gray \
  /opt/lampp/htdocs/retrospacegame/data/textures/generic/planets/16Bitv2/assets/minecraft/textures/blocks/{water_still,sand,grass_top,snow}.png \
  -virtual-pixel tile  -fx 'u[floor(4.9999*u)+1]' \
  map-16Bitv2.png

