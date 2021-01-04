FROM node:14

RUN mkdir /code

WORKDIR /code
ADD package.json /code/package.json
RUN npm install

EXPOSE 3000

CMD npm start