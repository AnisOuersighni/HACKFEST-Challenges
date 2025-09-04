from flask import Flask, render_template, request
from dotenv import load_dotenv
import mysql.connector
import os

load_dotenv()

def get_operation(form):
    operations = list()
    mydb = mysql.connector.connect(
        host=os.getenv('mysql_host'),
        user=os.getenv('mysql_user'),
        password=os.getenv('mysql_pwd'),
        database=os.getenv('mysql_db')
    )
    mycursor = mydb.cursor()
    try:
        opcode = str(form['opcode'])
        if 'UPDATE' in opcode.upper() or 'DELETE' in opcode.upper():
            # Requête interdite
            return "Requête non autorisée", 403
        else:
            # Exécution de la requête
            mycursor.execute("SELECT * FROM operations WHERE code = '" + opcode + "'")
            #mycursor.execute("SELECT * FROM operations WHERE code = '" + str(form['opcode']) + "'")
    except:
        pass
    myresult = mycursor.fetchall()
    for x in myresult:
        operations.append({
            'code': x[1],
            'name': x[2]
        })
    mycursor.close()
    return operations

app = Flask(__name__)

@app.route('/', methods=['POST', 'GET'])
def index(source=None):
    if request.method == "POST":
        operations = get_operation(request.form)
        if operations == []:
            return render_template('list.html', error="No Operation Found! another tentative and you will be reported to the admin")
        else:
            return render_template('list.html', operations=operations)
    else:
        if request.args.get('source') == '1':
            with open(__file__, 'r') as r:
                return r.read().strip()
        else: 
            return render_template('base.html')

if __name__ == "__main__":
    app.run(host="0.0.0.0", port=7331)
