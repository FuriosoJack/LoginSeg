#!/bin/bash
ifup wlan0
ifdown wlan0
ifup wlan0
/etc/init.d/isc-dhcp-server start&
/etc/init.d/hostapd stop
hostapd /etc/hostapd/hostapd.conf&
