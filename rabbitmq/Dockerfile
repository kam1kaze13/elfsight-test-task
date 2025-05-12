FROM rabbitmq:4.0.2-management-alpine

ADD rabbitmq.conf /etc/rabbitmq/rabbitmq.conf
ADD definitions.json /etc/rabbitmq/definitions.json

ARG RABBITMQ_PASSWORD=adminpass
RUN sed -i "s/rabbitpass/$RABBITMQ_PASSWORD/g" /etc/rabbitmq/definitions.json
