#!/usr/bin/env bash


VESTAS=$(curl https://www.euroinvestor.dk/markeder/aktier/europa/danmark/omx-c25 | grep -A 5 "vestas-wind-systems-a-s" | grep -Eo "[0-9]+\,[0-9]+")
VESTAS_KURS=$(echo $VESTAS | awk '{print $1}')
VESTAS_PLUS_MINUS=$(echo $VESTAS | awk '{print $2}')
VESTAS_BUD=$(echo $VESTAS | awk '{print $3}')
VESTAS_UDBUD=$(echo $VESTAS | awk '{print $1}')

echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
<rss version=\"2.0\">

<channel>
<title>Thors App</title>
<link>http://ec2-52-57-92-95.eu-central-1.compute.amazonaws.com/wishlist.php</link>
<description>Me playing around with rss</description>
<item>
<title>VESTAS AKTIEKURSER - Kurs = $VESTAS_KURS</title>
<link>http://ec2-52-57-92-95.eu-central-1.compute.amazonaws.com/VESTAS</link>
<description>
Vestas Kurs: $VESTAS_KURS
Vestas +/-: $VESTAS_PLUS_MINUS
Vestas Bud: $VESTAS_BUD
Vestas Udbud: $VESTAS_UDBUD
</description>
</item>
</channel>
</rss>
" > /var/www/html/vote/rss.xml

echo "
Vestas Kurs: $VESTAS_KURS
Vestas +/-: $VESTAS_PLUS_MINUS
Vestas Bud: $VESTAS_BUD
Vestas Udbud: $VESTAS_UDBUD
" > /var/www/html/vote/VESTAS


