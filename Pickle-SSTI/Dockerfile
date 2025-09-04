FROM python:3


COPY ./app /app

COPY requirements.txt /app/requirements.txt

WORKDIR /app

RUN pip install -r /app/requirements.txt



EXPOSE 9229

RUN groupadd Hackfest_ctf
RUN useradd -g Hackfest_ctf ctf
RUN chmod 775 /app
USER ctf:Hackfest_ctf

CMD ["python3", "-u", "app.py"]
