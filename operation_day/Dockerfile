FROM python:alpine3.19

WORKDIR /var/www/command_center

RUN pip install flask

COPY ./templates ./templates
COPY ./static ./static
COPY app.py .
RUN chmod 665 ./app.py



COPY flag.txt .
RUN chmod 664 ./flag.txt

RUN adduser -D ctf 

RUN chown -R root:ctf $(pwd) && \
    chmod -R 650 $(pwd) && \
    chown -R root:ctf /home/ctf/ && \
    chmod -R 650 /home/ctf

RUN mkdir ./restricted

USER ctf

EXPOSE 80

CMD ["python", "app.py"] 

#
#sudo docker build -t command-center . 
#sudo docker run -it --name command-center-instance -p 80:80 62aa12e12ad4  
#sudo docker stop command-center-instance

