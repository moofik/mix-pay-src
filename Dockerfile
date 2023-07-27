FROM nginx
COPY docker/build/nginx/brainpower.prod.conf /etc/nginx/conf.d/default.conf
COPY /backend /brainpower/backend
RUN sed -e 's/^worker_processes.*/worker_processes 5;/' -i /etc/nginx/nginx.conf

EXPOSE 80
