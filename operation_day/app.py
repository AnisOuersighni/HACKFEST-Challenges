from flask import Flask, jsonify, request, render_template
import os


app = Flask(__name__)

@app.route('/', methods=['GET'])
def index():
    return render_template('index.html')

# Operation Day, only our Agent can lunch the explosion command 
# Communicate with  ctOC . Central Operation Center
@app.route('/execute', methods=['POST'])
def run_command():

    # Get command
    data = request.get_json()
    if 'command' in data:
        command = str(data['command'])

        # Length check
        if len(command) < 5:
            return jsonify({'message': 'Command too short'}), 501

        # Perform security checks
        if '..' in command or '/' in command:
            return jsonify({'message': 'Hacking attempt detected, Be more creative!'}), 501
        # NEW: Space filter - no spaces allowed!
        if ' ' in command:
            return jsonify({'message': 'No spaces allowed in commands!'}), 501
        
        # NEW: Block dangerous characters
        dangerous_chars = [ '|', '&', '`', '(', ')', '<', '>', '\n', '\r', '\t']
        for char in dangerous_chars:
            if char in command:
                return jsonify({'message': f'Character "{char}" not allowed!'}), 501
        
        # Find path to executable - the first tool should be executable 
        executable_to_run = command.split()[0]

        # Check if we can execute the binary
        if os.access(executable_to_run, os.X_OK):

            # Execute binary if it exists and is executable
            out = os.popen(command).read()
            return jsonify({'message': 'Operation Status: ' + str(out)}), 200

    return jsonify({'message': 'Not implemented'}), 501


if __name__ == '__main__':
    
    # Make sure we can only execute binaries in the executables directory
    os.chdir('./restricted/')

    # Run server
    app.run(host='0.0.0.0', port=80)
