FROM nginx:1

COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN date > /builddate

WORKDIR /app