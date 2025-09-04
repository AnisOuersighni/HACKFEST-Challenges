I have read many articles about SQL Truncation Attack and this one was inspiring : https://linuxhint.com/sql-truncation-attack/


I started developping this challenge a while ago, to exploit it you have to :
	
	input admin, followed by 15 spaces and a random alphabet (in our case, +),  and pass the password you want.

this will result on a duplicated admin account. access the Shipment Direction panel with the credentials created ( admin and your password ) and you must be passed to the admin dashboard.
