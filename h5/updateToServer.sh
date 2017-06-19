#!/usr/bin/expect -f
set temp [lindex $argv 0]

#set password [lindex $argv 1]
set ip www.pcw365.com
set password "18^1#WJc5z3#zV0X"
set timeout -1

spawn ssh root@$ip

expect "password:"
send "$password\r"
expect "Welcome"
send "cd /home/server/apache2/htdocs/ecshop/ecshop2/MobileAPI\r"
send "git pull\r"

send "exit\r"
interact
#send "exit\r"
